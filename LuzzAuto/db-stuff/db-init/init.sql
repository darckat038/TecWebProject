/* Se hai bisogno di aggiungere qualcosa, segui le indicazioni sotto. */
create table Veicolo
(
    id             int auto_increment
        primary key,
    marca          varchar(32) not null,
    modello        varchar(30) not null,
    condizione     varchar(30) null,
    prezzo         double      null,
    anno           int         not null,
    chilometraggio int         null,
    colore         varchar(30) not null,
    alimentazione  varchar(30) null,
    cambio         varchar(30) null,
    trazione       varchar(30) null,
    potenza        int         null,
    peso           int         null,
    neopatentati   int         null,
    numeroPosti    int         null,
    foto           varchar(255) null,
    alts           text        null
);

create table Utente
(
    username    varchar(30)  not null
        primary key,
    password    varchar(255) not null,
    nome        varchar(30)  not null,
    cognome     varchar(30)  not null,
    dataNascita date         not null
);

create table Prenotazione
(
    codice   int auto_increment
        primary key,
    username varchar(30) not null,
    idAuto   int         not null,
    dataOra  datetime    not null,
    stato    int         not null,
    constraint Prenotazione_Veicolo_id_fk
        foreign key (idAuto) references Veicolo (id),
    constraint Prenotazione_Utente_username_fk
        foreign key (username) references Utente (username)
);


/*
INSERIMENTO UTENTI BASE
*/
INSERT INTO Utente (username, password, nome, cognome, dataNascita) VALUES ("user", "$2y$10$1dHGE98yho9p0CmQifWsROlgG/eScdJhIQhiwx9gqHBUz5hPHCYJ6", "user", "user", "2025-01-01");
INSERT INTO Utente (username, password, nome, cognome, dataNascita) VALUES ("admin", "$2y$10$lWpeMfosLTT14Ex827SfKOk0E22zml9vuvqcH0BpICKB6r1qUwwnS", "admin", "admin", "2025-01-01");

/*
    TABELLA Veicolo:

                                    ### LINEE GUIDA: ###
    marca: per esteso; se necessario sigla e nome, es. "DM - Digital Motion", sempre con questo formato. Inoltre deve essere uguale a come è scritto nel folder img/Cars/
    modello: stringa, sempre con la maiuscola iniziale
    condizione: solo "Nuovo", "Usato" o "KM 0"
    prezzo: double, no apostrofi o altre cose strane
    anno: int
    chilometraggio: int
    colore: stringa a piacere ma non mettere cose troppo complesse come "Blu metallizzato fiordaliso", meglio "Blu chiaro", sempre con la maiuscola iniziale
    alimentazione: solo "Benzina", "Gasolio", "Elettrico", "Ibrido GPL" o "Ibrido Plug-in"
    cambio: solo "Manuale" o "Automatico"
    trazione: solo "Anteriore", "Posteriore" o "Integrale"
    potenza: int
    peso: int
    neopatentati: 0=non abilitati, 1=abilitati
    numeroPosti: int
    foto: nome del file immagine, se ce ne sono più di una separare con "+", es. "mudol.jpeg+mudol-interni.jpeg"; ATTENZIONE: in listino la copertina è sempre la prima foto

    Attenzione alle maiuscole ed agli spazi nelle stringhe.

    ESEMPIO DI INSERIMENTO DI UN VEICOLO:
    INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
    VALUES ('DM - Digital Motion', 'Mudol', 'Nuovo', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 'mudol.jpeg+mudol-interni.jpeg');
*/

/* UniPD */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('UniPD - Universal Premium Design', 'BotanicOrt', 'KM 0', 28000, 2022, 0, 'Grigio', 'Ibrido Plug-in', 'Automatico', 'Anteriore', 160, 1400, 0, 5, 
    'botanicort.png+botanicort-interni.png', 
    "Auto berlina grigia metallizzata, quattro porte, design elegante e moderno.+
    Interni di lusso con sedili in pelle marrone, finiture in legno e schermo di infotainment.");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('UniPD - Universal Premium Design', 'Planetary', 'Nuovo', 38500, 2024, 0, 'Blu chiaro', 'Ibrido Plug-in', 'Automatico', 'Anteriore', 150, 1705, 0, 8, 
    'planetary.png+planetary-interni.png', 
    "Auto monovolume moderna blu brillante, cinque porte, grandi finestrini, fari a LED. Design elegante con cerchi in lega stilosi.+
    Interni beige in pelle, cruscotto in legno, touchscreen grande e tetto panoramico.");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('UniPD - Universal Premium Design', 'Scrovenger', 'Nuovo', 42000, 2024, 0, 'Nero', 'Ibrido Plug-in', 'Automatico', 'Integrale', 180, 1850, 0, 5, 
    'scrovenger.png+scrovenger-interni.png', 
    "Station wagon nera, elegante con linee affilate, grandi ruote in lega, vetri oscurati. Design moderno e sofisticato.+
    Sedili in pelle beige, console centrale e cruscotto marroni, grande schermo touchscreen e tetto panoramico.");

/* EXFiat */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('EXFiat - EXcellence Fiat', 'Panda Limo', 'Usato', 18000, 2006, 190000, 'Rosso', 'Benzina', 'Manuale', 'Integrale', 47, 1960, 1, 3, 
    'panda-limo-1.png+panda-limo-2.png+panda-limo-3.gif+panda-limo-interni.png',
    "Auto limousine rossa, due porte, design unico e inusuale.+
    Auto limousine rossa, due porte, vari finestrini sulla fiancata destra.+
    Immagine animata che mostra Panda Limo in movimento da sinistra a destra.+
    Interni in velluto rosso, spazi ampi. Design retrò.");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('EXFiat - EXcellence Fiat', 'Due Cavalli', 'Usato', 15000, 2024, 12000, 'Verde', 'Ibrido GPL', 'Manuale', 'Anteriore', 2, 500, 1, 4, 
    'due-cavalli.jpeg',
    "Carrozza tradizionale, colore verde scuro con ruote rosse. I sedili sono neri.");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('EXFiat - EXcellence Fiat', 'Nove Renne', 'Usato', 0, 1823, 1320000000, 'Rosso', 'Ibrido GPL', 'Manuale', 'Anteriore', 1000000, 800, 0, 1, 
    'nove-renne.jpeg',
    "Slitta vintage di colore rosso con un sedile in pelle imbottita. Corpo in legno con lati curvi e decorativi, pattini metallici.");

/* ESU */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('ESU - European Sports Unlimited', 'Piövegg', 'Nuovo', 2300000, 2023, 0, 'Nero', 'Gasolio', 'Manuale', 'Posteriore', 1000, 1300, 0, 2, 
    'piövegg-1.jpg+piövegg-2.jpg+piövegg-interni.jpeg',
    "Auto sportiva nero opaco, due porte, design aerodinamico, grandi ruote stilose, dettagli intricati. Vista posteriore a tre quarti.+
    Auto sportiva nera, due porte, design aerodinamico e linee affilate, fari LED allungati, griglia a maglia e prese d'aria sul cofano.+
    Interni lussuosi con sedili in pelle nera, cruscotto nero e schermo touchscreen.");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('ESU - European Sports Unlimited', 'Muriald', 'KM 0', 1200000, 2020, 0, 'Verde chiaro', 'Benzina', 'Automatico', 'Integrale', 850, 1400, 0, 2, 
    'muriald.jpeg+muriald-interni.jpeg',
    "Auto sportiva verde brillante, due porte, design aerodinamico e aggressivo. Fari angolari moderni, grandi ruote nere.+
    Interni di lusso con sedili in pelle verde, cruscotto digitale e volante coordinato.");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('ESU - European Sports Unlimited', 'Belzuny', 'Nuovo', 56600, 2024, 0, 'Arancione', 'Gasolio', 'Automatico', 'Integrale', 450, 2200, 0, 5, 
    'belzuny.jpeg+belzuny-interni.jpeg',
    "Auto SUV arancione brillante, quattro porte, design grintoso con linee affilate, grandi ruote nere. Luci LED moderne e griglia prominente.+
    Interni lussuosi con sedili in pelle nera inserti arancioni, cruscotto marrone e grande schermo touchscreen.");

/* DM */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('DM - Digital Motion', 'Archimedial', 'KM 0', 17000, 2022, 0, 'Bianco', 'Elettrico', 'Automatico', 'Anteriore', 95, 1200, 1, 5, 
    'archimedial.jpeg+archimedial-interni.jpeg',
    "City car bianca, design moderno e futuristico, quattro porte, tetto nero a contrasto, fari angolari a LED e cerchi sportivi a più razze.+
    Gli interni dell'auto sono eleganti e moderni, con sedili in similpelle, un cruscotto spazioso e un ampio touchscreen.");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('DM - Digital Motion', 'Mudol', 'Nuovo', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 
    'mudol.jpeg+mudol-interni.jpeg',
    "Auto berlina grigio chiaro metallizzata, quattro porte, design elegante e lineare, con fari affilati e una griglia aerodinamica.+
    Interni con sedili in similpelle, cruscotto digitale, ampio schermo centrale, striscia LED soffusa. Design lussuoso e moderno.");

/* ? */











/*
    TABELLA Utente:

                                    ### LINEE GUIDA: ###
    username: stringa, non più lunga di 30 caratteri
    password: stringa, non più lunga di 255 caratteri
    nome: stringa, non più lunga di 30 caratteri
    cognome: stringa, non più lunga di 30 caratteri
    dataNascita: data, formato "YYYY-MM-DD"

    ESEMPIO DI INSERIMENTO DI UN UTENTE:
    INSERT INTO Utente (username, password, nome, cognome, dataNascita)
    VALUES ('mario.rossi', 'password', 'Mario', 'Rossi', '1990-01-01');
*/








/*
    TABELLA Prenotazione:

                                    ### LINEE GUIDA: ###
    username: stringa, non più lunga di 30 caratteri
    idAuto: int, corrispondente all'id del veicolo
    dataOra: data e ora, formato "YYYY-MM-DD HH:MM:SS"
    stato: 0=pendente, 1=confermata, -1=rifiutata

    ESEMPIO DI INSERIMENTO DI UNA PRENOTAZIONE:
    INSERT INTO Prenotazione (username, idAuto, dataOra, stato)
    VALUES ('mario.rossi', 1, '2024-01-01 12:00:00', 0);
*/