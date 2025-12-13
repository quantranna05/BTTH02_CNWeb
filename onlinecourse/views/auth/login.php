<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/BTTH02_CNWeb/onlinecourse/assets/css/style.css">
</head>

<body class="auth-body">

    <a href="/BTTH02_CNWeb/onlinecourse/" class="back-home">
        <i class="fas fa-arrow-left"></i> Trang chủ
    </a>

    <div class="auth-container">
        <h2>Đăng Nhập</h2>

        <?php if (isset($error) && $error != ''): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Đăng ký thành công! Hãy đăng nhập.
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>

            <button type="submit" class="btn-primary">
                ĐĂNG NHẬP
            </button>
        </form>

        <div class="auth-footer">
            Chưa có tài khoản?
            <a href="/BTTH02_CNWeb/onlinecourse/auth/register">Đăng ký ngay</a>
        </div>
    </div>

    <script src="/BTTH02_CNWeb/onlinecourse/assets/js/script.js"></script>
</body>

</html>