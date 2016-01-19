/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50624
 Source Host           : localhost
 Source Database       : qdsay

 Target Server Type    : MySQL
 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 01/19/2016 11:24:09 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `qd_admin`
-- ----------------------------
DROP TABLE IF EXISTS `qd_admin`;
CREATE TABLE `qd_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `groups_id` smallint(5) unsigned DEFAULT '0' COMMENT '用户组',
  `last_login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后一次登录时间',
  `last_login_ip` char(15) NOT NULL COMMENT '最后一次登录IP',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `groups` (`groups_id`),
  CONSTRAINT `fk_groups_id` FOREIGN KEY (`groups_id`) REFERENCES `qd_groups` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
--  Records of `qd_admin`
-- ----------------------------
BEGIN;
INSERT INTO `qd_admin` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1', '2016-01-17 22:30:52', '127.0.0.1', '2012', '1'), ('2', 'star', '2c7506884cab4cf19a0506bdda6701d9', '2', '2015-04-04 21:18:43', '127.0.0.1', '1407682164', '1');
COMMIT;

-- ----------------------------
--  Table structure for `qd_article`
-- ----------------------------
DROP TABLE IF EXISTS `qd_article`;
CREATE TABLE `qd_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '标题',
  `catalog_id` smallint(5) unsigned NOT NULL COMMENT '分类',
  `image` varchar(64) DEFAULT '' COMMENT '文章配图',
  `tags` varchar(255) NOT NULL COMMENT '标签',
  `summary` varchar(255) NOT NULL COMMENT '摘要',
  `contents` text COMMENT '内容',
  `author` varchar(32) DEFAULT NULL COMMENT '作者',
  `origin` varchar(64) DEFAULT NULL COMMENT '信息来源',
  `level` tinyint(1) unsigned DEFAULT '9' COMMENT '推荐级别',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `fk_catalog_id` (`catalog_id`),
  KEY `fk_level` (`level`),
  KEY `fk_disabled` (`disabled`),
  KEY `fk_addtime` (`addtime`),
  KEY `fk_uptime` (`uptime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
--  Records of `qd_article`
-- ----------------------------
BEGIN;
INSERT INTO `qd_article` VALUES ('1', '勤道基础开发框架开源', '1', 'uploads/article/2016/0117/26994820975.jpeg', '勤道,php,开发框架', '勤道基础开发框架开源', '<p>勤道基础开发框架开源</p>', '勤道', '勤道', '1', '1', '1453026994', '2016-01-17 18:36:34');
COMMIT;

-- ----------------------------
--  Table structure for `qd_assist`
-- ----------------------------
DROP TABLE IF EXISTS `qd_assist`;
CREATE TABLE `qd_assist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '标题',
  `aliases` char(32) NOT NULL COMMENT '别名',
  `contents` text COMMENT '内容',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_aliases` (`aliases`),
  KEY `fk_disabled` (`disabled`),
  KEY `fk_addtime` (`addtime`),
  KEY `fk_uptime` (`uptime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='页面';

-- ----------------------------
--  Records of `qd_assist`
-- ----------------------------
BEGIN;
INSERT INTO `qd_assist` VALUES ('1', '关于我们', 'aboutus', '<p>我们是一个热爱开源的技术团队。</p>', '1', '1453131908', '2016-01-18 23:45:08');
COMMIT;

-- ----------------------------
--  Table structure for `qd_catalog`
-- ----------------------------
DROP TABLE IF EXISTS `qd_catalog`;
CREATE TABLE `qd_catalog` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'åç±»ID',
  `father_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `grade` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '级别',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `type` enum('article') NOT NULL DEFAULT 'article' COMMENT '类型',
  `name` char(32) NOT NULL COMMENT '名称',
  `aliases` char(32) NOT NULL DEFAULT '' COMMENT '别名',
  `disabled` tinyint(1) unsigned DEFAULT '0' COMMENT '是否禁用',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `fk_father_id` (`father_id`),
  KEY `fk_grade` (`grade`),
  KEY `fk_sort` (`sort`),
  KEY `fk_type` (`type`),
  KEY `fk_aliases` (`aliases`),
  KEY `fk_disabled` (`disabled`),
  KEY `fk_uptime` (`uptime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='åç±»ç®å½';

-- ----------------------------
--  Records of `qd_catalog`
-- ----------------------------
BEGIN;
INSERT INTO `qd_catalog` VALUES ('1', '0', '0', '0', 'article', '企业新闻', '', '0', '2016-01-17 15:00:51');
COMMIT;

-- ----------------------------
--  Table structure for `qd_gallery`
-- ----------------------------
DROP TABLE IF EXISTS `qd_gallery`;
CREATE TABLE `qd_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `caller` char(16) NOT NULL COMMENT '调用',
  `caller_id` int(10) unsigned NOT NULL COMMENT '调用ID',
  `image` varchar(64) NOT NULL COMMENT '图标',
  `info` varchar(255) NOT NULL COMMENT '图片信息',
  `serial` tinyint(2) unsigned NOT NULL COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `fk_caller` (`caller`,`caller_id`) USING BTREE,
  KEY `fk_serial` (`serial`),
  KEY `fk_addtime` (`addtime`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='图集';

-- ----------------------------
--  Records of `qd_gallery`
-- ----------------------------
BEGIN;
INSERT INTO `qd_gallery` VALUES ('2', 'solution', '4', 'uploads/solution/2014/1122/75927972531.jpg', '2153144841', '1', '0'), ('4', 'solution', '4', 'uploads/solution/2014/1123/60582308835.jpg', 'tooopen_20574578', '2', '0'), ('5', 'solution', '4', 'uploads/solution/2014/1123/61484669575.jpg', '1351564155F3ADU8', '0', '0'), ('6', 'article', '2', 'uploads/article/2016/0113/97851469781.png', '86548691159', '1', '0'), ('8', 'article', '2', 'uploads/article/2016/0113/98149766424.png', '60628199574', '0', '0'), ('9', 'article', '2', 'uploads/article/2016/0113/98149766575.png', '60617018449', '2', '0');
COMMIT;

-- ----------------------------
--  Table structure for `qd_groups`
-- ----------------------------
DROP TABLE IF EXISTS `qd_groups`;
CREATE TABLE `qd_groups` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` char(16) NOT NULL COMMENT '用户组',
  `auth` varchar(21785) DEFAULT NULL COMMENT '权限',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户组';

-- ----------------------------
--  Records of `qd_groups`
-- ----------------------------
BEGIN;
INSERT INTO `qd_groups` VALUES ('1', '管理员', 'a:8:{s:5:\"admin\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}s:6:\"assist\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}s:7:\"catalog\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}s:9:\"component\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}s:8:\"solution\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}s:6:\"groups\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}s:4:\"news\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}s:5:\"setup\";a:3:{i:0;s:4:\"view\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}}', '1'), ('2', '编辑', 'a:2:{s:6:\"assist\";a:2:{i:0;s:4:\"view\";i:1;s:4:\"edit\";}s:4:\"news\";a:2:{i:0;s:4:\"view\";i:1;s:4:\"edit\";}}', '1');
COMMIT;

-- ----------------------------
--  Table structure for `qd_seo`
-- ----------------------------
DROP TABLE IF EXISTS `qd_seo`;
CREATE TABLE `qd_seo` (
  `caller` enum('assist','article','catalog','crowdfunding','institution','source') NOT NULL,
  `caller_id` int(10) unsigned NOT NULL COMMENT 'ID',
  `title` varchar(128) NOT NULL COMMENT 'SEO标题',
  `keywords` varchar(255) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(255) DEFAULT '' COMMENT 'SEO描述',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`caller`,`caller_id`),
  KEY `fk_addtime` (`addtime`),
  KEY `fk_uptime` (`uptime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `qd_seo`
-- ----------------------------
BEGIN;
INSERT INTO `qd_seo` VALUES ('assist', '1', '关于我们', '勤道CMS,勤道开发框架', '勤道CMS', '1453131908', '2016-01-18 23:45:31'), ('article', '1', '勤道基础开发框架开源', '勤道,php,开发框架', '勤道基础开发框架开源', '1453026994', '2016-01-17 18:36:34'), ('article', '2', '测试啦', '测试', '测试', '1452620006', '2016-01-13 01:33:26');
COMMIT;

-- ----------------------------
--  Table structure for `qd_setup`
-- ----------------------------
DROP TABLE IF EXISTS `qd_setup`;
CREATE TABLE `qd_setup` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `item` char(32) NOT NULL COMMENT '项目',
  `alias` char(32) NOT NULL COMMENT '别名',
  `content` varchar(255) DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='系统';

-- ----------------------------
--  Records of `qd_setup`
-- ----------------------------
BEGIN;
INSERT INTO `qd_setup` VALUES ('1', '网站标题', 'title', '网页配色 - 一键查询网页前端CSS、JS技术架构与配色方案 - 云配色'), ('2', '网站关键词', 'keywords', '网页设计,网页配色,配色方案,配色软件,配色表,配色卡,配色宝典,配色设计原理,WEB流行色,网站配色,前端配色,网页设计,网页制作,网站前端架构,css框架,js框架,jquery插件'), ('3', '网站描述', 'description', '索引 10000+ 网页配色方案与前端架构,网页配色,网站配色,配色工具,配色软件,配色表,配色方案,配色表,配色卡,设计配色表,配色方案大全,WEB流行色,css,js,jquery,网页设计,网页制作,前端架构,前端技术,jquery插件,css框架');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
