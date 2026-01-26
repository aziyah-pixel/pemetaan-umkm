document.addEventListener("DOMContentLoaded", function () {

  /* =========================
     BAGIAN 1: PREVIEW & VALIDASI FOTO
  ========================= */
  const fotoInput = document.getElementById('fotoUMKM');
  const preview = document.getElementById('previewFoto');

  if (fotoInput && preview) {
    fotoInput.addEventListener('change', function () {
      const file = this.files[0];

      if (file) {
        const allowedTypes = ['image/jpeg', 'image/png'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        // Validasi tipe file
        if (!allowedTypes.includes(file.type)) {
          showToastError("❌ Format file harus JPG atau PNG");
          this.value = '';
          preview.src = '../images/umkm/default-image.jpeg';
          return;
        }

        // Validasi ukuran file
        if (file.size > maxSize) {
          showToastError("❌ Ukuran file maksimal 2MB");
          this.value = '';
          preview.src = '../images/umkm/default-image.jpeg';
          return;
        }

        // Preview gambar
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }

  /* =========================
     BAGIAN 2: TOAST DARI URL (?msg / ?error)
  ========================= */
  const params = new URLSearchParams(window.location.search);

  if (params.get("error")) {
    let message = "❌ Terjadi kesalahan";

    switch (params.get("error")) {
      case "field_kosong":
        message = "❌ Semua field wajib diisi";
        break;
      case "format_foto":
        message = "❌ Format foto harus JPG / PNG";
        break;
      case "ukuran_foto":
        message = "❌ Ukuran foto maksimal 2MB";
        break;
      case "upload_gagal":
        message = "❌ Upload foto gagal";
        break;
    }

    showToastError(message);
  }


});

/* =========================
   HELPER FUNCTION TOAST
========================= */

function showToastError(message) {
  const toast = document.getElementById("toastError");
  const msg = document.getElementById("toastErrorMsg");

  if (toast && msg) {
    msg.innerText = message;
    new bootstrap.Toast(toast, { delay: 6000 }).show();
  }
}

