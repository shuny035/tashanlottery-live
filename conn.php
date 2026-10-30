<?php
date_default_timezone_set('Asia/Kolkata');

$db_server = getenv('DB_HOST') ?: 'sql302.infinityfree.com';
$db_user   = getenv('DB_USER') ?: 'if0_43313154';
$db_pass   = getenv('DB_PASSWORD') !== false && getenv('DB_PASSWORD') !== '' ? getenv('DB_PASSWORD') : 'J09oX3jfddQDeQ';
$db_name   = getenv('DB_NAME') ?: 'if0_43313154_tashan';
$db_port   = (int)(getenv('DB_PORT') ?: 3306);

if (!defined('DB_SERVER')) define('DB_SERVER', $db_server);
if (!defined('DB_USERNAME')) define('DB_USERNAME', $db_user);
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', $db_pass);
if (!defined('DB_NAME')) define('DB_NAME', $db_name);
if (!defined('DB_PORT')) define('DB_PORT', $db_port);

$conn = @mysqli_connect($db_server, $db_user, $db_pass, $db_name, $db_port);

if (!$conn || mysqli_connect_errno()) {
    die('Database connection error: ' . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8mb4');
?>
