<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container" style="margin-top: 50px;">
    <div class="auth-container"
        style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #28a745;">Thêm Bài Học Mới</h2>

        <form action="/BTTH02_CNWeb/onlinecourse/lessons/store" method="POST">
            <input type="hidden" name="course_id" value="<?php echo $_GET['course_id']; ?>">

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Tiêu đề bài học</label>
                <input type="text" name="title" class="form-control" placeholder="VD: Bài 1 - Giới thiệu" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Link Video (Youtube/Drive)</label>
                <input type="text" name="video_url" class="form-control" placeholder="URL Video"
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <button type="submit" class="btn-primary"
                style="background: #28a745; width: 100%; padding: 10px; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Thêm
                bài học</button>

            <a href="/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $_GET['course_id']; ?>"
                style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">Quay
                lại</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>