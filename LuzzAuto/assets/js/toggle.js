// Assicuriamo il funzionamento dell'espansione del filtro da mobile e la corretta gestione del aria-label
function switchToggle() {
    const toggleButton = document.getElementById('list_toggle_button');
    const toggleInput = document.getElementById('list_toggle_filter');
    const filterForm = document.getElementById('list_filter_form');

    toggleInput.checked = !toggleInput.checked;
    toggleButton.setAttribute('aria-expanded', toggleInput.checked.toString());
    toggleButton.setAttribute('aria-label', toggleInput.checked ? 'Seleziona per comprimere il form filtro' : 'Seleziona per espandere il form filtro');
}

// Utilizzato per riportare il menu ad hamburger nello stato in cui lo si è lasciato se si cambia viewport
document.addEventListener("DOMContentLoaded", function () {
    var x = document.getElementById("menu");
    var y = document.getElementById("menu-button-container");

    function adjustMenuOnResize() {
        if (window.innerWidth > 1024) {
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

// Utilzzato per animazione menu hamburger
function menuOpenClose(y) {
    var x = document.getElementById("menu");
    if (x.style.display === "flex") {
        x.style.display = "none";
    } else {
        x.style.display = "flex";
    }
    y.classList.toggle("change");
}