<?php
require_once '/models/Course.php';
require_once '/models/Lesson.php';

class CourseController
{
    // Kiểm tra quyền Admin
    private function checkAdmin()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo "<script>alert('Bạn không có quyền truy cập!'); window.location.href='/BTTH02_CNWeb/onlinecourse/';</script>";
            exit;
        }
    }

    public function index()
    {
        $courseModel = new Course();
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $courses = $keyword ? $courseModel->search($keyword) : $courseModel->getAll();
        require '/views/courses/index.php';
    }

    public function detail($id)
    {
        $courseModel = new Course();
        $course = $courseModel->getById($id);

        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourseId($id);

        if ($course)
            require '/views/courses/detail.php';
        else
            echo "Khóa học không tồn tại!";
    }

    // --- CÁC HÀM ADMIN ---

    public function create()
    {
        $this->checkAdmin();
        require '/views/courses/create.php';
    }

    public function store()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = 'default.jpg';
            if (!empty($_FILES['image']['name'])) {
                $target = "/assets/uploads/courses/" . time() . "_" . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $image = time() . "_" . basename($_FILES['image']['name']);
                }
            }

            $course = new Course();
            $course->create($_POST['title'], $_POST['description'], $_POST['price'], $image);
            header("Location: /BTTH02_CNWeb/onlinecourse/courses");
        }
    }

    public function edit()
    {
        $this->checkAdmin();
        $id = $_GET['id'];
        $courseModel = new Course();
        $course = $courseModel->getById($id);
        require '/views/courses/edit.php';
    }

    public function update()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_POST['old_image'];
            if (!empty($_FILES['image']['name'])) {
                $target = "/assets/uploads/courses/" . time() . "_" . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $image = time() . "_" . basename($_FILES['image']['name']);
                }
            }

            $course = new Course();
            $course->update($_POST['id'], $_POST['title'], $_POST['description'], $_POST['price'], $image);
            header("Location: /BTTH02_CNWeb/onlinecourse/courses");
        }
    }

    public function delete()
    {
        $this->checkAdmin();
        $id = $_GET['id'];
        $course = new Course();
        $course->delete($id);
        header("Location: /BTTH02_CNWeb/onlinecourse/courses");
    }
}
?>