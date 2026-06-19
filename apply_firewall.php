<?php

$projectPath = __DIR__;
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

if (! $dbSetting) {
    echo "DB_DATABASE is missing in .env\n";
    exit(1);
}

$dbPath = $dbSetting;

if (! str_starts_with($dbPath, '/')) {
    $dbPath = $projectPath . '/' . $dbPath;
}

if (! file_exists($dbPath)) {
    echo "Database file not found: {$dbPath}\n";
    exit(1);
}

echo "Using database: {$dbPath}\n";

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$hasDevices = $pdo->query("
    SELECT name
    FROM sqlite_master
    WHERE type = 'table'
    AND name = 'devices'
")->fetchColumn();

if (! $hasDevices) {
    echo "The devices table does not exist in this database.\n";
    exit(1);
}

$devices = $pdo->query("
    SELECT mac_address, ip_address, status
    FROM devices
    WHERE ip_address IS NOT NULL
")->fetchAll(PDO::FETCH_ASSOC);

shell_exec('sudo iptables -N PERMITNET_DEVICES 2>/dev/null');
shell_exec('sudo iptables -F PERMITNET_DEVICES');
shell_exec('sudo iptables -D FORWARD -i wlan0 -o eth0 -j PERMITNET_DEVICES 2>/dev/null');
shell_exec('sudo iptables -I FORWARD -i wlan0 -o eth0 -j PERMITNET_DEVICES');

foreach ($devices as $device) {
    $ip = trim($device['ip_address']);
    $status = $device['status'];

    if (! filter_var($ip, FILTER_VALIDATE_IP)) {
        continue;
    }

    if ($status === 'approved') {
        shell_exec("sudo iptables -A PERMITNET_DEVICES -s {$ip} -j ACCEPT");
        echo "Allowed {$ip}\n";
    } else {
        shell_exec("sudo iptables -A PERMITNET_DEVICES -s {$ip} -j DROP");
        echo "Blocked {$ip}\n";
    }
}

shell_exec('sudo iptables -A PERMITNET_DEVICES -j DROP');

echo "Firewall updated.\n";
