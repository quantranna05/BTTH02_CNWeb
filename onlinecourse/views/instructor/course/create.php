<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 700px; margin: 40px auto; padding: 20px;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
        
        <h2 style="text-align: center; margin-bottom: 25px;">➕ Tạo khóa học mới</h2>

        <form action="/BTTH02_CNWeb/onlinecourse/courses/store" method="POST" enctype="multipart/form-data">

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Tên khóa học: <span style="color: red;">*</span></label>
                <input type="text" name="title" required placeholder="Ví dụ: Lập trình PHP từ cơ bản"
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Giá tiền (VNĐ): <span style="color: red;">*</span></label>
                <input type="number" name="price" required value="0" min="0"
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="font-weight: bold; display: block; margin-bottom: 8px;">Thời lượng (tuần):</label>
                    <input type="number" name="duration_weeks" value="4" min="1"
                           style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <div style="flex: 1;">
                    <label style="font-weight: bold; display: block; margin-bottom: 8px;">Cấp độ:</label>
                    <select name="level" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
                        <option value="Beginner">Cơ bản</option>
                        <option value="Intermediate">Trung cấp</option>
                        <option value="Advanced">Nâng cao</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Danh mục:</label>
                <select name="category_id" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="1">Lập trình Web</option>
                    <option value="2">Khoa học dữ liệu</option>
                    <option value="3">Thiết kế đồ họa</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Mô tả:</label>
                <textarea name="description" rows="5" placeholder="Mô tả về nội dung khóa học..."
                          style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Ảnh đại diện: <span style="color: red;">*</span></label>
                <input type="file" name="image" id="imgInput" accept="image/*" required
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                
                <div style="margin-top: 15px; text-align: center;">
                    <img id="preview" src="#" 
                         style="max-width: 100%; height: 200px; display: none; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <a href="/BTTH02_CNWeb/onlinecourse/courses/my_courses" 
                   style="flex: 1; text-align: center; padding: 14px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    ← Hủy
                </a>
                <button type="submit" 
                        style="flex: 2; padding: 14px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                    💾 Tạo khóa học
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const imgInput = document.getElementById('imgInput');
const preview = document.getElementById('preview');

imgInput.onchange = evt => {
    const [file] = imgInput.files;
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}
</script>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>