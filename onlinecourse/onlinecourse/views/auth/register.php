<div class="container">
    <h2>Đăng ký</h2>

    <?php if(isset($error)) echo "<div class='alert error'>$error</div>"; ?>
    <?php if(isset($success)) echo "<div class='alert success'>$success</div>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="fullname" placeholder="Họ và tên" required>
        <div style="position:relative;">
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <span class="show-password">Hiện mật khẩu</span>
        </div>
        <button type="submit">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>
</div>
<script src="assets/js/script.js"></script>
