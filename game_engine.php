<?php
/**
 * Tashan Lottery - Realtime Local Game Engine Daemon
 * Runs continuous game cycles for WinGo (30s, 1m, 3m, 5m), K3, and 5D.
 * Settles bets, inserts results, updates wallets, and advances periods.
 */

date_default_timezone_set('Asia/Kolkata');
chdir(__DIR__);

require_once 'conn.php';

echo "=================================================\n";
echo "  Tashan Lottery Game Engine Daemon Started\n";
echo "  Time: " . date('Y-m-d H:i:s') . " (Asia/Kolkata)\n";
echo "=================================================\n";

function ensureDbConnection(&$conn) {
    if (!$conn || !@mysqli_ping($conn)) {
        @mysqli_close($conn);
        $db_server = getenv('DB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
        $db_user   = getenv('DB_USER') ?: '33DAiUvZbJwLN6P.root';
        $db_pass   = getenv('DB_PASSWORD') !== false && getenv('DB_PASSWORD') !== '' ? getenv('DB_PASSWORD') : '4YmiwUyUTs3a3Obe';
        $db_name   = getenv('DB_NAME') ?: 'tashan_db';
        $db_port   = (int)(getenv('DB_PORT') ?: 4000);

        $conn = mysqli_init();
        if ($db_server !== '127.0.0.1' && $db_server !== 'localhost') {
            mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
            mysqli_real_connect($conn, $db_server, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL);
        } else {
            mysqli_real_connect($conn, $db_server, $db_user, $db_pass, $db_name, $db_port);
        }
        if (!$conn || mysqli_connect_errno()) {
            echo "[" . date('H:i:s') . "] DB Reconnect Failed: " . mysqli_connect_error() . "\n";
            return false;
        }
        echo "[" . date('H:i:s') . "] DB Reconnected successfully.\n";
    }
    return true;
}

function advancePeriod($conn, $table, $interval, $prefix) {
    $now = time();
    $currentDate = date('Ymd');
    $secOfDay = $now % 86400;
    $seq = intval($secOfDay / $interval) + 1;
    $newPeriodId = $currentDate . $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    $periodStartSec = $now - ($now % $interval);
    $startTime = date('Y-m-d H:i:s', $periodStartSec);

    // Check if new period already inserted
    $check = $conn->query("SELECT atadaaidi FROM `$table` ORDER BY kramasankhye DESC LIMIT 1");
    $row = $check ? mysqli_fetch_array($check) : null;
    if (!$row || $row['atadaaidi'] != $newPeriodId) {
        $conn->query("INSERT INTO `$table` (`atadaaidi`, `dinankavannuracisi`) VALUES ('$newPeriodId', '$startTime')");
    }
    return $newPeriodId;
}

// 1. Initial sync of all active periods on startup
$games = [
    ['table' => 'gelluonduhogu_zehn', 'interval' => 30,  'prefix' => '10005', 'name' => 'WinGo 30s'],
    ['table' => 'gelluonduhogu',      'interval' => 60,  'prefix' => '10001', 'name' => 'WinGo 1m'],
    ['table' => 'gelluonduhogu_drei', 'interval' => 180, 'prefix' => '10002', 'name' => 'WinGo 3m'],
    ['table' => 'gelluonduhogu_funf', 'interval' => 300, 'prefix' => '10003', 'name' => 'WinGo 5m'],
    ['table' => 'gelluonduhogu_kemuru', 'interval' => 60, 'prefix' => '10101', 'name' => 'K3 1m'],
    ['table' => 'gelluonduhogu_aidudi', 'interval' => 60, 'prefix' => '10201', 'name' => '5D 1m'],
    ['table' => 'gelluonduhogu_trx',    'interval' => 60, 'prefix' => '10301', 'name' => 'TRX 1m'],
];

foreach ($games as $g) {
    $pid = advancePeriod($conn, $g['table'], $g['interval'], $g['prefix']);
    echo "  Synced {$g['name']}: Period {$pid}\n";
}
echo "-------------------------------------------------\n";
echo "Game Engine is now actively ticking...\n";

$lastTriggered = [];

while (true) {
    if (!ensureDbConnection($conn)) {
        sleep(2);
        continue;
    }

    $now = time();
    $currentSec = intval(date('s', $now));
    $currentMin = intval(date('i', $now));

    // 1. WinGo 30s: triggers at 00s and 30s
    if (($currentSec == 0 || $currentSec == 30) && (!isset($lastTriggered['wingo30']) || $lastTriggered['wingo30'] != $now)) {
        $lastTriggered['wingo30'] = $now;
        try {
            @include 'nayakaphalitansa_mulaka_unohs_zehn.php';
        } catch (Throwable $t) {
            echo "[" . date('H:i:s') . "] WinGo 30s settlement err: " . $t->getMessage() . "\n";
        }
        $newPid = advancePeriod($conn, 'gelluonduhogu_zehn', 30, '10005');
        echo "[" . date('H:i:s') . "] WinGo 30s settled -> New Period: $newPid\n";
    }

    // 2. 1-Minute games: triggers at 00s
    if ($currentSec == 0 && (!isset($lastTriggered['1min']) || $lastTriggered['1min'] != $now)) {
        $lastTriggered['1min'] = $now;

        // WinGo 1m
        try {
            @include 'nayakaphalitansa_mulaka_unohs.php';
        } catch (Throwable $t) {}
        $newPid = advancePeriod($conn, 'gelluonduhogu', 60, '10001');
        echo "[" . date('H:i:s') . "] WinGo 1m settled -> New Period: $newPid\n";

        // K3 1m
        try {
            @include 'nayakaphalitansa_mulaka_unohs_kemuru.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_kemuru', 60, '10101');

        // 5D 1m
        try {
            @include 'nayakaphalitansa_mulaka_unohs_aidudi.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_aidudi', 60, '10201');
    }

    // 3. 3-Minute games: triggers at 00s when minute % 3 == 0
    if ($currentSec == 0 && ($currentMin % 3 == 0) && (!isset($lastTriggered['3min']) || $lastTriggered['3min'] != $now)) {
        $lastTriggered['3min'] = $now;
        try {
            @include 'nayakaphalitansa_mulaka_unohs_drei.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_drei', 180, '10002');

        try {
            @include 'nayakaphalitansa_mulaka_unohs_kemuru_drei.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_kemuru_drei', 180, '10102');

        try {
            @include 'nayakaphalitansa_mulaka_unohs_aidudi_drei.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_aidudi_drei', 180, '10202');

        echo "[" . date('H:i:s') . "] 3-Min games settled & advanced.\n";
    }

    // 4. 5-Minute games: triggers at 00s when minute % 5 == 0
    if ($currentSec == 0 && ($currentMin % 5 == 0) && (!isset($lastTriggered['5min']) || $lastTriggered['5min'] != $now)) {
        $lastTriggered['5min'] = $now;
        try {
            @include 'nayakaphalitansa_mulaka_unohs_funf.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_funf', 300, '10003');

        try {
            @include 'nayakaphalitansa_mulaka_unohs_kemuru_funf.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_kemuru_funf', 300, '10103');

        try {
            @include 'nayakaphalitansa_mulaka_unohs_aidudi_funf.php';
        } catch (Throwable $t) {}
        advancePeriod($conn, 'gelluonduhogu_aidudi_funf', 300, '10203');

        echo "[" . date('H:i:s') . "] 5-Min games settled & advanced.\n";
    }

    usleep(500000); // Check twice every second for responsive execution
}
