<?php
class Lesson
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy bài học theo khóa
    public function getByCourseId($courseId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM lessons WHERE course_id = :course_id ORDER BY id ASC");
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm bài học
    public function create($courseId, $title, $videoUrl)
    {
        $sql = "INSERT INTO lessons (course_id, title, video_url) VALUES (:course_id, :title, :video_url)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':course_id' => $courseId, ':title' => $title, ':video_url' => $videoUrl]);
    }

    // Xóa bài học
    public function delete($id)
    {
        $sql = "DELETE FROM lessons WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>