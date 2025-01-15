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
    foto           varchar(255) null
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
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('UniPD - Universal Premium Design', 'BotanicOrt', 'KM 0', 28000, 2022, 0, 'Grigio', 'Ibrido Plug-in', 'Automatico', 'Anteriore', 160, 1400, 0, 5, 'botanicort.png+botanicort-interni.png');

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('UniPD - Universal Premium Design', 'Planetary', 'Nuovo', 38500, 2024, 0, 'Blu chiaro', 'Ibrido Plug-in', 'Automatico', 'Anteriore', 150, 1705, 0, 8, 'planetary.png+planetary-interni.png');

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('UniPD - Universal Premium Design', 'Scrovenger', 'Nuovo', 42000, 2024, 0, 'Nero', 'Ibrido Plug-in', 'Automatico', 'Integrale', 180, 1850, 0, 5, 'scrovenger.png+scrovenger-interni.png');

/* EXFiat */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('EXFiat - EXcellence Fiat', 'Panda Limo', 'Usato', 18000, 2006, 190000, 'Rosso', 'Benzina', 'Manuale', 'Integrale', 47, 1960, 1, 3, 'panda-limo-1.png+panda-limo-2.png+panda-limo-3.gif+panda-limo-interni.png');

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('EXFiat - EXcellence Fiat', 'Due Cavalli', 'Usato', 15000, 2024, 12000, 'Verde', 'Ibrido GPL', 'Manuale', 'Anteriore', 2, 500, 1, 4, 'due-cavalli.jpeg');

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('EXFiat - EXcellence Fiat', 'Nove Renne', 'Usato', 0, 1823, 1320000000, 'Rosso', 'Ibrido GPL', 'Manuale', 'Anteriore', 1000000, 800, 0, 1, 'nove-renne.jpeg');

/* ESU */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('ESU - European Sports Unlimited', 'Piövegg', 'Nuovo', 2300000, 2023, 0, 'Nero', 'Gasolio', 'Manuale', 'Posteriore', 1000, 1300, 0, 2, 'piövegg-1.jpg+piövegg-2.jpg+piövegg-interni.jpg');

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('ESU - European Sports Unlimited', 'Muriald', 'KM 0', 1200000, 2020, 0, 'Verde chiaro', 'Benzina', 'Automatico', 'Integrale', 850, 1400, 0, 2, 'muriald.jpeg+muriald-interni.jpeg');

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('ESU - European Sports Unlimited', 'Belzuny', 'Nuovo', 56600, 2024, 0, 'Blu chiaro', 'Gasolio', 'Automatico', 'Integrale', 450, 2200, 0, 5, 'belzuny.jpeg+belzuny-interni.jpeg');

/* DM */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('DM - Digital Motion', 'Archimedial', 'KM 0', 17000, 2022, 0, 'Bianco', 'Elettrico', 'Automatico', 'Anteriore', 95, 1200, 1, 5, 'archimedial.jpeg+archimedial-interni.jpeg');

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('DM - Digital Motion', 'Mudol', 'Nuovo', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 'mudol.jpeg+mudol-interni.jpeg');

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
    stato: 0=?, 1=confermata, -1=?

    ESEMPIO DI INSERIMENTO DI UNA PRENOTAZIONE:
    INSERT INTO Prenotazione (username, idAuto, dataOra, stato)
    VALUES ('mario.rossi', 1, '2024-01-01 12:00:00', 0);
*/