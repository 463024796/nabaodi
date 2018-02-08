/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : shubaona

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-02-08 23:05:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_announcement
-- ----------------------------
DROP TABLE IF EXISTS `tp_announcement`;
CREATE TABLE `tp_announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_announcement
-- ----------------------------

-- ----------------------------
-- Table structure for tp_blacklist
-- ----------------------------
DROP TABLE IF EXISTS `tp_blacklist`;
CREATE TABLE `tp_blacklist` (
  `blacklist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`blacklist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_blacklist
-- ----------------------------

-- ----------------------------
-- Table structure for tp_orders
-- ----------------------------
DROP TABLE IF EXISTS `tp_orders`;
CREATE TABLE `tp_orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0为未处理1为已处理',
  `is_deleted` tinyint(2) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `orders_` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_orders
-- ----------------------------
INSERT INTO `tp_orders` VALUES ('1', '2', '11', '1', '0', '1518096371', '1518096371');
INSERT INTO `tp_orders` VALUES ('2', '2', '1', '0', '1', '1518096371', '1518096371');

-- ----------------------------
-- Table structure for tp_users
-- ----------------------------
DROP TABLE IF EXISTS `tp_users`;
CREATE TABLE `tp_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `alipay_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(2) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_users
-- ----------------------------
INSERT INTO `tp_users` VALUES ('1', '123@qq.com', '12345678911', '123456', '$2y$10$av8CXNqEjHwkd4aK3Spzd.PndiEuiGI83ueENprSs/ws9RzWe1cyC', '0', null, null);
INSERT INTO `tp_users` VALUES ('2', '463024796@qq.com', '463024796', '463024796@qq.com', '$2y$10$YyWEX9EbsXyMJAo1ubH1Xu4OswtIKciFtUcR5wElnxQW3GwvMkTMC', '1', '1518091788', '1518091788');
