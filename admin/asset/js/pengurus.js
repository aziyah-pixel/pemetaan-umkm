document.addEventListener("DOMContentLoaded", function () {

  const params = new URLSearchParams(window.location.search);

  /* =========================
     MODAL EDIT PENGURUS
  ========================= */
  const editButtons = document.querySelectorAll('.btnEditPengurus');

  if (editButtons.length > 0) {
    editButtons.forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();

        const inputId   = document.getElementById('edit_id_pengurus');
        const inputNama = document.getElementById('edit_pengurus');
        const inputKode = document.getElementById('edit_kode_daerah');
        const modalEl   = document.getElementById('modalEditPengurus');

        if (inputId && inputNama && inputKode && modalEl) {
          inputId.value   = this.dataset.id;
          inputNama.value = this.dataset.pengurus;
          inputKode.value = this.dataset.kode;

          new bootstrap.Modal(modalEl).show();
        }
      });
    });
  }

  /* =========================
     MODAL ERROR
  ========================= */
  if (params.get("error") === "kosong") {
    const modalError = document.getElementById("modalErrorPengurus");
    if (modalError) {
      new bootstrap.Modal(modalError).show();
    }
  }

  /* =========================
     MODAL HAPUS PENGURUS
  ========================= */
  const hapusButtons = document.querySelectorAll('.btnHapusPengurus');

  if (hapusButtons.length > 0) {
    hapusButtons.forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();

        const inputId = document.getElementById('hapus_id_pengurus');
        const namaEl  = document.getElementById('hapus_nama_pengurus');
        const modalEl = document.getElementById('modalHapusPengurus');

        if (inputId && namaEl && modalEl) {
          inputId.value = this.dataset.id;
          namaEl.innerText = this.dataset.nama;

          new bootstrap.Modal(modalEl).show();
        }
      });
    });
  }



});
