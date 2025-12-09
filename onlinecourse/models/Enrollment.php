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
    // Thêm vào class Enrollment
    public function updateProgress($studentId, $courseId, $percentToAdd)
    {
        // 1. Lấy tiến độ hiện tại
        $query = "SELECT progress FROM " . $this->table . " WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        $currentProgress = $stmt->fetchColumn() ?: 0;

        // 2. Cộng thêm % mới (Không được quá 100%)
        $newProgress = $currentProgress + $percentToAdd;
        if ($newProgress > 100)
            $newProgress = 100;

        // 3. Cập nhật lại vào DB
        $updateQuery = "UPDATE " . $this->table . " SET progress = :progress WHERE student_id = :student_id AND course_id = :course_id";
        $stmtUpdate = $this->conn->prepare($updateQuery);
        $stmtUpdate->bindParam(':progress', $newProgress);
        $stmtUpdate->bindParam(':student_id', $studentId);
        $stmtUpdate->bindParam(':course_id', $courseId);

        return $stmtUpdate->execute();
    }

    // Hàm lấy % hiện tại để hiển thị ra View
    public function getProgress($studentId, $courseId)
    {
        $query = "SELECT progress FROM " . $this->table . " WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }
}
?>