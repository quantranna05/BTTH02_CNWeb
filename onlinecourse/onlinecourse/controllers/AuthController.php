<?php
session_start();
require_once 'models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];

            if($this->user->register($username, $email, $fullname, $password)) {
                header("Location: index.php?page=login&success=1");
                exit;
            } else {
                $error = "Đăng ký thất bại, có thể email hoặc username đã tồn tại.";
            }
        }
        require 'views/auth/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->user->login($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                // Redirect theo role
                if ($user['role'] == 0) {
                    header("Location: index.php?page=student_dashboard");
                } elseif ($user['role'] == 1) {
                    header("Location: index.php?page=instructor_dashboard");
                } else {
                    header("Location: index.php?page=admin_dashboard");
                }
                exit;
            } else {
                $error = "Email hoặc mật khẩu sai!";
            }
        }
        require 'views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
