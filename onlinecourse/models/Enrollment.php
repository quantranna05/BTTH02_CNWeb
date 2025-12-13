<?php
class Enrollment
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // 1. Đăng ký khóa học
    public function register($studentId, $courseId)
    {
        // Kiểm tra xem đã đăng ký chưa
        if ($this->isEnrolled($studentId, $courseId)) {
            return false;
        }

        // [SỬA] Đổi user_id -> student_id
        $sql = "INSERT INTO enrollments (student_id, course_id, progress) VALUES (:student_id, :course_id, 0)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':student_id' => $studentId, ':course_id' => $courseId]);
    }

    // 2. Kiểm tra xem User đã đăng ký chưa
    public function isEnrolled($studentId, $courseId)
    {
        // [SỬA] Đổi user_id -> student_id trong WHERE
        $sql = "SELECT * FROM enrollments WHERE student_id = :student_id AND course_id = :course_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':student_id' => $studentId, ':course_id' => $courseId]);
        return $stmt->rowCount() > 0;
    }

    // 3. Lấy % tiến độ
    public function getProgress($studentId, $courseId)
    {
        // [SỬA] Đổi user_id -> student_id
        $sql = "SELECT progress FROM enrollments WHERE student_id = :student_id AND course_id = :course_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':student_id' => $studentId, ':course_id' => $courseId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['progress'] : 0;
    }

    // 4. Cập nhật tiến độ
    public function updateProgress($studentId, $courseId, $newProgress)
    {
        if ($newProgress > 100)
            $newProgress = 100;

        // [SỬA] Đổi user_id -> student_id
        $sql = "UPDATE enrollments SET progress = :progress WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':progress' => $newProgress, ':student_id' => $studentId, ':course_id' => $courseId]);
    }
}
?>