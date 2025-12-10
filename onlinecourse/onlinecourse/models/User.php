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

    public function register($username, $email, $fullname, $password)
    {
        $check = $this->conn->prepare("SELECT * FROM users WHERE username=:username OR email=:email");
        $check->bindParam(':username', $username);
        $check->bindParam(':email', $email);
        $check->execute();
        if ($check->rowCount() > 0)
            return "Username hoặc Email đã tồn tại!";

        $stmt = $this->conn->prepare("INSERT INTO users (username,email,fullname,password,role,created_at)
            VALUES (:username,:email,:fullname,:password,0,NOW())");
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':password', $hashed);

        return $stmt->execute() ? true : "Đăng ký thất bại!";
    }

    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user && password_verify($password, $user['password']) ? $user : false;
    }
}