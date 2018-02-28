/*
Navicat MySQL Data Transfer

Source Server         : 2131
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : shubaona

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-02-28 21:21:53
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
-- Table structure for tp_auth
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth`;
CREATE TABLE `tp_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` varchar(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `rule` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_auth
-- ----------------------------
INSERT INTO `tp_auth` VALUES ('1', '1', '超级管理员', '1', '1,2,3,4,5,6,7,9');
INSERT INTO `tp_auth` VALUES ('2', '0', '管理员', '1', '3,4,5,6,7');

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
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_blacklist
-- ----------------------------

-- ----------------------------
-- Table structure for tp_black_order
-- ----------------------------
DROP TABLE IF EXISTS `tp_black_order`;
CREATE TABLE `tp_black_order` (
  `black_order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `black_order_alipay_id` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`black_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_black_order
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

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
INSERT INTO `tp_menu` VALUES ('8', '个人中心', '/index/show', 'am-icon-home', '1', '0', '1');
INSERT INTO `tp_menu` VALUES ('9', '操作日志', '/admin/weblog/index', 'am-icon-table', '8', '1', '1');

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
  `order_qq` varchar(50) DEFAULT NULL,
  `order_alipay_id` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(2) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `numbers` (`order_number`),
  KEY `orders_` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_orders
-- ----------------------------
INSERT INTO `tp_orders` VALUES ('13', '3', '123456', '321321', '1', '13222552513', '212321515857', '0', '1518421063', '1519131171');
INSERT INTO `tp_orders` VALUES ('14', '7', '123412356', '321321', '1', '21335482', '12454782', '0', '1518421063', '1519131171');
INSERT INTO `tp_orders` VALUES ('15', '4', '1256', '321321', '1', '132854528', '2318565134', '0', '1518421063', '1519131171');
INSERT INTO `tp_orders` VALUES ('16', '11', '12533336', '321321', '1', '2132185', '21318522', '0', '1518421063', '1519131171');
INSERT INTO `tp_orders` VALUES ('17', '11', '12533337446', '321321', '1', '233132154', '128574', '0', '1518421063', '1519131171');
INSERT INTO `tp_orders` VALUES ('18', '11', '3215534234', '', '1', '2134854', '2123454', '0', '0', '1519131171');
INSERT INTO `tp_orders` VALUES ('20', '2', 'asdasdasd', '123123123', '1', '123123', '123123', '0', '1519056000', '1519131171');
INSERT INTO `tp_orders` VALUES ('21', '2', '312343242sdfadfasfv', '34234234', '0', '234234', '42134234', '0', '1519119634', '1519131171');

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
  UNIQUE KEY `email_unique` (`email`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `alipay_id` (`alipay_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_users
-- ----------------------------
INSERT INTO `tp_users` VALUES ('1', '11111111111', 'asdasd', '88888', 'al121111', '$2y$10$av8CXNqEjHwkd4aK3Spzd.PndiEuiGI83ueENprSs/ws9RzWe1cyC', '0', '1', null, '1519117719');
INSERT INTO `tp_users` VALUES ('2', '13640222917', 'asdasdasd', '463024796', '463024796@qq.com', '$2y$10$nKl0/glIQJxMMPl8VIwxbO7uVMlmnDEK93ieZsOv1Ok0xDuOYPT32', '1', '1', '1518091788', '1519117757');
INSERT INTO `tp_users` VALUES ('3', '45665432111', '2asda', '463055555555', 'alibaba3213123', '$2y$10$ARsYmrtLlwdeqFsXNuAiOOv0GJg0OP3M2nGRqvLYerxpNKH93HVNu', '0', '1', null, '1519117759');
INSERT INTO `tp_users` VALUES ('4', '5465102', 'wqwqwe', '463055555555', 'alibaba', '$2y$10$BrSMGXm.s3wf86On0CvtgOybTjC82QxZndIy3rlbcwIZWlC7FE3I.', '0', '1', '1518105600', '1519117699');
INSERT INTO `tp_users` VALUES ('5', '01465', 'asdascczc', '463055555555', 'alibaba56123', '$2y$10$dNl7epGZ3P1mvTV/n3G4A.3Y3tcWE6taYkGGV8mtviV0PTZiHI60.', '0', '1', '1518105600', '1519117699');
INSERT INTO `tp_users` VALUES ('6', '04156456', 'admi3n@admin.com', '463055555555', 'alibaba545', '$2y$10$zjBoGbS7MFV.yg3N8B6lPu6kNf7VqxbTFGxfM2qg5nZDYzrlt5oPe', '0', '1', '1518105600', '1519117699');
INSERT INTO `tp_users` VALUES ('7', '0154654', 'admin45@admin.com', '4646546564', '463024796', '$2y$10$aUMU4MFlQtmUGrcTKIq9E.AF04HrJDvZKx5LPt2phQRp0Rnj3iVeG', '0', '1', '1518105600', '1519117699');
INSERT INTO `tp_users` VALUES ('8', '0', '23123@qq.com', '321', '23121', '$2y$10$vxnbfdV7rjpEB4BDyEuch.xKnf5vpuovdehK1GXPYd7H4cJ7VOpFq', '0', '1', '1518364800', '1519117699');
INSERT INTO `tp_users` VALUES ('11', '13640222916', 'xxxxdianpu', '13213213', '12123123', '$2y$10$nKl0/glIQJxMMPl8VIwxbO7uVMlmnDEK93ieZsOv1Ok0xDuOYPT32', '0', '1', '1518428720', '1519117699');
INSERT INTO `tp_users` VALUES ('12', '13640222915', '我大夫撒旦法金卡第三方', '123132132132', '13640222915', '$2y$10$f4lrlIOSetU.On0SGn2Sv.7KHO5S/Fd2IGhUelmjXCEa7uC02x1xy', '0', '1', '1518445753', '1519117699');
INSERT INTO `tp_users` VALUES ('13', '13640222914', '就不删掉都是', '6446213345', '13640222917', '$2y$10$egL63goXyLPdsHULIQIa6O/kXDjbkN4rM46pfzKq/Jkq0KDICSuA6', '0', '0', '1519134605', '1519134605');

-- ----------------------------
-- Table structure for tp_web_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_web_log`;
CREATE TABLE `tp_web_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志主键',
  `uid` smallint(5) unsigned NOT NULL COMMENT '用户id',
  `ip` char(15) NOT NULL COMMENT '访客ip',
  `url` varchar(255) NOT NULL COMMENT 'url',
  `method` varchar(10) NOT NULL DEFAULT 'GET' COMMENT '请求类型',
  `data` text NOT NULL COMMENT '请求的param数据，serialize后的',
  `created_at` int(11) unsigned NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `ip` (`ip`) USING BTREE,
  KEY `otime` (`created_at`) USING BTREE,
  KEY `method` (`method`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='网站日志';

-- ----------------------------
-- Records of tp_web_log
-- ----------------------------
INSERT INTO `tp_web_log` VALUES ('75', '2', '127.0.0.1', '/admin/orders/delete', 'Ajax', '{\"all\":\",,21,20,18,17,16,15,14,13\"}', '1519131167');
INSERT INTO `tp_web_log` VALUES ('76', '2', '127.0.0.1', '/admin/orders/del-order-reback', 'Ajax', '{\"all\":\",on,21,20,18,17,16,15,14,13\"}', '1519131171');
INSERT INTO `tp_web_log` VALUES ('77', '2', '127.0.0.1', '/admin/orders/del-black', 'Ajax', '{\"id\":\"20\"}', '1519131182');
INSERT INTO `tp_web_log` VALUES ('78', '2', '127.0.0.1', '/admin/orders/del-black', 'Ajax', '{\"id\":\"18\"}', '1519131182');
INSERT INTO `tp_web_log` VALUES ('79', '2', '127.0.0.1', '/admin/orders/del-black', 'Ajax', '{\"id\":\"17\"}', '1519131183');
INSERT INTO `tp_web_log` VALUES ('80', '2', '127.0.0.1', '/admin/orders/del-black', 'Ajax', '{\"id\":\"16\"}', '1519131187');
INSERT INTO `tp_web_log` VALUES ('81', '2', '127.0.0.1', '/admin/orders/del-black', 'Ajax', '{\"id\":\"15\"}', '1519131187');
INSERT INTO `tp_web_log` VALUES ('82', '2', '127.0.0.1', '/admin/orders/del-black', 'Ajax', '{\"id\":\"13\"}', '1519131188');
INSERT INTO `tp_web_log` VALUES ('83', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"1\"}', '1519131191');
INSERT INTO `tp_web_log` VALUES ('84', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"2\"}', '1519131192');
INSERT INTO `tp_web_log` VALUES ('85', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"3\"}', '1519131192');
INSERT INTO `tp_web_log` VALUES ('86', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"4\"}', '1519131193');
INSERT INTO `tp_web_log` VALUES ('87', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"5\"}', '1519131194');
INSERT INTO `tp_web_log` VALUES ('88', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"7\"}', '1519131195');
INSERT INTO `tp_web_log` VALUES ('89', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"11\"}', '1519131196');
INSERT INTO `tp_web_log` VALUES ('90', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"12\"}', '1519131196');
INSERT INTO `tp_web_log` VALUES ('91', '2', '127.0.0.1', '/admin/blacklist/member', 'Ajax', '{\"id\":\"8\"}', '1519131197');
INSERT INTO `tp_web_log` VALUES ('92', '2', '127.0.0.1', '/admin/blacklist/del-reback', 'Ajax', '{\"all\":\",on,23121,13640222915,12123123,463024796,alibaba56123,alibaba,alibaba3213123,463024796@qq.com,al121111,212321515857,2318565134,21318522,128574,2123454,123123\"}', '1519131206');
