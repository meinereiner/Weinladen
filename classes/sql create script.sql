CREATE TABLE benutzer (
  idbenutzer INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  benutzername VARCHAR (255) NULL,
  admin BOOL NULL,
  e_mail VARCHAR (255) NULL,
  newsletter BOOL NULL,
  passwort VARCHAR (255) NULL,
  PRIMARY KEY(idbenutzer)
);


CREATE TABLE bestellung (
  idbestellung INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  wein_idwein INTEGER UNSIGNED NOT NULL,
  benutzer_idbenutzer INTEGER UNSIGNED NOT NULL,
  datum DATE NULL,
  PRIMARY KEY(idbestellung),
  INDEX bestellung_FKIndex1(benutzer_idbenutzer),
  INDEX bestellung_FKIndex2(wein_idwein)
);

CREATE TABLE Nachrichten (
  idNachrichten INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nachricht VARCHAR (2000) NULL,
  datum DATETIME NULL,
  PRIMARY KEY(idNachrichten)
);

CREATE TABLE wein (
  idwein INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR (100) NULL,
  jahrgang YEAR NULL,
  typ VARCHAR (100) NULL, 
  anbaugebiet VARCHAR (255) NULL,
  land VARCHAR (100) NULL,
  beschreibung VARCHAR (500) NULL,
  preis DOUBLE NULL,
  PRIMARY KEY(idwein)
);


