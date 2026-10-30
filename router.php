<?php
date_default_timezone_set('Asia/Kolkata');
if (function_exists('mysqli_report')) {
    @mysqli_report(MYSQLI_REPORT_OFF);
}

// Ensure Authorization header is available for php -S built-in web server
if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
        if (!empty($headers['Authorization'])) {
            $_SERVER['HTTP_AUTHORIZATION'] = $headers['Authorization'];
        } elseif (!empty($headers['authorization'])) {
            $_SERVER['HTTP_AUTHORIZATION'] = $headers['authorization'];
        }
    }
}

$root = __DIR__;
$rawUri = $_SERVER['REQUEST_URI'] ?? '/';
$uri = parse_url($rawUri, PHP_URL_PATH);
$uri = urldecode($uri);
$uri = preg_replace('#/+#', '/', $uri);

if ($uri === '/' || $uri === '') {
    header('Content-Type: text/html; charset=UTF-8');
    readfile($root . '/index.html');
    exit;
}

$filePath = realpath($root . $uri);
if ($filePath && strpos($filePath, $root) === 0 && is_file($filePath)) {
    if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
        chdir(dirname($filePath));
        require $filePath;
        exit;
    }
    return false;
}

if ($uri === '/admin' || $uri === '/admin/') {
    chdir($root . '/admin');
    require $root . '/admin/index.php';
    exit;
}

if (strpos($uri, '/admin/') === 0) {
    $rel = substr($uri, strlen('/admin/'));
    if (!str_ends_with($rel, '.php') && file_exists($root . '/admin/' . $rel . '.php')) {
        chdir($root . '/admin');
        require $root . '/admin/' . $rel . '.php';
        exit;
    }
}

if (file_exists($root . $uri . '.php')) {
    $target = $root . $uri . '.php';
    chdir(dirname($target));
    require $target;
    exit;
}

$ext = pathinfo($uri, PATHINFO_EXTENSION);
if (empty($ext) || !in_array(strtolower($ext), ['js', 'css', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'webp', 'mp3', 'mp4', 'json'])) {
    if (file_exists($root . '/index.html')) {
        header('Content-Type: text/html; charset=UTF-8');
        readfile($root . '/index.html');
        exit;
    }
}

http_response_code(404);
echo "404 Not Found";
