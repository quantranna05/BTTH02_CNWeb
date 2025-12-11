<?php
class HomeController
{
    public function index()
    {
        // 1. Gọi Model
        $courseModel = new Course();
        $courses = $courseModel->getAll(); // Lấy danh sách khóa học

        // 2. Gửi dữ liệu sang View
        // Biến $courses sẽ được sử dụng bên trong file view
        require 'views/home/index.php';
    }
}
?>