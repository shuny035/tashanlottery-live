<?php 
// Credit: https://t.me/little_pie34

function run($path) {
    // Credit: https://t.me/little_pie34
    $php = "/usr/local/bin/php"; // Adjust if needed
    exec("$php $path > /dev/null 2>&1 &");
}

// Credit: https://t.me/little_pie34
// Get current minute
$minute = (int) date('i');

// Always run every-minute scripts
// Credit: https://t.me/little_pie34
run("/public_html/niyamitakelasa_zehn.php");
sleep(30);
run("/public_html/niyamitakelasa_zehn.php");
run("/public_html/niyamitakelasa.php");
run("/public_html/niyamitakelasa_aidudi.php");
run("/public_html/niyamitakelasa_kemuru.php");
run("/public_html/ktrx.php");

// Every 3 minutes
if ($minute % 3 === 0) {
    // Credit: https://t.me/little_pie34
    run("/home/esldoomd/public_html/niyamitakelasa_drei.php");
    run("/home/esldoomd/public_html/niyamitakelasa_aidudi_drei.php");
    run("/home/esldoomd/public_html/niyamitakelasa_kemuru_drei.php");
    run("/home/esldoomd/public_html/ktrx3.php");
}

// Every 5 minutes
if ($minute % 5 === 0) {
    // Credit: https://t.me/little_pie34
    run("/home/esldoomd/public_html/niyamitakelasa_funf.php");
    run("/home/venusclu/public_html/niyamitakelasa_aidudi_funf.php");
    run("/home/venusclu/public_html/niyamitakelasa_kemuru_funf.php");
    run("/home/venusclu/public_html/ktrx5.php");
}

// Every 10 minutes
if ($minute % 10 === 0) {
    // Credit: https://t.me/little_pie34
    run("/home/venusclu/public_html/niyamitakelasa_aidudi_zehn.php");
    run("/home/venusclu/public_html/niyamitakelasa_kemuru_zehn.php");
    run("/home/venusclu/public_html/ktrx10.php");
}
?>
