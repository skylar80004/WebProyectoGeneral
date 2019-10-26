
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
  longitude float
)

ALTER TABLE enterprise AUTO_INCREMENT=1;
