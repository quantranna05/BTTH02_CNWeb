<?php
// Load các Model cần thiết
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Lesson.php';

class EnrollmentController
{
    // Hàm hỗ trợ kiểm tra đăng nhập
    private function requireLogin()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
    }

    // 1. Xử lý Đăng ký khóa học
    public function store()
    {
        $this->requireLogin();

        // Nếu có tham số ID trên URL (dạng GET)
        // Ví dụ: index.php?url=enrollment/store/5
        // (Tuy nhiên, ở CourseController ta đã có hàm register rồi, hàm này để dự phòng nếu dùng form POST)
        if (isset($_GET['course_id'])) {
            // Logic giống CourseController::register
            // ...
        }

        // Nếu dùng Form POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $courseId = $_POST['course_id'];

            $enrollmentModel = new Enrollment();
            // Hàm trong Model là enroll, không phải register
            $enrollmentModel->enroll($userId, $courseId);

            // Đăng ký xong quay lại trang chi tiết
            header("Location: index.php?url=courses/detail/$courseId");
            exit;
        }
    }

    // 2. Xử lý khi bấm nút "Hoàn thành"
    public function completeLesson()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $courseId = $_POST['course_id']; // Lấy ID khóa học từ form

            if ($courseId) {
                $enrollmentModel = new Enrollment();
                // Gọi hàm cộng điểm bên Model
                $enrollmentModel->completeLesson($userId, $courseId);
            }

            // Quay lại trang chi tiết
            header("Location: index.php?url=courses/detail/$courseId");
            exit;
        }
    }
}
?>