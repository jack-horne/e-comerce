<?php
// Flag agar file config aman
define('APP_INIT', true);

// Session global
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load config
require_once __DIR__ . '/base.php';
require_once __DIR__ . '/connection.php';
