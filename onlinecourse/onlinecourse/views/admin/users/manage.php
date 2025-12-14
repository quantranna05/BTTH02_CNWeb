<h2>Quản lý người dùng</h2>

<table border="1" cellpadding="6">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php foreach ($users as $u): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= $u['username'] ?></td>
    <td><?= $u['email'] ?></td>

    <td>
        <form method="post" action="index.php?page=admin_update_role">
            <input type="hidden" name="id" value="<?= $u['id'] ?>">

        <select name="role">
            <option value="0" <?= $u['role']==0?'selected':'' ?>>Student</option>
            <option value="1" <?= $u['role']==1?'selected':'' ?>>Instructor</option>
            <option value="2" <?= $u['role']==2?'selected':'' ?>>Admin</option>
        </select>

        <button type="submit">Cập nhật</button>
    </form>

    </td>

    <td><?= $u['status'] ? 'Hoạt động' : 'Khoá' ?></td>

    <td>
        <a href="index.php?controller=admin&action=toggleStatus&id=<?= $u['id'] ?>&status=<?= $u['status']?0:1 ?>">
            <?= $u['status']?'Khoá':'Mở' ?>
        </a>
    </td>
</tr>
<?php endforeach; ?>
</table>
