/*
SQLyog Ultimate v9.10 
MySQL - 5.1.73 : Database - dbflex
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `mappings` */

DROP TABLE IF EXISTS `mappings`;

CREATE TABLE `mappings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mappings` */

insert  into `mappings`(`id`,`key`,`value`) values (1,'Customer.Reference',NULL),(2,'Customer.Title',NULL),(3,'Customer.FirstName',NULL),(4,'Customer.LastName',NULL),(5,'Customer.CompanyName',NULL),(6,'Customer.JobDescription',NULL),(7,'Customer.Street1',NULL),(8,'Customer.City',NULL),(9,'Customer.State',NULL),(10,'Customer.PostalCode',NULL),(11,'Customer.Country',NULL),(12,'Customer.Email',NULL),(13,'Customer.Phone',NULL),(14,'Customer.Mobile',NULL),(15,'Customer.Comments',NULL),(16,'Customer.Fax',NULL),(17,'Customer.Url',NULL),(18,'Customer.CardDetails.Name',NULL),(19,'Customer.CardDetails.Number',NULL),(20,'Customer.CardDetails.ExpiryMonth',NULL),(21,'Customer.CardDetails.ExpiryYear',NULL),(22,'Customer.CardDetails.StartMonth',NULL),(23,'Customer.CardDetails.StartYear',NULL),(24,'Customer.CardDetails.IssueNumber',NULL),(25,'Customer.CardDetails.CVN',NULL),(26,'ShippingAddress.FirstName',NULL),(27,'ShippingAddress.LastName',NULL),(28,'ShippingAddress.Street1',NULL),(29,'ShippingAddress.Street2',NULL),(30,'ShippingAddress.City',NULL),(31,'ShippingAddress.State',NULL),(32,'ShippingAddress.Country',NULL),(33,'ShippingAddress.PostalCode',NULL),(34,'ShippingAddress.Email',NULL),(35,'ShippingAddress.Phone',NULL),(36,'ShippingAddress.ShippingMethod',NULL),(37,'Payment.TotalAmount',NULL),(38,'Payment.InvoiceNumber',NULL),(39,'Payment.InvoiceDescription',NULL),(40,'Payment.InvoiceReference',NULL),(41,'Payment.CurrencyCode',NULL);

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

insert  into `settings`(`id`,`key`,`value`) values (1,'dbflex_user','quang@abitech.com.au'),(2,'dbflex_pass','duyquang@112088'),(3,'eway_key','C3AB9C6G6ljG838l6xaSIJTf3cE/AoqfLasktjKrX5TgPTHSMfNY/HRsR8jaxkT3v2M9G6'),(4,'eway_pass','duyquang#112088'),(5,'dbflex_url','tcguy.dbflex.net'),(6,'eway_appid','41016'),(9,'eway_envir','1'),(10,'lastmodified','1433668211'),(11,'cronjob_interval','5'),(12,'factor','100'),(13,'transaction_table','ABItech Invoice');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `transactions` */

insert  into `transactions`(`id`,`dbflex_id`,`transaction_id`,`status`) values (5,3,NULL,0);

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
