<?php

class Database
{
    private $host = "localhost";
    private $db_name = "onlinecourse"; // <-- Đảm bảo tên này đúng với phpMyAdmin của bạn
    private $username = "root";
    private $password = ""; // XAMPP mặc định mật khẩu để trống
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            // Kết nối UTF-8 để không bị lỗi font tiếng Việt
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Lỗi kết nối CSDL: " . $exception->getMessage();


        }
        return $this->conn;
    }
}