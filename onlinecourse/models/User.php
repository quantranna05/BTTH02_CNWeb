<?php
require_once __DIR__ . '/../config/Database.php';

class User
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy tất cả user
    public function getAll()
    {
        $stmt = $this->conn->query("SELECT id, username, email, fullname, role, created_at FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật quyền
    public function updateRole($id, $role)
    {
        $stmt = $this->conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $id]);
    }

    // Xóa user
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Login (Giữ lại để dùng cho AuthController)
    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Register
    public function register($username, $email, $fullname, $password)
    {
        // ... (Code register cũ của bạn) ...
        // Lưu ý: Default role = 0
    }
}
?>