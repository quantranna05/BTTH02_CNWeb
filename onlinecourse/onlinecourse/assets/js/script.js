<<<<<<< HEAD
document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebar-toggle");
  const sidebar = document.querySelector(".sidebar");

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", function (e) {
      e.preventDefault();
      sidebar.classList.toggle("active");
    });
  }

  const deleteLinks = document.querySelectorAll(
    '.btn-delete, a[href*="delete"]'
  );

  deleteLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      const confirmed = confirm(
        "Bạn có chắc chắn muốn xóa dữ liệu này không? Hành động này không thể hoàn tác."
      );
      if (!confirmed) {
        e.preventDefault();
      }
    });
  });

  const imageInput = document.getElementById("image-upload");
  const imagePreview = document.getElementById("image-preview");

  if (imageInput && imagePreview) {
    imageInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.src = e.target.result;
          imagePreview.style.display = "block";
        };
        reader.readAsDataURL(file);
      }
    });
  }

  const forms = document.querySelectorAll(".needs-validation");

  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      function (event) {
        let isValid = true;
        const requiredInputs = form.querySelectorAll("[required]");

        requiredInputs.forEach((input) => {
          if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = "red";
          } else {
            input.style.borderColor = "#ced4da";
          }
        });

        if (!isValid) {
          event.preventDefault();
          event.stopPropagation();
          alert("Vui lòng điền đầy đủ các trường bắt buộc.");
        }
      },
      false
    );
  });
=======
document.addEventListener('DOMContentLoaded',function(){
    const alerts=document.querySelectorAll('.alert');
    alerts.forEach(a=>setTimeout(()=>a.style.display='none',3000));
>>>>>>> feature/auth
});
