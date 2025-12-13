<?php
require_once 'models/User.php';
require_once 'config/auth.php';

class AdminController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function dashboard() {
        requireRole(2);
        require 'views/admin/dashboard.php';
    }

    public function users() {
        requireRole(2);
        $users = $this->userModel->all();
        require 'views/admin/users/manage.php';
    }

    public function updateRole() {
        requireRole(2);
        $this->userModel->setRole($_POST['id'], $_POST['role']);
        header("Location: index.php?controller=admin&action=users");
    }

    public function toggleStatus() {
        requireRole(2);
        $this->userModel->setStatus($_GET['id'], $_GET['status']);
        header("Location: index.php?controller=admin&action=users");
    }
}
