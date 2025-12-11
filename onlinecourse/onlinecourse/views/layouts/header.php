<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Khóa học</title>
    <link rel="stylesheet" href="/onlinecourse/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php include 'sidebar.php'; ?>
        <?php endif; ?>
        
        <div class="main-content">
            <header>
                <div class="header-left">
                    <button id="sidebar-toggle" class="btn"><i class="fas fa-bars"></i></button>
                    <span>Xin chào, <?php echo $_SESSION['username'] ?? 'Khách'; ?></span>
                </div>
                </header>
            <div class="container">
