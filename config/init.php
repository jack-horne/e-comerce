<?php
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// Pastikan file-file ini ada di dalam folder config
require_once __DIR__ . '/base.php';
require_once __DIR__ . '/connection.php';

// Jalankan session di satu pintu
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}