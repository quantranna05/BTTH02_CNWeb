<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    // ĐỊNH NGHĨA ĐƯỜNG DẪN GỐC CỦA DỰ ÁN
    // Bạn hãy sửa dòng này nếu tên thư mục dự án của bạn khác
    private $baseUrl = '/BTTH02_CNWeb/onlinecourse';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    public function register()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $fullname = trim($_POST['fullname']);
            $password = $_POST['password'];

            $result = $this->userModel->register($username, $email, $fullname, $password);

            if ($result === true) {
                // SỬA LẠI: Chuyển hướng về trang login với đường dẫn tuyệt đối
                header("Location: " . $this->baseUrl . "/auth/login?success=1");
                exit;
            } else {
                $error = $result;
            }
        }
        require __DIR__ . '/../views/auth/register.php';
    }

    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user) {
                // Lưu session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['fullname'] = $user['fullname'];

                // --- QUAN TRỌNG: CHUYỂN VỀ TRANG CHỦ TUYỆT ĐỐI ---
                // Dùng đường dẫn gốc để không bị kẹt trong thư mục /auth/
                header("Location: " . $this->baseUrl . "/");
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        // Chuyển hướng về trang chủ sau khi đăng xuất
        header("Location: " . $this->baseUrl . "/");
        exit;
    }
}
?>