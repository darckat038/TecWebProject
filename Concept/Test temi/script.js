document.getElementById("theme-switch").addEventListener("change", function() {
    const theme = this.value;
    document.body.className = theme;
    localStorage.setItem("theme", theme);  // Salva la preferenza dell'utente
  });
  
  // Carica il tema salvato se presente
  window.addEventListener("load", () => {
    const savedTheme = localStorage.getItem("theme") || "light";
    document.body.className = savedTheme;
    document.getElementById("theme-switch").value = savedTheme;
  });
  