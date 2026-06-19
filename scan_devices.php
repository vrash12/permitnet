<?php

$projectPath = __DIR__;
$interface = 'eth0';

// Read DB_DATABASE from .env
$envPath = $projectPath . '/.env';
$dbSetting = null;

if (file_exists($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        if (str_starts_with($line, 'DB_DATABASE=')) {
            $dbSetting = trim(substr($line, strlen('DB_DATABASE=')));
            $dbSetting = trim($dbSetting, "\"'");
            break;
        }
    }
}

if (!$dbSetting) {
    $dbSetting = 'database/database.sqlite';
}

$dbPath = $dbSetting;

if (!str_starts_with($dbPath, '/')) {
    $dbPath = $projectPath . '/' . $dbPath;
}

if (!file_exists($dbPath)) {
    echo "SQLite database not found: {$dbPath}\n";
    exit(1);
}

echo "Using database: {$dbPath}\n";
echo "Scanning interface: {$interface}\n\n";

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$command = "arp-scan --interface=" . escapeshellarg($interface) . " --localnet 2>&1";
$output = shell_exec($command);

if (!$output || str_contains($output, 'Operation not permitted') || str_contains($output, 'You need to be root')) {
    echo "arp-scan needs permission. Run this instead:\n";
    echo "sudo php scan_devices.php\n";
    exit(1);
}

$lines = explode("\n", $output);
$saved = 0;

foreach ($lines as $line) {
    $line = trim($line);

    if (!preg_match('/^(\d+\.\d+\.\d+\.\d+)\s+([0-9a-fA-F:]{17})\s*(.*)$/', $line, $matches)) {
        continue;
    }

    $ip = $matches[1];
    $mac = strtolower($matches[2]);
    $vendor = trim($matches[3]);

    $hostname = gethostbyaddr($ip);

    if ($hostname === $ip || empty($hostname)) {
        $hostname = $vendor ?: 'Unknown Device';
    }

    $now = date('Y-m-d H:i:s');

    $existing = $pdo->prepare("SELECT id FROM devices WHERE mac_address = ?");
    $existing->execute([$mac]);
    $deviceId = $existing->fetchColumn();

    if (!$deviceId) {
        $insert = $pdo->prepare("
            INSERT INTO devices (
                mac_address,
                ip_address,
                hostname,
                owner_name,
                status,
                role,
                last_seen_at,
                created_at,
                updated_at
            ) VALUES (?, ?, ?, NULL, 'pending', 'guest', ?, ?, ?)
        ");

        $insert->execute([
            $mac,
            $ip,
            $hostname,
            $now,
            $now,
            $now
        ]);

        $deviceId = $pdo->lastInsertId();

        $request = $pdo->prepare("
            INSERT INTO device_access_requests (
                device_id,
                status,
                message,
                created_at,
                updated_at
            ) VALUES (?, 'pending', 'New device detected by network scan.', ?, ?)
        ");

        $request->execute([
            $deviceId,
            $now,
            $now
        ]);
    } else {
        $update = $pdo->prepare("
            UPDATE devices
            SET ip_address = ?,
                hostname = ?,
                last_seen_at = ?,
                updated_at = ?
            WHERE id = ?
        ");

        $update->execute([
            $ip,
            $hostname,
            $now,
            $now,
            $deviceId
        ]);
    }

    $log = $pdo->prepare("
        INSERT INTO connection_logs (
            device_id,
            mac_address,
            ip_address,
            hostname,
            event_type,
            action,
            status,
            message,
            created_at,
            updated_at
        ) VALUES (?, ?, ?, ?, 'scan_detected', 'detected', 'success', 'Detected by arp-scan.', ?, ?)
    ");

    $log->execute([
        $deviceId,
        $mac,
        $ip,
        $hostname,
        $now,
        $now
    ]);

    echo "Saved: {$ip} | {$mac} | {$hostname}\n";
    $saved++;
}
