<?php
// Gọi Header
include __DIR__ . '/../layouts/header.php';

// =================================================================================
// 1. CẤU HÌNH CƠ BẢN & PHÂN QUYỀN
// =================================================================================
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Tính toán đường dẫn gốc (Base URL) để tránh lỗi ảnh/link
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['PHP_SELF']);
$path = str_replace('\\', '/', $path);
$path = rtrim($path, '/');
$base_url = $protocol . $domainName . $path; // VD: http://localhost/BTTH02_CNWeb/onlinecourse

// Lấy Role
$role = $_SESSION['role'] ?? 0; // 0: Student, 1: Admin, 2: Instructor
$canManage = ($role == 1 || $role == 2); // Quyền quản lý bài học (Admin + GV)
$isAdmin = ($role == 1); // Quyền cao nhất (Xóa khóa học)
?>

<div class="container py-5">
    <div class="row">

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px; z-index: 1;">

                <?php
                $imgName = $course['image'] ?? '';
                // Thư mục chứa ảnh (Bạn cần đảm bảo ảnh nằm đúng chỗ này)
                // Nếu bạn lưu ở uploads/ ngay ngoài cùng thì sửa thành 'uploads/'
                $uploadPath = 'assets/uploads/courses/';

                if (empty($imgName)) {
                    $displayImg = "https://via.placeholder.com/600x400.png?text=No+Image";
                } elseif (strpos($imgName, 'http') === 0) {
                    $displayImg = $imgName; // Link online
                } else {
                    // Link file cục bộ (Dùng base_url để nối chuỗi chính xác)
                    $displayImg = $base_url . '/' . $uploadPath . $imgName;
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
                        <div class="alert alert-secondary text-center">
                            <i class="fas fa-user-tie fa-lg mb-2"></i><br>
                            <strong>Chế độ Giảng viên</strong><br>
                            <small>(Bạn có quyền quản lý bài học)</small>
                        </div>

                    <?php elseif ($role == 1): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-user-shield fa-lg mb-2"></i><br>
                            <strong>Chế độ Admin</strong><br>
                            <small>(Toàn quyền quản trị)</small>
                        </div>
                        <a href="<?php echo $base_url; ?>/index.php?url=courses/delete&id=<?php echo $course['id']; ?>"
                            onclick="return confirm('CẢNH BÁO: Xóa khóa học sẽ xóa toàn bộ bài học và dữ liệu học viên!\nBạn có chắc chắn không?')"
                            class="btn btn-outline-danger w-100 mt-2">
                            <i class="fas fa-trash-alt"></i> Xóa khóa học này
                        </a>

                    <?php elseif (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($isEnrolled) && $isEnrolled): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Bạn đang học khóa này
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: <?php echo $currentProgress; ?>%"></div>
                                </div>
                                <small class="text-muted">Tiến độ: <?php echo round($currentProgress); ?>%</small>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo $base_url; ?>/index.php?url=courses/register/<?php echo $course['id']; ?>"
                                class="btn btn-primary w-100 btn-lg fw-bold shadow-sm"
                                onclick="return confirm('Xác nhận đăng ký khóa học với giá <?php echo number_format($course['price']); ?>đ?')">
                                ĐĂNG KÝ HỌC NGAY
                            </a>
                        <?php endif; ?>

                    <?php else: ?>
                        <a href="<?php echo $base_url; ?>/index.php?page=login" class="btn btn-warning w-100 fw-bold">
                            🔐 Đăng nhập để đăng ký
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h1 class="fw-bold text-primary mb-3"><?php echo htmlspecialchars($course['title']); ?></h1>

            <div class="bg-light p-4 rounded mb-5">
                <h5 class="fw-bold border-bottom pb-2">Giới thiệu khóa học</h5>
                <p class="mb-0" style="white-space: pre-line; color: #555;">
                    <?php echo htmlspecialchars($course['description']); ?>
                </p>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><i class="fas fa-list-ul me-2"></i>Nội dung bài học</h4>

                <?php if ($canManage): ?>
                    <a href="<?php echo $base_url; ?>/index.php?url=lessons/create&course_id=<?php echo $course['id']; ?>"
                        class="btn btn-success btn-sm shadow-sm">
                        <i class="fas fa-plus"></i> Thêm bài mới
                    </a>
                <?php endif; ?>
            </div>

            <div class="list-group">
                <?php if (!empty($lessons)): ?>
                    <?php
                    $totalLessons = count($lessons);
                    $percentPerLesson = ($totalLessons > 0) ? (100 / $totalLessons) : 0;
                    ?>

                    <?php foreach ($lessons as $index => $lesson): ?>
                        <div class="list-group-item list-group-item-action p-3 mb-2 border rounded shadow-sm">
                            <div class="d-flex w-100 justify-content-between align-items-center">

                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary rounded-circle me-3"
                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                        <?php echo $index + 1; ?>
                                    </span>
                                    <div>
                                        <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($lesson['title']); ?></h6>

                                        <?php if (!empty($lesson['video_url'])): ?>
                                            <?php if ($canManage || (isset($isEnrolled) && $isEnrolled)): ?>
                                                <a href="<?php echo htmlspecialchars($lesson['video_url']); ?>" target="_blank"
                                                    class="text-danger text-decoration-none small">
                                                    <i class="fab fa-youtube"></i> Xem Video bài giảng
                                                </a>
                                            <?php else: ?>
                                                <small class="text-muted"><i class="fas fa-lock"></i> Đăng ký để xem video</small>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div>
                                    <?php if ($canManage): ?>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo $base_url; ?>/index.php?url=lessons/edit&id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course['id']; ?>"
                                                class="btn btn-outline-warning btn-sm" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo $base_url; ?>/index.php?url=lessons/delete&id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course['id']; ?>"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Bạn chắc chắn muốn xóa bài học này?')" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>

                                    <?php elseif (isset($isEnrolled) && $isEnrolled): ?>
                                        <?php $threshold = ($index + 1) * $percentPerLesson; ?>

                                        <?php if ($currentProgress >= ($threshold - 0.1)): ?>
                                            <button class="btn btn-success btn-sm disabled" style="opacity: 0.8;">
                                                <i class="fas fa-check"></i> Xong
                                            </button>
                                        <?php else: ?>
                                            <form action="<?php echo $base_url; ?>/index.php?url=enrollment/completeLesson"
                                                method="POST" class="d-inline">
                                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
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
                    <div class="text-center p-5 bg-light rounded text-muted">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p>Chưa có bài học nào được cập nhật.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>