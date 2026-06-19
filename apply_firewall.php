<?php

$dbPath = __DIR__ . '/database/database.sqlite';

if (! file_exists($dbPath)) {
    echo "Database not found: {$dbPath}\n";
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$devices = $pdo->query("
    SELECT mac_address, ip_address, status
    FROM devices
    WHERE ip_address IS NOT NULL
")->fetchAll(PDO::FETCH_ASSOC);

$commands = [
    'iptables -N PERMITNET_DEVICES 2>/dev/null',
    'iptables -F PERMITNET_DEVICES',
    'iptables -D FORWARD -i wlan0 -o eth0 -j PERMITNET_DEVICES 2>/dev/null',
    'iptables -I FORWARD -i wlan0 -o eth0 -j PERMITNET_DEVICES',
];

foreach ($commands as $command) {
    shell_exec("sudo {$command}");
}

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
