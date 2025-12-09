<?php
class CourseController
{

    // SỬA LẠI HÀM INDEX
    public function index()
    {
        $courseModel = new Course();

        // Kiểm tra xem trên URL có tham số ?keyword=... không
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            // Gọi hàm tìm kiếm vừa viết ở Model
            $courses = $courseModel->search($keyword);
        } else {
            // Nếu không tìm kiếm thì lấy tất cả
            $courses = $courseModel->getAll();
        }

        // Gửi dữ liệu sang View
        require ROOT_PATH . '/views/courses/index.php';
    }

    // --- (Hàm detail giữ nguyên) ---
    public function detail($id)
    {
        // ... (Code cũ của bạn) ...
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
    // Thêm vào trong class CourseController

    // 1. Hiển thị Form tạo khóa học
    public function create()
    {
        require ROOT_PATH . '/views/courses/create.php';
    }

    // 2. Xử lý lưu khóa học + Upload ảnh
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            // --- PHẦN CỦA LẬP TRÌNH VIÊN D: XỬ LÝ UPLOAD FILE ---
            $image = ""; // Tên file mặc định nếu không upload

            // Kiểm tra xem có file gửi lên không
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = ROOT_PATH . "/assets/uploads/courses/";

                // Tạo tên file mới để tránh trùng (time + tên gốc)
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;

                // Kiểm tra đuôi file (chỉ cho phép ảnh)
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

                if (in_array($fileType, $allowTypes)) {
                    // Upload file lên server
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $image = $fileName; // Lưu tên file để đưa vào DB
                    } else {
                        echo "Lỗi: Không thể upload file.";
                    }
                } else {
                    echo "Lỗi: Chỉ chấp nhận file ảnh (JPG, PNG, JPEG, GIF).";
                }
            }
            // ----------------------------------------------------

            // Lưu vào Database (Gọi Model)
            // Lưu ý: Cần thêm hàm create() trong Model Course
            $courseModel = new Course();
            // Tạm thời gọi hàm insert (bạn cần bổ sung hàm này vào Model Course sau)
            // $courseModel->create($title, $description, $price, $image);

            // Demo thành công
            echo "Upload ảnh thành công! Tên file: " . $image;
            echo "<br>Tiêu đề: " . $title;
            echo "<br><a href='/BTTH02_CNWeb/onlinecourse/courses'>Quay lại</a>";
        }
    }
}
?>