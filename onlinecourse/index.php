<?php
session_start();

// 1. Định nghĩa đường dẫn gốc
define('ROOT_PATH', __DIR__);

// 2. Load kết nối Database
require_once ROOT_PATH . '/config/Database.php';

// 3. Xử lý URL (Routing)
$url = isset($_GET['url']) ? $_GET['url'] : null;

if ($url) {
    // --- TRƯỜNG HỢP 1: CÓ ĐƯỜNG DẪN CỤ THỂ ---
    $url = rtrim($url, '/');
    $url = explode('/', $url);

    // Lấy tên Controller
    $controllerName = ucfirst($url[0]);

    // Xử lý số nhiều: courses -> Course
    if (substr($controllerName, -1) == 's') {
        $controllerName = substr($controllerName, 0, -1);
    }
    $controllerName .= 'Controller';

    // Lấy tên Action
    $actionName = isset($url[1]) ? $url[1] : 'index';

    // Đường dẫn file Controller
    $controllerPath = ROOT_PATH . '/controllers/' . $controllerName . '.php';

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        $controller = new $controllerName();

        if (method_exists($controller, $actionName)) {
            $controller->{$actionName}();
        } else {
            echo "Lỗi 404: Không tìm thấy hàm '$actionName'";
        }
    } else {
        echo "Lỗi 404: Không tìm thấy Controller '$controllerName'";
    }
} else {
    // --- TRƯỜNG HỢP 2: TRANG CHỦ (Không có URL) ---
    // [QUAN TRỌNG] Gọi hàm home() để hiện Landing Page đẹp
    require_once ROOT_PATH . '/controllers/CourseController.php';
    $controller = new CourseController();
    $controller->home(); // <-- Đã sửa từ index() thành home()
}
?>