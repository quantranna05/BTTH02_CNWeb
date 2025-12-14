<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý Thành viên</h2>
        <a href="index.php?page=admin_dashboard" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại Dashboard
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User Info</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($user['username']); ?></strong><br>
                            <small><?php echo htmlspecialchars($user['fullname']); ?></small>
                        </td>
                        <td>
                            <form action="index.php?page=admin_update_role" method="POST">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <select name="role" class="form-select form-select-sm" onchange="this.form.submit()"
                                    style="width:140px">
                                    <option value="0" <?php echo $user['role'] == 0 ? 'selected' : ''; ?>>Học viên
                                    </option>

                                    <option value="1" class="text-danger fw-bold"
                                        <?php echo $user['role'] == 1 ? 'selected' : ''; ?>>Admin</option>

                                    <option value="2" <?php echo $user['role'] == 2 ? 'selected' : ''; ?>>Giảng viên
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="index.php?page=admin_delete_user&id=<?php echo $user['id']; ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('Xóa user này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>