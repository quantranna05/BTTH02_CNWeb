<?php
class Lesson
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy danh sách bài học theo khóa
    public function getByCourseId($courseId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM lessons WHERE course_id = :course_id ORDER BY id ASC");
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [MỚI] Lấy 1 bài học cụ thể để sửa
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM lessons WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [MỚI] Cập nhật bài học
    public function update($id, $title, $videoUrl)
    {
        $sql = "UPDATE lessons SET title = :title, video_url = :video_url WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':title' => $title, ':video_url' => $videoUrl, ':id' => $id]);
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