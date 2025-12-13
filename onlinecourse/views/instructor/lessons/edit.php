<?php
// SỬA LỖI: Đường dẫn chỉ cần lùi 2 cấp là ra tới thư mục views, nên không cần thêm chữ /views nữa
include __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="margin-top: 50px;">
    <div class="auth-container"
        style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #ffc107;">✏️ Chỉnh Sửa Bài Học</h2>

        <form action="/BTTH02_CNWeb/onlinecourse/lessons/update" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($lesson['id']) ? $lesson['id'] : ''; ?>">
            <input type="hidden" name="course_id" value="<?php echo isset($course_id) ? $course_id : ''; ?>">

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Tiêu đề bài học</label>
                <input type="text" name="title" class="form-control"
                    value="<?php echo isset($lesson['title']) ? htmlspecialchars($lesson['title']) : ''; ?>" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Link Video (Youtube/Drive)</label>
                <input type="text" name="video_url" class="form-control"
                    value="<?php echo isset($lesson['video_url']) ? htmlspecialchars($lesson['video_url']) : ''; ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <button type="submit" class="btn-primary"
                style="background: #ffc107; color: black; width: 100%; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 16px;">
                Lưu Thay Đổi
            </button>

            <?php
            // Link quay lại
            $backLink = isset($course_id) ? "/BTTH02_CNWeb/onlinecourse/courses/detail/" . $course_id : "/BTTH02_CNWeb/onlinecourse/courses";
            ?>
            <a href="<?php echo $backLink; ?>"
                style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">
                Hủy bỏ
            </a>
        </form>
    </div>
</div>

<?php
// SỬA LỖI: Tương tự header, sửa đường dẫn footer
include __DIR__ . '/../../layouts/footer.php';
?>