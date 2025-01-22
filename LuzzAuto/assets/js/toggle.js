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

    let toggleButton = document.getElementById('list_toggle_button');

    if(toggleButton){
        
        let toggleInput = document.getElementById('list_toggle_filter');
        let filterForm = document.getElementById('list_filter_form');
        let inputs = filterForm.querySelectorAll("input, select");   
        
        
        function filterOpenClose() {
            // Controlla toggle
            if (toggleInput.checked) {
                // Mostra menù
                filterForm.style.position = "static";
                filterForm.style.margin = "0";

                // Mostra toggle se su mobile altrimenti rimuovi
                if(window.innerWidth <= 1024) {
                    toggleButton.style.position = "static";
                    toggleButton.style.margin = "1em";
                    toggleButton.setAttribute("tabindex", "0");
                } else {
                    toggleButton.style.position = "absolute";
                    toggleButton.style.margin = "-9999em";
                    toggleButton.setAttribute("tabindex", "-1");
                }

                // Mostra campi input
                inputs.forEach(input => {
                    input.setAttribute("tabindex", "0");
                    input.style.position = "static";
                    input.style.margin = "0";
                });
            } else {
                // Rimuovi menù
                filterForm.style.position = "absolute";
                filterForm.style.margin = "-9999em";

                // Rimuovi toggle non serve perché su mobile

                // Rimuovi campi input
                inputs.forEach(input => {
                    input.setAttribute("tabindex", "-1");
                    input.style.position = "absolute";
                    input.style.margin = "-9999em";
                });
            }
        }

        // Ascolta pressioni toggle
        toggleButton.addEventListener("click", function() {
            // Cambio stato ed espansione/riduzione menù
            toggleInput.checked = !toggleInput.checked;
            filterOpenClose();

            // Impostazione ARIA attributes
            toggleButton.setAttribute('aria-expanded', toggleInput.checked.toString());
            toggleButton.setAttribute('aria-label', toggleInput.checked ? 'Seleziona per comprimere il form filtro' : 'Seleziona per espandere il form filtro');

            });

        // Esegui al caricamento e al resize
        window.addEventListener('resize', function() {
            toggleInput.checked = true;
            filterOpenClose();
        });
        window.addEventListener('DOMContentLoaded', function() {
            toggleInput.checked = true;
            filterOpenClose();
        });

    }

}