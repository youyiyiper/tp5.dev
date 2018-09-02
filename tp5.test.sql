/*
Navicat MySQL Data Transfer

Source Server         : localhost_phpstudy_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tp5.test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-09-01 18:30:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_admins
-- ----------------------------
DROP TABLE IF EXISTS `tp_admins`;
CREATE TABLE `tp_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名称',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '角色状态:1可用 0不可用',
  `headimg` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户头像',
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户邮箱',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户密码',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='系统管理员';

-- ----------------------------
-- Records of tp_admins
-- ----------------------------
INSERT INTO `tp_admins` VALUES ('1', '王小五', '1', '/uploads/20180529/cropped-ca80cea99cd5f0fb9aefa483544bdb9d.png', '673726312@qq.com', '501a3971e22fce0afa79bd66fc2ad7d3', null, '2018-09-01 15:29:29', '1');
INSERT INTO `tp_admins` VALUES ('3', '赵小六', '1', '/uploads/20180407/cropped-fa5b853fd0f740f36492957fbc9943b0.jpg', '815174623@qq.com', '501a3971e22fce0afa79bd66fc2ad7d3', '2018-04-07 15:49:30', '2018-05-29 23:23:55', '1');

-- ----------------------------
-- Table structure for tp_article
-- ----------------------------
DROP TABLE IF EXISTS `tp_article`;
CREATE TABLE `tp_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章内容',
  `desc` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文章描述',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶，1置顶，0不置顶',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：1正，-1删除，0待发布',
  `published_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_title_unique` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tp_article
-- ----------------------------

-- ----------------------------
-- Table structure for tp_configs
-- ----------------------------
DROP TABLE IF EXISTS `tp_configs`;
CREATE TABLE `tp_configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '配置标识',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '配置名称',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='系统配置表';

-- ----------------------------
-- Records of tp_configs
-- ----------------------------
INSERT INTO `tp_configs` VALUES ('3', 'system', '系统设置', '系统设置', '2018-05-21 22:57:28', '2018-05-20 15:00:07');
INSERT INTO `tp_configs` VALUES ('5', 'role', '角色管理', '角色管理', '2018-05-21 22:57:28', '2018-05-20 15:01:10');
INSERT INTO `tp_configs` VALUES ('6', 'sidebar', '菜单管理', '菜单管理', '2018-05-21 22:57:28', '2018-05-20 15:01:34');
INSERT INTO `tp_configs` VALUES ('7', 'privilege', '权限管理', '权限管理', '2018-05-21 22:57:28', '2018-05-20 15:02:09');
INSERT INTO `tp_configs` VALUES ('8', 'manage', '系统管理', '系统管理', '2018-05-29 23:32:14', '2018-05-29 23:32:14');

-- ----------------------------
-- Table structure for tp_email_valid
-- ----------------------------
DROP TABLE IF EXISTS `tp_email_valid`;
CREATE TABLE `tp_email_valid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户邮箱',
  `validcode` char(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮箱验证code',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `out_time` int(10) unsigned NOT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='邮箱验证';

-- ----------------------------
-- Records of tp_email_valid
-- ----------------------------
INSERT INTO `tp_email_valid` VALUES ('3', '673726312@qq.com', 'b7d8e5309a0101bed445cc088d8c145e', '2018-09-01 10:52:43', '2018-09-01 10:52:43', '1535770963');
INSERT INTO `tp_email_valid` VALUES ('4', '673726312@qq.com', 'd7a9d4f92bb5788d44742855411334b9', '2018-09-01 11:36:25', '2018-09-01 11:36:25', '1535773585');

-- ----------------------------
-- Table structure for tp_privileges
-- ----------------------------
DROP TABLE IF EXISTS `tp_privileges`;
CREATE TABLE `tp_privileges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类id',
  `is_menu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否菜单显示',
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限名称',
  `flag` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限标识',
  `desc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限描述',
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单使用的icon',
  `url` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '菜单访问的地址',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `privileges_flag_unique` (`flag`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限表';

-- ----------------------------
-- Records of tp_privileges
-- ----------------------------
INSERT INTO `tp_privileges` VALUES ('1', '0', '1', '系统设置', 'CCCCCC', 'CCCCCC', '', '', '2018-05-20 17:36:02', '2018-05-19 22:06:23');
INSERT INTO `tp_privileges` VALUES ('2', '1', '1', '管理员管理', 'ccc', 'ccc', '', 'admin/admin/', '2018-05-20 17:35:49', '2018-05-19 20:13:34');
INSERT INTO `tp_privileges` VALUES ('3', '1', '1', '角色管理', 'ddd', 'ddd', '', 'admin/role/', '2018-05-20 17:35:49', '2018-05-19 20:17:27');
INSERT INTO `tp_privileges` VALUES ('4', '1', '1', '配置管理', 'bbb', 'bbb', '', 'admin/config/', '2018-05-21 22:24:04', '2018-05-19 20:18:34');
INSERT INTO `tp_privileges` VALUES ('5', '1', '1', '权限管理', 'eee', 'eee', '', 'admin/privilege/', '2018-05-20 17:35:49', '2018-05-19 20:19:35');

-- ----------------------------
-- Table structure for tp_roles
-- ----------------------------
DROP TABLE IF EXISTS `tp_roles`;
CREATE TABLE `tp_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `desc` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '角色状态:1可用0不可用',
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色规则,保存的是权限的id,多个逗号分割',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色表';

-- ----------------------------
-- Records of tp_roles
-- ----------------------------
INSERT INTO `tp_roles` VALUES ('1', '超级管理员', '超级管理员1', '1', '1,2,6,3,7,4,9,5,8', '2018-04-07 14:58:13', '2018-05-20 14:44:24');
INSERT INTO `tp_roles` VALUES ('3', '爱爱爱', '爱爱爱', '1', '1,2,3,7,4,9,5,8', '2018-05-20 14:46:45', '2018-05-29 23:29:19');
