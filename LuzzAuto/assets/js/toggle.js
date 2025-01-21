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



/*
* Assicuriamo il funzionamento dell'espansione del filtro da mobile e la corretta gestione del aria-label
*/
function switchToggle() {

    let FilterMenu = document.getElementById("list_toggle_button");
    if(FilterMenu){
        const toggleButton = document.getElementById('list_toggle_button');
        const toggleInput = document.getElementById('list_toggle_filter');
        const filterForm = document.getElementById('list_filter_form');
        const inputs = filterForm.querySelectorAll("input, select");       

        // Aggiorna tabindex in base alla larghezza dello schermo
        function updateTabIndex() {
            if (window.innerWidth <= 1024) {
                FilterMenu.addEventListener("click", function() {
                    toggleInput.checked = !toggleInput.checked;
                    toggleButton.setAttribute('aria-expanded', toggleInput.checked.toString());
                    toggleButton.setAttribute('aria-label', toggleInput.checked ? 'Seleziona per comprimere il form filtro' : 'Seleziona per espandere il form filtro');
                    inputs.forEach(input => {
                        input.setAttribute("tabindex", toggleInput.checked ? "-1" : "0");
                    });
                });

                FilterMenu.removeAttribute('tabindex'); // Rende tabbabile

                // Applica position e margin se è selezionato
                if (toggleInput.checked) {
                    toggleButton.style.position = "absolute";
                    toggleButton.style.margin = "-9999em";
                    inputs.forEach(input => {
                        input.style.position = "absolute";
                        input.style.margin = "-9999em";
                    });
                } else {
                    toggleButton.style.position = "static";
                    toggleButton.style.margin = "0";
                    inputs.forEach(input => {
                        input.style.position = "static";
                        input.style.margin = "0";
                    });
                }
            } else {
                FilterMenu.setAttribute('tabindex', '-1'); // Rimuove dalla tabulazione
                // Gestisce il tabindex sugli input del form
                inputs.forEach(input => {
                    input.setAttribute("tabindex", "0");
                    input.style.position = "static";
                    input.style.margin = "0";
                });
                toggleButton.style.position = "static";
                toggleButton.style.margin = "0";
            }
        }
    }

    

    // Esegui al caricamento e al resize
    window.addEventListener('resize', updateTabIndex);
    window.addEventListener('DOMContentLoaded', updateTabIndex);

    // Esegui subito per impostare lo stato iniziale
    updateTabIndex();
}