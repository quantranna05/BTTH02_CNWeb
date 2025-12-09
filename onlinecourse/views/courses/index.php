<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">

    <h1 style="text-align: center; margin-bottom: 30px; color: #333;">
        <?php
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            echo 'Kết quả tìm kiếm cho: "' . htmlspecialchars($_GET['keyword']) . '"';
        } else {
            echo 'Danh sách khóa học';
        }
        ?>
    </h1>

    <div style="text-align: center; margin-bottom: 40px;">
        <form action="" method="GET">
            <input type="text" name="keyword" placeholder="Tìm khóa học bạn quan tâm..."
                value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">

            <button type="submit"
                style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Tìm kiếm
            </button>

            <?php if (isset($_GET['keyword']) && $_GET['keyword'] != ''): ?>
                <a href="/BTTH02_CNWeb/onlinecourse/courses" style="margin-left: 10px; color: red; text-decoration: none;">
                    Xóa lọc
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="course-list"
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>

                <div class="course-item"
                    ondblclick="window.location.href='/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $course['id']; ?>'"
                    title="Nhấp đúp chuột để xem chi tiết"
                    style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); cursor: pointer; user-select: none; transition: transform 0.2s;">

                    <?php
                    $imgName = $course['image'];
                    $imgPath = 'assets/uploads/courses/' . $imgName;
                    // Kiểm tra file có thật không (Dùng đường dẫn tuyệt đối)
                    if (empty($imgName) || !file_exists(ROOT_PATH . '/' . $imgPath)) {
                        // Ảnh demo nếu lỗi
                        $displayImg = "https://via.placeholder.com/400x250.png?text=Course";
                    } else {
                        $displayImg = "/BTTH02_CNWeb/onlinecourse/" . $imgPath;
                    }
                    ?>

                    <img src="<?php echo $displayImg; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>"
                        style="width: 100%; height: 180px; object-fit: cover;">

                    <div style="padding: 15px;">
                        <h3
                            style="margin-top: 0; font-size: 18px; min-height: 44px; margin-bottom: 10px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?php echo $course['title']; ?>
                        </h3>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #d9534f; font-weight: bold; font-size: 16px;">
                                <?php echo number_format($course['price']); ?> VNĐ
                            </span>
                        </div>

                        <p style="font-size: 12px; color: #999; margin-top: 15px; font-style: italic; text-align: right;">
                            (Nhấp đúp để xem)
                        </p>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #fff; border-radius: 8px;">
                <h3 style="color: #777;">Không tìm thấy khóa học nào phù hợp!</h3>
                <a href="/BTTH02_CNWeb/onlinecourse/courses" style="color: #007bff; text-decoration: none;">Xem tất cả khóa
                    học</a>
            </div>
        <?php endif; ?>
    </div>

</div>

<style>
    .course-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        border-color: #007bff !important;
    }
</style>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>