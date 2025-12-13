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
    public function getFeatured($limit = 2)
    {
        $sql = "SELECT * FROM courses ORDER BY id DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 1. Lấy tất cả (Ưu tiên B: Sắp xếp mới nhất lên đầu)
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy 1 dòng theo ID
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Tìm kiếm (Ưu tiên C: Logic kiểm tra rỗng an toàn hơn)
    public function search($keyword)
    {
        if (!empty($keyword)) {
            $sql = "SELECT * FROM " . $this->table . " WHERE title LIKE :keyword";
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchTerm);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    // --- CÁC HÀM ADMIN (Của B) ---

    public function create($title, $description, $price, $image)
    {
        $sql = "INSERT INTO " . $this->table . " (title, description, price, image) VALUES (:title, :description, :price, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':title' => $title, ':description' => $description, ':price' => $price, ':image' => $image]);
    }

    public function update($id, $title, $description, $price, $image)
    {
        $sql = "UPDATE " . $this->table . " SET title=:title, description=:description, price=:price, image=:image WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':title' => $title, ':description' => $description, ':price' => $price, ':image' => $image, ':id' => $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>