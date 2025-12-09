<?php
// FILE: index.php

// 1. KHỞI ĐỘNG SESSION
session_start();

// =================================================================
// --- [MỚI] CHẾ ĐỘ DEV (DÀNH CHO LẬP TRÌNH VIÊN C) ---
// Giả lập người dùng ID=1 đã đăng nhập để test chức năng Đăng ký
// LƯU Ý: XÓA ĐOẠN NÀY KHI GHÉP CODE VỚI LẬP TRÌNH VIÊN A
// =================================================================
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;       // Giả sử User ID 1 đang online
    $_SESSION['username'] = 'Test Student';
    $_SESSION['role'] = 0;          // 0 là học viên
}
// =================================================================

// 2. ĐỊNH NGHĨA ĐƯỜNG DẪN GỐC
define('ROOT_PATH', __DIR__);

// 3. AUTOLOAD
spl_autoload_register(function ($className) {
    $paths = [
        ROOT_PATH . '/config/',
        ROOT_PATH . '/models/',
        ROOT_PATH . '/controllers/'
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// 4. XỬ LÝ ROUTING

$url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
$url = filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL);
$urlArr = explode('/', $url);

// --- CẤU HÌNH ĐƯỜNG DẪN ĐẸP (ROUTING MAP) ---
$routingMap = [
    'courses' => 'CourseController',
    'khoa-hoc' => 'CourseController',
    'login' => 'AuthController',
    'register' => 'AuthController',


    // --- [MỚI] THÊM DÒNG NÀY ĐỂ NÚT ĐĂNG KÝ CHẠY ĐƯỢC ---
    'enrollment' => 'EnrollmentController',
    // ----------------------------------------------------
];

// Xác định Controller
$routeKey = $urlArr[0] ?? 'home';

if (array_key_exists($routeKey, $routingMap)) {
    $controllerName = $routingMap[$routeKey];
} else {
    $controllerName = ucfirst($routeKey) . 'Controller';
}

// Xác định Action
$action = $urlArr[1] ?? 'index';

// Xác định Tham số
$params = array_slice($urlArr, 2);

// 5. GỌI CONTROLLER VÀ CHẠY
$controllerPath = ROOT_PATH . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerPath)) {
    if (class_exists($controllerName)) {
        $controllerObject = new $controllerName();

        if (method_exists($controllerObject, $action)) {
            call_user_func_array([$controllerObject, $action], $params);
        } else {
            die("Lỗi 404: Action '{$action}' không tồn tại trong Controller '{$controllerName}'.");
        }
    } else {
        die("Lỗi hệ thống: Class '{$controllerName}' không được tìm thấy.");
    }
} else {
    die("Lỗi 404: Trang bạn tìm kiếm không tồn tại (Controller '{$controllerName}' not found).");
}
?>