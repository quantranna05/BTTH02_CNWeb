<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Khóa học Online</title>

    <link rel="stylesheet" href="/BTTH02_CNWeb/onlinecourse/assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <nav>
        <a href="/BTTH02_CNWeb/onlinecourse/" style="font-weight: bold; font-size: 20px;">
            <i class="fas fa-graduation-cap"></i> Online Course
        </a>

        <a href="/BTTH02_CNWeb/onlinecourse/courses">Danh sách Khóa học</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <span style="color: #555; margin: 0 10px;">
                Xin chào, <b><?php echo $_SESSION['username'] ?? 'Học viên'; ?></b>
            </span>

            <a href="/BTTH02_CNWeb/onlinecourse/courses/create" style="color: green;">
                <i class="fas fa-plus-circle"></i> Tạo khóa học
            </a>

            <a href="/BTTH02_CNWeb/onlinecourse/auth/logout" style="color: red;">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>

        <?php else: ?>
            <a href="/BTTH02_CNWeb/onlinecourse/auth/login">Đăng nhập</a>
            <a href="/BTTH02_CNWeb/onlinecourse/auth/register"
                style="background: #007bff; color: white; padding: 5px 10px; border-radius: 4px;">Đăng ký</a>
        <?php endif; ?>
    </nav>

    <div class="main-content">