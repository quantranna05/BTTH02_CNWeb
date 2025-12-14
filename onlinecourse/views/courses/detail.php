<?php
// Gọi Header
include __DIR__ . '/../layouts/header.php';

// =================================================================================
// 1. CẤU HÌNH CƠ BẢN & PHÂN QUYỀN
// =================================================================================
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Tính toán Base URL
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['PHP_SELF']);
$path = str_replace('\\', '/', $path);
$path = rtrim($path, '/');
$base_url = $protocol . $domainName . $path;

// Lấy Role và Quyền hạn
$role = $_SESSION['role'] ?? 0; // 0: Student, 1: Admin, 2: Instructor
$canManage = ($role == 1 || $role == 2); // Admin hoặc Giảng viên
$isAdmin = ($role == 1);
?>

<div class="container py-5">
    <div class="row">

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px; z-index: 10;">

                <?php
                $imgName = $course['image'] ?? '';
                $uploadPath = 'assets/uploads/courses/';

                if (empty($imgName)) {
                    $displayImg = "https://via.placeholder.com/600x400.png?text=No+Image";
                } elseif (strpos($imgName, 'http') === 0) {
                    $displayImg = $imgName; // Ảnh online
                } else {
                    $displayImg = $base_url . '/' . $uploadPath . $imgName; // Ảnh cục bộ
                }
                ?>
                <img src="<?php echo $displayImg; ?>" class="card-img-top"
                    alt="<?php echo htmlspecialchars($course['title']); ?>" style="height: 250px; object-fit: cover;"
                    onerror="this.src='https://via.placeholder.com/600x400.png?text=Image+Error';">

                <div class="card-body p-4">
                    <h2 class="text-danger fw-bold text-center mb-3">
                        <?php echo number_format($course['price']); ?> VNĐ
                    </h2>

                    <?php if ($role == 2): ?>
                        <div class="alert alert-secondary text-center shadow-sm">
                            <i class="fas fa-user-tie fa-2x mb-2 text-primary"></i><br>
                            <strong>Giao diện Giảng viên</strong><br>
                            <small class="text-muted">Bạn có quyền quản lý nội dung.</small>
                        </div>

                    <?php elseif ($role == 1): ?>
                        <div class="alert alert-warning text-center shadow-sm">
                            <i class="fas fa-user-shield fa-2x mb-2 text-danger"></i><br>
                            <strong>Giao diện Quản trị viên</strong>
                        </div>
                        <a href="<?php echo $base_url; ?>/index.php?url=courses/delete&id=<?php echo $course['id']; ?>"
                            onclick="return confirm('CẢNH BÁO: Hành động này không thể hoàn tác!\nXóa khóa học sẽ xóa toàn bộ bài học và lịch sử học tập.\nBạn chắc chắn chứ?')"
                            class="btn btn-outline-danger w-100 mt-2 fw-bold">
                            <i class="fas fa-trash-alt"></i> XÓA KHÓA HỌC
                        </a>

                    <?php elseif (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($isEnrolled) && $isEnrolled): ?>
                            <div class="alert alert-success shadow-sm">
                                <h5 class="alert-heading"><i class="fas fa-graduation-cap"></i> Đang học</h5>
                                <hr>
                                <p class="mb-1 small">Tiến độ hoàn thành:</p>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width: <?php echo $currentProgress; ?>%">
                                        <?php echo round($currentProgress); ?>%
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo $base_url; ?>/index.php?url=courses/register/<?php echo $course['id']; ?>"
                                class="btn btn-primary w-100 btn-lg fw-bold shadow pulse-button"
                                onclick="return confirm('Xác nhận đăng ký khóa học: <?php echo htmlspecialchars($course['title']); ?>\nGiá: <?php echo number_format($course['price']); ?> VNĐ?')">
                                <i class="fas fa-cart-plus me-2"></i> ĐĂNG KÝ HỌC NGAY
                            </a>
                            <div class="text-center mt-3 text-muted small">
                                <i class="fas fa-shield-alt"></i> Cam kết hoàn tiền trong 7 ngày
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <a href="<?php echo $base_url; ?>/index.php?page=login"
                            class="btn btn-warning w-100 fw-bold shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập để đăng ký
                        </a>
                        <p class="text-center mt-2 small text-muted">Bạn cần có tài khoản để mua khóa học này.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h1 class="fw-bold text-primary mb-3"><?php echo htmlspecialchars($course['title']); ?></h1>

            <div class="card shadow-sm mb-5 border-0">
                <div class="card-body bg-light">
                    <h5 class="card-title fw-bold border-bottom pb-2 mb-3 text-dark">
                        <i class="fas fa-info-circle text-primary me-2"></i>Giới thiệu khóa học
                    </h5>
                    <p class="card-text text-secondary" style="white-space: pre-line; line-height: 1.6;">
                        <?php echo htmlspecialchars($course['description']); ?>
                    </p>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold text-dark"><i class="fas fa-list-ul me-2 text-primary"></i>Nội dung bài học</h4>

                <?php if ($canManage): ?>
                    <a href="<?php echo $base_url; ?>/index.php?url=lessons/create&course_id=<?php echo $course['id']; ?>"
                        class="btn btn-success btn-sm shadow-sm fw-bold">
                        <i class="fas fa-plus-circle"></i> Thêm bài mới
                    </a>
                <?php endif; ?>
            </div>

            <div class="list-group shadow-sm">
                <?php if (!empty($lessons)): ?>
                    <?php
                    // Tính toán phần trăm mỗi bài học
                    $totalLessons = count($lessons);
                    $percentPerLesson = ($totalLessons > 0) ? (100 / $totalLessons) : 0;
                    ?>

                    <?php foreach ($lessons as $index => $lesson): ?>
                        <div
                            class="list-group-item list-group-item-action p-3 border-start-0 border-end-0 border-top-0 border-bottom">
                            <div class="d-flex w-100 justify-content-between align-items-center">

                                <div class="d-flex align-items-center flex-grow-1">
                                    <span class="badge bg-primary rounded-circle me-3 shadow-sm"
                                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                        <?php echo $index + 1; ?>
                                    </span>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($lesson['title']); ?>
                                        </h6>

                                        <?php if (!empty($lesson['video_url'])): ?>
                                            <?php if ($canManage || (isset($isEnrolled) && $isEnrolled)): ?>
                                                <a href="<?php echo htmlspecialchars($lesson['video_url']); ?>" target="_blank"
                                                    class="text-danger text-decoration-none small fw-bold">
                                                    <i class="fab fa-youtube"></i> Xem Video bài giảng
                                                </a>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-lock text-warning"></i>
                                                    <span style="opacity: 0.7;">Mua khóa học để xem video</span>
                                                </small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <small class="text-muted fst-italic">Bài này chưa có video.</small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="ms-3">
                                    <?php if ($canManage): ?>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo $base_url; ?>/index.php?url=lessons/edit&id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course['id']; ?>"
                                                class="btn btn-outline-warning btn-sm" title="Sửa bài">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo $base_url; ?>/index.php?url=lessons/delete&id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course['id']; ?>"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Bạn chắc chắn muốn xóa bài học này?')" title="Xóa bài">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>

                                    <?php elseif (isset($isEnrolled) && $isEnrolled): ?>
                                        <?php

                                        $threshold = ($index + 1) * $percentPerLesson;
                                        ?>

                                        <?php if ($currentProgress >= ($threshold - 0.5)): ?>
                                            <button class="btn btn-success btn-sm disabled shadow-sm"
                                                style="opacity: 0.9; cursor: default;">
                                                <i class="fas fa-check"></i> Đã học
                                            </button>
                                        <?php else: ?>
                                            <form action="<?php echo $base_url; ?>/index.php?url=enrollment/completeLesson"
                                                method="POST" class="d-inline">
                                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                                <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
                                                <button type="submit" class="btn btn-outline-success btn-sm">
                                                    Hoàn thành
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center p-5 bg-white border rounded shadow-sm text-muted">
                        <i class="fas fa-box-open fa-3x mb-3 text-secondary opacity-50"></i>
                        <p class="mb-0">Chưa có bài học nào được cập nhật cho khóa này.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.02);
        }

        100% {
            transform: scale(1);
        }
    }

    .pulse-button:hover {
        animation: pulse 1s infinite;
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>