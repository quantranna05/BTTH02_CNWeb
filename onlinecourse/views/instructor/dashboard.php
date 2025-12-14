<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h4>
                </div>
                <div class="card-body text-center p-5">

                    <h3 class="mb-4">Xin chào, <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Admin'); ?>!</h3>
                    <p class="text-muted mb-5">Bạn muốn quản lý mục nào hôm nay?</p>

                    <div class="row g-4 justify-content-center">
                        <div class="col-md-5">
                            <a href="index.php?page=admin_users"
                                class="card h-100 text-decoration-none shadow-sm hover-effect border-primary">
                                <div class="card-body d-flex flex-column align-items-center p-4">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px; font-size: 24px;">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h5 class="card-title text-dark">Quản lý Thành viên</h5>
                                    <p class="card-text text-muted small">Xem, sửa, xóa, phân quyền tài khoản</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-5">
                            <a href="index.php?page=admin_courses"
                                class="card h-100 text-decoration-none shadow-sm hover-effect border-success">
                                <div class="card-body d-flex flex-column align-items-center p-4">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px; font-size: 24px;">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <h5 class="card-title text-dark">Quản lý Khóa học</h5>
                                    <p class="card-text text-muted small">Duyệt bài, xem thống kê khóa học</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="mt-5">
                        <a href="index.php?page=logout" class="btn btn-outline-danger px-4">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-effect {
        transition: transform 0.2s;
    }

    .hover-effect:hover {
        transform: translateY(-5px);
        background-color: #f8f9fa;
    }
</style>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>