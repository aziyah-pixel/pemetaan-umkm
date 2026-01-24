document.addEventListener("DOMContentLoaded", function () {
  
    /* =========================
       MODAL HAPUS usaha
    ========================= */
    const hapusButtons = document.querySelectorAll('.btnHapusUsaha');
  
    if (hapusButtons.length > 0) {
      hapusButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();
  
          const kode = document.getElementById('hapus_kode_usaha');
          const inputId  = document.getElementById('hapus_id_usaha');
          const modalEl = document.getElementById('modalHapusUsaha');
  
          if (inputId && kode && modalEl) {
            inputId.value = this.dataset.id;
            kode.innerText = this.dataset.nama;

  
            new bootstrap.Modal(modalEl).show();
          }
        });
      });
    }
  
  
  
  });
  