<?php
class CourseController
{
    // ========== GIỮ NGUYÊN CÁC HÀM CŨ ==========
    
    public function index()
    {
        $courseModel = new Course();

        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $courses = $courseModel->search($keyword);
        } else {
            $courses = $courseModel->getAll();
        }

        require ROOT_PATH . '/views/courses/index.php';
    }

    public function detail($id)
    {
        if (!$id)
            die("ID không hợp lệ.");
        $courseModel = new Course();
        $course = $courseModel->getById($id);

        if (!$course)
            die("Không tìm thấy khóa học.");

        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourseId($id);

        require ROOT_PATH . '/views/courses/detail.php';
    }

    // ========== PHẦN MỚI - LẬP TRÌNH VIÊN B ==========

    // Xem khóa học của tôi
    public function my_courses()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /BTTH02_CNWeb/onlinecourse/auth/login");
            exit();
        }

        $courseModel = new Course();
        $courses = $courseModel->getByInstructor($_SESSION['user_id']);

        require ROOT_PATH . '/views/instructor/my_courses.php';
    }

    // Hiển thị form tạo khóa học
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /BTTH02_CNWeb/onlinecourse/auth/login");
            exit();
        }

        require ROOT_PATH . '/views/instructor/course/create.php';
    }

    // Xử lý tạo khóa học
    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='/BTTH02_CNWeb/onlinecourse/auth/login';</script>";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $duration_weeks = intval($_POST['duration_weeks'] ?? 4);
            $level = $_POST['level'] ?? 'Beginner';
            $category_id = intval($_POST['category_id'] ?? 1);

            // Upload ảnh
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = ROOT_PATH . "/assets/uploads/courses/";

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $image = $fileName;
                    } else {
                        echo "<script>alert('Lỗi upload ảnh!'); window.history.back();</script>";
                        exit();
                    }
                } else {
                    echo "<script>alert('Chỉ chấp nhận file ảnh!'); window.history.back();</script>";
                    exit();
                }
            }

            // Lưu vào database
            $courseModel = new Course();
            $courseModel->title = $title;
            $courseModel->description = $description;
            $courseModel->instructor_id = $_SESSION['user_id'];
            $courseModel->image = $image;
            $courseModel->price = $price;
            $courseModel->duration_weeks = $duration_weeks;
            $courseModel->level = $level;
            $courseModel->category_id = $category_id;

            if ($courseModel->create()) {
                echo "<script>alert('Tạo khóa học thành công!'); window.location.href='/BTTH02_CNWeb/onlinecourse/courses/my_courses';</script>";
            } else {
                echo "<script>alert('Tạo thất bại!'); window.history.back();</script>";
            }
        }
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /BTTH02_CNWeb/onlinecourse/auth/login");
            exit();
        }

        $courseModel = new Course();
        $course = $courseModel->getById($id);

        if (!$course || $course['instructor_id'] != $_SESSION['user_id']) {
            die("Không có quyền chỉnh sửa.");
        }

        require ROOT_PATH . '/views/instructor/course/edit.php';
    }

    // Xử lý cập nhật
    public function update($id)
    {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập!'); window.history.back();</script>";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $courseModel = new Course();
            $course = $courseModel->getById($id);

            if (!$course || $course['instructor_id'] != $_SESSION['user_id']) {
                die("Không có quyền chỉnh sửa.");
            }

            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $duration_weeks = intval($_POST['duration_weeks'] ?? 4);
            $level = $_POST['level'] ?? 'Beginner';
            $image = $course['image'];

            // Upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = ROOT_PATH . "/assets/uploads/courses/";
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        if (!empty($course['image']) && file_exists($targetDir . $course['image'])) {
                            unlink($targetDir . $course['image']);
                        }
                        $image = $fileName;
                    }
                }
            }

            $courseModel->id = $id;
            $courseModel->title = $title;
            $courseModel->description = $description;
            $courseModel->image = $image;
            $courseModel->price = $price;
            $courseModel->duration_weeks = $duration_weeks;
            $courseModel->level = $level;

            if ($courseModel->update()) {
                echo "<script>alert('Cập nhật thành công!'); window.location.href='/BTTH02_CNWeb/onlinecourse/courses/my_courses';</script>";
            } else {
                echo "<script>alert('Cập nhật thất bại!'); window.history.back();</script>";
            }
        }
    }

    // Xóa khóa học
    public function delete($id)
    {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập!'); window.history.back();</script>";
            exit();
        }

        $courseModel = new Course();
        $course = $courseModel->getById($id);

        if (!$course || $course['instructor_id'] != $_SESSION['user_id']) {
            echo "<script>alert('Không có quyền xóa!'); window.history.back();</script>";
            exit();
        }

        if ($courseModel->delete($id)) {
            if (!empty($course['image'])) {
                $imagePath = ROOT_PATH . "/assets/uploads/courses/" . $course['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            echo "<script>alert('Đã xóa khóa học!'); window.location.href='/BTTH02_CNWeb/onlinecourse/courses/my_courses';</script>";
        } else {
            echo "<script>alert('Xóa thất bại!'); window.history.back();</script>";
        }
    }
}
?>