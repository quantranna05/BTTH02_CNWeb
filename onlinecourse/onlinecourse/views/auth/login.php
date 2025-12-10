<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="auth-box">
        <h2>Đăng nhập</h2>
        <?php if(isset($_GET['success']) && $_GET['success']==1) echo "<p class='success'>Đăng ký thành công! Vui lòng đăng nhập.</p>"; ?>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="index.php?page=register">Đăng ký ngay</a></p>
    </div>
</div>
</body>
</html>
