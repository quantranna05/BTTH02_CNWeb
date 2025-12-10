document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', e => {
            const password = form.querySelector('input[name="password"]').value;
            if (password.length < 6) {
                e.preventDefault();
                alert("Mật khẩu phải từ 6 ký tự trở lên!");
            }
        });
    });
});
