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
// PHẦN 1: XỬ LÝ ?page=...
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

            // Nếu là Admin (1) -> Vào Admin Dashboard
            if ($role == 1) {
                require_once ROOT_PATH . '/views/admin/dashboard.php';
            }
            // Nếu là Giảng viên (2) -> Tạm thời cho về trang chủ hoặc Admin Dashboard (vì bạn không dùng Controller riêng)
            elseif ($role == 2) {
                // Cách 1: Cho về trang chủ
                header("Location: index.php");

                // Cách 2: Nếu muốn dùng chung Dashboard với Admin thì mở dòng dưới:
                // require_once ROOT_PATH . '/views/admin/dashboard.php';
            }
            // Học viên
            else {
                header("Location: index.php");
            }
            exit;

        // --- ADMIN (Giữ nguyên) ---
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

        // --- [QUAN TRỌNG] ĐÃ XÓA CÁC CASE CỦA INSTRUCTOR ĐỂ KHÔNG BÁO LỖI ---
        // Nếu bạn muốn Giảng viên quản lý khóa học, bạn phải dùng AdminController 
        // hoặc CourseController để xử lý thay thế tại đây.

        default:
            echo "<h2>404 - Page not found</h2>";
            break;
    }
    exit;
}

// ================================================================
// PHẦN 2: MVC ROUTER (Courses/Lessons)
// ================================================================
$url = isset($_GET['url']) ? $_GET['url'] : null;

if ($url) {
    $url = rtrim($url, '/');
    $url = explode('/', $url);
    $controllerName = ucfirst($url[0]);
    if (substr($controllerName, -1) == 's') {
        $controllerName = substr($controllerName, 0, -1);
    }
    $controllerName .= 'Controller';
    $actionName = isset($url[1]) ? $url[1] : 'index';
    $controllerPath = ROOT_PATH . '/controllers/' . $controllerName . '.php';

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $actionName)) {
                $controller->{$actionName}();
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