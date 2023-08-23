/*
 Navicat Premium Data Transfer

 Source Server         : eTutorKK
 Source Server Type    : MySQL
 Source Server Version : 50531 (5.5.31-log)
 Source Host           : localhost:3306
 Source Schema         : iddrives_tutor

 Target Server Type    : MySQL
 Target Server Version : 50531 (5.5.31-log)
 File Encoding         : 65001

 Date: 23/08/2023 21:50:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for exam_cach
-- ----------------------------
DROP TABLE IF EXISTS `exam_cach`;
CREATE TABLE `exam_cach`  (
  `cach_id` int(11) NOT NULL AUTO_INCREMENT,
  `number_exam` int(11) NOT NULL COMMENT 'ข้อที่เท่าไร',
  `question_id` int(11) NOT NULL COMMENT 'อ้างอิง question_id',
  `choice_id` int(11) NOT NULL COMMENT 'อ้างอิง choice_id',
  `score` int(2) NOT NULL,
  `user_id` int(15) NOT NULL COMMENT 'อ้างถึง Username ในตาราง User_member_group',
  `type_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL COMMENT 'รหัสโรงเรียน',
  `success_ex` int(1) NOT NULL DEFAULT 0 COMMENT '1 =ทำข้อสอบแล้ว 0 คือยังไม่ทำ',
  PRIMARY KEY (`cach_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1551 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for exam_choice
-- ----------------------------
DROP TABLE IF EXISTS `exam_choice`;
CREATE TABLE `exam_choice`  (
  `choice_id` int(11) NOT NULL AUTO_INCREMENT,
  `choice_order` int(11) NOT NULL,
  `choice_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `choice_sound` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เสียงของตัวเลือก',
  `reference` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ใช้อ้างอิงโจทย์และคำถาม',
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`choice_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48909 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for exam_permission
-- ----------------------------
DROP TABLE IF EXISTS `exam_permission`;
CREATE TABLE `exam_permission`  (
  `epm_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT 'exam_type',
  `user_code` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'user_member_group',
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`epm_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1441 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for exam_question
-- ----------------------------
DROP TABLE IF EXISTS `exam_question`;
CREATE TABLE `exam_question`  (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เนื้อหาข้อสอบ',
  `question_sound` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เสียงข้อสอบ',
  `answer` int(11) NOT NULL,
  `reference` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ใช้อ้างอิงโจทย์และคำถาม',
  `random_status` int(1) NOT NULL COMMENT 'กำหนดสถานะว่าจะให้สุ่มตัวเลือกหรือไม่',
  `type_choice` int(1) NOT NULL COMMENT 'ประเภทตัวเลือก 1=กขคง,2=ABCD',
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11761 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for exam_status_score
-- ----------------------------
DROP TABLE IF EXISTS `exam_status_score`;
CREATE TABLE `exam_status_score`  (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `score_total` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score_date` datetime NOT NULL,
  `type_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL COMMENT 'รหัสโรงเรียน',
  PRIMARY KEY (`score_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for exam_time
-- ----------------------------
DROP TABLE IF EXISTS `exam_time`;
CREATE TABLE `exam_time`  (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_time` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`ex_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for exam_type
-- ----------------------------
DROP TABLE IF EXISTS `exam_type`;
CREATE TABLE `exam_type`  (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type_detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type_pic` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type_date` date NOT NULL,
  `type_status` int(1) NOT NULL COMMENT 'สถานะเปิดปิด',
  `language_id` int(11) NOT NULL COMMENT 'tbl_exam_language',
  `type_group_id` int(11) NOT NULL COMMENT 'tbl_vehicle_type',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for tbl_exam_language
-- ----------------------------
DROP TABLE IF EXISTS `tbl_exam_language`;
CREATE TABLE `tbl_exam_language`  (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `language_code` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `language_img` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`language_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ตารางภาษาที่ใช้ในการสอบ คัดลอกจาก em' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for tbl_master_titlename
-- ----------------------------
DROP TABLE IF EXISTS `tbl_master_titlename`;
CREATE TABLE `tbl_master_titlename`  (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `title_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'คำนำหน้าชื่อ',
  `language_id` int(11) NOT NULL COMMENT 'tbl_exam_language',
  `title_status` int(1) NOT NULL COMMENT 'เปิด-ปิดใช้งาน',
  PRIMARY KEY (`title_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ตารางข้อมูลตั้งต้นคำนำหน้าชื่อ' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for tbl_permission_course
-- ----------------------------
DROP TABLE IF EXISTS `tbl_permission_course`;
CREATE TABLE `tbl_permission_course`  (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT 'หลักสูตร,ประเภทข้อสอบ',
  `compair_course` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'อ้างอิงโรงเรียนและหลักสูตรเข้าด้วยกัน',
  PRIMARY KEY (`permission_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1690 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for tbl_school
-- ----------------------------
DROP TABLE IF EXISTS `tbl_school`;
CREATE TABLE `tbl_school`  (
  `school_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `school_path_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number_student` int(6) NOT NULL COMMENT 'จำนวนนักเรียนที่อยู่ในโรงเรียน',
  `v_program` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Version โปรแกรม',
  `comment_update` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชี้แจงโปรแกรมอัพเดท',
  `day_create` date NOT NULL COMMENT 'วันที่สร้าง',
  `day_update` date NOT NULL COMMENT 'วันที่ปรับปรุง',
  `compair_course` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'อ้างอิงโรงเรียนและหลักสูตรเข้าด้วยกัน',
  `school_code` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `school_fanpage` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `school_fanpage_text` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ข้อความเชิญชวน',
  `language_id` int(11) NOT NULL DEFAULT 1 COMMENT 'tbl_exam_language',
  PRIMARY KEY (`school_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 61 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for tbl_system_language
-- ----------------------------
DROP TABLE IF EXISTS `tbl_system_language`;
CREATE TABLE `tbl_system_language`  (
  `stlg_id` int(11) NOT NULL AUTO_INCREMENT,
  `stlg_text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อเมนู',
  `stlg_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `language_id` int(11) NOT NULL COMMENT 'tbl_exam_language',
  PRIMARY KEY (`stlg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 409 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for tbl_vehicle_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vehicle_type`;
CREATE TABLE `tbl_vehicle_type`  (
  `vt_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_group_id` int(11) NOT NULL,
  `type_group_name` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`vt_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for user_member_group
-- ----------------------------
DROP TABLE IF EXISTS `user_member_group`;
CREATE TABLE `user_member_group`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_password_2` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_prefix` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_firstname` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_lastname` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id_card` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสบัตรประชาชน',
  `user_tel` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_email` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_img` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_date` int(1) NOT NULL COMMENT 'จำนวนวันหมดอายุ',
  `user_date_start` date NOT NULL COMMENT 'วันที่ลงทะเบียน',
  `user_date_end` date NOT NULL COMMENT 'วันหมดอายุ',
  `user_testing_date` date NOT NULL COMMENT 'วันที่สอบจริง',
  `user_date_status` int(1) NOT NULL COMMENT '0=หมดอายุ,1=ยังไม่หมดอายุ,2=ปิดการใช้งาน / ลบ',
  `school_id` int(11) NOT NULL COMMENT 'รหัสโรงเรียน',
  `user_status` int(1) NOT NULL COMMENT 'แบ่งสถานะ User 0=ไม่มี,1=admin,2=ผู้เข้าสอบ,3=Admin',
  `user_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 481 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

SET FOREIGN_KEY_CHECKS = 1;
