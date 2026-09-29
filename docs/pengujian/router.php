<?php
// Router uji lokal: tiru mod_rewrite .htaccess CI (file nyata dilayani langsung, sisanya ke index.php)
$root = $_SERVER['DOCUMENT_ROOT'];
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// tiru proteksi .htaccess: folder application/ & system/ tidak boleh diakses langsung
if (preg_match('#^/(application|system)(/|$)#', $path)) { http_response_code(403); echo "403 Forbidden"; return true; }
if ($path !== '/' && is_file($root . $path)) return false;
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/index.php';
chdir($root);
require $root . '/index.php';
