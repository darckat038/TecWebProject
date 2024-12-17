document.addEventListener("DOMContentLoaded", function () {
    var x = document.getElementById("menu");
    var y = document.getElementById("menu-button-container");

    function adjustMenuOnResize() {
        if (window.innerWidth >= 1024) {
            x.style.display = "flex";                       // Passaggio a modalità desktop
        } else {
            if (x.style.display === "flex" && !(y.classList.contains("change"))) {
                x.style.display = "none";                   // Passaggio da desktop a mobile
            }
                                                            // Passaggio da mobile a mobile
        }
    }

    // Evento resize sulla finestra
    window.addEventListener("resize", adjustMenuOnResize);
});

function menuOpenClose(y) {
    var x = document.getElementById("menu");
    if (x.style.display === "flex") {
        x.style.display = "none";
    } else {
        x.style.display = "flex";
    }
    y.classList.toggle("change");
}


/*UTENTE*/


//saluto in base all'ora del giorno
document.addEventListener("DOMContentLoaded", function(){
  const oraCorrente = new Date().getHours();
  const nomeUtente = "Giovanni";
  const salutoUtente = document.getElementById("saluto");

  let saluto = oraCorrente < 18 ? "Buongiorno" : "Buonasera";
  salutoUtente.textContent = `${saluto} ${nomeUtente}!`;
});


document.addEventListener("DOMContentLoaded", () => {
  // Aggiunge il listener ai link di navigazione e ad altri elementi simili
  document.body.addEventListener("click", (event) => {
    if (event.target.tagName === "A" && event.target.hasAttribute("data-section")) {
      event.preventDefault(); // Previene il comportamento predefinito del link

      const sectionId = event.target.getAttribute("data-section"); // Ottieni l'ID della sezione
      showSection(sectionId); // Chiama la funzione che gestisce le sezioni
    }
  });

  function showSection(sectionId) {
    // Nasconde tutte le sezioni
    document.querySelectorAll('.section').forEach(section => {
      section.classList.remove('active'); // Rimuove 'active' da tutte le sezioni
    });

    // Mostra solo la sezione selezionata
    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
      selectedSection.classList.add('active'); // Aggiunge 'active' alla sezione corrente
    }
  }
});
  