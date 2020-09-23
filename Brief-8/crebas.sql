/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de cr�ation :  26/04/2020 19:39:02                      */
/*==============================================================*/


DROP TABLE IF EXISTS Chambre;

DROP TABLE IF EXISTS Hotel;

DROP TABLE IF EXISTS Personne;

DROP TABLE IF EXISTS SalleDeBain;

DROP TABLE IF EXISTS association5;

/*==============================================================*/
/* Table : Chambre                                              */
/*==============================================================*/
CREATE TABLE Chambre
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
CREATE TABLE Personne
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
CREATE TABLE SalleDeBain
(
   etage                int,
   numero               int not null,
   primary key (numero)
);

/*==============================================================*/
/* Table : association5                                         */
/*==============================================================*/
CREATE TABLE association5
(
   id                   int not null,
   adresse              varchar(254) not null,
   numero               int not null,
   primary key (adresse, id, numero)
);

ALTER TABLE Chambre add CONSTRAINT FK_association1 foreign key (adresse)
      references Hotel (adresse) on delete restrict on update restrict;

ALTER TABLE Chambre add CONSTRAINT FK_association2 foreign key (Sal_numero)
      references SalleDeBain (numero) on delete restrict on update restrict;

ALTER TABLE Personne add CONSTRAINT FK_association4 foreign key (adresse)
      references Hotel (adresse) on delete restrict on update restrict;

ALTER TABLE association5 add CONSTRAINT FK_association5 foreign key (adresse, numero)
      references Chambre (adresse, numero) on delete restrict on update restrict;

ALTER TABLE association5 add CONSTRAINT FK_association6 foreign key (id)
      references Personne (id) on delete restrict on update restrict;

