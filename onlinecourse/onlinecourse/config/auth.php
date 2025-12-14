<?php
function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?page=login");
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user']['role'] != $role) {
        die("Bạn không có quyền truy cập");
    }
}
