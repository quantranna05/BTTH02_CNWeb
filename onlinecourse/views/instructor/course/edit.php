<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 700px; margin: 40px auto; padding: 20px;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
        
        <h2 style="text-align: center; margin-bottom: 25px;">✏️ Chỉnh sửa khóa học</h2>

        <form action="/BTTH02_CNWeb/onlinecourse/courses/update/<?php echo $course['id']; ?>" method="POST" enctype="multipart/form-data">

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Tên khóa học:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Giá tiền (VNĐ):</label>
                <input type="number" name="price" value="<?php echo $course['price']; ?>" required
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Thời lượng (tuần):</label>
                <input type="number" name="duration_weeks" value="<?php echo $course['duration_weeks']; ?>" required
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Cấp độ:</label>
                <select name="level" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="Beginner" <?php echo $course['level'] == 'Beginner' ? 'selected' : ''; ?>>Cơ bản</option>
                    <option value="Intermediate" <?php echo $course['level'] == 'Intermediate' ? 'selected' : ''; ?>>Trung cấp</option>
                    <option value="Advanced" <?php echo $course['level'] == 'Advanced' ? 'selected' : ''; ?>>Nâng cao</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Mô tả:</label>
                <textarea name="description" rows="5" required
                          style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;"><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Ảnh hiện tại:</label>
                
                <?php 
                $imgPath = 'assets/uploads/courses/' . $course['image'];
                if (!empty($course['image']) && file_exists(ROOT_PATH . '/' . $imgPath)) {
                    $displayImg = "/BTTH02_CNWeb/onlinecourse/" . $imgPath;
                } else {
                    $displayImg = "https://via.placeholder.com/400x225.png?text=No+Image";
                }
                ?>
                
                <div style="text-align: center; margin-bottom: 15px;">
                    <img id="currentImage" src="<?php echo $displayImg; ?>" 
                         style="max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Đổi ảnh (tùy chọn):</label>
                <input type="file" name="image" id="imgInput" accept="image/*"
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                
                <div style="margin-top: 15px; text-align: center;">
                    <img id="preview" src="#" 
                         style="max-width: 100%; height: 200px; display: none; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <a href="/BTTH02_CNWeb/onlinecourse/courses/my_courses" 
                   style="flex: 1; text-align: center; padding: 14px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    ← Quay lại
                </a>
                <button type="submit" 
                        style="flex: 2; padding: 14px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                    ✅ Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const imgInput = document.getElementById('imgInput');
const preview = document.getElementById('preview');
const currentImage = document.getElementById('currentImage');

imgInput.onchange = evt => {
    const [file] = imgInput.files;
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        currentImage.style.display = 'none';
    }
}
</script>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>