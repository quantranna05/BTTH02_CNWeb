<?php
require_once 'config/Database.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function register($username, $email, $fullname, $password) {
        $sql = "INSERT INTO {$this->table} (username, email, fullname, password) VALUES (:username, :email, :fullname, :password)";
        $stmt = $this->conn->prepare($sql);
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':password', $hashed);
        return $stmt->execute();
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM {$this->table} WHERE email=:email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
