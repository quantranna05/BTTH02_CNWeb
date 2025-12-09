<?php
class Lesson
{
    private $conn;
    private $table = 'lessons';

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy danh sách bài học theo ID khóa học
    public function getByCourseId($courseId)
    {
        // Xóa đoạn "ORDER BY order_num ASC" đi
        $query = "SELECT * FROM " . $this->table . " WHERE course_id = :course_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>