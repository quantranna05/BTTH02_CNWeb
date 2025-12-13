<?php
require_once __DIR__ . '/../config/Database.php';

class User
{
    private $conn;

<<<<<<< HEAD:onlinecourse/onlinecourse/models/User.php
    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    /* =========================
       ĐĂNG KÝ
    ========================== */
    public function register($u, $e, $f, $p) {
        $check = $this->conn->prepare(
            "SELECT id FROM users WHERE username=? OR email=?"
        );
        $check->execute([$u, $e]);
=======
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
>>>>>>> 16dc027df1d69c70b35a69d99407b7053e566f89:onlinecourse/models/User.php

        if ($check->rowCount() > 0) {
            return "User hoặc Email đã tồn tại";
        }

        $hash = password_hash($p, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare(
            "INSERT INTO users(username,email,fullname,password,role,status,created_at)
             VALUES(?,?,?,?,0,1,NOW())"
        );

        return $stmt->execute([$u, $e, $f, $hash]);
    }

<<<<<<< HEAD:onlinecourse/onlinecourse/models/User.php
    /* =========================
       ĐĂNG NHẬP
    ========================== */
    public function login($u, $p) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM users WHERE username=? LIMIT 1"
        );
        $stmt->execute([$u]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return false;

        // Tài khoản bị khoá
        if ($user['status'] == 0) {
            return "Tài khoản đã bị khoá";
        }

        if (password_verify($p, $user['password'])) {
            return $user;
        }

        return false;
    }

    /* =========================
       ADMIN: LẤY DANH SÁCH USER
    ========================== */
    public function getAll() {
        return $this->conn->query(
            "SELECT id, username, email, fullname, role, status, created_at 
             FROM users"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       ADMIN: ĐỔI ROLE
       0: Học viên | 1: Giảng viên | 2: Admin
    ========================== */
    public function updateRole($id,$role) {
        $stmt = $this->conn->prepare(
            "UPDATE users SET role=? WHERE id=?"
        );
        return $stmt->execute([$role,$id]);
    }


    /* =========================
       ADMIN: KHOÁ / MỞ USER
    ========================== */
    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare(
            "UPDATE users SET status=? WHERE id=?"
        );
        return $stmt->execute([$status, $id]);
    }

    /* =========================
       ADMIN: XOÁ USER
    ========================== */
    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM users WHERE id=?"
        );
        return $stmt->execute([$id]);
    }

    /* =========================
       TÌM USER THEO ID
    ========================== */
    public function findById($id) {
        $stmt = $this->conn->prepare(
            "SELECT id, username, email, fullname, role, status 
             FROM users WHERE id=?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
=======
    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user && password_verify($password, $user['password']) ? $user : false;
>>>>>>> 16dc027df1d69c70b35a69d99407b7053e566f89:onlinecourse/models/User.php
    }
}