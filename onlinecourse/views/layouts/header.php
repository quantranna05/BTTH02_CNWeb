<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Course System</title>
    <link rel="stylesheet" href="/BTTH02_CNWeb/onlinecourse/assets/css/style.css">
</head>

<body>
    <nav>
        <a href="/BTTH02_CNWeb/onlinecourse/">Trang chủ</a>
        <a href="/BTTH02_CNWeb/onlinecourse/courses">Khóa học</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <span style="margin: 0 10px;">👤 <?php echo $_SESSION['username'] ?? 'Học viên'; ?></span>
            <a href="/BTTH02_CNWeb/onlinecourse/courses/create">➕ Tạo khóa học</a>
            <a href="/BTTH02_CNWeb/onlinecourse/auth/logout" style="color: red;">Đăng xuất</a>
        <?php else: ?>
            <a href="/BTTH02_CNWeb/onlinecourse/auth/login">Đăng nhập</a>
        <?php endif; ?>
    </nav>