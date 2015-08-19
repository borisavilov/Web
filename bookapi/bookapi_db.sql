/*
SQLyog Community v11.11 (32 bit)
MySQL - 5.5.24-log : Database - conscio0_bookapi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`conscio0_bookapi` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `conscio0_bookapi`;

/*Table structure for table `tbl_books` */

DROP TABLE IF EXISTS `tbl_books`;

CREATE TABLE `tbl_books` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `user_id` bigint(11) DEFAULT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `book_desc` text,
  `chapter_name` varchar(255) DEFAULT NULL,
  `chapter_desc` text,
  `subchapter_name` varchar(255) DEFAULT NULL,
  `subchapter_desc` text,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_books` */

insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (1,2,'1','1',NULL,NULL,NULL,NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (2,3,'2','12',NULL,NULL,NULL,NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (3,3,'123','12',NULL,NULL,NULL,NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (25,123,'mybook2',NULL,'chapter1',NULL,NULL,NULL,'filename2');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (35,15,'hans_book1',NULL,NULL,NULL,NULL,NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (36,15,'hans_book1','this is my private book',NULL,NULL,NULL,NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (37,15,'hans_book1','  private book2','chapter1','this is my private book','subchapter1',NULL,'test3.txt');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (38,15,'hans_book1',NULL,'chapter1',NULL,'subchapter1','subchapter_desc 1','test.jpg');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (39,15,'hans_book1',NULL,'chapter1',NULL,'subchapter2',NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (40,15,'hans_book1',NULL,'subsub',NULL,NULL,NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (41,15,'hans_book1',NULL,'chapter2','subsub',NULL,NULL,NULL);
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (42,15,'hans_book1',NULL,'chapter3','subsub',NULL,NULL,'');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (43,15,'hans_book2','book desk2','chapter2',NULL,NULL,NULL,'test111.jpg');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (44,123,'mybook1',NULL,'chapter1',NULL,NULL,NULL,'filename1');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (45,123,'mybook1',NULL,'chapter1',NULL,NULL,NULL,'filename1');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (46,123,'mybook1',NULL,'chapter1',NULL,NULL,NULL,'filename1.txt');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (47,123,'mybook1',NULL,'chapter1',NULL,NULL,NULL,'filename1.txt');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (48,123,'mybook1',NULL,'chapter1',NULL,NULL,NULL,'filename1.txt');
insert  into `tbl_books`(`id`,`user_id`,`book_name`,`book_desc`,`chapter_name`,`chapter_desc`,`subchapter_name`,`subchapter_desc`,`filename`) values (49,123,'mybook1',NULL,'chapter1',NULL,NULL,NULL,'filename1.txt');

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL COMMENT 'male, female',
  `birthday` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `point` varchar(10) DEFAULT NULL,
  `bm` varchar(10) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `zipcode` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `usergrade` enum('admin','member','user') NOT NULL DEFAULT 'user',
  `avatar` varchar(50) DEFAULT NULL COMMENT 'photo id',
  `push_enable` tinyint(1) NOT NULL DEFAULT '0',
  `sound_enable` int(1) DEFAULT '0',
  `push_sound` varchar(50) DEFAULT 'Bamboo',
  `authentication_token` varchar(50) DEFAULT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_sent_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (1,'admin','test1@hotmail.com','admin',NULL,'borisIphone4Sw_debug','Al122','0','05-05-1991','','1582254512','2','2','Ghana','123','','admin',NULL,0,1,'Bamboo',NULL,NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (2,'boris','test2@hotmail.com','boris','http://localhost/bookapi/uploads/13/t','boris borisIphone5S','avilov','0','01-05-1980','','1682112122','212',NULL,'Russia','1234','','admin',NULL,0,1,'Bamboo',NULL,NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (3,'alex','tokenUser_20150218122744@etherean.com','user',NULL,'','','','','','','150',NULL,'','','','user',NULL,0,0,'Bamboo','72e6d3c407bb105bb6e621aadd8afc55',NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (4,'tokenUser_20150219184748','tokenUser_20150218115609@etherean.com','user',NULL,'','','','','','','5','3','','','','user',NULL,0,0,'Bamboo','63b77ce38f2f1346b0e0f9387860be36',NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (5,'tokenUser_20150219184748','tokenUser_20150219184748@etherean.com','user',NULL,'','','','','','','12',NULL,'','','','user',NULL,0,0,'Bamboo','8e9db09313287f7fc39c38a9dbbd875c',NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (6,'tokenUser_20150304113947','tokenUser_20150304113947@etherean.com','user',NULL,'','','','','','','33',NULL,'','','','user',NULL,0,0,'Bamboo','3f6f8114260a386224d6c95dd8b5e80e',NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (7,'tokenUser_20150305050216','tokenUser_20150305050216@etherean.com','user',NULL,'','','','','','','90','3','','','','user',NULL,0,0,'Bamboo','2ebe01df84623c07be91022a1ab28c24',NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (8,'tokenUser_20150306074745','tokenUser_20150306074745@etherean.com','user',NULL,'','','','','','','6',NULL,'','','','user',NULL,0,0,'Bamboo','8d07c95faae2f74c0dade7e1df8e771d',NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (9,'borisIphone4Sw','tokenUser_20150313064830@etherean.com','user',NULL,'','','','','','','2',NULL,'','','','user',NULL,0,0,'Bamboo','d6c1be32d242c3ce914b0ed513e281a5',NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (10,'borisIphone4SB',NULL,'user',NULL,'','','','','','',NULL,NULL,'','','','user',NULL,0,0,'Bamboo',NULL,NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (13,'hans1116','hanschan1116@hotmail.com','simple12345','http://localhost/bookapi/uploads/13/t','','','','','','',NULL,NULL,'','','','user',NULL,0,0,'Bamboo',NULL,NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (14,'hans11161','hanschan11116@hotmail.com','simple12345','http://localhost/bookapi/uploads/user/14/t','','','','','','',NULL,NULL,'','','','user',NULL,0,0,'Bamboo',NULL,NULL,NULL);
insert  into `tbl_users`(`id`,`username`,`email`,`password`,`photo`,`firstname`,`lastname`,`gender`,`birthday`,`address`,`phonenumber`,`point`,`bm`,`country`,`zipcode`,`city`,`usergrade`,`avatar`,`push_enable`,`sound_enable`,`push_sound`,`authentication_token`,`reset_password_token`,`reset_password_sent_at`) values (15,'hans','test@gmail.com','123456',NULL,'hans','chen','','','','',NULL,NULL,'','','','user',NULL,0,0,'Bamboo',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
