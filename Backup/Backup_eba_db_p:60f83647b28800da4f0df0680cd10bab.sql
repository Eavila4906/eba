-- MariaDB dump 10.19  Distrib 10.4.25-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: eba_db_p
-- ------------------------------------------------------
-- Server version	10.4.25-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `about`
--

DROP TABLE IF EXISTS `about`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `about` (
  `id_cont` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `icon` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_cont`),
  KEY `icon` (`icon`),
  CONSTRAINT `about_ibfk_1` FOREIGN KEY (`icon`) REFERENCES `icons` (`id_icon`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `about`
--

LOCK TABLES `about` WRITE;
/*!40000 ALTER TABLE `about` DISABLE KEYS */;
INSERT INTO `about` VALUES (1,'Mision y visio EBA','Es común confundir la misión y la visión de una empresa, aunque son dos conceptos diferentes. Por un lado, la misión, como ya hemos definido, es la razón de ser, pero, en cambio, la visión se refiere a dónde se dirige esta compañía y cuáles son sus metas a medio y largo plazo.','2022-10-30 18:22:52',NULL,1,1);
/*!40000 ALTER TABLE `about` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounting`
--

DROP TABLE IF EXISTS `accounting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounting` (
  `id_accounting` int(11) NOT NULL AUTO_INCREMENT,
  `date_SA` date DEFAULT NULL,
  `date_FA` date DEFAULT NULL,
  `date_LP` date DEFAULT NULL,
  `date_NP` date DEFAULT NULL,
  PRIMARY KEY (`id_accounting`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting`
--

LOCK TABLES `accounting` WRITE;
/*!40000 ALTER TABLE `accounting` DISABLE KEYS */;
INSERT INTO `accounting` VALUES (15,'2022-10-22','2023-01-28','2023-01-05','0000-00-00'),(16,'2022-10-22','2023-01-09','2022-10-05','2022-11-05');
/*!40000 ALTER TABLE `accounting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `id_backup` int(11) NOT NULL AUTO_INCREMENT,
  `nameFile` varchar(255) NOT NULL,
  PRIMARY KEY (`id_backup`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
INSERT INTO `backup` VALUES (79,'Backup_eba_db_p:2d37e1ccdcb9e09020ac5d630e3fc3c7.sql'),(80,'Backup_eba_db_p:951e51888415ee40a6b0cfe711d5ad3b.sql'),(81,'Backup_eba_db_p:60f83647b28800da4f0df0680cd10bab.sql');
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id_contacts` int(11) NOT NULL AUTO_INCREMENT,
  `telefono` varchar(35) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_contacts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id_course` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `category` int(11) NOT NULL,
  `description` varchar(45) NOT NULL,
  `date_start` date NOT NULL,
  `date_final` date NOT NULL,
  `value` decimal(9,2) DEFAULT 0.00,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_course`),
  KEY `category` (`category`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`category`) REFERENCES `course_category` (`id_course_category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'English Basic B1',1,'asdasdas12','2022-12-05','2023-02-10',200.00,1),(2,'English Basic B2',2,'sdf11','2022-11-14','2023-01-09',200.00,1),(4,'English Basic B3',3,'sfdsfdf','2022-10-06','2023-01-28',300.00,1);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_category`
--

DROP TABLE IF EXISTS `course_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_category` (
  `id_course_category` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `description` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_course_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_category`
--

LOCK TABLES `course_category` WRITE;
/*!40000 ALTER TABLE `course_category` DISABLE KEYS */;
INSERT INTO `course_category` VALUES (1,'Kids','Para ninos de 8 a 15 anos',1,'2022-10-08 15:41:08'),(2,'Teenagers','Adolecentes de 15 a 20 anos ',1,'2022-10-08 15:41:43'),(3,'Adults','Adultos de 21 a mas anos',1,'2022-10-08 15:42:02');
/*!40000 ALTER TABLE `course_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_accounting`
--

DROP TABLE IF EXISTS `detail_accounting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_accounting` (
  `id_detail_accounting` int(11) NOT NULL AUTO_INCREMENT,
  `accounting` int(11) NOT NULL,
  `estudiante` varchar(10) NOT NULL,
  `course` int(11) NOT NULL,
  `share` varchar(15) NOT NULL,
  `full_value` double(9,2) DEFAULT NULL,
  `share_value` decimal(9,2) NOT NULL DEFAULT 0.00,
  `discount` int(11) DEFAULT 0,
  `discount_value` decimal(9,2) DEFAULT 0.00,
  `full_discount_value` double(9,2) DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `observation` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_detail_accounting`),
  KEY `accounting` (`accounting`),
  KEY `estudiante` (`estudiante`),
  KEY `course` (`course`),
  CONSTRAINT `detail_accounting_ibfk_1` FOREIGN KEY (`accounting`) REFERENCES `accounting` (`id_accounting`),
  CONSTRAINT `detail_accounting_ibfk_2` FOREIGN KEY (`estudiante`) REFERENCES `student` (`estudiante`),
  CONSTRAINT `detail_accounting_ibfk_3` FOREIGN KEY (`course`) REFERENCES `course` (`id_course`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_accounting`
--

LOCK TABLES `detail_accounting` WRITE;
/*!40000 ALTER TABLE `detail_accounting` DISABLE KEYS */;
INSERT INTO `detail_accounting` VALUES (14,15,'1349652358',4,'Mensual',300.00,75.00,0,0.00,0.00,'',NULL,0),(15,16,'1315246328',2,'Mensual',200.00,63.33,5,10.00,190.00,'',NULL,1);
/*!40000 ALTER TABLE `detail_accounting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_backup`
--

DROP TABLE IF EXISTS `detail_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_backup` (
  `id_detail_backup` int(11) NOT NULL AUTO_INCREMENT,
  `backup` int(11) NOT NULL,
  `create_by` varchar(10) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `eliminated_by` varchar(10) NOT NULL,
  `removal_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_detail_backup`),
  KEY `backup` (`backup`),
  KEY `create_by` (`create_by`),
  KEY `eliminated_by` (`eliminated_by`),
  CONSTRAINT `detail_backup_ibfk_1` FOREIGN KEY (`backup`) REFERENCES `backup` (`id_backup`),
  CONSTRAINT `detail_backup_ibfk_2` FOREIGN KEY (`create_by`) REFERENCES `usuario` (`DNI`),
  CONSTRAINT `detail_backup_ibfk_3` FOREIGN KEY (`eliminated_by`) REFERENCES `usuario` (`DNI`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_backup`
--

LOCK TABLES `detail_backup` WRITE;
/*!40000 ALTER TABLE `detail_backup` DISABLE KEYS */;
INSERT INTO `detail_backup` VALUES (79,79,'1316847586','2022-11-01 19:50:22','1316847586','2022-11-01 19:50:36',0),(80,80,'1316847586','2022-11-01 19:50:27','1316847586','0000-00-00 00:00:00',1),(81,81,'1316847586','2022-11-02 03:02:35','1316847586','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `detail_backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_my_content_student`
--

DROP TABLE IF EXISTS `detail_my_content_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_my_content_student` (
  `id_detail_my_content_student` int(11) NOT NULL AUTO_INCREMENT,
  `content` int(45) NOT NULL,
  `student` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_detail_my_content_student`),
  KEY `content` (`content`),
  KEY `student` (`student`),
  CONSTRAINT `detail_my_content_student_ibfk_1` FOREIGN KEY (`content`) REFERENCES `my_content` (`id_my_content`),
  CONSTRAINT `detail_my_content_student_ibfk_2` FOREIGN KEY (`student`) REFERENCES `student` (`estudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_my_content_student`
--

LOCK TABLES `detail_my_content_student` WRITE;
/*!40000 ALTER TABLE `detail_my_content_student` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_my_content_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_my_content_teacher`
--

DROP TABLE IF EXISTS `detail_my_content_teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_my_content_teacher` (
  `id_detail_my_content_teacher` int(11) NOT NULL AUTO_INCREMENT,
  `content` int(45) NOT NULL,
  `teacher` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_detail_my_content_teacher`),
  KEY `content` (`content`),
  KEY `teacher` (`teacher`),
  CONSTRAINT `detail_my_content_teacher_ibfk_1` FOREIGN KEY (`content`) REFERENCES `my_content` (`id_my_content`),
  CONSTRAINT `detail_my_content_teacher_ibfk_2` FOREIGN KEY (`teacher`) REFERENCES `teacher` (`teacher`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_my_content_teacher`
--

LOCK TABLES `detail_my_content_teacher` WRITE;
/*!40000 ALTER TABLE `detail_my_content_teacher` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_my_content_teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_notifications`
--

DROP TABLE IF EXISTS `detail_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_notifications` (
  `id_detail_notifications` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(10) NOT NULL,
  `notifications` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_detail_notifications`),
  KEY `usuario` (`usuario`),
  KEY `notifications` (`notifications`),
  CONSTRAINT `detail_notifications_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`DNI`),
  CONSTRAINT `detail_notifications_ibfk_2` FOREIGN KEY (`notifications`) REFERENCES `notifications` (`id_notifications`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_notifications`
--

LOCK TABLES `detail_notifications` WRITE;
/*!40000 ALTER TABLE `detail_notifications` DISABLE KEYS */;
INSERT INTO `detail_notifications` VALUES (23,'1349652358',23,'2022-10-22 19:48:57'),(24,'1349652358',24,'2022-10-22 19:49:29'),(25,'1349652358',25,'2022-10-22 19:50:35'),(26,'1349652358',26,'2022-10-22 19:51:22'),(27,'1315246328',27,'2022-10-22 20:01:13');
/*!40000 ALTER TABLE `detail_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_payment`
--

DROP TABLE IF EXISTS `detail_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_payment` (
  `id_detail_payment` int(11) NOT NULL AUTO_INCREMENT,
  `estudiante` varchar(10) NOT NULL,
  `payment` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_detail_payment`),
  KEY `estudiante` (`estudiante`),
  KEY `payment` (`payment`),
  CONSTRAINT `detail_payment_ibfk_1` FOREIGN KEY (`estudiante`) REFERENCES `student` (`estudiante`),
  CONSTRAINT `detail_payment_ibfk_2` FOREIGN KEY (`payment`) REFERENCES `payment` (`id_payment`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_payment`
--

LOCK TABLES `detail_payment` WRITE;
/*!40000 ALTER TABLE `detail_payment` DISABLE KEYS */;
INSERT INTO `detail_payment` VALUES (18,'1349652358',18,'2022-10-22 19:48:57'),(19,'1349652358',19,'2022-10-22 19:49:29'),(20,'1349652358',20,'2022-10-22 19:50:35'),(21,'1349652358',21,'2022-10-22 19:51:22'),(22,'1315246328',22,'2022-10-22 20:01:13');
/*!40000 ALTER TABLE `detail_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galeryhome`
--

DROP TABLE IF EXISTS `galeryhome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galeryhome` (
  `id_cont` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `fechaIU` date NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_cont`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeryhome`
--

LOCK TABLES `galeryhome` WRITE;
/*!40000 ALTER TABLE `galeryhome` DISABLE KEYS */;
/*!40000 ALTER TABLE `galeryhome` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `headquarter`
--

DROP TABLE IF EXISTS `headquarter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `headquarter` (
  `id_headquarter` int(11) NOT NULL AUTO_INCREMENT,
  `ubicacion` varchar(75) NOT NULL,
  `longitud` varchar(25) NOT NULL,
  `latitud` varchar(25) NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_headquarter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `headquarter`
--

LOCK TABLES `headquarter` WRITE;
/*!40000 ALTER TABLE `headquarter` DISABLE KEYS */;
/*!40000 ALTER TABLE `headquarter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `icons`
--

DROP TABLE IF EXISTS `icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `icons` (
  `id_icon` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(9) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `utilidad` int(11) NOT NULL,
  PRIMARY KEY (`id_icon`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `icons`
--

LOCK TABLES `icons` WRITE;
/*!40000 ALTER TABLE `icons` DISABLE KEYS */;
INSERT INTO `icons` VALUES (1,'&#xf0c0;','users',1),(2,'&#xf0a3;','certificate',1),(3,'&#xf099;','twitter',2),(4,'&#xf09a;','facebook',2),(5,'&#xf16d;','instagram',2),(6,'&#xf36c;','algolia',2);
/*!40000 ALTER TABLE `icons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulo` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreModulo` varchar(25) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estadoModulo` int(11) NOT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulo`
--

LOCK TABLES `modulo` WRITE;
/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` VALUES (1,'Area personal','Area personal de los docentes, estudiantes y usuarios que no tengan rol de super administrador ',1),(2,'Dashboard','Dashboard',1),(3,'Sitio publico','Sitio publico',1),(4,'Usuarios','Usuarios del sistema',1),(5,'Roles y Permisos','Roles y permisos para los usuarios',1),(6,'Contabilidad','Contabilidad de los pagos del estudiante',1),(7,'Registrar Pagos','Llevar el control de pagos de los estudiantes',1),(8,'Reportes','Describe y proporciona información de todos los procesos contables',1),(9,'Categoria de cursos','Categoria de cursos',1),(10,'Cursos','Cursos',1),(11,'Backup','Realizara respaldos o copia de seguridad de la base de datos',1);
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `my_content`
--

DROP TABLE IF EXISTS `my_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_content` (
  `id_my_content` int(11) NOT NULL AUTO_INCREMENT,
  `name_content` varchar(45) NOT NULL,
  `description` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_my_content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_content`
--

LOCK TABLES `my_content` WRITE;
/*!40000 ALTER TABLE `my_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id_notifications` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `leida` int(11) NOT NULL,
  PRIMARY KEY (`id_notifications`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (23,'Pago Inicial',NULL,'2022-10-05',0),(24,'Pago',NULL,'2022-11-05',0),(25,'Pago',NULL,'2022-12-05',0),(26,'Pago Final',NULL,'2023-01-05',0),(27,'Pago Inicial',NULL,'2022-10-05',0);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_pago` varchar(45) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `valor` double(9,2) NOT NULL,
  `periodo` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `observacion` int(11) NOT NULL DEFAULT 0,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_payment`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (18,'Efectivo','2022-10-05',75.00,'2022-10-22 - 2023-01-28',0,0,NULL),(19,'Transferencia','2022-11-05',75.00,'2022-10-22 - 2023-01-28',0,0,''),(20,'Efectivo','2022-12-05',75.00,'2022-10-22 - 2023-01-28',0,0,''),(21,'Deposito','2023-01-05',75.00,'2022-10-22 - 2023-01-28',0,0,''),(22,'Deposito','2022-10-05',63.33,'2022-10-22 - 2023-01-09',1,0,NULL);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paymentday`
--

DROP TABLE IF EXISTS `paymentday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paymentday` (
  `id_paymentday` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) NOT NULL,
  PRIMARY KEY (`id_paymentday`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paymentday`
--

LOCK TABLES `paymentday` WRITE;
/*!40000 ALTER TABLE `paymentday` DISABLE KEYS */;
INSERT INTO `paymentday` VALUES (1,5);
/*!40000 ALTER TABLE `paymentday` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `rol` int(11) NOT NULL,
  `modulo` int(11) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_permiso`),
  KEY `rol` (`rol`),
  KEY `modulo` (`modulo`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id_rol`),
  CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`modulo`) REFERENCES `modulo` (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (9,4,1,1,0,0,0),(10,4,2,0,0,0,0),(11,4,3,0,0,0,0),(12,4,4,0,0,0,0),(13,4,5,0,0,0,0),(14,4,6,0,0,0,0),(15,4,7,0,0,0,0),(16,4,8,0,0,0,0),(17,3,1,1,0,0,0),(18,3,2,0,0,0,0),(19,3,3,0,0,0,0),(20,3,4,0,0,0,0),(21,3,5,0,0,0,0),(22,3,6,0,0,0,0),(23,3,7,0,0,0,0),(24,3,8,0,0,0,0),(25,2,1,1,0,0,0),(26,2,2,0,0,0,0),(27,2,3,0,0,0,0),(28,2,4,0,0,0,0),(29,2,5,0,0,0,0),(30,2,6,0,0,0,0),(31,2,7,0,0,0,0),(32,2,8,0,0,0,0),(43,1,1,1,1,1,1),(44,1,2,1,1,1,1),(45,1,3,1,1,1,1),(46,1,4,1,1,1,1),(47,1,5,1,1,1,1),(48,1,6,1,1,1,1),(49,1,7,1,1,1,1),(50,1,8,1,1,1,1),(51,1,9,1,1,1,1),(52,1,10,1,1,1,1),(53,1,11,1,1,1,1);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(25) NOT NULL,
  `descripRol` varchar(200) NOT NULL,
  `estadoRol` int(11) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Administrador','Access to all system functionalities',1),(2,'Administrador','second-degree role to that of super administrator',1),(3,'Estudiante','Acceso limitado de acuerdo al rol estudiante',1),(4,'Docente','Acceso limitado de acuerdo al rol docente',1),(5,'Director Académico	','Coordinar la acción académica con la de administración de alumnos y profesores',1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `socialmedia`
--

DROP TABLE IF EXISTS `socialmedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `socialmedia` (
  `id_socialMedia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icono` int(11) NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_socialMedia`),
  KEY `icono` (`icono`),
  CONSTRAINT `socialmedia_ibfk_1` FOREIGN KEY (`icono`) REFERENCES `icons` (`id_icon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `socialmedia`
--

LOCK TABLES `socialmedia` WRITE;
/*!40000 ALTER TABLE `socialmedia` DISABLE KEYS */;
/*!40000 ALTER TABLE `socialmedia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id_student` int(11) NOT NULL AUTO_INCREMENT,
  `estudiante` varchar(10) NOT NULL,
  `proceso_contable` int(11) DEFAULT 0,
  PRIMARY KEY (`id_student`),
  KEY `estudiante` (`estudiante`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`estudiante`) REFERENCES `usuario` (`DNI`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'1312565821',0),(2,'1315246328',1),(3,'1349652358',0);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher` (
  `id_teacher` int(11) NOT NULL AUTO_INCREMENT,
  `teacher` varchar(10) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_teacher`),
  KEY `teacher` (`teacher`),
  CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`teacher`) REFERENCES `usuario` (`DNI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `DNI` varchar(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `apellidoP` varchar(35) NOT NULL,
  `apellidoM` varchar(35) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `fechaNaci` date NOT NULL,
  `rol` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `DNI` (`DNI`),
  KEY `rol` (`rol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'1316847586','admin','240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9','Jose David','Mora','Moreira','jmora@eba.com','0988221245','M','1994-01-19',1,'',1,'img_profilef6b7dd2c1cb2ca11a4a03895e12a7d80.jpg'),(2,'1312565821','jmedina5821','15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225','Jose Manuel','Medina','Solorzano','josemanuel@gmail.com','0956526622','F','2000-10-10',3,'',1,'profile-default.ico'),(3,'1315246328','amora6328','feb48f06ed24a5ef0f49aa9f2afca6ebbf9f3cf1af1af026eeb5ec529330337a','Alexa Michell','Mora','Gorozabel','gromichell@gmial.com','0985654552','F','2004-02-19',3,'',1,'profile-default.ico'),(4,'1349652358','hbernaza2358','8590bf3046398a96c988b1bbb21421529d1ad9bcdaeea26a2accb771a13de81d','Holger Manuel','Bernaza','Vera','veramanuel@gmail.com','0981512452','M','1999-02-10',3,'',1,'profile-default.ico');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-01 22:02:36
