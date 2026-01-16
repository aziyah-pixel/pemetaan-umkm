  const fotoInput = document.getElementById('fotoUMKM');
  const preview = document.getElementById('previewFoto');

  fotoInput.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
      const allowedTypes = ['image/jpeg', 'image/png'];
      const maxSize = 2 * 1024 * 1024; // 2MB

      // Validasi tipe file
      if (!allowedTypes.includes(file.type)) {
        alert('Format file harus JPG atau PNG');
        this.value = '';
        preview.src = '../../../asset/images/default-image.jpeg';
        return;
      }

      // Validasi ukuran file
      if (file.size > maxSize) {
        alert('Ukuran file maksimal 2MB');
        this.value = '';
        preview.src = '../../../assets/images/default-image.jpeg';
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

