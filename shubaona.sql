/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : shubaona

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-02-12 19:49:49
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_announcement
-- ----------------------------
INSERT INTO `tp_announcement` VALUES ('1', '<p>欢迎来到舒宝娜管理系统<br><br>&nbsp;&nbsp;&nbsp;&nbsp;--舒宝娜内衣旗舰店</p>');

-- ----------------------------
-- Table structure for tp_blacklist
-- ----------------------------
DROP TABLE IF EXISTS `tp_blacklist`;
CREATE TABLE `tp_blacklist` (
  `blacklist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`blacklist_id`),
  UNIQUE KEY `user_unique` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_orders
-- ----------------------------
INSERT INTO `tp_orders` VALUES ('13', '3', '123456', '321321', '1', '0', '1518421063', '1518435577');
INSERT INTO `tp_orders` VALUES ('14', '7', '123412356', '321321', '1', '0', '1518421063', '1518435577');
INSERT INTO `tp_orders` VALUES ('15', '4', '1256', '321321', '1', '0', '1518421063', '1518435577');
INSERT INTO `tp_orders` VALUES ('16', '1', '12533336', '321321', '1', '0', '1518421063', '1518435577');
INSERT INTO `tp_orders` VALUES ('17', '8', '12533337446', '321321', '1', '0', '1518421063', '1518435577');
INSERT INTO `tp_orders` VALUES ('18', '2', '1253', '321321', '1', '0', '1518364800', '1518435577');

-- ----------------------------
-- Table structure for tp_users
-- ----------------------------
DROP TABLE IF EXISTS `tp_users`;
CREATE TABLE `tp_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `alipay_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(2) DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_users
-- ----------------------------
INSERT INTO `tp_users` VALUES ('1', '11111111111', 'asdasd', '88888', 'al121111', '$2y$10$av8CXNqEjHwkd4aK3Spzd.PndiEuiGI83ueENprSs/ws9RzWe1cyC', '0', '1', null, '1518435605');
INSERT INTO `tp_users` VALUES ('2', '13640222917', 'asdasdasd', '463024796', '463024796@qq.com', '$2y$10$nKl0/glIQJxMMPl8VIwxbO7uVMlmnDEK93ieZsOv1Ok0xDuOYPT32', '1', '1', '1518091788', '1518091788');
INSERT INTO `tp_users` VALUES ('3', '45665432111', '2asda', '463055555555', 'alibaba3213123', '$2y$10$ARsYmrtLlwdeqFsXNuAiOOv0GJg0OP3M2nGRqvLYerxpNKH93HVNu', '0', '1', null, '1518435605');
INSERT INTO `tp_users` VALUES ('4', '0', 'wqwqwe', '463055555555', 'alibaba', '$2y$10$BrSMGXm.s3wf86On0CvtgOybTjC82QxZndIy3rlbcwIZWlC7FE3I.', '0', '1', '1518105600', '1518435605');
INSERT INTO `tp_users` VALUES ('5', '0', 'asdascczc', '463055555555', 'alibaba', '$2y$10$dNl7epGZ3P1mvTV/n3G4A.3Y3tcWE6taYkGGV8mtviV0PTZiHI60.', '0', '1', '1518105600', '1518435605');
INSERT INTO `tp_users` VALUES ('6', '0', 'admi3n@admin.com', '463055555555', 'alibaba', '$2y$10$zjBoGbS7MFV.yg3N8B6lPu6kNf7VqxbTFGxfM2qg5nZDYzrlt5oPe', '0', '1', '1518105600', '1518435605');
INSERT INTO `tp_users` VALUES ('7', '0', 'admin45@admin.com', '4646546564', '463024796@qq.com', '$2y$10$aUMU4MFlQtmUGrcTKIq9E.AF04HrJDvZKx5LPt2phQRp0Rnj3iVeG', '0', '1', '1518105600', '1518435605');
INSERT INTO `tp_users` VALUES ('8', '0', '23123@qq.com', '321', '23121', '$2y$10$vxnbfdV7rjpEB4BDyEuch.xKnf5vpuovdehK1GXPYd7H4cJ7VOpFq', '0', '1', '1518364800', '1518435605');
INSERT INTO `tp_users` VALUES ('11', '13640222916', 'xxxxdianpu', '13213213', '12123123', '$2y$10$nKl0/glIQJxMMPl8VIwxbO7uVMlmnDEK93ieZsOv1Ok0xDuOYPT32', '0', '1', '1518428720', '1518435605');
