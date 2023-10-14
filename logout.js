document.addEventListener("DOMContentLoaded", function() {
    const logoutButton = document.getElementById("logout-button");
  
    logoutButton.addEventListener("click", function() {
      const confirmed = confirm("¿Estás seguro que deseas cerrar sesión?");
      if (confirmed) {
        // Redirigir al archivo de cerrar sesión (logout.php)
        window.location.href = "logout.php";
      }
    });
  });
  