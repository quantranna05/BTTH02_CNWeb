<?php
require_once __DIR__ . '/../models/Lesson.php';

class LessonController
{
    private function checkAdmin()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo "<script>alert('Bạn không có quyền Admin!'); window.history.back();</script>";
            exit;
        }
    }

    // Thêm bài mới
    public function create()
    {
        $this->checkAdmin();
        $course_id = $_GET['course_id'];
        require __DIR__ . '/../views/instructor/lessons/create.php';
    }

    public function store()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lesson = new Lesson();
            $lesson->create($_POST['course_id'], $_POST['title'], $_POST['video_url']);
            header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/" . $_POST['course_id']);
        }
    }

    // [MỚI] Hiển thị form Sửa
    public function edit()
    {
        $this->checkAdmin();
        $id = $_GET['id'];
        $course_id = $_GET['course_id']; // Lấy để nút Hủy biết đường quay lại

        $lessonModel = new Lesson();
        $lesson = $lessonModel->getById($id);

        if ($lesson) {
            require __DIR__ . '/../views/instructor/lessons/edit.php';
        } else {
            echo "Bài học không tồn tại!";
        }
    }

    // [MỚI] Xử lý Lưu cập nhật
    public function update()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $courseId = $_POST['course_id'];
            $title = $_POST['title'];
            $videoUrl = $_POST['video_url'];

            $lessonModel = new Lesson();
            $lessonModel->update($id, $title, $videoUrl);

            // Sửa xong quay lại trang chi tiết khóa học
            header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/$courseId");
        }
    }

    // Xóa bài
    public function delete()
    {
        $this->checkAdmin();
        $lesson = new Lesson();
        $lesson->delete($_GET['id']);
        header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/" . $_GET['course_id']);
    }
}
?>