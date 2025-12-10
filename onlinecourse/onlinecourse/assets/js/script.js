// Hiển thị / ẩn mật khẩu
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtns = document.querySelectorAll('.show-password');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const input = this.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = 'Ẩn mật khẩu';
            } else {
                input.type = 'password';
                this.textContent = 'Hiện mật khẩu';
            }
        });
    });

    // Ẩn thông báo sau 5s
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(a => {
        setTimeout(() => {
            a.style.display = 'none';
        }, 5000);
    });
});
