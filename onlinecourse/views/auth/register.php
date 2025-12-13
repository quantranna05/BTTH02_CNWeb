<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/BTTH02_CNWeb/onlinecourse/assets/css/style.css">
</head>

<body class="auth-body">

    <a href="/BTTH02_CNWeb/onlinecourse/" class="back-home">
        <i class="fas fa-arrow-left"></i> Trang chủ
    </a>

    <div class="auth-container">
        <h2>Đăng Ký</h2>

        <?php if (isset($error) && $error != ''): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="fullname" class="form-control" placeholder="Nguyễn Văn A" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
            </div>

            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" placeholder="Viết liền không dấu" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
            </div>

            <button type="submit" class="btn-primary">
                ĐĂNG KÝ
            </button>
        </form>

        <div class="auth-footer">
            Đã có tài khoản?
            <a href="/BTTH02_CNWeb/onlinecourse/auth/login">Đăng nhập</a>
        </div>
    </div>

    <script src="/BTTH02_CNWeb/onlinecourse/assets/js/script.js"></script>
</body>

</html>