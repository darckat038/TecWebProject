# Controlli accessibilità e ritrutturazioni (Emanuele, progressi segnati tra parentesi)
- [x] validator.w3.org D:

- [x] Aggiungere tabindex (accesskey) su tutti i link/funzionalità (TEST NVDA) (Emanuele)  
(OK: in generale)

- [ ] Sistemare tutti i warning di Lighthouse -> ridotto dimensioni imgs -> ora bisogna minify js e optimize css (prestazioni mediocri mobile)

- [x] Sistemare tutti i warning di Wave  
(OK: 403, 404, 500, about, amministratore, auto, index, listino, login, modificautente, registrazione, testdrive, utente)

- [x] Sistemare tutti i warning di WCAG Color checker  
(OK: 403, 404, 500, about, amministratore, auto, index, listino, login, modificautente, registrazione, testdrive, utente)

- [x] Check con IE11  
(OK: 403, 404, 500, about, amministratore, auto, index, listino, login, modificautente, registrazione, testdrive, utente)

- [x] Mettere placeholders di esempio in tutti gli input type text dei form (es: placeholder="Es. Fiat, Toyota, Tesla", placeholder="gg/mm/aaaa")  
(OK: 403, 404, 500, about, amministratore, auto, index, listino, login, modificautente, registrazione, testdrive, utente)

- [x] Togliere tutti gli attributi aria-label negli input di tutti i form a cui è già associata una label con il tag html  
(OK: 403, 404, 500, about, amministratore, auto, index, listino, login, modificautente, registrazione, testdrive, utente)

- [x] Aggiungere anche ontap oltre che onclick perchè i cellulari vecchi non fanno la conversione
  
# ALTRE MODIFICHE DA IMPLEMENTARE E DOCUMENTARE IN RELAZIONE

- [x] Inserire la possibilità per l'utente di eliminare i suoi dati del profilo

- [x] Aggiungere tag time/date in tabelle amministratore e utente

- [x] Nella pagina about.html dichiarare che il link con la mail porta effettivamente alla mail : indirizzomail@luzzauto.com(mail)

- [x] Modificare title area personale: NO username -> SI Area Personale | LuzzAuto Concessionario

- [x] Fix background troppo corto mobile in registrazione login utente amministratore

- [x] Attributo enctype nel form aggiunta auto (vedi_slide:93 pdf:html)

- [x] Modifica select auto in test_drive e amministratore (vedi_slide:95 pdf:html)

- [x] Tabella responsive mobile in utente e amministratore (vedi_slide:74 pdf:accessibilità)

- [x] Testo giustificato nel print.css

- [x] Agguingere "skip to content" in tutte le pagine

- [x] Controllare le description di tutte le pagine (max: 145 caratteri)

- [x] Controllare "above the fold" in tutte le pagine

- [x] Controllare/modificare messaggi errore/successo di tutte le form (vedi_slide:122 pdf:principi di web design)

- [x] Nella pagina about togliere l'immagine della mappa e mettere solo un testo con l'indirizzo del concessionario e altre info

- [x] .manifest ??? (vedi_slide:113 pdf:html) -> NO

- [x] Fare bene le pagine 404.html 403.html 500.html rassicurando l'utente (Emanuele)

- [x] Impedire l'accesso diretto alle risorse della cartella assets

- [x] Rimuovere file php_info.php

- [x] Sistemare dimensioni file immagini (max 1MB) (Emanuele)

- [x] Rimuovere tutti i display: none (Emanuele) (PAIN)

- [x] Rimuovere exit da codice php amministratore primi 2 forms

- [x] Fare Js form gestione prenotazioni amministratore

- [x] In listino tenere come carburanti: Gasolio, Benzina, Elettrico, Ibrido, Metano

- [x] Modificare select auto test_drive e amministratore usando solo l'id nel value

- [x] Sistemare la dl nel dettaglio auto: dd e dt sono invertiti

- [x] Rimuovere i console.log nel js

- [x] Fixare tutti i dl (vedi about.html)

# RELAZIONE
- [ ] # !DOCUMENTARE TUTTE LE COSE CHE PUO' FARE L'UTENTE

- [ ] Mettere nella relazione che abbiamo tolto i display none (tranne tabella responsive)

- [ ] Mettere nella relazione che abbiamo usato modalità IE11

- [ ] Nella relazione descrivere strategia mobile first

- [ ] Eseguire e descrivere nella relazione tutti i controlli sull'accessibilità eseguiti con i vari tool


## Aggiunta e modifica auto in catalogo
- [x] NO MODIFICA

## come fare inserimento immagini nel database?
- [x] COPIARE L'IMMAGINE CARICATA DALL'UTENTE NEL SERVER NELLA CARTELLA CORRETTA E IMPOSTARE IL PATH DELL'IMMAGINE NEL SERVER NEL CAMPO DEL DB

## come gestire testo "alt" delle immagini (js per corretta visualizzazione, come inserire nel form e salvare nel DB)?
- [x] L'AMMINISTRATORE NEL CAMPO DESCRIZIONE INSERISCE ALT CHE DEVE ESSERE DI MAX 100 CARATTERI

## I bottoni devono avere comunque il formato link (testo sottolineato ecc)?
- [x] I BOTTONI FUORI DAI FORM DEVONO AVERE DISTINTI IN VISITATI E NON VISITATI

## vale anche per i riquadri tipo i veicoli in listino?
- [x] METTERE LINK SOTTO CHE TI MANDA AL DETTAGLIO DELL'AUTO

## Devo controllare htmlspecialchars della password o non serve perchè non sarà mai visualizzata in chiaro?
- [x] NO

## Discorso reset button per form filtro listino
- [x] RIMUOVI FILTRI FA ANCHE RICERCA DEFAULT (CON FILTRI VUOTI)

## Link listino da breadcrumb auto deve contenere filtri di listino applicati?
- [x] NO

## Serve un banner per avviso utilizzo cookie?
- [x] NO

## Come font con le grazie va bene uno qualunque?
- [x] SI

## Per dei salvataggi di valori poco importanti va bene usare i cookies o quando possibile usare la sessione?
- [x] SI VA BENE COOKIES

## nome auto in index sezione ultimi arrivi
- [x] METTERE SFONDO NERO TESTO BIANCO E IL NOME DELA MACCHINA COME LINK - (Impostati utilizzando id attuali del DB, da cambiare eventualmente)

## abbreviazioni nei select
- [x] TOGLIERE I TAG abbr NEI SELECT

## breadcrumb nel listino
- [x] LINK LISTINO COME DEFAULT

## in dettaglio auto link listino auto nel menu cliccabile?
- [x] SI

## IL COLORE DEI LINK VISITATI DEVE ESSERE MANTENUTO ANCHE IN CASO DI HOVER? (VEDI TEST DRIVE)
- [x] PROBABILMENTE SI

- [x] Max file size tramite controllo php

- [ ] Non mettere codice css in js, usare metodo cambio classi

- [ ] In moodle caricare file che ci sono sul server

- [x] Div in Label ok

- [x] Display none tra mobile e desktop ok

- [ ] In relazione spiegare falsi positivi Total Validator