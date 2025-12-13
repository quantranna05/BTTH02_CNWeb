<?php include '/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 20px;">
    <h1 style="text-align: center; color: #007bff;">Danh sách Khóa học</h1>

    <div style="display: flex; justify-content: center; margin-bottom: 30px;">
        <form action="" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm khóa học..." style="width: 300px;">
            <button type="submit" class="btn-primary">Tìm kiếm</button>
        </form>
    </div>

    <div class="course-list">
        <?php foreach ($courses as $course): ?>
            <div class="course-item">
                <img src="/BTTH02_CNWeb/onlinecourse/assets/uploads/courses/<?php echo $course['image']; ?>"
                    onerror="this.src='https://via.placeholder.com/300x200'">

                <div class="course-content">
                    <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                    <p class="course-price"><?php echo number_format($course['price']); ?> VNĐ</p>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                        <a href="/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $course['id']; ?>"
                            class="btn-primary">
                            Xem chi tiết
                        </a>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                            <div>
                                <a href="/BTTH02_CNWeb/onlinecourse/courses/edit?id=<?php echo $course['id']; ?>"
                                    style="color: #ffc107; margin-right: 10px; font-size: 18px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/BTTH02_CNWeb/onlinecourse/courses/delete?id=<?php echo $course['id']; ?>"
                                    onclick="return confirm('Xóa khóa học này?')" style="color: #dc3545; font-size: 18px;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '/views/layouts/footer.php'; ?>