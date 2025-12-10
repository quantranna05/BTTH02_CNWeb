<?php
session_start();
require_once 'controllers/AuthController.php';

$page = $_GET['page'] ?? 'login';

$auth = new AuthController();

switch($page) {
    case 'login':
        $auth->login();
        break;
    case 'register':
        $auth->register();
        break;
    case 'logout':
        $auth->logout();
        break;
    case 'student_dashboard':
        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header("Location: index.php?page=login");
            exit;
        }
        require 'views/student/dashboard.php';
        break;
    case 'instructor_dashboard':
        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header("Location: index.php?page=login");
            exit;
        }
        require 'views/instructor/dashboard.php';
        break;
    case 'admin_dashboard':
        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
            header("Location: index.php?page=login");
            exit;
        }
        require 'views/admin/dashboard.php';
        break;
    default:
        echo "Trang không tồn tại!";
}
