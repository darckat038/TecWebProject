/*
* Assicuriamo il funzionamento dell'espansione del filtro da mobile e la corretta gestione del aria-label
*/
function switchToggle() {

    let FilterMenu = document.getElementById("list_toggle_button");

    FilterMenu.addEventListener("click", function() {
        const toggleButton = document.getElementById('list_toggle_button');
        const toggleInput = document.getElementById('list_toggle_filter');
        const filterForm = document.getElementById('list_filter_form');

        toggleInput.checked = !toggleInput.checked;
        toggleButton.setAttribute('aria-expanded', toggleInput.checked.toString());
        toggleButton.setAttribute('aria-label', toggleInput.checked ? 'Seleziona per comprimere il form filtro' : 'Seleziona per espandere il form filtro');
    });   
}
