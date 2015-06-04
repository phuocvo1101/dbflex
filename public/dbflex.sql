/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.1.73 : Database - dbflex
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbflex` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `dbflex`;

/*Table structure for table `invoices` */

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_company_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `customer` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `product_item` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_company` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_firstname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_street` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_state` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_sumary` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `recordOwner` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdBy` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_create` int(100) DEFAULT NULL,
  `last_modified_by` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_modified` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invoices` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
