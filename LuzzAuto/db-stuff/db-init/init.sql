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


INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
VALUES ('DM - Digital Motion', 'Mudol', 'Nuova', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 'mudol.jpeg+mudol-interni.jpeg');