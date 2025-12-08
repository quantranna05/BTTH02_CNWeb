-- ============================================
-- 1. TẠO DATABASE
-- ============================================
CREATE DATABASE IF NOT EXISTS onlinecourse 
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE eonlinecourse ;

-- ============================================
-- 2. TẠO BẢNG users
-- ============================================
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255),
    role INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 3. TẠO BẢNG categories
-- ============================================
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 4. TẠO BẢNG courses
-- ============================================
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructor_id INT,
    category_id INT,
    price DECIMAL(10,2) DEFAULT 0,
    duration_weeks INT,
    level VARCHAR(50),
    image VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_instructor FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- ============================================
-- 5. TẠO BẢNG enrollments
-- ============================================
CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    student_id INT NOT NULL,
    enrolled_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'active',
    progress INT DEFAULT 0,
    
    CONSTRAINT fk_enrollment_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_enrollment_student FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================
-- 6. TẠO BẢNG lessons
-- ============================================
CREATE TABLE lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT,
    video_url VARCHAR(255),
    `order` INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_lesson_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- ============================================
-- 7. TẠO BẢNG materials
-- ============================================
CREATE TABLE materials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT NOT NULL,
    filename VARCHAR(255),
    file_path VARCHAR(255),
    file_type VARCHAR(50),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_material_lesson FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

-- ============================================
-- 8. THÊM DỮ LIỆU users
-- ============================================
INSERT INTO users (username, email, password, fullname, role, created_at)
VALUES
('nguyenvana', 'vana@example.com', '123456', 'Nguyễn Văn A', 0, NOW()),
('tranthib', 'thib@example.com', '123456', 'Trần Thị B', 0, NOW()),
('phamgiangvien', 'giangvien@example.com', '123456', 'Phạm Văn Giảng', 1, NOW()),
('admin01', 'admin@example.com', '123456', 'Quản trị viên 01', 2, NOW());

-- ============================================
-- 9. THÊM DỮ LIỆU categories
-- ============================================
INSERT INTO categories (name, description, created_at)
VALUES
('Lập trình Web', 'Các khóa học về phát triển website, frontend và backend', NOW()),
('Khoa học dữ liệu', 'Phân tích dữ liệu, Machine Learning, AI', NOW()),
('Thiết kế đồ họa', 'Khóa học Photoshop, Illustrator, dựng hình 3D', NOW());

-- ============================================
-- 10. THÊM DỮ LIỆU courses
-- ============================================
INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at)
VALUES
('Lập trình Web cơ bản với HTML & CSS', 
 'Khóa học dành cho người mới bắt đầu xây dựng trang web.', 
 3, 1, 499000, 4, 'Beginner', 'html_css.jpg', NOW()),

('Python cho phân tích dữ liệu', 
 'Khóa học thực hành Python để xử lý và phân tích dữ liệu.', 
 3, 2, 899000, 6, 'Intermediate', 'python_data.jpg', NOW()),

('Thiết kế đồ họa với Photoshop', 
 'Học cách chỉnh sửa ảnh chuyên nghiệp với Adobe Photoshop.', 
 3, 3, 699000, 5, 'Beginner', 'photoshop.jpg', NOW());

-- ============================================
-- 11. THÊM DỮ LIỆU enrollments
-- ============================================
INSERT INTO enrollments (course_id, student_id, enrolled_date, status, progress)
VALUES
(1, 1, NOW(), 'active', 20),
(1, 2, NOW(), 'active', 10),
(2, 1, NOW(), 'active', 0),
(3, 2, NOW(), 'completed', 100);

-- ============================================
-- 12. THÊM DỮ LIỆU lessons
-- ============================================
-- Khóa 1: HTML & CSS
INSERT INTO lessons (course_id, title, content, video_url, `order`, created_at)
VALUES
(1, 'Giới thiệu về HTML', 'Nội dung bài học về HTML cơ bản...', 'video1.mp4', 1, NOW()),
(1, 'Cấu trúc trang web', 'Các thẻ HTML phổ biến...', 'video2.mp4', 2, NOW()),
(1, 'CSS cơ bản', 'Định dạng trang web với CSS...', 'video3.mp4', 3, NOW());

-- Khóa 2: Python
INSERT INTO lessons (course_id, title, content, video_url, `order`, created_at)
VALUES
(2, 'Giới thiệu Python', 'Khái niệm cơ bản về Python...', 'py1.mp4', 1, NOW()),
(2, 'Làm việc với Pandas', 'Xử lý dữ liệu bằng Pandas...', 'py2.mp4', 2, NOW());

-- Khóa 3: Photoshop
INSERT INTO lessons (course_id, title, content, video_url, `order`, created_at)
VALUES
(3, 'Làm quen với Photoshop', 'Tìm hiểu giao diện và công cụ cơ bản...', 'ps1.mp4', 1, NOW()),
(3, 'Công cụ chỉnh sửa ảnh', 'Các công cụ chỉnh sửa cơ bản...', 'ps2.mp4', 2, NOW());

-- ============================================
-- 13. THÊM DỮ LIỆU materials
-- ============================================
INSERT INTO materials (lesson_id, filename, file_path, file_type, uploaded_at)
VALUES
(1, 'HTML_guide.pdf', '/materials/html/html_guide.pdf', 'pdf', NOW()),
(2, 'HTML_tags.docx', '/materials/html/html_tags.docx', 'docx', NOW()),
(3, 'CSS_basics.pptx', '/materials/css/css_basics.pptx', 'pptx', NOW()),
(4, 'Python_intro.pdf', '/materials/python/python_intro.pdf', 'pdf', NOW()),
(7, 'Photoshop_tools.pdf', '/materials/ps/tools.pdf', 'pdf', NOW());
