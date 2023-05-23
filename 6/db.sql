CREATE TABLE admin (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user varchar(128) NOT NULL DEFAULT '',
  pass varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);