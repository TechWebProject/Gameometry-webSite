drop table if exists Recensione;
drop table if exists Videogioco;
drop table if exists Commento;
drop table if exists Utente;

CREATE TABLE Recensione(
    idRecensione VARCHAR(30) PRIMARY KEY
    voto INTEGER NOT NULL
    contenuto TEXT NOT NULL
    titolo VARCHAR(200) NOT NULL
    dataPubblicazione DATE NOT NULL
    FOREIGN KEY(idVideogioco) REFERENCES Videogioco(titolo) on update cascade on delete cascade
);

CREATE TABLE Videogioco(
    titolo VARCHAR(100) PRIMARY KEY
    rilascio DATE NOT NULL
    casaProduttrice VARCHAR(50) NOT NULL
    /*locandina DECIDERE*/
    trama TEXT NOT NULL
    /*genere CREARE DOMINIO*/
    /*piattaforma CREARE DOMINIO*/
);

CREATE TABLE Commento(
    idCommento VARCHAR(30) PRIMARY KEY
    data DATE NOT NULL
    voto FLOAT(1,1)
    contenuto VARCHAR(900) NOT NULL
    FOREIGN KEY(idUtente) REFERENCES Utente(email) on update cascade on delete cascade
);

CREATE TABLE Utente(
    email VARCHAR(100) PRIMARY KEY
    nickname VARCHAR(30) UNIQUE NOT NULL
    password VARCHAR(30) NOT NULL
    /*immagineProfilo DECIDERE*/
);
