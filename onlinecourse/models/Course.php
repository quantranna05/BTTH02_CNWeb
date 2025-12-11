<?php
class Course
{
    private $conn;
    private $table = 'courses';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // --- (Các hàm getAll, getById cũ giữ nguyên) ---
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

    // --- THÊM HÀM TÌM KIẾM Ở ĐÂY ---
    public function search($keyword)
    {
        if (!empty($keyword)) {
            // Tìm những khóa học có Tên chứa từ khóa
            $query = "SELECT * FROM " . $this->table . " WHERE title LIKE :keyword";
            $stmt = $this->conn->prepare($query);

            // Thêm dấu % hai bên để tìm kiếm tương đối (Ví dụ: %PHP%)
            $searchTerm = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchTerm);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>