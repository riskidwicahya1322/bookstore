<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=bookstore;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$_SESSION['t'] ??= bin2hex(random_bytes(16));
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['t'], $_POST['t'] ?? '')) die('Token tidak valid');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES); }
function csrf() { return '<input type="hidden" name="t" value="' . $_SESSION['t'] . '">'; }
function rp($n) { return 'Rp' . number_format($n, 0, ',', '.'); }
function go($url) { header("Location: $url"); exit; }
function user() { return $_SESSION['user'] ?? null; }
function q($sql, $p = []) { global $db; $s = $db->prepare($sql); $s->execute($p); return $s; }
function need($admin = false) {
    $u = user();
    if (!$u || ($admin && $u['role'] != 'admin')) go(($GLOBALS['r'] ?? '') . 'login.php');
}
