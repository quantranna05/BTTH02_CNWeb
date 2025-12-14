<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container"
    style="display: flex; justify-content: center; align-items: center; padding: 40px 20px; min-height: 80vh;">
    <div class="auth-container"
        style="width: 100%; max-width: 700px; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">

        <h2
            style="text-align: center; color: #28a745; margin-bottom: 30px; text-transform: uppercase; font-size: 24px;">
            <i class="fas fa-plus-circle"></i> Thêm Khóa Học Mới
        </h2>

        <form action="index.php?url=courses/store" method="POST" enctype="multipart/form-data">

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Tên khóa học:</label>
                <input type="text" name="title" class="form-control" required placeholder="Nhập tên khóa học..."
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Mô tả chi
                    tiết:</label>
                <textarea name="description" class="form-control" rows="5" required
                    placeholder="Mô tả nội dung khóa học..."
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Giá khóa học
                    (VNĐ):</label>
                <input type="number" name="price" class="form-control" required placeholder="Ví dụ: 500000"
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 30px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ảnh đại diện:</label>
                <div
                    style="border: 2px dashed #ccc; padding: 20px; text-align: center; border-radius: 6px; cursor: pointer; background: #f9f9f9;">
                    <input type="file" name="image" class="form-control" style="width: 100%;">
                    <small style="color: #666; display: block; margin-top: 5px;">Hỗ trợ: JPG, PNG, JPEG</small>
                </div>
            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn-primary"
                    style="background: #28a745; color: white; padding: 12px 40px; border: none; border-radius: 30px; cursor: pointer; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px rgba(40, 167, 69, 0.3); transition: 0.3s;">
                    <i class="fas fa-save"></i> TẠO KHÓA HỌC
                </button>

                <div style="margin-top: 20px;">
                    <a href="index.php?url=courses" style="color: #666; text-decoration: none; font-size: 14px;">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>