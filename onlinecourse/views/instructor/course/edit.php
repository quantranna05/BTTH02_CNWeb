<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container"
    style="display: flex; justify-content: center; align-items: center; padding: 40px 20px; min-height: 85vh;">
    <div class="auth-container"
        style="width: 100%; max-width: 700px; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">

        <h2
            style="text-align: center; color: #ffc107; margin-bottom: 30px; text-transform: uppercase; font-size: 24px;">
            <i class="fas fa-edit"></i> Cập nhật Khóa học
        </h2>

        <form action="index.php?url=courses/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
            <input type="hidden" name="old_image" value="<?php echo $course['image']; ?>">

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Tên khóa học:</label>
                <input type="text" name="title" class="form-control"
                    value="<?php echo htmlspecialchars($course['title']); ?>" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Giá (VNĐ):</label>
                <input type="number" name="price" class="form-control" value="<?php echo $course['price']; ?>" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Mô tả:</label>
                <textarea name="description" class="form-control" rows="5" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; resize: vertical;"><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 30px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Hình ảnh:</label>

                <div
                    style="display: flex; gap: 20px; align-items: flex-start; border: 2px dashed #ddd; padding: 15px; border-radius: 8px; background: #f9f9f9;">
                    <div style="text-align: center;">
                        <span style="font-size: 12px; color: #666; display: block; margin-bottom: 5px;">Ảnh hiện
                            tại</span>
                        <img src="assets/uploads/courses/<?php echo $course['image']; ?>"
                            style="width: 120px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc;">
                    </div>

                    <div style="flex: 1;">
                        <span style="font-size: 12px; color: #666; display: block; margin-bottom: 5px;">Chọn ảnh mới
                            (nếu muốn đổi)</span>
                        <input type="file" name="image" id="imgInput" class="form-control" style="width: 100%;">

                        <div id="previewContainer" style="display: none; margin-top: 10px;">
                            <span style="font-size: 12px; color: #28a745; font-weight: bold;">Ảnh mới:</span><br>
                            <img id="preview" src="#"
                                style="max-width: 100%; height: 100px; object-fit: cover; border-radius: 6px; margin-top: 5px; border: 1px solid #28a745;">
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn-primary"
                    style="background: #ffc107; color: black; padding: 12px 40px; border: none; border-radius: 30px; cursor: pointer; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px rgba(255, 193, 7, 0.3); transition: 0.3s; width: 100%;">
                    <i class="fas fa-save"></i> LƯU THAY ĐỔI
                </button>

                <div style="margin-top: 20px;">
                    <a href="index.php?url=courses" style="color: #666; text-decoration: none; font-size: 14px;">
                        <i class="fas fa-arrow-left"></i> Hủy bỏ
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const imgInput = document.getElementById('imgInput');
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('previewContainer');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            preview.src = URL.createObjectURL(file);
            previewContainer.style.display = 'block';
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>

<?php include __DIR__ . '/../../layouts/footer.php' ?>