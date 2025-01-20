# DOMANDE

## È possibile usare una lista dl direttamente dentro un'altra dl? 
- [x] SI E' POSSIBILE

## È possibile avere un dl con all'interno div che contengono h3 e p al posto di dt e dd?
- [x] NO, RIMUOVERE I DIV, AL POSTO DI h3 USARE I dt CON SFONDO ICONA (AGGIUSTATA CON PADDING DELL'h3 SIZE E POSITION) E AL POSTO DEI p USARE I dd.

## Aggiunta e modifica auto in catalogo
- [ ] NO MODIFICA

## come fare inserimento immagini nel database?
- [ ] COPIARE L'IMMAGINE CARICATA DALL'UTENTE NEL SERVER NELLA CARTELLA CORRETTA E IMPOSTARE IL PATH DELL'IMMAGINE NEL SERVER NEL CAMPO DEL DB

## come gestire testo "alt" delle immagini (js per corretta visualizzazione, come inserire nel form e salvare nel DB)?
- [ ] L'AMMINISTRATORE NEL CAMPO DESCRIZIONE INSERISCE ALT CHE DEVE ESSERE DI MAX 100 CARATTERI

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

- [ ] # !DOCUMENTARE TUTTE LE COSE CHE PUO' FARE L'UTENTE


  
# ALTRE MODIFICHE DA IMPLEMENTARE E DOCUMENTARE IN RELAZIONE
- [x] Nella pagina about.html dichiarare che il link con la mail porta effettivamente alla mail : indirizzomail@luzzauto.com(mail)
- [ ] Modificare title area personale: NO username -> SI Area Personale | LuzzAuto Concessionario
- [ ] Fix background troppo corto mobile in registrazione login utente amministratore
- [ ] Attributo enctype nel form aggiunta auto (vedi_slide:93 pdf:html)
- [ ] Modifica select auto in test_drive e amministratore (vedi_slide:95 pdf:html)
- [ ] Tabella responsive mobile in utente e amministratore (vedi_slide:74 pdf:accessibilità)
- [ ] Testo giustificato nel print.css
- [ ] Aggiungere tabindex su tutti i link/funzionalità
- [ ] Mettere placeholders di esempio in tutti gli input type text dei form (es: Fiat)
- [ ] Agguingere "skip to content" in tutte le pagine
- [ ] Controllare le description di tutte le pagine (max: 145 caratteri)
- [ ] Controllare "above the fold" in tutte le pagine
- [ ] Controllare/mdificare messaggi errore/successo di tutte le form (vedi_slide:122 pdf:principi di web design)
- [x] Nella pagina about togliere l'immagine della mappa e mettere solo un testo con l'indirizzo del concessionario e altre info
- [ ] Aggiungere anche ontap oltre che onclick perchè i cellulari vecchi non fanno la conversione
- [ ] .manifest ??? (vedi_slide:113 pdf:html)
- [ ] Fare bene le pagine 404.html 403.html 500.html rassicurando l'utente
- [ ] Impedire l'accesso diretto alle risorse della cartella assets
- [ ] Dare enfasi ad alcune parole chiave con tag <em> e <strong>
- [ ] Nella relazione descrivere strategia mobile first
- [ ] Eseguire e descrivere nella relazione tutti i controlli sull'accessibilità eseguiti con i vari tool
- [ ] Rimuovere file php_info.php

