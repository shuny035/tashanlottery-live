<?php
date_default_timezone_set('Asia/Kolkata');

$db_server = getenv('DB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$db_user   = getenv('DB_USER') ?: '33DAiUvZbJwLN6P.root';
$db_pass   = getenv('DB_PASSWORD') !== false && getenv('DB_PASSWORD') !== '' ? getenv('DB_PASSWORD') : '4YmiwUyUTs3a3Obe';
$db_name   = getenv('DB_NAME') ?: 'tashan_db';
$db_port   = (int)(getenv('DB_PORT') ?: 4000);

if (!defined('DB_SERVER')) define('DB_SERVER', $db_server);
if (!defined('DB_USERNAME')) define('DB_USERNAME', $db_user);
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', $db_pass);
if (!defined('DB_NAME')) define('DB_NAME', $db_name);
if (!defined('DB_PORT')) define('DB_PORT', $db_port);

$conn = mysqli_init();
if ($db_server !== '127.0.0.1' && $db_server !== 'localhost') {
    mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
    mysqli_real_connect($conn, $db_server, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL);
} else {
    mysqli_real_connect($conn, $db_server, $db_user, $db_pass, $db_name, $db_port);
}

if (!$conn || mysqli_connect_errno()) {
    die('Database connection error: ' . mysqli_connect_error());
}
