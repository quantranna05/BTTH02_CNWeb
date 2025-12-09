<?php
class Enrollment
{
    private $conn;
    private $table = 'enrollments'; // Tên bảng trong DB của bạn

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // 1. Đăng ký khóa học (INSERT)
    public function register($studentId, $courseId)
    {
        // Cập nhật tên cột theo DB của bạn: student_id, enrolled_date, status, progress
        $query = "INSERT INTO " . $this->table . " 
                  (student_id, course_id, enrolled_date, status, progress) 
                  VALUES (:student_id, :course_id, NOW(), 'active', 0)";

        $stmt = $this->conn->prepare($query);

        // Gán tham số
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);

        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            // Lỗi có thể do khóa ngoại hoặc trùng lặp (nếu chưa set unique)
            return false;
        }
        return false;
    }

    // 2. Kiểm tra đã đăng ký chưa (SELECT)
    public function isEnrolled($studentId, $courseId)
    {
        // Chú ý: dùng student_id thay vì user_id
        $query = "SELECT id FROM " . $this->table . " WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>