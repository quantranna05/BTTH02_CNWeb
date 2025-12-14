<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 40px auto; padding: 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0; color: #333;">📚 Khóa học của tôi</h2>
        <a href="/BTTH02_CNWeb/onlinecourse/courses/create" 
           style="padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
            ➕ Tạo khóa học mới
        </a>
    </div>

    <?php if (empty($courses)): ?>
        <div style="background: #f0f8ff; border: 1px solid #b3d9ff; padding: 30px; text-align: center; border-radius: 8px;">
            <p style="font-size: 18px; color: #555; margin: 0;">
                🎓 Bạn chưa có khóa học nào. Hãy tạo khóa học đầu tiên!
            </p>
        </div>
    <?php else: ?>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
            
            <?php foreach ($courses as $course): ?>
                <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    
                    <?php
                    $imgName = $course['image'];
                    $imgPath = 'assets/uploads/courses/' . $imgName;
                    if (empty($imgName) || !file_exists(ROOT_PATH . '/' . $imgPath)) {
                        $displayImg = "https://via.placeholder.com/400x225.png?text=Course+Image";
                    } else {
                        $displayImg = "/BTTH02_CNWeb/onlinecourse/" . $imgPath;
                    }
                    ?>
                    
                    <img src="<?php echo $displayImg; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" 
                         style="width: 100%; height: 200px; object-fit: cover;">
                    
                    <div style="padding: 20px;">
                        <h3 style="margin: 0 0 10px; font-size: 18px; min-height: 50px; color: #333;">
                            <?php echo htmlspecialchars($course['title']); ?>
                        </h3>
                        
                        <p style="color: #666; font-size: 14px; margin: 10px 0;">
                            <?php echo substr(htmlspecialchars($course['description']), 0, 100); ?>...
                        </p>
                        
                        <div style="display: flex; gap: 10px; margin: 15px 0;">
                            <span style="background: #e3f2fd; color: #1976d2; padding: 4px 10px; border-radius: 4px; font-size: 13px;">
                                📖 <?php echo $course['lesson_count']; ?> bài học
                            </span>
                            <span style="background: #fff3e0; color: #f57c00; padding: 4px 10px; border-radius: 4px; font-size: 13px;">
                                💰 <?php echo number_format($course['price']); ?> đ
                            </span>
                        </div>
                        
                        <div style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px; display: flex; gap: 8px;">
                            
                            <a href="/BTTH02_CNWeb/onlinecourse/courses/edit/<?php echo $course['id']; ?>" 
                               style="flex: 1; text-align: center; padding: 8px; background: #fff3e0; color: #f57c00; text-decoration: none; border-radius: 4px; font-size: 14px;">
                                ✏️ Sửa
                            </a>
                            
                            <a href="/BTTH02_CNWeb/onlinecourse/courses/delete/<?php echo $course['id']; ?>" 
                               onclick="return confirm('⚠️ Xóa khóa học này?')" 
                               style="flex: 1; text-align: center; padding: 8px; background: #ffebee; color: #c62828; text-decoration: none; border-radius: 4px; font-size: 14px;">
                                🗑️ Xóa
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
        </div>
        
    <?php endif; ?>
    
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>