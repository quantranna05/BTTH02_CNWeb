<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $user;

    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->user = new User();
    }

    /* =========================
       ĐĂNG KÝ
    ========================== */
    public function register(){
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email    = trim($_POST['email']);
            $fullname = trim($_POST['fullname']);
            $password = $_POST['password'];

            $result = $this->user->register($username, $email, $fullname, $password);

            if ($result === true) {
                header("Location: index.php?page=login&success=1");
                exit;
            } else {
                $error = $result;
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    /* =========================
       ĐĂNG NHẬP + PHÂN QUYỀN
    ========================== */
    public function login(){
        $error = '';

        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['username'], $_POST['password'])
        ) {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = $this->user->login($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header("Location:index.php?page=dashboard");
                exit;
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
        }
        }


        require __DIR__ . '/../views/auth/login.php';
    }

    /* =========================
       ĐĂNG XUẤT
    ========================== */
    public function logout(){
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
