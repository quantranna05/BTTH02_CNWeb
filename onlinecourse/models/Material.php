<?php
require_once 'config/Database.php';

class Material
{
    private $conn;
    private $table = 'materials';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Hàm thêm mới tài liệu
    public function create($lesson_id, $filename, $file_path, $file_type)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (lesson_id, filename, file_path, file_type, uploaded_at) 
                  VALUES (:lesson_id, :filename, :file_path, :file_type, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':file_path', $file_path);
        $stmt->bindParam(':file_type', $file_type);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function getByLessonId($lesson_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE lesson_id = :lesson_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function upload()
    {

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $lesson_id = $_POST['lesson_id'];
            $display_name = $_POST['filename'];

            $target_dir = "assets/uploads/materials/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_name = basename($_FILES["file_upload"]["name"]);
            $file_size = $_FILES["file_upload"]["size"];
            $file_tmp = $_FILES["file_upload"]["tmp_name"];
            $file_type_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));


            $allowed_types = array("pdf", "doc", "docx", "ppt", "pptx", "zip");


            $max_size = 20 * 1024 * 1024;

            if (!in_array($file_type_ext, $allowed_types)) {
                $error = "Chỉ chấp nhận file PDF, Word, PowerPoint hoặc ZIP.";
            } elseif ($file_size > $max_size) {
                $error = "File quá lớn. Vui lòng upload file dưới 20MB.";
            } else {
                $new_file_name = time() . '_' . $file_name;
                $target_file = $target_dir . $new_file_name;


                if (move_uploaded_file($file_tmp, $target_file)) {
                    if (empty($display_name)) {
                        $display_name = $file_name;
                    }
                    $materialModel = new Material();
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
        require_once 'views/instructor/materials/upload.php';
    }
}
?>