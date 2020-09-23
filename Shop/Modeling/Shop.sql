/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  6/2/2020 5:57:45 PM                      */
/*==============================================================*/


drop table if exists CATEGORIE;

drop table if exists CLIENT;

drop table if exists COMMANDE;

drop table if exists COMMANDE_PF;

drop table if exists COMMANDE_PRODUIT;

drop table if exists PANIERFIX;

drop table if exists PRODUIT;

drop table if exists PRODUIT_PF;

/*==============================================================*/
/* Table : CATEGORIE                                            */
/*==============================================================*/
create table CATEGORIE
(
   ID_CATEGORIE         int not null auto_increment,
   C_NOM                varchar(255) not null,
   primary key (ID_CATEGORIE)
);

/*==============================================================*/
/* Table : CLIENT                                               */
/*==============================================================*/
create table CLIENT
(
   ID_CLIENT            int not null auto_increment,
   NOM                  varchar(255) not null,
   PRENOM               varchar(255) not null,
   EMAIL                varchar(255) not null,
   PASSWORD             varchar(255) not null,
   ROLE                 varchar(255) not null,
   primary key (ID_CLIENT)
);

/*==============================================================*/
/* Table : COMMANDE                                             */
/*==============================================================*/
create table COMMANDE
(
   ID_COMMANDE          int not null auto_increment,
   ID_CLIENT            int not null,
   CC_NUM               int not null,
   CC_EXP               int not null,
   CC_CVV               int not null,
   primary key (ID_COMMANDE)
);

/*==============================================================*/
/* Table : COMMANDE_PF                                          */
/*==============================================================*/
create table COMMANDE_PF
(
   ID_PANIER            int not null,
   ID_COMMANDE          int not null,
   primary key (ID_PANIER, ID_COMMANDE)
);

/*==============================================================*/
/* Table : COMMANDE_PRODUIT                                     */
/*==============================================================*/
create table COMMANDE_PRODUIT
(
   ID_PRODUIT           int not null,
   ID_COMMANDE          int not null,
   primary key (ID_PRODUIT, ID_COMMANDE)
);

/*==============================================================*/
/* Table : PANIERFIX                                            */
/*==============================================================*/
create table PANIERFIX
(
   ID_PANIER            int not null auto_increment,
   primary key (ID_PANIER)
);

/*==============================================================*/
/* Table : PRODUIT                                              */
/*==============================================================*/
create table PRODUIT
(
   ID_PRODUIT           int not null auto_increment,
   ID_CATEGORIE         int not null,
   PRIX                 float(8,2) not null,
   IMAGE                longblob not null,
   P_NOM                longtext not null,
   primary key (ID_PRODUIT)
);

/*==============================================================*/
/* Table : PRODUIT_PF                                           */
/*==============================================================*/
create table PRODUIT_PF
(
   ID_PRODUIT           int not null,
   ID_PANIER            int not null,
   primary key (ID_PRODUIT, ID_PANIER)
);

alter table COMMANDE add constraint FK_COMMANDER foreign key (ID_CLIENT)
      references CLIENT (ID_CLIENT) on delete restrict on update restrict;

alter table COMMANDE_PF add constraint FK_CONTENIR foreign key (ID_COMMANDE)
      references COMMANDE (ID_COMMANDE) on delete restrict on update restrict;

alter table COMMANDE_PF add constraint FK_CONTENIR2 foreign key (ID_PANIER)
      references PANIERFIX (ID_PANIER) on delete restrict on update restrict;

alter table COMMANDE_PRODUIT add constraint FK_COMMANDE_PRODUIT foreign key (ID_COMMANDE)
      references COMMANDE (ID_COMMANDE) on delete restrict on update restrict;

alter table COMMANDE_PRODUIT add constraint FK_COMMANDE_PRODUIT2 foreign key (ID_PRODUIT)
      references PRODUIT (ID_PRODUIT) on delete restrict on update restrict;

alter table PRODUIT add constraint FK_CONTIENT foreign key (ID_CATEGORIE)
      references CATEGORIE (ID_CATEGORIE) on delete restrict on update restrict;

alter table PRODUIT_PF add constraint FK_PRODUIT_PF foreign key (ID_PANIER)
      references PANIERFIX (ID_PANIER) on delete restrict on update restrict;

alter table PRODUIT_PF add constraint FK_PRODUIT_PF2 foreign key (ID_PRODUIT)
      references PRODUIT (ID_PRODUIT) on delete restrict on update restrict;

