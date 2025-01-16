document.addEventListener("DOMContentLoaded", function () {
    const messages = [
        "<h2>Ehi! Sei fuori pista!</h2>         <p><a href='/'>Chiama la safety car e torna alla <span lang='en-GB'>home</span></a></p>",
        "<h2>Oh, hai sbagliato strada?</h2>     <p><a href='/'>Usa il navigatore e torna alla <span lang='en-GB'>home</span></a></p>",
        "<h2>Nebbia fitta all'orizzonte!</h2>   <p><a href='/'>Accendi i fari antinebbia e torna alla <span lang='en-GB'>home</span></a></p>",
        "<h2>Strada chiusa per lavori in corso.</h2>     <p><a href='/'>Trova un percorso alternativo e torna alla <span lang='en-GB'>home</span></a></p>",
        "<h2>Hai forato!</h2>                   <p><a href='/'>Chiama il carro attrezzi e torna alla <span lang='en-GB'>home</span></a></p>",
        "<h2>Bandiera nera!</h2>                <p><a href='/'>Fermati ai box e torna alla <span lang='en-GB'>home</span></a></p>"
    ];

    // Scegli un messaggio casualmente
    const randomMessage = messages[Math.floor(Math.random() * messages.length)];

    // Mostra il messaggio nella pagina
    document.getElementById('message').innerHTML = randomMessage;
});