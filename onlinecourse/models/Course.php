<?php
class Course
{
    private $conn;
    private $table = 'courses';

    // Properties
    public $id;
    public $title;
    public $description;
    public $instructor_id;
    public $category_id;
    public $price;
    public $duration_weeks;
    public $level;
    public $image;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả khóa học
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy khóa học theo ID
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm khóa học
    public function search($keyword)
    {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " WHERE title LIKE :keyword ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $searchTerm = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchTerm);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    // ========== PHẦN MỚI - LẬP TRÌNH VIÊN B ==========

    // Lấy khóa học theo giảng viên
    public function getByInstructor($instructor_id)
    {
        $query = "SELECT c.*, COUNT(l.id) as lesson_count 
                  FROM " . $this->table . " c
                  LEFT JOIN lessons l ON c.id = l.course_id
                  WHERE c.instructor_id = :instructor_id
                  GROUP BY c.id
                  ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':instructor_id', $instructor_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo khóa học mới
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
                  (title, description, instructor_id, image, price, duration_weeks, level, category_id) 
                  VALUES (:title, :description, :instructor_id, :image, :price, :duration_weeks, :level, :category_id)";
        
        $stmt = $this->conn->prepare($query);
        
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':instructor_id', $this->instructor_id);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':duration_weeks', $this->duration_weeks);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':category_id', $this->category_id);
        
        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Cập nhật khóa học
    public function update()
    {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, 
                      description = :description,
                      image = :image,
                      price = :price,
                      duration_weeks = :duration_weeks,
                      level = :level
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':duration_weeks', $this->duration_weeks);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    // Xóa khóa học
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>