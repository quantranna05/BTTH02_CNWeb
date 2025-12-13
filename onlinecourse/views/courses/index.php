<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="hero-section">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <h1>Danh sách khóa học</h1>

        <form action="/BTTH02_CNWeb/onlinecourse/courses" method="GET" class="search-box">
            <input type="text" name="keyword" placeholder="Bạn muốn học gì hôm nay?"
                value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
            <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
        </form>
    </div>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 50px 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="color: #333; font-size: 24px; border-left: 5px solid #007bff; padding-left: 15px;">
            <?php echo isset($_GET['keyword']) && $_GET['keyword'] != '' ? 'Kết quả tìm kiếm' : 'Khóa học nổi bật'; ?>
        </h2>

        <?php if (isset($_GET['keyword']) && $_GET['keyword'] != ''): ?>
            <a href="/BTTH02_CNWeb/onlinecourse/courses" class="btn-reset">
                <i class="fas fa-undo"></i> Xóa bộ lọc
            </a>
        <?php endif; ?>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
            <a href="/BTTH02_CNWeb/onlinecourse/courses/create" class="btn-create">
                <i class="fas fa-plus-circle"></i> Tạo khóa học mới
            </a>
        <?php endif; ?>
    </div>

    <div class="course-grid">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>

                <div class="course-card">
                    <a href="/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $course['id']; ?>" class="card-img-link">
                        <?php
                        $imgName = $course['image'];
                        $imgPath = 'assets/uploads/courses/' . $imgName;
                        // Check file ảnh
                        if (!empty($imgName) && file_exists(__DIR__ . '/../../' . $imgPath)) {
                            $displayImg = "/BTTH02_CNWeb/onlinecourse/" . $imgPath;
                        } else {
                            $displayImg = "https://via.placeholder.com/400x225.png?text=Course";
                        }
                        ?>
                        <img src="<?php echo $displayImg; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">

                        <div class="img-overlay">
                            <span>Xem chi tiết</span>
                        </div>
                    </a>

                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $course['id']; ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </a>
                        </h3>

                        <p class="card-desc">
                            <?php
                            // Cắt ngắn mô tả nếu quá dài
                            $desc = htmlspecialchars($course['description']);
                            echo (strlen($desc) > 80) ? substr($desc, 0, 80) . '...' : $desc;
                            ?>
                        </p>

                        <div class="card-footer">
                            <span class="price"><?php echo number_format($course['price']); ?> đ</span>

                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                                <div class="admin-actions">
                                    <a href="/BTTH02_CNWeb/onlinecourse/courses/edit?id=<?php echo $course['id']; ?>"
                                        class="btn-icon edit" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="/BTTH02_CNWeb/onlinecourse/courses/delete?id=<?php echo $course['id']; ?>"
                                        class="btn-icon delete" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-result">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/search-result-not-found-2130361-1800925.png"
                    alt="Not found" style="width: 200px;">
                <p>Không tìm thấy khóa học nào phù hợp với từ khóa
                    "<b><?php echo htmlspecialchars($_GET['keyword']); ?></b>"</p>
                <a href="/BTTH02_CNWeb/onlinecourse/courses" class="btn-reset">Quay lại danh sách</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* HERO SECTION */
    .hero-section {
        background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
        padding: 80px 0;
        text-align: center;
        color: white;
        margin-bottom: 40px;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .hero-section p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    /* SEARCH BOX */
    .search-box {
        background: white;
        padding: 10px;
        border-radius: 50px;
        display: inline-flex;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .search-box input {
        border: none;
        outline: none;
        padding: 10px 20px;
        flex: 1;
        font-size: 16px;
        border-radius: 50px 0 0 50px;
    }

    .search-box button {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .search-box button:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    /* GRID LAYOUT */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    /* COURSE CARD */
    .course-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: #007bff;
    }

    /* CARD IMAGE */
    .card-img-link {
        position: relative;
        display: block;
        height: 180px;
        overflow: hidden;
    }

    .card-img-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }

    .course-card:hover .card-img-link img {
        transform: scale(1.1);
    }

    .img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: 0.3s;
    }

    .img-overlay span {
        color: white;
        border: 1px solid white;
        padding: 8px 20px;
        border-radius: 20px;
    }

    .course-card:hover .img-overlay {
        opacity: 1;
    }

    /* CARD BODY */
    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-title {
        font-size: 18px;
        margin: 0 0 10px;
        line-height: 1.4;
        height: 50px;
        overflow: hidden;
    }

    .card-title a {
        color: #333;
        text-decoration: none;
        transition: 0.2s;
    }

    .card-title a:hover {
        color: #007bff;
    }

    .card-desc {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
        flex: 1;
    }

    /* CARD FOOTER */
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .price {
        color: #dc3545;
        font-weight: bold;
        font-size: 18px;
    }

    /* BUTTONS */
    .btn-create {
        background: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
    }

    .btn-reset {
        color: #dc3545;
        text-decoration: none;
        font-weight: bold;
    }

    .admin-actions {
        display: flex;
        gap: 10px;
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-icon.edit {
        background: #fff3cd;
        color: #856404;
    }

    .btn-icon.edit:hover {
        background: #ffc107;
        color: black;
    }

    .btn-icon.delete {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-icon.delete:hover {
        background: #dc3545;
        color: white;
    }

    /* NO RESULT */
    .no-result {
        grid-column: 1 / -1;
        text-align: center;
        padding: 50px;
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>