<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Enrollment.php';

class CourseController
{
    // [ĐÃ SỬA] Hàm check quyền: Cho phép Admin(1) HOẶC Giảng viên(2)
    private function checkPermission()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $role = $_SESSION['role'] ?? 0;

        if ($role != 1) {
            echo "<script>alert('Bạn không có quyền thực hiện thao tác này!'); window.location.href='index.php';</script>";
            exit;
        }
    }

    // --- 1. HÀM CHO TRANG CHỦ ---
    public function home()
    {
        $courseModel = new Course();
        $courses = $courseModel->getAll();
        require __DIR__ . '/../views/home/index.php';
    }

    // --- 2. HÀM CHO TRANG DANH SÁCH ---
    public function index()
    {
        $courseModel = new Course();
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $courses = $courseModel->getAll(); // Tạm thời get all, sau này bạn bổ sung search
        } else {
            $courses = $courseModel->getAll();
        }
        require __DIR__ . '/../views/courses/index.php';
    }

    // --- 3. CHI TIẾT KHÓA HỌC ---
    public function detail()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : (isset($_GET['url']) ? explode('/', $_GET['url'])[2] ?? null : null);

        if (!$id) {
            echo "Thiếu ID khóa học!";
            return;
        }

        $courseModel = new Course();
        $course = $courseModel->getById($id);
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourseId($id);

        $isEnrolled = false;
        $currentProgress = 0;
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (isset($_SESSION['user_id'])) {
            $enrollmentModel = new Enrollment();
            if ($enrollmentModel->isEnrolled($_SESSION['user_id'], $id)) {
                $isEnrolled = true;
                $currentProgress = $enrollmentModel->getProgress($_SESSION['user_id'], $id);
            }
        }

        if ($course) {
            require __DIR__ . '/../views/courses/detail.php';
        } else {
            echo "Khóa học không tồn tại!";
        }
    }

    // --- ADMIN/INSTRUCTOR CRUD ---

    public function create()
    {
        $this->checkPermission();
        // [QUAN TRỌNG] Trỏ đúng vào views/courses/create.php
        require __DIR__ . '/../views/instructor/course/create.php';
    }

    public function store()
    {
        $this->checkPermission();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = 'default.jpg';
            if (!empty($_FILES['image']['name'])) {
                $target_dir = __DIR__ . "/../assets/uploads/courses/";
                if (!file_exists($target_dir))
                    mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa có

                $fileName = time() . "_" . basename($_FILES['image']['name']);
                $target_file = $target_dir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image = $fileName;
                }
            }
            $course = new Course();
            $course->create($_POST['title'], $_POST['description'], $_POST['price'], $image);

            // [QUAN TRỌNG] Chuyển hướng đúng router
            header("Location: index.php?url=courses");
            exit;
        }
    }

    public function edit()
    {
        $this->checkPermission();
        $id = $_GET['id'];
        $courseModel = new Course();
        $course = $courseModel->getById($id);
        // [QUAN TRỌNG] Trỏ đúng vào views/courses/edit.php
        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    public function update()
    {
        $this->checkPermission();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_POST['old_image'];
            if (!empty($_FILES['image']['name'])) {
                $target_dir = __DIR__ . "/../assets/uploads/courses/";
                $fileName = time() . "_" . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $fileName)) {
                    $image = $fileName;
                }
            }
            $course = new Course();
            $course->update($_POST['id'], $_POST['title'], $_POST['description'], $_POST['price'], $image);

            // [QUAN TRỌNG] Chuyển hướng đúng router
            header("Location: index.php?url=courses");
            exit;
        }
    }

    public function delete()
    {
        $this->checkPermission();
        $id = $_GET['id'];
        $course = new Course();
        $course->delete($id);

        // [QUAN TRỌNG] Chuyển hướng đúng router
        header("Location: index.php?url=courses");
        exit;
    }

    public function register($course_id)
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $role = $_SESSION['role'] ?? 0;
        if ($role == 2) {
            echo "<script>alert('Giảng viên không thể đăng ký khóa học!'); window.history.back();</script>";
            exit;
        }
        // Code đăng ký gọi model...
    }
}
?>