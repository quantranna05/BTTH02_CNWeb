<?php
require_once 'controllers/AuthController.php';
$auth = new AuthController();

$page = $_GET['page'] ?? 'login';
switch($page){
    case 'login': $auth->login(); break;
    case 'register': $auth->register(); break;
    case 'logout': $auth->logout(); break;
    case 'student_dashboard':
        echo "<h2>Welcome ".$_SESSION['user']['fullname']."</h2><a href='index.php?page=logout'>Logout</a>";
        break;
    default: $auth->login(); break;
}
