<?php
class Course
{
    private $conn;
    private $table = 'courses';

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy tất cả
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 dòng theo ID
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm
    public function search($keyword)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE title LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = "%" . $keyword . "%";
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm mới
    public function create($title, $description, $price, $image)
    {
        $sql = "INSERT INTO " . $this->table . " (title, description, price, image) VALUES (:title, :description, :price, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':title' => $title, ':description' => $description, ':price' => $price, ':image' => $image]);
    }

    // Cập nhật (Sửa)
    public function update($id, $title, $description, $price, $image)
    {
        $sql = "UPDATE " . $this->table . " SET title=:title, description=:description, price=:price, image=:image WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':title' => $title, ':description' => $description, ':price' => $price, ':image' => $image, ':id' => $id]);
    }

    // Xóa
    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>