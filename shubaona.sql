/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : shubaona

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-02-11 22:13:24
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
  PRIMARY KEY (`blacklist_id`),
  UNIQUE KEY `user_unique` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_blacklist
-- ----------------------------

-- ----------------------------
-- Table structure for tp_menu
-- ----------------------------
DROP TABLE IF EXISTS `tp_menu`;
CREATE TABLE `tp_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_menu
-- ----------------------------
INSERT INTO `tp_menu` VALUES ('1', '首页', '/admin/show', 'am-icon-home', '1', '1', '1');
INSERT INTO `tp_menu` VALUES ('2', '所有用户', '/admin/all-members', 'am-icon-times', '2', '1', '1');
INSERT INTO `tp_menu` VALUES ('3', '所有订单', '/admin/all-orders', 'am-icon-table', '3', '1', '1');
INSERT INTO `tp_menu` VALUES ('4', '未完成订单', '/admin/uncompleted', 'am-icon-tag', '4', '1', '1');
INSERT INTO `tp_menu` VALUES ('5', '已完成订单', '/admin/completed', 'am-icon-check', '5', '1', '1');
INSERT INTO `tp_menu` VALUES ('6', '订单回收站', '/admin/recycling', 'am-icon-trash-o', '6', '1', '1');
INSERT INTO `tp_menu` VALUES ('7', '黑名单', '/admin/blacklist', 'am-icon-times', '7', '1', '1');
INSERT INTO `tp_menu` VALUES ('8', '个人中心', '/index/show', 'am-icon-home', '1', '1', '0');

-- ----------------------------
-- Table structure for tp_orders
-- ----------------------------
DROP TABLE IF EXISTS `tp_orders`;
CREATE TABLE `tp_orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0为未处理1为已处理',
  `is_deleted` tinyint(2) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `numbers` (`order_number`),
  KEY `orders_` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_orders
-- ----------------------------
INSERT INTO `tp_orders` VALUES ('1', '2', '123', '11', '1', '1', '1518096371', '1518096371');
INSERT INTO `tp_orders` VALUES ('2', '2', '321', '1', '1', '1', '1518096371', '1518096371');
INSERT INTO `tp_orders` VALUES ('3', '1', '222', 'wo juemdead f', '1', '1', '1970', '1970');
INSERT INTO `tp_orders` VALUES ('8', '1', '', '32131321', '1', '1', '1518350503', '1518350503');
INSERT INTO `tp_orders` VALUES ('7', '1', '231356', 'wotetiana ', '1', '1', '1518105600', '1518105600');
INSERT INTO `tp_orders` VALUES ('9', '1', '231231321', '123123', '0', '0', '1518352204', '1518352204');
INSERT INTO `tp_orders` VALUES ('10', '1', '321432423', '123', '0', '0', '1518354594', '1518354594');
INSERT INTO `tp_orders` VALUES ('11', '1', '323', '1234444', '0', '0', '1518354608', '1518354608');
INSERT INTO `tp_orders` VALUES ('12', '1', '321321', '123', '0', '0', '1518354629', '1518354629');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_users
-- ----------------------------
INSERT INTO `tp_users` VALUES ('1', '123@qq.com', '12345678911', '123456', '$2y$10$av8CXNqEjHwkd4aK3Spzd.PndiEuiGI83ueENprSs/ws9RzWe1cyC', '0', null, null);
INSERT INTO `tp_users` VALUES ('2', '463024796@qq.com', '463024796', '463024796@qq.com', '$2y$10$YyWEX9EbsXyMJAo1ubH1Xu4OswtIKciFtUcR5wElnxQW3GwvMkTMC', '1', '1518091788', '1518091788');
INSERT INTO `tp_users` VALUES ('3', 'admin@admin.com', '463055555555', 'alibaba', '$2y$10$ARsYmrtLlwdeqFsXNuAiOOv0GJg0OP3M2nGRqvLYerxpNKH93HVNu', '0', null, null);
INSERT INTO `tp_users` VALUES ('4', 'admi1n@admin.com', '463055555555', 'alibaba', '$2y$10$BrSMGXm.s3wf86On0CvtgOybTjC82QxZndIy3rlbcwIZWlC7FE3I.', '0', '1518105600', '1518105600');
INSERT INTO `tp_users` VALUES ('5', 'admi2n@admin.com', '463055555555', 'alibaba', '$2y$10$dNl7epGZ3P1mvTV/n3G4A.3Y3tcWE6taYkGGV8mtviV0PTZiHI60.', '0', '1518105600', '1518105600');
INSERT INTO `tp_users` VALUES ('6', 'admi3n@admin.com', '463055555555', 'alibaba', '$2y$10$zjBoGbS7MFV.yg3N8B6lPu6kNf7VqxbTFGxfM2qg5nZDYzrlt5oPe', '0', '1518105600', '1518105600');
INSERT INTO `tp_users` VALUES ('7', 'admin45@admin.com', '4646546564', '463024796@qq.com', '$2y$10$aUMU4MFlQtmUGrcTKIq9E.AF04HrJDvZKx5LPt2phQRp0Rnj3iVeG', '0', '1518105600', '1518105600');
