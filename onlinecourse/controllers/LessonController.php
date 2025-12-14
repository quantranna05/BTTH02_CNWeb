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
    public function upload()
    {
        //Kiểm tra ID bài học
        if (!isset($_GET['id'])) {
            header('Location: index.php?controller=lesson&action=index');
            exit;
        }
        $lesson_id = $_GET['id'];

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $lesson_id = $_POST['lesson_id'];
            $display_name = $_POST['filename'];

            // đường dẫn lưu file
            $target_dir = "assets/uploads/materials/";
            // kiểm tra và tạo thư mục nếu chưa tồn tại
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_name = basename($_FILES["file_upload"]["name"]);
            $file_size = $_FILES["file_upload"]["size"];
            $file_tmp = $_FILES["file_upload"]["tmp_name"];
            $file_type_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // 1. Validate định dạng file (Security)
            $allowed_types = array("pdf", "doc", "docx", "ppt", "pptx", "zip");

            // 2. Validate kích thước (ví dụ: max 20MB)
            $max_size = 20 * 1024 * 1024;

            if (!in_array($file_type_ext, $allowed_types)) {
                $error = "Chỉ chấp nhận file PDF, Word, PowerPoint hoặc ZIP.";
            } elseif ($file_size > $max_size) {
                $error = "File quá lớn. Vui lòng upload file dưới 20MB.";
            } else {
                // 3. Tạo tên file mới để tránh trùng lặp (timestamp_tenfile)
                $new_file_name = time() . '_' . $file_name;
                $target_file = $target_dir . $new_file_name;

                // 4. Di chuyển file từ bộ nhớ tạm vào thư mục đích
                if (move_uploaded_file($file_tmp, $target_file)) {
                    // Nếu người dùng không nhập tên hiển thị, lấy tên file gốc
                    if (empty($display_name)) {
                        $display_name = $file_name;
                    }

                    // 5. Lưu vào Database thông qua Model
                    $materialModel = new Material();
                    // Gọi hàm insert (cần khớp với cấu trúc bảng materials: id, lesson_id, filename, file_path, file_type, uploaded_at)
                    if ($materialModel->create($lesson_id, $display_name, $target_file, $file_type_ext)) {
                        $success = "Upload tài liệu thành công!";
                    } else {
                        $error = "Lỗi khi lưu vào cơ sở dữ liệu.";
                    }
                } else {
                    $error = "Đã xảy ra lỗi khi tải file lên server.";
                }
            }
        }

        // Load view
        require_once 'views/instructor/materials/upload.php';
    }
}
?>