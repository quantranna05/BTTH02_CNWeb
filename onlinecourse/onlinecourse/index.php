<?php
session_start();

require_once "controllers/AuthController.php";

$controller = new AuthController();

// Điều hướng theo ?page=
$page = $_GET["page"] ?? "login";

switch ($page) {

    case "login":
        $controller->showLogin();
        break;

    case "login_submit":
        $controller->login();
        break;

    case "register":
        $controller->showRegister();
        break;

    case "register_submit":
        $controller->register();
        break;

    case "logout":
        $controller->logout();
        break;

    case "dashboard":
        echo "<h1>Xin chào, " . ($_SESSION["user"]["fullname"] ?? "Guest") . "</h1>";
        echo "<a href='index.php?page=logout'>Logout</a>";
        break;

    default:
        echo "404 - Page not found";
}
