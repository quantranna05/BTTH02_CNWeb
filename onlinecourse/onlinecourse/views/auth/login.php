<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Đăng nhập</h2>

<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST" action="index.php?page=login_submit">
    <label>Username:</label><br>
    <input type="text" name="username"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>

<p>Chưa có tài khoản? <a href="index.php?page=register">Đăng ký</a></p>

</body>
</html>
