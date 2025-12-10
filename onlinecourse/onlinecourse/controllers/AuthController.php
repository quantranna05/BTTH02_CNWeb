<?php

require_once "models/User.php";

class AuthController {

    // Hiển thị form login
    public function showLogin() {
        require "views/auth/login.php";
    }

    // Xử lý login
    public function login() {
        if (!empty($_POST["username"]) && !empty($_POST["password"])) {

            $userModel = new User();
            $user = $userModel->login($_POST["username"], $_POST["password"]);

            if ($user) {
                session_start();
                $_SESSION["user"] = $user;
                header("Location: index.php?page=dashboard");
                exit;
            } else {
                $error = "Sai username hoặc password!";
                require "views/auth/login.php";
            }
        }
    }

    // Hiển thị form register
    public function showRegister() {
        require "views/auth/register.php";
    }

    // Xử lý register
    public function register() {
        if (!empty($_POST["username"]) && !empty($_POST["email"]) &&
            !empty($_POST["password"]) && !empty($_POST["fullname"])) {

            $userModel = new User();
            $userModel->register(
                $_POST["username"],
                $_POST["email"],
                $_POST["password"],
                $_POST["fullname"]
            );

            header("Location: index.php?page=login&success=1");
            exit;
        }
    }

    // Logout
    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?page=login");
    }
}
