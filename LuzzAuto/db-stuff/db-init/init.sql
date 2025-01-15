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
    marca: per esteso; se necessario sigla e nome, es. "DM - Digital Motion", sempre con questo formato
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

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('DM - Digital Motion', 'Mudol', 'Nuovo', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 'mudol.jpeg+mudol-interni.jpeg');