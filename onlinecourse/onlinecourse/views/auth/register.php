<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Đăng ký tài khoản</h2>

<form method="POST" action="index.php?page=register_submit">

    <label>Username:</label><br>
    <input type="text" name="username"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Full Name:</label><br>
    <input type="text" name="fullname"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Register</button>
</form>

<p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>

</body>
</html>
