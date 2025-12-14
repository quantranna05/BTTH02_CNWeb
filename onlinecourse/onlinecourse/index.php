<?php
// index.php – Front Controller

// ==================
// BOOTSTRAP
// ==================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/config/auth.php';

// Controllers
require_once __DIR__ . '/controllers/AuthController.php';
// require_once __DIR__ . '/controllers/AdminController.php';
// require_once __DIR__ . '/controllers/InstructorController.php';
// require_once __DIR__ . '/controllers/StudentController.php';

// ==================
// ROUTING
// ==================
$page = $_GET['page'] ?? 'login';

$auth = new AuthController();

switch ($page) {

    // ===== AUTH =====
    case 'login':
        $auth->login();
        break;

    case 'register':
        $auth->register();
        break;

    case 'logout':
        $auth->logout();
        break;

    // ===== DASHBOARD =====
    case 'dashboard':
        requireLogin();

        $role = $_SESSION['user']['role'];

        // 0: student | 1: instructor | 2: admin
        if ($role == 0) {
            header("Location: index.php?page=student_dashboard");
        } elseif ($role == 1) {
            header("Location: index.php?page=instructor_dashboard");
        } elseif ($role == 2) {
            header("Location: index.php?page=admin_dashboard");
        }
        exit;

    // ===== STUDENT =====
    case 'student_dashboard':
        requireRole(0);
        echo "<h2>Student Dashboard</h2>";
        echo "<p>Xin chào: ".$_SESSION['user']['fullname']."</p>";
        echo "<a href='index.php?page=logout'>Logout</a>";
        break;

    // ===== INSTRUCTOR =====
    case 'instructor_dashboard':
        requireRole(1);
        echo "<h2>Instructor Dashboard</h2>";
        echo "<p>Xin chào: ".$_SESSION['user']['fullname']."</p>";
        echo "<a href='index.php?page=logout'>Logout</a>";
        break;

    // ===== ADMIN =====
    case 'admin_dashboard':
        requireRole(2);
        echo "<h2>Admin Dashboard</h2>";
        echo "<p>Xin chào ADMIN: ".$_SESSION['user']['fullname']."</p>";
        echo "<a href='index.php?page=logout'>Logout</a>";
        break;

    case 'admin_users':
        requireRole(2); // chỉ admin
        require_once __DIR__ . '/controllers/AdminController.php';
        (new AdminController())->users();
        break;

    case 'admin_update_role':
        requireRole(2); // chỉ admin
        require_once __DIR__ . '/controllers/AdminController.php';
        (new AdminController())->updateRole();
        break;


    // ===== 404 =====
    default:
        http_response_code(404);
        echo "<h2>404 - Page not found</h2>";
        break;
}
