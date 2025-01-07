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



/*AMMINISTRATORE*/

document.addEventListener("DOMContentLoaded", function(){
    const oraCorrente = new Date().getHours();
    const nomeUtente = "Luca";
    const salutoUtente = document.getElementById("saluto");
  
    let saluto = oraCorrente < 17 ? "Buongiorno" : "Buonasera";
    salutoUtente.textContent = `${saluto} ${nomeUtente}!`;
  });