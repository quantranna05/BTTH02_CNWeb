<?php
// Load các Model cần thiết
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Lesson.php';

class EnrollmentController
{
    // Xử lý Đăng ký khóa học
    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /BTTH02_CNWeb/onlinecourse/auth/login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $courseId = $_POST['course_id'];

            $enrollmentModel = new Enrollment();
            $enrollmentModel->register($userId, $courseId);

            // Đăng ký xong quay lại trang chi tiết
            header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/$courseId");
        }
    }

    // Xử lý khi bấm nút "Hoàn thành bài học" (Tăng %)
    public function completeLesson()
    {
        if (!isset($_SESSION['user_id']))
            exit;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $courseId = $_POST['course_id'];

            // 1. Tính toán % mỗi bài học
            $lessonModel = new Lesson();
            $lessons = $lessonModel->getByCourseId($courseId);
            $totalLessons = count($lessons);

            if ($totalLessons > 0) {
                $percentPerLesson = 100 / $totalLessons;

                // 2. Lấy tiến độ cũ + % bài mới
                $enrollmentModel = new Enrollment();
                $currentProgress = $enrollmentModel->getProgress($userId, $courseId);
                $newProgress = $currentProgress + $percentPerLesson;

                // 3. Cập nhật vào DB
                $enrollmentModel->updateProgress($userId, $courseId, $newProgress);
            }

            header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/$courseId");
        }
    }
}
?>