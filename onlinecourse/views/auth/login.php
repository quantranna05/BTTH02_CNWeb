<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Đăng nhập</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Đăng nhập</h2>
    <?php if(isset($error) && $error!=''): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>
    <?php if(isset($_GET['success'])): ?>
        <div class="alert success">Đăng ký thành công! Vui lòng đăng nhập.</div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="index.php?page=register">Đăng ký ngay</a></p>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>
