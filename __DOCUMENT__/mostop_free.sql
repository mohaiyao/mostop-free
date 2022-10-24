/*
 Navicat Premium Data Transfer

 Source Server         : 192.168.101.201
 Source Server Type    : MySQL
 Source Server Version : 50735
 Source Host           : 192.168.101.201:3306
 Source Schema         : mostop_free

 Target Server Type    : MySQL
 Target Server Version : 50735
 File Encoding         : 65001

 Date: 24/10/2022 16:39:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mostop_admin
-- ----------------------------
DROP TABLE IF EXISTS `mostop_admin`;
CREATE TABLE `mostop_admin`  (
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `name` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '性别，0 = 女，1 = 男',
  `birthday` date NULL DEFAULT NULL COMMENT '生日',
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `mobile` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `qq` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'QQ',
  `weixin` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信',
  `disabled` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '禁用，0 = 否，1 = 是',
  `created_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建来源用户 ID',
  `updated_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `updated_by` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新来源用户 ID',
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE COMMENT '排序查询',
  INDEX `name_created_at`(`name`, `created_at`) USING BTREE COMMENT '姓名查询',
  INDEX `disabled_created_at`(`disabled`, `created_at`) USING BTREE COMMENT '状态查询'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_admin
-- ----------------------------
INSERT INTO `mostop_admin` VALUES (1, '超级管理员', 1, '2019-01-01', '', '', '494686707@qq.com', '494686707', 'lensic_mo', 0, 1546272000, 0, 1546272000, 1);

-- ----------------------------
-- Table structure for mostop_admin_login_log
-- ----------------------------
DROP TABLE IF EXISTS `mostop_admin_login_log`;
CREATE TABLE `mostop_admin_login_log`  (
  `logid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志 ID',
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `ip` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IP',
  `succeed` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '成功， 0 = 否，1 = 是',
  `created_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`logid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE COMMENT '排序查询',
  INDEX `ip_created_at`(`ip`, `created_at`) USING BTREE COMMENT 'IP 地址日志',
  INDEX `userid_created_at`(`userid`, `created_at`) USING BTREE COMMENT '用户日志'
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_admin_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for mostop_admin_operate_log
-- ----------------------------
DROP TABLE IF EXISTS `mostop_admin_operate_log`;
CREATE TABLE `mostop_admin_operate_log`  (
  `logid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志 ID',
  `url` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '链接地址',
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `ip` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IP',
  `created_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`logid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE COMMENT '排序查询',
  INDEX `url_created_at`(`url`(255), `created_at`) USING BTREE COMMENT '链接查询',
  INDEX `userid_created_at`(`userid`, `created_at`) USING BTREE COMMENT '用户查询',
  INDEX `ip_created_at`(`ip`, `created_at`) USING BTREE COMMENT 'IP 地址查询'
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_admin_operate_log
-- ----------------------------

-- ----------------------------
-- Table structure for mostop_log
-- ----------------------------
DROP TABLE IF EXISTS `mostop_log`;
CREATE TABLE `mostop_log`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level` int(11) NULL DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `log_time` double NULL DEFAULT NULL,
  `prefix` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_log_level`(`level`) USING BTREE,
  INDEX `idx_log_category`(`category`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_log
-- ----------------------------

-- ----------------------------
-- Table structure for mostop_menu
-- ----------------------------
DROP TABLE IF EXISTS `mostop_menu`;
CREATE TABLE `mostop_menu`  (
  `menuid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单 ID',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级 ID',
  `parent_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所有父级 ID',
  `child_ids` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '所有子级 ID',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名',
  `controller` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '控制器',
  `action` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '方法',
  `enabled` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否启用，0 = 否，1 = 是',
  `is_show` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否显示，1 = 是，0 = 否',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`menuid`) USING BTREE,
  INDEX `sort`(`sort`) USING BTREE COMMENT '排序查询'
) ENGINE = InnoDB AUTO_INCREMENT = 150 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_menu
-- ----------------------------
INSERT INTO `mostop_menu` VALUES (1, 0, '', '2,3,4', '我的', '', '', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (2, 1, '1', '3,4', '我的信息', '', '', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (3, 2, '2,1', '', '个人资料', 'my', 'info', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (4, 2, '2,1', '', '修改密码', 'my', 'pwd', 1, 1, 10);
INSERT INTO `mostop_menu` VALUES (16, 0, '', '17,18,19,142,67,68', '工具', '', '', 1, 1, 20);
INSERT INTO `mostop_menu` VALUES (17, 16, '16', '18,19,142', '日志管理', '', '', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (18, 17, '17,16', '', '登录日志', 'tool', 'login-log', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (19, 17, '17,16', '', '操作日志', 'tool', 'operate-log', 1, 1, 10);
INSERT INTO `mostop_menu` VALUES (20, 0, '', '21,24,141,25,26,27,28,29,35,36,37,38,39,40,114', '设置', '', '', 1, 1, 30);
INSERT INTO `mostop_menu` VALUES (21, 20, '20', '24,141', '全局配置', '', '', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (24, 21, '21,20', '', '安全设置', 'setting', 'safe', 1, 1, 20);
INSERT INTO `mostop_menu` VALUES (25, 20, '20', '26,27,28,29', '权限设置', '', '', 1, 1, 10);
INSERT INTO `mostop_menu` VALUES (26, 25, '25,20', '27,28,29', '管理员', 'permission', 'admin', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (27, 26, '26,25,20', '', '添加管理员', 'permission', 'admin-add', 1, 0, 0);
INSERT INTO `mostop_menu` VALUES (28, 26, '26,25,20', '', '编辑管理员', 'permission', 'admin-edit', 1, 0, 10);
INSERT INTO `mostop_menu` VALUES (29, 26, '26,25,20', '', '删除管理员', 'permission', 'admin-del', 1, 0, 20);
INSERT INTO `mostop_menu` VALUES (35, 20, '20', '36,37,38,39,40,114', '菜单管理', '', '', 1, 1, 20);
INSERT INTO `mostop_menu` VALUES (36, 35, '35,20', '37,38,39,40,114', '菜单列表', 'menu', 'index', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (37, 36, '36,35,20', '', '添加菜单', 'menu', 'add', 1, 0, 0);
INSERT INTO `mostop_menu` VALUES (38, 36, '36,35,20', '', '编辑菜单', 'menu', 'edit', 1, 0, 10);
INSERT INTO `mostop_menu` VALUES (39, 36, '36,35,20', '', '删除菜单', 'menu', 'del', 1, 0, 20);
INSERT INTO `mostop_menu` VALUES (40, 36, '36,35,20', '', '获取子菜单数据', 'menu', 'get-sub-menu-data', 1, 0, 30);
INSERT INTO `mostop_menu` VALUES (58, 0, '', '59,60,61,63,64,62,65,75,66', '公共权限', '', '', 1, 0, 990);
INSERT INTO `mostop_menu` VALUES (59, 58, '58', '60,61,63,64,62,65', '基本权限', '', '', 1, 0, 0);
INSERT INTO `mostop_menu` VALUES (60, 59, '59,58', '', '后台登录', 'site', 'login', 1, 0, 0);
INSERT INTO `mostop_menu` VALUES (61, 59, '59,58', '', '获取验证码', 'site', 'captcha', 1, 0, 10);
INSERT INTO `mostop_menu` VALUES (62, 59, '59,58', '', '后台登出', 'site', 'logout', 1, 0, 40);
INSERT INTO `mostop_menu` VALUES (63, 59, '59,58', '', '后台框架页', 'site', 'index', 1, 0, 20);
INSERT INTO `mostop_menu` VALUES (64, 59, '59,58', '', '后台首页', 'site', 'home', 1, 0, 30);
INSERT INTO `mostop_menu` VALUES (65, 59, '59,58', '', '错误提示页', 'site', 'error', 1, 0, 50);
INSERT INTO `mostop_menu` VALUES (66, 75, '75,58', '', '文件上传', 'public', 'upload', 1, 0, 0);
INSERT INTO `mostop_menu` VALUES (67, 16, '16', '68', '其它工具', '', '', 1, 1, 10);
INSERT INTO `mostop_menu` VALUES (68, 67, '67,16', '', '更新缓存', 'tool', 'update-cache', 1, 1, 0);
INSERT INTO `mostop_menu` VALUES (75, 58, '58', '66', '高级权限', '', '', 1, 0, 10);
INSERT INTO `mostop_menu` VALUES (114, 36, '36,35,20', '', '修复菜单', 'menu', 'repair', 1, 0, 40);
INSERT INTO `mostop_menu` VALUES (141, 21, '21,20', '', '缓存设置', 'setting', 'cache', 1, 1, 30);
INSERT INTO `mostop_menu` VALUES (142, 17, '17,16', '', '系统日志', 'tool', 'log', 1, 1, 40);

-- ----------------------------
-- Table structure for mostop_migration
-- ----------------------------
DROP TABLE IF EXISTS `mostop_migration`;
CREATE TABLE `mostop_migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_migration
-- ----------------------------
INSERT INTO `mostop_migration` VALUES ('m000000_000000_base', 1516185367);
INSERT INTO `mostop_migration` VALUES ('m141106_185632_log_init', 1516185368);

-- ----------------------------
-- Table structure for mostop_setting
-- ----------------------------
DROP TABLE IF EXISTS `mostop_setting`;
CREATE TABLE `mostop_setting`  (
  `app` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '应用',
  `parameter` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参数名',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '参数值',
  PRIMARY KEY (`app`, `parameter`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_setting
-- ----------------------------
INSERT INTO `mostop_setting` VALUES ('backend', 'enable_delete_action', '1');
INSERT INTO `mostop_setting` VALUES ('backend', 'enable_operate_log', '0');
INSERT INTO `mostop_setting` VALUES ('backend', 'enable_upload_file', '1');
INSERT INTO `mostop_setting` VALUES ('system', 'cache_time', '86400');

-- ----------------------------
-- Table structure for mostop_user
-- ----------------------------
DROP TABLE IF EXISTS `mostop_user`;
CREATE TABLE `mostop_user`  (
  `userid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户 ID',
  `username` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `created_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE COMMENT '排序查询',
  INDEX `username_created_at`(`username`, `created_at`) USING BTREE COMMENT '用户名查询排序'
) ENGINE = InnoDB AUTO_INCREMENT = 10000 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户总表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_user
-- ----------------------------
INSERT INTO `mostop_user` VALUES (1, 'admin', 1546272000, 1559197925);

-- ----------------------------
-- Table structure for mostop_user_0
-- ----------------------------
DROP TABLE IF EXISTS `mostop_user_0`;
CREATE TABLE `mostop_user_0`  (
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `username` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `salt` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '辅助密码',
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `username`(`username`) USING BTREE COMMENT '用户名查询'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户分表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_user_0
-- ----------------------------

-- ----------------------------
-- Table structure for mostop_user_1
-- ----------------------------
DROP TABLE IF EXISTS `mostop_user_1`;
CREATE TABLE `mostop_user_1`  (
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `username` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `salt` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '辅助密码',
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `username`(`username`) USING BTREE COMMENT '用户名查询'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户分表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_user_1
-- ----------------------------

-- ----------------------------
-- Table structure for mostop_user_2
-- ----------------------------
DROP TABLE IF EXISTS `mostop_user_2`;
CREATE TABLE `mostop_user_2`  (
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `username` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `salt` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '辅助密码',
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `username`(`username`) USING BTREE COMMENT '用户名查询'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户分表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_user_2
-- ----------------------------
INSERT INTO `mostop_user_2` VALUES (1, 'admin', 'de52203f07e1a410a03b198ec1424f5f', '6vc4xU');

-- ----------------------------
-- Table structure for mostop_user_3
-- ----------------------------
DROP TABLE IF EXISTS `mostop_user_3`;
CREATE TABLE `mostop_user_3`  (
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `username` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `salt` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '辅助密码',
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `username`(`username`) USING BTREE COMMENT '用户名查询'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户分表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_user_3
-- ----------------------------

-- ----------------------------
-- Table structure for mostop_user_4
-- ----------------------------
DROP TABLE IF EXISTS `mostop_user_4`;
CREATE TABLE `mostop_user_4`  (
  `userid` int(10) UNSIGNED NOT NULL COMMENT '用户 ID',
  `username` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `salt` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '辅助密码',
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `username`(`username`) USING BTREE COMMENT '用户名查询'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户分表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mostop_user_4
-- ----------------------------

-- ----------------------------
-- Procedure structure for process_cycle_content_insert
-- ----------------------------
DROP PROCEDURE IF EXISTS `process_cycle_content_insert`;
delimiter ;;
CREATE PROCEDURE `process_cycle_content_insert`()
BEGIN
	DECLARE i INT DEFAULT 10001;
	WHILE i <= 11000
	DO

	INSERT INTO `mostop`.`mostop_content` (
	`catid`,
	`modelid`,
	`title`,
	`subtitle`,
	`thumb`,
	`sourceid`,
	`allow_comment`,
	`comments`,
	`pv`,
	`seo_title`,
	`seo_description`,
	`url`,
	`status`,
	`created_at`,
	`created_by`,
	`published_at`,
	`published_by`,
	`unpublished_at`,
	`unpublished_by`,
	`updated_at`,
	`updated_by`
)
VALUES
	(
		FLOOR(1 + (RAND() * 3)),
		FLOOR(1 + (RAND() * 2)),
		CONCAT('标题', i),
		CONCAT('副标题', i),
		NULL,
		NULL,
		'1',
		'0',
		'0',
		CONCAT('SEO 标题', i),
		CONCAT('SEO 描述', i),
		NULL,
		FLOOR(0 + (RAND() * 5)),
		unix_timestamp(now()) + FLOOR(1 + (RAND() * 200000)),
		FLOOR(1 + (RAND() * 3)),
		unix_timestamp(now()) + FLOOR(1 + (RAND() * 200000)),
		FLOOR(1 + (RAND() * 3)),
		unix_timestamp(now()) + FLOOR(1 + (RAND() * 200000)),
		FLOOR(1 + (RAND() * 3)),
		unix_timestamp(now()) + FLOOR(1 + (RAND() * 200000)),
		FLOOR(1 + (RAND() * 3))
	);

	SET i = i + 1;
	END WHILE;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
