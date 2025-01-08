create table Auto
(
    id             int auto_increment
        primary key,
    condizione     varchar(30) null,
    prezzo         double      null,
    marca          varchar(30) not null,
    modello        varchar(30) not null,
    anno           int         not null,
    chilometraggio int         null,
    alimentazione  varchar(30) null,
    cambio         varchar(30) null,
    trazione       varchar(30) null,
    potenza        int         null,
    peso           int         null,
    neopatentati   int         null,
    numeroPosti    int         null,
    colore         varchar(30) not null
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
    constraint Prenotazione_Auto_id_fk
        foreign key (idAuto) references Auto (id),
    constraint Prenotazione_Utente_username_fk
        foreign key (username) references Utente (username)
);


