<?php
// 1. KHỞI ĐỘNG SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/config/Database.php';

if (file_exists(ROOT_PATH . '/config/auth.php')) {
    require_once ROOT_PATH . '/config/auth.php';
}

require_once ROOT_PATH . '/controllers/AuthController.php';

// ================================================================
// PHẦN 1: XỬ LÝ ?page=... (Giữ nguyên logic cũ của bạn)
// ================================================================
$page = $_GET['page'] ?? null;

if ($page) {
    $auth = new AuthController();

    switch ($page) {
        case 'login':
            $auth->login();
            break;
        case 'register':
            $auth->register();
            break;
        case 'logout':
            $auth->logout();
            break;

        // --- DASHBOARD ---
        case 'dashboard':
            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php?page=login");
                exit;
            }
            $role = $_SESSION['role'] ?? 0;

            if ($role == 1) { // Admin
                require_once ROOT_PATH . '/views/admin/dashboard.php';
            } elseif ($role == 2) { // Giảng viên
                header("Location: index.php");
            } else { // Học viên
                header("Location: index.php");
            }
            exit;

        // --- ADMIN ---
        case 'admin_users':
            if (function_exists('requireRole'))
                requireRole(1);
            require_once ROOT_PATH . '/controllers/AdminController.php';
            (new AdminController())->users();
            break;

        case 'admin_update_role':
            if (function_exists('requireRole'))
                requireRole(1);
            require_once ROOT_PATH . '/controllers/AdminController.php';
            (new AdminController())->updateRole();
            break;

        case 'admin_delete_user':
            if (function_exists('requireRole'))
                requireRole(1);
            require_once ROOT_PATH . '/controllers/AdminController.php';
            (new AdminController())->deleteUser();
            break;

        // --- INSTRUCTOR (Đã xóa để dùng MVC Router) ---

        default:
            echo "<h2>404 - Page not found</h2>";
            break;
    }
    exit;
}

// ================================================================
// PHẦN 2: MVC ROUTER (ĐÃ SỬA LỖI TRUYỀN THAM SỐ)
// ================================================================
$url = isset($_GET['url']) ? $_GET['url'] : null;

if ($url) {
    $url = rtrim($url, '/');
    $url = explode('/', $url);

    // 1. Lấy tên Controller
    $controllerName = ucfirst($url[0]);
    if (substr($controllerName, -1) == 's') {
        $controllerName = substr($controllerName, 0, -1);
    }
    $controllerName .= 'Controller';

    // 2. Lấy tên Action (Hàm)
    $actionName = isset($url[1]) ? $url[1] : 'index';

    // 3. [MỚI] Lấy Tham số (ID) từ URL
    // Ví dụ: courses/register/5 -> $params sẽ là 5
    $params = isset($url[2]) ? $url[2] : null;

    $controllerPath = ROOT_PATH . '/controllers/' . $controllerName . '.php';

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        if (class_exists($controllerName)) {
            $controller = new $controllerName();

            if (method_exists($controller, $actionName)) {
                // [QUAN TRỌNG] Kiểm tra xem có tham số không để truyền vào hàm
                if ($params) {
                    $controller->{$actionName}($params);
                } else {
                    $controller->{$actionName}();
                }
            } else {
                echo "Action '$actionName' không tồn tại.";
            }
        }
    } else {
        echo "Controller '$controllerName' không tồn tại.";
    }
} else {
    // TRANG CHỦ
    require_once ROOT_PATH . '/controllers/CourseController.php';
    (new CourseController())->home();
}
?>