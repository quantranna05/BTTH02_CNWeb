<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        // Luôn đảm bảo session được bật để thao tác
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // --- ĐĂNG NHẬP ---
    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user && is_array($user)) {
                // Lưu thông tin vào Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

                // Chuyển hướng về trang chủ
                header("Location: index.php");
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    // --- ĐĂNG KÝ ---
    public function register()
    {
        // (Code đăng ký giữ nguyên như cũ)
        require __DIR__ . '/../views/auth/register.php';
    }

    // --- ĐĂNG XUẤT (QUAN TRỌNG) ---
    public function logout()
    {
        // 1. Xóa tất cả biến trong session
        session_unset();

        // 2. Hủy hoàn toàn phiên làm việc
        session_destroy();

        // 3. Chuyển hướng về trang chủ (để thấy lại nút Đăng nhập)
        header("Location: index.php");
        exit;
    }
}
?>