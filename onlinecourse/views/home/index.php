<?php
// Include Header
include __DIR__ . '/../layouts/header.php';
?>

<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4 text-white">Khởi đầu sự nghiệp lập trình</h1>
        <p class="lead mb-5 text-white opacity-75">Học từ cơ bản đến nâng cao với lộ trình rõ ràng.</p>
        <a href="<?php echo $base_url; ?>/index.php?url=courses"
            class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow">
            Xem tất cả khóa học
        </a>
    </div>
</div>

<div class="container mb-5">
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="p-4 border rounded-3 shadow-sm h-100 bg-white">
                <i class="fas fa-laptop-code fa-3x text-primary mb-3"></i>
                <h5>Học thực chiến</h5>
                <p class="text-muted">Bài tập thực hành chiếm 70% thời lượng.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3 shadow-sm h-100 bg-white">
                <i class="fas fa-certificate fa-3x text-success mb-3"></i>
                <h5>Cấp chứng chỉ</h5>
                <p class="text-muted">Chứng nhận hoàn thành có giá trị toàn quốc.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3 shadow-sm h-100 bg-white">
                <i class="fas fa-infinity fa-3x text-warning mb-3"></i>
                <h5>Truy cập trọn đời</h5>
                <p class="text-muted">Mua một lần, học mãi mãi, update miễn phí.</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Khóa học nổi bật</h2>
        <div class="row">
            <?php
            // Chỉ lấy 3 khóa học
            $topCourses = !empty($courses) ? array_slice($courses, 0, 3) : [];

            if (empty($topCourses)): ?>
                <div class="text-center text-muted">Chưa có khóa học nào.</div>
            <?php else:
                foreach ($topCourses as $course):
                    // Xử lý ảnh
                    $imgName = $course['image'] ?? '';
                    if (empty($imgName)) {
                        $imgSrc = "https://via.placeholder.com/600x400.png?text=Course";
                    } elseif (strpos($imgName, 'http') === 0) {
                        $imgSrc = $imgName;
                    } else {
                        $imgSrc = $base_url . '/assets/uploads/courses/' . $imgName;
                    }
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm course-card">
                            <img src="<?php echo $imgSrc; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-truncate"><?php echo htmlspecialchars($course['title']); ?>
                                </h5>
                                <p class="card-text text-danger fw-bold"><?php echo number_format($course['price']); ?> VNĐ</p>
                                <a href="<?php echo $base_url; ?>/index.php?url=courses/detail/<?php echo $course['id']; ?>"
                                    class="btn btn-outline-primary w-100">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>