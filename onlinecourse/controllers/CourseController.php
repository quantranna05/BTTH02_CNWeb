<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Enrollment.php';

class CourseController
{
    // Kiểm tra quyền Admin
    private function checkAdmin()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo "<script>alert('Bạn không có quyền!'); window.location.href='/BTTH02_CNWeb/onlinecourse/';</script>";
            exit;
        }
    }
    public function home()
    {
        $courseModel = new Course();

        // Lấy 3-4 khóa học nổi bật để hiện ở trang chủ (nếu có hàm getFeatured)
        // Nếu chưa có hàm getFeatured thì dùng tạm getAll()
        if (method_exists($courseModel, 'getFeatured')) {
            $featuredCourses = $courseModel->getFeatured(3);
        } else {
            $featuredCourses = $courseModel->getAll();
        }

        // Gọi view trang chủ
        require __DIR__ . '/../views/home/index.php';
    }
    public function index()
    {
        $courseModel = new Course();
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        if ($keyword) {
            $courses = $courseModel->search($keyword);
        } else {
            $courses = $courseModel->getAll();
        }
        require __DIR__ . '/../views/courses/index.php';
    }

    public function detail()
    {
        // Lấy ID từ URL (do Router xử lý nên ID thường nằm trong $_GET['id'] hoặc params)
        // Với cấu trúc router trên, ta dùng $_GET từ query string nếu URL dạng ?id=1 hoặc xử lý thủ công
        // Để đơn giản với router hiện tại, ta lấy $_GET['id'] nếu dùng rewrite dạng courses/detail?id=1
        // Hoặc lấy từ URL segment thứ 3. Ở đây ta dùng cách đơn giản nhất khớp với view của bạn:

        $id = isset($_GET['id']) ? $_GET['id'] : (isset($_GET['url']) ? explode('/', $_GET['url'])[2] ?? null : null);

        if (!$id) {
            echo "Thiếu ID khóa học!";
            return;
        }

        $courseModel = new Course();
        $course = $courseModel->getById($id);

        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourseId($id);

        // Logic kiểm tra đăng ký
        $isEnrolled = false;
        $currentProgress = 0;

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

    // --- ADMIN CRUD ---

    public function create()
    {
        $this->checkAdmin();
        require __DIR__ . '/../views/instructor/course/create.php';
    }

    public function store()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = 'default.jpg';
            if (!empty($_FILES['image']['name'])) {
                $target = __DIR__ . "/../assets/uploads/courses/" . time() . "_" . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $image = time() . "_" . basename($_FILES['image']['name']);
                }
            }
            $course = new Course();
            $course->create($_POST['title'], $_POST['description'], $_POST['price'], $image);

            // [QUAN TRỌNG] Chuyển hướng đúng về danh sách
            header("Location: /BTTH02_CNWeb/onlinecourse/courses");
        }
    }

    public function edit()
    {
        $this->checkAdmin();
        $id = $_GET['id'];
        $courseModel = new Course();
        $course = $courseModel->getById($id);
        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    public function update()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_POST['old_image'];
            if (!empty($_FILES['image']['name'])) {
                $target = __DIR__ . "/../assets/uploads/courses/" . time() . "_" . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $image = time() . "_" . basename($_FILES['image']['name']);
                }
            }
            $course = new Course();
            $course->update($_POST['id'], $_POST['title'], $_POST['description'], $_POST['price'], $image);

            // [QUAN TRỌNG] Chuyển hướng đúng
            header("Location: /BTTH02_CNWeb/onlinecourse/courses");
        }
    }

    public function delete()
    {
        $this->checkAdmin();
        $id = $_GET['id'];
        $course = new Course();
        $course->delete($id);

        // [QUAN TRỌNG] Chuyển hướng đúng
        header("Location: /BTTH02_CNWeb/onlinecourse/courses");
    }
}
?>