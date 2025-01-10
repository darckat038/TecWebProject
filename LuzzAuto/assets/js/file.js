

//saluto in base all'ora del giorno
document.addEventListener("DOMContentLoaded", function(){
    const oraCorrente = new Date().getHours();
    const nomeUtente = "Giovanni";
    const salutoUtente = document.getElementById("saluto");
  
    let saluto = oraCorrente < 18 ? "Buongiorno" : "Buonasera";
    salutoUtente.textContent = `${saluto} ${nomeUtente}!`;
  });

  toggle