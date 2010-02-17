use moto;
CREATE USER 'moto'@'%' IDENTIFIED BY 'svs650';
GRANT USAGE ON * . * TO 'moto'@'%' IDENTIFIED BY 'svs650' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
create table annonce (
	id int(11) PRIMARY KEY AUTO_INCREMENT,
	type varchar(128),
	marque varchar(128),
	model varchar(128),
	cylindre int(11),
	imageURL varchar(256),
	origine char(11),
	prix int(11),
	km int(11),
	annee int(4),
	cp char(5),
	dateAnnonce date,
	detailsURL varchar(256)
	);
