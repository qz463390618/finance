/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : finance

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-12-01 18:05:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zwf_admin_class
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_class`;
CREATE TABLE `zwf_admin_class` (
  `class_id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `class_name` char(30) NOT NULL COMMENT '分类名',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `class_name` (`class_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of zwf_admin_class
-- ----------------------------
INSERT INTO `zwf_admin_class` VALUES ('2', '新闻', '2017-11-30 14:11:26', '2017-11-30 14:11:26');

-- ----------------------------
-- Table structure for zwf_admin_column
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_column`;
CREATE TABLE `zwf_admin_column` (
  `column_id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '栏目id',
  `column_name` char(50) NOT NULL COMMENT '栏目名',
  `column_pid` tinyint(3) NOT NULL COMMENT '父级id',
  `column_path` varchar(255) NOT NULL COMMENT '全部路径',
  `column_filename` varchar(50) NOT NULL COMMENT '文件名,完整连接是父级完整连接/文件名',
  `column_chaining` varchar(50) NOT NULL COMMENT '完整链接',
  `column_display` tinyint(1) unsigned DEFAULT '2' COMMENT '控制显示和隐藏 1:显示 2:隐藏',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`column_id`),
  UNIQUE KEY `column_name` (`column_name`),
  UNIQUE KEY `column_filename` (`column_filename`),
  UNIQUE KEY `column_chaining` (`column_chaining`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='栏目表';

-- ----------------------------
-- Records of zwf_admin_column
-- ----------------------------
INSERT INTO `zwf_admin_column` VALUES ('1', '关于我们', '0', '0,', 'related', '/related', '1', '2017-11-29 13:39:17', '2017-11-30 09:20:42');
INSERT INTO `zwf_admin_column` VALUES ('3', '中心简介', '1', '0,1', 'profile', '/related/profile', '1', '2017-11-30 10:10:45', '2017-11-30 10:10:45');
INSERT INTO `zwf_admin_column` VALUES ('4', '信息中心', '0', '0,', 'information', '/information', '1', '2017-11-30 15:13:19', '2017-11-30 15:13:19');
INSERT INTO `zwf_admin_column` VALUES ('5', '中心公告', '4', '0,4', 'announcement', '/information/announcement', '1', '2017-11-30 15:13:39', '2017-11-30 15:13:39');
INSERT INTO `zwf_admin_column` VALUES ('6', '中心动态', '4', '0,4', 'dynamics', '/information/dynamics', '1', '2017-11-30 15:14:06', '2017-11-30 15:14:06');
INSERT INTO `zwf_admin_column` VALUES ('7', '资讯要闻', '4', '0,4', 'impnews', '/information/impnews', '1', '2017-11-30 15:23:46', '2017-11-30 15:23:46');
INSERT INTO `zwf_admin_column` VALUES ('8', '投资者教育', '0', '0,', 'education', '/education', '1', '2017-11-30 15:24:43', '2017-11-30 15:24:43');
INSERT INTO `zwf_admin_column` VALUES ('9', '法律法规', '8', '0,8', 'law', '/education/law', '1', '2017-11-30 15:25:13', '2017-11-30 15:25:13');
INSERT INTO `zwf_admin_column` VALUES ('10', '业务规范', '8', '0,8', 'business', '/education/business', '1', '2017-11-30 15:25:46', '2017-11-30 15:25:46');
INSERT INTO `zwf_admin_column` VALUES ('11', '风险管理与防范', '8', '0,8', 'risk', '/education/risk', '1', '2017-11-30 15:26:27', '2017-11-30 15:26:27');
INSERT INTO `zwf_admin_column` VALUES ('12', '投资者权益保护', '8', '0,8', 'equity', '/education/equity', '1', '2017-11-30 15:27:04', '2017-11-30 15:27:04');
INSERT INTO `zwf_admin_column` VALUES ('13', '产品知识', '8', '0,8', 'knowledge', '/education/knowledge', '1', '2017-11-30 15:27:30', '2017-11-30 15:27:30');
INSERT INTO `zwf_admin_column` VALUES ('14', '常见问题', '8', '0,8', 'question', '/education/question', '1', '2017-11-30 15:28:07', '2017-11-30 15:28:07');
INSERT INTO `zwf_admin_column` VALUES ('15', '联系我们', '0', '0,', 'contact', '/contact', '1', '2017-11-30 15:47:35', '2017-11-30 15:47:35');
INSERT INTO `zwf_admin_column` VALUES ('16', '职位招聘', '15', '0,15', 'recruit', '/contact/recruit', '1', '2017-11-30 15:48:04', '2017-11-30 15:48:04');

-- ----------------------------
-- Table structure for zwf_admin_information
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_information`;
CREATE TABLE `zwf_admin_information` (
  `news_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '新闻id',
  `class_id` smallint(5) NOT NULL COMMENT '分类id',
  `column_id` tinyint(3) NOT NULL COMMENT '栏目id',
  `onclick` int(10) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `titlepic` char(120) NOT NULL COMMENT '封面图片',
  `smalltext` char(255) NOT NULL COMMENT '简介',
  `truetime` int(10) NOT NULL COMMENT '创建时间',
  `lastdotime` int(10) NOT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='信息中心 文章';

-- ----------------------------
-- Records of zwf_admin_information
-- ----------------------------

-- ----------------------------
-- Table structure for zwf_admin_information_data
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_information_data`;
CREATE TABLE `zwf_admin_information_data` (
  `news_id` int(10) NOT NULL COMMENT '新闻id',
  `class_id` smallint(5) NOT NULL COMMENT '分类id',
  `writer` varchar(30) DEFAULT NULL COMMENT '作者',
  `befrom` varchar(60) DEFAULT NULL COMMENT '来源',
  `newstext` mediumtext NOT NULL COMMENT '文章内容',
  `seotext` text COMMENT '文章描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='信息中心 文章内容';

-- ----------------------------
-- Records of zwf_admin_information_data
-- ----------------------------

-- ----------------------------
-- Table structure for zwf_admin_rights
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_rights`;
CREATE TABLE `zwf_admin_rights` (
  `rights_id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `rights_name` char(20) NOT NULL COMMENT '权限名',
  `rights_mark` char(50) NOT NULL COMMENT '权限标志,路由',
  PRIMARY KEY (`rights_id`),
  UNIQUE KEY `rights_name` (`rights_name`),
  UNIQUE KEY `rights_mark` (`rights_mark`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of zwf_admin_rights
-- ----------------------------
INSERT INTO `zwf_admin_rights` VALUES ('1', '用户管理', '/admin/rbac/user');
INSERT INTO `zwf_admin_rights` VALUES ('2', '权限管理', '/admin/rbac/rights');
INSERT INTO `zwf_admin_rights` VALUES ('3', '超级管理', '*');
INSERT INTO `zwf_admin_rights` VALUES ('4', '角色管理', '/admin/rbac/role');
INSERT INTO `zwf_admin_rights` VALUES ('5', '栏目管理', '/admin/column');

-- ----------------------------
-- Table structure for zwf_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_role`;
CREATE TABLE `zwf_admin_role` (
  `role_id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` char(30) NOT NULL COMMENT '角色名',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of zwf_admin_role
-- ----------------------------
INSERT INTO `zwf_admin_role` VALUES ('4', '作者');
INSERT INTO `zwf_admin_role` VALUES ('2', '权限管理员');
INSERT INTO `zwf_admin_role` VALUES ('3', '用户管理员');
INSERT INTO `zwf_admin_role` VALUES ('1', '超级管理员');

-- ----------------------------
-- Table structure for zwf_admin_role_rights
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_role_rights`;
CREATE TABLE `zwf_admin_role_rights` (
  `role_id` char(3) NOT NULL COMMENT '角色id',
  `rights_id` char(3) NOT NULL COMMENT '权限id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Records of zwf_admin_role_rights
-- ----------------------------
INSERT INTO `zwf_admin_role_rights` VALUES ('1', '3');
INSERT INTO `zwf_admin_role_rights` VALUES ('2', '2');
INSERT INTO `zwf_admin_role_rights` VALUES ('2', '1');
INSERT INTO `zwf_admin_role_rights` VALUES ('2', '4');
INSERT INTO `zwf_admin_role_rights` VALUES ('3', '1');

-- ----------------------------
-- Table structure for zwf_admin_users
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_users`;
CREATE TABLE `zwf_admin_users` (
  `user_id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_account` char(30) NOT NULL COMMENT '用户名',
  `user_pwd` char(60) NOT NULL COMMENT '用户密码',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_account` (`user_account`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of zwf_admin_users
-- ----------------------------
INSERT INTO `zwf_admin_users` VALUES ('1', '曾伟峰', '$2y$10$wuM9g60o3rH4.Ry6dT4Lu.vTA3UuZP0swlvxRcY.RYWCdtVWNyXcK');
INSERT INTO `zwf_admin_users` VALUES ('2', '张乐琼', '$2y$10$a5RbvrwBZkz05bCDQxjuHuFXJwYtpn2urzSxE4mxYad0IGIMlNuwG');

-- ----------------------------
-- Table structure for zwf_admin_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `zwf_admin_user_roles`;
CREATE TABLE `zwf_admin_user_roles` (
  `user_id` smallint(5) NOT NULL COMMENT '用户id',
  `role_id` tinyint(3) NOT NULL COMMENT '角色id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色表';

-- ----------------------------
-- Records of zwf_admin_user_roles
-- ----------------------------
INSERT INTO `zwf_admin_user_roles` VALUES ('1', '1');
