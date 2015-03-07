/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50528
Source Host           : localhost:3306
Source Database       : wjl_blog

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2015-03-07 22:18:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `meta`
-- ----------------------------
DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `post`
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` longtext NOT NULL,
  `status` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(128) NOT NULL,
  `type` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category` int(10) unsigned NOT NULL,
  `year` smallint(12) NOT NULL COMMENT 'yyyy',
  `month` tinyint(4) NOT NULL COMMENT '1~12',
  `created` varchar(20) NOT NULL COMMENT 'yyyy-MM-dd HH:mm:ss',
  `sticky` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1|0',
  `html` longtext NOT NULL,
  `updated` varchar(20) NOT NULL COMMENT 'yyyy-MM-dd HH:mm:ss',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `post_and_series`
-- ----------------------------
DROP TABLE IF EXISTS `post_and_series`;
CREATE TABLE `post_and_series` (
  `post` bigint(20) unsigned NOT NULL,
  `series` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post`,`series`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `post_and_tag`
-- ----------------------------
DROP TABLE IF EXISTS `post_and_tag`;
CREATE TABLE `post_and_tag` (
  `post` bigint(20) unsigned NOT NULL,
  `tag` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post`,`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `taxonomy`
-- ----------------------------
DROP TABLE IF EXISTS `taxonomy`;
CREATE TABLE `taxonomy` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `text` varchar(256) NOT NULL,
  `type` varchar(8) NOT NULL COMMENT 'category|tag',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;