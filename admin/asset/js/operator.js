document.addEventListener("DOMContentLoaded", function () {

  const params = new URLSearchParams(window.location.search);
  
  if (params.get("error") === "username_exist") {

    const username = params.get("username");

    const textEl  = document.getElementById("username_exist_text");
    const modalEl = document.getElementById("modalUsernameExist");

    if (textEl && modalEl) {
      textEl.innerText = username;
      new bootstrap.Modal(modalEl).show();
    }
  }

   

  
  });
  