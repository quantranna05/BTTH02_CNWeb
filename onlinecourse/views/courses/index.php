<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">

    <h1 style="text-align: center; margin-bottom: 30px; color: #333;">
        <?php
        // Nếu đang tìm kiếm thì đổi tiêu đề cho dễ hiểu
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            echo 'Kết quả tìm kiếm cho: "' . htmlspecialchars($_GET['keyword']) . '"';
        } else {
            echo 'Tất cả khóa học';
        }
        ?>
    </h1>

    <div style="text-align: center; margin-bottom: 40px;">
        <form action="" method="GET">
            <input type="text" name="keyword" placeholder="Tìm khóa học khác..."
                value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">

            <button type="submit"
                style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Tìm kiếm
            </button>

            <?php if (isset($_GET['keyword']) && $_GET['keyword'] != ''): ?>
                <a href="/BTTH02_CNWeb/onlinecourse/courses" style="margin-left: 10px; color: red; text-decoration: none;">
                    Xóa bộ lọc
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="course-list" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-item"
                    style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">

                    <img src="/BTTH02_CNWeb/onlinecourse/assets/uploads/courses/<?php echo $course['image']; ?>"
                        style="width: 100%; height: 180px; object-fit: cover;">

                    <div style="padding: 15px;">
                        <h3 style="margin-top: 0; font-size: 18px; min-height: 44px;"><?php echo $course['title']; ?></h3>
                        <p style="color: #d9534f; font-weight: bold;"><?php echo number_format($course['price']); ?> VNĐ</p>

                        <a href="/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $course['id']; ?>"
                            style="display: inline-block; padding: 8px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                <h3 style="color: #777;">Không tìm thấy khóa học nào phù hợp!</h3>
                <a href="/BTTH02_CNWeb/onlinecourse/courses">Xem tất cả khóa học</a>
            </div>
        <?php endif; ?>
    </div>

</div><?php include ROOT_PATH . '/views/layouts/footer.php'; ?>