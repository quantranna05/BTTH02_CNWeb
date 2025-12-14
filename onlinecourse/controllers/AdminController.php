<?php
require_once __DIR__ . '/../models/User.php';

class AdminController
{

    public function users()
    {
        $userModel = new User();
        $users = $userModel->getAll();
        // Trỏ đúng file manage.php
        require __DIR__ . '/../views/admin/users/manage.php';
    }

    public function updateRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $userModel->updateRole($_POST['id'], $_POST['role']);
            header("Location: index.php?page=admin_users");
            exit;
        }
    }

    public function deleteUser()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_SESSION['user_id'] == $id) {
                echo "<script>alert('Không thể xóa chính mình!'); window.location.href='index.php?page=admin_users';</script>";
                exit;
            }
            $userModel = new User();
            $userModel->delete($id);
            header("Location: index.php?page=admin_users");
            exit;
        }
    }
}
?>