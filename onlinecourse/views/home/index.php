<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">

    <div style="text-align: center; margin-bottom: 40px; padding: 30px 0; border-bottom: 1px solid #eee;">
        <h1>Chào mừng bạn đến với Online Course</h1>
        <p>Tìm khóa học yêu thích để bắt đầu ngay hôm nay</p>

        <form action="/BTTH02_CNWeb/onlinecourse/courses" method="GET" style="margin-top: 20px;">

            <input type="text" name="keyword" placeholder="Nhập tên khóa học (ví dụ: PHP)..." required
                style="padding: 12px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">

            <button type="submit"
                style="padding: 12px 25px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Tìm kiếm
            </button>
        </form>

        <h2 style="margin-bottom: 20px;">Khóa học mới nhất</h2>

        <div class="course-list" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="course-item" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                        <img src="/BTTH02_CNWeb/onlinecourse/assets/uploads/courses/<?php echo $course['image']; ?>"
                            style="width: 100%; height: 180px; object-fit: cover;">

                        <div style="padding: 15px;">
                            <h3 style="margin-top: 0;"><?php echo $course['title']; ?></h3>
                            <p style="color: red; font-weight: bold;"><?php echo number_format($course['price']); ?> VNĐ</p>

                            <a href="/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $course['id']; ?>"
                                style="display: inline-block; padding: 8px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có khóa học nào được hiển thị.</p>
            <?php endif; ?>
        </div>

    </div>

    <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>