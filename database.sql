PRAGMA foreign_keys = ON;

CREATE TABLE produits (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    prix REAL NOT NULL,
    quantiteStock INTEGER NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
);

CREATE TABLE caisse(
    idCaisse INTEGER PRIMARY KEY AUTOINCREMENT,
    numeroCaisse TEXT NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
);

CREATE TABLE achat(
    idAchat INTEGER PRIMARY KEY AUTOINCREMENT,
    dateAchat DATETIME,
    total REAL,
    idCaisse INTEGER,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY(idCaisse)
    REFERENCES caisse(idCaisse)
);

CREATE TABLE detail_achat(
    idDetail INTEGER PRIMARY KEY AUTOINCREMENT,
    quantite INTEGER,
    prixUnitaire REAL,
    idAchat INTEGER,
    idProduit INTEGER,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY(idAchat)
    REFERENCES achat(idAchat),
    FOREIGN KEY(idProduit)
    REFERENCES produit(idProduit)
);




-------INSERTION DES DONNEES

INSERT INTO produits(designation,prix,quantiteStock) VALUES ('Riz', 3500, 100);

INSERT INTO produit(designation,prix,quantiteStock)
VALUES('Huile',8000,50);

INSERT INTO produit(designation,prix,quantiteStock)
VALUES('Sucre',4000,80);

INSERT INTO produit(designation,prix,quantiteStock)
VALUES('Savon',1500,120);

INSERT INTO produit(designation,prix,quantiteStock)
VALUES('Lait',2500,60);

INSERT INTO caisse(numeroCaisse) VALUES ('C001');

INSERT INTO caisse(numeroCaisse) VALUES ('C002');

