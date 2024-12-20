<?php
session_start();

if (session_status() !== PHP_SESSION_ACTIVE) {
    die('La sesión no está activa');
}

require_once __DIR__ . '/autoload.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

const IMGS_PATH = __DIR__ . '/../images';
?>