<?php
// Gọi Header chuẩn
include __DIR__ . '/../../views/layouts/header.php';

// Biến kiểm tra Admin
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] == 1);
?>

<div class="container" style="margin-top: 40px; margin-bottom: 50px;">

    <div style="display: flex; gap: 40px; flex-wrap: wrap;">

        <div style="flex: 1; min-width: 300px;">
            <?php
            $imgName = $course['image'];
            $imgPath = 'assets/uploads/courses/' . $imgName;
            if (!empty($imgName) && file_exists(__DIR__ . '/../../' . $imgPath)) {
                $displayImg = "/BTTH02_CNWeb/onlinecourse/" . $imgPath;
            } else {
                $displayImg = "https://via.placeholder.com/600x400.png?text=No+Image";
            }
            ?>
            <img src="<?php echo $displayImg; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>"
                style="width: 100%; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); object-fit: cover;">
        </div>

        <div style="flex: 1.5; min-width: 300px;">

            <h1 style="color: #333; margin-top: 0; font-size: 28px; line-height: 1.3;">
                <?php echo htmlspecialchars($course['title']); ?>
            </h1>

            <?php if ($isAdmin): ?>
                <div
                    style="margin-bottom: 20px; padding: 10px; background: #fff3cd; border-left: 5px solid #ffc107; border-radius: 4px; display: inline-block;">
                    <strong style="margin-right: 10px; color: #856404;">Admin:</strong>

                    <a href="/BTTH02_CNWeb/onlinecourse/courses/delete?id=<?php echo $course['id']; ?>"
                        onclick="return confirm('CẢNH BÁO: Bạn có chắc muốn xóa khóa học này?\n\nTất cả BÀI HỌC và DỮ LIỆU ĐĂNG KÝ của sinh viên thuộc khóa này sẽ bị xóa vĩnh viễn!')"
                        style="color: #dc3545; text-decoration: none; font-weight: bold; font-size: 14px;">
                        <i class="fas fa-trash"></i> Xóa khóa này
                    </a>
                </div>
            <?php endif; ?>

            <p style="font-size: 24px; color: #dc3545; font-weight: bold; margin: 15px 0;">
                Giá: <?php echo number_format($course['price']); ?> VNĐ
            </p>

            <div style="margin-bottom: 25px; color: #555; line-height: 1.6; white-space: pre-line;">
                <?php echo htmlspecialchars($course['description']); ?>
            </div>

            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 1px solid #e9ecef;">
                <?php if ($isAdmin): ?>
                    <h4 style="margin: 0; color: #007bff;"><i class="fas fa-user-shield"></i> Chế độ xem của Admin</h4>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #666;">Bạn có toàn quyền thêm/sửa/xóa nội dung bài
                        học.</p>
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($isEnrolled) && $isEnrolled): ?>
                        <h4 style="margin-top: 0; color: #28a745;"><i class="fas fa-check-circle"></i> Bạn đang học khóa này
                        </h4>
                        <div style="margin-top: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <strong>Tiến độ:</strong><strong
                                    style="color: #28a745;"><?php echo round($currentProgress); ?>%</strong>
                            </div>
                            <div style="width: 100%; background: #ddd; height: 10px; border-radius: 5px;">
                                <div style="width: <?php echo $currentProgress; ?>%; background: #28a745; height: 100%;"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <form action="/BTTH02_CNWeb/onlinecourse/enrollment/store" method="POST">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" onclick="return confirm('Bạn muốn đăng ký khóa học này?')"
                                style="background: #007bff; color: white; padding: 15px; border: none; border-radius: 5px; font-weight: bold; width: 100%; cursor: pointer;">
                                ĐĂNG KÝ HỌC NGAY
                            </button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/BTTH02_CNWeb/onlinecourse/auth/login"
                        style="display: block; text-align: center; background: #ffc107; color: #000; padding: 15px; border-radius: 5px; font-weight: bold; text-decoration: none;">🔐
                        Đăng nhập để học</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <hr style="margin: 40px 0; border-top: 1px solid #eee;">

    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="color: #007bff; border-left: 5px solid #007bff; padding-left: 15px;">Nội dung khóa học</h3>

            <?php if ($isAdmin): ?>
                <a href="/BTTH02_CNWeb/onlinecourse/lessons/create?course_id=<?php echo $course['id']; ?>"
                    style="background: #28a745; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-weight: bold;">
                    <i class="fas fa-plus"></i> Thêm bài học
                </a>
            <?php endif; ?>
        </div>

        <ul style="list-style: none; padding: 0;">
            <?php if (!empty($lessons)): ?>
                <?php
                $totalLessons = count($lessons);
                $percentPerLesson = ($totalLessons > 0) ? (100 / $totalLessons) : 0;
                ?>
                <?php foreach ($lessons as $index => $lesson): ?>
                    <li
                        style="background: #fff; border: 1px solid #e9ecef; padding: 20px; margin-bottom: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">

                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span
                                style="background: #007bff; color: #fff; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold;">
                                <?php echo $index + 1; ?>
                            </span>
                            <div>
                                <strong style="font-size: 16px;"><?php echo htmlspecialchars($lesson['title']); ?></strong>
                                <?php if (!empty($lesson['video_url'])): ?>
                                    <?php if ($isAdmin || (isset($isEnrolled) && $isEnrolled)): ?>
                                        <br><a href="<?php echo htmlspecialchars($lesson['video_url']); ?>" target="_blank"
                                            style="color: #d9534f; font-size: 13px; text-decoration: none; margin-top: 5px; display: inline-block;"><i
                                                class="fab fa-youtube"></i> Xem video</a>
                                    <?php else: ?>
                                        <br><span style="color: #999; font-size: 12px;">🔒 Đăng ký để xem video</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px; align-items: center;">
                            <?php if ($isAdmin): ?>
                                <a href="/BTTH02_CNWeb/onlinecourse/lessons/edit?id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course['id']; ?>"
                                    style="color: #ffc107; font-weight: bold; text-decoration: none; border: 1px solid #ffc107; padding: 5px 10px; border-radius: 4px; font-size: 13px;">
                                    Sửa
                                </a>
                                <a href="/BTTH02_CNWeb/onlinecourse/lessons/delete?id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course['id']; ?>"
                                    onclick="return confirm('Xóa bài này?')"
                                    style="color: #dc3545; font-weight: bold; text-decoration: none; border: 1px solid #dc3545; padding: 5px 10px; border-radius: 4px; font-size: 13px;">
                                    Xóa
                                </a>
                            <?php elseif (isset($isEnrolled) && $isEnrolled): ?>
                                <?php $threshold = ($index + 1) * $percentPerLesson; ?>
                                <?php if ($currentProgress >= ($threshold - 0.1)): ?>
                                    <button disabled
                                        style="border: 1px solid #28a745; background: #28a745; color: white; padding: 6px 12px; border-radius: 4px; opacity: 0.8; cursor: not-allowed;">✅
                                        Đã xong</button>
                                <?php else: ?>
                                    <form action="/BTTH02_CNWeb/onlinecourse/enrollment/completeLesson" method="POST"
                                        style="margin: 0;">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit"
                                            style="border: 1px solid #28a745; background: white; color: #28a745; padding: 6px 12px; border-radius: 4px; cursor: pointer;">✔
                                            Hoàn thành</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>