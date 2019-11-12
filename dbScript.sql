
// Todos se ejecuta de uno en uno, no todos al mismo tiempo
CREATE DATABASE `labweb3` /*!40100 DEFAULT CHARACTER SET latin1 */

 CREATE TABLE  users (
 id varchar(30) NOT NULL PRIMARY KEY,
 firstname varchar(30) NOT NULL,
 lastname varchar(30) NOT NULL,
 cellphone varchar(50) DEFAULT NULL,
 telephone varchar(50) DEFAULT NULL,
 password varchar(30) DEFAULT NULL,
 role varchar(20) DEFAULT NULL,
)

create table enterprise(
  id int AUTO_INCREMENT PRIMARY KEY,
  name varchar(200),
  origin varchar(200),
  destiny varchar(200),
  phone varchar(100),
  email varchar(100),
  address varchar(100),
  latitude float,
  longitude float,
  anomalyContact varchar(200)
)

ALTER TABLE enterprise AUTO_INCREMENT=1;

create table schedule(
  id int AUTO_INCREMENT PRIMARY KEY,
  enterpriseID int,
  day varchar(100),
  start varchar (100),
  finish varchar (100),
  FOREIGN KEY(enterpriseID) REFERENCES enterprise(id)

);

ALTER TABLE enterprise AUTO_INCREMENT=1;

create table log(
  user varchar(30),
  action varchar(300),
  creationTime datetime DEFAULT CURRENT_TIMESTAMP
)


create table route (

  id int AUTO_INCREMENT PRIMARY KEY,
  enterpriseID int,
  routeNumber int,
  description varchar(200),
  cost varchar(100),
  duration varchar(200),
  handicapCheck varchar(100),
  FOREIGN KEY(enterpriseID) REFERENCES enterprise(id)

);

create table routePoints(
  enterpriseID int,
  routeNumber int,
  lat float,
  lng float,
  type varchar(100)
);
