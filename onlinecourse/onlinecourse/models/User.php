<?php

require_once "config/Database.php";

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ---- Tạo người dùng mới ----
    public function register($username, $email, $password, $fullname) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO $this->table (username, email, password, fullname, role, created_at)
                VALUES (:username, :email, :password, :fullname, 0, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $hashed,
            ":fullname" => $fullname
        ]);

        return true;
    }

    // ---- Kiểm tra đăng nhập ----
    public function login($username, $password) {
        $sql = "SELECT * FROM $this->table WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":username" => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            return $user; // trả về toàn bộ thông tin user
        }

        return false;
    }
}
