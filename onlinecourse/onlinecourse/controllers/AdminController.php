<?php
require_once __DIR__ . '/../models/User.php';

class AdminController {
    private $user;

    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🔴 BẮT BUỘC PHẢI CÓ
        $this->user = new User();
    }

    public function users(){
        $users = $this->user->getAll();
        require __DIR__ . '/../views/admin/users/manage.php';
    }

    public function updateRole(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id   = $_POST['id']   ?? null;
            $role = $_POST['role'] ?? null;

            if ($id !== null && $role !== null) {
                $this->user->updateRole($id, $role);
            }
        }

        header("Location: index.php?page=admin_users");
        exit;
    }
}
