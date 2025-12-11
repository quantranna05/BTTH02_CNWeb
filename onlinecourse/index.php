<?php
// FILE: index.php

// 1. KHỞI ĐỘNG SESSION
session_start();

// 2. ĐỊNH NGHĨA ĐƯỜNG DẪN GỐC
define('ROOT_PATH', __DIR__);

// 3. AUTOLOAD (Hệ thống nạp file tự động của C)
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

// 4. XỬ LÝ ROUTING (Hệ thống điều hướng thông minh của C)

// Lấy tham số url
$url = isset($_GET['url']) ? $_GET['url'] : 'home/index';

// --- CẦU NỐI GIỮ LẠI TÍNH NĂNG CỦA A ---
// Đoạn này giúp link cũ ?page=login của A vẫn chạy tốt trên hệ thống mới
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 'login')
        $url = 'auth/login';
    elseif ($page == 'register')
        $url = 'auth/register';
    elseif ($page == 'logout')
        $url = 'auth/logout';
}
// ----------------------------------------

$url = filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL);
$urlArr = explode('/', $url);

// --- BẢN ĐỒ ĐỊNH TUYẾN (Nơi A và C gặp nhau) ---
$routingMap = [
    // Các chức năng của C
    'courses' => 'CourseController',
    'khoa-hoc' => 'CourseController',
    'enrollment' => 'EnrollmentController',
    'progress' => 'ProgressController',

    // Các chức năng của A (Đã được khai báo vào hệ thống mới)
    'auth' => 'AuthController',
    'login' => 'AuthController',    // gõ /login -> Gọi AuthController
    'register' => 'AuthController',    // gõ /register -> Gọi AuthController
];

// Xác định Controller
$routeKey = $urlArr[0] ?? 'home';

if (array_key_exists($routeKey, $routingMap)) {
    $controllerName = $routingMap[$routeKey];
} else {
    $controllerName = ucfirst($routeKey) . 'Controller';
}

// Xác định Action (Hàm)
$action = $urlArr[1] ?? 'index';

// Fix lỗi hành động mặc định cho Auth
if ($routeKey == 'login')
    $action = 'login';
if ($routeKey == 'register')
    $action = 'register';

// 5. CHẠY CODE
$controllerPath = ROOT_PATH . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerPath)) {
    if (class_exists($controllerName)) {
        $controllerObject = new $controllerName();

        if (method_exists($controllerObject, $action)) {
            // Chạy hàm tương ứng
            call_user_func_array([$controllerObject, $action], array_slice($urlArr, 2));
        } else {
            // Nếu gọi Auth mà không có hàm, mặc định về login
            if ($controllerName == 'AuthController') {
                $controllerObject->login();
            } else {
                die("Lỗi 404: Không tìm thấy chức năng.");
            }
        }
    } else {
        die("Lỗi hệ thống: Không tìm thấy Controller.");
    }
} else {
    die("Lỗi 404: Trang không tồn tại.");
}

// KHÔNG CẦN SWITCH-CASE CỦA A Ở DƯỚI NỮA
// VÌ ĐOẠN CODE TRÊN ĐÃ BAO GỒM NÓ RỒI
?>