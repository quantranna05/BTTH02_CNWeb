<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Tính Base URL
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['PHP_SELF']);
$path = str_replace('\\', '/', $path);
$path = rtrim($path, '/');
// Xử lý logic để về đúng root nếu đang ở thư mục con
if (strpos($path, '/views') !== false) {
    $parts = explode('/views', $path);
    $path = $parts[0];
}
$base_url = $protocol . $domainName . $path;

$role = $_SESSION['role'] ?? 0;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Khóa học Trực tuyến</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .course-card {
            transition: transform 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* CSS cho Banner trang chủ */
        .hero-section {
            background-color: #0d6efd;
            /* Màu xanh dự phòng nếu ảnh lỗi */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?php echo $base_url; ?>/index.php">
                <i class="fas fa-graduation-cap"></i> Online Course
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/index.php?url=courses">Khóa
                            học</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>

                        <?php if ($role == 1): ?>
                            <li class="nav-item ms-2">
                                <a class="btn btn-danger btn-sm text-white"
                                    href="<?php echo $base_url; ?>/index.php?page=dashboard">
                                    <i class="fas fa-user-shield"></i> Quản trị
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle fw-bold text-dark" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Xin chào, <?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']); ?>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if ($role == 1): ?>
                                    <li><a class="dropdown-item"
                                            href="<?php echo $base_url; ?>/index.php?page=dashboard">Dashboard Admin</a></li>
                                <?php elseif ($role == 2): ?>
                                    <li><a class="dropdown-item"
                                            href="<?php echo $base_url; ?>/index.php?page=instructor_dashboard">Quản lý khóa
                                            học</a></li>
                                <?php else: ?>
                                    <li><span class="dropdown-item-text text-muted">Tài khoản Học viên</span></li>
                                <?php endif; ?>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger"
                                        href="<?php echo $base_url; ?>/index.php?page=logout">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li class="nav-item ms-3"><a class="nav-link"
                                href="<?php echo $base_url; ?>/index.php?page=login">Đăng nhập</a></li>
                        <li class="nav-item ms-2"><a class="btn btn-primary btn-sm rounded-pill px-4"
                                href="<?php echo $base_url; ?>/index.php?page=register">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>