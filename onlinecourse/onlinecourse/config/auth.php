<?php
session_start();

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user']['role'] < $role) {
        die("Bạn không có quyền truy cập");
    }
}
