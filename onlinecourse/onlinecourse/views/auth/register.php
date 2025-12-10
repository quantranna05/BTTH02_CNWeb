<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="auth-box">
        <h2>Đăng ký</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="fullname" placeholder="Họ và tên" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng ký</button>
        </form>
        <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>
    </div>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>
