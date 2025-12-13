<?php
class Lesson
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getByCourseId($courseId)
    {
        // Lấy tất cả bài học thuộc khóa học này
        $sql = "SELECT * FROM lessons WHERE course_id = :course_id ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>