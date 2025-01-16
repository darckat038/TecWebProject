document.addEventListener("DOMContentLoaded", function () {
    // Evento resize sulla finestra
    adjustMenuOnResize();
    // Evento click su menu hamburger
    menuOpenClose();
    // Evento click filtro listino
    switchToggle();
});

/*
* Utilizzato per riportare il menu ad hamburger nello stato in cui lo si è lasciato se si cambia viewport
*/
function adjustMenuOnResize() {

    window.addEventListener("resize", function() {

        var x = document.getElementById("menu");
        var y = document.getElementById("menu-button-container");

        if (window.innerWidth > 1024) {
            x.style.display = "flex";                       // Passaggio a modalità desktop
        } else {
            if (x.style.display === "flex" && !(y.classList.contains("change"))) {
                x.style.display = "none";                   // Passaggio da desktop a mobile
            }
                                                            // Passaggio da mobile a mobile
        }
    });
}


/*
* Utilzzato per animazione menu hamburger
*/
function menuOpenClose() {

    let HamMenu = document.getElementById("menu-button-container");

    HamMenu.addEventListener("click", function() {
        let y = document.getElementById("menu-button-container");
        let x = document.getElementById("menu");

        if (x.style.display === "flex") {
            x.style.display = "none";
        } else {
            x.style.display = "flex";
        }
        y.classList.toggle("change");
    });
}