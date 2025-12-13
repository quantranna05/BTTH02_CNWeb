<?php
// FILE: models/Course.php

class Course
{
    private $conn;
    private $table = 'courses';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function search($keyword)
    {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " WHERE title LIKE :keyword";
            $stmt = $this->conn->prepare($query);
            $searchTerm = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchTerm);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return []; // Trả về mảng rỗng nếu không có từ khóa
    }

    // --- LƯU Ý: KHÔNG ĐỂ HÀM detail() Ở ĐÂY ---
}
?>