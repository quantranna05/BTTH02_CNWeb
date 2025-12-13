<?php
// FILE: controllers/CourseController.php

// Đảm bảo đã load các Model
require_once ROOT_PATH . '/models/Course.php';
require_once ROOT_PATH . '/models/Lesson.php'; // Quan trọng: Load Model Lesson

class CourseController
{
    // ... (Hàm index, create, store... giữ nguyên) ...

    // HÀM DETAIL PHẢI NẰM Ở CONTROLLER
    public function detail($id)
    {
        // 1. Gọi Model Course để lấy thông tin khóa học
        $courseModel = new Course();
        $course = $courseModel->getById($id);

        // 2. Gọi Model Lesson để lấy danh sách bài học
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourseId($id);

        // 3. Kiểm tra và hiển thị View
        if ($course) {
            // Truyền biến $course và $lessons sang View
            require ROOT_PATH . '/views/courses/detail.php';
        } else {
            echo "Khóa học không tồn tại!";
        }
    }
}
?>