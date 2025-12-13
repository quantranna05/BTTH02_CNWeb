<?php include '/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 50px;">
    <div class="auth-container" style="max-width: 800px;">
        <h2 style="text-align: center; color: #ffc107;">Cập nhật Khóa học</h2>

        <form action="/BTTH02_CNWeb/onlinecourse/courses/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
            <input type="hidden" name="old_image" value="<?php echo $course['image']; ?>">

            <div class="form-group">
                <label>Tên khóa học</label>
                <input type="text" name="title" class="form-control"
                    value="<?php echo htmlspecialchars($course['title']); ?>" required>
            </div>

            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" class="form-control" rows="5"
                    required><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Giá (VNĐ)</label>
                <input type="number" name="price" class="form-control" value="<?php echo $course['price']; ?>" required>
            </div>

            <div class="form-group">
                <label>Ảnh hiện tại</label><br>
                <img src="/BTTH02_CNWeb/onlinecourse/assets/uploads/courses/<?php echo $course['image']; ?>"
                    width="100"><br>
                <label>Chọn ảnh mới (nếu muốn đổi)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn-primary" style="background: #ffc107; color: black;">Lưu thay đổi</button>
            <a href="/BTTH02_CNWeb/onlinecourse/courses"
                style="display: block; text-align: center; margin-top: 15px;">Hủy bỏ</a>
        </form>
    </div>
</div>

<?php include '/views/layouts/footer.php'; ?>