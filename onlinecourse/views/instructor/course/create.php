<?php include '/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 50px;">
    <div class="auth-container" style="max-width: 600px;">
        <h2 style="text-align: center; color: #28a745;">Thêm Bài Học Mới</h2>

        <form action="/BTTH02_CNWeb/onlinecourse/lessons/store" method="POST">
            <input type="hidden" name="course_id" value="<?php echo $_GET['course_id']; ?>">

            <div class="form-group">
                <label>Tiêu đề bài học</label>
                <input type="text" name="title" class="form-control" placeholder="VD: Bài 1 - Giới thiệu" required>
            </div>

            <div class="form-group">
                <label>Link Video (Youtube/Drive)</label>
                <input type="text" name="video_url" class="form-control" placeholder="URL Video">
            </div>

            <button type="submit" class="btn-primary" style="background: #28a745;">Thêm bài học</button>
            <a href="/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $_GET['course_id']; ?>"
                style="display: block; text-align: center; margin-top: 15px;">Quay lại</a>
        </form>
    </div>
</div>

<?php include '/views/layouts/footer.php'; ?>