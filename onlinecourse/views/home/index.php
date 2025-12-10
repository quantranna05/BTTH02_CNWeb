<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div
    style="background: linear-gradient(to right, #4facfe, #00f2fe); padding: 60px 20px; text-align: center; color: white;">
    <h1>Chào mừng đến với Online Course</h1>
    <p style="font-size: 18px; margin-bottom: 30px;">Tìm kiếm khóa học và bắt đầu sự nghiệp của bạn</p>

    <form action="/BTTH02_CNWeb/onlinecourse/courses" method="GET"
        style="display: inline-block; width: 100%; max-width: 500px;">
        <div style="display: flex; background: white; padding: 5px; border-radius: 50px;">
            <input type="text" name="keyword" placeholder="Bạn muốn học gì?"
                style="flex: 1; border: none; padding: 10px 20px; border-radius: 50px; outline: none;">
            <button type="submit"
                style="background: #007bff; color: white; border: none; padding: 10px 30px; border-radius: 50px; font-weight: bold; cursor: pointer;">Tìm</button>
        </div>
    </form>
</div>

<div class="container" style="max-width: 1200px; margin: 40px auto; padding: 20px;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Khóa học nổi bật</h2>

    <div class="course-list"
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
        <?php if (!empty($courses)): ?>
            <?php foreach (array_slice($courses, 0, 6) as $course): ?>

                <div class="course-item"
                    onclick="window.location.href='/BTTH02_CNWeb/onlinecourse/courses/detail/<?php echo $course['id']; ?>'"
                    style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); cursor: pointer; user-select: none; transition: transform 0.2s;">

                    <?php
                    $imgName = $course['image'];
                    $imgPath = 'assets/uploads/courses/' . $imgName;
                    if (empty($imgName) || !file_exists(ROOT_PATH . '/' . $imgPath)) {
                        $displayImg = "https://via.placeholder.com/400x225.png?text=Featured+Course";
                    } else {
                        $displayImg = "/BTTH02_CNWeb/onlinecourse/" . $imgPath;
                    }
                    ?>
                    <img src="<?php echo $displayImg; ?>" alt="<?php echo $course['title']; ?>"
                        style="width: 100%; height: 180px; object-fit: cover;">

                    <div style="padding: 15px;">
                        <h3
                            style="margin: 0 0 10px; font-size: 18px; min-height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?php echo $course['title']; ?>
                        </h3>
                        <p style="color: #d9534f; font-weight: bold; margin: 0; font-size: 16px;">
                            <?php echo number_format($course['price']); ?> VNĐ
                        </p>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">Chưa có dữ liệu khóa học.</p>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <a href="/BTTH02_CNWeb/onlinecourse/courses"
            style="padding: 12px 30px; background: #333; color: white; text-decoration: none; border-radius: 30px; font-weight: bold;">Xem
            tất cả khóa học</a>
    </div>
</div>

<style>
    .course-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
        border-color: #007bff !important;
    }
</style>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>