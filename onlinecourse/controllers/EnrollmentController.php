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
}
?>