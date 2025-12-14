<?php
require_once __DIR__ . '/../models/Lesson.php';

class LessonController
{

    // Chỉ cho phép Admin (1) HOẶC Giảng viên (2) đi tiếp
    private function checkPermission()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $role = $_SESSION['role'] ?? 0;

        // Nếu không phải Admin VÀ không phải Giảng viên
        if ($role != 1 && $role != 2) {
            echo "<script>
                    alert('Bạn không có quyền thực hiện thao tác này!'); 
                    window.history.back();
                  </script>";
            exit;
        }
    }

    // 1. Hiện Form Thêm bài học
    public function create()
    {
        $this->checkPermission(); // <--- Check quyền

        // Lấy ID khóa học từ URL
        if (!isset($_GET['course_id'])) {
            die("Lỗi: Thiếu ID khóa học.");
        }
        $course_id = $_GET['course_id'];

        // Gọi view
        require __DIR__ . '/../views/instructor/lessons/create.php';
    }

    // 2. Xử lý Lưu bài học mới
    public function store()
    {
        $this->checkPermission(); // <--- Check quyền

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lesson = new Lesson();
            // Gọi hàm create trong Model (đảm bảo Model Lesson có hàm này)
            $lesson->create($_POST['course_id'], $_POST['title'], $_POST['video_url']);

            // Lưu xong quay về trang chi tiết khóa học
            header("Location: index.php?url=courses/detail/" . $_POST['course_id']);
            exit;
        }
    }

    // 3. Hiện Form Sửa bài học
    public function edit()
    {
        $this->checkPermission(); // <--- Check quyền

        $id = $_GET['id'];
        // Lấy course_id để nếu bấm Hủy thì biết quay về đâu
        $course_id = $_GET['course_id'] ?? 0;

        $lessonModel = new Lesson();
        $lesson = $lessonModel->getById($id);

        if ($lesson) {
            require __DIR__ . '/../views/instructor/lessons/edit.php';
        } else {
            echo "Bài học không tồn tại!";
        }
    }

    // 4. Xử lý Cập nhật bài học
    public function update()
    {
        $this->checkPermission(); // <--- Check quyền

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lessonModel = new Lesson();
            $lessonModel->update($_POST['id'], $_POST['title'], $_POST['video_url']);

            // Quay về trang chi tiết
            header("Location: index.php?url=courses/detail/" . $_POST['course_id']);
            exit;
        }
    }

    // 5. Xử lý Xóa bài học
    public function delete()
    {
        $this->checkPermission(); // <--- Check quyền

        if (isset($_GET['id'])) {
            $lesson = new Lesson();
            $lesson->delete($_GET['id']);

            $course_id = $_GET['course_id'] ?? '';
            header("Location: index.php?url=courses/detail/" . $course_id);
            exit;
        }
    }
}
?>