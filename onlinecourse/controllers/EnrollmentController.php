<?php
class EnrollmentController
{

    public function store()
    {
        // 1. KIỂM TRA ĐĂNG NHẬP (Code giả lập cho Programmer C)
        if (!isset($_SESSION['user_id'])) {
            // Chuyển hướng về Login nếu chưa đăng nhập
            echo "<script>
                alert('Vui lòng đăng nhập để đăng ký!');
                window.location.href = '/BTTH02_CNWeb/onlinecourse/auth/login'; 
            </script>";
            exit();
        }

        // 2. XỬ LÝ ĐĂNG KÝ
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentId = $_SESSION['user_id']; // Lấy ID từ Session (Giả lập hoặc thật)
            $courseId = $_POST['course_id'];   // Lấy ID khóa học từ Form

            $enrollmentModel = new Enrollment();

            // Kiểm tra đã học chưa
            if ($enrollmentModel->isEnrolled($studentId, $courseId)) {
                echo "<script>
                    alert('Bạn đang học khóa này rồi!');
                    window.history.back();
                </script>";
            } else {
                // Gọi hàm đăng ký
                if ($enrollmentModel->register($studentId, $courseId)) {
                    echo "<script>
                        alert('Đăng ký thành công! Bắt đầu học ngay.');
                        window.location.href = '/BTTH02_CNWeb/onlinecourse/'; 
                    </script>";
                } else {
                    echo "<script>
                        alert('Lỗi hệ thống: Không thể đăng ký.');
                        window.history.back();
                    </script>";
                }
            }
        }
    }
    // Thêm vào class EnrollmentController

    public function completeLesson()
    {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: /BTTH02_CNWeb/onlinecourse/auth/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentId = $_SESSION['user_id'];
            $courseId = $_POST['course_id'];

            // Đếm tổng số bài học của khóa này để chia %
            // (Lưu ý: Đoạn này cần gọi Model Lesson để đếm, mình viết gọn SQL ở đây hoặc bạn gọi LessonModel)
            $db = new Database();
            $conn = $db->getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM lessons WHERE course_id = :course_id");
            $stmt->bindParam(':course_id', $courseId);
            $stmt->execute();
            $totalLessons = $stmt->fetchColumn();

            if ($totalLessons > 0) {
                // Tính giá trị % của 1 bài học
                $percentPerLesson = 100 / $totalLessons;

                // Gọi Model để cộng %
                $enrollmentModel = new Enrollment();
                $enrollmentModel->updateProgress($studentId, $courseId, $percentPerLesson);
            }

            // Quay lại trang chi tiết
            header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/" . $courseId);
        }
    }
}
?>