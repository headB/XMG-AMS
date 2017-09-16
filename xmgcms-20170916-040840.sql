--
-- DbNinja v3.2.6 for MySQL
--
-- Dump date: 2017-09-16 04:08:40 (UTC)
-- Server version: 5.5.54-log
-- Database: xmgcms
--

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

CREATE DATABASE `xmgcms` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `xmgcms`;

--
-- Structure for table: admin
--
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `department` int(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `groupId` int(11) DEFAULT NULL,
  `realname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;


--
-- Structure for table: asset_type_detail
--
CREATE TABLE `asset_type_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `content` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


--
-- Structure for table: computerid
--
CREATE TABLE `computerid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `computerId` varchar(255) NOT NULL,
  `serialNumber` varchar(50) DEFAULT NULL,
  `useStatus` varchar(20) DEFAULT NULL,
  `type` int(255) DEFAULT NULL,
  `last_mobify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `new_index_2` (`computerId`),
  KEY `fktypeid` (`type`),
  KEY `index_computer` (`computerId`) USING BTREE,
  KEY `new_index_1` (`serialNumber`),
  CONSTRAINT `fktypeid` FOREIGN KEY (`type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;


--
-- Structure for table: computerrentrecord
--
CREATE TABLE `computerrentrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `renting_num` varchar(50) DEFAULT NULL,
  `freeRent_num` varchar(50) DEFAULT NULL,
  `expired_num` varchar(50) DEFAULT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=utf8;


--
-- Structure for table: department
--
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dpname` varchar(20) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;


--
-- Structure for table: domain_name
--
CREATE TABLE `domain_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `unblocked` varchar(50) NOT NULL DEFAULT 'yes',
  `last_time_send` datetime DEFAULT NULL,
  `domain` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `new_index_1` (`location`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


--
-- Structure for table: estimate_history
--
CREATE TABLE `estimate_history` (
  `uniqueNum` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `sid` int(11) DEFAULT NULL,
  `who` int(50) NOT NULL,
  `port` int(11) NOT NULL,
  `typeDetail` int(11) DEFAULT NULL,
  `setting_time` datetime DEFAULT NULL,
  `expired_time` datetime NOT NULL,
  `classInfoId` varchar(50) DEFAULT NULL,
  `classRoomName` varchar(50) DEFAULT NULL,
  `teacherName` varchar(50) DEFAULT NULL,
  `className` varchar(50) DEFAULT NULL,
  `total` varchar(50) DEFAULT NULL,
  `content` text,
  `post` int(11) DEFAULT NULL,
  PRIMARY KEY (`uniqueNum`),
  UNIQUE KEY `new_index_1` (`classInfoId`),
  KEY `fkey_flzfkfdrpv` (`who`)
) ENGINE=InnoDB AUTO_INCREMENT=904 DEFAULT CHARSET=utf8;


--
-- Structure for table: estimate_summary
--
CREATE TABLE `estimate_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classInfoId` int(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Structure for table: rentlist_operate_history
--
CREATE TABLE `rentlist_operate_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sql` longtext,
  `time` datetime DEFAULT NULL,
  `f_is_record` varchar(255) DEFAULT NULL,
  `d_is_record` varchar(255) DEFAULT NULL,
  `who` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=781 DEFAULT CHARSET=utf8;


--
-- Structure for table: service_operate
--
CREATE TABLE `service_operate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sql_operate` varchar(1000) DEFAULT NULL,
  `sql_check` varchar(1000) DEFAULT NULL,
  `sql_alter` varchar(1000) DEFAULT NULL,
  `D` varchar(50) DEFAULT NULL,
  `F` varchar(50) DEFAULT NULL,
  `bigPlace` varchar(50) DEFAULT NULL,
  `beijing` varchar(50) DEFAULT NULL,
  `db` varchar(50) DEFAULT NULL,
  `insertTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=383 DEFAULT CHARSET=utf8;


--
-- Structure for table: student_class
--
CREATE TABLE `student_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(50) DEFAULT NULL,
  `leader` varchar(50) DEFAULT NULL,
  `classSubject` varchar(50) DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `graduation` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Structure for table: subject_detail
--
CREATE TABLE `subject_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT '0',
  `subjectName` varchar(50) DEFAULT NULL,
  `subjectTeacherName` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=270 DEFAULT CHARSET=utf8;


--
-- Structure for table: teachingarea
--
CREATE TABLE `teachingarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `new_index_1` (`block`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


--
-- Structure for table: type
--
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_admin
--
CREATE TABLE `yx_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` tinyint(4) NOT NULL DEFAULT '1',
  `username` char(50) NOT NULL,
  `realname` char(15) NOT NULL,
  `password` char(32) NOT NULL,
  `lastlogin_time` int(10) unsigned NOT NULL,
  `lastlogin_ip` char(15) NOT NULL,
  `iflock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sortpower` text NOT NULL,
  `extendpower` varchar(100) NOT NULL,
  `department` int(11) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usename` (`username`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='管理员信息表';


--
-- Structure for table: yx_asset_type
--
CREATE TABLE `yx_asset_type` (
  `tid` int(11) DEFAULT '0',
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `typename` varchar(20) NOT NULL,
  `description` text,
  `unrecycle` varchar(10) DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_assets
--
CREATE TABLE `yx_assets` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `aid` varchar(50) NOT NULL,
  `assetname` varchar(20) NOT NULL,
  `type` int(4) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `manufacturer` varchar(20) DEFAULT NULL,
  `manufacturedate` date DEFAULT NULL,
  `buydate` date NOT NULL,
  `price` double NOT NULL,
  `usestate` int(1) NOT NULL,
  `deprecition` int(1) DEFAULT NULL,
  `department` int(4) DEFAULT NULL,
  `user` int(4) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `location` int(255) DEFAULT NULL,
  `total` int(11) DEFAULT '1',
  `measure` int(11) DEFAULT NULL,
  `campus` int(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aid` (`aid`),
  KEY `FKAC1073836E7261AF` (`department`),
  KEY `FKAC10738349DADDBF` (`type`),
  KEY `FKAC10738349DB96E1` (`user`),
  KEY `fk_location` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=435 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_campus
--
CREATE TABLE `yx_campus` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_computer_type
--
CREATE TABLE `yx_computer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_computerid
--
CREATE TABLE `yx_computerid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `computerId` varchar(255) NOT NULL,
  `serialNumber` varchar(50) DEFAULT NULL,
  `useStatus` varchar(20) DEFAULT NULL,
  `type` int(255) DEFAULT NULL,
  `last_mobify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `new_index_2` (`computerId`),
  KEY `fktypeid` (`type`),
  KEY `index_computer` (`computerId`) USING BTREE,
  KEY `new_index_1` (`serialNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_consumables
--
CREATE TABLE `yx_consumables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addTime` date DEFAULT NULL,
  `providers` varchar(50) DEFAULT NULL,
  `buyer` int(50) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `handler` int(11) DEFAULT NULL,
  `subType` int(11) DEFAULT NULL,
  `assetName` varchar(50) DEFAULT NULL,
  `specification` varchar(50) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `addTotal` int(11) DEFAULT NULL,
  `actualTotal` int(11) DEFAULT NULL,
  `measure` int(11) DEFAULT NULL,
  `totalPrice` varchar(50) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_consumables_issue
--
CREATE TABLE `yx_consumables_issue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assetId` int(11) DEFAULT NULL,
  `assetName` varchar(50) DEFAULT NULL,
  `issueTime` date DEFAULT NULL,
  `department` varchar(11) DEFAULT NULL,
  `user` varchar(11) DEFAULT NULL,
  `handler` varchar(11) DEFAULT NULL,
  `remark` varchar(80) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `measure` varchar(50) DEFAULT NULL,
  `totalPrice` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_department
--
CREATE TABLE `yx_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dpname` varchar(20) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_extend
--
CREATE TABLE `yx_extend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT '0',
  `tableinfo` varchar(255) DEFAULT NULL,
  `type` int(4) DEFAULT '0',
  `defvalue` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ifsearch` tinyint(1) NOT NULL DEFAULT '0',
  `norder` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_group
--
CREATE TABLE `yx_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `power` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_location
--
CREATE TABLE `yx_location` (
  `tid` int(11) DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(30) DEFAULT NULL,
  `locationName` varchar(255) DEFAULT NULL,
  `description` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_method
--
CREATE TABLE `yx_method` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rootid` int(10) unsigned NOT NULL,
  `pid` float unsigned NOT NULL,
  `operate` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ifmenu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否菜单显示',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=410 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_news
--
CREATE TABLE `yx_news` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `sort` varchar(350) NOT NULL COMMENT '类别',
  `exsort` varchar(350) NOT NULL,
  `account` char(15) NOT NULL COMMENT '发布者账户',
  `title` varchar(60) NOT NULL COMMENT '标题',
  `places` varchar(100) NOT NULL,
  `color` varchar(7) NOT NULL COMMENT '标题颜色',
  `picture` varchar(80) NOT NULL,
  `keywords` varchar(300) NOT NULL COMMENT '关键字',
  `description` varchar(600) NOT NULL,
  `content` text NOT NULL COMMENT '内容',
  `method` varchar(100) NOT NULL COMMENT '方法',
  `tpcontent` varchar(100) NOT NULL COMMENT '模板',
  `norder` int(4) NOT NULL COMMENT '排序',
  `recmd` tinyint(1) NOT NULL COMMENT '推荐',
  `hits` int(10) NOT NULL COMMENT '点击量',
  `ispass` tinyint(1) NOT NULL,
  `origin` varchar(30) NOT NULL COMMENT '来源',
  `addtime` int(11) NOT NULL,
  `releids` varchar(255) NOT NULL,
  `extfield` int(10) NOT NULL DEFAULT '0' COMMENT '拓展字段',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_nonconsumables
--
CREATE TABLE `yx_nonconsumables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addTime` date DEFAULT NULL,
  `providers` varchar(50) DEFAULT NULL,
  `buyer` int(50) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `handler` int(11) DEFAULT NULL,
  `subType` int(11) DEFAULT NULL,
  `assetName` varchar(50) DEFAULT NULL,
  `specification` varchar(50) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `addTotal` int(11) DEFAULT NULL,
  `actualTotal` int(11) DEFAULT NULL,
  `measure` int(11) DEFAULT NULL,
  `totalPrice` varchar(50) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_nonconsumables_issue
--
CREATE TABLE `yx_nonconsumables_issue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assetId` int(11) DEFAULT NULL,
  `assetName` varchar(50) DEFAULT NULL,
  `issueTime` date DEFAULT NULL,
  `department` varchar(11) DEFAULT NULL,
  `user` varchar(11) DEFAULT NULL,
  `handler` varchar(11) DEFAULT NULL,
  `remark` varchar(80) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `measure` varchar(50) DEFAULT NULL,
  `totalPrice` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_photo
--
CREATE TABLE `yx_photo` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `sort` varchar(350) NOT NULL COMMENT '类别',
  `exsort` varchar(350) NOT NULL,
  `account` char(15) NOT NULL COMMENT '发布者账户',
  `title` varchar(60) NOT NULL COMMENT '标题',
  `places` varchar(100) NOT NULL,
  `color` varchar(7) NOT NULL COMMENT '标题颜色',
  `picture` varchar(80) NOT NULL COMMENT '封面图',
  `keywords` varchar(300) NOT NULL COMMENT '关键字',
  `description` varchar(600) NOT NULL,
  `photolist` text NOT NULL COMMENT '图片集',
  `conlist` text NOT NULL COMMENT '图片说明',
  `content` text NOT NULL COMMENT '内容',
  `method` varchar(100) NOT NULL COMMENT '方法',
  `tpcontent` varchar(100) NOT NULL COMMENT '模板',
  `norder` int(4) NOT NULL COMMENT '排序',
  `recmd` tinyint(1) NOT NULL COMMENT '推荐',
  `hits` int(10) NOT NULL COMMENT '点击量',
  `ispass` tinyint(1) NOT NULL,
  `addtime` int(11) NOT NULL,
  `releids` varchar(255) NOT NULL,
  `extfield` int(10) NOT NULL DEFAULT '0' COMMENT '拓展字段',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_rentlist
--
CREATE TABLE `yx_rentlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idf` varchar(255) NOT NULL,
  `susername` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `class` varchar(255) NOT NULL,
  `rentDate` date DEFAULT NULL,
  `lendDate` date DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `computerSort` varchar(255) DEFAULT NULL,
  `computerId` varchar(255) DEFAULT NULL,
  `CpuSort` varchar(255) DEFAULT NULL,
  `memorySort` varchar(255) DEFAULT NULL,
  `HDDTotal` varchar(255) DEFAULT NULL,
  `monitorId` varchar(255) DEFAULT NULL,
  `more` varchar(255) DEFAULT NULL,
  `admin` varchar(255) DEFAULT NULL,
  `modified` varchar(255) DEFAULT NULL,
  `returnRecord` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `rereturnDate` date DEFAULT NULL,
  `mouse` varchar(255) DEFAULT NULL,
  `keyboard` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_computerid1` (`computerId`)
) ENGINE=InnoDB AUTO_INCREMENT=661 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_rerentlist
--
CREATE TABLE `yx_rerentlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idf` varchar(255) NOT NULL,
  `susername` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `class` varchar(255) NOT NULL,
  `rentDate` date DEFAULT NULL,
  `lendDate` date DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `computerSort` varchar(255) DEFAULT NULL,
  `computerId` varchar(255) DEFAULT NULL,
  `CpuSort` varchar(255) DEFAULT NULL,
  `memorySort` varchar(255) DEFAULT NULL,
  `HDDTotal` varchar(255) DEFAULT NULL,
  `monitorId` varchar(255) DEFAULT NULL,
  `more` varchar(255) DEFAULT NULL,
  `admin` varchar(255) DEFAULT NULL,
  `modified` varchar(255) DEFAULT NULL,
  `returnRecord` varchar(255) DEFAULT NULL,
  `rereturnDate` datetime DEFAULT NULL,
  `months` varchar(255) DEFAULT NULL,
  `rereturnId` varchar(255) DEFAULT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_sort
--
CREATE TABLE `yx_sort` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '模型类别',
  `path` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ename` varchar(100) NOT NULL,
  `picwidth` int(5) NOT NULL,
  `picheight` int(5) NOT NULL,
  `picture` varchar(80) NOT NULL,
  `deep` int(5) unsigned NOT NULL DEFAULT '1' COMMENT '深度',
  `norder` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `ifmenu` tinyint(1) NOT NULL COMMENT '是否前台显示',
  `method` varchar(100) NOT NULL COMMENT '模型方法',
  `tplist` varchar(100) NOT NULL COMMENT '列表模板',
  `keywords` varchar(255) NOT NULL COMMENT '描述',
  `description` varchar(300) NOT NULL COMMENT '描述',
  `url` varchar(255) NOT NULL COMMENT '外部链接',
  `extendid` int(10) NOT NULL COMMENT '拓展表id',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `path` (`path`)
) ENGINE=MyISAM AUTO_INCREMENT=100034 DEFAULT CHARSET=utf8;


--
-- Structure for table: yx_user
--
CREATE TABLE `yx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL DEFAULT '',
  `department` int(4) NOT NULL,
  `email` varchar(50) NOT NULL,
  `workphone` varchar(15) DEFAULT NULL,
  `mobilephone` varchar(15) DEFAULT NULL,
  `registCode` varchar(50) DEFAULT NULL,
  `registExpired` datetime DEFAULT NULL,
  `reregistCode` varchar(50) DEFAULT NULL,
  `reregistExpired` varchar(50) DEFAULT NULL,
  `WiFiName` varchar(50) DEFAULT NULL,
  `estimateName` varchar(50) DEFAULT NULL,
  `WiFiRegCode` varchar(80) DEFAULT NULL,
  `WiFiCodeExpired` varchar(100) DEFAULT NULL,
  `pingjiaSetTime` int(11) DEFAULT NULL,
  `pingjiaReSetTime` int(11) DEFAULT NULL,
  `WiFiSetTime` int(11) DEFAULT NULL,
  `WiFiReSetTime` int(11) DEFAULT NULL,
  `setTimeNow` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=270 DEFAULT CHARSET=utf8;


--
-- Data for table: asset_type_detail
--
LOCK TABLES `asset_type_detail` WRITE;
ALTER TABLE `asset_type_detail` DISABLE KEYS;

INSERT INTO `asset_type_detail` (`id`,`uid`,`tid`,`content`) VALUES (1,219,41,'1*2*10'),(2,219,42,'123'),(3,219,43,'123'),(4,218,46,'4g'),(5,390,46,'1'),(6,391,46,'1'),(7,390,37,'1'),(8,390,38,'1'),(9,390,39,'1');

ALTER TABLE `asset_type_detail` ENABLE KEYS;
UNLOCK TABLES;
COMMIT;

--
-- Data for table: yx_asset_type
--
LOCK TABLES `yx_asset_type` WRITE;
ALTER TABLE `yx_asset_type` DISABLE KEYS;

INSERT INTO `yx_asset_type` (`tid`,`id`,`typename`,`description`,`unrecycle`) VALUES (0,1,'资产种类',NULL,'no'),(1,10,'计算机设备及电子设备','','no'),(1,11,'易耗品','','yes'),(1,12,'办公家具用品','','no'),(0,14,'计量单位',NULL,'no'),(14,15,'个',NULL,'no'),(14,16,'叠',NULL,'no'),(0,23,'使用情况状态',NULL,'no'),(23,24,'在用',NULL,'no'),(23,25,'备用',NULL,'no'),(1,26,'电器设备',NULL,'no'),(1,28,'非易耗品',NULL,'no'),(14,32,'张',NULL,'no'),(14,33,'把',NULL,'no'),(14,34,'台',NULL,'no'),(10,35,'笔记本','','no'),(10,36,'台式电脑','','no'),(36,37,'显示器','请输入品牌','no'),(36,38,'键盘','','no'),(36,39,'鼠标','','no'),(12,40,'钢架办公卡位','','no'),(40,41,'长*宽*高','','no'),(40,42,'桌面颜色','','no'),(40,43,'挡板颜色','','no'),(12,44,'屏风办公卡位','','no'),(35,46,'内存','例如：4G ','no'),(10,47,'交换机','','no'),(1,49,'清洁用品','','no'),(49,51,'布条拖把','','no'),(49,52,'吸水拖把','','no'),(49,53,'84消毒液','','no'),(11,54,'布条拖把','','no'),(14,55,'件','','no'),(11,56,'纸巾','','no'),(11,57,'透明胶纸','','no'),(11,58,'固体胶','','no'),(11,59,'双面胶','','no'),(11,60,'笔记本','','no'),(14,61,'本','','no'),(28,62,'键盘','键盘的统称','no'),(10,63,'普联三层交换机','交换机','no'),(10,64,'三层交换机','','no'),(10,65,'二层交换机','','no'),(10,66,'飞利浦显示器','','no'),(10,67,'三巨键盘','','no'),(10,68,'三巨鼠标','','no'),(10,69,'主机','','no'),(10,70,'IMAC一体机','','no'),(10,71,'键盘','','no'),(10,72,'无线触摸板','','no'),(10,73,'功放','','no'),(10,74,'麦克风','','no'),(10,75,'麦克风架子','','no'),(10,76,'打卡机','','no'),(10,77,'显示器','','no'),(14,78,'    包','','no'),(14,79,'支','','no'),(11,80,'便利贴','','no'),(11,81,'标签','','no'),(11,82,'复印纸','','no'),(11,83,'笔','','no'),(11,84,'桶','','no'),(11,85,'铲子','','no'),(11,86,'扫把','','no'),(11,87,'刷','','no'),(11,88,'袋','','no'),(14,89,'桶','','no'),(14,90,'条','','no'),(11,91,'檀香','','no'),(14,92,'瓶','','no'),(14,93,'盒','','no'),(11,97,'蓝泡泡','','no'),(11,98,'清新剂','','no'),(11,99,'消毒液','','no'),(11,100,'钢丝球','','no'),(11,101,'芳香球','','no'),(11,102,'胶带','','no'),(11,103,'回形针','','no'),(11,104,'长尾夹','','no'),(11,105,'板夹','','no'),(11,106,'订书机','','no'),(11,107,'订书钉','','no'),(11,108,'档案袋','','no'),(11,109,'文件袋','','no'),(11,110,'资料架','','no'),(11,111,'笔筒','','no'),(11,112,'报销单','','no'),(11,113,'计算器','','no'),(11,114,'印泥油','','no'),(11,115,'印台','','no'),(14,116,'提','','no'),(11,117,'杯子','','no'),(11,118,'剪刀','','no'),(11,119,'直尺','','no'),(11,120,'碳粉','','no'),(11,121,'麦','','no'),(11,122,'话筒','','no'),(11,123,'U盘','','no'),(11,124,'加密狗','','no'),(11,125,'触摸板','','no'),(11,126,'遥控','','no'),(11,127,'排插','','no'),(11,128,'电池','','no'),(14,130,'粒','','no'),(28,131,'遥控器','','no'),(11,132,'洗衣粉','','no'),(11,133,'灯泡','','no'),(28,134,'电话','','no'),(28,135,'横幅','','no'),(28,136,'锁','','no'),(28,137,'挂钩','','no'),(14,138,'个','','no'),(28,139,'手机','','no'),(28,140,'冲水阀','','no'),(28,141,'厕所水箱','','no'),(28,142,'螺丝刀','','no'),(28,143,'锯子','','no'),(14,144,'卷','','no'),(28,145,'插排','','no'),(28,146,'水龙头','','no'),(11,147,'布','','no'),(11,148,'木柄','','no'),(11,149,'起钉器','','no'),(11,150,'刨笔刀','','no'),(11,151,'文件夹','','no'),(11,152,'橡皮筋','','no'),(14,153,'箱','','no'),(11,154,'纸杯','','no'),(11,155,'麦克风','','no'),(11,156,'老鼠夹','','no'),(11,157,'老鼠笼','','no'),(11,158,'老鼠胶','','no'),(10,159,'鼠标','','no'),(10,160,'路由器','','no'),(10,161,'POE交换机','','no'),(11,162,'拖布','','no'),(14,163,'套','','no'),(28,164,'消毒液',NULL,'no'),(28,165,'垃圾袋',NULL,'no'),(28,166,'地毯',NULL,'no'),(28,167,'U型锁',NULL,'no');

ALTER TABLE `yx_asset_type` ENABLE KEYS;
UNLOCK TABLES;
COMMIT;

--
-- Data for table: yx_assets
--
LOCK TABLES `yx_assets` WRITE;
ALTER TABLE `yx_assets` DISABLE KEYS;

INSERT INTO `yx_assets` (`id`,`aid`,`assetname`,`type`,`version`,`manufacturer`,`manufacturedate`,`buydate`,`price`,`usestate`,`deprecition`,`department`,`user`,`remark`,`location`,`total`,`measure`,`campus`) VALUES (10,'GZ-XMG-PC-0102001','组装台式电脑',36,'intel','','1970-01-01','2015-08-20',2000,24,2,19,4,'',11,1,15,1),(11,'GZ-XMG-PC-0102002','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,19,3,NULL,2,1,NULL,1),(12,'GZ-XMG-PC-0102003','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,19,2,NULL,2,1,NULL,1),(13,'GZ-XMG-PC-0102004','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,NULL,NULL,'',2,1,34,1),(14,'GZ-XMG-PC-0500001','笔记本电脑',35,'','','2015-08-20','2015-08-20',2000,24,2,29,41,'',11,1,15,1),(15,'GZ-18502005833','小手机',10,'','','2015-08-20','2015-08-20',2000,24,2,29,41,'',2,1,NULL,1),(16,'GZ-XMG-PC-0502005','笔记本电脑',36,'','','2015-08-20','2015-08-20',2600,24,2,23,24,'',2,1,15,1),(17,'GZ-XMG-PC-0102021','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,23,23,NULL,2,1,NULL,1),(18,'GZ-XMG-PC-0102023','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,21,26,NULL,2,1,NULL,1),(19,'GZ-XMG-PC-0102022','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,21,25,NULL,2,1,NULL,1),(20,'GZ-18613028980','红米手机',10,'','','2015-08-20','2015-08-20',900,24,2,21,26,NULL,2,1,NULL,1),(26,'GZ-XMG-PC-0101010','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,NULL,NULL,NULL,2,1,NULL,1),(27,'GZ-XMG-PC-0101008','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,26,38,'',36,1,15,1),(28,'GZ-XMG-PC-0103005','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,27,51,NULL,2,1,NULL,1),(29,'GZ-XMG-PC-0103006','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,27,52,NULL,2,1,NULL,1),(30,'GZ-XMG-PC-0102007','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,NULL,NULL,NULL,2,1,NULL,1),(31,'GZ-XMG-PC-0102008','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,20,12,NULL,2,1,NULL,1),(32,'GZ-XMG-PC-0102009','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,20,89,'',2,1,NULL,1),(33,'GZ-XMG-PC-0102011','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,20,14,NULL,2,1,NULL,1),(34,'GZ-XMG-PC-0102012','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,NULL,NULL,NULL,2,1,NULL,1),(35,'GZ-XMG-PC-0503004','hp笔记本电脑',10,'','','2015-08-20','2015-08-20',2600,24,2,22,5,NULL,2,1,NULL,1),(36,'GZ-XMG-PC-0102019','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,22,64,NULL,2,1,NULL,1),(37,'GZ-XMG-PC-0102018','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,22,6,NULL,2,1,NULL,1),(38,'GZ-XMG-PC-0102015','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,22,7,NULL,2,1,NULL,1),(39,'GZ-XMG-PC-0102013','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,22,9,'',2,1,NULL,1),(40,'GZ-XMG-PC-0102017','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,22,8,NULL,2,1,NULL,1),(41,'GZ-XMG-PC-0500002','笔记本电脑',10,'','','2015-08-20','2015-08-20',2600,24,2,29,40,NULL,2,1,NULL,1),(42,'GZ-18520619655','小手机',10,'','','2015-08-20','2015-08-20',150,24,2,29,40,'',2,1,NULL,1),(43,'GZ-18520619622','小手机',10,'','','2015-08-20','2015-08-20',150,24,2,22,5,'',2,1,NULL,1),(44,'GZ-18520619633','小手机',10,'','','2015-08-20','2015-08-20',150,24,2,22,64,'',2,1,NULL,1),(45,'GZ-18688895400','小手机',10,'','','2015-08-20','2015-08-20',150,24,2,22,6,NULL,2,1,NULL,1),(46,'GZ-18665580499','小手机',10,'','','2015-08-20','2015-08-20',150,24,2,22,7,NULL,2,1,NULL,1),(47,'GZ-18688854600','小手机',10,'','','2015-08-20','2015-08-20',150,24,2,22,8,NULL,2,1,NULL,1),(48,'GZ-18520619755','小手机',10,'','','2015-08-20','2015-08-20',150,24,2,22,9,NULL,2,1,NULL,1),(49,'GZ-XMG-PC-0102026','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,18,20,'',2,1,NULL,1),(50,'GZ-XMG-PC-0102025','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,19,118,'',2,1,15,1),(51,'GZ-XMG-PC-0102024','组装台式电脑',10,'','','2015-08-20','2015-08-20',2000,24,2,18,18,NULL,2,1,NULL,1),(52,'GZ-XMG-PC-0802001','iMac 一体机',10,'','','2015-08-20','2015-08-20',5000,24,2,NULL,NULL,'',2,1,NULL,1),(54,'GZ-XMG-PC-0103004','组装台式电脑',10,'','','2015-08-20','2015-08-20',5000,24,2,20,13,NULL,2,1,NULL,1),(55,'GZ-XMG-BG-0102001','办公桌 椅 柜',12,'','','2015-08-20','2015-08-20',1500,24,2,19,4,NULL,2,1,NULL,1),(56,'GZ-XMG-BG-0102002','办公桌 椅 柜',12,'','','2015-08-20','2015-08-20',1500,24,2,19,3,NULL,2,1,NULL,1),(57,'GZ-XMG-BG-0102004','办公桌 椅 柜',12,'','','2015-08-20','2015-08-20',1500,24,2,NULL,NULL,NULL,2,1,NULL,1),(58,'GZ-XMG-BG-0102003','办公桌 椅 柜',12,'','','2015-08-20','2015-08-20',1500,24,2,19,2,'',2,1,15,1),(59,'GZ-XMG-BG-0102006','办公桌 椅 柜',12,'','','2015-08-20','2015-08-20',1500,24,2,29,41,NULL,2,1,NULL,1),(60,'GZ-XMG-BG-0102020','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,23,24,NULL,2,1,NULL,1),(61,'GZ-XMG-BG-0102021','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,23,23,NULL,2,1,NULL,1),(62,'GZ-XMG-BG-0102023','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,21,26,'',2,1,15,1),(63,'GZ-XMG-BG-0102022','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,21,25,NULL,2,1,NULL,1),(71,'GZ-XMG-BG-0103001','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,NULL,NULL,NULL,3,1,NULL,1),(72,'GZ-XMG-BG-0103005','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,27,51,NULL,2,1,NULL,1),(73,'GZ-XMG-BG-0103006','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,27,52,'',2,1,15,1),(74,'GZ-XMG-BG-0102007','办公桌椅柜',12,'','','2015-08-20','2015-08-20',1000,24,2,NULL,NULL,'',2,1,15,1),(76,'GZ-XMG-BG-0102011','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,NULL,NULL,NULL,2,1,NULL,1),(77,'GZ-XMG-BG-0102012','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,20,14,NULL,2,1,NULL,1),(78,'GZ-XMG-BGZJ-0102006','座机',28,'','','2015-08-21','2015-08-21',115,24,2,20,12,'',2,1,15,1),(79,'GZ-XMG-BG-01020013','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,22,9,NULL,2,1,NULL,1),(80,'GZ-XMG-BG-01020014','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,29,40,NULL,2,1,NULL,1),(81,'GZ-XMG-BG-01020015','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,22,7,NULL,2,1,NULL,1),(82,'GZ-XMG-BG-01020016','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,22,5,NULL,2,1,NULL,1),(83,'GZ-XMG-BG-01020017','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,22,8,NULL,2,1,NULL,1),(84,'GZ-XMG-BG-01020018','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,22,6,NULL,2,1,NULL,1),(85,'GZ-XMG-BG-01020019','办公桌椅柜',12,'','','2015-08-21','2015-08-21',1000,24,2,22,64,NULL,2,1,NULL,1),(90,'GZ-XMG-BGZJ-0102001','座机',28,'','','2015-05-01','2015-09-23',115,24,0,22,5,NULL,2,1,NULL,1),(91,'GZ-XMG-BGZJ-0102002','座机',28,'','','2015-05-01','2015-09-23',115,24,0,29,40,'',2,1,NULL,1),(108,'GZ-XMG-BG-0102008','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,20,12,'',2,1,NULL,1),(110,'GZ-18665554100','小手机',10,'','','2015-05-01','2015-10-21',200,24,0,20,14,'学工部',2,1,NULL,1),(111,'GZ-XMG-BG-0102026','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,18,18,'行政部',2,1,NULL,1),(112,'GZ-XMG-BG-0102025','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,18,18,'行政部',2,1,NULL,1),(113,'GZ-XMG-BG-0102024','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,18,18,'行政部',2,1,NULL,1),(117,'GZ-XMG-BGZJ-0102003','座机',28,'','','2015-05-01','2015-10-21',200,24,0,18,18,'行政部,分机号:8527',2,1,NULL,1),(120,'GZ-XMG-BGZJ-0102004','座机',28,'','','2015-05-01','2015-10-21',150,24,0,23,23,'人事部',2,1,NULL,1),(122,'GZ-XMG-PC-0102005','电脑',10,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'市场部',2,1,NULL,1),(123,'GZ-XMG-PC-0102010','电脑套装',10,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'学工部',2,1,NULL,1),(124,'GZ-XMG-BG-0204019','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,57,'就业部',3,1,NULL,1),(126,'GZ-XMG-BG-0104021','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'就业部(F2楼)',3,1,NULL,1),(127,'GZ-XMG-BG-0104022','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,27,101,'就业部(F2楼)',3,1,NULL,1),(128,'GZ-XMG-BG-0104023','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,32,60,'就业部(F2楼)',3,1,NULL,1),(130,'GZ-XMG-BG-0104027','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'就业部(F2楼)',3,1,NULL,1),(131,'GZ-XMG-BG-0104028','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'就业部(F2楼)',3,1,NULL,1),(132,'GZ-XMG-BG-0104029','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'就业部(F2楼)',3,1,NULL,1),(133,'GZ-XMG-BG-0104030','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,28,53,'就业部(F2楼)',3,1,NULL,1),(134,'GZ-XMG-BG-0104031','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,30,62,'网页UI设计学院(F2楼)',3,1,NULL,1),(135,'GZ-XMG-BG-0104025','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,20,88,'学工部(F2楼)',2,1,NULL,1),(136,'GZ-XMG-BG-0104026','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,20,13,'学工部(F2楼)',2,1,NULL,1),(137,'GZ-XMG-PC-0104001','电脑整套',10,'','','2015-05-01','2015-10-21',2000,24,0,20,88,'学工部(F2楼)',2,1,NULL,1),(138,'GZ-XMG-PC-0104002','电脑套装',10,'','','2015-05-01','2015-10-21',2000,24,0,20,13,'学工部(F2楼)',2,1,NULL,1),(139,'GZ-XMG-PG-0104001','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,83,'IOS学院(F2楼)',3,1,NULL,1),(140,'GZ-XMG-BG-0104002','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,31,'IOS学院(F2楼)',3,1,NULL,1),(141,'GZ-XMG-BG-0104003','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,30,'IOS学院(F2楼)',3,1,NULL,1),(142,'GZ-XMG-BG-0104004','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,34,'IOS学院(F2楼)',3,1,NULL,1),(143,'GZ-XMG-BG-0104005','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,29,'IOS学院(F2楼)',3,1,NULL,1),(144,'GZ-XMG-BG-0104006','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,22,'IOS学院(F2楼)',3,1,NULL,1),(145,'GZ-XMG-BG-0104008','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,18,17,'行政部网管(F2楼)',2,1,NULL,1),(146,'GZ-XMG-BG-0104010','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'IOS学院(F2楼)',3,1,NULL,1),(147,'GZ-XMG-BG-0104011','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,27,'IOS学院(F2楼)',3,1,NULL,1),(148,'GZ-XMG-BG-0104012','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,35,'IOS学院(F2楼)',3,1,NULL,1),(149,'GZ-XMG-BG-0104013','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,28,'IOS学院(F2楼)',3,1,NULL,1),(150,'GZ-XMG-BG-0104014','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,38,'IOS学院(F2楼)',3,1,NULL,1),(151,'GZ-XMG-BG-0104015','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,37,'IOS学院(F2楼)',3,1,NULL,1),(152,'GZ-XMG-BG-0104016','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,26,33,'IOS学院(F2楼)',3,1,NULL,1),(153,'GZ-XMG-BG-0104020','办公桌椅柜整套',12,'','','2015-05-01','2015-10-21',2000,24,0,NULL,NULL,'就业部(F2楼)',3,1,NULL,1),(154,'GZ-XMG-PC-0502006','笔记本电脑',10,'HP','','2015-05-01','2015-10-21',2600,25,0,20,12,'学工部(D座5楼办公室)',2,1,15,1),(213,'GZ-18520180310','小手机',10,'三星','北京生产','2015-05-01','2015-10-07',120,24,NULL,20,13,'0',2,1,NULL,1),(215,'GZ-XMG-BG-PEN','笔',11,'晨光','晨光','2015-05-01','2016-07-14',1,24,NULL,NULL,NULL,'数据只是用于测试',25,18,15,1),(228,'GZ-XMG-JS121001','普联三层交换机',47,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'，',9,1,34,1),(229,'GZ-XMG-JS120001','普联二层交换机',65,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,34,1),(230,'GZ-XMG-JS120002','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,34,1),(231,'GZ-XMG-JS120003','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,34,1),(232,'GZ-XMG-JS120004','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(233,'GZ-XMG-JS020001','飞利浦显示器',36,'190VL','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,34,1),(234,'GZ-XMG-JS040001','键盘',67,'三巨','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(235,'GZ-XMG-JS030001','鼠标',68,'三巨','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(239,'GZ-XMG-JS010001','主机',10,'','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,34,1),(240,'GZ-XMG-JS012001','IMAC一体机',70,'APPLE','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,34,1),(241,'GZ-XMG-JS042001','键盘',71,'APPLE','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(242,'GZ-XMG-JS033001','无线触摸板',72,'APPLE','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(243,'GZ-XMG-JS-140001','功放',73,'PEK-K82','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(244,'GZ-XMG-JS-150001','麦克风',74,'','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(245,'GZ-XMG-JS-151001','麦克风架子',75,'','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(246,'GZ-XMG-JS-190001','打卡机',76,'得力','',NULL,'2016-07-25',0,24,NULL,18,115,'',9,1,15,1),(247,'GZ-XMG-JS121002','普联三层交换机',35,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(248,'GZ-XMG-JS-120005','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(249,'GZ-XMG-JS-120006','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(250,'GZ-XMG-JS-120007','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(251,'GZ-XMG-JS-120008','普联二层交换机',65,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(252,'GZ-XMG-JS-120009','普联二层交换机',65,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(253,'GZ-XMG-JS-120010','普联二层交换机',35,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(254,'GZ-XMG-JS-020002','飞利浦显示器',66,'190VL','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(255,'GZ-XMG-JS-040002','键盘',71,'三巨','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,15,1),(256,'GZ-XMG-JS-030002','鼠标',68,'三巨','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,15,1),(257,'GZ-XMG-JS-010002','主机',69,'','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(258,'GZ-XMG-JS-012002','IMAC一体机',70,'APPLE','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(259,'GZ-XMG-JS-042002','键盘',71,'APPLE','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,15,1),(260,'GZ-XMG-JS-033002','无线触摸板',72,'APPLE','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,15,1),(261,'GZ-XMG-JS-140002','功放',73,'PEK-K82','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,34,1),(262,'GZ-XMG-JS-150002','麦克风',74,'','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,15,1),(263,'GZ-XMG-JS151002','麦克风架子',75,'','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,15,1),(264,'GZ-XMG-JS-190002','打卡机',76,'得力','',NULL,'2016-07-25',0,24,NULL,18,115,'',7,1,15,1),(265,'GZ-XMG-JS-121003','普联三层交换机',63,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',8,1,34,1),(266,'GZ-XMG-JS-120011','普联二层交换机',65,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',8,1,34,1),(267,'GZ-XMG-JS-120012','普联二层交换机',65,'TL-SL-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',8,1,15,1),(268,'GZ-XMG-JS-120013','普联二层交换机',65,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',8,1,15,1),(269,'GZ-XMG-JS120014','普联二层交换机',65,'TL-SG-5428','',NULL,'2016-07-25',0,24,NULL,18,115,'',8,1,15,1),(270,'GZ-XMG-JS-020003','飞利浦显示器',66,'190VL','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(271,'GZ-XMG-JS-040003','键盘',67,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(272,'GZ-XMG-JS-030003','鼠标',68,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(273,'GZ-XMG-JS010003','主机',69,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,34,1),(274,'GZ-XMG-JS-012003','IMAC一体机',70,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,34,1),(275,'GZ-XMG-JS-042003','有线键盘',71,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(276,'GZ-XMG-JS-033003','无线触摸板',72,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(277,'GZ-XMG-JS-140003','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(278,'GZ-XMG-JS-150003','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(279,'GZ-XMG-JS-151003','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,1,15,1),(280,'GZ-XMG-JS-190003','打卡机',76,'得力','',NULL,'2016-07-26',0,24,NULL,18,115,'',8,2,15,1),(281,'GZ-XMG-JS-121004','普联三层交换机',63,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,34,1),(282,'GZ-XMG-JS-120015','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,34,1),(283,'GZ-XMG-JS120016','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,34,1),(284,'GZ-XMG-JS-120017','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,34,1),(285,'GZ-XMG-JS-120018','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,34,1),(286,'GZ-XMG-JS-020004','飞利浦显示器',66,'190VL','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,34,1),(287,'GZ-XMG-JS-040004','键盘',71,'柯普达','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(288,'GZ-XMG-JS-030004','鼠标',68,'柯普达','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(289,'GZ-XMG-JS-012004','IMAC一体机',35,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(290,'GZ-XMG-JS042004','键盘',71,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(291,'GZ-XMG-JS-033004','无线触摸板',72,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(292,'GZ-XMG-JS-140004','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(293,'GZ-XMG-JS-150004','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(294,'GZ-XMG-JS-151004','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',10,1,15,1),(295,'GZ-XMG-JS-121007','普联三层交换机',63,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(296,'GZ-XMG-JS-120019','普联楼道交换机',65,'TL-SF-1024L','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(297,'GZ-XMG-JS-120020','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(298,'GZ-XMG-JS-120021','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(299,'GZ-XMG-JS-120022','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(300,'GZ-XMG-JS-120023','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(301,'GZ-XMG-JS-020008','飞利浦显示器',66,'190VL','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(302,'GZ-XMG-JS-040013','键盘',67,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,34,1),(303,'GZ-XMG-JS010008','主机',35,'','',NULL,'2016-07-26',0,24,NULL,18,20,'',61,1,34,1),(304,'BJ-XMG-JS-012006','IMAC一体机',70,'APPLE','',NULL,'2016-07-26',0,25,NULL,18,20,'',62,1,34,1),(305,'BJ-XMG-JS-042005','有线键盘',71,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',62,1,15,1),(306,'BJ-XMG-JS-033005','无线触摸板',72,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',62,1,15,1),(307,'GZ-XMG-JS-140005','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,15,1),(308,'GZ-XMG-JS-150005','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,15,1),(309,'GZ-XMG-JS-151005','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,15,1),(310,'GZ-XMG-JS-190005','打卡机',76,'得力','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,15,1),(311,'GZ-XMG-JS-121008','普联三层交换机',63,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,34,1),(312,'GZ-XMG-JS-120024','普联二层交换机',63,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,34,1),(313,'GZ-XMG-JS-120025','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,34,1),(314,'GZ-XMG-JS-120026','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,15,1),(315,'GZ-XMG-JS-120027','普联楼道二层交换机',65,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,34,1),(316,'BJ-XMG-JS-012007','iMac一体机',70,'apple','',NULL,'2016-07-26',0,25,NULL,18,20,'',62,1,34,1),(317,'GZ-XMG-JS-042006','有线键盘',71,'APPLE','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,15,1),(318,'GZ-XMG-JS-010009','台式电脑',36,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,34,1),(319,'GZ-XMG-JS-020009','飞利浦显示器',66,'190VL','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,34,1),(320,'GZ-XMG-JS-040014','键盘',71,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,15,1),(321,'GZ-XMG-JS030014','鼠标',68,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,15,1),(322,'GZ-XMG-JS-140006','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',13,1,15,1),(323,'GZ-XMG-JS-150006','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,15,1),(324,'GZ-XMG-JS-151006','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,15,1),(325,'GZ-XMG-JS-190006','打卡机',76,'得力','',NULL,'2016-07-26',0,24,NULL,18,115,'',14,1,15,1),(326,'GZ-XMG-JS-121009','普联三层交换机',63,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,34,1),(327,'GZ-XMG-JS-120028','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,34,1),(328,'GZ-XMG-JS-120029','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,34,1),(329,'GZ-XMG-JS-120030','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,34,1),(330,'GZ-XMG-JS-020010','戴尔显示器',77,'U2412M','',NULL,'2016-07-26',0,24,NULL,18,17,'',33,1,34,1),(331,'GZ-XMG-JS-040015','键盘',71,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,15,1),(332,'GZ-XMG-JS-121002','普联二层交换机',65,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',7,1,15,1),(333,'GZ-XMG-JS-04015','键盘',71,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,15,1),(334,'GZ-XMG-JS-030015','鼠标',67,'三巨','',NULL,'2016-07-26',0,24,NULL,18,17,'',33,1,15,1),(335,'GZ-XMG-JS-010010','主机',69,'','',NULL,'2016-07-26',0,24,NULL,18,17,'',33,1,15,1),(336,'GZ-XMG-JS-140007','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,15,1),(337,'GZ-XMG-JS-150007','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,15,1),(338,'GZ-XMG-JS-151007','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,15,1),(339,'GZ-XMG-JS190007','打卡机',76,'得力','',NULL,'2016-07-26',0,24,NULL,18,115,'',15,1,15,1),(340,'GZ-XMG-JS-121010','普联三层交换机',64,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,34,1),(341,'GZ-XMG-JS-120031','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,15,1),(342,'GZ-XMG-JS-120032','普联二层交换机',64,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,34,1),(343,'GZ-XMG-JS120033','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,34,1),(344,'GZ-XMG-JS-020011','飞利浦显示器',66,'190VL','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,15,1),(345,'GZ-XMG-JS-040016','键盘',71,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,15,1),(346,'GZ-XMG-JS-030016','鼠标',65,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,15,1),(347,'GZ-XMG-JS-010011','主机',69,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,34,1),(348,'GZ-XMG-JS-140008','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,15,1),(349,'GZ-XMG-JS150008','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,15,1),(350,'GZ-XMG-JS151008','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',16,1,15,1),(351,'GZ-XMG-JS-121011','普联三层交换机',64,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,34,1),(352,'GZ-XMG-JS120034','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,34,1),(353,'GZ-XMG-JS-120035','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,34,1),(354,'GZ-XMG-JS-120036','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,34,1),(355,'GZ-XMG-JS-120037','普联楼道交换机',65,'TL-SF-1024L','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,34,1),(356,'GZ-XMG-JS-020012','宏碁Acer浦显示器',77,'','',NULL,'2016-07-26',0,25,NULL,18,20,'',61,1,34,1),(357,'GZ-XMG-JS-040017','键盘',71,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,15,1),(358,'GZ-XMG-JS-030017','鼠标',68,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,15,1),(359,'GZ-XMG-JS-010012','主机',69,'','',NULL,'2016-07-26',0,25,NULL,18,20,'',61,1,34,1),(360,'GZ-XMG-JS140009','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,15,1),(361,'GZ-XMG-JS-150009','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,15,1),(362,'GZ-XMG-JS-151009','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,15,1),(363,'GZ-XMG-JS-190009','打卡机',76,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',17,1,15,1),(364,'GZ-XMG-JS-121012','普联三层交换机',64,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(365,'GZ-XMG-JS-120038','普联楼道交换机',65,'TL-SF-1024L','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(366,'GZ-XMG-JS-120039','普联楼道交换机',65,'TL-SF-1024L','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(367,'GZ-XMG-JS-120040','普联楼道交换机',65,'TL-SF-1024L','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(368,'GZ-XMG-JS-120041','普联楼道交换机',65,'TL-SF-1024L','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(369,'GZ-XMG-JS-020013','宏碁Acer浦显示器',77,'ACER','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(370,'GZ-XMG-JS-040018','键盘',67,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,15,1),(371,'GZ-XMG-JS-030018','鼠标',68,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,15,1),(372,'GZ-XMG-JS-010013','主机',69,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(373,'GZ-XMG-JS-140010','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,15,1),(374,'GZ-XMG-JS-151010','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,15,1),(375,'GZ-XMG-JS-190010','打卡机',76,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(376,'GZ-XMG-JS-121013','普联三层交换机',64,'TL-SG-5428','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,15,1),(377,'GZ-XMG-JS-120042','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(378,'GZ-XMG-JS-120043','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,34,1),(379,'GZ-XMG-JS-120044','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',18,1,34,1),(380,'GZ-XMG-JS120045','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,34,1),(381,'GZ-XMG-JS-120046','普联二层交换机',65,'TL-SL-3428','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,34,1),(382,'GZ-XMG-JS-020014','宏碁显示器',77,'ACER','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,34,1),(383,'GZ-XMG-JS-040019','键盘',71,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(384,'GZ-XMG-JS-030019','鼠标',68,'三巨','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(385,'GZ-XMG-JS-010014','主机',69,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(386,'GZ-XMG-JS-140011','功放',73,'PEK-K82','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(387,'GZ-XMG-JS150011','麦克风',74,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(388,'GZ-XMG-JS-151011','麦克风架子',75,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(389,'GZ-XMG-JS-190011','打卡机',76,'','',NULL,'2016-07-26',0,24,NULL,18,115,'',19,1,15,1),(390,'GZ-XMG-JS-020106','UI教室机',77,'','',NULL,'2016-08-31',0,24,NULL,18,17,'',30,1,34,1),(391,'GZ-XMG-JS-010115','UI教室机',69,'','',NULL,'2016-08-31',0,24,NULL,18,17,'',30,1,34,1),(392,'GZ-XMG-JS-040122','UI教室机',71,'','',NULL,'2016-08-31',0,24,NULL,18,17,'',30,1,34,1),(393,'GZ-XMG-JS-030117','UI教室机',68,'','',NULL,'2015-08-31',0,24,NULL,18,17,'',30,1,15,1),(394,'GZ-XMG-JS-020-107','飞利浦显示器',66,'19寸 黑色','',NULL,'2016-09-27',0,24,NULL,32,161,'',25,1,34,1),(395,'GZ-XMG-JS-020-108','飞利浦显示器',66,'19寸 黑色','',NULL,'2016-09-27',0,25,NULL,18,20,'',61,1,34,1),(396,'GZ-XMG-JS-010-116','主机',69,'','',NULL,'2016-09-27',0,24,NULL,32,161,'内存：4G 硬盘：500G CPU：G1840 固定硬盘：128G',25,1,34,1),(397,'GZ-XMG-JS-010-117','主机',69,'','',NULL,'2016-09-27',0,25,NULL,18,20,'内存：4G 硬盘：500G CPU：G1840 固定硬盘：128G',61,1,34,1),(398,'GZ-XMG-JS-040-123','键盘',67,'','',NULL,'2016-09-27',0,24,NULL,32,161,'颜色：黑色 牌子：三巨',25,1,15,1),(399,'GZ-XMG-JS-040-124','键盘',67,'','',NULL,'2016-09-27',0,25,NULL,18,20,'颜色：黑色 牌子：三巨',61,1,15,1),(400,'GZ-XMG-JS-030-118','鼠标',68,'','',NULL,'2016-09-27',0,24,NULL,32,161,'颜色：黑色 牌子：三巨',25,1,15,1),(401,'GZ-XMG-JS-030-119','鼠标',68,'','',NULL,'2016-09-27',0,25,NULL,18,20,'颜色：黑色 牌子：三巨',59,1,15,1),(402,'GZ-XMG-JS-050-006','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(403,'GZ-XMG-JS-050-007','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(404,'GZ-XMG-JS-050-008','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(405,'GZ-XMG-JS-050-009','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(406,'GZ-XMG-JS-050-010','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(407,'GZ-XMG-JS-050-011','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,34,1),(408,'GZ-XMG-JS-050-012','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,34,1),(409,'GZ-XMG-JS-050-013','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(410,'GZ-XMG-JS-050-014','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,34,1),(411,'GZ-XMG-JS-050-015','笔记本电脑',35,'ThinkPad E550','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,34,1),(412,'GZ-XMG-JS-030-120','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(413,'GZ-XMG-JS-030-121','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(414,'GZ-XMG-JS-030-122','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(415,'GZ-XMG-JS-030-123','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(416,'GZ-XMG-JS-030-124','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(417,'GZ-XMG-JS-030-125','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(418,'GZ-XMG-JS-030-126','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(419,'GZ-XMG-JS-030-127','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(420,'GZ-XMG-JS-030-128','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(421,'GZ-XMG-JS-030-129','鼠标',159,'联想M20','',NULL,'2016-11-02',0,25,NULL,18,20,'',61,1,15,1),(422,'GZ-XMG-JS-010-094','主机',69,'一条8GB ddr3-1600MHz内存','',NULL,'2016-11-08',0,24,NULL,25,238,'',12,0,15,1),(423,'BJ-XMG-JS-121-028','三层交换机',64,'华为 S5700','',NULL,'2016-11-15',0,24,NULL,18,110,'24个普通端口，4个光纤端口',62,1,15,2),(424,'BJ-XMG-JS-120-098','普联二层交换机',65,'TL-SL3428','',NULL,'2016-11-15',0,24,NULL,18,110,'28个普通端口，2个光纤端口',62,1,15,2),(425,'BJ-XMG-JS-120-101','普联二层交换机',65,'TL-SL3428','',NULL,'2016-11-15',0,24,NULL,18,110,'28个普通端口，2个光纤端口',62,1,15,2),(426,'BJ-XMG-JS-120-102','普联二层交换机',65,'TL-SG5428','',NULL,'2016-11-15',0,24,NULL,18,110,'24个普通端口，4个光纤端口',62,1,15,2),(427,'BJ-XMG-JS-120-103','普联二层交换机',65,'TL-SL3226','',NULL,'2016-11-15',0,24,NULL,18,110,'26个普通端口',62,1,15,2),(428,'BJ-XMG-JS-120-104','普联二层交换机',65,'TL-SL3226','',NULL,'2016-11-15',0,24,NULL,18,110,'26个普通端口',62,1,15,2),(429,'BJ-XMG-JS-110-009','艾泰路由器',160,'4220G','',NULL,'2016-11-15',0,24,NULL,18,110,'5个LAN端口，2个WAN端口',62,0,15,2),(430,'BJ-XMG-JS-122-005','普联POE交换机',161,'TL-SF1009P','',NULL,'2016-11-15',0,24,NULL,18,110,'8个普通端口',62,2,15,2),(431,'GZ-XMG-JS-030-092','鼠标',159,'三巨','',NULL,'2016-11-08',0,24,NULL,32,211,'',42,1,15,1),(432,'GZ-XMG-JS-020-084','飞利浦显示器',66,'190v4L(4寸)','',NULL,'2016-11-08',0,24,NULL,32,211,'',42,1,34,1),(433,'GZ-XMG-JS-010-086','主机',69,'cpu:intel G1820 2.7G','',NULL,'2016-11-08',0,24,NULL,32,211,'',42,1,34,1),(434,'GZ-XMG-JS-040-099','键盘',71,'三巨','',NULL,'2016-11-08',0,24,NULL,32,211,'',42,1,15,1);

ALTER TABLE `yx_assets` ENABLE KEYS;
UNLOCK TABLES;
COMMIT;

--
-- Data for table: yx_computer_type
--
LOCK TABLES `yx_computer_type` WRITE;
ALTER TABLE `yx_computer_type` DISABLE KEYS;

INSERT INTO `yx_computer_type` (`id`,`typeName`) VALUES (1,'mac-mini(迷你主机）'),(2,'imac(低配一体机）'),(3,'imac(高配一体机） '),(4,'笔记本'),(5,'普通台式电脑'),(6,'imac-顶配教师机');

ALTER TABLE `yx_computer_type` ENABLE KEYS;
UNLOCK TABLES;
COMMIT;

--
-- Data for table: yx_method
--
LOCK TABLES `yx_method` WRITE;
ALTER TABLE `yx_method` DISABLE KEYS;

INSERT INTO `yx_method` (`id`,`rootid`,`pid`,`operate`,`name`,`ifmenu`) VALUES (1,1,0,'admin','后台登陆管理',1),(2,1,1,'index','管理员管理',1),(4,1,1,'admindel','管理员删除',0),(5,1,1,'adminedit','管理员编辑',0),(6,1,1,'adminlock','管理员锁定',0),(7,1,1,'group','权限管理',1),(8,1,1,'groupedit','管理组编辑',0),(9,1,1,'groupdel','管理组删除',0),(17,17,0,'dbback','数据库管理',1),(18,17,17,'index','数据库备份',1),(19,17,17,'recover','备份恢复',0),(20,17,17,'detail','备份详细',0),(21,17,17,'del','备份删除',0),(22,22,0,'index','后台面板',0),(23,22,22,'index','后台首页',0),(24,22,22,'login','登陆',0),(25,22,22,'logout','退出登陆',0),(26,22,22,'verify','验证码',0),(27,22,22,'welcome','服务器环境',0),(28,28,0,'set','全局设置',1),(29,28,28,'index','网站设置',1),(340,337,337,'rentedit','修改',1),(85,28,28,'menuname','后台功能',0),(228,1,1,'adminnow','账户管理',1),(339,337,337,'rentadd','租赁添加',1),(314,314,0,'files','附件管理',1),(315,314,314,'index','上传文件管理',1),(316,314,314,'del','删除文件',0),(320,17,17,'sqlrun','SQL执行',1),(337,337,0,'rent','电脑租赁管理',1),(338,337,337,'index','记录查询',1),(341,337,337,'rerent','续租',1),(342,337,337,'rentcancel','退租',1),(376,374,374,'issueIndex','领用查询',1),(373,370,370,'add','固定资产增加',1),(372,370,370,'edit','固定资产编辑',1),(371,370,370,'index','资产查询',1),(374,374,0,'consumables','易耗品管理',1),(370,370,0,'asset','固定资产管理',1),(375,374,374,'index','易耗品查询',1),(367,337,337,'rentshow','电脑查询',0),(366,337,337,'rentstore','设备库存',1),(365,337,337,'rentchange','设备租期内更换',1),(377,374,374,'add','易耗品增加',1),(378,374,374,'edit','易耗品修改',0),(379,374,374,'issue','易耗品领用',1),(380,380,0,'nonconsumables','非易耗品',1),(382,380,380,'issueIndex','领用查询',1),(381,380,380,'index','非易耗品查询',1),(383,380,380,'add','非易耗品增加',1),(384,380,380,'edit','非易耗品修改',0),(385,380,380,'issue','非易耗品领用',1),(386,386,0,'coreset','行政核心设置',1),(387,386,386,'userIndex','用户管理',1),(388,386,386,'departmentIndex','部门管理',1),(389,386,386,'locationIndex','地点管理',1),(390,386,386,'measureIndex','计量单位管理',1),(391,386,386,'userEdit','用户编辑',0),(392,386,386,'userDelete','用户删除',0),(393,386,386,'userAdd','用户增加',0),(394,386,386,'departmentEdit','部门信息修改',0),(395,386,386,'departmentDelete','部门删除',0),(396,386,386,'departmentAdd','部门添加',0),(397,386,386,'locationAdd','地点增加',0),(398,386,386,'locationEdit','地点编辑',0),(399,386,386,'locationDelete','地点删除',0),(400,386,386,'measureAdd','单位增加',0),(401,386,386,'measureEdit','单位编辑',0),(402,386,386,'measureDelete','单位删除',0),(403,386,386,'typeIndex','资产类型',1),(404,386,386,'typeAdd','资产类型增加',0),(405,386,386,'typeEdit','资产类型编辑',0),(406,386,386,'typeDelete','资产类型删除',0),(407,407,0,'hronly','人事专用',1),(408,407,407,'index','资料搜索',1),(409,407,407,'download','资料导出',0);

ALTER TABLE `yx_method` ENABLE KEYS;
UNLOCK TABLES;
COMMIT;

--
-- Data for table: yx_sort
--
LOCK TABLES `yx_sort` WRITE;
ALTER TABLE `yx_sort` DISABLE KEYS;

-- Table contains no data

ALTER TABLE `yx_sort` ENABLE KEYS;
UNLOCK TABLES;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

