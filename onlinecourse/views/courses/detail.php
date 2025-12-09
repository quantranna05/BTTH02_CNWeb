<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 30px;">
    <div class="row" style="display: flex; gap: 30px;">

        <div class="left" style="flex: 1;">
            <img src="/BTTH02_CNWeb/onlinecourse/assets/uploads/courses/<?php echo $course['image']; ?>"
                style="width: 100%; border-radius: 5px;">

            <h2><?php echo $course['title']; ?></h2>
            <h3 style="color: red;"><?php echo number_format($course['price']); ?> VNĐ</h3>

            <div class="enroll-area" style="margin-top: 20px;">

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="/BTTH02_CNWeb/onlinecourse/enrollment/store" method="POST">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">

                        <button type="submit" onclick="return confirm('Xác nhận đăng ký khóa học này?')"
                            style="width: 100%; padding: 15px; background: #28a745; color: white; border: none; font-size: 16px; font-weight: bold; border-radius: 5px; cursor: pointer;">
                            ĐĂNG KÝ HỌC NGAY
                        </button>
                    </form>

                <?php else: ?>
                    <a href="/BTTH02_CNWeb/onlinecourse/auth/login"
                        style="display: block; text-align: center; width: 100%; padding: 15px; background: #ffc107; color: #333; text-decoration: none; font-size: 16px; font-weight: bold; border-radius: 5px;">
                        ĐĂNG NHẬP ĐỂ ĐĂNG KÝ
                    </a>
                <?php endif; ?>

            </div>
        </div>

        <div class="right" style="flex: 2;">
            <h3>Giới thiệu</h3>
            <p><?php echo nl2br($course['description']); ?></p>
            <hr>
            <h3>Nội dung bài học</h3>

            <ul style="list-style: none; padding: 0;">
                <?php if (!empty($lessons)): ?>
                    <?php foreach ($lessons as $index => $lesson): ?>
                        <li style="padding: 10px; border-bottom: 1px solid #ddd; background: #f9f9f9; margin-bottom: 5px;">
                            <strong>Bài <?php echo $index + 1; ?>:</strong>
                            <?php echo $lesson['title']; ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có bài học nào.</p>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>