<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<?php
// --- KHỐI XỬ LÝ LOGIC NGAY TẠI VIEW (Để đảm bảo tính độc lập) ---

// 1. Kiểm tra trạng thái Đăng ký & Tiến độ
$isEnrolled = false;
$currentProgress = 0;

if (isset($_SESSION['user_id'])) {
    // Gọi Model Enrollment để kiểm tra
    $enrollmentModel = new Enrollment();
    $studentId = $_SESSION['user_id'];
    $courseId = $course['id'];

    // Kiểm tra đã đăng ký chưa?
    if ($enrollmentModel->isEnrolled($studentId, $courseId)) {
        $isEnrolled = true;
        // Nếu đã đăng ký -> Lấy % tiến độ hiện tại
        $currentProgress = $enrollmentModel->getProgress($studentId, $courseId);
    }
}

// 2. Xử lý hiển thị Ảnh (Tránh lỗi ảnh vỡ)
$uploadDir = 'assets/uploads/courses/';
$imageName = $course['image'] ?? '';
$physicalPath = ROOT_PATH . '/' . $uploadDir . $imageName;
$baseUrl = '/BTTH02_CNWeb/onlinecourse/'; // Sửa lại nếu tên thư mục của bạn khác

if (!empty($imageName) && file_exists($physicalPath)) {
    $imageSrc = $baseUrl . $uploadDir . $imageName;
} else {
    // Ảnh mặc định nếu không tìm thấy file
    $imageSrc = "https://via.placeholder.com/800x450.png?text=Course+Image";
}
?>

<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="row" style="display: flex; gap: 40px; flex-wrap: wrap;">

        <div class="left-column" style="flex: 1; min-width: 300px;">

            <div style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>"
                    style="width: 100%; display: block; object-fit: cover; aspect-ratio: 16/9;">
            </div>

            <h2 style="margin-top: 20px; font-size: 24px; color: #333;"><?php echo $course['title']; ?></h2>

            <p style="color: #d9534f; font-weight: bold; font-size: 20px; margin: 10px 0;">
                Giá: <?php echo number_format($course['price']); ?> VNĐ
            </p>

            <div class="action-area" style="margin-top: 25px;">

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="/BTTH02_CNWeb/onlinecourse/auth/login"
                        style="display: block; text-align: center; background: #ffc107; color: #333; padding: 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                        🔐 ĐĂNG NHẬP ĐỂ HỌC
                    </a>

                <?php elseif ($isEnrolled): ?>
                    <div
                        style="background: #e8f5e9; color: #2e7d32; padding: 15px; text-align: center; border-radius: 5px; border: 1px solid #c8e6c9;">
                        ✅ Bạn đã đăng ký khóa này
                    </div>

                <?php else: ?>
                    <form action="/BTTH02_CNWeb/onlinecourse/enrollment/store" method="POST">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn đăng ký?')"
                            style="width: 100%; background: #28a745; color: white; padding: 15px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px;">
                            📝 ĐĂNG KÝ HỌC NGAY
                        </button>
                    </form>
                <?php endif; ?>

            </div>
        </div>

        <div class="right-column" style="flex: 2; min-width: 300px;">

            <?php if ($isEnrolled): ?>
                <div
                    style="margin-bottom: 30px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <h3 style="margin-top: 0; font-size: 18px;">Tiến độ học tập của bạn</h3>
                    <div
                        style="background: #e9ecef; border-radius: 20px; height: 20px; width: 100%; margin-top: 10px; overflow: hidden;">
                        <div
                            style="width: <?php echo $currentProgress; ?>%; background: linear-gradient(90deg, #007bff, #00c6ff); height: 100%; text-align: center; line-height: 20px; color: white; font-size: 12px; font-weight: bold; transition: width 0.5s;">
                            <?php echo round($currentProgress); ?>%
                        </div>
                    </div>
                    <?php if ($currentProgress >= 100): ?>
                        <p style="color: green; margin-top: 10px; font-weight: bold;">🎉 Chúc mừng! Bạn đã hoàn thành khóa học
                            này.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div style="margin-bottom: 30px;">
                <h3 style="border-bottom: 2px solid #007bff; display: inline-block; padding-bottom: 5px;">Giới thiệu
                </h3>
                <div style="line-height: 1.6; color: #555; margin-top: 10px;">
                    <?php echo nl2br($course['description']); ?>
                </div>
            </div>

            <div>
                <h3 style="border-bottom: 2px solid #007bff; display: inline-block; padding-bottom: 5px;">Nội dung bài
                    học</h3>

                <ul style="list-style: none; padding: 0; margin-top: 15px;">
                    <?php if (!empty($lessons)): ?>
                        <?php foreach ($lessons as $index => $lesson): ?>
                            <li
                                style="background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">

                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span
                                        style="background: #eee; color: #555; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; font-size: 14px;">
                                        <?php echo $index + 1; ?>
                                    </span>
                                    <span style="font-weight: 500; font-size: 16px;">
                                        <?php echo $lesson['title']; ?>
                                    </span>
                                </div>

                                <?php if ($isEnrolled): ?>
                                    <?php if ($currentProgress < 100): ?>
                                        <form action="/BTTH02_CNWeb/onlinecourse/enrollment/completeLesson" method="POST"
                                            style="margin: 0;">
                                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                            <button type="submit"
                                                style="background: #17a2b8; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; transition: 0.2s;">
                                                ✅ Hoàn thành
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: green; font-weight: bold;">✔</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 12px;">🔒 Đăng ký để học</span>
                                <?php endif; ?>

                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #777; font-style: italic;">Chưa có bài học nào được cập nhật.</p>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>