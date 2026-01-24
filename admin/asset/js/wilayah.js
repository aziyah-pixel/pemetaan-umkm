document.addEventListener("DOMContentLoaded", function () {

  /* ==========================
     TAMBAH WILAYAH
  ========================== */
  const tambahDapen = document.getElementById("tambah_dapen");
  if (tambahDapen) {
    tambahDapen.addEventListener("change", function () {
      loadPengurus("tambah_pengurus", this.value);
    });
  }

  /* ==========================
     EDIT WILAYAH
  ========================== */
  document.querySelectorAll(".btnEditWilayah").forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      document.getElementById("edit_id_wilayah").value = this.dataset.id;
      document.getElementById("edit_wilayah").value = this.dataset.wilayah;
      document.getElementById("edit_dapen").value = this.dataset.dapen;

      loadPengurus(
        "edit_pengurus",
        this.dataset.dapen,
        this.dataset.pengurus
      );

      new bootstrap.Modal(
        document.getElementById("modalEditWilayah")
      ).show();
    });
  });

  const editDapen = document.getElementById("edit_dapen");
  if (editDapen) {
    editDapen.addEventListener("change", function () {
      loadPengurus("edit_pengurus", this.value);
    });
  }

  /* =========================
     MODAL HAPUS WILAYAH
  ========================= */
  document.querySelectorAll(".btnHapuswilayah").forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      document.getElementById("hapus_id_wilayah").value = this.dataset.id;
      document.getElementById("hapus_wilayah").innerText = this.dataset.nama;

      new bootstrap.Modal(
        document.getElementById("modalHapusWilayah")
      ).show();
    });
  });

});

/* ==========================
   LOAD PENGURUS (MURNI)
========================== */
function loadPengurus(targetSelectId, kodeDaerah, selectedNama = null) {

  const select = document.getElementById(targetSelectId);
  if (!select || !kodeDaerah) return;

  select.innerHTML = `<option>Memuat...</option>`;

  fetch(`../../../config/proses/wilayah-get-pengurus.php?kode_daerah=${kodeDaerah}`)
    .then(res => res.json())
    .then(data => {

      select.innerHTML = `<option value="">-- Pilih Pengurus --</option>`;

      data.forEach(p => {
        const opt = document.createElement("option");
        opt.value = p.pengurus;
        opt.textContent = p.pengurus;

        if (selectedNama === p.pengurus) {
          opt.selected = true;
        }

        select.appendChild(opt);
      });
    });
}
