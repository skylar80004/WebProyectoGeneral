
CREATE DATABASE `labweb3` /*!40100 DEFAULT CHARACTER SET latin1 */

 CREATE TABLE `users` (
 `id` varchar(30) NOT NULL,
 `firstname` varchar(30) NOT NULL,
 `lastname` varchar(30) NOT NULL,
 `cellphone` varchar(50) DEFAULT NULL,
 `telephone` varchar(50) DEFAULT NULL,
 `password` varchar(30) DEFAULT NULL,
 `role` varchar(20) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
