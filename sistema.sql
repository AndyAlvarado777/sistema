/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - sistema
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sistema` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sistema`;

/*Table structure for table `caja` */

DROP TABLE IF EXISTS `caja`;

CREATE TABLE `caja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caja` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `caja` */

insert  into `caja`(`id`,`caja`,`estado`) values 
(1,'General',1),
(2,'Secundario',1),
(4,'Basico',1);

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categorias` */

insert  into `categorias`(`id`,`nombre`,`estado`) values 
(7,'Comida',1),
(8,'Ropa',1),
(9,'Electronica',1),
(10,'Accesorios',1),
(11,'Zapatos',1),
(12,'Celulares',1),
(13,'Ropa Interior',1),
(14,'Audifonos',1),
(15,'Comida Chatarra',1);

/*Table structure for table `cierre_caja` */

DROP TABLE IF EXISTS `cierre_caja`;

CREATE TABLE `cierre_caja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `monto_inicial` decimal(10,2) NOT NULL,
  `monto_final` decimal(10,2) DEFAULT 0.00,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `total_ventas` int(11) DEFAULT NULL,
  `monto_total` decimal(10,2) DEFAULT 0.00,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cierre_caja` */

insert  into `cierre_caja`(`id`,`id_usuario`,`monto_inicial`,`monto_final`,`fecha_apertura`,`fecha_cierre`,`total_ventas`,`monto_total`,`estado`) values 
(19,33,100.00,7117.30,'2024-06-20','2024-06-19',9,7217.30,0),
(20,36,100.00,0.00,'2024-06-19','0000-00-00',3,3070.00,1),
(21,39,100.00,1870.00,'2024-06-19','2024-06-19',2,1970.00,0),
(22,39,100.00,120.00,'2024-06-19','2024-06-19',1,220.00,0),
(23,39,100.00,340.00,'2024-06-19','2024-06-19',1,440.00,0);

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dui` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `clientes` */

insert  into `clientes`(`id`,`dui`,`nombre`,`telefono`,`direccion`,`estado`) values 
(18,'12345678-7','Andy','12345678','Ciudad Arce',1),
(19,'98765432-9','Oscar','99999999','Km 46 1/2 Carretera a Santa Ana',1),
(20,'67843267-8','Diego ','77777777','Km 46 1/2 Carretera a Santa Ana',1),
(21,'77777777-7','Gerson','66666666','Km 46 1/2 Carretera a Santa Ana',1),
(22,'44444444-5','Abid Argueta','98765476','Km 46 1/2 Carretera a Santa Ana',1),
(23,'98267498-7','Dennis Alberto','89172635','Km 46 1/2 Carretera a Santa Ana',1),
(24,'12345625-7','Edenilson Hernandez','82736458','Km 46 1/2 Carretera a Santa Ana',1),
(25,'89898978-8','Kilmar Esequiel','66758712','Las mercedes',1),
(26,'67345678-6','Alfredo Alvarado','11111123','Coatepeque',1),
(27,'66667777-8','Albertano José ','99966778','Km 46 1/2 Carretera a Santa Ana',1),
(28,'66789856-8','Cristiann nodal','99772234','Km 46 1/2 Carretera a Santa Ana',1),
(29,'00708712-5','Jeremy','72776338','Metapán, Urb. Las Vegas, Casa #15',1),
(30,'00708813-4','Marlen','60452365','Cantón Santa Rita, Metapán, Santa Ana',1),
(31,'01618810-3','Yael','24023028','Col. Santa Elena, San Salvador',1),
(32,'05786301-9','Genara','75136560','Cantón Las Tilapias, Metapán',1),
(33,'00508791-5','Rafael','75356862','Colonia Las Américas, Metapán',1),
(34,'05759815-3','William Jeremy','76982354','Urbanización Jardines, Metapán',1);

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compras` */

insert  into `compras`(`id`,`total`,`fecha`,`estado`) values 
(148,510.00,'2024-06-19 11:19:55',1),
(149,1950.00,'2024-06-19 11:21:23',1),
(150,20.00,'2024-06-19 11:22:43',1),
(151,80.00,'2024-06-19 11:22:56',1),
(152,680.00,'2024-06-19 11:23:15',1),
(153,250.00,'2024-06-19 11:23:50',1),
(154,2000.00,'2024-06-19 11:24:07',1),
(155,2000.00,'2024-06-19 11:24:21',1),
(156,5000.00,'2024-06-19 11:24:34',1),
(157,1000.00,'2024-06-19 11:24:49',1),
(158,500.00,'2024-06-19 11:25:01',1),
(159,5000.00,'2024-06-19 11:25:15',1),
(160,25.00,'2024-06-19 11:25:27',1),
(161,460.00,'2024-06-19 11:32:44',1),
(162,1800.00,'2024-06-19 11:35:44',1),
(163,240.00,'2024-06-19 11:35:55',1),
(164,1150.00,'2024-06-19 11:36:09',1),
(165,230.00,'2024-06-19 11:36:43',1),
(166,225.00,'2024-06-19 11:36:57',1),
(167,4500.00,'2024-06-19 11:37:15',1),
(168,19.50,'2024-06-19 11:37:30',1),
(169,6942.25,'2024-06-19 11:38:05',1),
(170,2700.00,'2024-06-19 11:40:57',1),
(171,13.50,'2024-06-19 11:41:14',1),
(172,340.00,'2024-06-19 11:41:26',1),
(173,4600.00,'2024-06-19 11:42:53',1),
(174,1700.00,'2024-06-19 11:44:11',1);

/*Table structure for table `configuracion` */

DROP TABLE IF EXISTS `configuracion`;

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `mensaje` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `configuracion` */

insert  into `configuracion`(`id`,`ruc`,`nombre`,`telefono`,`direccion`,`mensaje`) values 
(1,'123456789','Maritza','69924676','Metapan','GRACIAS');

/*Table structure for table `detalle` */

DROP TABLE IF EXISTS `detalle`;

CREATE TABLE `detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detalle` */

/*Table structure for table `detalle_compras` */

DROP TABLE IF EXISTS `detalle_compras`;

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detalle_compras` */

insert  into `detalle_compras`(`id`,`id_compra`,`id_producto`,`cantidad`,`precio`,`subtotal`) values 
(196,148,31,10,20.00,200.00),
(197,148,33,5,50.00,250.00),
(198,148,34,6,10.00,60.00),
(199,149,33,34,50.00,1700.00),
(200,149,36,5,50.00,250.00),
(201,150,31,1,20.00,20.00),
(202,151,32,4,20.00,80.00),
(203,152,31,34,20.00,680.00),
(204,153,35,50,5.00,250.00),
(205,154,31,100,20.00,2000.00),
(206,155,32,100,20.00,2000.00),
(207,156,33,100,50.00,5000.00),
(208,157,34,100,10.00,1000.00),
(209,158,35,100,5.00,500.00),
(210,159,36,100,50.00,5000.00),
(211,160,37,100,0.25,25.00),
(212,161,31,23,20.00,460.00),
(213,162,31,90,20.00,1800.00),
(214,163,32,12,20.00,240.00),
(215,164,33,23,50.00,1150.00),
(216,165,34,23,10.00,230.00),
(217,166,35,45,5.00,225.00),
(218,167,36,90,50.00,4500.00),
(219,168,37,78,0.25,19.50),
(220,169,31,12,20.00,240.00),
(221,169,32,34,20.00,680.00),
(222,169,33,45,50.00,2250.00),
(223,169,36,75,50.00,3750.00),
(224,169,37,89,0.25,22.25),
(225,170,36,54,50.00,2700.00),
(226,171,37,54,0.25,13.50),
(227,172,38,34,10.00,340.00),
(228,173,39,23,200.00,4600.00),
(229,174,33,34,50.00,1700.00);

/*Table structure for table `detalle_permisos` */

DROP TABLE IF EXISTS `detalle_permisos`;

CREATE TABLE `detalle_permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detalle_permisos` */

/*Table structure for table `detalle_temp` */

DROP TABLE IF EXISTS `detalle_temp`;

CREATE TABLE `detalle_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detalle_temp` */

/*Table structure for table `detalle_ventas` */

DROP TABLE IF EXISTS `detalle_ventas`;

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detalle_ventas` */

insert  into `detalle_ventas`(`id`,`id_venta`,`id_producto`,`cantidad`,`precio`,`sub_total`) values 
(75,85,31,12,30.00,360.00),
(76,86,32,12,30.00,360.00),
(77,87,33,2,70.00,140.00),
(78,87,34,12,20.00,240.00),
(79,88,34,12,20.00,240.00),
(80,89,35,4,10.00,40.00),
(81,90,36,56,80.00,4480.00),
(82,91,37,78,0.35,27.30),
(83,92,31,34,30.00,1020.00),
(84,93,32,7,30.00,210.00),
(85,94,31,15,30.00,450.00),
(86,95,34,12,20.00,240.00),
(87,96,33,34,70.00,2380.00),
(88,97,33,12,70.00,840.00),
(89,98,32,12,30.00,360.00),
(90,98,35,67,10.00,670.00),
(91,99,35,12,10.00,120.00),
(92,100,35,34,10.00,340.00);

/*Table structure for table `medidas` */

DROP TABLE IF EXISTS `medidas`;

CREATE TABLE `medidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `nombre_corto` varchar(5) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `medidas` */

insert  into `medidas`(`id`,`nombre`,`nombre_corto`,`estado`) values 
(2,'hjjjjjj','fgddd',0),
(3,'ddd','ss',1),
(4,'litro','lt',1),
(5,'Kilo','Kl',1),
(6,'kilogramo','kl',1),
(7,'Medio','Md',1),
(8,'Kelvin','Kl',1),
(9,'Newton','Nw',1),
(10,'Gravedad','Ga',1),
(11,'Arroba','Ar',1),
(12,'Kintal','Kn',1);

/*Table structure for table `permisos` */

DROP TABLE IF EXISTS `permisos`;

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permiso` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `permisos` */

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_medida` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_proveedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_productos_proveedores` (`id_proveedor`),
  CONSTRAINT `FK_productos_proveedores` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `productos` */

insert  into `productos`(`id`,`codigo`,`descripcion`,`precio_compra`,`precio_venta`,`cantidad`,`id_medida`,`id_categoria`,`foto`,`estado`,`id_proveedor`) values 
(31,'123','Camiza',20.00,30.00,221,2,8,'imagenes/Captura de pantalla 2024-06-04 204909.png',1,8),
(32,'234','Camiza Blanca',20.00,30.00,119,2,7,'imagenes/Captura de pantalla 2024-05-27 080319.png',1,1),
(33,'345','Zapato',50.00,70.00,193,7,11,'imagenes/Captura de pantalla 2024-05-27 075233.png',1,2),
(34,'9383','Hamburguesa',10.00,20.00,93,5,7,'imagenes/Captura de pantalla 2024-05-27 094428.png',1,4),
(35,'897','pan',5.00,10.00,78,5,7,'imagenes/galaxi A8 2018.png',1,4),
(36,'453','Audifonos',50.00,80.00,268,7,14,'imagenes/Galaxi A14 G5.png',1,6),
(37,'777','Panes chucos',0.25,0.35,243,6,15,'imagenes/GALAXI A20.png',1,4),
(38,'987','Pantalon negro',10.00,15.00,34,7,8,'',1,5),
(39,'876','Laptop',200.00,500.00,23,7,9,'imagenes/Galaxi A10E.png',1,1),
(40,'544','Comida para Perro Maxi Chuchito',1.25,1.75,0,6,7,'imagenes/1718820954-Galaxi A10E.png',1,1);

/*Table structure for table `proveedores` */

DROP TABLE IF EXISTS `proveedores`;

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `ruc` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `contacto` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ruc` (`ruc`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `proveedores` */

insert  into `proveedores`(`id`,`nombre`,`ruc`,`telefono`,`direccion`,`contacto`,`email`,`estado`) values 
(1,'Oscar','12121212121','12121212','Km 46 1/2 Carretera a Santa Ana','12121212','alvaradoandy097@gmail.com',1),
(2,'chilin','11111111111','88888888','Km 46 1/2 Carretera a Santa Ana','88888888','alvaradoandy097@gmail.com',1),
(3,'Coca Cola','82822721234','89765461','Km 46 1/2 Carretera a Santa Ana','89765461','alvaradoandy097@gmail.com',1),
(4,'Zibas','19283765182','17293635','Km 46 1/2 Carretera a Santa Ana','17293635','alvaradoandy097@gmail.com',1),
(5,'Almacenes Bomba','22222222222','66666666','Santa Ana','66666666','Example@gmail.com',1),
(6,'Freum','98989898987','73894958','Km 46 1/2 Carretera a Santa Ana','73894958','alvaradoandy097@gmail.com',1),
(7,'Cinepolis','66666666673','12345678','Km 46 1/2 Carretera a Santa Ana','12345678','alvaradoandy097@gmail.com',1),
(8,'Adlverto','98987862735','12345678','Km 46 1/2 Carretera a Santa Ana','Cristian','alvaradoandy097@gmail.com',1);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id`,`usuario`,`nombre`,`clave`,`id_rol`,`id_caja`,`estado`) values 
(30,'abid@itca','abid argueta martines','$2y$10$sfZZK03RhN1iO5p1mJgu9OYdIWQvip1B6D7ryinxGbJyXfiezSNM.',1,1,1),
(32,'Victor@itca','Victor Jose Linares','$2y$10$yRJBviJUodxBlddrIgBQueqKBrmf/ty.JWJ/raBd1NxwbhZzborPu',0,1,1),
(33,'andy.alvarado@itca','Andy Alvarado','$2y$10$byt.snI6RUPXnxupBMzD...eWZVvOIHI8ZReW.WdXGqT4BG8f4f3G',1,1,1),
(34,'Oscar@itca','Oscar Linares','$2y$10$r/XrrpEjgOe52bUAgdT9U.o4wSIXBfUS6fpgh0YDU7mxH8nvXnxTm',0,2,1),
(36,'gerson@itca','Gerson linares','$2y$10$Y1aCQn2MZWqDotblEpIVIeVVCwPs6yt.IB89aS4IEWRq/aBQOGQl.',0,1,1),
(37,'denis@itca','Dennis linares','$2y$10$BL4IwSwR046PeLxkhvKSuOITeulmwn2rBwb9QLebM6GOgFi7eaqk.',0,1,1),
(38,'Nicole@itca','nicole','$2y$10$hl1uu5aB6uyAzPPeuk0Td.Xp9odBPyHDuRpAOIhzai3p26GM.MVOy',0,1,1),
(39,'Emerson@itca','Emerson Jose','$2y$10$gAOd2tJhkKw3iH3j3v0gY.psrQCpujIuii3kmKPk0oGunnhP4vMKW',0,1,1),
(40,'Andres@itca','Andres Matias','$2y$10$/hJywfMr71UDz0y4Vz84k.yFdEn0HPQAcp.PA1DkTUeJl7TxGaI16',0,1,1),
(41,'Deisy@itca','Deysi Noemi','$2y$10$NGBFgIJW0L9y1aKY3QOUlO.ox7Ie7owPCObFTGDPqtqF318sONjZe',0,1,1);

/*Table structure for table `ventas` */

DROP TABLE IF EXISTS `ventas`;

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hora` time NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `apertura` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ventas` */

insert  into `ventas`(`id`,`id_usuario`,`id_cliente`,`total`,`fecha`,`hora`,`estado`,`apertura`) values 
(85,33,19,360.00,'2024-06-19 11:45:41','00:00:00',0,0),
(86,33,27,360.00,'2024-06-19 11:31:44','00:00:00',1,0),
(87,33,27,380.00,'2024-06-19 11:31:44','00:00:00',1,0),
(88,33,25,240.00,'2024-06-19 11:31:44','00:00:00',1,0),
(89,33,23,40.00,'2024-06-19 11:31:44','00:00:00',1,0),
(90,33,20,4480.00,'2024-06-19 11:31:44','00:00:00',1,0),
(91,33,28,27.30,'2024-06-19 11:31:44','00:00:00',1,0),
(92,33,18,1020.00,'2024-06-19 11:31:44','00:00:00',1,0),
(93,33,26,210.00,'2024-06-19 11:31:44','00:00:00',1,0),
(94,36,27,450.00,'2024-06-19 11:49:57','00:00:00',1,1),
(95,36,22,240.00,'2024-06-19 11:55:41','00:00:00',1,1),
(96,36,25,2380.00,'2024-06-19 11:55:54','00:00:00',1,1),
(97,39,24,840.00,'2024-06-19 12:03:40','00:00:00',0,0),
(98,39,22,1030.00,'2024-06-19 12:03:40','00:00:00',0,0),
(99,39,24,120.00,'2024-06-19 12:03:40','00:00:00',0,0),
(100,39,22,340.00,'2024-06-19 12:03:40','00:00:00',0,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
