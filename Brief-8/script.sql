/*CREATION D'UNE BASE DE DONNEES*/
CREATE SCHEMA hotel;
USE hotel;

DROP TABLE IF EXISTS Chambre;

DROP TABLE IF EXISTS Hotel;

DROP TABLE IF EXISTS Personne;

DROP TABLE IF EXISTS SalleDeBain;

DROP TABLE IF EXISTS association5;

/*==============================================================*/
/* Table : Chambre                                              */
/*==============================================================*/
create table Chambre
(
   adresse              varchar(254) not null,
   numero               int not null,
   Sal_numero           int,
   nblit                int,
   prix                 float,
   etage                int,
   primary key (adresse, numero)
);

/*==============================================================*/
/* Table : Hotel                                                */
/*==============================================================*/
CREATE TABLE Hotel
(
   adresse              varchar(254) not null,
   nbrchambre           int,
   primary key (adresse)
);

/*==============================================================*/
/* Table : Personne                                             */
/*==============================================================*/
create table Personne
(
   nom                  varchar(254),
   age                  int,
   sexe                 varchar(254),
   id                   int not null,
   adresse              varchar(254),
   primary key (id),
   key AK_Identifiant_1 (id)
);

/*==============================================================*/
/* Table : SalleDeBain                                          */
/*==============================================================*/
create table SalleDeBain
(
   etage                int,
   numero               int not null,
   primary key (numero)
);

/*==============================================================*/
/* Table : association5                                         */
/*==============================================================*/
create table association5
(
   id                   int not null,
   adresse              varchar(254) not null,
   numero               int not null,
   primary key (adresse, id, numero)
);

alter table Chambre add constraint FK_association1 foreign key (adresse)
      references Hotel (adresse) on delete restrict on update restrict;

alter table Chambre add constraint FK_association2 foreign key (Sal_numero)
      references SalleDeBain (numero) on delete restrict on update restrict;

alter table Personne add constraint FK_association4 foreign key (adresse)
      references Hotel (adresse) on delete restrict on update restrict;

alter table association5 add constraint FK_association5 foreign key (adresse, numero)
      references Chambre (adresse, numero) on delete restrict on update restrict;

alter table association5 add constraint FK_association6 foreign key (id)
      references Personne (id) on delete restrict on update restrict;
      
/*INSERTION DANS TABLE HOTEL*/
INSERT INTO Hotel (adresse, nbrchambre) VALUES ('4R7WI82QBRAPMH', 4);

INSERT INTO Hotel (adresse, nbrchambre) VALUES ('AA2GG 06C5', 0);

INSERT INTO Hotel (adresse, nbrchambre) VALUES ('4JJ5GES3RJGU7NVO', 7);

INSERT INTO Hotel (adresse, nbrchambre) VALUES ('5DV 6P9VVSJC4R', 17);

INSERT INTO Hotel (adresse, nbrchambre) VALUES ('GCXXQXIRL9RL5175', 2);

INSERT INTO Hotel (adresse, nbrchambre) VALUES ('RT1PE5733D6L3JE', 15);

insert into Hotel (adresse, nbrchambre) values ('9VYX8D6MSNAEQCLR', 10);

/*INSERTION DANS TABLE PERSONNE	*/

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('3CPG8RBWGI0', 6, 'LLGAMHPYTVL33BX6FDV', 5, 'DS33D6L3JE');

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('U4W41NS5R0', 13, 'S2R64QU3BGO5');

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('66A4IJBTXCR', 14, '7WQWTUA3B4TGVSF', 10, 'RO2KEI8O83DV3');

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('FRJK0MTX74V 2J61', 4, '3KLWCDWMDOQTV', 12, '5ISLG0NO5XC4R');

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('A8XICA1I2AK2', 11, '5I1BTN2Q6FMGHAP', 0, 'GHGM61J8RRL5175');

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('68LVY4P0 PD3O NP7S4GN4O3R9', 3, '5MCW8UJDW56', 14, 'BRAPMH');

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('EOM88LKFD9LX', 12, 'T K6PN0O73', 16, 'ESJVK9MH37BY');

INSERT INTO Personne (nom, age, sexe, id, adresse) VALUES ('K6O56F4AMNOJ3CD65C', 2, 'WHUM OTMJ31D B', 15, 'W1X0IR4Q395C');

/*INSERTION DANS TABLE SALLE DE BAIN*/
INSERT INTO SalleDeBain (etage, numero) VALUES (19, 14);

INSERT INTO SalleDeBain (etage, numero) VALUES (11, 4);

INSERT INTO SalleDeBain (etage, numero) VALUES (14, 11);

INSERT INTO SalleDeBain (etage, numero) VALUES (4, 9);

INSERT INTO SalleDeBain (etage, numero) VALUES (8, 5);

INSERT INTO SalleDeBain (etage, numero) VALUES (15, 13);

INSERT INTO SalleDeBain (etage, numero) VALUES (6, 3);

INSERT INTO SalleDeBain (etage, numero) VALUES (7, 10);

INSERT INTO SalleDeBain (etage, numero) VALUES (10, 18);

INSERT INTO SalleDeBain (etage, numero) VALUES (0, 8);

/*INSERTION DANS TABLE CHAMBRE*/
INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('5DV5ddddddd4R', 9, 4, 5, 10, 15);

INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('H6PQJ01S83DV3', 17, 1, 2, 7, 13);

INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('OE811R4AWBBPAL8H5', 14, 1, 8, 3, 3);

INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('W1X0Q3BX4Q395C', 0, 15, 16, 17, 11);

INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('EYX6BKG6537BY', 11, 9, 13, 11, 14);

INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('LEOY6HHHET9M96', 4, 9, 10, 8, 5);

INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('KHO8P6CCB1V4I', 2, 6, 7, 12, 2);

INSERT INTO Chambre (adresse, numero, Sal_numero, nblit, prix, etage) VALUES ('BA1463SM18JESRUGG7', 5, 6, 0, 6, 19);

/*INSERTION DANS TABLE association5*/
INSERT INTO association5 (id, adresse, numero) VALUES (2, '4R7WIXMTAN8882QBRAPMH', 19);

INSERT INTO association5 (id, adresse, numero) values (18, 'AALUQU3CVI6DIECBGO5', 15);

INSERT INTO association5 (id, adresse, numero) values (5, '4JPFWPVJ5WCS3RJGU7NVO', 13);

INSERT INTO association5 (id, adresse, numero) values (4, '5DV 6P94CU2P9JJA', 9);

INSERT INTO association5 (id, adresse, numero) VALUES (0, '4DRYYLK78N89KK3L', 3);

INSERT INTO association5 (id, adresse, numero) VALUES (8, 'M8X6F2BR1BXJLLSQDDFB', 6);

INSERT INTO association5 (id, adresse, numero) VALUES (6, 'H6PU5BKQN0QO9MDV3', 17);

INSERT INTO association5 (id, adresse, numero) VALUES (3, 'RTP2JQOAEQCLR', 14);

INSERT INTO association5 (id, adresse, numero) VALUES (17, 'RTP2JQOAEQCLR', 8);

INSERT INTO association5 (id, adresse, numero) VALUES (19, '8PKQMLRHMQDRLQJ75', 0);

INSERT INTO association5 (id, adresse, numero) VALUES (11, '41N5P3L479KG65', 11);

INSERT INTO association5 (id, adresse, numero) VALUES (1, 'OHEBC6HHHET9M96', 4);

INSERT INTO association5 (id, adresse, numero) VALUES (7, 'KOI9QE05HOVBIO', 18);

INSERT INTO association5 (id, adresse, numero) VALUES (16, 'TQO8DCPPV80KBUIC', 10);

INSERT INTO association5 (id, adresse, numero) VALUES (13, ' 7NANWTK3V3GLYW', 2);

INSERT INTO association5 (id, adresse, numero) VALUES (15, 'C39E1JBCB1V4I', 5);


/*DELETE depuis un TABLE */
DELETE  FROM Hotel WHERE nbrchambre=4;
DELETE FROM Personne WHERE age= 12;
DELETE FROM SalleDeBain WHERE etage=8;
DELETE FROM chambre WHERE numero=9 ;
DELETE FROM association5 WHERE id=15 ;

/*MODIFICATION D'UN CONTENU*/
UPDATE Hotel SET nbrchambre=5 WHERE nbrchambre=0;
UPDATE Personne SET adresse='Safi' WHERE adresse='W1X0IR4Q395C';
UPDATE SalleDeBain SET numero=20 WHERE numero=10 ;
UPDATE chambre SET prix=200 WHERE prix=3 ;
UPDATE association5 SET adresse='MARAKKECH' WHERE adresse='7NANWTK3V3GLYW';

