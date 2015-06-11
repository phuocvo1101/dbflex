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
  `transactionRemoteID` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` int(20) DEFAULT NULL,
  `currencyCode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoiceNumber` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoiceReference` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoiceDescription` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customerReference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firtName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyName` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `jobDescription` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postCode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cardHolder` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cardNumber` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiryDate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `validFormDate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issueNumber` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cvn` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transactionType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(100) DEFAULT NULL,
  `transactionIDPayment` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statusPayment` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invoices` */

/*Table structure for table `mappings` */

DROP TABLE IF EXISTS `mappings`;

CREATE TABLE `mappings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keymap` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valuemap` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mappings` */

insert  into `mappings`(`id`,`keymap`,`valuemap`) values (1,'Customer.Reference','CustomerReference'),(2,'Customer.Title','CustomerTitle'),(3,'Customer.FirstName','FirstName'),(4,'Customer.LastName','LastName'),(5,'Customer.CompanyName','Company'),(6,'Customer.JobDescription','Job Detail on Invoice'),(7,'Customer.Street1','Street'),(8,'Customer.City','CustomerCity'),(9,'Customer.State','New State'),(10,'Customer.PostalCode','Postal Code'),(11,'Customer.Country','Country'),(12,'Customer.Email','Invoice To'),(13,'Customer.Phone','HousePhone'),(14,'Customer.Mobile','Mobile'),(15,'Customer.Comments','CustomerComments'),(16,'Customer.Fax','Fax'),(17,'Customer.Url','CustomerUrl'),(18,'Customer.CardDetails.Name','CardHolder'),(19,'Customer.CardDetails.Number','CardNumber'),(20,'Customer.CardDetails.ExpiryMonth','ExpiryDate'),(21,'Customer.CardDetails.ExpiryYear','ExpiryDate'),(22,'Customer.CardDetails.StartMonth','ValidFromDate'),(23,'Customer.CardDetails.StartYear','ValidFromDate'),(24,'Customer.CardDetails.IssueNumber','IssueNumber'),(25,'Customer.CardDetails.CVN','CVN'),(26,'ShippingAddress.FirstName','FirstName'),(27,'ShippingAddress.LastName','LastName'),(28,'ShippingAddress.Street1','Street'),(29,'ShippingAddress.Street2',NULL),(30,'ShippingAddress.City','City'),(31,'ShippingAddress.State','State'),(32,'ShippingAddress.Country','Country'),(33,'ShippingAddress.PostalCode','Postal Code'),(34,'ShippingAddress.Email','Invoice To'),(35,'ShippingAddress.Phone','HousePhone'),(36,'ShippingAddress.ShippingMethod','payment'),(37,'Payment.TotalAmount','TotalINVOICE'),(38,'Payment.InvoiceNumber','Invoice Number'),(39,'Payment.InvoiceDescription','View Invoice'),(40,'Payment.InvoiceReference','Invoice reference'),(41,'Payment.CurrencyCode','CurrencyCode'),(48,'Fetch','Send to eWay'),(49,'Status','eWay Result'),(50,'TransactionID','TransactionID');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NewIndex1` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`key`,`value`) values (1,'dbflex_user','quang@abitech.com.au'),(2,'dbflex_pass','duyquang@112088'),(3,'eway_key','C3AB9C6G6ljG838l6xaSIJTf3cE/AoqfLasktjKrX5TgPTHSMfNY/HRsR8jaxkT3v2M9G6'),(4,'eway_pass','duyquang#112088'),(5,'dbflex_url','tcguy.dbflex.net'),(6,'eway_appid','41777'),(9,'eway_envir','1'),(10,'lastmodified','1434039149'),(11,'cronjob_interval','0'),(12,'factor','100'),(13,'transaction_table','ABItech Invoice');

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dbflex_id` bigint(20) DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `NewIndex1` (`dbflex_id`),
  KEY `NewIndex2` (`transaction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `transactions` */

insert  into `transactions`(`id`,`dbflex_id`,`transaction_id`,`status`) values (19,12,11646251,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`email`,`fullname`) values (1,'admin','21232f297a57a5a743894a0e4a801fc3','duyquang1202@gmail.com','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
