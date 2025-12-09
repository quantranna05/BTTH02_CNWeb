<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 600px; margin-top: 40px; margin-bottom: 40px;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Thêm Khóa Học Mới</h2>

        <form action="/BTTH02_CNWeb/onlinecourse/courses/store" method="POST" enctype="multipart/form-data">

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Tên khóa học:</label>
                <input type="text" name="title" class="form-control" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Giá tiền (VNĐ):</label>
                <input type="number" name="price" class="form-control" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Mô tả chi tiết:</label>
                <textarea name="description" class="form-control" rows="4"
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Ảnh đại diện:</label>
                <input type="file" name="image" class="form-control" id="imgInput" accept="image/*" required
                    style="margin-top: 5px;">

                <div style="margin-top: 15px; text-align: center;">
                    <img id="preview" src="#" alt="Ảnh xem trước sẽ hiện ở đây"
                        style="max-width: 100%; height: 200px; display: none; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary"
                style="width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;">
                Lưu Khóa Học
            </button>
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