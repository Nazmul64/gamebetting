<?php

$publicPath = getcwd();

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// If the requested URI is a physical file in public/, let the built-in server serve it directly.
if ($uri !== '/' && is_file($publicPath . $uri)) {
    return false;
}

$formattedDateTime = date('D M j H:i:s Y');
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$remoteAddress = ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') . ':' . ($_SERVER['REMOTE_PORT'] ?? '8000');

@file_put_contents('php://stdout', "[$formattedDateTime] $remoteAddress [$requestMethod] URI: $uri\n");

require_once $publicPath . '/index.php';
