<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'library_system';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS);

// On first run, create database if not exists
if ($mysqli->connect_error) {
    die('DB connect error: ' . $mysqli->connect_error);
}
$mysqli->query("CREATE DATABASE IF NOT EXISTS `{$DB_NAME}`");
$mysqli->select_db($DB_NAME);

// helper function
function esc($s){ return htmlspecialchars(trim($s)); }
?>
