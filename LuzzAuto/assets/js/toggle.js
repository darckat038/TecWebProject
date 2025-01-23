document.addEventListener("DOMContentLoaded", function () {
    // Gestione menù ad hamburger
    adjustMenuOnResize();
    // Evento click filtro listino
    switchToggle();
});
/*
* Gestione menù ad hamburger
*/
function adjustMenuOnResize() {
    let menu = document.getElementById("menu");
    let tasto = document.getElementById("menu-button-container");
    let links = menu.querySelectorAll("a");
    function menuOpenClose() {
        // Cambia tra menù visibile e nascosto
        if (tasto.classList.contains("change")) {
            menu.style.position = "static";
            menu.style.margin = "0";
            if (window.innerWidth > 1024) menu.style.marginLeft = "auto";
            else menu.style.marginTop = "3.5em";
            menu.setAttribute("tabindex","0");
            links.forEach(link => {
                link.setAttribute("tabindex", "0");
                link.style.pointerEvents = (link.id === "here" ? "none" : "auto");
            });
            tasto.setAttribute("aria-label","Seleziona per comprimere il menù di navigazione");
        } else {
            menu.style.position = "absolute";
            menu.style.margin = "-9999em";
            menu.setAttribute("tabindex","-1");
            links.forEach(link => {
                link.setAttribute("tabindex", "-1");
                link.style.pointerEvents = "none";
            });
            tasto.setAttribute("aria-label","Seleziona per espandere il menù di navigazione");
        }
    }
    // Esegui al caricamento e al resize
    if (window.innerWidth > 1024) tasto.classList.add("change");
    else tasto.classList.remove("change");
    menuOpenClose();
    window.addEventListener('resize', function(){
        if (window.innerWidth > 1024) tasto.classList.add("change");
        else tasto.classList.remove("change");
        menuOpenClose();
    });
    tasto.addEventListener('click', function() {
        // Cambia tra linee e croce
        tasto.classList.toggle("change");   
        menuOpenClose();
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
                    if(!input.classList.contains("list_button")) input.style.margin = "0";
                    else input.style.margin = "3em auto 0";
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
        toggleInput.checked = true;
        filterOpenClose();
        window.addEventListener('resize', function() {
            toggleInput.checked = true;
            filterOpenClose();
        });
    }
}