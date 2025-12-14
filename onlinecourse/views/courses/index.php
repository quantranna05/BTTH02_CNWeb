<?php
// 1. Gọi Header
include __DIR__ . '/../layouts/header.php';

// 2. Kiểm tra quyền hạn (Admin: 1, Giảng viên: 2)
if (session_status() === PHP_SESSION_NONE)
    session_start();
$role = $_SESSION['role'] ?? 0;
$canManage = ($role == 1);
?>

<div class="bg-primary py-4 mb-5 shadow-sm">
    <div class="container text-white">
        <div class="row align-items-center">
            <div class="col-md-5">
                <h2 class="mb-0 fw-bold"><i class="fas fa-book-open me-2"></i>Thư viện khóa học</h2>
            </div>

            <div class="col-md-7">
                <div class="d-flex justify-content-md-end align-items-center mt-3 mt-md-0 gap-2">
                    <form action="index.php" method="GET" class="d-flex flex-grow-1" style="max-width: 400px;">
                        <input type="hidden" name="url" value="courses">
                        <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm khóa học..."
                            value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        <button class="btn btn-light text-primary fw-bold" type="submit">Tìm</button>
                    </form>

                    <?php if ($canManage): ?>
                        <a href="index.php?url=courses/create" class="btn btn-success fw-bold text-nowrap shadow">
                            <i class="fas fa-plus-circle"></i> Tạo khóa học
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <?php if (empty($courses)): ?>
            <div class="col-12 text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-search fa-4x mb-3 text-secondary opacity-50"></i>
                    <h4>Không tìm thấy khóa học nào!</h4>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($courses as $course):
                $imgName = $course['image'] ?? '';
                if (empty($imgName)) {
                    $imgSrc = "https://via.placeholder.com/600x400.png?text=Course";
                } elseif (strpos($imgName, 'http') === 0) {
                    $imgSrc = $imgName;
                } else {
                    $imgSrc = 'assets/uploads/courses/' . $imgName;
                }
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border course-card position-relative">

                        <?php if ($canManage): ?>
                            <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                                <div class="btn-group shadow">
                                    <a href="index.php?url=courses/edit&id=<?php echo $course['id']; ?>"
                                        class="btn btn-warning btn-sm text-dark" title="Sửa khóa học">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?url=courses/delete&id=<?php echo $course['id']; ?>"
                                        onclick="return confirm('CẢNH BÁO: Xóa khóa học sẽ xóa HẾT bài học bên trong.\nBạn có chắc chắn không?');"
                                        class="btn btn-danger btn-sm" title="Xóa khóa học">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="position-relative">
                            <img src="<?php echo $imgSrc; ?>" class="card-img-top" style="height: 160px; object-fit: cover;">
                            <?php if (!$canManage): ?>
                                <span
                                    class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded small fw-bold">HOT</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate"
                                title="<?php echo htmlspecialchars($course['title']); ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </h6>
                            <div class="mt-auto pt-3">
                                <h5 class="text-primary mb-3 fw-bold"><?php echo number_format($course['price']); ?> đ</h5>
                                <a href="index.php?url=courses/detail/<?php echo $course['id']; ?>"
                                    class="btn btn-sm btn-outline-primary w-100 fw-bold">
                                    Chi tiết <i class="fas fa-arrow-right small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>