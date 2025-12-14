<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // 1. Kiểm tra đã đăng ký chưa
    public function isEnrolled($userId, $courseId)
    {
        // Lưu ý: Database của bạn dùng 'student_id'
        $sql = "SELECT * FROM enrollments WHERE student_id = :uid AND course_id = :cid LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $userId, ':cid' => $courseId]);
        return $stmt->rowCount() > 0;
    }

    // 2. Đăng ký khóa học
    public function enroll($userId, $courseId)
    {
        if ($this->isEnrolled($userId, $courseId))
            return false;

        $sql = "INSERT INTO enrollments (student_id, course_id, progress) VALUES (:uid, :cid, 0)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':uid' => $userId, ':cid' => $courseId]);
    }

    // 3. Lấy % tiến độ hiện tại
    public function getProgress($userId, $courseId)
    {
        $sql = "SELECT progress FROM enrollments WHERE student_id = :uid AND course_id = :cid LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $userId, ':cid' => $courseId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Làm tròn số lẻ để tránh lỗi so sánh (VD: 33.3333)
        return $row ? floatval($row['progress']) : 0;
    }

    // 4. Cộng điểm tiến độ (QUAN TRỌNG)
    public function completeLesson($userId, $courseId)
    {
        // A. Đếm tổng số bài học
        $sqlTotal = "SELECT COUNT(*) as total FROM lessons WHERE course_id = :cid";
        $stmtTotal = $this->conn->prepare($sqlTotal);
        $stmtTotal->execute([':cid' => $courseId]);
        $rowTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
        $totalLessons = $rowTotal['total'] ?? 0;

        if ($totalLessons == 0)
            return false;

        // B. Tính % của 1 bài (Ví dụ 3 bài thì mỗi bài 33.33%)
        $percentPerLesson = 100 / $totalLessons;

        // C. Lấy tiến độ cũ
        $currentProgress = $this->getProgress($userId, $courseId);

        // D. Cộng thêm (Nếu gần 100% thì cho thành 100 luôn)
        $newProgress = $currentProgress + $percentPerLesson;
        if ($newProgress > 99)
            $newProgress = 100;

        // E. Cập nhật vào DB
        $sqlUpdate = "UPDATE enrollments SET progress = :prog WHERE student_id = :uid AND course_id = :cid";
        $stmtUpdate = $this->conn->prepare($sqlUpdate);
        return $stmtUpdate->execute([
            ':prog' => $newProgress,
            ':uid' => $userId,
            ':cid' => $courseId
        ]);
    }
}
?>