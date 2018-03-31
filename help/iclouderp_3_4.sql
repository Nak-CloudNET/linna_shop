/*
Navicat MySQL Data Transfer

Source Server         : CloudNET
Source Server Version : 50626
Source Host           : 127.0.0.1:3306
Source Database       : iclouderp_3_4

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2017-06-05 11:54:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for erp_account_settings
-- ----------------------------
DROP TABLE IF EXISTS `erp_account_settings`;
CREATE TABLE `erp_account_settings` (
  `id` int(1) NOT NULL,
  `biller_id` int(11) NOT NULL DEFAULT '0',
  `default_open_balance` varchar(20) DEFAULT NULL,
  `default_sale` varchar(20) DEFAULT 'yes',
  `default_sale_discount` varchar(20) DEFAULT NULL,
  `default_sale_tax` varchar(20) DEFAULT NULL,
  `default_sale_freight` varchar(20) DEFAULT NULL,
  `default_sale_deposit` varchar(20) DEFAULT NULL,
  `default_receivable` varchar(20) DEFAULT NULL,
  `default_purchase` varchar(20) DEFAULT NULL,
  `default_purchase_discount` varchar(20) DEFAULT NULL,
  `default_purchase_tax` varchar(20) DEFAULT NULL,
  `default_purchase_freight` varchar(20) DEFAULT NULL,
  `default_purchase_deposit` varchar(20) DEFAULT NULL,
  `default_payable` varchar(20) DEFAULT NULL,
  `default_stock` varchar(20) DEFAULT NULL,
  `default_stock_adjust` varchar(20) DEFAULT NULL,
  `default_cost` varchar(20) DEFAULT NULL,
  `default_payroll` varchar(20) DEFAULT NULL,
  `default_cash` varchar(20) DEFAULT NULL,
  `default_credit_card` varchar(20) DEFAULT NULL,
  `default_gift_card` varchar(20) DEFAULT NULL,
  `default_cheque` varchar(20) DEFAULT NULL,
  `default_loan` varchar(20) DEFAULT NULL,
  `default_retained_earnings` varchar(20) DEFAULT NULL,
  `default_cost_variant` varchar(20) DEFAULT NULL,
  `default_interest_income` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`,`biller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_account_settings
-- ----------------------------
INSERT INTO `erp_account_settings` VALUES ('1', '1', '300300', '410101', '410102', '201407', '601206', '201208', '100200', '100430', '500106', '100441', '601206', '100420', '201100', '100430', '500107', '500101', '201201', '100102', '100105', '201208', '100104', '100501', '300200', '500108', null);

-- ----------------------------
-- Table structure for erp_adjustments
-- ----------------------------
DROP TABLE IF EXISTS `erp_adjustments`;
CREATE TABLE `erp_adjustments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `cost` decimal(19,4) DEFAULT '0.0000',
  `total_cost` decimal(19,4) DEFAULT '0.0000',
  `biller_id` int(11) DEFAULT '0',
  `count_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_adjustments
-- ----------------------------

-- ----------------------------
-- Table structure for erp_bom
-- ----------------------------
DROP TABLE IF EXISTS `erp_bom`;
CREATE TABLE `erp_bom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noted` varchar(200) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_bom
-- ----------------------------

-- ----------------------------
-- Table structure for erp_bom_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_bom_items`;
CREATE TABLE `erp_bom_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bom_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` decimal(25,4) NOT NULL,
  `cost` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`bom_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_bom_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_brands
-- ----------------------------
DROP TABLE IF EXISTS `erp_brands`;
CREATE TABLE `erp_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_brands
-- ----------------------------

-- ----------------------------
-- Table structure for erp_calendar
-- ----------------------------
DROP TABLE IF EXISTS `erp_calendar`;
CREATE TABLE `erp_calendar` (
  `start` datetime NOT NULL,
  `title` varchar(55) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `end` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_calendar
-- ----------------------------

-- ----------------------------
-- Table structure for erp_captcha
-- ----------------------------
DROP TABLE IF EXISTS `erp_captcha`;
CREATE TABLE `erp_captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `word` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_captcha
-- ----------------------------

-- ----------------------------
-- Table structure for erp_categories
-- ----------------------------
DROP TABLE IF EXISTS `erp_categories`;
CREATE TABLE `erp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) DEFAULT NULL,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `image` varchar(55) DEFAULT NULL,
  `jobs` tinyint(1) unsigned DEFAULT '1',
  `auto_delivery` tinyint(1) DEFAULT NULL,
  `ac_sale` varchar(20) DEFAULT NULL,
  `ac_cost` varchar(20) DEFAULT NULL,
  `ac_stock` varchar(20) DEFAULT NULL,
  `ac_stock_adj` varchar(20) DEFAULT NULL,
  `ac_wip` varchar(20) DEFAULT NULL,
  `ac_cost_variant` varchar(20) DEFAULT NULL,
  `ac_purchase` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_categories
-- ----------------------------
INSERT INTO `erp_categories` VALUES ('1', null, 'CAT-0001', 'Drink', 'no_image.png', '1', null, '410101', '500000', '100430', '500107', null, '500108', '100430');
INSERT INTO `erp_categories` VALUES ('2', null, 'RG-001', 'Return Group', 'no_image.png', '1', null, '', '500000', '100430', '500107', null, '500108', '100430');
INSERT INTO `erp_categories` VALUES ('3', null, 'KD0001', 'G-Devith', null, '1', null, '', '', '', '', null, '', '');

-- ----------------------------
-- Table structure for erp_combine_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_combine_items`;
CREATE TABLE `erp_combine_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sale_deliveries_id` bigint(20) NOT NULL,
  `sale_deliveries_id_combine` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_combine_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_combo_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_combo_items`;
CREATE TABLE `erp_combo_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `quantity` decimal(12,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_combo_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_companies
-- ----------------------------
DROP TABLE IF EXISTS `erp_companies`;
CREATE TABLE `erp_companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `group_name` varchar(20) NOT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `customer_group_name` varchar(100) DEFAULT NULL,
  `price_group_id` int(11) DEFAULT NULL,
  `name` varchar(55) NOT NULL,
  `company` varchar(255) NOT NULL,
  `company_kh` varchar(255) DEFAULT NULL,
  `name_kh` varchar(255) DEFAULT NULL,
  `vat_no` varchar(100) DEFAULT NULL,
  `group_areas_id` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address_kh` varchar(255) DEFAULT NULL,
  `sale_man` int(11) DEFAULT NULL,
  `city` varchar(55) DEFAULT NULL,
  `state` varchar(55) DEFAULT NULL,
  `postal_code` varchar(8) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cf1` varchar(100) DEFAULT NULL,
  `cf2` varchar(100) DEFAULT NULL,
  `cf3` varchar(100) DEFAULT NULL,
  `cf4` varchar(100) DEFAULT NULL,
  `cf5` varchar(100) DEFAULT NULL,
  `cf6` varchar(100) DEFAULT NULL,
  `invoice_footer` text,
  `payment_term` int(11) DEFAULT '0',
  `logo` varchar(255) DEFAULT 'logo.png',
  `award_points` int(11) DEFAULT '0',
  `deposit_amount` decimal(25,4) DEFAULT NULL,
  `status` char(20) DEFAULT NULL,
  `posta_card` char(50) DEFAULT NULL,
  `gender` char(10) DEFAULT NULL,
  `attachment` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `credit_limited` decimal(25,4) DEFAULT NULL,
  `business_activity` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `village` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `sangkat` varchar(255) DEFAULT NULL,
  `district` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `period` varchar(100) DEFAULT NULL,
  `amount` decimal(25,4) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `group_id_2` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_companies
-- ----------------------------
INSERT INTO `erp_companies` VALUES ('1', 'COM1', null, 'biller', null, null, null, 'ABC Company', 'ABC Company', null, null, '12346756892', null, 'PP', null, null, 'phnom penh', '', '', 'Cambodia', 'owner', '012334345', 'iclouderp@gmail.com', '', '', '', '', '1', '', '', null, 'logo.png', '200', null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, '', '', '', '', '', '', null, null, null);
INSERT INTO `erp_companies` VALUES ('2', 'CUS01', '3', 'customer', '1', '', null, 'General Customer', 'General Customer', null, 'អតិថិជន', '22323452345', '0', 'PP', null, null, 'phnom penh', '', null, 'Cambodia', 'owner', '012334345', 'iclouderp@gmail.com', null, null, null, null, null, null, null, null, 'logo.png', '2626', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `erp_companies` VALUES ('3', 'SUP01', '4', 'supplier', null, '', null, 'General Supplier', 'General Supplier', null, null, '13241436245', null, 'pp', null, null, 'phnom penh', '', null, 'Cambodia', 'owner', '012334345', 'iclouderp@gmail.com', null, null, null, null, null, null, null, null, 'logo.png', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `erp_companies` VALUES ('4', '001', null, 'biller', null, null, null, 'RKS-Head Office', 'RKS-Head Office', null, null, '', null, 'Phnom Penh', null, null, '', '', '', '', 'RKS-Head Office', '', 'headoffice@gmail.com', '', '', '', '', '2,3', '', '', '0', '', '0', null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, '', '', '', '', '', '', null, null, null);
INSERT INTO `erp_companies` VALUES ('5', '004', null, 'biller', null, null, null, 'RKS-Ta Kmao', 'RKS-Ta Kmao', null, null, '', null, 'Ta Kmao', null, null, '', '', '', '', 'RKS-Ta Kmao', '', 'takmao@gmail.com', '', '', '', '', '4', '', '', '0', '', '0', null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, '', '', '', '', '', '', null, null, null);

-- ----------------------------
-- Table structure for erp_condition_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_condition_tax`;
CREATE TABLE `erp_condition_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(55) NOT NULL,
  `rate` decimal(12,4) NOT NULL,
  `min_salary` double(19,0) DEFAULT NULL,
  `max_salary` double(19,0) DEFAULT NULL,
  `reduct_tax` double(19,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_condition_tax
-- ----------------------------

-- ----------------------------
-- Table structure for erp_convert
-- ----------------------------
DROP TABLE IF EXISTS `erp_convert`;
CREATE TABLE `erp_convert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(55) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noted` varchar(200) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_convert
-- ----------------------------

-- ----------------------------
-- Table structure for erp_convert_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_convert_items`;
CREATE TABLE `erp_convert_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `convert_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` decimal(25,4) NOT NULL,
  `cost` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`convert_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_convert_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_costing
-- ----------------------------
DROP TABLE IF EXISTS `erp_costing`;
CREATE TABLE `erp_costing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_item_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `delivery_item_id` int(11) DEFAULT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `purchase_item_id` int(11) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `purchase_net_unit_cost` decimal(25,4) DEFAULT NULL,
  `purchase_unit_cost` decimal(25,4) DEFAULT NULL,
  `sale_net_unit_price` decimal(25,4) NOT NULL,
  `sale_unit_price` decimal(25,4) NOT NULL,
  `quantity_balance` decimal(15,4) DEFAULT NULL,
  `inventory` tinyint(1) DEFAULT '0',
  `overselling` tinyint(1) DEFAULT '0',
  `option_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_costing
-- ----------------------------
INSERT INTO `erp_costing` VALUES ('1', '2017-06-01', '2', '1', '1', null, null, '3', '1.0000', '2.5000', '2.5000', '3.5000', '3.5000', '9.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('2', '2017-06-01', '4', '5', '5', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('3', '2017-06-01', '4', '5', '5', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('4', '2017-06-01', '4', '6', '6', null, null, '10', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('5', '2017-06-01', '4', '6', '6', null, null, '9', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('6', '2017-06-01', '4', '7', '7', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('7', '2017-06-01', '4', '7', '7', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('8', '2017-06-01', '4', '8', '8', null, null, '2', '1.0000', '100.0000', '100.0000', '200.0000', '200.0000', '4.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('9', '2017-06-01', '4', '9', '9', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('10', '2017-06-01', '4', '9', '9', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('11', '2017-06-01', '4', '10', '10', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('12', '2017-06-01', '4', '10', '10', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('13', '2017-06-01', '4', '11', '11', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('14', '2017-06-01', '4', '11', '11', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('15', '2017-06-01', '4', '12', '12', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('16', '2017-06-01', '4', '12', '12', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('17', '2017-06-01', '4', '13', '13', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('18', '2017-06-01', '4', '13', '13', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('19', '2017-06-01', '4', '16', '16', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('20', '2017-06-01', '4', '16', '16', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('21', '2017-06-01', '4', '17', '17', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('22', '2017-06-01', '4', '17', '17', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('23', '2017-06-01', '4', '18', '18', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('24', '2017-06-01', '4', '18', '18', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('25', '2017-06-01', '4', '19', '19', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('26', '2017-06-01', '4', '19', '19', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('27', '2017-06-01', '4', '20', '20', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('28', '2017-06-01', '4', '20', '20', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('29', '2017-06-01', '4', '21', '21', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('30', '2017-06-01', '4', '21', '21', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('31', '2017-06-01', '4', '22', '22', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('32', '2017-06-01', '4', '22', '22', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('33', '2017-06-02', '4', '24', '24', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('34', '2017-06-02', '4', '24', '24', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('35', '2017-06-02', '4', '25', '25', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('36', '2017-06-02', '4', '25', '25', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('37', '2017-06-02', '4', '26', '26', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('38', '2017-06-02', '4', '26', '26', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('39', '2017-06-02', '4', '27', '27', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('40', '2017-06-02', '4', '27', '27', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('41', '2017-06-02', '5', '28', '28', null, null, '20', '0.0000', '20.0000', '20.0000', '22.0000', '22.0000', '50.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('42', '2017-06-02', '5', '29', '28', null, null, '20', '15.0000', '10.0000', '10.0000', '22.0000', '22.0000', '35.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('43', '2017-06-02', '4', '30', '29', null, null, null, '1.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('44', '2017-06-02', '1', '31', '29', null, null, null, '1.0000', '0.0000', '0.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('45', '2017-06-02', '1', '32', '30', null, null, null, '10.0000', '0.0000', '0.0000', '50.0000', '50.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('46', '2017-06-02', '4', '33', '31', null, null, null, '5.0000', '100.0000', '100.0000', '0.0000', '0.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('47', '2017-06-02', '5', '34', '31', null, null, '18', '5.0000', '20.0000', '20.0000', '0.0000', '0.0000', '45.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('48', '2017-06-02', '4', '35', '32', null, null, null, '5.0000', '100.0000', '100.0000', '0.0000', '0.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('49', '2017-06-02', '1', '36', '33', null, null, null, '1.0000', '0.0000', '0.0000', '30.0000', '30.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('50', '2017-06-02', '4', '37', '34', null, null, null, '1.0000', '100.0000', '100.0000', '12.0000', '12.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('51', '2017-06-02', '5', '38', '35', null, null, '18', '1.0000', '20.0000', '20.0000', '122.0000', '122.0000', '49.0000', '1', '0', '0');
INSERT INTO `erp_costing` VALUES ('52', '2017-06-02', '5', '39', '36', null, null, '18', '1.0000', '20.0000', '20.0000', '122.0000', '122.0000', '49.0000', '1', '0', '0');
INSERT INTO `erp_costing` VALUES ('53', '2017-06-02', '5', '40', '37', null, null, '18', '1.0000', '20.0000', '20.0000', '122.0000', '122.0000', '49.0000', '1', '0', '0');
INSERT INTO `erp_costing` VALUES ('54', '2017-06-02', '5', '41', '38', null, null, '18', '1.0000', '20.0000', '20.0000', '122.0000', '122.0000', '49.0000', '1', '0', '0');
INSERT INTO `erp_costing` VALUES ('55', '2017-06-02', '5', '42', '39', null, null, '18', '1.0000', '20.0000', '20.0000', '122.0000', '122.0000', '49.0000', '1', '0', '0');
INSERT INTO `erp_costing` VALUES ('56', '2017-06-02', '6', '43', '40', null, null, null, '2.0000', '0.0000', '0.0000', '5.0000', '5.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('57', '2017-06-02', '5', '44', '40', null, null, '18', '2.0000', '20.0000', '20.0000', '5.0000', '5.0000', '48.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('58', '2017-06-02', '4', '45', '41', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('59', '2017-06-02', '4', '45', '41', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('60', '2017-06-02', '4', '46', '42', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('61', '2017-06-02', '4', '46', '42', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('62', '2017-06-02', '4', '47', '43', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('63', '2017-06-02', '4', '47', '43', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('64', '2017-06-02', '4', '48', '44', null, null, '2', '4.0000', '100.0000', '100.0000', '15.0000', '15.0000', '1.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('65', '2017-06-02', '5', '49', '44', null, null, null, '5.0000', '20.0000', '20.0000', '12.0000', '12.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('66', '2017-06-02', '6', '50', '44', null, null, null, '5.0000', '0.0000', '0.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('67', '2017-06-02', '4', '51', '45', null, null, null, '4.0000', '100.0000', '100.0000', '15.0000', '15.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('68', '2017-06-02', '5', '52', '45', null, null, null, '5.0000', '20.0000', '20.0000', '12.0000', '12.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('69', '2017-06-02', '6', '53', '45', null, null, null, '5.0000', '0.0000', '0.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('70', '2017-06-02', '4', '54', '46', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('71', '2017-06-02', '4', '55', '47', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('72', '2017-06-02', '4', '55', '47', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('73', '2017-06-02', '4', '56', '48', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('74', '2017-06-02', '4', '56', '48', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('75', '2017-06-02', '5', '57', '49', null, null, null, '0.0000', '20.0000', '20.0000', '20.0000', '20.0000', '10.0000', '1', '1', null);
INSERT INTO `erp_costing` VALUES ('76', '2017-06-02', '5', '58', '49', null, null, null, '15.0000', '20.0000', '20.0000', '20.0000', '20.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('77', '2017-06-02', '4', '59', '50', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('78', '2017-06-02', '4', '59', '50', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('79', '2017-06-02', '4', '60', '51', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('80', '2017-06-02', '4', '60', '51', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('81', '2017-06-02', '4', '61', '52', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('82', '2017-06-02', '4', '61', '52', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('83', '2017-06-02', '4', '62', '53', null, null, '2', '5.0000', '100.0000', '100.0000', '200.0000', '200.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('84', '2017-06-02', '4', '62', '53', null, null, '1', '10.0000', '100.0000', '100.0000', '200.0000', '200.0000', '5.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('85', '2017-06-02', '2', '63', '54', null, null, '33', '10.0000', '61.0000', '61.0000', '20.0000', '20.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('86', '2017-06-02', '2', '63', '54', null, null, '33', '10.0000', '61.0000', '61.0000', '20.0000', '20.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('87', '2017-06-02', '2', '63', '54', null, null, '33', '10.0000', '61.0000', '61.0000', '20.0000', '20.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('88', '2017-06-02', '2', '63', '54', null, null, '33', '10.0000', '61.0000', '61.0000', '20.0000', '20.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('89', '2017-06-02', '2', '63', '54', null, null, '33', '10.0000', '61.0000', '61.0000', '20.0000', '20.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('90', '2017-06-02', '2', '63', '54', null, null, null, '15.0000', '3.4947', '3.4947', '20.0000', '20.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('91', '2017-06-02', '6', '64', '54', null, null, null, '5.0000', '0.0000', '0.0000', '20.0000', '20.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('92', '2017-06-03', '4', '65', '55', null, null, null, '10.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('93', '2017-06-03', '4', '66', '56', null, null, '2', '5.0000', '100.0000', '100.0000', '10.0000', '10.0000', '0.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('94', '2017-06-03', '4', '66', '56', null, null, '1', '6.0000', '100.0000', '100.0000', '10.0000', '10.0000', '9.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('95', '2017-06-03', '5', '67', '56', null, null, null, '5.0000', '20.0000', '20.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('96', '2017-06-03', '4', '68', '57', null, null, null, '1.0000', '100.0000', '100.0000', '5.0000', '5.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('97', '2017-06-03', '6', '69', '57', null, null, null, '1.0000', '0.0000', '0.0000', '5.0000', '5.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('98', '2017-06-03', '1', '70', '58', null, null, null, '5.0000', '0.0000', '0.0000', '9.0909', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('99', '2017-06-03', '4', '71', '58', null, null, null, '10.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('100', '2017-06-03', '4', '72', '61', null, null, null, '1.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('101', '2017-06-03', '5', '73', '61', null, null, null, '1.0000', '20.0000', '20.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('102', '2017-06-03', '1', '74', '62', null, null, null, '1.0000', '0.0000', '0.0000', '11.0000', '11.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('103', '2017-06-03', '4', '75', '62', null, null, null, '1.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('104', '2017-06-03', '4', '76', '63', null, null, null, '1.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('105', '2017-06-03', '4', '77', '64', null, null, null, '1.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('106', '2017-06-03', '1', '78', '65', null, null, null, '1.0000', '0.0000', '0.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('107', '2017-06-03', '1', '79', '67', null, null, null, '1.0000', '0.0000', '0.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('108', '2017-06-03', '4', '80', '67', null, null, null, '1.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('109', '2017-06-03', '4', '82', '68', null, null, null, '5.0000', '100.0000', '100.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('110', '2017-06-03', '5', '83', '69', null, null, '18', '2.0000', '20.0000', '20.0000', '10.0000', '10.0000', '48.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('111', '2017-06-03', '5', '84', '70', null, null, null, '2.0000', '20.0000', '20.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('112', '2017-06-03', '5', '85', '71', null, null, null, '2.0000', '20.0000', '20.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('113', '2017-06-03', '5', '86', '72', null, null, null, '2.0000', '20.0000', '20.0000', '10.0000', '10.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('114', '2017-06-03', '2', '0', null, '7', '5', '33', '2.0000', '75.6250', '75.6250', '3.5000', '3.5000', '8.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('115', '2017-06-03', '4', '0', null, '8', '5', null, '2.0000', '100.0000', '100.0000', '1.0000', '1.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('116', '2017-06-03', '5', '0', null, '9', '6', null, '4.0000', '20.0000', '20.0000', '20.0000', '20.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('117', '2017-06-03', '2', '0', null, '10', '7', null, '0.0000', '3.4947', '3.4947', '3.5000', '3.5000', '3.0000', '1', '1', null);
INSERT INTO `erp_costing` VALUES ('118', '2017-06-03', '4', '0', null, '11', '7', null, '0.0000', '100.0000', '100.0000', '1.0000', '1.0000', '3.0000', '1', '1', null);
INSERT INTO `erp_costing` VALUES ('119', '2017-06-03', '5', '0', null, '12', '8', null, '4.0000', '20.0000', '20.0000', '20.0000', '20.0000', null, '1', '1', null);
INSERT INTO `erp_costing` VALUES ('120', '2017-06-03', '2', '0', null, '13', '7', null, '0.0000', '3.4947', '3.4947', '3.5000', '3.5000', '3.0000', '1', '1', null);
INSERT INTO `erp_costing` VALUES ('121', '2017-06-03', '4', '0', null, '14', '7', null, '0.0000', '100.0000', '100.0000', '1.0000', '1.0000', '3.0000', '1', '1', null);
INSERT INTO `erp_costing` VALUES ('122', '2017-06-03', '9', '0', null, '17', '9', '110', '2.0000', '39.3333', '39.3333', '3.0000', '3.0000', '8.0000', '1', '0', null);
INSERT INTO `erp_costing` VALUES ('123', '2017-06-03', '2', '0', null, '18', '9', null, '2.0000', '3.4947', '3.4947', '3.5000', '3.5000', null, '1', '1', null);

-- ----------------------------
-- Table structure for erp_currencies
-- ----------------------------
DROP TABLE IF EXISTS `erp_currencies`;
CREATE TABLE `erp_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(55) NOT NULL,
  `in_out` tinyint(1) DEFAULT NULL,
  `rate` decimal(12,4) NOT NULL,
  `auto_update` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_currencies
-- ----------------------------
INSERT INTO `erp_currencies` VALUES ('1', 'USD', 'US Dollar', '1', '1.0000', '0');
INSERT INTO `erp_currencies` VALUES ('2', 'KHM', 'Riel In', '1', '4000.0000', '0');
INSERT INTO `erp_currencies` VALUES ('3', 'KHM_o', 'Riel Out', '0', '4050.0000', '0');

-- ----------------------------
-- Table structure for erp_customer_groups
-- ----------------------------
DROP TABLE IF EXISTS `erp_customer_groups`;
CREATE TABLE `erp_customer_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `percent` int(11) NOT NULL,
  `makeup_cost` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_customer_groups
-- ----------------------------
INSERT INTO `erp_customer_groups` VALUES ('1', 'General', '0', '0');
INSERT INTO `erp_customer_groups` VALUES ('2', 'Reseller', '-5', '0');
INSERT INTO `erp_customer_groups` VALUES ('3', 'Distributor', '-15', '0');
INSERT INTO `erp_customer_groups` VALUES ('4', 'New Customer (+10)', '10', '0');
INSERT INTO `erp_customer_groups` VALUES ('5', 'Makeup (+10)', '10', '1');

-- ----------------------------
-- Table structure for erp_date_format
-- ----------------------------
DROP TABLE IF EXISTS `erp_date_format`;
CREATE TABLE `erp_date_format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `js` varchar(20) NOT NULL,
  `php` varchar(20) NOT NULL,
  `sql` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_date_format
-- ----------------------------
INSERT INTO `erp_date_format` VALUES ('1', 'mm-dd-yyyy', 'm-d-Y', '%m-%d-%Y');
INSERT INTO `erp_date_format` VALUES ('2', 'mm/dd/yyyy', 'm/d/Y', '%m/%d/%Y');
INSERT INTO `erp_date_format` VALUES ('3', 'mm.dd.yyyy', 'm.d.Y', '%m.%d.%Y');
INSERT INTO `erp_date_format` VALUES ('4', 'dd-mm-yyyy', 'd-m-Y', '%d-%m-%Y');
INSERT INTO `erp_date_format` VALUES ('5', 'dd/mm/yyyy', 'd/m/Y', '%d/%m/%Y');
INSERT INTO `erp_date_format` VALUES ('6', 'dd.mm.yyyy', 'd.m.Y', '%d.%m.%Y');
INSERT INTO `erp_date_format` VALUES ('7', 'yyyy-mm-dd', 'Y-m-d', '%Y-%m-%d');

-- ----------------------------
-- Table structure for erp_deliveries
-- ----------------------------
DROP TABLE IF EXISTS `erp_deliveries`;
CREATE TABLE `erp_deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_id` int(11) NOT NULL,
  `do_reference_no` varchar(50) NOT NULL,
  `sale_reference_no` varchar(50) NOT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer` varchar(55) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total_cost` decimal(8,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_count` int(4) unsigned zerofill NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `delivery_by` int(11) DEFAULT NULL,
  `sale_status` varchar(50) DEFAULT NULL,
  `issued_sale_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_deliveries
-- ----------------------------
INSERT INTO `erp_deliveries` VALUES ('1', '2017-06-02 08:30:00', '25', 'DO/1706/00001', 'SALE/1706/00014', '1', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '1000.0000', '1', '1', null, '0001', 'invoice', 'pending', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('2', '2017-06-02 08:31:48', '23', 'DO/1706/00002', 'SALE/1706/00013', '4', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '500.0000', '3', null, null, '0000', 'invoice', 'pending', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('3', '2017-06-02 09:05:02', '28', 'DO/1706/00003', 'SALE/1706/00015', '5', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '100.0000', '1', null, null, '0000', 'invoice', 'pending', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('4', '2017-06-02 15:17:00', '49', 'DO/1706/00004', 'SALE/1706/00032', '1', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '100.0000', '1', '1', null, '0001', 'invoice', 'pending', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('5', '2017-06-03 11:48:20', '84', 'DO/1706/00005', 'SALE/1706/00050', '1', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '206.9894', '1', null, null, '0000', 'invoice', 'completed', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('6', '2017-06-03 11:49:08', '80', 'DO/1706/00006', 'SALE/1706/00048', '4', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '80.0000', '1', null, null, '0000', 'invoice', 'completed', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('7', '2017-06-03 11:49:00', '84', 'DO/1706/00007', 'SALE/1706/00050', '1', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '310.4841', '1', '1', null, '0002', 'invoice', 'completed', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('8', '2017-06-03 11:49:29', '80', 'DO/1706/00008', 'SALE/1706/00048', '4', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '80.0000', '1', null, null, '0000', 'invoice', 'completed', '0', 'pending', '0');
INSERT INTO `erp_deliveries` VALUES ('9', '2017-06-03 11:57:30', '85', 'DO/1706/00009', 'SALE/1706/00051', '1', '2', 'General Customer', 'PP phnom penh   Cambodia<br/> Tel: 012334345 Email: iclouderp@gmail.com', '', '30.3872', '1', null, null, '0000', 'invoice', 'completed', '0', 'pending', '0');

-- ----------------------------
-- Table structure for erp_delivery_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_delivery_items`;
CREATE TABLE `erp_delivery_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL,
  `do_reference_no` varchar(50) NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `begining_balance` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) NOT NULL,
  `ending_balance` decimal(25,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_count` int(4) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`do_reference_no`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`do_reference_no`),
  KEY `sale_id_2` (`do_reference_no`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_delivery_items
-- ----------------------------
INSERT INTO `erp_delivery_items` VALUES ('2', '2', '', '5', '23', '23', 'standard', 'KAKADA_01', '0', '', '2', null, '25.0000', '25.0000', '0.0000', '3', null, null, null, '0000');
INSERT INTO `erp_delivery_items` VALUES ('3', '3', '', '5', '28', '28', 'standard', 'KAKADA_01', null, '', '4', null, '10.0000', '5.0000', '5.0000', '1', null, null, null, '0000');
INSERT INTO `erp_delivery_items` VALUES ('4', '1', '', '4', '25', '25', 'standard', 'Cambodia', null, '', '1', null, '10.0000', '5.0000', '5.0000', null, null, '1', null, '0001');
INSERT INTO `erp_delivery_items` VALUES ('6', '4', '', '5', '57', '49', 'standard', 'KAKADA_01', null, '', '1', null, '10.0000', '10.0000', '0.0000', null, null, '1', null, '0001');
INSERT INTO `erp_delivery_items` VALUES ('7', '5', '', '2', '99', '84', 'standard', 'Return Group 1', null, '', '1', null, '5.0000', '2.0000', '3.0000', '1', null, null, null, '0000');
INSERT INTO `erp_delivery_items` VALUES ('8', '5', '', '4', '100', '84', 'standard', 'Cambodia', null, '', '1', null, '5.0000', '2.0000', '3.0000', '1', null, null, null, '0000');
INSERT INTO `erp_delivery_items` VALUES ('9', '6', '', '5', '94', '80', 'standard', 'KAKADA_01', '0', '', '2', null, '8.0000', '4.0000', '4.0000', '1', null, null, null, '0000');
INSERT INTO `erp_delivery_items` VALUES ('12', '8', '', '5', '94', '80', 'standard', 'KAKADA_01', '0', '', '2', null, '4.0000', '4.0000', '0.0000', '1', null, null, null, '0000');
INSERT INTO `erp_delivery_items` VALUES ('15', '7', '', '2', '99', '84', 'standard', 'Return Group 1', null, '', '1', null, '3.0000', '0.0000', '3.0000', null, null, '1', null, '0002');
INSERT INTO `erp_delivery_items` VALUES ('16', '7', '', '4', '100', '84', 'standard', 'Cambodia', null, '', '1', null, '3.0000', '0.0000', '3.0000', null, null, '1', null, '0002');
INSERT INTO `erp_delivery_items` VALUES ('17', '9', '', '9', '101', '85', 'standard', 'Mey Mey', null, '', '1', null, '5.0000', '2.0000', '3.0000', '1', null, null, null, '0000');
INSERT INTO `erp_delivery_items` VALUES ('18', '9', '', '2', '102', '85', 'standard', 'Return Group 1', null, '', '1', null, '5.0000', '2.0000', '3.0000', '1', null, null, null, '0000');

-- ----------------------------
-- Table structure for erp_deposits
-- ----------------------------
DROP TABLE IF EXISTS `erp_deposits`;
CREATE TABLE `erp_deposits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(11) NOT NULL,
  `amount` decimal(25,4) NOT NULL,
  `paid_by` varchar(50) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `account_code` varchar(20) DEFAULT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `po_reference_no` varchar(50) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `deposit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_deposits
-- ----------------------------

-- ----------------------------
-- Table structure for erp_documents
-- ----------------------------
DROP TABLE IF EXISTS `erp_documents`;
CREATE TABLE `erp_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(50) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text,
  `brand_id` varchar(50) DEFAULT NULL,
  `category_id` varchar(50) DEFAULT NULL,
  `subcategory_id` varchar(50) DEFAULT NULL,
  `cost` decimal(50,0) DEFAULT NULL,
  `price` decimal(8,4) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_documents
-- ----------------------------

-- ----------------------------
-- Table structure for erp_document_photos
-- ----------------------------
DROP TABLE IF EXISTS `erp_document_photos`;
CREATE TABLE `erp_document_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_document_photos
-- ----------------------------

-- ----------------------------
-- Table structure for erp_employee_salary_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_employee_salary_tax`;
CREATE TABLE `erp_employee_salary_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `basic_salary` decimal(24,4) DEFAULT NULL,
  `amount_usd` decimal(24,4) DEFAULT NULL,
  `spouse` int(10) DEFAULT NULL,
  `minor_children` int(20) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `date_insert` date DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `location` varchar(300) DEFAULT NULL,
  `date_print` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `trigger_id` int(11) DEFAULT NULL,
  `tax_rate` double DEFAULT NULL,
  `salary_tax` double DEFAULT NULL,
  `salary_tobe_paid` double DEFAULT NULL,
  `declare_salary_tax` tinyint(1) NOT NULL DEFAULT '0',
  `tab` tinyint(1) DEFAULT NULL,
  `allowance` decimal(4,0) DEFAULT NULL,
  `allowance_tax` decimal(4,0) DEFAULT NULL,
  `remark_fb` text,
  `declare_tax` tinyint(1) DEFAULT '0',
  `hide_row` tinyint(1) DEFAULT '0',
  `total_time` int(11) DEFAULT NULL,
  `emp_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `trigger_id` (`trigger_id`),
  KEY `date_insert` (`date_insert`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_employee_salary_tax
-- ----------------------------

-- ----------------------------
-- Table structure for erp_employee_salary_tax_small_taxpayers
-- ----------------------------
DROP TABLE IF EXISTS `erp_employee_salary_tax_small_taxpayers`;
CREATE TABLE `erp_employee_salary_tax_small_taxpayers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `basic_salary` decimal(24,4) DEFAULT NULL,
  `amount_usd` decimal(24,4) DEFAULT NULL,
  `spouse` int(10) DEFAULT NULL,
  `minor_children` int(20) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `date_insert` date DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `location` varchar(300) DEFAULT NULL,
  `date_print` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `trigger_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_employee_salary_tax_small_taxpayers
-- ----------------------------

-- ----------------------------
-- Table structure for erp_employee_salary_tax_small_taxpayers_trigger
-- ----------------------------
DROP TABLE IF EXISTS `erp_employee_salary_tax_small_taxpayers_trigger`;
CREATE TABLE `erp_employee_salary_tax_small_taxpayers_trigger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(50) NOT NULL,
  `year_month` date NOT NULL,
  `isCompany` tinyint(1) unsigned NOT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `total_salary_usd` decimal(24,2) unsigned DEFAULT NULL,
  `total_salary_tax_usd` decimal(24,2) unsigned DEFAULT NULL,
  `total_salary_tax_cal_base_riel` decimal(24,2) DEFAULT NULL,
  `total_salary_tax_riel` decimal(24,2) DEFAULT NULL,
  `date_print` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `trigger_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_employee_salary_tax_small_taxpayers_trigger
-- ----------------------------

-- ----------------------------
-- Table structure for erp_employee_salary_tax_trigger
-- ----------------------------
DROP TABLE IF EXISTS `erp_employee_salary_tax_trigger`;
CREATE TABLE `erp_employee_salary_tax_trigger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(50) NOT NULL,
  `year_month` varchar(15) NOT NULL,
  `isCompany` tinyint(1) unsigned NOT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `total_salary_usd` decimal(24,2) unsigned DEFAULT NULL,
  `total_salary_tax_usd` decimal(24,2) unsigned DEFAULT NULL,
  `total_salary_tax_cal_base_riel` decimal(24,2) DEFAULT NULL,
  `total_salary_tax_riel` decimal(24,2) DEFAULT NULL,
  `date_print` date NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `tab` tinyint(1) DEFAULT NULL,
  `total_allowance_tax` decimal(25,4) DEFAULT NULL,
  `reference_no_j` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `reference` (`reference_no`),
  KEY `year_month` (`year_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_employee_salary_tax_trigger
-- ----------------------------

-- ----------------------------
-- Table structure for erp_employee_type
-- ----------------------------
DROP TABLE IF EXISTS `erp_employee_type`;
CREATE TABLE `erp_employee_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(120) NOT NULL DEFAULT '',
  `code` varchar(30) DEFAULT NULL,
  `account_salary` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_employee_type
-- ----------------------------

-- ----------------------------
-- Table structure for erp_enter_using_stock
-- ----------------------------
DROP TABLE IF EXISTS `erp_enter_using_stock`;
CREATE TABLE `erp_enter_using_stock` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `warehouse_id` int(5) DEFAULT NULL,
  `authorize_id` int(10) DEFAULT NULL,
  `employee_id` int(10) DEFAULT NULL,
  `shop` int(10) DEFAULT NULL,
  `account` int(20) DEFAULT NULL,
  `note` text,
  `create_by` int(10) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `total_cost` decimal(25,4) DEFAULT NULL,
  `using_reference_no` varchar(255) DEFAULT NULL,
  `total_using_cost` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_enter_using_stock
-- ----------------------------

-- ----------------------------
-- Table structure for erp_enter_using_stock_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_enter_using_stock_items`;
CREATE TABLE `erp_enter_using_stock_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `description` text,
  `reason` text,
  `qty_use` decimal(25,4) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `warehouse_id` int(10) DEFAULT NULL,
  `qty_by_unit` int(25) DEFAULT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_enter_using_stock_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_expenses
-- ----------------------------
DROP TABLE IF EXISTS `erp_expenses`;
CREATE TABLE `erp_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference` varchar(55) NOT NULL,
  `amount` decimal(25,6) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `account_code` varchar(20) DEFAULT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax` tinyint(3) DEFAULT '0',
  `status` varchar(55) DEFAULT '',
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_expenses
-- ----------------------------

-- ----------------------------
-- Table structure for erp_expenses_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_expenses_audit`;
CREATE TABLE `erp_expenses_audit` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference` varchar(55) NOT NULL,
  `amount` decimal(25,6) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `account_code` varchar(20) DEFAULT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax` tinyint(3) DEFAULT '0',
  `status` varchar(55) DEFAULT '',
  `warehouse_id` int(11) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_expenses_audit
-- ----------------------------

-- ----------------------------
-- Table structure for erp_expense_categories
-- ----------------------------
DROP TABLE IF EXISTS `erp_expense_categories`;
CREATE TABLE `erp_expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_expense_categories
-- ----------------------------

-- ----------------------------
-- Table structure for erp_gift_cards
-- ----------------------------
DROP TABLE IF EXISTS `erp_gift_cards`;
CREATE TABLE `erp_gift_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `card_no` varchar(20) NOT NULL,
  `value` decimal(25,4) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `balance` decimal(25,4) NOT NULL,
  `expiry` date DEFAULT NULL,
  `created_by` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_no` (`card_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_gift_cards
-- ----------------------------

-- ----------------------------
-- Table structure for erp_gift_cards_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_gift_cards_audit`;
CREATE TABLE `erp_gift_cards_audit` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `card_no` varchar(20) NOT NULL,
  `value` decimal(25,4) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `balance` decimal(25,4) NOT NULL,
  `expiry` date DEFAULT NULL,
  `created_by` varchar(55) NOT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  UNIQUE KEY `card_no` (`card_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_gift_cards_audit
-- ----------------------------

-- ----------------------------
-- Table structure for erp_gl_charts
-- ----------------------------
DROP TABLE IF EXISTS `erp_gl_charts`;
CREATE TABLE `erp_gl_charts` (
  `accountcode` int(11) NOT NULL DEFAULT '0',
  `accountname` varchar(200) DEFAULT '',
  `parent_acc` int(11) DEFAULT '0',
  `sectionid` int(11) DEFAULT '0',
  `account_tax_id` int(11) DEFAULT '0',
  `acc_level` int(11) DEFAULT '0',
  `lineage` varchar(500) NOT NULL,
  `bank` tinyint(1) DEFAULT NULL,
  `value` decimal(55,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`accountcode`),
  KEY `AccountCode` (`accountcode`) USING BTREE,
  KEY `AccountName` (`accountname`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_gl_charts
-- ----------------------------
INSERT INTO `erp_gl_charts` VALUES ('100100', 'Cash', '100100', '10', '0', '0', '', '1', '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100101', 'Petty Cash', '100100', '10', '0', '0', '', '1', '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100102', 'Cash on Hand', '100100', '10', '0', '0', '', '1', '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100103', 'ANZ Bank', '100100', '10', '0', '0', '', '1', '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100104', 'Wing Account', '100100', '10', '0', '0', '', '1', '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100105', 'Visa', '100100', '10', '0', '0', '', '1', '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100106', 'Chequing Bank Account', '100100', '10', '0', '0', '', '1', '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100200', 'Account Receivable', '0', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100400', 'Other Current Assets', '0', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100410', 'Prepaid Expense', '100400', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100420', 'Supplier Deposit', '100400', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100430', 'Inventory', '100400', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100440', 'Deferred Tax Asset', '100400', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100441', 'VAT Input', '100440', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100442', 'VAT Credit Carried Forward', '100440', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100500', 'Cash Advance', '100400', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100501', 'Loan to Related Parties', '100400', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('100502', 'Staff Advance Cash', '100400', '10', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('101005', 'Own Invest', '0', '80', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110200', 'Property, Plant and Equipment', '0', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110201', 'Furniture', '110200', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110202', 'Office Equipment', '110200', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110203', 'Machineries', '110200', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110204', 'Leasehold Improvement', '110200', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110205', 'IT Equipment & Computer', '110200', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110206', 'Vehicle', '110200', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110250', 'Less Total Accumulated Depreciation', '110200', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110251', 'Less Acc. Dep. of Furniture', '110250', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110252', 'Less Acc. Dep. of Office Equipment', '110250', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110253', 'Less Acc. Dep. of Machineries', '110250', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110254', 'Less Acc. Dep. of Leasehold Improvement', '110250', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110255', 'Less Acc. Dep. of IT Equipment & Computer', '110250', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('110256', 'Less Acc. Dep of Vehicle', '110250', '11', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201100', 'Accounts Payable', '0', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201200', 'Other Current Liabilities', '0', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201201', 'Salary Payable', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201202', 'OT Payable', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201203', 'Allowance Payable', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201204', 'Bonus Payable', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201205', 'Commission Payable', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201206', 'Interest Payable', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201207', 'Loan from Related Parties', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201208', 'Customer Deposit', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201209', 'Accrued Expense', '201200', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201400', 'Deferred Tax Liabilities', '0', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201401', 'Salary Tax Payable', '201400', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201402', 'Withholding Tax Payable', '201400', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201403', 'VAT Payable', '201400', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201404', 'Profit Tax Payable', '201400', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201405', 'Prepayment Profit Tax Payable', '201400', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201406', 'Fringe Benefit Tax Payable', '201400', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('201407', 'VAT Output', '201400', '20', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('300000', 'Capital Stock', '0', '30', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('300100', 'Paid-in Capital', '300000', '30', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('300101', 'Additional Paid-in Capital', '300000', '30', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('300200', 'Retained Earnings', '0', '30', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('300300', 'Opening Balance', '0', '30', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('400000', 'Sale Revenue', '0', '40', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('400001', 'Utilities', '0', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('410101', 'Income', '400000', '40', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('410102', 'Sale Discount', '400000', '40', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('410103', 'Other Income', '400000', '40', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('410104', 'Income Restaurant', '400000', '40', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('410105', 'Income Phone', '400000', '40', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500000', 'Cost of Goods Sold', '0', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500101', 'COMS', '500000', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500102', 'Freight Expense', '500000', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500103', 'Wages & Salaries', '500000', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500104', 'Cost Restaurant', '500000', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500105', 'Cost Phones', '500000', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500106', 'Purchase Discount', '500000', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500107', 'Inventory Adjustment', '500000', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500108', 'Cost of Variance', '500000', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('500109', 'Using Stock', '500101', '50', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('600000', 'Expenses', '0', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601100', 'Staff Cost', '600000', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601101', 'Salary Expense', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601102', 'OT', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601103', 'Allowance ', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601104', 'Bonus', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601105', 'Commission', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601106', 'Training/Education', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601107', 'Compensation', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601108', 'Other Staff Relation', '601100', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601200', 'Administration Cost', '600000', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601201', 'Rental Expense', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601202', 'Utilities', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601203', 'Marketing & Advertising', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601204', 'Repair & Maintenance', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601205', 'Customer Relation', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601206', 'Transportation', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601207', 'Communication', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601208', 'Insurance Expense', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601209', 'Professional Fee', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601210', 'Depreciation Expense', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601211', 'Amortization Expense', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601212', 'Stationery', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601213', 'Office Supplies', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601214', 'Donation', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601215', 'Entertainment Expense', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601216', 'Travelling & Accomodation', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601217', 'Service Computer Expenses', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601218', 'Interest Expense', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601219', 'Bank Charge', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601220', 'Miscellaneous Expense', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601221', 'Canteen Supplies', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('601222', 'Registration Expenses', '601200', '60', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('710300', 'Other Income', '0', '70', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('710301', 'Interest Income', '710300', '70', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('710302', 'Other Revenue & Gain', '710300', '70', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('801300', 'Other Expenses', '0', '80', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('801301', 'Other Expense & Loss', '801300', '80', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('801302', 'Bad Dept Expense', '801300', '80', '0', '0', '', null, '0.00');
INSERT INTO `erp_gl_charts` VALUES ('801303', 'Tax & Duties Expense', '801300', '80', '0', '0', '', null, '0.00');

-- ----------------------------
-- Table structure for erp_gl_charts_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_gl_charts_tax`;
CREATE TABLE `erp_gl_charts_tax` (
  `account_tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `accountcode` varchar(19) DEFAULT '0',
  `accountname` varchar(200) DEFAULT '',
  `accountname_kh` varchar(250) DEFAULT '0',
  `sectionid` int(11) DEFAULT '0',
  PRIMARY KEY (`account_tax_id`),
  KEY `AccountCode` (`accountcode`) USING BTREE,
  KEY `AccountName` (`accountname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of erp_gl_charts_tax
-- ----------------------------
INSERT INTO `erp_gl_charts_tax` VALUES ('1', 'B1', 'Sales of manufactured products', 'ការលក់ផលិតផល', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('2', 'B2', 'Sales of goods', 'ការលក់ទំនិញ', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('3', 'B3', 'Sales/Supply of services', 'ការផ្គត់ផ្គង់សេវា', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('4', 'A2', 'Freehold Land', 'ដីធ្លីរបស់សហគ្រាស', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('5', 'A3', 'Improvements and preparation of land', 'ការរៀបចំតុបតែងលំអរដីរបស់សហគ្រាស', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('6', 'A4', 'Freehold buildings', 'សំណង់ងគាររបស់សហគ្រាស', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('7', 'B4', 'Costs of pruducts sold of production enterprises(TOP 01/V)', 'ថៃ្លដើមផលិតផលបានលក់របស់សហគ្រាសផលិតកម្ម​(TOP 01/V)', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('8', 'A5', 'Freehold buildings on leasehold land', 'សំណង់អាគារលើដីធ្លីក្រោមភតិសន្យា', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('9', 'B5', 'Costs of goods sold of​​​​ non- production enterprises (TOP 01/VI)', 'ថៃ្លដើម ទំនិញបានលក់របស់សហគ្រាសក្រៅពីផលិតកម្ម(TOP 0', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('10', 'A6', 'Non-current assets in progress', 'ទ្រព្យសកម្មរយះពេលវែងកំពុងដំណើរការ', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('11', 'A7', 'Plant and equipemt', 'រោងចក្រ​​​(ក្រៅពីអគារ)និងបរិក្ខារ', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('12', 'B5a', 'Costs of services supplied', 'ថៃ្លដើមសេវាបានផ្គត់ផ្គង់', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('13', 'A8', 'Goodwill', 'កេរ្តិ៍ឈ្មោះ/មូលនិធិពាណិជ្ជកម្ម', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('14', 'A9', 'Preliminary and formation expenses', 'ចំណាយបង្កើតសហគ្រាសដំបូង', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('15', 'B8', 'Grant/subsidy', 'ឧបត្ថម្ភកធន', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('16', 'A10', 'Leasehold assets and lease premiums', 'ទ្រព្យសកម្មក្រោមភតិសន្យា​​ និង​បុព្វលាភនៃការប្រើប្', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('17', 'A11', 'Investment in other enterprise', 'វិនិយោគក្នុងសហគ្រាសដទៃ', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('18', 'B9', 'Dividend received or receivable', 'ចំណូលពីភាគលាភបានទទួល​ ឬ ត្រូវទទួល', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('19', 'B10', 'Interest received or receivable', 'ចំំណូលពីការប្រាក់បានទទួល ឬ ត្រូវទទួល', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('20', 'A29', 'Capital/ Share capital', 'មូលធន/ មូលធនភាគហ៊ុន', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('21', 'A12', 'Other non-current assets', 'ទ្រព្យសកម្មរយ:ពេលវែងផ្សេងៗ', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('22', 'B11', 'Royalty received or receivable', 'ចំណូលពីសួយសារបានទទួល ឬ ត្រូវទទួល', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('23', 'A30', 'Share premium', 'តម្លៃលើសនៃការលក់ប័ណ្ណភាគហ៊ុន', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('24', 'B12', 'Rental received or receivable', 'ចំណូលពីការជួលបានទទួល ឬ ត្រូវទទួល', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('25', 'A31', 'Legal capital reserves', 'មូលធនបំរុងច្បាប់', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('26', 'A14', 'Stock of raw materials and supplies', 'ស្តូកវត្ធុធាតុដើម និងសំភារ:ផ្គត់ផ្គង់', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('27', 'A32', 'Reserves revaluation surplus of assets', 'លំអៀងលើសការវាយតំលៃឡើងវិញនូវទ្រព្យសកម្ម', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('28', 'A33', 'Other capital reserves', 'មូលធនបំរុងផ្សេងៗ', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('29', 'A15', 'Stock of goods', 'ស្តុកទំនិញ', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('30', 'B13', 'Gain from disposal of fixed assets (captital gain)', 'ផលចំណេញ/តំលៃលើសពីការលក់ទ្រព្យសកម្មរយះពេលវែង', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('31', 'A34', 'Profit and loss brought forward', 'លទ្ធផលចំណេញ/ ខាត យោងពីមុន', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('32', 'A16', 'Stock of finished goods', 'ស្តុកផលិតផលសម្រាច', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('33', 'A35', 'Profit and loss for the period', 'លទ្ធផងចំណេញ/ ខាត នៃកាលបរិច្ឆេត', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('34', 'B14', 'Gain from disposal of securities', 'ផលចំណេញពីការលក់មូលប័ត្រ/សញ្ញាប័ណ្ណ', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('35', 'A37', 'Loan from related parties', 'បំណុលភាគីជាប់ទាក់ទិន', '21');
INSERT INTO `erp_gl_charts_tax` VALUES ('36', 'A38', 'Loan from banks and other external parties', 'បំណុលធនាគារ និងបំណុលភាគីមិនជាប់ទាក់ទិនផ្សេងៗ', '21');
INSERT INTO `erp_gl_charts_tax` VALUES ('37', 'B15', 'Share of profit from joint venture', 'ភាគចំណេញពីប្រតិបត្តិការរួមគ្នា', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('38', 'A17', 'Products in progress', 'ផលិតផលកំពុងផលិត', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('39', 'A39', 'Provision for charges and contigencies', 'សវិធានធនសំរាប់បន្ទុក និង​ហានិភ័យ', '21');
INSERT INTO `erp_gl_charts_tax` VALUES ('40', 'B16', 'Realised exchange gain', 'ផលចំណេញពីការប្តូរប្រាក់សំរេចបាន', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('41', 'A40', 'Other non-current liabilities', 'បំណុលរយៈពេលវែងផ្សេងៗ', '21');
INSERT INTO `erp_gl_charts_tax` VALUES ('42', 'A18', 'Account receivevable/trade debtors', 'គណនីត្រូវទទួល​ /អតិថិជន', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('43', 'B17', 'Unrealised exchange gain', 'ផលចំណេញពីការប្តូរប្រាក់មិនទាន់សំរេចបាន', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('44', 'A42', 'Bank overdraft', 'សាច់ប្រាក់ដកពីធនាគារលើសប្រាក់បញ្ជី (ឥណទានរិបារូប៍រ', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('45', 'A19', 'Other account receivables', 'គណនីទទួលផ្សេងៗ', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('46', 'B18', 'Other revenues', 'ចំណូលដ៏ទៃទៀត', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('47', 'A43', 'Short-term borrowing-current portion of interest bearing borrowing', 'ចំណែកចរន្តនៃបំណុលមានការប្រាក់', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('48', 'A20', 'Prepaid expenses', 'ចំណាយបានកត់ត្រាមុន', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('49', 'B20', 'Salaries expenses', 'ចំណាយបៀវត្ស', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('50', 'A44', 'Accounts payble to relate parties', 'គណនីត្រូវសងបុគ្គលជាប់ទាក់ទិន (ភាគីសម្ព័ន្ធញាត្តិ)', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('51', 'A45', 'Other accounts payable', 'គណនីត្រូវសងផ្សេងៗ', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('52', 'A21', 'Cash on hand and at banks', 'សាច់ប្រាក់នៅក្នុងបេឡា និងនៅធនាគា', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('53', 'B21', 'Fuel, gas,electricity and water expenses', 'ចំណាយប្រេង ឧស្មន័ អគ្គីសនី និងទឹក', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('54', 'A46', 'Unearned revenue, accruals and other current liabilities', 'ចំណូលកត់មុន គណនីចំណាយបង្ករ និងបំណុលរយោៈពេលខ្លីផ្សេ', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('55', 'A47', 'Provision for changes and contigencies', 'សវិធានធនសំរាប់បន្ទុក និង​ហានិភ័យ', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('56', 'B22', 'Travelling and accommodation expenses', 'ចំណាយធើ្វដំណើរ និងចំណាយស្នាក់នៅ', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('57', 'A48', 'Profit tax payable', 'ពន្ធលើប្រាក់ចំណេញត្រូវបង់', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('58', 'A49', 'Other taxes payable', 'ពន្ទ-អាករផ្សេងៗត្រូវបង់', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('59', 'B23', 'Transporttation expenses', 'ចំណាយដឹកជញ្ជូន', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('60', 'A50', 'Differences arissing from currency translation in liabilities', 'លំអៀងពីការប្តូរប្រាក់នៃទ្រព្យសកម្ម', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('61', 'B24', 'Rental expenses', 'ចំណាយលើការជួល', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('62', 'B25', 'Repair anmaintenance expenses', 'ចំណាយលើការថែទាំ និងជួសជុល', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('63', 'B26', 'Entertament expenses', 'ចំណាយលើការកំសាន្តសប្យាយ', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('64', 'A22', 'Prepayment of profit tax credit', 'ឥណទានប្រាក់រំដោះពន្ធលើប្រាក់ចំណេញ', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('65', 'B27', 'Commission, advertising, and selling expenses', 'ចំណាយកំរៃជើងសារ ផ្សាយពាណិ្ជកម្ម និងចំណាយការលក់', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('66', 'A23', 'Value added tax credit', 'ឥណទានអាករលើតម្លៃបន្ថែម', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('67', 'B28', 'Other taxes expenses', 'ចំណាយបង់ពន្ធ និងអាករផេ្សងៗ', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('68', 'B29', 'Donation expenses', 'ចំណាយលើអំណោយ', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('69', 'A24', 'Other taxes credit', 'ឥណទានពន្ធ-អាករដដៃទៀត', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('70', 'B30', 'Management, consultant, other technical, and other similar services expenses', 'ចំណាយសេវាគ្រប់គ្រង ពិគ្រោះយោបល់ បចេ្វកទេស និងសេវាប', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('71', 'A25', 'Other current assets', 'ទ្រព្យសកម្មពេលខ្លីផ្សេងៗ', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('72', 'B31', 'Royalty expenses', 'ចំណាយលើសួយសារ', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('73', 'B32', 'Bad debts written off expenses', 'ចំណាយលើបំណុលទារមិនបាន', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('74', 'A26', 'Diffference arising from currency translation in assets', 'លំអៀងពីការប្តូរទ្រព្យសកម្ម', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('75', 'B33', 'Armortisation/depletion and depreciation expenses', 'ចំណាយរំលស់', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('76', 'B34', 'Increase /(decrease) in expenses', 'ការកើនឡើង /​ (ថយចុះ) សំវិធានធន', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('77', 'B35', 'Loss on siposal of fixed assets', 'ខាតពីការលក់ទ្រព្យសកម្មរយះពេលវែង', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('78', 'B36', 'Realised exchange loss', 'ខាតពីការប្តូរប្រាក់សំរេចបាន', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('79', 'B37', 'Unrealised exchange loss', 'ខាតពីការប្តូរប្រាក់មិនទាន់សំរេចបាន', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('80', 'B38', 'Other expenses', 'ចំណាយផេ្សងៗ', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('81', 'B40', 'Interest expenses paid to residents', 'ចំណាយការប្រាក់បង់អោយនិវាសនជន', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('82', 'B41', 'Interest expenses paid to non-residents', 'ចំណាយការប្រាក់បង់អោយអនិវាសនជន', '60');
INSERT INTO `erp_gl_charts_tax` VALUES ('83', 'A1', 'Non-current assets/ fixed assets', 'ទ្រព្យសកម្មរយៈពេលេវែង', '10');
INSERT INTO `erp_gl_charts_tax` VALUES ('84', 'A13', 'Current assets', 'ទ្រព្យសកម្មរយៈពេលខ្លី', '11');
INSERT INTO `erp_gl_charts_tax` VALUES ('85', 'A28', 'Equity', 'មូលនិធិ/ ទុនម្ចាស់ទ្រព្យ ', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('86', 'A36', 'Non-current liabilities', 'បំណុលរយៈពេលវែង', '21');
INSERT INTO `erp_gl_charts_tax` VALUES ('87', 'A41', 'Current liabilities', 'បំណុលរយៈពេលខ្លី', '20');
INSERT INTO `erp_gl_charts_tax` VALUES ('88', 'B0', 'Operating revenue', 'ចំណូលប្រតិបត្តិការ', '30');
INSERT INTO `erp_gl_charts_tax` VALUES ('89', 'B7', 'Other revenue', 'ចំណូលផ្សេងៗ', '70');
INSERT INTO `erp_gl_charts_tax` VALUES ('90', 'B19', 'Operating expenses', 'ចំណាយប្រតិបតិ្តការ', '60');

-- ----------------------------
-- Table structure for erp_gl_sections
-- ----------------------------
DROP TABLE IF EXISTS `erp_gl_sections`;
CREATE TABLE `erp_gl_sections` (
  `sectionid` int(11) NOT NULL DEFAULT '0',
  `sectionname` text,
  `sectionname_kh` text,
  `AccountType` char(2) DEFAULT NULL,
  `description` text,
  `pandl` int(11) DEFAULT '0',
  `order_stat` int(11) DEFAULT '0',
  PRIMARY KEY (`sectionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_gl_sections
-- ----------------------------
INSERT INTO `erp_gl_sections` VALUES ('10', 'CURRENT ASSETS', 'ទ្រព្យសកម្មរយះពេលខ្លី', 'AS', 'CURRENT ASSETS', '0', '10');
INSERT INTO `erp_gl_sections` VALUES ('11', 'FIXED ASSETS', 'ទ្រព្យសកម្មរយះពេលវែង', 'AS', 'FIXED ASSETS', '0', '11');
INSERT INTO `erp_gl_sections` VALUES ('20', 'CURRENT LIABILITIES', 'បំណុលរយះពេលខ្លី', 'LI', 'CURRENT LIABILITIES', '0', '20');
INSERT INTO `erp_gl_sections` VALUES ('21', 'NON-CURRENT LIABILITIES', 'បំណុលរយះពេលវែង', 'LI', 'NON-CURRENT LIABILITIES', '0', '21');
INSERT INTO `erp_gl_sections` VALUES ('30', 'EQUITY AND RETAINED EARNING', 'មូលនិធិ/ទុនម្ចាស់ទ្រព្យ', 'EQ', 'EQUITY AND RETAINED EARNING', '0', '30');
INSERT INTO `erp_gl_sections` VALUES ('40', 'INCOME', 'ចំណូលប្រតិបត្តិការ', 'RE', 'INCOME', '1', '40');
INSERT INTO `erp_gl_sections` VALUES ('50', 'COST OF GOODS SOLD', 'ចំណាយថ្លៃដើម', 'CO', 'COST OF GOODS SOLD', '1', '50');
INSERT INTO `erp_gl_sections` VALUES ('60', 'OPERATING EXPENSES', 'ចំណាយប្រតិបត្តិការ', 'EX', 'OPERATING EXPENSES', '1', '60');
INSERT INTO `erp_gl_sections` VALUES ('70', 'OTHER INCOME', 'ចំណូលផ្សេងៗ', 'OI', 'OTHER INCOME', '1', '70');
INSERT INTO `erp_gl_sections` VALUES ('80', 'OTHER EXPENSE', 'ចំណាយផ្សេងៗ', 'OX', 'OTHER EXPENSE', '1', '80');
INSERT INTO `erp_gl_sections` VALUES ('90', 'GAIN & LOSS', 'ចំណេញខាត', 'GL', 'GAIN & LOSS', '1', '90');

-- ----------------------------
-- Table structure for erp_gl_sections_copy
-- ----------------------------
DROP TABLE IF EXISTS `erp_gl_sections_copy`;
CREATE TABLE `erp_gl_sections_copy` (
  `sectionid` int(11) NOT NULL DEFAULT '0',
  `sectionname` text,
  `sectionname_kh` text,
  `AccountType` char(2) DEFAULT NULL,
  `description` text,
  `pandl` int(11) DEFAULT '0',
  `order_stat` int(11) DEFAULT '0',
  PRIMARY KEY (`sectionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_gl_sections_copy
-- ----------------------------
INSERT INTO `erp_gl_sections_copy` VALUES ('10', 'CURRENT ASSETS', 'ទ្រព្យសកម្មរយះពេលខ្លី', 'AS', 'CURRENT ASSETS', '0', '10');
INSERT INTO `erp_gl_sections_copy` VALUES ('11', 'FIXED ASSETS', 'ទ្រព្យសកម្មរយះពេលវែង', 'AS', 'FIXED ASSETS', '0', '11');
INSERT INTO `erp_gl_sections_copy` VALUES ('20', 'CURRENT LIABILITIES', 'បំណុលរយះពេលខ្លី', 'LI', 'CURRENT LIABILITIES', '0', '20');
INSERT INTO `erp_gl_sections_copy` VALUES ('21', 'NON-CURRENT LIABILITIES', 'បំណុលរយះពេលវែង', 'LI', 'NON-CURRENT LIABILITIES', '0', '21');
INSERT INTO `erp_gl_sections_copy` VALUES ('30', 'EQUITY AND RETAINED EARNING', 'មូលនិធិ/ទុនម្ចាស់ទ្រព្យ', 'EQ', 'EQUITY AND RETAINED EARNING', '0', '30');
INSERT INTO `erp_gl_sections_copy` VALUES ('40', 'INCOME', 'ចំណូលប្រតិបត្តិការ', 'RE', 'INCOME', '1', '40');
INSERT INTO `erp_gl_sections_copy` VALUES ('50', 'COST OF GOODS SOLD', 'ចំណាយថ្លៃដើម', 'CO', 'COST OF GOODS SOLD', '1', '50');
INSERT INTO `erp_gl_sections_copy` VALUES ('60', 'OPERATING EXPENSES', 'ចំណាយប្រតិបត្តិការ', 'EX', 'OPERATING EXPENSES', '1', '60');
INSERT INTO `erp_gl_sections_copy` VALUES ('70', 'OTHER INCOME', 'ចំណូលផ្សេងៗ', 'OI', 'OTHER INCOME', '1', '70');
INSERT INTO `erp_gl_sections_copy` VALUES ('80', 'OTHER EXPENSE', 'ចំណាយផ្សេងៗ', 'OX', 'OTHER EXPENSE', '1', '80');
INSERT INTO `erp_gl_sections_copy` VALUES ('90', 'GAIN & LOSS', 'ចំណេញខាត', 'GL', 'GAIN & LOSS', '1', '90');

-- ----------------------------
-- Table structure for erp_gl_trans
-- ----------------------------
DROP TABLE IF EXISTS `erp_gl_trans`;
CREATE TABLE `erp_gl_trans` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `tran_type` varchar(20) DEFAULT '0',
  `tran_no` bigint(20) NOT NULL DEFAULT '1',
  `tran_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `sectionid` int(11) DEFAULT '0',
  `account_code` int(19) DEFAULT '0',
  `narrative` varchar(100) DEFAULT '',
  `amount` decimal(25,4) DEFAULT '0.0000',
  `reference_no` varchar(55) NOT NULL DEFAULT '',
  `description` varchar(250) DEFAULT '',
  `biller_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bank` tinyint(3) DEFAULT '0',
  `gov_tax` tinyint(3) DEFAULT '0',
  `reference_gov_tax` varchar(55) DEFAULT '',
  `people_id` int(11) DEFAULT NULL,
  `invoice_ref` varchar(55) DEFAULT NULL,
  `ref_type` int(11) DEFAULT NULL,
  `created_name` varchar(100) DEFAULT NULL,
  `created_type` varchar(10) DEFAULT NULL,
  `people` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status_tax` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tran_id`),
  KEY `Account` (`account_code`) USING BTREE,
  KEY `TranDate` (`tran_date`) USING BTREE,
  KEY `TypeNo` (`tran_no`) USING BTREE,
  KEY `Type_and_Number` (`tran_type`,`tran_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=384 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_gl_trans
-- ----------------------------
INSERT INTO `erp_gl_trans` VALUES ('1', 'PURCHASES', '1', '2017-06-01 19:09:36', '20', '201100', 'Accounts Payable', '-1000.0000', 'PO/1706/00001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('2', 'PURCHASES', '1', '2017-06-01 00:00:00', '10', '100430', 'Inventory', '1000.0000', 'PO/1706/00001', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('3', 'PURCHASES', '2', '2017-06-01 19:10:22', '20', '201100', 'Accounts Payable', '-500.0000', 'PO/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('4', 'PURCHASES', '2', '2017-06-01 00:00:00', '10', '100430', 'Inventory', '500.0000', 'PO/1706/00002', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('8', 'PURCHASES', '4', '2017-06-01 19:34:00', '20', '201100', 'Accounts Payable', '48.0000', 'PV/1706/00001', '', '1', '1', null, '1', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('9', 'PURCHASES', '4', '2017-06-01 19:34:00', '10', '100104', 'Wing Account', '-48.0000', 'PV/1706/00001', '', '1', '1', null, '1', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('10', 'SALES', '5', '2017-06-01 20:10:00', '40', '410102', 'Sale Discount', '0.3500', 'SALE/1706/00001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('11', 'SALES', '5', '2017-06-01 20:10:00', '10', '100200', 'Account Receivable', '3.1500', 'SALE/1706/00001', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('12', 'SALES', '5', '2017-06-01 20:10:00', '50', '500000', 'Cost of Goods Sold', '2.7692', 'SALE/1706/00001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('13', 'SALES', '5', '2017-06-01 20:10:00', '10', '100430', 'Inventory', '-2.7692', 'SALE/1706/00001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('14', 'SALES', '6', '2017-06-01 20:28:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00002', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('15', 'SALES', '6', '2017-06-01 20:28:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('16', 'SALES', '6', '2017-06-01 20:28:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('17', 'SALES', '6', '2017-06-01 20:28:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('18', 'SALES', '7', '2017-06-01 20:28:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00002', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('19', 'SALES', '7', '2017-06-01 20:28:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('20', 'SALES', '7', '2017-06-01 20:28:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('21', 'SALES', '7', '2017-06-01 20:28:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('22', 'SALES', '8', '2017-06-01 20:28:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00002', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('23', 'SALES', '8', '2017-06-01 20:28:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('24', 'SALES', '8', '2017-06-01 20:28:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('25', 'SALES', '8', '2017-06-01 20:28:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('26', 'SALES', '9', '2017-06-01 20:28:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00002', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('27', 'SALES', '9', '2017-06-01 20:28:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('28', 'SALES', '9', '2017-06-01 20:28:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('29', 'SALES', '9', '2017-06-01 20:28:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('30', 'PURCHASES', '10', '2017-06-01 20:34:38', '20', '201100', 'Accounts Payable', '-2000.0000', 'PO/1706/00004', '', '4', '4', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('31', 'PURCHASES', '10', '2017-06-01 00:00:00', '10', '100430', 'Inventory', '2000.0000', 'PO/1706/00004', null, '4', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('32', 'PURCHASES', '11', '2017-06-01 20:35:31', '20', '201100', 'Accounts Payable', '-1000.0000', 'PO/1706/00005', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('33', 'PURCHASES', '11', '2017-06-01 00:00:00', '10', '100430', 'Inventory', '1000.0000', 'PO/1706/00005', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('34', 'PURCHASES', '12', '2017-06-01 20:35:45', '20', '201100', 'Accounts Payable', '-500.0000', 'PO/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('35', 'PURCHASES', '12', '2017-06-01 00:00:00', '10', '100430', 'Inventory', '500.0000', 'PO/1706/00006', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('36', 'SALES', '13', '2017-06-01 20:44:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00003', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('37', 'SALES', '13', '2017-06-01 20:44:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00003', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('38', 'SALES', '13', '2017-06-01 20:44:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00003', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('39', 'SALES', '13', '2017-06-01 20:44:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00003', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('40', 'SALES', '14', '2017-06-01 20:47:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00004', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('41', 'SALES', '14', '2017-06-01 20:47:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00004', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('42', 'SALES', '14', '2017-06-01 20:47:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00004', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('43', 'SALES', '14', '2017-06-01 20:47:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00004', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('44', 'SALES', '15', '2017-06-01 20:52:00', '10', '100200', 'Account Receivable', '200.0000', 'SALE/1706/00005', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('45', 'SALES', '15', '2017-06-01 20:52:00', '40', '410101', 'Income', '-200.0000', 'SALE/1706/00005', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('46', 'SALES', '15', '2017-06-01 20:52:00', '50', '500000', 'Cost of Goods Sold', '100.0000', 'SALE/1706/00005', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('47', 'SALES', '15', '2017-06-01 20:52:00', '10', '100430', 'Inventory', '-100.0000', 'SALE/1706/00005', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('48', 'SALES', '16', '2017-06-01 20:53:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00006', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('49', 'SALES', '16', '2017-06-01 20:53:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('50', 'SALES', '16', '2017-06-01 20:53:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('51', 'SALES', '16', '2017-06-01 20:53:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('52', 'SALES', '17', '2017-06-01 20:53:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00006', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('53', 'SALES', '17', '2017-06-01 20:53:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('54', 'SALES', '17', '2017-06-01 20:53:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('55', 'SALES', '17', '2017-06-01 20:53:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('56', 'SALES', '18', '2017-06-01 20:53:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00006', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('57', 'SALES', '18', '2017-06-01 20:53:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('58', 'SALES', '18', '2017-06-01 20:53:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('59', 'SALES', '18', '2017-06-01 20:53:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('60', 'SALES', '19', '2017-06-01 20:53:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00006', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('61', 'SALES', '19', '2017-06-01 20:53:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('62', 'SALES', '19', '2017-06-01 20:53:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('63', 'SALES', '19', '2017-06-01 20:53:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('64', 'SALES', '20', '2017-06-01 20:53:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00006', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('65', 'SALES', '20', '2017-06-01 20:53:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('66', 'SALES', '20', '2017-06-01 20:53:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('67', 'SALES', '20', '2017-06-01 20:53:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00006', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('68', 'SALES', '21', '2017-06-01 21:01:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00008', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('69', 'SALES', '21', '2017-06-01 21:01:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00008', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('70', 'SALES', '22', '2017-06-01 21:04:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00009', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('71', 'SALES', '22', '2017-06-01 21:04:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('72', 'SALES', '22', '2017-06-01 21:04:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('73', 'SALES', '22', '2017-06-01 21:04:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('74', 'SALES', '23', '2017-06-01 21:04:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00009', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('75', 'SALES', '23', '2017-06-01 21:04:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('76', 'SALES', '23', '2017-06-01 21:04:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('77', 'SALES', '23', '2017-06-01 21:04:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('78', 'SALES', '24', '2017-06-01 21:04:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00009', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('79', 'SALES', '24', '2017-06-01 21:04:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('80', 'SALES', '24', '2017-06-01 21:04:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('81', 'SALES', '24', '2017-06-01 21:04:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('82', 'SALES', '25', '2017-06-01 21:19:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00010', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('83', 'SALES', '25', '2017-06-01 21:19:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00010', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('84', 'SALES', '25', '2017-06-01 21:19:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00010', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('85', 'SALES', '25', '2017-06-01 21:19:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00010', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('86', 'SALES', '26', '2017-06-01 21:19:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00010', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('87', 'SALES', '26', '2017-06-01 21:19:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00010', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('88', 'SALES', '26', '2017-06-01 21:19:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00010', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('89', 'SALES', '26', '2017-06-01 21:19:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00010', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('90', 'SALES', '27', '2017-06-01 21:26:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00011', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('91', 'SALES', '27', '2017-06-01 21:26:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00011', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('92', 'SALES', '27', '2017-06-01 21:26:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00011', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('93', 'SALES', '27', '2017-06-01 21:26:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00011', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('94', 'SALES', '28', '2017-06-01 21:28:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00012', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('95', 'SALES', '28', '2017-06-01 21:28:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00012', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('96', 'SALES', '28', '2017-06-01 21:28:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00012', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('97', 'SALES', '28', '2017-06-01 21:28:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00012', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('98', 'SALES', '29', '2017-06-02 08:05:08', '10', '100200', 'Account Receivable', '500.0000', 'SALE/1706/00013', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('99', 'SALES', '30', '2017-06-02 08:05:47', '10', '100200', 'Account Receivable', '-100.0000', 'RV/1706/00001', 'General Customer', '4', '1', null, '3', '0', '', null, null, null, null, null, null, 'payment', null);
INSERT INTO `erp_gl_trans` VALUES ('100', 'SALES', '30', '2017-06-02 08:05:47', '10', '100100', 'Cash', '100.0000', 'RV/1706/00001', 'General Customer', '4', '3', null, '1', '0', '', null, null, null, null, null, null, 'payment', null);
INSERT INTO `erp_gl_trans` VALUES ('101', 'SALES', '31', '2017-06-02 08:31:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00014', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('102', 'SALES', '31', '2017-06-02 08:31:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('103', 'SALES', '31', '2017-06-02 08:31:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('104', 'SALES', '31', '2017-06-02 08:31:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('105', 'SALES', '32', '2017-06-02 08:31:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00014', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('106', 'SALES', '32', '2017-06-02 08:31:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('107', 'SALES', '32', '2017-06-02 08:31:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('108', 'SALES', '32', '2017-06-02 08:31:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('109', 'SALES', '33', '2017-06-02 08:31:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00014', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('110', 'SALES', '33', '2017-06-02 08:31:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('111', 'SALES', '33', '2017-06-02 08:31:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('112', 'SALES', '33', '2017-06-02 08:31:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('113', 'SALES', '34', '2017-06-02 08:31:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00014', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('114', 'SALES', '34', '2017-06-02 08:31:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('115', 'SALES', '34', '2017-06-02 08:31:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('116', 'SALES', '34', '2017-06-02 08:31:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00014', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('118', 'SALES', '35', '2017-06-02 08:36:00', '10', '100200', 'Account Receivable', '330.0000', 'SALE/1706/00015', 'General Customer', '5', '5', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('119', 'SALES', '36', '2017-06-02 09:38:09', '60', '601206', 'Transportation', '-10.0000', 'SALE/1706/00016', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('120', 'SALES', '36', '2017-06-02 09:38:09', '10', '100200', 'Account Receivable', '30.0000', 'SALE/1706/00016', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('121', 'SALES', '36', '2017-06-02 09:38:09', '40', '410101', 'Income', '-10.0000', 'SALE/1706/00016', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('122', 'SALES', '36', '2017-06-02 09:38:09', '50', '500000', 'Cost of Goods Sold', '100.0000', 'SALE/1706/00016', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('123', 'SALES', '36', '2017-06-02 09:38:09', '10', '100430', 'Inventory', '-100.0000', 'SALE/1706/00016', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('124', 'SALES', '36', '2017-06-02 09:38:09', '40', '410101', 'Income', '-10.0000', 'SALE/1706/00016', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('125', 'SALES', '37', '2017-06-02 09:40:25', '60', '601206', 'Transportation', '-5.0000', 'SALE/1706/00017', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('126', 'SALES', '37', '2017-06-02 09:40:25', '10', '100200', 'Account Receivable', '505.0000', 'SALE/1706/00017', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('127', 'SALES', '37', '2017-06-02 09:40:25', '40', '410101', 'Income', '-500.0000', 'SALE/1706/00017', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('128', 'SALES', '0', '2017-06-02 09:44:21', '10', '100200', 'Account Receivable', '5.0000', 'SALE/1706/00018', 'RKS-Ta Kmao', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('129', 'SALES', '37', '2017-06-02 09:44:21', '40', '410101', 'Income', '0.0000', 'SALE/1706/00018', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('130', 'SALES', '37', '2017-06-02 09:44:21', '50', '500000', 'Cost of Goods Sold', '500.0000', 'SALE/1706/00018', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('131', 'SALES', '37', '2017-06-02 09:44:21', '10', '100430', 'Inventory', '-500.0000', 'SALE/1706/00018', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('132', 'SALES', '37', '2017-06-02 09:45:27', '40', '410101', 'Income', '0.0000', 'SALE/1706/00019', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('133', 'SALES', '37', '2017-06-02 09:45:27', '50', '500000', 'Cost of Goods Sold', '500.0000', 'SALE/1706/00019', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('134', 'SALES', '37', '2017-06-02 09:45:27', '10', '100430', 'Inventory', '-500.0000', 'SALE/1706/00019', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('135', 'SALES', '38', '2017-06-02 09:56:21', '10', '100200', 'Account Receivable', '30.0000', 'SALE/1706/00020', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('136', 'SALES', '38', '2017-06-02 09:56:21', '40', '410101', 'Income', '-30.0000', 'SALE/1706/00020', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('137', 'SALES', '39', '2017-06-02 09:59:57', '10', '100200', 'Account Receivable', '12.0000', 'SALE/1706/00021', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('138', 'SALES', '39', '2017-06-02 09:59:57', '40', '410101', 'Income', '-12.0000', 'SALE/1706/00021', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('139', 'SALES', '39', '2017-06-02 09:59:57', '50', '500000', 'Cost of Goods Sold', '100.0000', 'SALE/1706/00021', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('140', 'SALES', '39', '2017-06-02 09:59:57', '10', '100430', 'Inventory', '-100.0000', 'SALE/1706/00021', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('141', 'SALES', '40', '2017-06-02 10:02:01', '10', '100200', 'Account Receivable', '122.0000', 'SALE/1706/00022', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('142', 'SALES', '41', '2017-06-02 10:04:35', '10', '100200', 'Account Receivable', '122.0000', 'SALE/1706/00023', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('143', 'SALES', '42', '2017-06-02 10:08:34', '10', '100200', 'Account Receivable', '122.0000', 'SALE/1706/00024', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('144', 'SALES', '43', '2017-06-02 10:10:03', '10', '100200', 'Account Receivable', '122.0000', 'SALE/1706/00025', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('145', 'SALES', '44', '2017-06-02 10:11:10', '10', '100200', 'Account Receivable', '122.0000', 'SALE/1706/00026', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('146', 'SALES', '45', '2017-06-02 10:14:21', '60', '601206', 'Transportation', '-10.0000', 'SALE/1706/00027', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('147', 'SALES', '45', '2017-06-02 10:14:21', '10', '100200', 'Account Receivable', '30.0000', 'SALE/1706/00027', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('156', 'PURCHASES', '46', '2017-06-02 10:35:00', '20', '201100', 'Accounts Payable', '-48.0000', 'PO/1706/00003', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('157', 'PURCHASES', '46', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '24.0000', 'PO/1706/00003', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('158', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '24.0000', 'PO/1706/00003', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('159', 'PURCHASES', '46', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '19.0000', 'PO/1706/00003', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('160', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '19.0000', 'PO/1706/00003', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('175', 'PURCHASES', '47', '2017-06-02 10:54:00', '20', '201100', 'Accounts Payable', '-60.0000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('176', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.7000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('177', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.7000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('178', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '22.3000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('179', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '22.3000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('180', 'SALES', '48', '2017-06-02 11:03:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00028', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('181', 'SALES', '48', '2017-06-02 11:03:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('182', 'SALES', '48', '2017-06-02 11:03:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('183', 'SALES', '48', '2017-06-02 11:03:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('184', 'SALES', '49', '2017-06-02 11:03:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00028', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('185', 'SALES', '49', '2017-06-02 11:03:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('186', 'SALES', '49', '2017-06-02 11:03:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('187', 'SALES', '49', '2017-06-02 11:03:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('191', 'SALES', '51', '2017-06-02 11:03:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00028', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('192', 'SALES', '51', '2017-06-02 11:03:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('193', 'SALES', '51', '2017-06-02 11:03:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('194', 'SALES', '51', '2017-06-02 11:03:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00028', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('197', 'PURCHASES', '52', '2017-06-02 12:02:00', '20', '201100', 'Accounts Payable', '-70.0000', 'PO/1706/00008', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('198', 'PURCHASES', '52', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '33.1000', 'PO/1706/00008', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('199', 'PURCHASES', '52', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '26.9000', 'PO/1706/00008', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('200', 'SALES', '53', '2017-06-02 14:15:00', '10', '100200', 'Account Receivable', '170.0000', 'SALE/1706/00029', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('201', 'SALES', '53', '2017-06-02 14:15:00', '40', '410101', 'Income', '-60.0000', 'SALE/1706/00029', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('202', 'SALES', '53', '2017-06-02 14:15:00', '50', '500000', 'Cost of Goods Sold', '400.0000', 'SALE/1706/00029', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('203', 'SALES', '53', '2017-06-02 14:15:00', '10', '100430', 'Inventory', '-400.0000', 'SALE/1706/00029', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('204', 'SALES', '54', '2017-06-02 14:15:00', '10', '100200', 'Account Receivable', '170.0000', 'SALE/1706/00029', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('205', 'SALES', '54', '2017-06-02 14:15:00', '40', '410101', 'Income', '-60.0000', 'SALE/1706/00029', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('206', 'SALES', '54', '2017-06-02 14:15:00', '50', '500000', 'Cost of Goods Sold', '400.0000', 'SALE/1706/00029', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('207', 'SALES', '54', '2017-06-02 14:15:00', '10', '100430', 'Inventory', '-400.0000', 'SALE/1706/00029', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('208', 'SALES', '55', '2017-06-02 14:17:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00030', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('209', 'SALES', '55', '2017-06-02 14:17:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00030', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('210', 'SALES', '55', '2017-06-02 14:17:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00030', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('211', 'SALES', '55', '2017-06-02 14:17:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00030', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('212', 'SALES', '56', '2017-06-02 14:17:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00030', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('213', 'SALES', '56', '2017-06-02 14:17:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00030', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('214', 'SALES', '56', '2017-06-02 14:17:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00030', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('215', 'SALES', '56', '2017-06-02 14:17:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00030', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('216', 'SALES', '57', '2017-06-02 15:08:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00031', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('217', 'SALES', '57', '2017-06-02 15:08:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00031', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('218', 'SALES', '57', '2017-06-02 15:08:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00031', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('219', 'SALES', '57', '2017-06-02 15:08:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00031', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('224', 'SALES', '59', '2017-06-02 15:24:00', '10', '100200', 'Account Receivable', '-198.0000', 'RV/1706/00002', 'General Customer', '1', '1', null, '1', '0', '', null, null, null, null, null, null, 'payment', null);
INSERT INTO `erp_gl_trans` VALUES ('225', 'SALES', '59', '2017-06-02 15:24:00', '10', '100100', 'Cash', '198.0000', 'RV/1706/00002', 'General Customer', '1', '1', null, '1', '0', '', null, null, null, null, null, null, 'payment', null);
INSERT INTO `erp_gl_trans` VALUES ('226', 'SALES', '58', '2017-06-02 15:21:00', '40', '410102', 'Sale Discount', '60.0000', 'SALE/1706/00032', '', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('227', 'SALES', '58', '2017-06-02 15:21:00', '60', '601206', 'Transportation', '-20.0000', 'SALE/1706/00032', '', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('228', 'SALES', '58', '2017-06-02 15:21:00', '20', '201407', 'VAT Output', '-26.0000', 'SALE/1706/00032', '', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('229', 'SALES', '58', '2017-06-02 15:21:00', '10', '100200', 'Account Receivable', '88.0000', 'SALE/1706/00032', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('230', 'PURCHASES', '60', '2017-06-02 15:18:40', '20', '201100', 'Accounts Payable', '-901.0000', 'PO/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('231', 'PURCHASES', '60', '2017-06-02 15:18:40', '50', '500106', 'Purchase Discount', '-99.0000', 'PO/1706/00009', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('232', 'PURCHASES', '60', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '1000.0000', 'PO/1706/00009', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('233', 'SALES', '61', '2017-06-02 16:54:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00033', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('234', 'SALES', '61', '2017-06-02 16:54:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00033', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('235', 'SALES', '61', '2017-06-02 16:54:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00033', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('236', 'SALES', '61', '2017-06-02 16:54:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00033', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('237', 'SALES', '62', '2017-06-02 16:54:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00033', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('238', 'SALES', '62', '2017-06-02 16:54:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00033', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('239', 'SALES', '62', '2017-06-02 16:54:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00033', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('240', 'SALES', '62', '2017-06-02 16:54:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00033', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('241', 'SALES', '63', '2017-06-02 17:00:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00034', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('242', 'SALES', '63', '2017-06-02 17:00:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00034', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('243', 'SALES', '63', '2017-06-02 17:00:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00034', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('244', 'SALES', '63', '2017-06-02 17:00:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00034', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('245', 'SALES', '64', '2017-06-02 17:07:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00035', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('246', 'SALES', '64', '2017-06-02 17:07:00', '40', '410101', 'Income', '-2000.0000', 'SALE/1706/00035', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('247', 'SALES', '64', '2017-06-02 17:07:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00035', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('248', 'SALES', '64', '2017-06-02 17:07:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00035', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('249', 'SALES', '65', '2017-06-02 17:10:00', '60', '601206', 'Transportation', '-25.0000', 'SALE/1706/00036', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('250', 'SALES', '65', '2017-06-02 17:10:00', '10', '100200', 'Account Receivable', '425.0000', 'SALE/1706/00036', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('251', 'SALES', '65', '2017-06-02 17:10:00', '50', '500000', 'Cost of Goods Sold', '52.4205', 'SALE/1706/00036', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('252', 'SALES', '65', '2017-06-02 17:10:00', '10', '100430', 'Inventory', '-52.4205', 'SALE/1706/00036', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('253', 'SALES', '66', '2017-06-03 08:05:56', '10', '100200', 'Account Receivable', '100.0000', 'SALE/1706/00037', 'General Customer', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('254', 'SALES', '66', '2017-06-03 08:05:56', '40', '410101', 'Income', '-100.0000', 'SALE/1706/00037', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('255', 'SALES', '66', '2017-06-03 08:05:56', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00037', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('256', 'SALES', '66', '2017-06-03 08:05:56', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00037', '', '4', '3', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('257', 'SALES', '67', '2017-06-03 08:20:00', '40', '410102', 'Sale Discount', '2.2000', 'SALE/1706/00038', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('258', 'SALES', '67', '2017-06-03 08:20:00', '60', '601206', 'Transportation', '-4.0000', 'SALE/1706/00038', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('259', 'SALES', '67', '2017-06-03 08:20:00', '20', '201407', 'VAT Output', '-11.1800', 'SALE/1706/00038', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('260', 'SALES', '67', '2017-06-03 08:20:00', '10', '100200', 'Account Receivable', '122.9800', 'SALE/1706/00038', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('261', 'SALES', '67', '2017-06-03 08:20:00', '40', '410101', 'Income', '-60.0000', 'SALE/1706/00038', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('262', 'SALES', '67', '2017-06-03 08:20:00', '50', '500000', 'Cost of Goods Sold', '600.0000', 'SALE/1706/00038', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('263', 'SALES', '67', '2017-06-03 08:20:00', '10', '100430', 'Inventory', '-600.0000', 'SALE/1706/00038', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('264', 'SALES', '68', '2017-06-03 08:23:00', '40', '410102', 'Sale Discount', '0.0600', 'SALE/1706/00039', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('265', 'SALES', '68', '2017-06-03 08:23:00', '60', '601206', 'Transportation', '-2.0000', 'SALE/1706/00039', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('266', 'SALES', '68', '2017-06-03 08:23:00', '20', '201407', 'VAT Output', '-0.7940', 'SALE/1706/00039', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('267', 'SALES', '68', '2017-06-03 08:23:00', '10', '100200', 'Account Receivable', '8.7340', 'SALE/1706/00039', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('268', 'SALES', '68', '2017-06-03 08:23:00', '40', '410101', 'Income', '-3.0000', 'SALE/1706/00039', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('269', 'SALES', '68', '2017-06-03 08:23:00', '50', '500000', 'Cost of Goods Sold', '100.0000', 'SALE/1706/00039', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('270', 'SALES', '68', '2017-06-03 08:23:00', '10', '100430', 'Inventory', '-100.0000', 'SALE/1706/00039', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('274', 'SALES', '70', '2017-06-03 08:50:00', '40', '410102', 'Sale Discount', '3.1200', 'SALE/1706/00040', '&lt;p&gt;sss&lt;&sol;p&gt;', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('275', 'SALES', '70', '2017-06-03 08:50:00', '60', '601206', 'Transportation', '-4.0000', 'SALE/1706/00040', '&lt;p&gt;sss&lt;&sol;p&gt;', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('276', 'SALES', '70', '2017-06-03 08:50:00', '20', '201407', 'VAT Output', '-15.6680', 'SALE/1706/00040', '&lt;p&gt;sss&lt;&sol;p&gt;', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('277', 'SALES', '70', '2017-06-03 08:50:00', '10', '100200', 'Account Receivable', '172.3480', 'SALE/1706/00040', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('278', 'SALES', '70', '2017-06-03 08:50:00', '40', '410101', 'Income', '-48.0000', 'SALE/1706/00040', '&lt;p&gt;sss&lt;&sol;p&gt;', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('279', 'SALES', '70', '2017-06-03 08:50:00', '40', '410101', 'Income', '-107.8000', 'SALE/1706/00040', '&lt;p&gt;sss&lt;&sol;p&gt;', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('280', 'SALES', '70', '2017-06-03 08:50:00', '50', '500000', 'Cost of Goods Sold', '1000.0000', 'SALE/1706/00040', '&lt;p&gt;sss&lt;&sol;p&gt;', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('281', 'SALES', '70', '2017-06-03 08:50:00', '10', '100430', 'Inventory', '-1000.0000', 'SALE/1706/00040', '&lt;p&gt;sss&lt;&sol;p&gt;', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('284', 'PURCHASES', '71', '2017-06-03 09:06:00', '20', '201100', 'Accounts Payable', '-1990.0000', 'PO/1706/00010', '', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('285', 'PURCHASES', '71', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '900.0000', 'PO/1706/00010', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('286', 'PURCHASES', '71', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '1080.0000', 'PO/1706/00010', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('287', 'SALES', '72', '2017-06-03 10:01:00', '10', '100200', 'Account Receivable', '20.0000', 'qqqq123', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('288', 'SALES', '73', '2017-06-03 10:01:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00041', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('289', 'SALES', '74', '2017-06-03 10:01:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00042', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('290', 'SALES', '74', '2017-06-03 10:01:00', '40', '410101', 'Income', '-10.0000', 'SALE/1706/00042', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('291', 'SALES', '74', '2017-06-03 10:01:00', '50', '500000', 'Cost of Goods Sold', '100.0000', 'SALE/1706/00042', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('292', 'SALES', '74', '2017-06-03 10:01:00', '10', '100430', 'Inventory', '-100.0000', 'SALE/1706/00042', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('293', 'SALES', '75', '2017-06-03 10:06:00', '10', '100200', 'Account Receivable', '21.0000', 'sss001', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('294', 'SALES', '75', '2017-06-03 10:06:00', '40', '410101', 'Income', '-11.0000', 'sss001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('295', 'SALES', '75', '2017-06-03 10:06:00', '40', '410101', 'Income', '-10.0000', 'sss001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('296', 'SALES', '75', '2017-06-03 10:06:00', '50', '500000', 'Cost of Goods Sold', '100.0000', 'sss001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('297', 'SALES', '75', '2017-06-03 10:06:00', '10', '100430', 'Inventory', '-100.0000', 'sss001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('298', 'SALES', '76', '2017-06-03 10:08:00', '10', '100200', 'Account Receivable', '10.0000', 'sdsfsdfdsf', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('299', 'SALES', '76', '2017-06-03 10:08:00', '40', '410101', 'Income', '-10.0000', 'sdsfsdfdsf', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('300', 'SALES', '76', '2017-06-03 10:08:00', '50', '500000', 'Cost of Goods Sold', '100.0000', 'sdsfsdfdsf', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('301', 'SALES', '76', '2017-06-03 10:08:00', '10', '100430', 'Inventory', '-100.0000', 'sdsfsdfdsf', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('302', 'SALES', '77', '2017-06-03 10:09:00', '10', '100200', 'Account Receivable', '10.0000', 'sdsfsdfdsf1', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('303', 'SALES', '77', '2017-06-03 10:09:00', '40', '410101', 'Income', '-10.0000', 'sdsfsdfdsf1', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('304', 'SALES', '77', '2017-06-03 10:09:00', '50', '500000', 'Cost of Goods Sold', '100.0000', 'sdsfsdfdsf1', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('305', 'SALES', '77', '2017-06-03 10:09:00', '10', '100430', 'Inventory', '-100.0000', 'sdsfsdfdsf1', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('306', 'SALES', '77', '2017-06-03 10:15:15', '40', '410101', 'Income', '-8.0000', 'SALE/POS/1706/00001', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('307', 'SALES', '77', '2017-06-03 10:15:15', '10', '100102', 'Cash on Hand', '8.0000', 'RV/1706/00003', '', '1', '1', null, '1', '0', '', null, null, null, null, null, null, 'payment', null);
INSERT INTO `erp_gl_trans` VALUES ('308', 'SALES', '78', '2017-06-03 10:19:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00043', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('309', 'SALES', '79', '2017-06-03 10:22:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00044', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('310', 'SALES', '79', '2017-06-03 10:22:00', '40', '410101', 'Income', '-10.0000', 'SALE/1706/00044', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('311', 'SALES', '79', '2017-06-03 10:22:00', '40', '410101', 'Income', '-10.0000', 'SALE/1706/00044', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('312', 'SALES', '79', '2017-06-03 10:22:00', '50', '500000', 'Cost of Goods Sold', '100.0000', 'SALE/1706/00044', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('313', 'SALES', '79', '2017-06-03 10:22:00', '10', '100430', 'Inventory', '-100.0000', 'SALE/1706/00044', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('314', 'SALES', '80', '2017-06-03 10:25:00', '10', '100200', 'Account Receivable', '50.0000', 'sss002', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('315', 'SALES', '80', '2017-06-03 10:25:00', '40', '410101', 'Income', '0.0000', 'sss002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('316', 'SALES', '80', '2017-06-03 10:25:00', '40', '410101', 'Income', '-50.0000', 'sss002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('317', 'SALES', '80', '2017-06-03 10:25:00', '50', '500000', 'Cost of Goods Sold', '500.0000', 'sss002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('318', 'SALES', '80', '2017-06-03 10:25:00', '10', '100430', 'Inventory', '-500.0000', 'sss002', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('319', 'SALES', '81', '2017-06-03 10:19:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00043', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('320', 'SALES', '82', '2017-06-03 10:55:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00045', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('321', 'SALES', '83', '2017-06-03 10:55:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00045', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('322', 'SALES', '84', '2017-06-03 11:02:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00046', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('323', 'SALES', '85', '2017-06-03 11:02:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00046', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('324', 'SALES', '86', '2017-06-03 11:02:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00046', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('325', 'PURCHASES', '87', '2017-06-03 11:07:43', '20', '201100', 'Accounts Payable', '-235.0000', 'PO/1706/00011', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('326', 'PURCHASES', '87', '2017-06-03 00:00:00', '10', '100441', 'VAT Input', '0.0000', 'PO/1706/00011', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('327', 'PURCHASES', '87', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '100.0000', 'PO/1706/00011', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('328', 'PURCHASES', '87', '2017-06-03 00:00:00', '10', '100441', 'VAT Input', '0.0000', 'PO/1706/00011', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('329', 'PURCHASES', '87', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '71.4706', 'PO/1706/00011', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('330', 'PURCHASES', '87', '2017-06-03 00:00:00', '10', '100441', 'VAT Input', '0.0000', 'PO/1706/00011', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('331', 'PURCHASES', '87', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '63.5294', 'PO/1706/00011', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('332', 'SALES', '88', '2017-06-03 11:02:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00046', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('338', 'PURCHASES', '90', '2017-06-03 11:41:21', '20', '201100', 'Accounts Payable', '-3250.0000', 'PO/1706/00013', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('339', 'PURCHASES', '90', '2017-06-03 00:00:00', '10', '100441', 'VAT Input', '200.0000', 'PO/1706/00013', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('340', 'PURCHASES', '90', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '1960.3175', 'PO/1706/00013', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('341', 'PURCHASES', '90', '2017-06-03 00:00:00', '10', '100441', 'VAT Input', '100.0000', 'PO/1706/00013', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('342', 'PURCHASES', '90', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '980.1587', 'PO/1706/00013', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('343', 'SALES', '91', '2017-06-03 11:50:00', '10', '100200', 'Account Receivable', '160.0000', 'SALE/1706/00047', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('344', 'SALES', '92', '2017-06-03 11:02:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00046', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('345', 'SALES', '93', '2017-06-03 11:53:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00048', 'ABC Company', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('346', 'SALES', '93', '2017-06-03 11:53:00', '40', '410101', 'Income', '-1000.0000', 'SALE/1706/00048', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('349', 'SALES', '94', '2017-06-03 11:53:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00048', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('350', 'SALES', '95', '2017-06-03 11:50:00', '10', '100200', 'Account Receivable', '160.0000', 'SALE/1706/00048', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('351', 'SALES', '96', '2017-06-03 11:53:00', '10', '100200', 'Account Receivable', '20.0000', 'SALE/1706/00048', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('352', 'SALES', '97', '2017-06-03 11:50:00', '10', '100200', 'Account Receivable', '160.0000', 'SALE/1706/00049', 'General Customer', '4', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('353', 'SALES', '98', '2017-06-03 11:53:00', '10', '100200', 'Account Receivable', '2000.0000', 'SALE/1706/00049', 'ABC Company', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('354', 'SALES', '98', '2017-06-03 11:53:00', '40', '410101', 'Income', '-1000.0000', 'SALE/1706/00049', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('355', 'SALES', '99', '2017-06-03 11:55:00', '10', '100200', 'Account Receivable', '22.5000', 'SALE/1706/00050', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('356', 'SALES', '99', '2017-06-03 11:55:00', '40', '410101', 'Income', '-5.0000', 'SALE/1706/00050', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('357', 'DELIVERY', '100', '2017-06-03 11:48:20', '50', '500000', 'Cost of Goods Sold', '6.0000', 'DO/1706/00005', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('358', 'DELIVERY', '100', '2017-06-03 11:48:20', '10', '100430', 'Inventory', '-6.0000', 'DO/1706/00005', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('359', 'DELIVERY', '100', '2017-06-03 11:48:20', '50', '500000', 'Cost of Goods Sold', '200.0000', 'DO/1706/00005', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('360', 'DELIVERY', '100', '2017-06-03 11:48:20', '10', '100430', 'Inventory', '-200.0000', 'DO/1706/00005', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('369', 'DELIVERY', '101', '2017-06-03 11:49:00', '50', '500000', 'Cost of Goods Sold', '0.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('370', 'DELIVERY', '101', '2017-06-03 11:49:00', '10', '100430', 'Inventory', '0.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('371', 'DELIVERY', '101', '2017-06-03 11:49:00', '50', '500000', 'Cost of Goods Sold', '0.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('372', 'DELIVERY', '101', '2017-06-03 11:49:00', '10', '100430', 'Inventory', '0.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('375', 'DELIVERY', '103', '2017-06-03 11:57:30', '50', '500000', 'Cost of Goods Sold', '24.0000', 'DO/1706/00009', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('376', 'DELIVERY', '103', '2017-06-03 11:57:30', '10', '100430', 'Inventory', '-24.0000', 'DO/1706/00009', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('377', 'DELIVERY', '103', '2017-06-03 11:57:30', '50', '500000', 'Cost of Goods Sold', '6.0000', 'DO/1706/00009', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('378', 'DELIVERY', '103', '2017-06-03 11:57:30', '10', '100430', 'Inventory', '-6.0000', 'DO/1706/00009', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('379', 'SALES', '102', '2017-06-03 12:04:00', '10', '100200', 'Account Receivable', '50.0000', 'SALE/1706/00051', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('380', 'SALES', '103', '2017-06-03 12:04:00', '40', '410101', 'Income', '-15.0000', 'SALE/1706/00051', '', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('381', 'PURCHASES', '104', '2017-06-03 12:07:00', '20', '201100', 'Accounts Payable', '-85.0000', 'PO/1706/00012', '', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('382', 'PURCHASES', '104', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '15.0000', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);
INSERT INTO `erp_gl_trans` VALUES ('383', 'PURCHASES', '104', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '20.0000', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for erp_gl_trans_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_gl_trans_audit`;
CREATE TABLE `erp_gl_trans_audit` (
  `tran_id` int(11) NOT NULL,
  `tran_type` varchar(20) DEFAULT '0',
  `tran_no` bigint(20) NOT NULL DEFAULT '1',
  `tran_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `sectionid` int(11) DEFAULT '0',
  `account_code` int(19) DEFAULT '0',
  `narrative` varchar(100) DEFAULT '',
  `amount` decimal(25,4) DEFAULT '0.0000',
  `reference_no` varchar(55) NOT NULL DEFAULT '',
  `description` varchar(250) DEFAULT '',
  `biller_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bank` tinyint(3) DEFAULT '0',
  `gov_tax` tinyint(3) DEFAULT '0',
  `reference_gov_tax` varchar(55) DEFAULT '',
  `people_id` int(11) DEFAULT NULL,
  `invoice_ref` varchar(55) DEFAULT NULL,
  `ref_type` int(11) DEFAULT NULL,
  `created_name` varchar(100) DEFAULT NULL,
  `created_type` varchar(10) DEFAULT NULL,
  `people` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status_tax` varchar(50) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `Account` (`account_code`) USING BTREE,
  KEY `TranDate` (`tran_date`) USING BTREE,
  KEY `TypeNo` (`tran_no`) USING BTREE,
  KEY `Type_and_Number` (`tran_type`,`tran_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_gl_trans_audit
-- ----------------------------
INSERT INTO `erp_gl_trans_audit` VALUES ('117', 'SALES', '35', '2017-06-02 08:36:10', '10', '100200', 'Account Receivable', '220.0000', 'SALE/1706/00015', 'General Customer', '5', '5', null, '0', '0', '', null, null, null, null, null, null, null, null, '1', '0', '2017-06-02 09:05:35', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('5', 'PURCHASES', '3', '2017-06-01 19:23:34', '20', '201100', 'Accounts Payable', '-48.0000', 'PO/1706/00003', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '2', '0', '2017-06-02 10:19:19', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('6', 'PURCHASES', '3', '2017-06-01 00:00:00', '10', '100430', 'Inventory', '26.5000', 'PO/1706/00003', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '3', '0', '2017-06-02 10:19:19', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('7', 'PURCHASES', '3', '2017-06-01 00:00:00', '10', '100430', 'Inventory', '21.5000', 'PO/1706/00003', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '4', '0', '2017-06-02 10:19:19', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('148', 'PURCHASES', '45', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '19.0000', 'PO/1706/00003', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '5', '0', '2017-06-02 10:19:19', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('149', 'PURCHASES', '46', '2017-06-02 09:53:00', '20', '201100', 'Accounts Payable', '-48.0000', 'PO/1706/00003', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '6', '0', '2017-06-02 10:24:12', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('150', 'PURCHASES', '46', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '19.0000', 'PO/1706/00003', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '7', '0', '2017-06-02 10:24:12', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('153', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '19.0000', 'PO/1706/00003', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '8', '0', '2017-06-02 10:27:37', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('155', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '24.0000', 'PO/1706/00003', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '9', '0', '2017-06-02 10:27:37', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('151', 'PURCHASES', '46', '2017-06-02 09:53:00', '20', '201100', 'Accounts Payable', '-48.0000', 'PO/1706/00003', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '10', '0', '2017-06-02 10:27:37', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('152', 'PURCHASES', '46', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '19.0000', 'PO/1706/00003', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '11', '0', '2017-06-02 10:27:37', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('154', 'PURCHASES', '46', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '24.0000', 'PO/1706/00003', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '12', '0', '2017-06-02 10:27:37', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('163', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.3000', 'PO/1706/00007', '', '5', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '13', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('165', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '32.7000', 'PO/1706/00007', '', '5', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '14', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('167', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.7000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '15', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('169', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '22.3000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '16', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('161', 'PURCHASES', '47', '2017-06-02 10:38:50', '20', '201100', 'Accounts Payable', '-60.0000', 'PO/1706/00007', '', '5', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '17', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('162', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.3000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '18', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('164', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '32.7000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '19', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('166', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.7000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '20', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('168', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '22.3000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '21', '0', '2017-06-02 10:44:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('172', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '22.3000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '22', '0', '2017-06-02 10:45:14', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('174', 'PURCHASES', '0', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.7000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '23', '0', '2017-06-02 10:45:14', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('170', 'PURCHASES', '47', '2017-06-02 10:53:00', '20', '201100', 'Accounts Payable', '-60.0000', 'PO/1706/00007', '', '5', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '24', '0', '2017-06-02 10:45:14', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('171', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '22.3000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '25', '0', '2017-06-02 10:45:14', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('173', 'PURCHASES', '47', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '27.7000', 'PO/1706/00007', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '26', '0', '2017-06-02 10:45:14', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('188', 'PURCHASES', '50', '2017-06-02 10:57:42', '20', '201100', 'Accounts Payable', '-70.0000', 'PO/1706/00008', '', '5', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '27', '0', '2017-06-02 11:53:18', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('189', 'PURCHASES', '50', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '38.1000', 'PO/1706/00008', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '28', '0', '2017-06-02 11:53:18', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('190', 'PURCHASES', '50', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '31.9000', 'PO/1706/00008', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '29', '0', '2017-06-02 11:53:18', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('195', 'PURCHASES', '51', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '26.9000', 'PO/1706/00008', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '30', '0', '2017-06-02 11:53:18', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('196', 'PURCHASES', '51', '2017-06-02 00:00:00', '10', '100430', 'Inventory', '33.1000', 'PO/1706/00008', null, '5', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '31', '0', '2017-06-02 11:53:18', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('220', 'SALES', '58', '2017-06-02 15:21:00', '40', '410102', 'Sale Discount', '40.0000', 'SALE/1706/00032', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '32', '0', '2017-06-02 15:18:07', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('221', 'SALES', '58', '2017-06-02 15:21:00', '60', '601206', 'Transportation', '-20.0000', 'SALE/1706/00032', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '33', '0', '2017-06-02 15:18:07', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('222', 'SALES', '58', '2017-06-02 15:21:00', '20', '201407', 'VAT Output', '-18.0000', 'SALE/1706/00032', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '34', '0', '2017-06-02 15:18:07', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('223', 'SALES', '58', '2017-06-02 15:21:00', '10', '100200', 'Account Receivable', '198.0000', 'SALE/1706/00032', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '35', '0', '2017-06-02 15:18:07', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('271', 'PURCHASES', '69', '2017-06-03 08:23:29', '20', '201100', 'Accounts Payable', '-1990.0000', 'PO/1706/00010', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '36', '0', '2017-06-03 09:21:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('272', 'PURCHASES', '69', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '945.4545', 'PO/1706/00010', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '37', '0', '2017-06-03 09:21:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('273', 'PURCHASES', '69', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '1134.5455', 'PO/1706/00010', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '38', '0', '2017-06-03 09:21:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('282', 'PURCHASES', '70', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '1188.0000', 'PO/1706/00010', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '39', '0', '2017-06-03 09:21:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('283', 'PURCHASES', '70', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '990.0000', 'PO/1706/00010', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '40', '0', '2017-06-03 09:21:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('361', 'DELIVERY', '101', '2017-06-03 11:49:15', '50', '500000', 'Cost of Goods Sold', '9.0000', 'DO/1706/00007', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '41', '0', '2017-06-03 11:50:53', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('362', 'DELIVERY', '101', '2017-06-03 11:49:15', '10', '100430', 'Inventory', '-9.0000', 'DO/1706/00007', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '42', '0', '2017-06-03 11:50:53', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('363', 'DELIVERY', '101', '2017-06-03 11:49:15', '50', '500000', 'Cost of Goods Sold', '300.0000', 'DO/1706/00007', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '43', '0', '2017-06-03 11:50:53', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('364', 'DELIVERY', '101', '2017-06-03 11:49:15', '10', '100430', 'Inventory', '-300.0000', 'DO/1706/00007', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '44', '0', '2017-06-03 11:50:53', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('365', 'DELIVERY', '101', '2017-06-03 11:49:00', '50', '500000', 'Cost of Goods Sold', '9.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '45', '0', '2017-06-03 11:51:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('366', 'DELIVERY', '101', '2017-06-03 11:49:00', '10', '100430', 'Inventory', '-9.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '46', '0', '2017-06-03 11:51:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('367', 'DELIVERY', '101', '2017-06-03 11:49:00', '50', '500000', 'Cost of Goods Sold', '300.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '47', '0', '2017-06-03 11:51:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('368', 'DELIVERY', '101', '2017-06-03 11:49:00', '10', '100430', 'Inventory', '-300.0000', 'DO/1706/00007', 'General Customer', '1', '1', '1', '0', '0', '', null, null, null, null, null, null, null, null, '48', '0', '2017-06-03 11:51:39', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('373', 'SALES', '102', '2017-06-03 12:04:00', '10', '100200', 'Account Receivable', '32.5000', 'SALE/1706/00051', 'General Customer', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '49', '0', '2017-06-03 11:58:10', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('374', 'SALES', '102', '2017-06-03 12:04:00', '40', '410101', 'Income', '-15.0000', 'SALE/1706/00051', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '50', '0', '2017-06-03 11:58:10', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('333', 'PURCHASES', '89', '2017-06-03 11:30:52', '20', '201100', 'Accounts Payable', '-85.0000', 'PO/1706/00012', '', '1', '1', null, '0', '0', '', null, null, null, null, null, null, null, null, '51', '0', '2017-06-03 11:59:09', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('334', 'PURCHASES', '89', '2017-06-03 00:00:00', '10', '100441', 'VAT Input', '0.0000', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '52', '0', '2017-06-03 11:59:09', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('335', 'PURCHASES', '89', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '36.4286', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '53', '0', '2017-06-03 11:59:09', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('336', 'PURCHASES', '89', '2017-06-03 00:00:00', '10', '100441', 'VAT Input', '0.0000', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '54', '0', '2017-06-03 11:59:09', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('337', 'PURCHASES', '89', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '48.5714', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '55', '0', '2017-06-03 11:59:09', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('347', 'PURCHASES', '93', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '20.0000', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '56', '0', '2017-06-03 11:59:09', 'DELETED');
INSERT INTO `erp_gl_trans_audit` VALUES ('348', 'PURCHASES', '93', '2017-06-03 00:00:00', '10', '100430', 'Inventory', '15.0000', 'PO/1706/00012', null, '1', null, null, '0', '0', '', null, null, null, null, null, null, null, null, '57', '0', '2017-06-03 11:59:09', 'DELETED');

-- ----------------------------
-- Table structure for erp_groups
-- ----------------------------
DROP TABLE IF EXISTS `erp_groups`;
CREATE TABLE `erp_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_groups
-- ----------------------------
INSERT INTO `erp_groups` VALUES ('1', 'owner', 'Owner');
INSERT INTO `erp_groups` VALUES ('2', 'admin', 'Administrator');
INSERT INTO `erp_groups` VALUES ('3', 'customer', 'Customer');
INSERT INTO `erp_groups` VALUES ('4', 'supplier', 'Supplier');
INSERT INTO `erp_groups` VALUES ('5', 'cashier', 'Cashier');
INSERT INTO `erp_groups` VALUES ('6', 'stock', 'Stocker');
INSERT INTO `erp_groups` VALUES ('7', 'manager', 'Manager');
INSERT INTO `erp_groups` VALUES ('8', 'sale_branch', 'sale_branch');
INSERT INTO `erp_groups` VALUES ('9', 'stock_office', 'stock_office');
INSERT INTO `erp_groups` VALUES ('10', 'sale_office', 'sale_office');

-- ----------------------------
-- Table structure for erp_group_areas
-- ----------------------------
DROP TABLE IF EXISTS `erp_group_areas`;
CREATE TABLE `erp_group_areas` (
  `areas_g_code` int(3) NOT NULL AUTO_INCREMENT,
  `areas_group` varchar(100) DEFAULT '',
  PRIMARY KEY (`areas_g_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_group_areas
-- ----------------------------

-- ----------------------------
-- Table structure for erp_inventory_valuation_details
-- ----------------------------
DROP TABLE IF EXISTS `erp_inventory_valuation_details`;
CREATE TABLE `erp_inventory_valuation_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `biller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `quantity` decimal(15,4) DEFAULT NULL,
  `cost` decimal(15,4) DEFAULT NULL,
  `qty_on_hand` decimal(15,4) DEFAULT NULL,
  `avg_cost` decimal(15,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `field_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_inventory_valuation_details
-- ----------------------------
INSERT INTO `erp_inventory_valuation_details` VALUES ('1', '1', '4', 'CAM-0001', 'Cambodia', '1', null, '1', 'PO/1706/00001', 'PURCHASE', '2017-06-01 19:09:36', 'General Supplier', '10.0000', '0.0000', '0.0000', '0.0000', '1', null, null, '1');
INSERT INTO `erp_inventory_valuation_details` VALUES ('2', '1', '4', 'CAM-0001', 'Cambodia', '1', null, '1', 'PO/1706/00002', 'PURCHASE', '2017-06-01 19:10:22', 'General Supplier', '5.0000', '100.0000', '10.0000', '100.0000', '1', null, null, '2');
INSERT INTO `erp_inventory_valuation_details` VALUES ('8', '1', '4', 'CAM-0001', 'Cambodia', '1', null, '1', 'PO/1706/00005', 'PURCHASE', '2017-06-01 20:35:31', 'General Supplier', '10.0000', '100.0000', '0.0000', '100.0000', '1', null, null, '9');
INSERT INTO `erp_inventory_valuation_details` VALUES ('9', '1', '4', 'CAM-0001', 'Cambodia', '1', null, '1', 'PO/1706/00006', 'PURCHASE', '2017-06-01 20:35:45', 'General Supplier', '5.0000', '100.0000', '10.0000', '100.0000', '1', null, null, '10');
INSERT INTO `erp_inventory_valuation_details` VALUES ('12', '1', '5', '01KD', 'KAKADA_01', '3', null, '2', 'TR/1706/00002', 'TRANSFER', '2017-05-27 19:42:00', null, '-50.0000', '20.0000', '100.0000', '20.0000', '1', null, null, '2');
INSERT INTO `erp_inventory_valuation_details` VALUES ('13', '1', '5', '01KD', 'KAKADA_01', '3', null, '4', 'TR/1706/00001', 'TRANSFER', '2017-06-01 20:58:06', null, '0.0000', '20.0000', '100.0000', '20.0000', '4', null, null, '1');
INSERT INTO `erp_inventory_valuation_details` VALUES ('14', '1', '2', 'RG-001', 'Return Group 1', '2', null, '1', 'PO/1706/00003', 'PURCHASE', '2017-06-01 19:23:34', 'General Supplier', '10.0000', '3.0000', '9.0000', '3.0000', '1', null, null, '3');
INSERT INTO `erp_inventory_valuation_details` VALUES ('15', '1', '3', 'RG-002', 'Return Group 2', '2', null, '1', 'PO/1706/00003', 'PURCHASE', '2017-06-01 19:23:34', 'General Supplier', '10.0000', '2.0000', '10.0000', '2.0000', '1', null, null, '4');
INSERT INTO `erp_inventory_valuation_details` VALUES ('16', '1', '5', '01KD', 'KAKADA_01', '3', null, '4', 'TR/1706/00003', 'TRANSFER', '2017-06-02 08:13:57', null, '-50.0000', '20.0000', '100.0000', '20.0000', '4', null, null, '3');
INSERT INTO `erp_inventory_valuation_details` VALUES ('17', '4', '5', '01KD', 'KAKADA_01', '3', null, '2', 'PO/1706/00004', 'PURCHASE', '2017-06-01 20:34:38', 'General Supplier', '0.0000', '20.0000', '100.0000', '20.0000', '4', null, null, '8');
INSERT INTO `erp_inventory_valuation_details` VALUES ('18', '5', '3', 'RG-002', 'Return Group 2', '2', null, '1', 'PO/1706/00003', 'PURCHASE', '2017-06-02 09:53:00', 'General Supplier', '10.0000', '2.0000', '10.0000', '2.0000', '1', '1', '2017-06-02 10:24:12', '31');
INSERT INTO `erp_inventory_valuation_details` VALUES ('19', '5', '2', 'RG-001', 'Return Group 1', '2', null, '1', 'PO/1706/00003', 'PURCHASE', '2017-06-02 09:53:00', 'General Supplier', '10.0000', '3.0000', '9.0000', '3.0000', '1', '1', '2017-06-02 10:24:12', '32');
INSERT INTO `erp_inventory_valuation_details` VALUES ('20', '5', '2', 'RG-001', 'Return Group 1', '2', null, '1', 'PO/1706/00003', 'PURCHASE', '2017-06-02 10:35:00', 'General Supplier', '10.0000', '3.0000', '9.0000', '3.0000', '1', '1', '2017-06-02 10:27:37', '33');
INSERT INTO `erp_inventory_valuation_details` VALUES ('21', '5', '3', 'RG-002', 'Return Group 2', '2', null, '1', 'PO/1706/00003', 'PURCHASE', '2017-06-02 10:35:00', 'General Supplier', '10.0000', '2.0000', '10.0000', '2.0000', '1', '1', '2017-06-02 10:27:37', '34');
INSERT INTO `erp_inventory_valuation_details` VALUES ('22', '5', '3', 'RG-002', 'Return Group 2', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:38:50', 'General Supplier', '10.0000', '2.0000', '10.0000', '2.0000', '1', null, null, '35');
INSERT INTO `erp_inventory_valuation_details` VALUES ('23', '5', '2', 'RG-001', 'Return Group 1', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:38:50', 'General Supplier', '10.0000', '3.0000', '9.0000', '3.0000', '1', null, null, '36');
INSERT INTO `erp_inventory_valuation_details` VALUES ('24', '5', '2', 'RG-001', 'Return Group 1', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:52:00', 'General Supplier', '10.0000', '3.0000', '19.0000', '3.0000', '1', '1', '2017-06-02 10:44:08', '37');
INSERT INTO `erp_inventory_valuation_details` VALUES ('25', '5', '3', 'RG-002', 'Return Group 2', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:52:00', 'General Supplier', '10.0000', '2.0000', '20.0000', '2.0000', '1', '1', '2017-06-02 10:44:08', '38');
INSERT INTO `erp_inventory_valuation_details` VALUES ('26', '5', '3', 'RG-002', 'Return Group 2', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:53:00', 'General Supplier', '10.0000', '2.0000', '20.0000', '2.0000', '1', '1', '2017-06-02 10:44:39', '39');
INSERT INTO `erp_inventory_valuation_details` VALUES ('27', '5', '2', 'RG-001', 'Return Group 1', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:53:00', 'General Supplier', '10.0000', '3.0000', '19.0000', '3.0000', '1', '1', '2017-06-02 10:44:39', '40');
INSERT INTO `erp_inventory_valuation_details` VALUES ('28', '5', '2', 'RG-001', 'Return Group 1', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:54:00', 'General Supplier', '10.0000', '3.0000', '19.0000', '3.0000', '1', '1', '2017-06-02 10:45:14', '41');
INSERT INTO `erp_inventory_valuation_details` VALUES ('29', '5', '3', 'RG-002', 'Return Group 2', '2', null, '4', 'PO/1706/00007', 'PURCHASE', '2017-06-02 10:54:00', 'General Supplier', '10.0000', '3.0000', '20.0000', '3.0000', '1', '1', '2017-06-02 10:45:14', '42');
INSERT INTO `erp_inventory_valuation_details` VALUES ('30', '5', '2', 'RG-001', 'Return Group 1', '2', null, '4', 'PO/1706/00008', 'PURCHASE', '2017-06-02 10:57:42', 'General Supplier', '10.0000', '3.0000', '19.0000', '3.0000', '1', null, null, '43');
INSERT INTO `erp_inventory_valuation_details` VALUES ('31', '5', '3', 'RG-002', 'Return Group 2', '2', null, '4', 'PO/1706/00008', 'PURCHASE', '2017-06-02 10:57:42', 'General Supplier', '10.0000', '3.0000', '20.0000', '3.0000', '1', null, null, '44');
INSERT INTO `erp_inventory_valuation_details` VALUES ('32', '5', '3', 'RG-002', 'Return Group 2', '2', null, '4', 'PO/1706/00008', 'PURCHASE', '2017-06-02 11:37:00', 'General Supplier', '10.0000', '3.0000', '30.0000', '3.0000', '1', '1', '2017-06-02 11:30:27', '45');
INSERT INTO `erp_inventory_valuation_details` VALUES ('33', '5', '2', 'RG-001', 'Return Group 1', '2', null, '4', 'PO/1706/00008', 'PURCHASE', '2017-06-02 11:37:00', 'General Supplier', '10.0000', '3.0000', '29.0000', '3.0000', '1', '1', '2017-06-02 11:30:27', '46');
INSERT INTO `erp_inventory_valuation_details` VALUES ('34', '5', '2', 'RG-001', 'Return Group 1', '2', null, '4', 'PO/1706/00008', 'PURCHASE', '2017-06-02 12:02:00', 'General Supplier', '10.0000', '3.0000', '29.0000', '3.0000', '1', '1', '2017-06-02 11:53:18', '47');
INSERT INTO `erp_inventory_valuation_details` VALUES ('35', '5', '3', 'RG-002', 'Return Group 2', '2', null, '4', 'PO/1706/00008', 'PURCHASE', '2017-06-02 12:02:00', 'General Supplier', '10.0000', '3.0000', '30.0000', '3.0000', '1', '1', '2017-06-02 11:53:18', '48');
INSERT INTO `erp_inventory_valuation_details` VALUES ('36', '1', '7', 'RG-003', 'Return Group 3', '2', null, '1', 'PO/1706/00009', 'PURCHASE', '2017-06-02 15:18:40', 'General Supplier', '10.0000', '0.0000', '0.0000', '0.0000', '1', null, null, '58');
INSERT INTO `erp_inventory_valuation_details` VALUES ('37', '1', '8', 'RG-004', 'Return Group 4', '2', null, '1', 'PO/1706/00010', 'PURCHASE', '2017-06-03 08:23:29', 'General Supplier', '10.0000', '0.0000', '0.0000', '0.0000', '1', null, null, '85');
INSERT INTO `erp_inventory_valuation_details` VALUES ('38', '1', '11', 'RG-005', 'Return Group 5', '2', null, '1', 'PO/1706/00010', 'PURCHASE', '2017-06-03 08:23:29', 'General Supplier', '10.0000', '0.0000', '0.0000', '0.0000', '1', null, null, '86');
INSERT INTO `erp_inventory_valuation_details` VALUES ('39', '1', '11', 'RG-005', 'Return Group 5', '2', null, '1', 'PO/1706/00010', 'PURCHASE', '2017-06-03 08:54:00', 'General Supplier', '10.0000', '109.0000', '10.0000', '109.0000', '1', '1', '2017-06-03 08:53:26', '89');
INSERT INTO `erp_inventory_valuation_details` VALUES ('40', '1', '8', 'RG-004', 'Return Group 4', '2', null, '1', 'PO/1706/00010', 'PURCHASE', '2017-06-03 08:54:00', 'General Supplier', '10.0000', '90.0000', '10.0000', '90.0000', '1', '1', '2017-06-03 08:53:26', '90');
INSERT INTO `erp_inventory_valuation_details` VALUES ('41', '1', '8', 'RG-004', 'Return Group 4', '2', null, '1', 'PO/1706/00010', 'PURCHASE', '2017-06-03 09:06:00', 'General Supplier', '10.0000', '90.0000', '10.0000', '90.0000', '1', '1', '2017-06-03 09:21:39', '91');
INSERT INTO `erp_inventory_valuation_details` VALUES ('42', '1', '11', 'RG-005', 'Return Group 5', '2', null, '1', 'PO/1706/00010', 'PURCHASE', '2017-06-03 09:06:00', 'General Supplier', '10.0000', '109.0000', '10.0000', '109.0000', '1', '1', '2017-06-03 09:21:39', '92');
INSERT INTO `erp_inventory_valuation_details` VALUES ('43', '1', '12', 'MJ-0002', 'Mey Jing', '1', null, '1', 'PO/1706/00011', 'PURCHASE', '2017-06-03 11:07:43', 'General Supplier', '1.0000', '0.0000', '0.0000', '0.0000', '1', null, null, '104');
INSERT INTO `erp_inventory_valuation_details` VALUES ('44', '1', '9', 'MM-0001', 'Mey Mey', '1', null, '1', 'PO/1706/00011', 'PURCHASE', '2017-06-03 11:07:43', 'General Supplier', '3.0000', '0.0000', '0.0000', '0.0000', '1', null, null, '105');
INSERT INTO `erp_inventory_valuation_details` VALUES ('45', '1', '10', 'YY-0001', 'Yong Yong', '1', null, '1', 'PO/1706/00011', 'PURCHASE', '2017-06-03 11:07:43', 'General Supplier', '2.0000', '0.0000', '0.0000', '0.0000', '1', null, null, '106');
INSERT INTO `erp_inventory_valuation_details` VALUES ('46', '1', '9', 'MM-0001', 'Mey Mey', '1', null, '1', 'PO/1706/00012', 'PURCHASE', '2017-06-03 11:30:52', 'General Supplier', '5.0000', '19.0000', '3.0000', '19.0000', '1', null, null, '107');
INSERT INTO `erp_inventory_valuation_details` VALUES ('47', '1', '10', 'YY-0001', 'Yong Yong', '1', null, '1', 'PO/1706/00012', 'PURCHASE', '2017-06-03 11:30:52', 'General Supplier', '10.0000', '25.0000', '2.0000', '25.0000', '1', null, null, '108');
INSERT INTO `erp_inventory_valuation_details` VALUES ('48', '1', '10', 'YY-0001', 'Yong Yong', '1', null, '1', 'PO/1706/00013', 'PURCHASE', '2017-06-03 11:41:21', 'General Supplier', '10.0000', '8.0000', '12.0000', '8.0000', '1', null, null, '109');
INSERT INTO `erp_inventory_valuation_details` VALUES ('49', '1', '9', 'MM-0001', 'Mey Mey', '1', null, '1', 'PO/1706/00013', 'PURCHASE', '2017-06-03 11:41:21', 'General Supplier', '10.0000', '12.0000', '8.0000', '12.0000', '1', null, null, '110');
INSERT INTO `erp_inventory_valuation_details` VALUES ('50', '1', '10', 'YY-0001', 'Yong Yong', '1', null, '1', 'PO/1706/00012', 'PURCHASE', '2017-06-03 11:52:00', 'General Supplier', '10.0000', '103.0000', '22.0000', '103.0000', '1', '1', '2017-06-03 11:44:45', '111');
INSERT INTO `erp_inventory_valuation_details` VALUES ('51', '1', '9', 'MM-0001', 'Mey Mey', '1', null, '1', 'PO/1706/00012', 'PURCHASE', '2017-06-03 11:52:00', 'General Supplier', '5.0000', '63.0000', '18.0000', '63.0000', '1', '1', '2017-06-03 11:44:45', '112');
INSERT INTO `erp_inventory_valuation_details` VALUES ('52', '1', '9', 'MM-0001', 'Mey Mey', '1', null, '1', 'PO/1706/00012', 'PURCHASE', '2017-06-03 12:07:00', 'General Supplier', '5.0000', '12.0000', '16.0000', '12.0000', '1', '1', '2017-06-03 11:59:33', '127');
INSERT INTO `erp_inventory_valuation_details` VALUES ('53', '1', '10', 'YY-0001', 'Yong Yong', '1', null, '1', 'PO/1706/00012', 'PURCHASE', '2017-06-03 12:07:00', 'General Supplier', '10.0000', '8.0000', '22.0000', '8.0000', '1', '1', '2017-06-03 11:59:33', '128');

-- ----------------------------
-- Table structure for erp_loans
-- ----------------------------
DROP TABLE IF EXISTS `erp_loans`;
CREATE TABLE `erp_loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` smallint(6) NOT NULL,
  `dateline` date NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `rated` varchar(255) DEFAULT NULL,
  `payment` decimal(25,10) NOT NULL,
  `principle` decimal(25,10) NOT NULL,
  `interest` decimal(25,10) NOT NULL,
  `balance` decimal(25,10) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `paid_by` varchar(50) DEFAULT NULL,
  `paid_amount` decimal(25,4) NOT NULL,
  `paid_date` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `account_code` varchar(20) DEFAULT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `updated_by` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_loans
-- ----------------------------

-- ----------------------------
-- Table structure for erp_login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `erp_login_attempts`;
CREATE TABLE `erp_login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_login_attempts
-- ----------------------------
INSERT INTO `erp_login_attempts` VALUES ('10', 0x3139322E3136382E312E313030, 'stockrks@gmail.com', '1496386303');
INSERT INTO `erp_login_attempts` VALUES ('11', 0x3139322E3136382E312E313030, 'storck@gmail.com', '1496386319');

-- ----------------------------
-- Table structure for erp_marchine
-- ----------------------------
DROP TABLE IF EXISTS `erp_marchine`;
CREATE TABLE `erp_marchine` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `type` varchar(20) DEFAULT '0',
  `biller_id` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `13` int(11) DEFAULT '0',
  `15` int(11) DEFAULT '0',
  `25` int(11) DEFAULT '0',
  `30` int(11) DEFAULT '0',
  `50` int(11) DEFAULT '0',
  `60` int(11) DEFAULT '0',
  `76` int(11) DEFAULT '0',
  `80` int(11) DEFAULT '0',
  `100` int(11) DEFAULT '0',
  `120` int(11) DEFAULT '0',
  `150` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_marchine
-- ----------------------------

-- ----------------------------
-- Table structure for erp_marchine_logs
-- ----------------------------
DROP TABLE IF EXISTS `erp_marchine_logs`;
CREATE TABLE `erp_marchine_logs` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `marchine_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `old_number` int(11) DEFAULT NULL,
  `new_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_marchine_logs
-- ----------------------------

-- ----------------------------
-- Table structure for erp_migrations
-- ----------------------------
DROP TABLE IF EXISTS `erp_migrations`;
CREATE TABLE `erp_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_migrations
-- ----------------------------

-- ----------------------------
-- Table structure for erp_notifications
-- ----------------------------
DROP TABLE IF EXISTS `erp_notifications`;
CREATE TABLE `erp_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_date` datetime DEFAULT NULL,
  `till_date` datetime DEFAULT NULL,
  `scope` tinyint(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_notifications
-- ----------------------------

-- ----------------------------
-- Table structure for erp_order_ref
-- ----------------------------
DROP TABLE IF EXISTS `erp_order_ref`;
CREATE TABLE `erp_order_ref` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `biller_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `so` int(11) NOT NULL DEFAULT '1' COMMENT 'sale order',
  `qu` int(11) NOT NULL DEFAULT '1' COMMENT 'quote',
  `po` int(11) NOT NULL DEFAULT '1' COMMENT 'purchase order',
  `to` int(11) NOT NULL DEFAULT '1' COMMENT 'transfer to',
  `pos` int(11) NOT NULL DEFAULT '1' COMMENT 'pos',
  `do` int(11) NOT NULL DEFAULT '1' COMMENT 'delivery order',
  `pay` int(11) NOT NULL DEFAULT '1' COMMENT 'expense payment',
  `re` int(11) NOT NULL DEFAULT '1' COMMENT 'sale return',
  `ex` int(11) NOT NULL DEFAULT '1' COMMENT 'expense',
  `sp` int(11) NOT NULL DEFAULT '1' COMMENT 'sale payement',
  `pp` int(11) NOT NULL DEFAULT '1' COMMENT 'purchase payment',
  `sl` int(11) NOT NULL DEFAULT '1' COMMENT 'sale loan',
  `tr` int(11) NOT NULL DEFAULT '1' COMMENT 'transfer',
  `rep` int(11) NOT NULL DEFAULT '1' COMMENT 'purchase return',
  `con` int(11) NOT NULL DEFAULT '1' COMMENT 'convert product',
  `pj` int(11) NOT NULL DEFAULT '1' COMMENT 'prouduct job',
  `sd` int(11) NOT NULL DEFAULT '1',
  `es` int(11) NOT NULL DEFAULT '1',
  `esr` int(11) NOT NULL DEFAULT '1',
  `sao` int(11) NOT NULL DEFAULT '1',
  `poa` int(11) NOT NULL DEFAULT '1',
  `pq` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_order_ref
-- ----------------------------
INSERT INTO `erp_order_ref` VALUES ('1', '1', '2016-02-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('2', '1', '2016-03-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('3', '1', '2016-04-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('4', '1', '2016-05-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('5', '1', '2016-06-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('6', '1', '2016-07-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('7', '1', '2016-08-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('8', '1', '2016-09-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('9', '1', '2016-10-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('10', '1', '2016-11-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('11', '1', '2016-12-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('12', '1', '2017-01-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('13', '1', '2017-02-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('14', '1', '2017-03-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('15', '1', '2017-04-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('16', '1', '2017-05-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('17', '1', '2017-06-01', '52', '1', '14', '4', '2', '10', '1', '1', '1', '5', '2', '1', '104', '1', '1', '1', '1', '1', '1', '16', '3', '2');
INSERT INTO `erp_order_ref` VALUES ('18', '1', '2017-07-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('19', '1', '2017-08-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('21', '1', '2017-09-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('22', '1', '2017-10-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('23', '1', '2017-11-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('24', '1', '2017-12-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('25', '1', '2018-01-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('26', '1', '2018-02-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('27', '1', '2018-03-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('28', '1', '2018-04-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('29', '1', '2018-05-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('30', '1', '2018-06-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('31', '1', '2018-07-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('32', '1', '2018-08-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `erp_order_ref` VALUES ('33', '1', '2018-09-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for erp_pack_lists
-- ----------------------------
DROP TABLE IF EXISTS `erp_pack_lists`;
CREATE TABLE `erp_pack_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_code` varchar(20) DEFAULT NULL,
  `name` varchar(55) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  `level` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '0',
  `cf1` varchar(255) DEFAULT NULL,
  `cf2` varchar(255) DEFAULT NULL,
  `cf3` varchar(255) DEFAULT NULL,
  `cf4` varchar(255) DEFAULT NULL,
  `cf5` varchar(255) DEFAULT NULL,
  `cf6` varchar(255) DEFAULT NULL,
  `cf7` varchar(255) DEFAULT NULL,
  `cf8` varchar(255) DEFAULT NULL,
  `cf9` varchar(255) DEFAULT NULL,
  `cf10` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_pack_lists
-- ----------------------------

-- ----------------------------
-- Table structure for erp_payments
-- ----------------------------
DROP TABLE IF EXISTS `erp_payments`;
CREATE TABLE `erp_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `biller_id` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `deposit_id` int(11) DEFAULT NULL,
  `purchase_deposit_id` int(11) DEFAULT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `expense_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL,
  `paid_by` varchar(20) NOT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `cc_no` varchar(20) DEFAULT NULL,
  `cc_holder` varchar(25) DEFAULT NULL,
  `cc_month` varchar(2) DEFAULT NULL,
  `cc_year` varchar(4) DEFAULT NULL,
  `cc_type` varchar(20) DEFAULT NULL,
  `amount` decimal(25,4) NOT NULL,
  `pos_paid` decimal(25,4) DEFAULT '0.0000',
  `currency` varchar(3) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `pos_balance` decimal(25,4) DEFAULT '0.0000',
  `pos_paid_other` decimal(25,4) DEFAULT NULL,
  `pos_paid_other_rate` decimal(25,4) DEFAULT NULL,
  `approval_code` varchar(50) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `return_deposit_id` int(11) DEFAULT NULL,
  `extra_paid` decimal(25,4) DEFAULT NULL,
  `deposit_quote_id` int(11) DEFAULT NULL,
  `add_payment` tinyint(1) DEFAULT NULL,
  `discount_id` varchar(20) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `commission` int(11) DEFAULT NULL,
  `bank_account` int(11) DEFAULT NULL,
  `created_by_name` varchar(100) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_count` int(4) unsigned zerofill NOT NULL,
  `old_reference_no` varchar(50) DEFAULT NULL,
  `interest_paid` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_payments
-- ----------------------------
INSERT INTO `erp_payments` VALUES ('1', '1', '2017-06-01 19:34:00', null, null, '3', null, null, null, null, null, 'PV/1706/00001', 'cash', '', '', '', '', '', 'Visa', '48.0000', '0.0000', null, '1', null, 'sent', '', '0.0000', null, null, null, null, null, null, null, null, null, null, null, null, '100104', null, null, '0000', null, null);
INSERT INTO `erp_payments` VALUES ('2', '4', '2017-06-02 08:05:47', '23', null, null, null, null, null, null, null, 'RV/1706/00001', 'cash', '', '', '', '', '', 'Visa', '100.0000', '0.0000', null, '3', null, 'received', 'General Customer', '0.0000', null, null, null, null, null, null, null, '1', null, null, null, null, '100100', null, null, '0000', null, null);
INSERT INTO `erp_payments` VALUES ('3', '1', '2017-06-02 15:24:00', '49', null, null, null, null, null, null, null, 'RV/1706/00002', 'cash', '', '', '', '', '', 'Visa', '198.0000', '0.0000', null, '1', null, 'received', 'General Customer', '0.0000', null, null, null, null, null, null, null, '1', null, null, null, null, '100100', null, null, '0000', null, null);
INSERT INTO `erp_payments` VALUES ('4', '1', '2017-06-03 10:15:15', '65', null, null, null, null, null, null, null, 'RV/1706/00003', 'cash', '', '', '', '', '', '', '8.0000', '8.0000', null, '1', null, 'received', '', '0.0000', '0.0000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0000', null, null);

-- ----------------------------
-- Table structure for erp_payments_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_payments_audit`;
CREATE TABLE `erp_payments_audit` (
  `id` int(11) NOT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `deposit_id` int(11) DEFAULT NULL,
  `purchase_deposit_id` int(11) DEFAULT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `expense_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL,
  `paid_by` varchar(20) NOT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `cc_no` varchar(20) DEFAULT NULL,
  `cc_holder` varchar(25) DEFAULT NULL,
  `cc_month` varchar(2) DEFAULT NULL,
  `cc_year` varchar(4) DEFAULT NULL,
  `cc_type` varchar(20) DEFAULT NULL,
  `amount` decimal(25,4) NOT NULL,
  `pos_paid` decimal(25,4) DEFAULT '0.0000',
  `currency` varchar(3) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `pos_balance` decimal(25,4) DEFAULT '0.0000',
  `pos_paid_other` decimal(25,4) DEFAULT NULL,
  `pos_paid_other_rate` decimal(25,4) DEFAULT NULL,
  `approval_code` varchar(50) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `return_deposit_id` int(11) DEFAULT NULL,
  `extra_paid` decimal(25,4) DEFAULT NULL,
  `deposit_quote_id` int(11) DEFAULT NULL,
  `add_payment` tinyint(1) DEFAULT NULL,
  `discount_id` varchar(20) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `commission` int(11) DEFAULT NULL,
  `bank_account` int(11) DEFAULT NULL,
  `created_by_name` varchar(100) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_count` int(4) unsigned zerofill NOT NULL,
  `old_reference_no` varchar(50) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_payments_audit
-- ----------------------------

-- ----------------------------
-- Table structure for erp_payment_term
-- ----------------------------
DROP TABLE IF EXISTS `erp_payment_term`;
CREATE TABLE `erp_payment_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(55) DEFAULT NULL,
  `due_day` int(11) DEFAULT '0',
  `due_day_for_discount` int(11) DEFAULT '0',
  `discount` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_payment_term
-- ----------------------------
INSERT INTO `erp_payment_term` VALUES ('1', 'Net 20 Days', '20', '5', '0');
INSERT INTO `erp_payment_term` VALUES ('2', 'Net 1 Month', '30', '0', '0');
INSERT INTO `erp_payment_term` VALUES ('3', 'Net 7 Days', '7', '7', '0');
INSERT INTO `erp_payment_term` VALUES ('4', 'Case On Hand', '0', '0', '0');

-- ----------------------------
-- Table structure for erp_paypal
-- ----------------------------
DROP TABLE IF EXISTS `erp_paypal`;
CREATE TABLE `erp_paypal` (
  `id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `account_email` varchar(255) NOT NULL,
  `paypal_currency` varchar(3) NOT NULL DEFAULT 'USD',
  `fixed_charges` decimal(25,4) NOT NULL DEFAULT '2.0000',
  `extra_charges_my` decimal(25,4) NOT NULL DEFAULT '3.9000',
  `extra_charges_other` decimal(25,4) NOT NULL DEFAULT '4.4000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_paypal
-- ----------------------------

-- ----------------------------
-- Table structure for erp_permissions
-- ----------------------------
DROP TABLE IF EXISTS `erp_permissions`;
CREATE TABLE `erp_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `products-index` tinyint(1) DEFAULT '0',
  `products-add` tinyint(1) DEFAULT '0',
  `products-edit` tinyint(1) DEFAULT '0',
  `products-delete` tinyint(1) DEFAULT '0',
  `products-cost` tinyint(1) DEFAULT '0',
  `products-price` tinyint(1) DEFAULT '0',
  `products-import` tinyint(1) DEFAULT '0',
  `products-export` tinyint(1) DEFAULT '0',
  `products_convert_add` tinyint(1) DEFAULT NULL,
  `products-items_convert` tinyint(1) DEFAULT NULL,
  `products_print_barcodes` tinyint(1) DEFAULT NULL,
  `products-using_stock` tinyint(1) DEFAULT NULL,
  `products-list_using_stock` tinyint(1) DEFAULT NULL,
  `product_import` tinyint(1) DEFAULT NULL,
  `product_import_quantity` tinyint(1) DEFAULT NULL,
  `product_import_price_cost` tinyint(1) DEFAULT NULL,
  `products-print_barcodes` tinyint(1) DEFAULT NULL,
  `products-return_list` tinyint(1) DEFAULT NULL,
  `products-sync_quantity` tinyint(1) DEFAULT NULL,
  `quotes-index` tinyint(1) DEFAULT '0',
  `quotes-add` tinyint(1) DEFAULT '0',
  `quotes-edit` tinyint(1) DEFAULT '0',
  `quotes-email` tinyint(1) DEFAULT '0',
  `quotes-delete` tinyint(1) DEFAULT '0',
  `quotes-pdf` tinyint(1) DEFAULT '0',
  `quotes-export` tinyint(1) DEFAULT '0',
  `quotes-import` tinyint(1) DEFAULT '0',
  `quotes-authorize` tinyint(1) DEFAULT NULL,
  `quotes-conbine_pdf` tinyint(1) DEFAULT NULL,
  `sales-index` tinyint(1) DEFAULT '0',
  `sales-add` tinyint(1) DEFAULT '0',
  `sales-edit` tinyint(1) DEFAULT '0',
  `sales-email` tinyint(1) DEFAULT '0',
  `sales-pdf` tinyint(1) DEFAULT '0',
  `sales-delete` tinyint(1) DEFAULT '0',
  `sales-export` tinyint(1) DEFAULT '0',
  `sales-import` tinyint(1) DEFAULT '0',
  `purchases-index` tinyint(1) DEFAULT '0',
  `purchases-add` tinyint(1) DEFAULT '0',
  `purchases-edit` tinyint(1) DEFAULT '0',
  `purchases-email` tinyint(1) DEFAULT '0',
  `purchases-pdf` tinyint(1) DEFAULT '0',
  `purchases-delete` tinyint(1) DEFAULT '0',
  `purchases-export` tinyint(1) DEFAULT '0',
  `purchases-import` tinyint(1) DEFAULT '0',
  `purchases-return_list` tinyint(1) DEFAULT NULL,
  `purchases-return_add` tinyint(1) DEFAULT NULL,
  `purchases-cost` tinyint(1) DEFAULT NULL,
  `purchases-price` tinyint(1) DEFAULT NULL,
  `purchases-opening_ap` tinyint(1) DEFAULT NULL,
  `purchases-expenses` tinyint(1) DEFAULT '0',
  `purchases-import_expanse` tinyint(1) DEFAULT NULL,
  `purchases-payments` tinyint(1) DEFAULT '0',
  `purchase-combine_pdf` tinyint(1) DEFAULT NULL,
  `transfers-index` tinyint(1) DEFAULT '0',
  `transfers-add` tinyint(1) DEFAULT '0',
  `transfers-edit` tinyint(1) DEFAULT '0',
  `transfers-email` tinyint(1) DEFAULT '0',
  `transfers-delete` tinyint(1) DEFAULT '0',
  `transfers-pdf` tinyint(1) DEFAULT '0',
  `transfers-export` tinyint(1) DEFAULT '0',
  `transfers-import` tinyint(1) DEFAULT '0',
  `transfers-combine_pdf` tinyint(1) DEFAULT NULL,
  `customers-index` tinyint(1) DEFAULT '0',
  `customers-add` tinyint(1) DEFAULT '0',
  `customers-edit` tinyint(1) DEFAULT '0',
  `customers-delete` tinyint(1) DEFAULT '0',
  `customers-export` tinyint(1) DEFAULT '0',
  `customers-import` tinyint(1) DEFAULT '0',
  `suppliers-index` tinyint(1) DEFAULT '0',
  `suppliers-add` tinyint(1) DEFAULT '0',
  `suppliers-edit` tinyint(1) DEFAULT '0',
  `suppliers-delete` tinyint(1) DEFAULT '0',
  `suppliers-import` tinyint(1) DEFAULT '0',
  `suppliers-export` tinyint(1) DEFAULT '0',
  `sales-deliveries` tinyint(1) DEFAULT '0',
  `sales-add_delivery` tinyint(1) DEFAULT '0',
  `sales-edit_delivery` tinyint(1) DEFAULT '0',
  `sales-delete_delivery` tinyint(1) DEFAULT '0',
  `sales-pdf_delivery` tinyint(1) DEFAULT '0',
  `sales-email_delivery` tinyint(1) DEFAULT '0',
  `sales-export_delivery` tinyint(1) DEFAULT '0',
  `sales-import_delivery` tinyint(1) DEFAULT '0',
  `sales-gift_cards` tinyint(1) DEFAULT '0',
  `sales-add_gift_card` tinyint(1) DEFAULT '0',
  `sales-edit_gift_card` tinyint(1) DEFAULT '0',
  `sales-delete_gift_card` tinyint(1) DEFAULT '0',
  `sales-import_gift_card` tinyint(1) DEFAULT '0',
  `sales-export_gift_card` tinyint(1) DEFAULT '0',
  `pos-index` tinyint(1) DEFAULT '0',
  `sales-return_sales` tinyint(1) DEFAULT '0',
  `reports-index` tinyint(1) DEFAULT '0',
  `reports-warehouse_stock` tinyint(1) DEFAULT '0',
  `reports-quantity_alerts` tinyint(1) DEFAULT '0',
  `reports-expiry_alerts` tinyint(1) DEFAULT '0',
  `reports-products` tinyint(1) DEFAULT '0',
  `reports-daily_sales` tinyint(1) DEFAULT '0',
  `reports-monthly_sales` tinyint(1) DEFAULT '0',
  `reports-sales` tinyint(1) DEFAULT '0',
  `reports-payments` tinyint(1) DEFAULT '0',
  `reports-purchases` tinyint(1) DEFAULT '0',
  `reports-profit_loss` tinyint(1) DEFAULT '0',
  `reports-customers` tinyint(1) DEFAULT '0',
  `reports-suppliers` tinyint(1) DEFAULT '0',
  `reports-staff` tinyint(1) DEFAULT '0',
  `reports-register` tinyint(1) DEFAULT '0',
  `reports-account` tinyint(1) DEFAULT '0',
  `sales-payments` tinyint(1) DEFAULT '0',
  `bulk_actions` tinyint(1) DEFAULT '0',
  `customers-deposits` tinyint(1) DEFAULT '0',
  `customers-delete_deposit` tinyint(1) DEFAULT '0',
  `products-adjustments` tinyint(1) DEFAULT '0',
  `accounts-index` tinyint(1) DEFAULT '0',
  `accounts-add` tinyint(1) DEFAULT '0',
  `accounts-edit` tinyint(1) DEFAULT '0',
  `accounts-delete` tinyint(1) DEFAULT '0',
  `accounts-import` tinyint(1) DEFAULT '0',
  `accounts-export` tinyint(1) DEFAULT '0',
  `account-list_receivable` tinyint(1) DEFAULT NULL,
  `account-list_ar_aging` tinyint(1) DEFAULT NULL,
  `account-ar_by_customer` tinyint(1) DEFAULT NULL,
  `account-bill_receipt` tinyint(1) DEFAULT NULL,
  `account-list_payable` tinyint(1) DEFAULT NULL,
  `account-list_ap_aging` tinyint(1) DEFAULT NULL,
  `account-ap_by_supplier` tinyint(1) DEFAULT NULL,
  `account-bill_payable` tinyint(1) DEFAULT NULL,
  `account-list_ac_head` tinyint(1) DEFAULT NULL,
  `account-add_ac_head` tinyint(1) DEFAULT NULL,
  `account-list_customer_deposit` tinyint(1) DEFAULT NULL,
  `account-add_customer_deposit` tinyint(1) DEFAULT NULL,
  `account-list_supplier_deposit` tinyint(1) DEFAULT NULL,
  `account-add_supplier_deposit` tinyint(1) DEFAULT NULL,
  `account_setting` tinyint(1) DEFAULT NULL,
  `sales-discount` tinyint(1) DEFAULT '0',
  `sales-price` tinyint(1) DEFAULT '0',
  `sales-opening_ar` tinyint(1) DEFAULT NULL,
  `sales-loan` tinyint(1) DEFAULT '0',
  `reports-daily_purchases` tinyint(1) DEFAULT '0',
  `reports-monthly_purchases` tinyint(1) DEFAULT '0',
  `room-index` tinyint(1) DEFAULT NULL,
  `room-add` tinyint(1) DEFAULT NULL,
  `room-edit` tinyint(1) DEFAULT NULL,
  `room-delete` tinyint(1) DEFAULT NULL,
  `room-import` tinyint(1) DEFAULT NULL,
  `room-export` tinyint(1) DEFAULT NULL,
  `sale-room-index` tinyint(1) DEFAULT NULL,
  `sale-room-add` tinyint(1) DEFAULT NULL,
  `sale-room-edit` tinyint(1) DEFAULT NULL,
  `sale-room-delete` tinyint(1) DEFAULT NULL,
  `sale-room-import` tinyint(1) DEFAULT NULL,
  `sale-room-export` tinyint(1) DEFAULT NULL,
  `sales-combine_pdf` tinyint(1) DEFAULT NULL,
  `sales-combine_delivery` tinyint(1) DEFAULT NULL,
  `sale_order-index` tinyint(1) DEFAULT NULL,
  `sale_order-add` tinyint(1) DEFAULT NULL,
  `sale_order-edit` tinyint(1) DEFAULT NULL,
  `sale_order-delete` tinyint(1) DEFAULT NULL,
  `sale_order-import` tinyint(1) DEFAULT NULL,
  `sale_order-export` tinyint(1) DEFAULT NULL,
  `sale_order-authorize` tinyint(1) DEFAULT NULL,
  `sale_order-combine_pdf` tinyint(1) DEFAULT NULL,
  `purchases_order-index` tinyint(1) DEFAULT NULL,
  `purchases_order-edit` tinyint(1) DEFAULT NULL,
  `purchases_order-add` tinyint(1) DEFAULT NULL,
  `purchases_order-delete` tinyint(1) DEFAULT NULL,
  `purchases_order-email` tinyint(1) DEFAULT NULL,
  `purchases_order-import` tinyint(1) DEFAULT NULL,
  `purchases_order-export` tinyint(1) DEFAULT NULL,
  `purchases_order-pdf` tinyint(1) DEFAULT NULL,
  `purchases_order-payments` tinyint(1) DEFAULT NULL,
  `purchases_order-expenses` tinyint(1) DEFAULT NULL,
  `purchase_order-cost` tinyint(1) DEFAULT NULL,
  `purchase_order-price` tinyint(1) DEFAULT NULL,
  `purchase_order-import_expanse` tinyint(1) DEFAULT NULL,
  `purchase_order-combine_pdf` tinyint(1) DEFAULT NULL,
  `purchase_request-index` tinyint(1) DEFAULT NULL,
  `purchase_request-add` tinyint(1) DEFAULT NULL,
  `purchase_request-edit` tinyint(1) DEFAULT NULL,
  `purchase_request-delete` tinyint(1) DEFAULT NULL,
  `purchase_request-export` tinyint(1) DEFAULT NULL,
  `purchase_request-import` tinyint(1) DEFAULT NULL,
  `purchase_request-cost` tinyint(1) DEFAULT NULL,
  `purchase_request-price` tinyint(1) DEFAULT NULL,
  `purchase_request-import_expanse` tinyint(1) DEFAULT NULL,
  `purchase_request-combine_pdf` tinyint(1) DEFAULT NULL,
  `users-index` tinyint(1) DEFAULT NULL,
  `users-edit` tinyint(1) DEFAULT NULL,
  `users-add` tinyint(1) DEFAULT NULL,
  `users-delete` tinyint(1) DEFAULT NULL,
  `users-import` tinyint(1) DEFAULT NULL,
  `users-export` tinyint(1) DEFAULT NULL,
  `drivers-index` tinyint(1) DEFAULT NULL,
  `drivers-edit` tinyint(1) DEFAULT NULL,
  `drivers-add` tinyint(1) DEFAULT NULL,
  `drivers-delete` tinyint(1) DEFAULT NULL,
  `drivers-import` tinyint(1) DEFAULT NULL,
  `drivers-export` tinyint(1) DEFAULT NULL,
  `employees-index` tinyint(1) DEFAULT NULL,
  `employees-edit` tinyint(1) DEFAULT NULL,
  `employees-add` tinyint(1) DEFAULT NULL,
  `employees-delete` tinyint(1) DEFAULT NULL,
  `employees-import` tinyint(1) DEFAULT NULL,
  `employees-export` tinyint(1) DEFAULT NULL,
  `projects-index` tinyint(1) DEFAULT NULL,
  `projects-edit` tinyint(1) DEFAULT NULL,
  `projects-add` tinyint(1) DEFAULT NULL,
  `projects-delete` tinyint(1) DEFAULT NULL,
  `projects-import` tinyint(1) DEFAULT NULL,
  `projects-export` tinyint(1) DEFAULT NULL,
  `product_report-index` tinyint(1) DEFAULT NULL,
  `product_report-quantity_alert` tinyint(1) DEFAULT NULL,
  `product_report-product` tinyint(1) DEFAULT NULL,
  `product_report-warehouse` tinyint(1) DEFAULT NULL,
  `product_report-in_out` tinyint(1) DEFAULT NULL,
  `product_report-monthly` tinyint(1) DEFAULT NULL,
  `product_report-daily` tinyint(1) DEFAULT NULL,
  `product_report-suppliers` tinyint(1) DEFAULT NULL,
  `product_report-customers` tinyint(1) DEFAULT NULL,
  `product_report-categories` tinyint(1) DEFAULT NULL,
  `product_report-categories_value` tinyint(1) DEFAULT NULL,
  `sale_report-index` tinyint(1) DEFAULT NULL,
  `sale_report-register` tinyint(1) DEFAULT NULL,
  `sale_report-daily` tinyint(1) DEFAULT NULL,
  `sale_report-monthly` tinyint(1) DEFAULT NULL,
  `sale_report-report_sale` tinyint(1) DEFAULT NULL,
  `sale_report-disccount` tinyint(1) DEFAULT NULL,
  `sale_report-by_delivery_person` tinyint(1) DEFAULT NULL,
  `sale_report-customer` tinyint(1) DEFAULT NULL,
  `sale_report-saleman` tinyint(1) DEFAULT NULL,
  `sale_report-staff` tinyint(1) DEFAULT NULL,
  `sale_report-supplier` tinyint(1) DEFAULT NULL,
  `sale_report-project` tinyint(1) DEFAULT NULL,
  `sale_report-detail` tinyint(1) DEFAULT NULL,
  `sale_report-by_invoice` tinyint(1) DEFAULT NULL,
  `sale_report-sale_profit` tinyint(1) DEFAULT NULL,
  `sale_report-room_table` tinyint(1) DEFAULT NULL,
  `chart_report-index` tinyint(1) DEFAULT NULL,
  `chart_report-over_view` tinyint(1) DEFAULT NULL,
  `chart_report-warehouse_stock` tinyint(1) DEFAULT NULL,
  `chart_report-category_stock` tinyint(1) DEFAULT NULL,
  `chart_report-profit` tinyint(1) DEFAULT NULL,
  `chart_report-cash_analysis` tinyint(1) DEFAULT NULL,
  `chart_report-customize` tinyint(1) DEFAULT NULL,
  `chart_report-room_table` tinyint(1) DEFAULT NULL,
  `chart_report-suspend_profit_and_lose` tinyint(1) DEFAULT NULL,
  `account_report-index` tinyint(1) DEFAULT NULL,
  `account_report-ledger` tinyint(1) DEFAULT NULL,
  `account_report-trail_balance` tinyint(1) DEFAULT NULL,
  `account_report-journal` tinyint(1) DEFAULT NULL,
  `account_report-ac_injuiry_report` tinyint(1) DEFAULT NULL,
  `account_report-balance_sheet` tinyint(1) DEFAULT NULL,
  `account_report-bsh_by_month` tinyint(1) DEFAULT NULL,
  `account_report-bsh_by_year` tinyint(1) DEFAULT NULL,
  `account_report-bsh_by_project` tinyint(1) DEFAULT NULL,
  `account_report-bsh_by_budget` tinyint(1) DEFAULT NULL,
  `account_report-income_statement` tinyint(1) DEFAULT NULL,
  `account_report-income_statement_detail` tinyint(1) DEFAULT NULL,
  `account_report-ins_by_month` tinyint(1) DEFAULT NULL,
  `account_report-ins_by_year` tinyint(1) DEFAULT NULL,
  `account_report-ins_by_project` tinyint(1) DEFAULT NULL,
  `account_report-ins_by_budget` tinyint(1) DEFAULT NULL,
  `account_report-cash_flow_statement` tinyint(1) DEFAULT NULL,
  `account_report-cash_book` tinyint(1) DEFAULT NULL,
  `account_report-payment` tinyint(1) DEFAULT NULL,
  `report_profit-index` tinyint(1) DEFAULT NULL,
  `report_profit-payments` tinyint(1) DEFAULT NULL,
  `report_profit-profit_andOr_lose` tinyint(1) DEFAULT NULL,
  `report_profit-stock` tinyint(1) DEFAULT NULL,
  `report_profit-category` tinyint(1) DEFAULT NULL,
  `report_profit-sale_profit` tinyint(1) DEFAULT NULL,
  `report_profit-project` tinyint(1) DEFAULT NULL,
  `report_profit-project_profit` tinyint(1) DEFAULT NULL,
  `purchase_report-index` tinyint(1) DEFAULT NULL,
  `purchase_report-purchas` tinyint(1) DEFAULT NULL,
  `purchase_report-daily` tinyint(1) DEFAULT NULL,
  `purchase_report-monthly` tinyint(1) DEFAULT NULL,
  `purchase_report-supplier` tinyint(1) DEFAULT NULL,
  `purchase-authorize` tinyint(1) DEFAULT NULL,
  `sales-authorize` tinyint(1) DEFAULT NULL,
  `product_using_stock` tinyint(1) DEFAULT NULL,
  `product_list_using_stock` tinyint(1) DEFAULT NULL,
  `product_return_list` tinyint(1) DEFAULT NULL,
  `sale_report-customer_transfers` tinyint(1) DEFAULT NULL,
  `purchases_add-expenses` tinyint(1) DEFAULT NULL,
  `customers_balance` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_permissions
-- ----------------------------
INSERT INTO `erp_permissions` VALUES ('1', '5', '1', '1', '1', '1', null, '1', null, '1', '1', '1', '1', '1', '1', null, null, '1', null, '1', null, '1', '1', '1', null, '1', null, '1', '1', null, null, '1', '1', '1', null, null, '1', null, '1', '1', '1', '1', '1', null, '1', null, '1', '1', '1', '1', null, null, '1', '1', '1', null, '1', null, null, '1', '1', null, '1', null, null, null, '1', null, '1', '1', '1', '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', null, null, null, null, null, '1', null, '1', null, null, null, null, null, '0', null, null, null, null, '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('2', '6', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, '1', null, null, '1', null, null, null, null, null, '0', '0', '1', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('3', '7', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, '1', '1', null, null, null, null, '1', null, '1', '1', '1', '1', null, null, null, null, '1', null, '1', '1', '1', '1', null, '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, '1', '1', null, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, null, null, null, null, '1', '1', '1', '1', '1', '1', '1', '1', null, '0', '1', null, null, null, null, null, null, null, null, null, null, '0', '0', null, '1', null, null, null, null, '1', '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, null, '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', '1', null, null, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', null, '1', '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', null, '1', '1', null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('4', '8', '1', null, null, null, null, '1', null, '1', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('5', '9', '1', null, null, null, '1', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, '1', '1', '1', '1', '1', '1', null, null, null, null, '1', null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', null, null, '1', '1', null, null, null, null, null, null, null, null, null, '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', null, '1', '1', null, '1', null, '1', null, null, null, '1', '1', '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('6', '10', '1', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, null, null, '1', null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, '1', null, '1', '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, null, '1', '1', null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, '1', '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, '1', null, null);
INSERT INTO `erp_permissions` VALUES ('7', '11', '1', '1', null, null, null, '1', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('8', '12', '1', null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, null, '1', null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, '1', '1', '1', null, null, null, '1', null, null, null, '1', null, null, null, '1', '1', '1', null, '1', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('9', '13', '1', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('10', '8', '1', null, null, null, null, '1', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('11', '9', '1', null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, '1', '1', '1', '1', '1', '1', null, null, null, null, '1', null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', null, null, '1', '1', null, null, null, null, null, null, null, null, null, '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', null, '1', '1', null, '1', null, '1', null, null, null, '1', '1', '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `erp_permissions` VALUES ('12', '10', '1', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, null, null, '1', null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, '1', null, '1', '0', null, null, '0', null, null, '0', null, '0', null, null, null, '0', '0', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', null, null, null, '1', '1', null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, '1', '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, '1', null, null);

-- ----------------------------
-- Table structure for erp_pos_register
-- ----------------------------
DROP TABLE IF EXISTS `erp_pos_register`;
CREATE TABLE `erp_pos_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `cash_in_hand` decimal(25,4) NOT NULL,
  `status` varchar(10) NOT NULL,
  `total_cash` decimal(25,4) DEFAULT NULL,
  `total_cheques` int(11) DEFAULT NULL,
  `total_cc_slips` int(11) DEFAULT NULL,
  `total_cash_submitted` decimal(25,4) DEFAULT NULL,
  `total_cheques_submitted` int(11) DEFAULT NULL,
  `total_cc_slips_submitted` int(11) DEFAULT NULL,
  `note` text,
  `closed_at` timestamp NULL DEFAULT NULL,
  `transfer_opened_bills` varchar(50) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_pos_register
-- ----------------------------
INSERT INTO `erp_pos_register` VALUES ('1', '2017-05-13 14:31:59', '1', '0.0000', 'open', null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for erp_pos_settings
-- ----------------------------
DROP TABLE IF EXISTS `erp_pos_settings`;
CREATE TABLE `erp_pos_settings` (
  `pos_id` int(1) NOT NULL,
  `cat_limit` int(11) NOT NULL,
  `pro_limit` int(11) NOT NULL,
  `default_category` int(11) NOT NULL,
  `default_customer` int(11) NOT NULL,
  `default_biller` int(11) NOT NULL,
  `display_time` varchar(3) NOT NULL DEFAULT 'yes',
  `cf_title1` varchar(255) DEFAULT NULL,
  `cf_title2` varchar(255) DEFAULT NULL,
  `cf_value1` varchar(255) DEFAULT NULL,
  `cf_value2` varchar(255) DEFAULT NULL,
  `receipt_printer` varchar(55) DEFAULT NULL,
  `cash_drawer_codes` varchar(55) DEFAULT NULL,
  `focus_add_item` varchar(55) DEFAULT NULL,
  `add_manual_product` varchar(55) DEFAULT NULL,
  `customer_selection` varchar(55) DEFAULT NULL,
  `add_customer` varchar(55) DEFAULT NULL,
  `toggle_category_slider` varchar(55) DEFAULT NULL,
  `toggle_subcategory_slider` varchar(55) DEFAULT NULL,
  `show_search_item` varchar(55) DEFAULT NULL,
  `product_unit` varchar(55) DEFAULT NULL,
  `cancel_sale` varchar(55) DEFAULT NULL,
  `suspend_sale` varchar(55) DEFAULT NULL,
  `print_items_list` varchar(55) DEFAULT NULL,
  `print_bill` varchar(55) DEFAULT NULL,
  `finalize_sale` varchar(55) DEFAULT NULL,
  `today_sale` varchar(55) DEFAULT NULL,
  `open_hold_bills` varchar(55) DEFAULT NULL,
  `close_register` varchar(55) DEFAULT NULL,
  `keyboard` tinyint(1) NOT NULL,
  `pos_printers` varchar(255) DEFAULT NULL,
  `java_applet` tinyint(1) NOT NULL,
  `product_button_color` varchar(20) NOT NULL DEFAULT 'default',
  `tooltips` tinyint(1) DEFAULT '1',
  `paypal_pro` tinyint(1) DEFAULT '0',
  `stripe` tinyint(1) DEFAULT '0',
  `rounding` tinyint(1) DEFAULT '0',
  `char_per_line` tinyint(4) DEFAULT '42',
  `pin_code` varchar(20) DEFAULT NULL,
  `purchase_code` varchar(100) DEFAULT 'purchase_code',
  `envato_username` varchar(50) DEFAULT 'envato_username',
  `version` varchar(10) DEFAULT '3.0.1.21',
  `show_item_img` tinyint(1) DEFAULT NULL,
  `pos_layout` tinyint(1) DEFAULT NULL,
  `display_qrcode` tinyint(1) DEFAULT NULL,
  `show_suspend_bar` tinyint(1) DEFAULT NULL,
  `show_payment_noted` tinyint(1) DEFAULT NULL,
  `payment_balance` tinyint(1) DEFAULT NULL,
  `authorize` tinyint(1) DEFAULT '0',
  `show_product_code` tinyint(1) unsigned DEFAULT '1',
  `auto_delivery` tinyint(1) unsigned DEFAULT '1',
  `in_out_rate` tinyint(1) DEFAULT '0',
  `discount` decimal(8,4) DEFAULT NULL,
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_pos_settings
-- ----------------------------
INSERT INTO `erp_pos_settings` VALUES ('1', '22', '30', '2', '2', '1', '1', 'GST Reg', 'VAT Reg', '123456789', '987654321', 'BIXOLON SRP-350II', 'x1C', 'Ctrl+F3', 'Ctrl+Shift+M', 'Ctrl+Shift+C', 'Ctrl+Shift+A', 'Ctrl+F11', 'Ctrl+F12', 'F1', 'F2', 'F4', 'F7', 'F9', 'F3', 'F8', 'Ctrl+F1', 'Ctrl+F2', 'Ctrl+F10', '0', 'BIXOLON SRP-350II, BIXOLON SRP-350II', '0', 'warning', '0', '0', '0', '0', '42', '', 'cloud-net', '53d35644-a36e-45cd-b7ee-8dde3a08f83d', '3.3', '1', '0', '0', '1', '1', '1', '0', '0', '0', '0', '0.0000');

-- ----------------------------
-- Table structure for erp_price_groups
-- ----------------------------
DROP TABLE IF EXISTS `erp_price_groups`;
CREATE TABLE `erp_price_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_price_groups
-- ----------------------------
INSERT INTO `erp_price_groups` VALUES ('1', 'Price A');
INSERT INTO `erp_price_groups` VALUES ('2', 'Price B');

-- ----------------------------
-- Table structure for erp_principles
-- ----------------------------
DROP TABLE IF EXISTS `erp_principles`;
CREATE TABLE `erp_principles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_type_id` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT '0',
  `value` varchar(11) DEFAULT '0',
  `remark` varchar(150) DEFAULT NULL,
  `rate` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_principles
-- ----------------------------
INSERT INTO `erp_principles` VALUES ('1', '0', '10', '1000', null, '0.00');
INSERT INTO `erp_principles` VALUES ('2', '0', '10', '5000', null, '0.00');
INSERT INTO `erp_principles` VALUES ('3', '0', '10', '10%', null, '1.00');
INSERT INTO `erp_principles` VALUES ('4', '0', '10', '10%', null, '1.00');
INSERT INTO `erp_principles` VALUES ('5', '0', '10', '10%', null, '1.00');
INSERT INTO `erp_principles` VALUES ('6', '0', '10', '70%', null, '1.00');
INSERT INTO `erp_principles` VALUES ('7', '0', '10', '5', null, null);
INSERT INTO `erp_principles` VALUES ('8', '0', '10', '5', null, null);
INSERT INTO `erp_principles` VALUES ('9', '0', '10', '5', null, null);
INSERT INTO `erp_principles` VALUES ('10', '0', '10', '5', null, null);
INSERT INTO `erp_principles` VALUES ('11', '0', '10', '10', null, null);
INSERT INTO `erp_principles` VALUES ('12', '0', '10', '10', null, null);
INSERT INTO `erp_principles` VALUES ('13', '0', '10', '10', null, null);
INSERT INTO `erp_principles` VALUES ('14', '0', '10', '10', null, null);
INSERT INTO `erp_principles` VALUES ('15', '0', '10', '15', null, null);
INSERT INTO `erp_principles` VALUES ('16', '0', '10', '10', null, null);
INSERT INTO `erp_principles` VALUES ('17', '0', '10', '25', null, null);
INSERT INTO `erp_principles` VALUES ('18', '0', '10', '25', null, null);
INSERT INTO `erp_principles` VALUES ('19', '0', '10', '25', null, null);
INSERT INTO `erp_principles` VALUES ('20', '0', '10', '25', null, null);
INSERT INTO `erp_principles` VALUES ('21', '1', '12', '100%', 'ere', '1.00');
INSERT INTO `erp_principles` VALUES ('22', '1', '12', '10', 'hello', '1.00');
INSERT INTO `erp_principles` VALUES ('23', '1', '11', '30%', 'hi', null);
INSERT INTO `erp_principles` VALUES ('24', '1', '12', '23', 'er', null);
INSERT INTO `erp_principles` VALUES ('25', '1', '12', '12', 'hh', '1.00');
INSERT INTO `erp_principles` VALUES ('26', '1', '12', '12', 'gg', '1.00');
INSERT INTO `erp_principles` VALUES ('27', '1', '0', '', '', null);
INSERT INTO `erp_principles` VALUES ('28', '1', '0', '', '', null);
INSERT INTO `erp_principles` VALUES ('29', '1', '12', '12', 'fg', '1.00');
INSERT INTO `erp_principles` VALUES ('30', '1', '34', '43', 'hh', '1.00');
INSERT INTO `erp_principles` VALUES ('31', '1', '0', '', '', null);
INSERT INTO `erp_principles` VALUES ('32', '1', '0', '', '', null);
INSERT INTO `erp_principles` VALUES ('33', '1', '12', '12', 'frd', '1.00');
INSERT INTO `erp_principles` VALUES ('34', '1', '1', '12', 'hh', null);
INSERT INTO `erp_principles` VALUES ('35', '1', '6', '67', 'hj', '1.00');
INSERT INTO `erp_principles` VALUES ('36', '1', '2', '23', '4', '0.00');

-- ----------------------------
-- Table structure for erp_products
-- ----------------------------
DROP TABLE IF EXISTS `erp_products`;
CREATE TABLE `erp_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name_kh` varchar(50) DEFAULT NULL,
  `name` char(255) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) NOT NULL,
  `alert_quantity` decimal(15,0) DEFAULT '20',
  `image` varchar(255) DEFAULT 'no_image.png',
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `cf1` varchar(255) DEFAULT NULL,
  `cf2` varchar(255) DEFAULT NULL,
  `cf3` varchar(255) DEFAULT NULL,
  `cf4` varchar(255) DEFAULT NULL,
  `cf5` varchar(255) DEFAULT NULL,
  `cf6` varchar(255) DEFAULT NULL,
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `tax_rate` int(11) DEFAULT NULL,
  `track_quantity` tinyint(1) DEFAULT '1',
  `details` varchar(1000) DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `barcode_symbology` varchar(55) NOT NULL DEFAULT 'code128',
  `file` varchar(100) DEFAULT NULL,
  `product_details` text,
  `tax_method` tinyint(1) DEFAULT '0',
  `type` varchar(55) NOT NULL DEFAULT 'standard',
  `supplier1` int(11) DEFAULT NULL,
  `supplier1price` decimal(25,4) DEFAULT NULL,
  `supplier2` int(11) DEFAULT NULL,
  `supplier2price` decimal(25,4) DEFAULT NULL,
  `supplier3` int(11) DEFAULT NULL,
  `supplier3price` decimal(25,4) DEFAULT NULL,
  `supplier4` int(11) DEFAULT NULL,
  `supplier4price` decimal(25,4) DEFAULT NULL,
  `supplier5` int(11) DEFAULT NULL,
  `supplier5price` decimal(25,4) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `promotion` tinyint(1) DEFAULT '0',
  `promo_price` varchar(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `supplier1_part_no` varchar(50) DEFAULT NULL,
  `supplier2_part_no` varchar(50) DEFAULT NULL,
  `supplier3_part_no` varchar(50) DEFAULT NULL,
  `supplier4_part_no` varchar(50) DEFAULT NULL,
  `supplier5_part_no` varchar(50) DEFAULT NULL,
  `currentcy_code` varchar(10) DEFAULT NULL,
  `inactived` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `brand_id` int(11) DEFAULT NULL,
  `opening_stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `category_id` (`category_id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `category_id_2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_products
-- ----------------------------
INSERT INTO `erp_products` VALUES ('1', '1', null, 'Product_test', '1', '0.0000', '0.0000', '0', 'no_image.png', '1', null, '', '', '', '', '', '', '-13.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('2', 'RG-001', null, 'Return Group 1', '2', '3.4947', '3.5000', '2', 'no_image.png', '2', null, '', '', '', '', '', '', '15.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('3', 'RG-002', null, 'Return Group 2', '2', '2.8448', '3.0000', '2', 'no_image.png', '2', null, '', '', '', '', '', '', '30.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('4', 'CAM-0001', null, 'Cambodia', '1', '100.0000', '0.0000', '0', 'no_image.png', '1', null, '', '', '', '', '', '', '4.0000', '1', '1', '', null, 'code128', null, '', '1', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('5', '01KD', null, 'KAKADA_01', '3', '20.0000', '0.0000', '0', 'no_image.png', '3', null, '', '', '', '', '', '', '93.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('6', '02KD', null, 'KAKADA_02', '3', '0.0000', '0.0000', '0', 'no_image.png', '3', null, '', '', '', '', '', '', null, '1', '1', '', null, 'code128', null, '', '0', 'standard', '0', null, null, null, null, null, null, null, null, null, null, null, '', '1970-01-01', '1970-01-01', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('7', 'RG-003', null, 'Return Group 3', '2', '91.0000', '0.0000', '2', 'no_image.png', '2', null, '', '', '', '', '', '', '10.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('8', 'RG-004', null, 'Return Group 4', '2', '90.4545', '0.0000', '2', 'no_image.png', '2', null, '', '', '', '', '', '', '10.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('9', 'MM-0001', null, 'Mey Mey', '1', '11.6989', '0.0000', '0', 'no_image.png', '1', null, '', '', '', '', '', '', '16.0000', '1', '1', '', null, 'code128', null, '', '1', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('10', 'YY-0001', null, 'Yong Yong', '1', '8.2819', '0.0000', '0', 'no_image.png', '1', null, '', '', '', '', '', '', '22.0000', '1', '1', '', null, 'code128', null, '', '1', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('11', 'RG-005', null, 'Return Group 5', '2', '108.5455', '0.0000', '2', 'no_image.png', '2', null, '', '', '', '', '', '', '10.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('12', 'MJ-0002', null, 'Mey Jing', '1', '127.0270', '0.0000', '0', 'no_image.png', '1', null, '', '', '', '', '', '', '0.0000', '1', '0', '', null, 'code128', null, '', '1', 'service', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('13', 'RG-006', null, 'Return Group 6', '2', '0.0000', '0.0000', '2', 'no_image.png', '2', null, '', '', '', '', '', '', '0.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('14', 'RG-007', null, 'Return Group 7', '2', '0.0000', '0.0000', '0', 'no_image.png', '2', null, '', '', '', '', '', '', '0.0000', '1', '1', '', null, 'code128', null, '', '1', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);
INSERT INTO `erp_products` VALUES ('15', 'COCACOLA-001', null, 'Coca Cola', '1', '10.0000', '15.0000', '0', 'no_image.png', '1', null, '', '', '', '', '', '', '0.0000', '1', '1', '', null, 'code128', null, '', '0', 'standard', null, null, null, null, null, null, null, null, null, null, null, null, '', '0000-00-00', '0000-00-00', null, null, null, null, null, 'USD', '0', null, null);

-- ----------------------------
-- Table structure for erp_product_note
-- ----------------------------
DROP TABLE IF EXISTS `erp_product_note`;
CREATE TABLE `erp_product_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `price` decimal(25,4) NOT NULL,
  `image` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_product_note
-- ----------------------------

-- ----------------------------
-- Table structure for erp_product_photos
-- ----------------------------
DROP TABLE IF EXISTS `erp_product_photos`;
CREATE TABLE `erp_product_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_product_photos
-- ----------------------------

-- ----------------------------
-- Table structure for erp_product_prices
-- ----------------------------
DROP TABLE IF EXISTS `erp_product_prices`;
CREATE TABLE `erp_product_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price_group_id` int(11) NOT NULL,
  `price` decimal(25,4) NOT NULL,
  `currency_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `price_group_id` (`price_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_product_prices
-- ----------------------------

-- ----------------------------
-- Table structure for erp_product_variants
-- ----------------------------
DROP TABLE IF EXISTS `erp_product_variants`;
CREATE TABLE `erp_product_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) DEFAULT NULL,
  `qty_unit` decimal(15,4) DEFAULT NULL,
  `currentcy_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_product_variants
-- ----------------------------

-- ----------------------------
-- Table structure for erp_purchases
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchases`;
CREATE TABLE `erp_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `biller_id` int(11) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `product_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT NULL,
  `product_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(55) DEFAULT '',
  `payment_status` varchar(20) DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `suspend_note` varchar(100) DEFAULT NULL,
  `reference_no_tax` varchar(100) NOT NULL,
  `tax_status` varchar(100) DEFAULT NULL,
  `opening_ap` tinyint(1) DEFAULT '0',
  `type_of_po` varchar(50) DEFAULT NULL,
  `order_ref` varchar(50) DEFAULT NULL,
  `request_ref` varchar(50) DEFAULT NULL,
  `paid_by` varchar(15) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `account_code` varchar(20) DEFAULT '',
  `pur_refer` varchar(50) DEFAULT NULL,
  `purchase_type` int(1) DEFAULT NULL,
  `purchase_status` varchar(20) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `item_status` varchar(25) DEFAULT NULL,
  `container_no` varchar(50) DEFAULT NULL,
  `container_size` decimal(25,4) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_reference_no` int(50) DEFAULT NULL,
  `good_or_services` varchar(255) DEFAULT NULL,
  `acc_cate_separate` int(1) DEFAULT NULL,
  `cogs` decimal(25,4) DEFAULT NULL,
  `updated_count` int(4) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchases
-- ----------------------------
INSERT INTO `erp_purchases` VALUES ('1', '1', 'PO/1706/00001', '2017-06-01 19:09:36', '3', 'General Supplier', '1', '', '1000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1000.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);
INSERT INTO `erp_purchases` VALUES ('2', '1', 'PO/1706/00002', '2017-06-01 19:10:22', '3', 'General Supplier', '1', '', '500.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '500.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);
INSERT INTO `erp_purchases` VALUES ('3', '5', 'PO/1706/00003', '2017-06-02 10:35:00', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '48.0000', 'received', 'paid', '1', '1', '2017-06-02 10:27:37', null, '0', null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', '0004');
INSERT INTO `erp_purchases` VALUES ('4', '4', 'PO/1706/00004', '2017-06-01 20:34:38', '3', 'General Supplier', '2', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', '0.0000', 'received', 'pending', '4', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', 'PAO/1706/00001', 'PQ/1706/00001', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);
INSERT INTO `erp_purchases` VALUES ('5', '1', 'PO/1706/00005', '2017-06-01 20:35:31', '3', 'General Supplier', '1', '', '1000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1000.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);
INSERT INTO `erp_purchases` VALUES ('6', '1', 'PO/1706/00006', '2017-06-01 20:35:45', '3', 'General Supplier', '1', '', '500.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '500.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);
INSERT INTO `erp_purchases` VALUES ('7', '5', 'PO/1706/00007', '2017-06-02 10:54:00', '3', 'General Supplier', '4', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '60.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 10:45:14', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', '0003');
INSERT INTO `erp_purchases` VALUES ('8', '5', 'PO/1706/00008', '2017-06-02 12:02:00', '3', 'General Supplier', '4', '', '60.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '70.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 11:53:18', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', '0002');
INSERT INTO `erp_purchases` VALUES ('9', '1', 'PO/1706/00009', '2017-06-02 15:18:40', '3', 'General Supplier', '1', '', '990.0000', '10.0000', '10', '99.0000', '109.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '901.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);
INSERT INTO `erp_purchases` VALUES ('10', '1', 'PO/1706/00010', '2017-06-03 09:06:00', '3', 'General Supplier', '1', '', '1980.0000', '220.0000', null, '0.0000', '220.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '1990.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 09:21:39', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', '0002');
INSERT INTO `erp_purchases` VALUES ('11', '1', 'PO/1706/00011', '2017-06-03 11:07:43', '3', 'General Supplier', '1', '', '185.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '50.0000', '235.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);
INSERT INTO `erp_purchases` VALUES ('12', '1', 'PO/1706/00012', '2017-06-03 12:07:00', '3', 'General Supplier', '1', '', '35.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '50.0000', '85.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 11:59:33', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', '0002');
INSERT INTO `erp_purchases` VALUES ('13', '1', 'PO/1706/00013', '2017-06-03 11:41:21', '3', 'General Supplier', '1', '', '3150.0000', '150.0000', null, '0.0000', '150.0000', '300.0000', '1', '0.0000', '300.0000', '100.0000', '3250.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.0000', null);

-- ----------------------------
-- Table structure for erp_purchases_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchases_audit`;
CREATE TABLE `erp_purchases_audit` (
  `id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `product_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT NULL,
  `product_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(55) DEFAULT '',
  `payment_status` varchar(20) DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `suspend_note` varchar(100) DEFAULT NULL,
  `reference_no_tax` varchar(100) NOT NULL,
  `tax_status` varchar(100) DEFAULT NULL,
  `opening_ap` tinyint(1) DEFAULT '0',
  `type_of_po` varchar(50) DEFAULT NULL,
  `order_ref` varchar(50) DEFAULT NULL,
  `request_ref` varchar(50) DEFAULT NULL,
  `paid_by` varchar(15) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `account_code` varchar(20) DEFAULT '',
  `pur_refer` varchar(50) DEFAULT NULL,
  `purchase_type` int(1) DEFAULT NULL,
  `purchase_status` varchar(20) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `item_status` varchar(25) DEFAULT NULL,
  `container_no` varchar(50) DEFAULT NULL,
  `container_size` decimal(25,4) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_reference_no` int(50) DEFAULT NULL,
  `good_or_services` varchar(255) DEFAULT NULL,
  `acc_cate_separate` int(1) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchases_audit
-- ----------------------------
INSERT INTO `erp_purchases_audit` VALUES ('3', '1', 'PO/1706/00003', '2017-06-01 19:23:34', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '0', '2017-06-01 19:27:33', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('3', '1', 'PO/1706/00003', '2017-06-01 19:23:34', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '48.0000', 'received', 'paid', '1', null, null, null, '0', null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', '0', '2017-06-02 10:15:57', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('3', '5', 'PO/1706/00003', '2017-06-02 09:53:00', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '48.0000', 'received', 'paid', '1', '1', '2017-06-02 10:15:57', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '3', '0', '2017-06-02 10:19:19', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('3', '5', 'PO/1706/00003', '2017-06-02 09:53:00', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '48.0000', 'received', 'paid', '1', '1', '2017-06-02 10:19:19', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '4', '0', '2017-06-02 10:24:12', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('3', '5', 'PO/1706/00003', '2017-06-02 09:53:00', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '48.0000', 'received', 'paid', '1', '1', '2017-06-02 10:24:12', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '5', '0', '2017-06-02 10:24:14', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('3', '5', 'PO/1706/00003', '2017-06-02 09:53:00', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '48.0000', 'received', 'paid', '1', '1', '2017-06-02 10:24:12', null, '0', null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '6', '0', '2017-06-02 10:27:37', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('3', '5', 'PO/1706/00003', '2017-06-02 10:35:00', '3', 'General Supplier', '1', '', '43.0000', '2.0000', null, '0.0000', '2.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '48.0000', '48.0000', 'received', 'paid', '1', '1', '2017-06-02 10:27:37', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '7', '0', '2017-06-02 10:27:40', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('7', '5', 'PO/1706/00007', '2017-06-02 10:38:50', '3', 'General Supplier', '4', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '60.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '8', '0', '2017-06-02 10:44:08', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('7', '5', 'PO/1706/00007', '2017-06-02 10:52:00', '3', 'General Supplier', '4', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '60.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 10:44:08', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '9', '0', '2017-06-02 10:44:16', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('7', '5', 'PO/1706/00007', '2017-06-02 10:52:00', '3', 'General Supplier', '4', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '60.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 10:44:08', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '10', '0', '2017-06-02 10:44:39', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('7', '5', 'PO/1706/00007', '2017-06-02 10:53:00', '3', 'General Supplier', '4', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '60.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 10:44:39', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '11', '0', '2017-06-02 10:44:42', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('7', '5', 'PO/1706/00007', '2017-06-02 10:53:00', '3', 'General Supplier', '4', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '60.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 10:44:39', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '12', '0', '2017-06-02 10:45:14', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('7', '5', 'PO/1706/00007', '2017-06-02 10:54:00', '3', 'General Supplier', '4', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '60.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 10:45:14', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '13', '0', '2017-06-02 10:45:18', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('8', '5', 'PO/1706/00008', '2017-06-02 10:57:42', '3', 'General Supplier', '4', '', '60.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '70.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '14', '0', '2017-06-02 11:30:27', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('8', '5', 'PO/1706/00008', '2017-06-02 11:37:00', '3', 'General Supplier', '4', '', '60.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '70.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 11:30:27', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '15', '0', '2017-06-02 11:30:29', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('8', '5', 'PO/1706/00008', '2017-06-02 11:37:00', '3', 'General Supplier', '4', '', '60.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '70.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 11:30:27', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '16', '0', '2017-06-02 11:53:18', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('8', '5', 'PO/1706/00008', '2017-06-02 12:02:00', '3', 'General Supplier', '4', '', '60.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '70.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-02 11:53:18', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '17', '0', '2017-06-02 11:53:27', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('10', '1', 'PO/1706/00010', '2017-06-03 08:23:29', '3', 'General Supplier', '1', '', '1980.0000', '220.0000', null, '0.0000', '220.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '1990.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '18', '0', '2017-06-03 08:53:26', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('10', '1', 'PO/1706/00010', '2017-06-03 08:54:00', '3', 'General Supplier', '1', '', '2178.0000', '22.0000', null, '0.0000', '22.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '2188.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 08:53:26', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '19', '0', '2017-06-03 08:53:28', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('10', '1', 'PO/1706/00010', '2017-06-03 08:54:00', '3', 'General Supplier', '1', '', '2178.0000', '22.0000', null, '0.0000', '22.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '2188.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 08:53:26', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20', '0', '2017-06-03 09:21:39', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('10', '1', 'PO/1706/00010', '2017-06-03 09:06:00', '3', 'General Supplier', '1', '', '1980.0000', '220.0000', null, '0.0000', '220.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '1990.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 09:21:39', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '21', '0', '2017-06-03 09:21:45', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('12', '1', 'PO/1706/00012', '2017-06-03 11:30:52', '3', 'General Supplier', '1', '', '35.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '50.0000', '85.0000', '0.0000', 'received', 'pending', '1', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '22', '0', '2017-06-03 11:44:45', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('12', '1', 'PO/1706/00012', '2017-06-03 11:52:00', '3', 'General Supplier', '1', '', '35.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '50.0000', '85.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 11:44:45', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '23', '0', '2017-06-03 11:44:47', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('12', '1', 'PO/1706/00012', '2017-06-03 11:52:00', '3', 'General Supplier', '1', '', '35.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '50.0000', '85.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 11:44:45', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '24', '0', '2017-06-03 11:59:33', 'UPDATED');
INSERT INTO `erp_purchases_audit` VALUES ('12', '1', 'PO/1706/00012', '2017-06-03 12:07:00', '3', 'General Supplier', '1', '', '35.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '50.0000', '85.0000', '0.0000', 'received', 'pending', '1', '1', '2017-06-03 11:59:33', null, null, null, null, '0.0000', null, '', null, '0', 'po', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '25', '0', '2017-06-03 11:59:36', 'UPDATED');

-- ----------------------------
-- Table structure for erp_purchases_order
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchases_order`;
CREATE TABLE `erp_purchases_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `biller_id` int(11) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `purchase_ref` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `product_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT NULL,
  `product_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(55) DEFAULT '',
  `payment_status` varchar(20) DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `suspend_note` varchar(100) DEFAULT NULL,
  `reference_no_tax` varchar(100) NOT NULL,
  `tax_status` varchar(100) DEFAULT NULL,
  `purchase_type` int(1) DEFAULT NULL,
  `purchase_status` varchar(20) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `order_status` varchar(15) DEFAULT 'pending',
  `request_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchases_order
-- ----------------------------
INSERT INTO `erp_purchases_order` VALUES ('1', '4', 'PAO/1706/00001', 'PQ/1706/00001', '2017-06-01 20:34:08', '3', 'General Supplier', '2', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 'approved', null, '4', null, null, null, null, null, null, '0.0000', null, '', null, null, null, null, 'completed', '1');
INSERT INTO `erp_purchases_order` VALUES ('2', '1', 'PAO/1706/00002', '', '2017-06-02 14:48:00', '3', 'General Supplier', '1', '', '316.5000', '0.0000', '5%', '15.8300', '15.8300', '0.0000', '2', '35.0700', '35.0700', '50.0000', '385.7400', '0.0000', 'approved', null, '1', null, null, null, null, null, null, '0.0000', null, '', null, null, null, null, 'pending', '0');

-- ----------------------------
-- Table structure for erp_purchases_order_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchases_order_audit`;
CREATE TABLE `erp_purchases_order_audit` (
  `id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `purchase_ref` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `product_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT NULL,
  `product_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(55) DEFAULT '',
  `payment_status` varchar(20) DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `suspend_note` varchar(100) DEFAULT NULL,
  `reference_no_tax` varchar(100) NOT NULL,
  `tax_status` varchar(100) DEFAULT NULL,
  `purchase_type` int(1) DEFAULT NULL,
  `purchase_status` varchar(20) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `order_status` varchar(15) DEFAULT 'pending',
  `request_id` int(11) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchases_order_audit
-- ----------------------------
INSERT INTO `erp_purchases_order_audit` VALUES ('1', '4', 'PAO/1706/00001', 'PQ/1706/00001', '2017-06-01 20:34:08', '3', 'General Supplier', '2', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 'pending', null, '4', null, null, null, null, null, null, '0.0000', null, '', null, null, null, null, 'pending', '1', '1', '0', '2017-06-01 20:34:14', 'UPDATED');
INSERT INTO `erp_purchases_order_audit` VALUES ('1', '4', 'PAO/1706/00001', 'PQ/1706/00001', '2017-06-01 20:34:08', '3', 'General Supplier', '2', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 'approved', null, '4', null, null, null, null, null, null, '0.0000', null, '', null, null, null, null, 'pending', '1', '2', '0', '2017-06-01 20:34:39', 'UPDATED');
INSERT INTO `erp_purchases_order_audit` VALUES ('2', '1', 'PAO/1706/00002', '', '2017-06-02 14:48:00', '3', 'General Supplier', '1', '', '316.5000', '0.0000', '5%', '15.8300', '15.8300', '0.0000', '2', '35.0700', '35.0700', '50.0000', '385.7400', '0.0000', 'pending', null, '1', null, null, null, null, null, null, '0.0000', null, '', null, null, null, null, 'pending', '0', '3', '0', '2017-06-02 14:41:11', 'UPDATED');

-- ----------------------------
-- Table structure for erp_purchases_request
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchases_request`;
CREATE TABLE `erp_purchases_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `biller_id` int(11) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `product_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT NULL,
  `product_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(55) DEFAULT '',
  `payment_status` varchar(20) DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `suspend_note` varchar(100) DEFAULT NULL,
  `reference_no_tax` varchar(100) NOT NULL,
  `tax_status` varchar(100) DEFAULT NULL,
  `opening_ap` tinyint(1) DEFAULT '0',
  `order_status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchases_request
-- ----------------------------
INSERT INTO `erp_purchases_request` VALUES ('1', '4', 'PQ/1706/00001', '2017-06-01 20:27:39', '3', 'General Supplier', '2', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 'approved', null, '4', null, null, null, null, null, null, '0.0000', null, '', null, '0', 'completed');

-- ----------------------------
-- Table structure for erp_purchase_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchase_items`;
CREATE TABLE `erp_purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `product_type` varchar(55) DEFAULT NULL,
  `net_unit_cost` decimal(25,8) NOT NULL,
  `quantity` decimal(15,8) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_tax` decimal(25,8) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `item_discount` decimal(25,8) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `subtotal` decimal(25,8) NOT NULL,
  `quantity_balance` decimal(15,8) DEFAULT '0.00000000',
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit_cost` decimal(25,8) DEFAULT NULL,
  `real_unit_cost` decimal(25,8) DEFAULT NULL,
  `quantity_received` decimal(15,8) DEFAULT NULL,
  `supplier_part_no` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `job_name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `convert_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `opening_stock` int(11) DEFAULT NULL,
  `create_id` int(11) DEFAULT NULL,
  `returned` decimal(15,8) DEFAULT NULL,
  `acc_cate_separate` tinyint(1) DEFAULT NULL,
  `specific_tax_on_certain_merchandise_and_services` int(10) DEFAULT NULL,
  `accommodation_tax` int(10) DEFAULT NULL,
  `public_lighting_tax` int(10) DEFAULT NULL,
  `other_tax` int(10) DEFAULT NULL,
  `payment_of_profit_tax` int(10) DEFAULT NULL,
  `performance_royalty_intangible` int(10) DEFAULT NULL,
  `payment_interest_non_bank` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_fixed` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_non_fixed` int(10) DEFAULT NULL,
  `payment_rental_immovable_property` int(10) DEFAULT NULL,
  `payment_of_interest` int(10) DEFAULT NULL,
  `payment_royalty_rental_income_related` int(10) DEFAULT NULL,
  `payment_management_technical` int(10) DEFAULT NULL,
  `payment_dividend` int(10) DEFAULT NULL,
  `withholding_tax_on_resident` int(10) DEFAULT NULL,
  `withholding_tax_on_non_resident` int(10) DEFAULT NULL,
  `transaction_type` varchar(25) DEFAULT '' COMMENT 'Ex: SALE or PURCHASE',
  `transaction_id` int(11) DEFAULT NULL,
  `net_shipping` decimal(25,8) DEFAULT NULL,
  `cb_avg` decimal(25,8) DEFAULT '0.00000000' COMMENT '0',
  `cb_qty` decimal(25,8) DEFAULT '0.00000000' COMMENT '0',
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchase_items
-- ----------------------------
INSERT INTO `erp_purchase_items` VALUES ('1', '0', '1', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.00000000', '10.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '1000.00000000', '10.00000000', '2017-06-01', 'received', '100.00000000', '100.00000000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '1', '0.00000000', null, null);
INSERT INTO `erp_purchase_items` VALUES ('2', '0', '2', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.00000000', '5.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '500.00000000', '5.00000000', '2017-06-01', 'received', '100.00000000', '100.00000000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '2', '0.00000000', null, null);
INSERT INTO `erp_purchase_items` VALUES ('5', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '2.50000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '24.00000000', '-1.00000000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, null, null);
INSERT INTO `erp_purchase_items` VALUES ('8', '0', '4', null, '5', '01KD', 'KAKADA_01', '0', null, '20.00000000', '100.00000000', '2', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '2000.00000000', '0.00000000', '2017-06-01', 'received', '20.00000000', '20.00000000', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '8', '0.00000000', '0.00000000', null);
INSERT INTO `erp_purchase_items` VALUES ('17', '0', null, '1', '5', '01KD', 'KAKADA_01', '0', null, '20.00000000', '50.00000000', '4', '0.00000000', '1', '0.0000', null, null, null, '1000.00000000', '0.00000000', '2017-06-01', 'received', '20.00000000', '20.00000000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'TRANSFER', '1', null, null, null);
INSERT INTO `erp_purchase_items` VALUES ('18', '0', null, '2', '5', '01KD', 'KAKADA_01', '0', null, '20.00000000', '50.00000000', '2', '0.00000000', '1', '0.0000', null, null, null, '1000.00000000', '50.00000000', '2017-06-01', 'received', '20.00000000', '20.00000000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'TRANSFER', '2', null, null, null);
INSERT INTO `erp_purchase_items` VALUES ('20', '0', null, '3', '5', '01KD', 'KAKADA_01', '0', null, '20.00000000', '50.00000000', '4', '0.00000000', '1', '0.0000', null, null, null, '1000.00000000', '50.00000000', '2017-06-02', 'received', '20.00000000', '20.00000000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'TRANSFER', '3', null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('21', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '4', '0.00000000', null, null, null, null, null, '0.00000000', '10.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('22', '0', null, null, '4', '', '', null, null, '0.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('23', '0', null, null, '1', '', '', null, null, '0.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '0.00000000', '-10.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('26', '0', null, null, '1', '1', 'Product_test', null, null, '0.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('28', '0', null, null, '6', '', '', null, null, '0.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '0.00000000', '-2.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('33', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.50000000', '10.00000000', '1', '0.00000000', '1', '0.0000', '1', '1.00000000', null, '24.00000000', '10.00000000', '2017-06-02', 'received', '2.50000000', '2.76923077', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '33', '0.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('34', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.00000000', '10.00000000', '1', '0.00000000', '1', '0.0000', '1', '1.00000000', null, '19.00000000', '10.00000000', '2017-06-02', 'received', '2.00000000', '2.23076923', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '34', '0.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('41', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.77000000', '10.00000000', '4', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '27.70000000', '10.00000000', '2017-06-02', 'received', '2.77000000', '3.30846154', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '41', '0.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('42', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.23000000', '10.00000000', '4', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '22.30000000', '10.00000000', '2017-06-02', 'received', '2.23000000', '2.69153846', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '42', '0.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('47', '0', '8', null, '2', 'RG-001', 'Return Group 1', '0', null, '3.31000000', '10.00000000', '4', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '33.10000000', '10.00000000', '2017-06-02', 'received', '3.31000000', '3.49469363', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '47', '0.00000000', '3.30850000', '19.00000000');
INSERT INTO `erp_purchase_items` VALUES ('48', '0', '8', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.69000000', '10.00000000', '4', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '26.90000000', '10.00000000', '2017-06-02', 'received', '2.69000000', '2.84484615', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '48', '0.00000000', '2.69150000', '20.00000000');
INSERT INTO `erp_purchase_items` VALUES ('50', '0', null, null, '5', '', '', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-5.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('51', '0', null, null, '6', '', '', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-5.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('53', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-5.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('54', '0', null, null, '6', '02KD', 'KAKADA_02', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-5.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('55', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-10.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('56', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '10.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('57', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-15.00000000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('58', '0', '9', null, '7', 'RG-003', 'Return Group 3', '0', null, '100.00000000', '10.00000000', '1', '0.00000000', '1', '0.0000', '10', '10.00000000', null, '990.00000000', '10.00000000', '2017-06-02', 'received', '100.00000000', '91.00000000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '58', '1.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('59', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '500.00000000', '-2.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('60', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('61', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('62', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('63', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('64', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '500.00000000', '-2.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('65', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('66', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('67', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('68', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('69', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '500.00000000', '-2.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('70', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('71', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('72', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('73', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('74', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '500.00000000', '-2.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('75', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '500.00000000', '-2.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('76', '0', null, null, '1', '1', 'Product_test', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-1.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('77', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '500.00000000', '-2.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('78', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '2.50000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '24.00000000', '-5.00000000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('79', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '0.00000000', '-10.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('80', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '500.00000000', '-5.00000000', '2017-06-03', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('81', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1000.00000000', '-6.00000000', '2017-06-03', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('82', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-5.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('83', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('84', '0', null, null, '6', '02KD', 'KAKADA_02', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('87', '0', null, null, '1', '1', 'Product_test', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-5.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('88', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-10.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('91', '0', '10', null, '8', 'RG-004', 'Return Group 4', '0', null, '100.00000000', '10.00000000', '1', '0.00000000', '1', '0.0000', '10%', '100.00000000', null, '900.00000000', '10.00000000', '2017-06-03', 'received', '100.00000000', '90.45454545', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '91', '0.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('92', '0', '10', null, '11', 'RG-005', 'Return Group 5', '0', null, '120.00000000', '10.00000000', '1', '0.00000000', '1', '0.0000', '10%', '120.00000000', null, '1080.00000000', '10.00000000', '2017-06-03', 'received', '120.00000000', '108.54545455', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '92', '0.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('93', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('94', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('95', '0', null, null, '1', '1', 'Product_test', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('96', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('97', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('98', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('99', '0', null, null, '1', '1', 'Product_test', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('100', '0', null, null, '1', '1', 'Product_test', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('101', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-1.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('102', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-5.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('103', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '20.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '1000.00000000', '-2.00000000', '2017-06-03', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('104', '0', '11', null, '12', 'MJ-0002', 'Mey Jing', '0', null, '100.00000000', '1.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '100.00000000', '1.00000000', '2017-06-03', 'received', '100.00000000', '127.02702703', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '104', '0.00000000', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('105', '0', '11', null, '9', 'MM-0001', 'Mey Mey', '0', null, '15.00000000', '3.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '45.00000000', '3.00000000', '2017-06-03', 'received', '15.00000000', '19.05405405', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '105', '26.47058824', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('106', '0', '11', null, '10', 'YY-0001', 'Yong Yong', '0', null, '20.00000000', '2.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '40.00000000', '2.00000000', '2017-06-03', 'received', '20.00000000', '25.40540541', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '106', '23.52941176', '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('109', '0', '13', null, '10', 'YY-0001', 'Yong Yong', null, null, '200.00000000', '10.00000000', '1', '200.00000000', '2', '10.0000%', '100', '100.00000000', null, '2100.00000000', '10.00000000', '2017-06-03', 'received', '200.00000000', '103.30527879', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '109', '60.31746032', '8.28190000', '12.00000000');
INSERT INTO `erp_purchase_items` VALUES ('110', '0', '13', null, '9', 'MM-0001', 'Mey Mey', null, null, '100.00000000', '10.00000000', '1', '100.00000000', '2', '10.0000%', '50', '50.00000000', null, '1050.00000000', '10.00000000', '2017-06-03', 'received', '100.00000000', '62.79210370', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '110', '30.15873016', '11.69890000', '8.00000000');
INSERT INTO `erp_purchase_items` VALUES ('113', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '2.50000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '24.00000000', '-2.00000000', '2017-06-03', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('114', '0', null, null, '4', '', '', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-2.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('115', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '0.00000000', '-4.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('116', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('117', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('118', '0', null, null, '5', '01KD', 'KAKADA_01', null, null, '0.00000000', '0.00000000', '2', '0.00000000', null, null, null, null, null, '0.00000000', '-4.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('119', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('120', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('121', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('122', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('123', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('124', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '3.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('125', '0', null, null, '9', 'MM-0001', 'Mey Mey', null, null, '100.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '1050.00000000', '-2.00000000', '2017-06-03', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('126', '0', null, null, '2', 'RG-001', 'Return Group 1', null, null, '0.00000000', '0.00000000', '1', '0.00000000', null, null, null, null, null, '0.00000000', '-2.00000000', '2017-06-03', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000', '0.00000000');
INSERT INTO `erp_purchase_items` VALUES ('127', '0', '12', null, '9', 'MM-0001', 'Mey Mey', '0', null, '3.00000000', '5.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '15.00000000', '5.00000000', '2017-06-03', 'received', '3.00000000', '11.69885893', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '127', '0.00000000', '19.05410000', '3.00000000');
INSERT INTO `erp_purchase_items` VALUES ('128', '0', '12', null, '10', 'YY-0001', 'Yong Yong', '0', null, '2.00000000', '10.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '20.00000000', '10.00000000', '2017-06-03', 'received', '2.00000000', '8.28185238', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'PURCHASE', '128', '0.00000000', '25.40540000', '2.00000000');

-- ----------------------------
-- Table structure for erp_purchase_items_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchase_items_audit`;
CREATE TABLE `erp_purchase_items_audit` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `product_type` varchar(55) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `quantity_balance` decimal(15,4) DEFAULT '0.0000',
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit_cost` decimal(25,4) DEFAULT NULL,
  `real_unit_cost` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) DEFAULT NULL,
  `supplier_part_no` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `job_name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `convert_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `opening_stock` int(11) DEFAULT NULL,
  `create_id` int(11) DEFAULT NULL,
  `returned` decimal(15,4) DEFAULT NULL,
  `acc_cate_separate` tinyint(1) DEFAULT NULL,
  `specific_tax_on_certain_merchandise_and_services` int(10) DEFAULT NULL,
  `accommodation_tax` int(10) DEFAULT NULL,
  `public_lighting_tax` int(10) DEFAULT NULL,
  `other_tax` int(10) DEFAULT NULL,
  `payment_of_profit_tax` int(10) DEFAULT NULL,
  `performance_royalty_intangible` int(10) DEFAULT NULL,
  `payment_interest_non_bank` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_fixed` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_non_fixed` int(10) DEFAULT NULL,
  `payment_rental_immovable_property` int(10) DEFAULT NULL,
  `payment_of_interest` int(10) DEFAULT NULL,
  `payment_royalty_rental_income_related` int(10) DEFAULT NULL,
  `payment_management_technical` int(10) DEFAULT NULL,
  `payment_dividend` int(10) DEFAULT NULL,
  `withholding_tax_on_resident` int(10) DEFAULT NULL,
  `withholding_tax_on_non_resident` int(10) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchase_items_audit
-- ----------------------------
INSERT INTO `erp_purchase_items_audit` VALUES ('1', '0', '1', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '1000.0000', '10.0000', '2017-06-01', 'received', '100.0000', '100.0000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '0', '2017-06-01 19:09:37', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('2', '0', '2', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '500.0000', '5.0000', '2017-06-01', 'received', '100.0000', '100.0000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', '0', '2017-06-01 19:10:23', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('3', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.5000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '24.0000', '10.0000', '2017-06-01', 'received', '2.5000', '2.7692', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '3', '0', '2017-06-01 19:23:34', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('4', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-01', 'received', '2.0000', '2.2308', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '4', '0', '2017-06-01 19:23:35', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('3', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.5000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '24.0000', '10.0000', '2017-06-01', 'received', '2.5000', '2.7692', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '5', '0', '2017-06-01 19:48:17', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('4', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-01', 'received', '2.0000', '2.2308', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '6', '0', '2017-06-01 19:48:19', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('8', '0', '4', null, '5', '01KD', 'KAKADA_01', '0', null, '20.0000', '100.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', null, '2000.0000', '100.0000', '2017-06-01', 'received', '20.0000', '20.0000', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '7', '0', '2017-06-01 20:34:39', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('9', '0', '5', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '1000.0000', '10.0000', '2017-06-01', 'received', '100.0000', '100.0000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '8', '0', '2017-06-01 20:35:31', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('10', '0', '6', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '500.0000', '5.0000', '2017-06-01', 'received', '100.0000', '100.0000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '9', '0', '2017-06-01 20:35:46', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('12', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '1000.0000', '-10.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '10', '0', '2017-06-01 20:38:35', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('11', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '500.0000', '-5.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '11', '0', '2017-06-01 20:38:35', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('10', '0', '6', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '500.0000', '5.0000', '2017-06-01', 'received', '100.0000', '100.0000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '12', '0', '2017-06-01 20:38:35', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('9', '0', '5', null, '4', 'CAM-0001', 'Cambodia', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '1000.0000', '10.0000', '2017-06-01', 'received', '100.0000', '100.0000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '13', '0', '2017-06-01 20:38:36', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('7', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '1000.0000', '-10.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '14', '0', '2017-06-01 20:38:52', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('6', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '500.0000', '-5.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '15', '0', '2017-06-01 20:38:52', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('14', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '1000.0000', '-10.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '16', '0', '2017-06-01 20:42:31', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('13', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '500.0000', '-5.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '17', '0', '2017-06-01 20:42:31', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('16', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '1000.0000', '-10.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '18', '0', '2017-06-01 20:49:03', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('15', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '500.0000', '-5.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '19', '0', '2017-06-01 20:49:04', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('8', '0', '4', null, '5', '01KD', 'KAKADA_01', '0', null, '20.0000', '100.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', null, '2000.0000', '100.0000', '2017-06-01', 'received', '20.0000', '20.0000', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20', '0', '2017-06-01 20:58:07', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('17', '0', null, '1', '5', '01KD', 'KAKADA_01', '0', null, '20.0000', '50.0000', '4', '0.0000', '1', '0.0000', null, null, null, '1000.0000', '50.0000', '2017-06-01', 'received', '20.0000', '20.0000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '21', '0', '2017-06-01 21:00:39', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('3', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.5000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '24.0000', '10.0000', '2017-06-01', 'received', '2.5000', '2.7692', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '22', '0', '2017-06-01 21:14:00', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('4', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-01', 'received', '2.0000', '2.2308', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '23', '0', '2017-06-01 21:14:00', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('19', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '1000.0000', '-5.0000', '2017-06-01', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '24', '0', '2017-06-02 08:07:05', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('8', '0', '4', null, '5', '01KD', 'KAKADA_01', '0', null, '20.0000', '100.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', null, '2000.0000', '50.0000', '2017-06-01', 'received', '20.0000', '20.0000', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '25', '0', '2017-06-02 08:13:59', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('3', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.5000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '24.0000', '10.0000', '2017-06-01', 'received', '2.5000', '2.7692', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '26', '0', '2017-06-02 10:15:57', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('4', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-01', 'received', '2.0000', '2.2308', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '27', '0', '2017-06-02 10:15:57', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('29', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-02', 'received', '2.0000', '2.2308', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '29', '0', '2017-06-02 10:19:20', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('30', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-02', 'received', '2.0000', '2.2308', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '31', '0', '2017-06-02 10:24:13', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('31', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-02', 'received', '2.0000', '2.2308', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '32', '0', '2017-06-02 10:24:13', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('32', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.5000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '24.0000', '10.0000', '2017-06-02', 'received', '2.5000', '2.7692', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '33', '0', '2017-06-02 10:24:13', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('31', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-02', 'received', '2.0000', '2.2308', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '34', '0', '2017-06-02 10:27:38', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('32', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.5000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '24.0000', '10.0000', '2017-06-02', 'received', '2.5000', '2.7692', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '35', '0', '2017-06-02 10:27:38', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('33', '0', '3', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.5000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '24.0000', '10.0000', '2017-06-02', 'received', '2.5000', '2.7692', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '36', '0', '2017-06-02 10:27:38', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('34', '0', '3', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '1', '1.0000', null, '19.0000', '10.0000', '2017-06-02', 'received', '2.0000', '2.2308', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '37', '0', '2017-06-02 10:27:39', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('35', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.2300', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '22.3000', '10.0000', '2017-06-02', 'received', '2.2300', '2.4612', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '38', '0', '2017-06-02 10:38:50', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('36', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.7700', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '27.7000', '10.0000', '2017-06-02', 'received', '2.7700', '3.0530', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '39', '0', '2017-06-02 10:38:50', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('35', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.2300', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '22.3000', '10.0000', '2017-06-02', 'received', '2.2300', '2.4612', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '40', '0', '2017-06-02 10:44:09', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('36', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.7700', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '27.7000', '10.0000', '2017-06-02', 'received', '2.7700', '3.0530', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '41', '0', '2017-06-02 10:44:09', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('37', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.7700', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '27.7000', '10.0000', '2017-06-02', 'received', '2.7700', '3.0530', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '42', '0', '2017-06-02 10:44:10', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('38', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.2300', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '22.3000', '10.0000', '2017-06-02', 'received', '2.2300', '2.4612', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '43', '0', '2017-06-02 10:44:14', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('37', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.7700', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '27.7000', '10.0000', '2017-06-02', 'received', '2.7700', '3.0530', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '44', '0', '2017-06-02 10:44:40', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('38', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.2300', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '22.3000', '10.0000', '2017-06-02', 'received', '2.2300', '2.4612', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '45', '0', '2017-06-02 10:44:40', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('39', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.2300', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '22.3000', '10.0000', '2017-06-02', 'received', '2.2300', '2.6915', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '46', '0', '2017-06-02 10:44:40', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('40', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.7700', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '27.7000', '10.0000', '2017-06-02', 'received', '2.7700', '3.3085', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '47', '0', '2017-06-02 10:44:40', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('39', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.2300', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '22.3000', '10.0000', '2017-06-02', 'received', '2.2300', '2.6915', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '48', '0', '2017-06-02 10:45:14', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('40', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.7700', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '27.7000', '10.0000', '2017-06-02', 'received', '2.7700', '3.3085', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '49', '0', '2017-06-02 10:45:14', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('41', '0', '7', null, '2', 'RG-001', 'Return Group 1', '0', null, '2.7700', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '27.7000', '10.0000', '2017-06-02', 'received', '2.7700', '3.3085', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '50', '0', '2017-06-02 10:45:15', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('42', '0', '7', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.2300', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '22.3000', '10.0000', '2017-06-02', 'received', '2.2300', '2.6915', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '51', '0', '2017-06-02 10:45:16', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('43', '0', '8', null, '2', 'RG-001', 'Return Group 1', '0', null, '3.3100', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '33.1000', '10.0000', '2017-06-02', 'received', '3.3100', '3.4947', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '52', '0', '2017-06-02 10:57:42', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('44', '0', '8', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.6900', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '26.9000', '10.0000', '2017-06-02', 'received', '2.6900', '2.8448', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '53', '0', '2017-06-02 10:57:43', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('43', '0', '8', null, '2', 'RG-001', 'Return Group 1', '0', null, '3.3100', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '33.1000', '10.0000', '2017-06-02', 'received', '3.3100', '3.4947', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '54', '0', '2017-06-02 11:30:27', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('44', '0', '8', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.6900', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '26.9000', '10.0000', '2017-06-02', 'received', '2.6900', '2.8448', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '55', '0', '2017-06-02 11:30:27', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('45', '0', '8', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.6900', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '26.9000', '10.0000', '2017-06-02', 'received', '2.6900', '2.8448', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '56', '0', '2017-06-02 11:30:28', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('46', '0', '8', null, '2', 'RG-001', 'Return Group 1', '0', null, '3.3100', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '33.1000', '10.0000', '2017-06-02', 'received', '3.3100', '3.4947', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '57', '0', '2017-06-02 11:30:28', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('45', '0', '8', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.6900', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '26.9000', '10.0000', '2017-06-02', 'received', '2.6900', '2.8448', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '58', '0', '2017-06-02 11:53:19', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('46', '0', '8', null, '2', 'RG-001', 'Return Group 1', '0', null, '3.3100', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '33.1000', '10.0000', '2017-06-02', 'received', '3.3100', '3.4947', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '59', '0', '2017-06-02 11:53:19', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('47', '0', '8', null, '2', 'RG-001', 'Return Group 1', '0', null, '3.3100', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '33.1000', '10.0000', '2017-06-02', 'received', '3.3100', '3.4947', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '60', '0', '2017-06-02 11:53:20', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('48', '0', '8', null, '3', 'RG-002', 'Return Group 2', '0', null, '2.6900', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', null, '26.9000', '10.0000', '2017-06-02', 'received', '2.6900', '2.8448', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '61', '0', '2017-06-02 11:53:21', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('52', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '0.0000', '-4.0000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '62', '0', '2017-06-02 14:08:33', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('49', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '100.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '500.0000', '-4.0000', '2017-06-02', 'received', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '63', '0', '2017-06-02 14:08:34', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('27', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.0000', '0.0000', '2', '0.0000', null, null, null, null, null, '0.0000', '-1.0000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '64', '0', '2017-06-02 14:08:34', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('25', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.0000', '0.0000', '2', '0.0000', null, null, null, null, null, '0.0000', '-5.0000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '65', '0', '2017-06-02 14:08:34', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('24', '0', null, null, '4', 'CAM-0001', 'Cambodia', null, null, '0.0000', '0.0000', '2', '0.0000', null, null, null, null, null, '0.0000', '-5.0000', '2017-06-02', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '66', '0', '2017-06-02 14:08:35', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('58', '0', '9', null, '7', 'RG-003', 'Return Group 3', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10', '10.0000', null, '990.0000', '10.0000', '2017-06-02', 'received', '100.0000', '91.0000', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '67', '0', '2017-06-02 15:18:40', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('85', '0', '10', null, '8', 'RG-004', 'Return Group 4', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '100.0000', null, '900.0000', '10.0000', '2017-06-03', 'received', '100.0000', '90.4545', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '68', '0', '2017-06-03 08:23:32', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('86', '0', '10', null, '11', 'RG-005', 'Return Group 5', '0', null, '120.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '120.0000', null, '1080.0000', '10.0000', '2017-06-03', 'received', '120.0000', '108.5455', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '69', '0', '2017-06-03 08:23:34', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('85', '0', '10', null, '8', 'RG-004', 'Return Group 4', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '100.0000', null, '900.0000', '10.0000', '2017-06-03', 'received', '100.0000', '90.4545', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '70', '0', '2017-06-03 08:53:27', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('86', '0', '10', null, '11', 'RG-005', 'Return Group 5', '0', null, '120.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '120.0000', null, '1080.0000', '10.0000', '2017-06-03', 'received', '120.0000', '108.5455', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '71', '0', '2017-06-03 08:53:27', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('89', '0', '10', null, '11', 'RG-005', 'Return Group 5', '0', null, '120.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '12.0000', null, '1188.0000', '10.0000', '2017-06-03', 'received', '120.0000', '108.5455', '10.0000', null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '72', '0', '2017-06-03 08:53:27', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('90', '0', '10', null, '8', 'RG-004', 'Return Group 4', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '10.0000', null, '990.0000', '10.0000', '2017-06-03', 'received', '100.0000', '90.4545', '10.0000', null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '73', '0', '2017-06-03 08:53:27', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('89', '0', '10', null, '11', 'RG-005', 'Return Group 5', '0', null, '120.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '12.0000', null, '1188.0000', '10.0000', '2017-06-03', 'received', '120.0000', '108.5455', '10.0000', null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '74', '0', '2017-06-03 09:21:40', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('90', '0', '10', null, '8', 'RG-004', 'Return Group 4', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '10.0000', null, '990.0000', '10.0000', '2017-06-03', 'received', '100.0000', '90.4545', '10.0000', null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '75', '0', '2017-06-03 09:21:40', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('91', '0', '10', null, '8', 'RG-004', 'Return Group 4', '0', null, '100.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '100.0000', null, '900.0000', '10.0000', '2017-06-03', 'received', '100.0000', '90.4545', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '76', '0', '2017-06-03 09:21:41', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('92', '0', '10', null, '11', 'RG-005', 'Return Group 5', '0', null, '120.0000', '10.0000', '1', '0.0000', '1', '0.0000', '10%', '120.0000', null, '1080.0000', '10.0000', '2017-06-03', 'received', '120.0000', '108.5455', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '77', '0', '2017-06-03 09:21:41', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('104', '0', '11', null, '12', 'MJ-0002', 'Mey Jing', '0', null, '100.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '100.0000', '1.0000', '2017-06-03', 'received', '100.0000', '127.0270', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '78', '0', '2017-06-03 11:07:44', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('105', '0', '11', null, '9', 'MM-0001', 'Mey Mey', '0', null, '15.0000', '3.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '45.0000', '3.0000', '2017-06-03', 'received', '15.0000', '19.0541', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '79', '0', '2017-06-03 11:07:44', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('106', '0', '11', null, '10', 'YY-0001', 'Yong Yong', '0', null, '20.0000', '2.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '40.0000', '2.0000', '2017-06-03', 'received', '20.0000', '25.4054', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80', '0', '2017-06-03 11:07:44', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('107', '0', '12', null, '9', 'MM-0001', 'Mey Mey', '0', null, '3.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '15.0000', '5.0000', '2017-06-03', 'received', '3.0000', '11.6989', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '81', '0', '2017-06-03 11:30:53', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('108', '0', '12', null, '10', 'YY-0001', 'Yong Yong', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '20.0000', '10.0000', '2017-06-03', 'received', '2.0000', '8.2819', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '82', '0', '2017-06-03 11:30:54', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('109', '0', '13', null, '10', 'YY-0001', 'Yong Yong', null, null, '200.0000', '10.0000', '1', '200.0000', '2', '10.0000%', '100', '100.0000', null, '2100.0000', '10.0000', '2017-06-03', 'received', '200.0000', '103.3053', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '83', '0', '2017-06-03 11:41:22', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('110', '0', '13', null, '9', 'MM-0001', 'Mey Mey', null, null, '100.0000', '10.0000', '1', '100.0000', '2', '10.0000%', '50', '50.0000', null, '1050.0000', '10.0000', '2017-06-03', 'received', '100.0000', '62.7921', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '84', '0', '2017-06-03 11:41:22', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('107', '0', '12', null, '9', 'MM-0001', 'Mey Mey', '0', null, '3.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '15.0000', '5.0000', '2017-06-03', 'received', '3.0000', '11.6989', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '85', '0', '2017-06-03 11:44:46', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('108', '0', '12', null, '10', 'YY-0001', 'Yong Yong', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '20.0000', '10.0000', '2017-06-03', 'received', '2.0000', '8.2819', null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '86', '0', '2017-06-03 11:44:46', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('111', '0', '12', null, '10', 'YY-0001', 'Yong Yong', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '20.0000', '10.0000', '2017-06-03', 'received', '2.0000', '8.2819', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '87', '0', '2017-06-03 11:44:46', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('112', '0', '12', null, '9', 'MM-0001', 'Mey Mey', '0', null, '3.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '15.0000', '5.0000', '2017-06-03', 'received', '3.0000', '11.6989', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '88', '0', '2017-06-03 11:44:46', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('111', '0', '12', null, '10', 'YY-0001', 'Yong Yong', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '20.0000', '10.0000', '2017-06-03', 'received', '2.0000', '8.2819', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '89', '0', '2017-06-03 11:59:33', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('112', '0', '12', null, '9', 'MM-0001', 'Mey Mey', '0', null, '3.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '15.0000', '5.0000', '2017-06-03', 'received', '3.0000', '11.6989', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '90', '0', '2017-06-03 11:59:33', 'DELETED');
INSERT INTO `erp_purchase_items_audit` VALUES ('127', '0', '12', null, '9', 'MM-0001', 'Mey Mey', '0', null, '3.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '15.0000', '5.0000', '2017-06-03', 'received', '3.0000', '11.6989', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '91', '0', '2017-06-03 11:59:33', 'UPDATED');
INSERT INTO `erp_purchase_items_audit` VALUES ('128', '0', '12', null, '10', 'YY-0001', 'Yong Yong', '0', null, '2.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '20.0000', '10.0000', '2017-06-03', 'received', '2.0000', '8.2819', null, null, '0', null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '92', '0', '2017-06-03 11:59:34', 'UPDATED');

-- ----------------------------
-- Table structure for erp_purchase_order_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchase_order_items`;
CREATE TABLE `erp_purchase_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_cost` decimal(25,8) NOT NULL,
  `quantity` decimal(15,8) NOT NULL,
  `quantity_po` decimal(15,8) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_tax` decimal(25,8) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `item_discount` decimal(25,8) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `subtotal` decimal(25,8) NOT NULL,
  `quantity_balance` decimal(15,8) DEFAULT '0.00000000',
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit_cost` decimal(25,8) DEFAULT NULL,
  `real_unit_cost` decimal(25,8) DEFAULT NULL,
  `quantity_received` decimal(15,8) DEFAULT NULL,
  `supplier_part_no` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `price` decimal(25,8) DEFAULT NULL,
  `create_order` varchar(2) DEFAULT '0',
  `create_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchase_order_items
-- ----------------------------
INSERT INTO `erp_purchase_order_items` VALUES ('1', '1', null, '5', '01KD', 'KAKADA_01', '0', '0.00000000', '100.00000000', '0.00000000', '2', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '0.00000000', '0.00000000', '2017-06-01', 'pending', '0.00000000', '0.00000000', null, null, '0', null, '1', '1');
INSERT INTO `erp_purchase_order_items` VALUES ('2', '2', null, '2', 'RG-001', 'Return Group 1', '0', '3.49000000', '50.00000000', '0.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '174.50000000', '0.00000000', '2017-06-02', 'pending', '3.49000000', '4.04134281', null, null, '0', '3.50000000', '0', '0');
INSERT INTO `erp_purchase_order_items` VALUES ('3', '2', null, '3', 'RG-002', 'Return Group 2', '0', '2.84000000', '50.00000000', '0.00000000', '1', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '142.00000000', '0.00000000', '2017-06-02', 'pending', '2.84000000', '3.28865719', null, null, '0', '3.00000000', '0', '0');

-- ----------------------------
-- Table structure for erp_purchase_request_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchase_request_items`;
CREATE TABLE `erp_purchase_request_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `product_type` varchar(55) DEFAULT NULL,
  `net_unit_cost` decimal(25,8) NOT NULL,
  `quantity` decimal(15,8) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_tax` decimal(25,8) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `item_discount` decimal(25,8) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `subtotal` decimal(25,8) NOT NULL,
  `quantity_balance` decimal(15,8) DEFAULT '0.00000000',
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit_cost` decimal(25,8) DEFAULT NULL,
  `real_unit_cost` decimal(25,8) DEFAULT NULL,
  `quantity_received` decimal(15,8) DEFAULT NULL,
  `supplier_part_no` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `job_name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `convert_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `opening_stock` int(11) DEFAULT NULL,
  `create_status` varchar(2) DEFAULT '0',
  `create_qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_purchase_request_items
-- ----------------------------
INSERT INTO `erp_purchase_request_items` VALUES ('1', '0', '1', null, '5', '01KD', 'KAKADA_01', '0', null, '0.00000000', '100.00000000', '2', '0.00000000', '1', '0.0000', '0', '0.00000000', null, '0.00000000', '100.00000000', '2017-06-01', 'requested', '0.00000000', '0.00000000', null, null, null, null, null, null, null, null, null, '1', null, null);

-- ----------------------------
-- Table structure for erp_purchase_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchase_tax`;
CREATE TABLE `erp_purchase_tax` (
  `vat_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` varchar(100) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `purchase_id` varchar(10) DEFAULT NULL,
  `purchase_ref` varchar(100) DEFAULT NULL,
  `supplier_id` varchar(100) DEFAULT NULL,
  `issuedate` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `qty` double(25,4) DEFAULT NULL,
  `vatin` varchar(100) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `amount_tax` double DEFAULT NULL,
  `amount_declear` double DEFAULT NULL,
  `non_tax_pur` double(25,4) DEFAULT NULL,
  `tax_value` double(25,4) DEFAULT NULL,
  `vat` double(25,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `journal_location` varchar(255) DEFAULT NULL,
  `journal_date` date DEFAULT NULL,
  `amount_tax_declare` decimal(25,4) DEFAULT NULL,
  `value_import` decimal(25,4) DEFAULT NULL,
  `purchase_type` tinyint(1) DEFAULT NULL,
  `status_tax` varchar(25) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `pns` tinyint(1) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`vat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_purchase_tax
-- ----------------------------

-- ----------------------------
-- Table structure for erp_purchasing_taxes
-- ----------------------------
DROP TABLE IF EXISTS `erp_purchasing_taxes`;
CREATE TABLE `erp_purchasing_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insert_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `supplier` varchar(150) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `amount` decimal(24,4) DEFAULT NULL,
  `vat_id` int(11) DEFAULT NULL,
  `vat` decimal(24,4) DEFAULT NULL,
  `balance` decimal(24,4) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `status_tax` varchar(100) DEFAULT NULL,
  `remark_id` int(1) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `tax_type` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_purchasing_taxes
-- ----------------------------

-- ----------------------------
-- Table structure for erp_quotes
-- ----------------------------
DROP TABLE IF EXISTS `erp_quotes`;
CREATE TABLE `erp_quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `internal_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT NULL,
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `supplier` varchar(55) DEFAULT NULL,
  `saleman` int(11) DEFAULT NULL,
  `issue_invoice` varchar(55) DEFAULT NULL,
  `project_manager` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_quotes
-- ----------------------------

-- ----------------------------
-- Table structure for erp_quote_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_quote_items`;
CREATE TABLE `erp_quote_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quote_id` (`quote_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_quote_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_recieved_transfers
-- ----------------------------
DROP TABLE IF EXISTS `erp_recieved_transfers`;
CREATE TABLE `erp_recieved_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_warehouse_id` int(11) NOT NULL,
  `from_warehouse_code` varchar(55) NOT NULL,
  `from_warehouse_name` varchar(55) NOT NULL,
  `to_warehouse_id` int(11) NOT NULL,
  `to_warehouse_code` varchar(55) NOT NULL,
  `to_warehouse_name` varchar(55) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT NULL,
  `grand_total` decimal(25,4) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'pending',
  `shipping` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  `attachment1` varchar(55) DEFAULT NULL,
  `attachment2` varchar(55) DEFAULT NULL,
  `biller_id` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_recieved_transfers
-- ----------------------------

-- ----------------------------
-- Table structure for erp_recieved_transfer_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_recieved_transfer_items`;
CREATE TABLE `erp_recieved_transfer_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `received_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) DEFAULT NULL,
  `quantity_balance` decimal(15,4) NOT NULL,
  `unit_cost` decimal(25,4) DEFAULT NULL,
  `real_unit_cost` decimal(25,4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`received_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_recieved_transfer_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_related_products
-- ----------------------------
DROP TABLE IF EXISTS `erp_related_products`;
CREATE TABLE `erp_related_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(50) DEFAULT NULL,
  `related_product_code` varchar(50) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_related_products
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_items`;
CREATE TABLE `erp_return_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) unsigned NOT NULL,
  `return_id` int(11) unsigned NOT NULL,
  `sale_item_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `unit_price` decimal(55,4) DEFAULT NULL,
  `cost` decimal(25,8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_id`),
  KEY `sale_id_2` (`sale_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_purchases
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_purchases`;
CREATE TABLE `erp_return_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.0000',
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `surcharge` decimal(25,4) DEFAULT '0.0000',
  `old_grand_total` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `shipping` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_purchases
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_purchase_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_purchase_items`;
CREATE TABLE `erp_return_purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) unsigned NOT NULL,
  `return_id` int(11) unsigned NOT NULL,
  `purchase_item_id` int(11) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `old_subtotal` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `real_unit_cost` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`purchase_id`),
  KEY `purchase_id_2` (`purchase_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_purchase_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_sales
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_sales`;
CREATE TABLE `erp_return_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total_cost` decimal(25,4) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.0000',
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT NULL,
  `surcharge` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` double(25,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_sales
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_tax_back
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_tax_back`;
CREATE TABLE `erp_return_tax_back` (
  `orderlineno` int(11) DEFAULT NULL,
  `tax_return_id` int(11) DEFAULT NULL,
  `itemcode` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `specific_tax` double DEFAULT NULL,
  `amount_tax` double DEFAULT NULL,
  `inv_num` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_tax_back
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_tax_front
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_tax_front`;
CREATE TABLE `erp_return_tax_front` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '0',
  `credit_lmonth04` double DEFAULT '0',
  `precaba_month05` double DEFAULT '0',
  `premonth_rate06` double DEFAULT '0',
  `crecarry_forward07` double DEFAULT '0',
  `preprofit_taxdue08` double DEFAULT '0',
  `sptax_calbase09` double DEFAULT '0',
  `sptax_duerate10` double DEFAULT '0',
  `sptax_calbase11` double DEFAULT '0',
  `sptax_duerate12` double DEFAULT '0',
  `taxacc_calbase13` double DEFAULT '0',
  `taxacc_duerate14` double DEFAULT '0',
  `taxpuli_calbase15` double DEFAULT '0',
  `specify` varchar(100) DEFAULT '',
  `taxpuli_duerate16` double DEFAULT '0',
  `tax_calbase17` double DEFAULT '0',
  `tax_duerate18` double DEFAULT '0',
  `total_taxdue19` double DEFAULT '0',
  `covreturn_start` date DEFAULT NULL,
  `covreturn_end` date DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `year` int(11) DEFAULT '0',
  `month` int(11) DEFAULT '0',
  `filed_in_kh` varchar(100) DEFAULT NULL,
  `filed_in_en` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_tax_front
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_value_added_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_value_added_tax`;
CREATE TABLE `erp_return_value_added_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '0',
  `pusa_act04` varchar(100) DEFAULT '',
  `tax_credit_premonth05` varchar(100) DEFAULT '',
  `ncredit_purch06` varchar(100) DEFAULT '',
  `strate_purch07` varchar(100) DEFAULT '',
  `strate_purch08` varchar(100) DEFAULT '',
  `strate_imports09` varchar(100) DEFAULT '',
  `strate_imports10` varchar(100) DEFAULT '',
  `total_intax11` varchar(100) DEFAULT '',
  `ntaxa_sales12` varchar(100) DEFAULT '',
  `exports13` varchar(100) DEFAULT '',
  `strate_sales14` varchar(100) DEFAULT '',
  `strate_sales15` varchar(100) DEFAULT '',
  `pay_difference16` varchar(100) DEFAULT '',
  `refund17` varchar(100) DEFAULT '',
  `credit_forward18` varchar(100) DEFAULT '',
  `covreturn_start` date DEFAULT NULL,
  `covreturn_end` date DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `year` int(11) DEFAULT '0',
  `month` int(11) DEFAULT '0',
  `field_in_kh` varchar(100) DEFAULT NULL,
  `field_in_en` varchar(100) DEFAULT NULL,
  `state_change` tinyint(1) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_value_added_tax
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_value_added_tax_back
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_value_added_tax_back`;
CREATE TABLE `erp_return_value_added_tax_back` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value_id` int(11) DEFAULT '0',
  `productid` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `inv_cust_desc` varchar(255) DEFAULT NULL,
  `supp_exp_inn` varchar(255) DEFAULT NULL,
  `val_vat` varchar(255) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `val_vat_g` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_value_added_tax_back
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_withholding_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_withholding_tax`;
CREATE TABLE `erp_return_withholding_tax` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '0',
  `covreturn_start` date DEFAULT NULL,
  `covreturn_end` date DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `month` int(11) DEFAULT '0',
  `taxref` varchar(255) DEFAULT NULL,
  `field_in_kh` varchar(255) DEFAULT NULL,
  `field_in_en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_withholding_tax
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_withholding_tax_back
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_withholding_tax_back`;
CREATE TABLE `erp_return_withholding_tax_back` (
  `withholding_id` varchar(10) DEFAULT NULL,
  `emp_code` varchar(100) DEFAULT NULL,
  `object_of_payment` varchar(255) DEFAULT NULL,
  `invoice_paynote` varchar(255) DEFAULT NULL,
  `amount_paid` double DEFAULT NULL,
  `tax_rate` double DEFAULT NULL,
  `withholding_tax` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_withholding_tax_back
-- ----------------------------

-- ----------------------------
-- Table structure for erp_return_withholding_tax_front
-- ----------------------------
DROP TABLE IF EXISTS `erp_return_withholding_tax_front`;
CREATE TABLE `erp_return_withholding_tax_front` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `withholding_id` int(11) DEFAULT '0',
  `amount_paid` double DEFAULT '0',
  `tax_rate` double DEFAULT '1',
  `withholding_tax` double DEFAULT '0',
  `remarks` text,
  `type` varchar(10) DEFAULT NULL,
  `type_of_oop` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_return_withholding_tax_front
-- ----------------------------

-- ----------------------------
-- Table structure for erp_revenues
-- ----------------------------
DROP TABLE IF EXISTS `erp_revenues`;
CREATE TABLE `erp_revenues` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_type` varchar(255) NOT NULL,
  `revenue` varchar(255) NOT NULL,
  `goods_and_service` varchar(255) DEFAULT NULL,
  `description` text,
  `created_by` int(10) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_revenues
-- ----------------------------

-- ----------------------------
-- Table structure for erp_salary_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_salary_tax`;
CREATE TABLE `erp_salary_tax` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '0',
  `covreturn_start` date DEFAULT NULL,
  `covreturn_end` date DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `year` int(11) DEFAULT '0',
  `month` int(11) DEFAULT '0',
  `filed_in_kh` varchar(255) DEFAULT '0',
  `filed_in_en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_salary_tax
-- ----------------------------

-- ----------------------------
-- Table structure for erp_salary_tax_back
-- ----------------------------
DROP TABLE IF EXISTS `erp_salary_tax_back`;
CREATE TABLE `erp_salary_tax_back` (
  `orderno` int(11) NOT NULL AUTO_INCREMENT,
  `salary_tax_id` int(11) NOT NULL,
  `empcode` varchar(50) DEFAULT '0',
  `salary_paid` double(25,8) DEFAULT NULL,
  `spouse` int(10) DEFAULT NULL,
  `minor_children` int(5) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `date_insert` date DEFAULT NULL,
  `tax_type` varchar(50) NOT NULL,
  `tax_rate` double(25,8) DEFAULT NULL,
  `tax_salary` double(25,8) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`orderno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_salary_tax_back
-- ----------------------------

-- ----------------------------
-- Table structure for erp_salary_tax_front
-- ----------------------------
DROP TABLE IF EXISTS `erp_salary_tax_front`;
CREATE TABLE `erp_salary_tax_front` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `salary_tax_id` int(11) DEFAULT '0',
  `emp_num` int(11) DEFAULT '0',
  `salary_paid` double DEFAULT '0',
  `spouse_num` int(11) DEFAULT '0',
  `children_num` int(11) DEFAULT '0',
  `tax_salcalbase` double DEFAULT '0',
  `tax_rate` double DEFAULT '1',
  `tax_salary` double DEFAULT '0',
  `tax_type` char(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_salary_tax_front
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sales
-- ----------------------------
DROP TABLE IF EXISTS `erp_sales`;
CREATE TABLE `erp_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) DEFAULT NULL,
  `group_areas_id` int(11) DEFAULT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `staff_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.0000',
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `sale_status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `delivery_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_count` int(4) unsigned zerofill NOT NULL,
  `total_items` tinyint(4) DEFAULT NULL,
  `total_cost` decimal(25,4) NOT NULL,
  `pos` tinyint(1) NOT NULL DEFAULT '0',
  `paid` decimal(25,4) DEFAULT '0.0000',
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  `attachment1` varchar(55) DEFAULT NULL,
  `attachment2` varchar(55) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `other_cur_paid` decimal(25,0) DEFAULT NULL,
  `other_cur_paid_rate` decimal(25,0) DEFAULT '1',
  `other_cur_paid1` decimal(25,4) DEFAULT NULL,
  `other_cur_paid_rate1` decimal(25,4) DEFAULT NULL,
  `saleman_by` int(11) DEFAULT NULL,
  `reference_no_tax` varchar(55) NOT NULL,
  `tax_status` varchar(255) DEFAULT NULL,
  `opening_ar` tinyint(1) DEFAULT '0',
  `sale_type` tinyint(1) DEFAULT NULL,
  `bill_to` varchar(255) DEFAULT NULL,
  `po` varchar(50) DEFAULT NULL,
  `suspend_note` varchar(255) DEFAULT NULL,
  `tax_type` varchar(40) DEFAULT NULL,
  `so_id` int(11) DEFAULT NULL,
  `revenues_type` int(10) DEFAULT NULL,
  `acc_cate_separate` tinyint(1) DEFAULT NULL,
  `hide_tax` tinyint(1) DEFAULT '0',
  `quote_id` int(11) DEFAULT NULL,
  `project_manager` int(11) DEFAULT NULL,
  `assign_to_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sales
-- ----------------------------
INSERT INTO `erp_sales` VALUES ('1', '2017-06-01 20:10:00', 'SALE/1706/00001', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '3.5000', '0.0000', '10', '0.3500', '0.3500', '0.0000', '1', '0.0000', '0.0000', '0.0000', '3.1500', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '1', '2.7692', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, '1');
INSERT INTO `erp_sales` VALUES ('2', '2017-06-01 20:28:00', 'SALE/1706/00002', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, '3');
INSERT INTO `erp_sales` VALUES ('3', '2017-06-01 20:28:00', 'SALE/1706/00002', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, '3');
INSERT INTO `erp_sales` VALUES ('4', '2017-06-01 20:28:00', 'SALE/1706/00002', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('5', '2017-06-01 20:28:00', 'SALE/1706/00002', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('6', '2017-06-01 20:44:00', 'SALE/1706/00003', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('7', '2017-06-01 20:47:00', 'SALE/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('8', '2017-06-01 20:52:00', 'SALE/1706/00005', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '200.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '200.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '1', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('9', '2017-06-01 20:53:00', 'SALE/1706/00006', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('10', '2017-06-01 20:53:00', 'SALE/1706/00006', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('11', '2017-06-01 20:53:00', 'SALE/1706/00006', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('12', '2017-06-01 20:53:00', 'SALE/1706/00006', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('13', '2017-06-01 20:53:00', 'SALE/1706/00006', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('14', '2017-06-01 20:51:35', 'SALE/1706/00007', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'pending', 'due', null, null, null, null, '3', null, null, '0000', '100', '2000.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '2', null, '1', null, null, '3', '', null, '0', null, 'Old Market', null, null, null, '2', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('15', '2017-06-01 21:01:00', 'SALE/1706/00008', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'pending', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('16', '2017-06-01 21:04:00', 'SALE/1706/00009', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('17', '2017-06-01 21:04:00', 'SALE/1706/00009', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('18', '2017-06-01 21:04:00', 'SALE/1706/00009', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('19', '2017-06-01 21:19:00', 'SALE/1706/00010', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('20', '2017-06-01 21:19:00', 'SALE/1706/00010', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('21', '2017-06-01 21:26:00', 'SALE/1706/00011', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('22', '2017-06-01 21:28:00', 'SALE/1706/00012', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('23', '2017-06-02 08:05:08', 'SALE/1706/00013', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '500.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '500.0000', 'pending', 'partial', null, null, 'completed', null, '3', null, null, '0000', '25', '500.0000', '0', '100.0000', null, '0.0000', null, null, null, 'sale_order', '3', null, '1', null, null, '3', '', null, '0', null, 'Phnom Penh', null, null, null, '3', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('24', '2017-06-02 08:31:00', 'SALE/1706/00014', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('25', '2017-06-02 08:31:00', 'SALE/1706/00014', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, 'partial', null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('26', '2017-06-02 08:31:00', 'SALE/1706/00014', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('27', '2017-06-02 08:31:00', 'SALE/1706/00014', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('28', '2017-06-02 08:36:00', 'SALE/1706/00015', '2', 'General Customer', '0', '5', 'RKS-Ta Kmao', '4', '', '', '330.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '330.0000', 'completed', 'due', null, null, 'partial', null, '5', '1', '2017-06-02 09:05:35', '0001', '15', '300.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '5', '', null, '0', null, 'Old Market', null, null, null, null, null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('29', '2017-06-02 09:38:09', 'SALE/1706/00016', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '30.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '2', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '5', null, '1', null, null, '3', '', null, '0', null, '', null, null, null, '5', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('30', '2017-06-02 09:40:25', 'SALE/1706/00017', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '500.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '505.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '10', '0.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '6', null, '1', null, null, null, '', null, '0', null, '', null, null, null, '6', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('31', '2017-06-02 09:44:21', 'SALE/1706/00018', '5', 'RKS-Ta Kmao', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '5.0000', '5.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '10', '600.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '4', null, '1', null, null, '3', '', null, '0', null, '', null, null, null, '4', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('32', '2017-06-02 09:45:27', 'SALE/1706/00019', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '5', '500.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '7', null, '1', null, null, null, '', null, '0', null, '', null, null, null, '7', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('33', '2017-06-02 09:56:21', 'SALE/1706/00020', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '30.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '30.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '1', '0.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '8', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '8', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('34', '2017-06-02 09:59:57', 'SALE/1706/00021', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '12.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '12.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '1', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '9', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '9', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('35', '2017-06-02 10:02:01', 'SALE/1706/00022', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '1', '20.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '10', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '10', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('36', '2017-06-02 10:04:35', 'SALE/1706/00023', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '0', '20.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '11', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '11', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('37', '2017-06-02 10:08:34', 'SALE/1706/00024', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '0', '20.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '12', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '12', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('38', '2017-06-02 10:10:03', 'SALE/1706/00025', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '0', '20.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '13', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '13', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('39', '2017-06-02 10:11:10', 'SALE/1706/00026', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '0', '20.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '14', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '14', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('40', '2017-06-02 10:14:21', 'SALE/1706/00027', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '30.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '4', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '15', null, '1', null, null, null, '', null, '0', null, '', null, null, null, '15', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('41', '2017-06-02 11:03:00', 'SALE/1706/00028', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('42', '2017-06-02 11:03:00', 'SALE/1706/00028', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('43', '2017-06-02 11:03:00', 'SALE/1706/00028', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('44', '2017-06-02 14:15:00', 'SALE/1706/00029', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '170.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '170.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '14', '500.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('45', '2017-06-02 14:15:00', 'SALE/1706/00029', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '170.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '170.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '14', '500.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('46', '2017-06-02 14:17:00', 'SALE/1706/00030', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('47', '2017-06-02 14:17:00', 'SALE/1706/00030', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('48', '2017-06-02 15:08:00', 'SALE/1706/00031', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('49', '2017-06-02 15:21:00', 'SALE/1706/00032', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '300.0000', '0.0000', '20', '60.0000', '60.0000', '0.0000', '2', '26.0000', '26.0000', '20.0000', '286.0000', 'completed', 'partial', null, null, 'completed', null, '1', '1', '2017-06-02 15:18:05', '0001', '15', '300.0000', '0', '198.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, null, null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('50', '2017-06-02 16:54:00', 'SALE/1706/00033', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('51', '2017-06-02 16:54:00', 'SALE/1706/00033', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('52', '2017-06-02 17:00:00', 'SALE/1706/00034', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('53', '2017-06-02 17:07:00', 'SALE/1706/00035', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2000.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('54', '2017-06-02 17:10:00', 'SALE/1706/00036', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '400.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '25.0000', '425.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '20', '52.4205', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, '1');
INSERT INTO `erp_sales` VALUES ('55', '2017-06-03 08:05:56', 'SALE/1706/00037', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '100.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '100.0000', 'completed', 'due', null, null, null, null, '3', null, null, '0000', '10', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '3', '', null, '0', null, '', null, null, null, '0', null, null, '0', '0', null, '1');
INSERT INTO `erp_sales` VALUES ('56', '2017-06-03 08:20:00', 'SALE/1706/00038', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '110.0000', '0.0000', '2', '2.2000', '2.2000', '0.0000', '2', '11.1800', '11.1800', '4.0000', '122.9800', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '11', '700.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, 'dsfdsfss', null, null, null, '0', null, null, '0', '0', null, '3');
INSERT INTO `erp_sales` VALUES ('57', '2017-06-03 08:23:00', 'SALE/1706/00039', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '6.0000', '4.0000', '1', '4.0600', '0.0600', '0.0000', '2', '0.7940', '0.7940', '2.0000', '8.7340', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, 'ggg', null, null, null, '0', null, null, '0', '0', null, '3');
INSERT INTO `erp_sales` VALUES ('58', '2017-06-03 08:50:00', 'SALE/1706/00040', '2', 'General Customer', '0', '1', 'ABC Company', '1', '&lt;p&gt;sss&lt;&sol;p&gt;', '&lt;p&gt;ss&lt;&sol;p&gt;', '155.8000', '4.0000', '2', '7.1200', '3.1200', '14.3500', '2', '15.6680', '30.0135', '4.0000', '172.3480', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '15', '1000.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, 'sfds', null, null, null, '0', null, null, '0', '0', null, '3');
INSERT INTO `erp_sales` VALUES ('59', '2017-06-03 10:01:00', 'qqqq123', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '120.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('60', '2017-06-03 10:01:00', 'SALE/1706/00041', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '120.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('61', '2017-06-03 10:01:00', 'SALE/1706/00042', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '120.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('62', '2017-06-03 10:06:00', 'sss001', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '21.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '21.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('63', '2017-06-03 10:08:00', 'sdsfsdfdsf', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '10.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '10.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '1', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('64', '2017-06-03 10:09:00', 'sdsfsdfdsf1', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '10.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '10.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '1', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('65', '2017-06-03 10:15:15', 'SALE/POS/1706/00001', '2', 'General Customer', null, '1', 'ABC Company', '1', '', null, '8.0000', '2.0000', null, '2.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '8.0000', 'completed', 'paid', '0', null, null, null, '1', null, null, '0000', '1', '0.0000', '1', '8.0000', null, '0.0000', null, null, null, null, null, '0', '4000', null, null, '0', '', null, '0', null, null, null, '', null, null, null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('66', '2017-06-03 10:19:00', 'SALE/1706/00043', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('67', '2017-06-03 10:22:00', 'SALE/1706/00044', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '100.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('68', '2017-06-03 10:25:00', 'sss002', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '50.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '5', '500.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('69', '2017-06-03 10:19:00', 'SALE/1706/00043', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('70', '2017-06-03 10:55:00', 'SALE/1706/00045', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('71', '2017-06-03 10:55:00', 'SALE/1706/00045', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('72', '2017-06-03 11:02:00', 'SALE/1706/00046', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('73', '2017-06-03 11:02:00', 'SALE/1706/00046', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('74', '2017-06-03 11:02:00', 'SALE/1706/00046', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('75', '2017-06-03 11:02:00', 'SALE/1706/00046', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('76', '2017-06-03 11:50:00', 'SALE/1706/00047', '2', 'General Customer', null, '4', 'RKS-Head Office', '2', '', '', '160.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '160.0000', 'pending', 'due', null, null, null, null, '1', null, null, '0000', '8', '160.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '16', null, '1', null, null, null, '', null, '0', null, null, null, null, null, '16', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('77', '2017-06-03 11:02:00', 'SALE/1706/00046', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'completed', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('78', '2017-06-03 11:53:00', 'SALE/1706/00048', '1', 'ABC Company', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '2000.0000', 'pending', 'due', null, null, null, null, '1', null, null, '0000', '20', '1085.4550', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('79', '2017-06-03 11:53:00', 'SALE/1706/00048', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'pending', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('80', '2017-06-03 11:50:00', 'SALE/1706/00048', '2', 'General Customer', null, '4', 'RKS-Head Office', '2', '', '', '160.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '160.0000', 'pending', 'due', null, null, 'completed', null, '1', null, null, '0000', '8', '160.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '16', null, '1', null, null, null, '', null, '0', null, null, null, null, null, '16', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('81', '2017-06-03 11:53:00', 'SALE/1706/00048', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', 'pending', 'due', null, null, null, null, '1', null, null, '0000', '2', '40.0000', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('82', '2017-06-03 11:50:00', 'SALE/1706/00049', '2', 'General Customer', null, '4', 'RKS-Head Office', '2', '', '', '160.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '160.0000', 'pending', 'due', null, null, null, null, '1', null, null, '0000', '8', '160.0000', '0', '0.0000', null, '0.0000', null, null, null, 'sale_order', '16', null, '1', null, null, null, '', null, '0', null, null, null, null, null, '16', null, null, '0', null, null, null);
INSERT INTO `erp_sales` VALUES ('83', '2017-06-03 11:53:00', 'SALE/1706/00049', '1', 'ABC Company', '0', '1', 'ABC Company', '1', '', '', '2000.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '2000.0000', 'pending', 'due', null, null, null, null, '1', null, null, '0000', '20', '1085.4550', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('84', '2017-06-03 11:55:00', 'SALE/1706/00050', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '22.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '22.5000', 'pending', 'due', null, null, 'partial', null, '1', null, null, '0000', '10', '517.4735', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', '', null, '0', null, null, null, null, null, '0', null, null, '0', '0', null, null);
INSERT INTO `erp_sales` VALUES ('85', '2017-06-03 12:04:00', 'SALE/1706/00051', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '50.0000', 'pending', 'due', null, null, 'partial', null, '1', '1', '2017-06-03 11:58:09', '0001', '15', '93.4415', '0', '0.0000', null, '0.0000', null, null, null, '', '0', null, '1', null, null, '1', 'T001', 'confirmed', '0', '2', null, null, null, '2', null, null, null, '0', '0', null, null);

-- ----------------------------
-- Table structure for erp_sales_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_sales_audit`;
CREATE TABLE `erp_sales_audit` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) DEFAULT NULL,
  `group_areas_id` int(11) DEFAULT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `staff_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.0000',
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `sale_status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `delivery_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_count` int(4) unsigned zerofill NOT NULL,
  `total_items` tinyint(4) DEFAULT NULL,
  `total_cost` decimal(25,4) NOT NULL,
  `pos` tinyint(1) NOT NULL DEFAULT '0',
  `paid` decimal(25,4) DEFAULT '0.0000',
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  `attachment1` varchar(55) DEFAULT NULL,
  `attachment2` varchar(55) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `other_cur_paid` decimal(25,0) DEFAULT NULL,
  `other_cur_paid_rate` decimal(25,0) DEFAULT '1',
  `other_cur_paid1` decimal(25,4) DEFAULT NULL,
  `other_cur_paid_rate1` decimal(25,4) DEFAULT NULL,
  `saleman_by` int(11) DEFAULT NULL,
  `reference_no_tax` varchar(55) NOT NULL,
  `tax_status` varchar(255) DEFAULT NULL,
  `opening_ar` tinyint(1) DEFAULT '0',
  `sale_type` tinyint(1) DEFAULT NULL,
  `bill_to` varchar(255) DEFAULT NULL,
  `po` varchar(50) DEFAULT NULL,
  `suspend_note` varchar(255) DEFAULT NULL,
  `tax_type` varchar(40) DEFAULT NULL,
  `so_id` int(11) DEFAULT NULL,
  `revenues_type` int(10) DEFAULT NULL,
  `acc_cate_separate` tinyint(1) DEFAULT NULL,
  `hide_tax` tinyint(1) DEFAULT '0',
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sales_audit
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sales_types
-- ----------------------------
DROP TABLE IF EXISTS `erp_sales_types`;
CREATE TABLE `erp_sales_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_code` varchar(20) DEFAULT '',
  `type_name` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Sales_Type` (`type_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sales_types
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sale_areas
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_areas`;
CREATE TABLE `erp_sale_areas` (
  `areacode` int(3) NOT NULL AUTO_INCREMENT,
  `areadescription` varchar(100) DEFAULT '',
  `areas_g_code` varchar(100) DEFAULT '',
  PRIMARY KEY (`areacode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_areas
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sale_dev_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_dev_items`;
CREATE TABLE `erp_sale_dev_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `machine_name` varchar(50) DEFAULT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `grand_total` decimal(25,4) DEFAULT NULL,
  `quantity_break` decimal(25,4) DEFAULT NULL,
  `quantity_index` decimal(25,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_1` int(11) DEFAULT NULL,
  `user_2` int(11) DEFAULT NULL,
  `user_3` int(11) DEFAULT NULL,
  `user_4` int(11) DEFAULT NULL,
  `user_5` int(11) DEFAULT NULL,
  `user_6` int(11) DEFAULT NULL,
  `user_7` int(11) DEFAULT NULL,
  `user_8` int(11) DEFAULT NULL,
  `user_9` int(11) DEFAULT NULL,
  `cf1` varchar(20) DEFAULT NULL,
  `cf2` varchar(20) DEFAULT NULL,
  `cf3` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_id`),
  KEY `sale_id_2` (`sale_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_dev_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sale_dev_items_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_dev_items_audit`;
CREATE TABLE `erp_sale_dev_items_audit` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `machine_name` varchar(50) DEFAULT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `grand_total` decimal(25,4) DEFAULT NULL,
  `quantity_break` decimal(25,4) DEFAULT NULL,
  `quantity_index` decimal(25,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_1` int(11) DEFAULT NULL,
  `user_2` int(11) DEFAULT NULL,
  `user_3` int(11) DEFAULT NULL,
  `user_4` int(11) DEFAULT NULL,
  `user_5` int(11) DEFAULT NULL,
  `user_6` int(11) DEFAULT NULL,
  `user_7` int(11) DEFAULT NULL,
  `user_8` int(11) DEFAULT NULL,
  `user_9` int(11) DEFAULT NULL,
  `cf1` varchar(20) DEFAULT NULL,
  `cf2` varchar(20) DEFAULT NULL,
  `cf3` varchar(20) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_id`),
  KEY `sale_id_2` (`sale_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_dev_items_audit
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sale_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_items`;
CREATE TABLE `erp_sale_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) unsigned NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `product_noted` varchar(30) DEFAULT NULL,
  `returned` decimal(15,4) DEFAULT NULL,
  `group_price_id` int(11) DEFAULT NULL,
  `acc_cate_separate` tinyint(1) DEFAULT NULL,
  `specific_tax_on_certain_merchandise_and_services` int(10) DEFAULT NULL,
  `accommodation_tax` int(10) DEFAULT NULL,
  `public_lighting_tax` int(10) DEFAULT NULL,
  `other_tax` int(10) DEFAULT NULL,
  `payment_of_profit_tax` int(10) DEFAULT NULL,
  `performance_royalty_intangible` int(10) DEFAULT NULL,
  `payment_interest_non_bank` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_fixed` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_non_fixed` int(10) DEFAULT NULL,
  `payment_rental_immovable_property` int(10) DEFAULT NULL,
  `payment_of_interest` int(10) DEFAULT NULL,
  `payment_royalty_rental_income_related` int(10) DEFAULT NULL,
  `payment_management_technical` int(10) DEFAULT NULL,
  `payment_dividend` int(10) DEFAULT NULL,
  `withholding_tax_on_resident` int(10) DEFAULT NULL,
  `withholding_tax_on_non_resident` int(10) DEFAULT NULL,
  `order_status` int(25) DEFAULT NULL,
  `unit_cost` decimal(25,8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_id`),
  KEY `sale_id_2` (`sale_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_items
-- ----------------------------
INSERT INTO `erp_sale_items` VALUES ('1', '1', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '3.5000', '3.5000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '3.5000', '', '3.5000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2.76920000');
INSERT INTO `erp_sale_items` VALUES ('2', '2', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('3', '3', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('4', '4', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('5', '5', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('6', '6', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('7', '7', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('8', '8', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '200.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('9', '9', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('10', '10', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('11', '11', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('12', '12', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('13', '13', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('14', '14', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '0.0000', '0.0000', '0.0000', '100.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '0.0000', '', '0.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('15', '15', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('16', '16', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('17', '17', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('18', '18', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('19', '19', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('20', '20', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('21', '21', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('22', '22', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('23', '23', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '25.0000', '25.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '500.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('24', '24', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('25', '25', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '5.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('26', '26', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('27', '27', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('29', '28', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '22.0000', '22.0000', '0.0000', '15.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', '330.0000', '', '22.0000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('30', '29', null, '4', 'CAM-0001', 'Cambodia', 'standard', '0', '10.0000', '10.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('31', '29', null, '1', '1', 'Product_test', 'standard', '0', '10.0000', '10.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('32', '30', null, '1', '1', 'Product_test', 'standard', '0', '50.0000', '50.0000', '0.0000', '10.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '500.0000', '', '50.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('33', '31', null, '4', 'CAM-0001', 'Cambodia', 'standard', '0', '0.0000', '0.0000', '0.0000', '5.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '0.0000', '', '0.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('34', '31', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '0.0000', '0.0000', '0.0000', '5.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '0.0000', '', '0.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('35', '32', null, '4', 'CAM-0001', 'Cambodia', 'standard', '0', '0.0000', '0.0000', '0.0000', '5.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '0.0000', '', '0.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('36', '33', null, '1', '1', 'Product_test', 'standard', '0', '30.0000', '30.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '30.0000', '', '30.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('37', '34', null, '4', 'CAM-0001', 'Cambodia', 'standard', '0', '12.0000', '12.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '12.0000', '', '12.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('38', '35', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '122.0000', '', '122.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('39', '36', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '122.0000', '', '122.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('40', '37', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '122.0000', '', '122.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('41', '38', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '122.0000', '', '122.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('42', '39', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '122.0000', '', '122.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('43', '40', null, '6', '02KD', 'KAKADA_02', 'standard', '0', '5.0000', '5.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '5.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('44', '40', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '5.0000', '5.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '5.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('45', '41', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('46', '42', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('47', '43', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('48', '44', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '15.0000', '15.0000', '0.0000', '4.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '60.0000', '', '15.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('49', '44', null, '5', '01KD', 'KAKADA_01', 'standard', null, '12.0000', '12.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '60.0000', '', '12.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('50', '44', null, '6', '02KD', 'KAKADA_02', 'standard', null, '10.0000', '10.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '50.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('51', '45', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '15.0000', '15.0000', '0.0000', '4.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '60.0000', '', '15.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('52', '45', null, '5', '01KD', 'KAKADA_01', 'standard', null, '12.0000', '12.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '60.0000', '', '12.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('53', '45', null, '6', '02KD', 'KAKADA_02', 'standard', null, '10.0000', '10.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '50.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('54', '46', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('55', '47', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('56', '48', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('58', '49', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '0.0000', '15.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '300.0000', '', '20.0000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('59', '50', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('60', '51', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('61', '52', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('62', '53', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('63', '54', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '20.0000', '20.0000', '0.0000', '15.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '300.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '3.49470000');
INSERT INTO `erp_sale_items` VALUES ('64', '54', null, '6', '02KD', 'KAKADA_02', 'standard', null, '20.0000', '20.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '100.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('65', '55', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '10.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '100.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('66', '56', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '6.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '60.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('67', '56', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '50.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('68', '57', null, '4', 'CAM-0001', 'Cambodia', 'standard', '0', '5.0000', '5.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '2', '2.0000', '3.0000', '', '5.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('69', '57', null, '6', '02KD', 'KAKADA_02', 'standard', '0', '5.0000', '5.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '2', '2.0000', '3.0000', '', '5.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('70', '58', null, '1', '1', 'Product_test', 'standard', '0', '9.0909', '10.0000', '0.0000', '5.0000', '1', '4.5455', '2', '10.0000%', '2', '2.0000', '48.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('71', '58', null, '4', 'CAM-0001', 'Cambodia', 'standard', '0', '10.0000', '10.0000', '0.0000', '10.0000', '1', '9.8000', '2', '10.0000%', '2', '2.0000', '107.8000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('72', '61', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('73', '61', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('74', '62', null, '1', '1', 'Product_test', 'standard', null, '11.0000', '11.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '11.0000', '', '11.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('75', '62', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('76', '63', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('77', '64', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('78', '65', null, '1', '1', 'Product_test', 'standard', '0', '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '2', '2.0000', '8.0000', '', '10.0000', 'sfsdfsdf', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `erp_sale_items` VALUES ('79', '67', null, '1', '1', 'Product_test', 'standard', null, '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('80', '67', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '10.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('81', '68', null, '1', '1', 'Product_test', 'standard', null, '12.0000', '12.0000', '0.0000', '0.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.0000', '', '12.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('82', '68', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '10.0000', '10.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '50.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('83', '69', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('84', '70', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('85', '71', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('86', '72', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('87', '73', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('88', '74', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('89', '75', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('90', '76', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '0.0000', '8.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '160.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('91', '77', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('92', '78', null, '1', 'PR-00001', 'Product 00001', 'standard', null, '100.0000', '100.0000', '0.0000', '10.0000', '1', '0.0000', '0', '', '0', '0.0000', '1000.0000', '', '100.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('93', '79', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('94', '80', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '8.0000', '8.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '160.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('95', '81', null, '5', '01KD', 'KAKADA_01', 'standard', null, '10.0000', '10.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '20.0000', '', '10.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('96', '82', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '0.0000', '8.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '160.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '20.00000000');
INSERT INTO `erp_sale_items` VALUES ('97', '83', null, '1', 'PR-00001', 'Product 00001', 'standard', null, '100.0000', '100.0000', '0.0000', '10.0000', '1', '0.0000', '0', '', '0', '0.0000', '1000.0000', '', '100.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0.00000000');
INSERT INTO `erp_sale_items` VALUES ('98', '83', null, '11', 'PR-00011', 'Product 00011', 'standard', null, '100.0000', '100.0000', '0.0000', '10.0000', '1', '0.0000', '0', '', '0', '0.0000', '1000.0000', '', '100.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '108.54550000');
INSERT INTO `erp_sale_items` VALUES ('99', '84', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '3.5000', '3.5000', '2.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '17.5000', '', '3.5000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '3.49470000');
INSERT INTO `erp_sale_items` VALUES ('100', '84', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '1.0000', '1.0000', '2.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '1.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100.00000000');
INSERT INTO `erp_sale_items` VALUES ('103', '85', null, '9', 'MM-0001', 'Mey Mey', 'standard', '0', '3.0000', '3.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '15.0000', '', '3.0000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '11.69890000');
INSERT INTO `erp_sale_items` VALUES ('104', '85', null, '2', 'RG-001', 'Return Group 1', 'standard', '0', '3.5000', '3.5000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '35.0000', '', '3.5000', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '3.49470000');

-- ----------------------------
-- Table structure for erp_sale_items_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_items_audit`;
CREATE TABLE `erp_sale_items_audit` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) unsigned NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `product_noted` varchar(30) DEFAULT NULL,
  `returned` decimal(15,4) DEFAULT NULL,
  `group_price_id` int(11) DEFAULT NULL,
  `acc_cate_separate` tinyint(1) DEFAULT NULL,
  `specific_tax_on_certain_merchandise_and_services` int(10) DEFAULT NULL,
  `accommodation_tax` int(10) DEFAULT NULL,
  `public_lighting_tax` int(10) DEFAULT NULL,
  `other_tax` int(10) DEFAULT NULL,
  `payment_of_profit_tax` int(10) DEFAULT NULL,
  `performance_royalty_intangible` int(10) DEFAULT NULL,
  `payment_interest_non_bank` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_fixed` int(10) DEFAULT NULL,
  `payment_interest_taxpayer_non_fixed` int(10) DEFAULT NULL,
  `payment_rental_immovable_property` int(10) DEFAULT NULL,
  `payment_of_interest` int(10) DEFAULT NULL,
  `payment_royalty_rental_income_related` int(10) DEFAULT NULL,
  `payment_management_technical` int(10) DEFAULT NULL,
  `payment_dividend` int(10) DEFAULT NULL,
  `withholding_tax_on_resident` int(10) DEFAULT NULL,
  `withholding_tax_on_non_resident` int(10) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_id`),
  KEY `sale_id_2` (`sale_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_items_audit
-- ----------------------------
INSERT INTO `erp_sale_items_audit` VALUES ('25', '25', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '0', '2017-06-02 08:30:51', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('23', '23', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '0.0000', '25.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '500.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', '0', '2017-06-02 08:31:49', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('28', '28', null, '5', '01KD', 'KAKADA_01', 'standard', null, '22.0000', '22.0000', '0.0000', '10.0000', '4', '0.0000', '1', '0.0000', '0', '0.0000', '220.0000', '', '22.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '3', '0', '2017-06-02 09:05:03', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('25', '25', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '200.0000', '200.0000', '10.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2000.0000', '', '200.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '4', '0', '2017-06-02 15:13:23', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('57', '49', null, '5', '01KD', 'KAKADA_01', 'standard', null, '20.0000', '20.0000', '0.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '200.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '5', '0', '2017-06-02 15:17:01', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('57', '49', null, '5', '01KD', 'KAKADA_01', 'standard', null, '20.0000', '20.0000', '5.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '200.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '6', '0', '2017-06-02 15:17:27', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('99', '84', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '3.5000', '3.5000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '17.5000', '', '3.5000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '7', '0', '2017-06-03 11:48:21', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('100', '84', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '1.0000', '1.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '1.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '8', '0', '2017-06-03 11:48:21', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('94', '80', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '0.0000', '8.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '160.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '9', '0', '2017-06-03 11:49:08', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('99', '84', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '3.5000', '3.5000', '2.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '17.5000', '', '3.5000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '10', '0', '2017-06-03 11:49:16', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('100', '84', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '1.0000', '1.0000', '2.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '1.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '11', '0', '2017-06-03 11:49:16', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('94', '80', null, '5', '01KD', 'KAKADA_01', 'standard', '0', '20.0000', '20.0000', '4.0000', '8.0000', '2', '0.0000', '1', '0.0000', '0', '0.0000', '160.0000', '', '20.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '12', '0', '2017-06-03 11:49:33', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('99', '84', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '3.5000', '3.5000', '5.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '17.5000', '', '3.5000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '13', '0', '2017-06-03 11:50:54', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('100', '84', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '1.0000', '1.0000', '5.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '1.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '14', '0', '2017-06-03 11:50:54', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('99', '84', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '3.5000', '3.5000', '5.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '17.5000', '', '3.5000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '15', '0', '2017-06-03 11:51:40', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('100', '84', null, '4', 'CAM-0001', 'Cambodia', 'standard', null, '1.0000', '1.0000', '5.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '1.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '16', '0', '2017-06-03 11:51:40', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('101', '85', null, '9', 'MM-0001', 'Mey Mey', 'standard', null, '3.0000', '3.0000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '15.0000', '', '3.0000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '17', '0', '2017-06-03 11:57:30', 'UPDATED');
INSERT INTO `erp_sale_items_audit` VALUES ('102', '85', null, '2', 'RG-001', 'Return Group 1', 'standard', null, '3.5000', '3.5000', '0.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '17.5000', '', '3.5000', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '18', '0', '2017-06-03 11:57:31', 'UPDATED');

-- ----------------------------
-- Table structure for erp_sale_order
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_order`;
CREATE TABLE `erp_sale_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quote_id` int(11) DEFAULT NULL,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `group_areas_id` int(10) DEFAULT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `staff_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.0000',
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `order_status` varchar(20) DEFAULT NULL,
  `sale_status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_items` tinyint(4) DEFAULT NULL,
  `total_cost` decimal(25,4) NOT NULL,
  `pos` tinyint(1) NOT NULL DEFAULT '0',
  `paid` decimal(25,4) DEFAULT '0.0000',
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  `attachment1` varchar(55) DEFAULT NULL,
  `attachment2` varchar(55) DEFAULT NULL,
  `suspend_note` varchar(20) DEFAULT NULL,
  `other_cur_paid` decimal(25,0) DEFAULT NULL,
  `other_cur_paid_rate` decimal(25,0) DEFAULT '1',
  `other_cur_paid1` decimal(25,4) DEFAULT NULL,
  `other_cur_paid_rate1` decimal(25,4) DEFAULT NULL,
  `saleman_by` int(11) DEFAULT NULL,
  `reference_no_tax` varchar(55) NOT NULL,
  `tax_status` varchar(255) DEFAULT NULL,
  `opening_ar` tinyint(1) DEFAULT '0',
  `delivery_by` int(11) DEFAULT NULL,
  `sale_type` tinyint(1) DEFAULT NULL,
  `delivery_status` varchar(20) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `bill_to` varchar(255) DEFAULT NULL,
  `po` varchar(50) DEFAULT NULL,
  `project_manager` int(11) DEFAULT NULL,
  `assign_to_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_order
-- ----------------------------
INSERT INTO `erp_sale_order` VALUES ('1', '2017-06-01 18:59:00', null, 'SAO/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '565.0000', '0.0000', '10', '56.5000', '10.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '555.0000', 'completed', 'order', 'due', null, null, '1', null, null, '127', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, null, null, null, '3');
INSERT INTO `erp_sale_order` VALUES ('2', '2017-06-01 20:46:22', null, 'SAO/1706/00001', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '100', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, null, null, null, null);
INSERT INTO `erp_sale_order` VALUES ('3', '2017-06-02 08:03:09', null, 'SAO/1706/00002', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '25', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('4', '2017-06-02 09:35:54', null, 'SAO/1706/00003', '5', 'RKS-Ta Kmao', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '5.0000', '5.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '10', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('5', '2017-06-02 09:37:02', null, 'SAO/1706/00004', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '2', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('6', '2017-06-02 09:39:51', null, 'SAO/1706/00005', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '10.0000', '10.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '10', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('7', '2017-06-02 09:45:03', null, 'SAO/1706/00006', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '5', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('8', '2017-06-02 09:52:43', null, 'SAO/1706/00007', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '1', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('9', '2017-06-02 09:59:48', null, 'SAO/1706/00008', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '12.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '12.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '1', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('10', '2017-06-02 10:01:50', null, 'SAO/1706/00009', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '1', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('11', '2017-06-02 10:04:25', null, 'SAO/1706/00010', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('12', '2017-06-02 10:08:23', null, 'SAO/1706/00011', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('13', '2017-06-02 10:09:53', null, 'SAO/1706/00012', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('14', '2017-06-02 10:10:59', null, 'SAO/1706/00013', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('15', '2017-06-02 10:13:45', null, 'SAO/1706/00014', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '4', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, null, null);
INSERT INTO `erp_sale_order` VALUES ('16', '2017-06-03 11:50:00', null, 'SAO/1706/00015', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', '', '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '1', null, null, '8', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', '0', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for erp_sale_order_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_order_audit`;
CREATE TABLE `erp_sale_order_audit` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quote_id` int(11) DEFAULT NULL,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `group_areas_id` int(10) DEFAULT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `staff_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.0000',
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `order_status` varchar(20) DEFAULT NULL,
  `sale_status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_items` tinyint(4) DEFAULT NULL,
  `total_cost` decimal(25,4) NOT NULL,
  `pos` tinyint(1) NOT NULL DEFAULT '0',
  `paid` decimal(25,4) DEFAULT '0.0000',
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  `attachment1` varchar(55) DEFAULT NULL,
  `attachment2` varchar(55) DEFAULT NULL,
  `suspend_note` varchar(20) DEFAULT NULL,
  `other_cur_paid` decimal(25,0) DEFAULT NULL,
  `other_cur_paid_rate` decimal(25,0) DEFAULT '1',
  `other_cur_paid1` decimal(25,4) DEFAULT NULL,
  `other_cur_paid_rate1` decimal(25,4) DEFAULT NULL,
  `saleman_by` int(11) DEFAULT NULL,
  `reference_no_tax` varchar(55) NOT NULL,
  `tax_status` varchar(255) DEFAULT NULL,
  `opening_ar` tinyint(1) DEFAULT '0',
  `delivery_by` int(11) DEFAULT NULL,
  `sale_type` tinyint(1) DEFAULT NULL,
  `delivery_status` varchar(20) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `bill_to` varchar(255) DEFAULT NULL,
  `po` varchar(50) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_order_audit
-- ----------------------------
INSERT INTO `erp_sale_order_audit` VALUES ('1', '2017-06-01 18:59:00', null, 'SAO/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '565.0000', '0.0000', '10', '56.5000', '10.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '555.0000', 'completed', 'order', 'due', null, null, '1', null, null, '127', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, null, null, '1', '0', '2017-06-01 19:59:27', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('1', '2017-06-01 18:59:00', null, 'SAO/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '565.0000', '0.0000', '10', '56.5000', '10.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '555.0000', 'completed', 'order', 'due', null, null, '1', null, null, '127', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, null, null, '2', '0', '2017-06-01 19:59:36', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('1', '2017-06-01 18:59:00', null, 'SAO/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '565.0000', '0.0000', '10', '56.5000', '10.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '555.0000', 'completed', 'order', 'due', null, null, '1', null, null, '127', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, null, null, '3', '0', '2017-06-01 19:59:43', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('1', '2017-06-01 18:59:00', null, 'SAO/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '565.0000', '0.0000', '10', '56.5000', '10.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '555.0000', 'completed', 'order', 'due', null, null, '1', null, null, '127', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, null, null, '4', '0', '2017-06-01 20:00:03', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('1', '2017-06-01 18:59:00', null, 'SAO/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '565.0000', '0.0000', '10', '56.5000', '10.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '555.0000', 'completed', 'order', 'due', null, null, '1', null, null, '127', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, null, null, '5', '0', '2017-06-01 20:01:06', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('1', '2017-06-01 18:59:00', null, 'SAO/1706/00004', '2', 'General Customer', '0', '1', 'ABC Company', '1', '', '', '565.0000', '0.0000', '10', '56.5000', '10.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '555.0000', 'completed', 'order', 'due', null, null, '1', null, null, '127', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, null, null, '6', '0', '2017-06-01 20:01:30', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('2', '2017-06-01 20:46:22', null, 'SAO/1706/00001', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'order', 'due', null, null, '3', null, null, '100', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, null, null, '7', '0', '2017-06-01 20:51:36', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('2', '2017-06-01 20:46:22', null, 'SAO/1706/00001', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '100', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, null, null, '8', '0', '2017-06-01 20:51:36', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('3', '2017-06-02 08:03:09', null, 'SAO/1706/00002', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'order', 'due', null, null, '3', null, null, '25', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', null, null, null, null, '', null, '9', '0', '2017-06-02 08:05:09', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('3', '2017-06-02 08:03:09', null, 'SAO/1706/00002', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '25', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', null, null, null, null, '', null, '10', '0', '2017-06-02 08:05:09', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('5', '2017-06-02 09:37:02', null, 'SAO/1706/00004', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'order', 'due', null, null, '3', null, null, '2', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, '', null, '11', '0', '2017-06-02 09:38:10', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('5', '2017-06-02 09:37:02', null, 'SAO/1706/00004', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '2', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, '', null, '12', '0', '2017-06-02 09:38:10', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('6', '2017-06-02 09:39:51', null, 'SAO/1706/00005', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '10.0000', '10.0000', 'completed', 'order', 'due', null, null, '3', null, null, '10', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '13', '0', '2017-06-02 09:40:27', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('4', '2017-06-02 09:35:54', null, 'SAO/1706/00003', '5', 'RKS-Ta Kmao', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '5.0000', '5.0000', 'completed', 'order', 'due', null, null, '3', null, null, '10', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, '', null, '14', '0', '2017-06-02 09:44:22', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('4', '2017-06-02 09:35:54', null, 'SAO/1706/00003', '5', 'RKS-Ta Kmao', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '5.0000', '5.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '10', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '3', '', null, '0', '0', null, null, null, '', null, '15', '0', '2017-06-02 09:44:23', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('7', '2017-06-02 09:45:03', null, 'SAO/1706/00006', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'order', 'due', null, null, '3', null, null, '5', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '16', '0', '2017-06-02 09:45:27', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('8', '2017-06-02 09:52:43', null, 'SAO/1706/00007', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'order', 'due', null, null, '3', null, null, '1', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, '', null, '17', '0', '2017-06-02 09:56:21', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('9', '2017-06-02 09:59:48', null, 'SAO/1706/00008', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '12.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '12.0000', 'completed', 'order', 'due', null, null, '3', null, null, '1', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', null, null, null, null, '', null, '18', '0', '2017-06-02 09:59:59', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('10', '2017-06-02 10:01:50', null, 'SAO/1706/00009', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'order', 'due', null, null, '3', null, null, '1', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', '0', null, null, null, '', null, '19', '0', '2017-06-02 10:02:02', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('11', '2017-06-02 10:04:25', null, 'SAO/1706/00010', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'order', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', null, null, null, null, '', null, '20', '0', '2017-06-02 10:04:36', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('12', '2017-06-02 10:08:23', null, 'SAO/1706/00011', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'order', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '1', '', null, '0', null, null, null, null, '', null, '21', '0', '2017-06-02 10:08:34', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('13', '2017-06-02 10:09:53', null, 'SAO/1706/00012', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'order', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '22', '0', '2017-06-02 10:10:04', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('14', '2017-06-02 10:10:59', null, 'SAO/1706/00013', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'order', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '23', '0', '2017-06-02 10:11:11', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('14', '2017-06-02 10:10:59', null, 'SAO/1706/00013', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '122.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '122.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '0', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '24', '0', '2017-06-02 10:11:13', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('15', '2017-06-02 10:13:45', null, 'SAO/1706/00014', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'order', 'due', null, null, '3', null, null, '4', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '25', '0', '2017-06-02 10:14:22', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('15', '2017-06-02 10:13:45', null, 'SAO/1706/00014', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '4', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '26', '0', '2017-06-02 10:14:22', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('15', '2017-06-02 10:13:45', null, 'SAO/1706/00014', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', null, '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '3', null, null, '4', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', null, null, null, null, '', null, '27', '0', '2017-06-02 10:14:25', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('16', '2017-06-03 11:50:00', null, 'SAO/1706/00015', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', '', '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'order', 'due', null, null, '1', null, null, '8', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', '0', null, null, null, null, null, '28', '0', '2017-06-03 11:46:29', 'UPDATED');
INSERT INTO `erp_sale_order_audit` VALUES ('16', '2017-06-03 11:50:00', null, 'SAO/1706/00015', '2', 'General Customer', '0', '4', 'RKS-Head Office', '2', '', '', '0.0000', '0.0000', '', '0.0000', null, '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', 'completed', 'sale', 'due', null, null, '1', null, null, '8', '0.0000', '0', '0.0000', null, '0.0000', '', '', '', null, null, '1', null, null, '0', '', null, '0', '0', null, null, null, null, null, '29', '0', '2017-06-03 11:46:30', 'UPDATED');

-- ----------------------------
-- Table structure for erp_sale_order_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_order_items`;
CREATE TABLE `erp_sale_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `product_noted` varchar(30) DEFAULT NULL,
  `group_price_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_order_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_order_id`),
  KEY `sale_id_2` (`sale_order_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_order_items
-- ----------------------------
INSERT INTO `erp_sale_order_items` VALUES ('1', '1', '1', '1', 'Product_test', 'standard', '0', '1.0000', '1.0000', '0.0000', '565.0000', '1', '0.0000', '1', '0.0000%', '0', '0.0000', '565.0000', '', '1.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('2', '2', '5', '01KD', 'KAKADA_01', 'standard', null, '0.0000', '0.0000', '0.0000', '100.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('3', '3', '5', '01KD', 'KAKADA_01', 'standard', null, '0.0000', '0.0000', '0.0000', '25.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('4', '4', '4', 'CAM-0001', 'Cambodia', 'standard', '0', '0.0000', '0.0000', '0.0000', '5.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('5', '4', '5', '01KD', 'KAKADA_01', 'standard', null, '0.0000', '0.0000', '0.0000', '5.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('6', '5', '4', 'CAM-0001', 'Cambodia', 'standard', null, '0.0000', '0.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('7', '5', '1', '1', 'Product_test', 'standard', null, '0.0000', '0.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('8', '6', '1', '1', 'Product_test', 'standard', null, '0.0000', '0.0000', '0.0000', '10.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('9', '7', '4', 'CAM-0001', 'Cambodia', 'standard', null, '0.0000', '0.0000', '0.0000', '5.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('10', '8', '1', '1', 'Product_test', 'standard', null, '0.0000', '0.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('11', '9', '4', 'CAM-0001', 'Cambodia', 'standard', '0', '12.0000', '12.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '12.0000', '', '12.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('12', '10', '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '122.0000', '', '122.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('13', '11', '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '122.0000', '', '122.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('14', '12', '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '122.0000', '', '122.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('15', '13', '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '122.0000', '', '122.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('16', '14', '5', '01KD', 'KAKADA_01', 'standard', '0', '122.0000', '122.0000', '0.0000', '1.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '122.0000', '', '122.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('17', '15', '6', '02KD', 'KAKADA_02', 'standard', null, '0.0000', '0.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('18', '15', '5', '01KD', 'KAKADA_01', 'standard', null, '0.0000', '0.0000', '0.0000', '2.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);
INSERT INTO `erp_sale_order_items` VALUES ('19', '16', '5', '01KD', 'KAKADA_01', 'standard', null, '0.0000', '0.0000', '0.0000', '8.0000', '2', '0.0000', '1', '0.0000%', '0', '0.0000', '0.0000', '', '0.0000', '', null);

-- ----------------------------
-- Table structure for erp_sale_order_items_audit
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_order_items_audit`;
CREATE TABLE `erp_sale_order_items_audit` (
  `id` int(11) NOT NULL,
  `sale_order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `product_noted` varchar(30) DEFAULT NULL,
  `group_price_id` int(11) DEFAULT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_created_by` int(11) NOT NULL,
  `audit_record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `audit_type` varchar(55) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `sale_id` (`sale_order_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_order_id`),
  KEY `sale_id_2` (`sale_order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_order_items_audit
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sale_tax
-- ----------------------------
DROP TABLE IF EXISTS `erp_sale_tax`;
CREATE TABLE `erp_sale_tax` (
  `vat_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` varchar(100) DEFAULT '',
  `sale_id` varchar(100) DEFAULT '',
  `customer_id` varchar(100) DEFAULT '',
  `issuedate` datetime DEFAULT NULL,
  `vatin` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `qty` double(8,4) DEFAULT NULL,
  `non_tax_sale` double(8,4) DEFAULT NULL,
  `value_export` double(8,4) DEFAULT NULL,
  `amound` double DEFAULT NULL,
  `amound_tax` double DEFAULT '0',
  `amound_declare` double(8,4) DEFAULT NULL,
  `tax_value` double(8,4) DEFAULT NULL,
  `vat` double(8,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `journal_date` date DEFAULT NULL,
  `journal_location` varchar(100) DEFAULT NULL,
  `referent_no` varchar(255) DEFAULT NULL,
  `amount_tax_declare` int(100) DEFAULT NULL,
  `tax_type` tinyint(1) DEFAULT NULL,
  `pns` int(2) DEFAULT NULL,
  `sale_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`vat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sale_tax
-- ----------------------------
INSERT INTO `erp_sale_tax` VALUES ('1', '1', '85', 'General Customer', '2017-06-03 00:00:00', null, null, null, null, null, '50', '10', '9999.9999', null, null, '1', null, null, 'T001', null, null, null, '2');

-- ----------------------------
-- Table structure for erp_serial
-- ----------------------------
DROP TABLE IF EXISTS `erp_serial`;
CREATE TABLE `erp_serial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `serial_number` varchar(150) DEFAULT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `serial_status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_serial
-- ----------------------------

-- ----------------------------
-- Table structure for erp_sessions
-- ----------------------------
DROP TABLE IF EXISTS `erp_sessions`;
CREATE TABLE `erp_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_sessions
-- ----------------------------
INSERT INTO `erp_sessions` VALUES ('0030fa169fe55f62344a0c539937a86d387436cf', '192.168.1.15', '1496457866', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435343930373B6964656E746974797C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365726E616D657C733A31303A2273616C656F6666696365223B656D61696C7C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365725F69647C733A313A2233223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333937393333223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A323A223130223B77617265686F7573655F69647C733A313A2232223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C4E3B73686F775F70726963657C733A313A2231223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('02b78739ce37d88efdf581971cca38fefb0557ba', '192.168.1.114', '1496394178', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339333739363B7265717565737465645F706167657C733A31333A227075726368617365732F616464223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333932383330223B6C6173745F69707C733A31323A223139322E3136382E312E3533223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A22535A716D7A6B6433567077543647386139374C6F223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('0abea30a58d6703e7d1035f8569cf87c4d7304dc', '192.168.1.29', '1496397802', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339373830313B7265717565737465645F706167657C733A393A2273616C65732F616464223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333835303738223B6C6173745F69707C733A31313A223139322E3136382E312E32223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2231223B757365725F637372667C733A32303A226B4A46453265576E356C6967614B787A56755544223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('0d75a91c71ebb341671454eb2f006e8abe34815e', '192.168.1.53', '1496454281', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435323330383B7265717565737465645F706167657C733A353A2273616C6573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343531353338223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('193edfd954e7afa52bc18064f9345158d4f443b6', '192.168.1.53', '1496389205', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363338393230333B7265717565737465645F706167657C733A333A22706F73223B);
INSERT INTO `erp_sessions` VALUES ('1dbcaab6454b579a6e923d784d857db26c6bfb52', '192.168.1.100', '1496466065', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436343831343B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343534363530223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F736F327C733A313A2231223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('21d83e54a09b208465d25ae45303a4e63c49aaeb', '192.168.1.29', '1496465095', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436323739303B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343532333238223B6C6173745F69707C733A31323A223139322E3136382E312E3533223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A226945395157756164626B336A6E524A3749304C5A223B);
INSERT INTO `erp_sessions` VALUES ('2462a8279495df62746fb0df7cf251dd79cc6cf4', '192.168.1.110', '1496462326', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435393435353B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333933373939223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A227666314F6D7A5A646C4161555843716550454B39223B72656D6F76655F706F6C737C733A313A2231223B72656D6F76655F73327C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('251ac35ec7c544741e06bdfa2f0007b78ff5f11c', '192.168.1.110', '1496397957', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339363038343B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333633393132223B6C6173745F69707C733A31333A223139322E3136382E312E313030223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C4E3B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A226B4275576A4638326D77376F414C744D306C4731223B72656D6F76655F73327C733A313A2231223B72656D6F76655F706F6C736F7C733A313A2231223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('2a7edd8819c1ac116042c54d6d3acc51008dfc28', '192.168.1.15', '1496454668', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435343634353B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343534353333223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('3629c4a2510a6e8934c10386f21df50db9586c68', '192.168.1.129', '1496463193', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436303633353B7265717565737465645F706167657C733A373A2277656C636F6D65223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343539383130223B6C6173745F69707C733A31333A223139322E3136382E312E313239223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('38ff6358ef3af8e25cd4cea8c2b91dad10b0a9e9', '192.168.1.15', '1496398024', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339363234393B7265717565737465645F706167657C733A32303A2273616C65732F6164645F64656C69766572696573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333835333834223B6C6173745F69707C733A31323A223139322E3136382E312E3239223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('4c29d1faf4dbda1ee117efb1c16bb1806c4f1937', '192.168.1.15', '1496395415', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339323730393B6964656E746974797C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365726E616D657C733A31303A2273616C656F6666696365223B656D61696C7C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365725F69647C733A313A2233223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333930303738223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A323A223130223B77617265686F7573655F69647C733A313A2232223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C4E3B73686F775F70726963657C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('56a155817435a7932f85585d7f66e87ad03b2646', '192.168.1.15', '1496454609', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435313732333B6964656E746974797C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365726E616D657C733A31303A2273616C656F6666696365223B656D61696C7C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365725F69647C733A313A2233223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333937393333223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A323A223130223B77617265686F7573655F69647C733A313A2232223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C4E3B73686F775F70726963657C733A313A2231223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('5a563b33fa4fb310bff6e0f9848f7982e2f3cc67', '192.168.1.29', '1496465983', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436353935333B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343532333238223B6C6173745F69707C733A31323A223139322E3136382E312E3533223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A223943636869734F4D66327946553058746F506472223B);
INSERT INTO `erp_sessions` VALUES ('5e54e64ca9cf92ddd51210644087738e38169af4', '192.168.1.15', '1496461014', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435383231373B6964656E746974797C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365726E616D657C733A31303A2273616C656F6666696365223B656D61696C7C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365725F69647C733A313A2233223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333937393333223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A323A223130223B77617265686F7573655F69647C733A313A2232223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C4E3B73686F775F70726963657C733A313A2231223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('638584c7656ae56cf121fac4e21fc854e105b17c', '192.168.1.115', '1496465898', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436353036383B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343630363533223B6C6173745F69707C733A31333A223139322E3136382E312E313239223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('7468836590e8a26ddbe9808dfcc668c5db1d24a7', '192.168.1.53', '1496395504', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339323832343B7265717565737465645F706167657C733A353A2273616C6573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333838333738223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B6C6173745F61637469766974797C693A313439363339353530343B);
INSERT INTO `erp_sessions` VALUES ('767952d721561f40da72052d3d716c6f7c82a502', '192.168.1.53', '1496398920', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339353937373B7265717565737465645F706167657C733A353A2273616C6573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333838333738223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B6C6173745F61637469766974797C693A313439363339383932303B72656769737465725F69647C733A313A2231223B636173685F696E5F68616E647C733A363A22302E30303030223B72656769737465725F6F70656E5F74696D657C733A31393A22323031372D30352D31332031343A33313A3539223B);
INSERT INTO `erp_sessions` VALUES ('79ee600044a0ab836756e886f2423a442309c66e', '192.168.1.53', '1496459856', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435373333373B7265717565737465645F706167657C733A353A2273616C6573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343531353338223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2231223B6C6173745F61637469766974797C693A313439363435393835343B72656769737465725F69647C733A313A2231223B636173685F696E5F68616E647C733A363A22302E30303030223B72656769737465725F6F70656E5F74696D657C733A31393A22323031372D30352D31332031343A33313A3539223B);
INSERT INTO `erp_sessions` VALUES ('7de2cf45b1c578faf7b5f061a85be1d434d92cd5', '192.168.1.53', '1496466882', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436363732343B7265717565737465645F706167657C733A353A2273616C6573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343531353338223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2230223B6C6173745F61637469766974797C693A313439363436363838303B72656769737465725F69647C733A313A2231223B636173685F696E5F68616E647C733A363A22302E30303030223B72656769737465725F6F70656E5F74696D657C733A31393A22323031372D30352D31332031343A33313A3539223B);
INSERT INTO `erp_sessions` VALUES ('80f336664a32c655d2bf7f1fc821b44611cbf3ae', '192.168.1.129', '1496463130', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436303530303B6964656E746974797C733A32303A226A616D656B616B61646140676D61696C2E636F6D223B757365726E616D657C733A31303A226A616D656B616B616461223B656D61696C7C733A32303A226A616D656B616B61646140676D61696C2E636F6D223B757365725F69647C733A313A2236223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343630333330223B6C6173745F69707C4E3B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2239223B77617265686F7573655F69647C733A333A22332C32223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2231223B616C6C6F775F646973636F756E747C733A313A2231223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B6C6173745F61637469766974797C693A313439363436323231363B);
INSERT INTO `erp_sessions` VALUES ('80fc37076c06e8dfa74baea58c59e8bfd2367609', '192.168.1.29', '1496391605', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339313539363B7265717565737465645F706167657C733A393A2273616C65732F616464223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333835303738223B6C6173745F69707C733A31313A223139322E3136382E312E32223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('89c8fb5b4b662f1310be7f5afd1527189ef5d66a', '192.168.1.110', '1496466904', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436353536333B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333933373939223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A22724C507861326B4D4F7067446435755456625277223B72656D6F76655F706F6C737C733A313A2231223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('8a0dc8c47673fdd9c8216529144d2fb590d03d70', '192.168.1.15', '1496461315', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435393231343B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343534353333223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('8a8d564500175da2f2004f5efd34067d81eed47c', '192.168.1.110', '1496455777', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435333232353B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333933373939223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A22467866655A444E7433506157735249766B484D4B223B72656D6F76655F706F6C737C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('8d794ace3a7978922135385ac53680e543ce437a', '192.168.1.29', '1496391171', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363338383537343B7265717565737465645F706167657C733A393A2273616C65732F616464223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333835303738223B6C6173745F69707C733A31313A223139322E3136382E312E32223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('8d7af22e8a52d40e925caa1a8da8f9273792aa94', '192.168.1.29', '1496455516', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435323736343B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343532333238223B6C6173745F69707C733A31323A223139322E3136382E312E3533223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2254775A55783442336F4144507056584B37396966223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('99be0c5a02f5d12f6edd572a592e1dd8018cf255', '192.168.1.114', '1496456048', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435343533313B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343532373932223B6C6173745F69707C733A31323A223139322E3136382E312E3239223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('a11b53a34f2c01ce2649099e4e02693f9cce4ec0', '192.168.1.15', '1496465762', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436343533343B6964656E746974797C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365726E616D657C733A31303A2273616C656F6666696365223B656D61696C7C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365725F69647C733A313A2233223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333937393333223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A323A223130223B77617265686F7573655F69647C733A313A2232223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C4E3B73686F775F70726963657C733A313A2231223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('a14aa3cb630d222f7544197b37391c41547867d7', '192.168.1.2', '1496391891', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363338383934393B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333834353632223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A226C464D54585A717A7849733553676E4832427534223B72656D6F76655F706F6C737C733A313A2230223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('a16ee962da028b31781f42c7bf59e6e36c926881', '192.168.1.15', '1496397947', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339373931373B6964656E746974797C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365726E616D657C733A31303A2273616C656F6666696365223B656D61696C7C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365725F69647C733A313A2233223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333932373235223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A323A223130223B77617265686F7573655F69647C733A313A2232223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C4E3B73686F775F70726963657C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('a31d377cb9a23ce91809e9914cc8e93d1fd26fb7', '192.168.1.110', '1496453221', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435303137363B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333933373939223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A225A6D65684F776646787475705057306442676156223B);
INSERT INTO `erp_sessions` VALUES ('aa0051c02c04424ac849b1d227edce5ab68ba6ce', '192.168.1.102', '1496466931', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436353938333B7265717565737465645F706167657C733A32393A2274617865735F7265706F7274732F76616C75655F61646465645F746178223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343635303732223B6C6173745F69707C733A31333A223139322E3136382E312E313135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('bfe714386a0611fdcadae23535a59b15c3b8829e', '192.168.1.15', '1496464371', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436313430353B6964656E746974797C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365726E616D657C733A31303A2273616C656F6666696365223B656D61696C7C733A32303A2273616C656F666669636540676D61696C2E636F6D223B757365725F69647C733A313A2233223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333937393333223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A323A223130223B77617265686F7573655F69647C733A313A2232223B766965775F72696768747C733A313A2231223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C733A313A2234223B636F6D70616E795F69647C4E3B73686F775F636F73747C4E3B73686F775F70726963657C733A313A2231223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('c692ef25f8f110f2bd0d21dfd12ece9b285b25e0', '192.168.1.53', '1496466538', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436333538353B7265717565737465645F706167657C733A353A2273616C6573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343531353338223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2230223B6C6173745F61637469766974797C693A313439363436363533373B72656769737465725F69647C733A313A2231223B636173685F696E5F68616E647C733A363A22302E30303030223B72656769737465725F6F70656E5F74696D657C733A31393A22323031372D30352D31332031343A33313A3539223B);
INSERT INTO `erp_sessions` VALUES ('cc6a707be6a24d133bdc608e1938579d3909dd74', '192.168.1.110', '1496395824', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339323939343B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333633393132223B6C6173745F69707C733A31333A223139322E3136382E312E313030223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C4E3B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A225175336A45363873644C3062427A635A79553531223B72656D6F76655F73327C733A313A2231223B72656D6F76655F706F6C736F7C733A313A2231223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('cd441297b72977af51b1ea270c4db22d76fdde51', '192.168.1.110', '1496465444', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436323439363B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333933373939223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A224468413471735645496E656C6970794E51617435223B72656D6F76655F706F6C737C733A313A2230223B72656D6F76655F73327C733A313A2231223B);
INSERT INTO `erp_sessions` VALUES ('d3e81ef9321d8fa8505823d34609d651dc123a93', '192.168.1.110', '1496459445', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435363434393B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333933373939223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A227666314F6D7A5A646C4161555843716550454B39223B72656D6F76655F706F6C737C733A313A2231223B72656D6F76655F73327C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('d6819f0c50213e172422133ae4c2e90f0c31dfd5', '192.168.1.15', '1496390468', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363338383936393B7265717565737465645F706167657C733A32303A2273616C65732F6164645F64656C69766572696573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333835333834223B6C6173745F69707C733A31323A223139322E3136382E312E3239223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('d6da0df08910494bb83c9365250dec143bded1ce', '192.168.1.29', '1496458940', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435383533353B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343532333238223B6C6173745F69707C733A31323A223139322E3136382E312E3533223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A227A3538756C47583076706472454A336263596D34223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('dc45b56fb0f8703231cf7a462a67542916eff70d', '192.168.1.29', '1496397749', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339343738343B7265717565737465645F706167657C733A393A2273616C65732F616464223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333835303738223B6C6173745F69707C733A31313A223139322E3136382E312E32223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2231223B757365725F637372667C733A32303A226B4A46453265576E356C6967614B787A56755544223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('dd0986ada57affa765115916fe8b7251edf52d92', '192.168.1.15', '1496465865', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436343030313B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343534353333223B6C6173745F69707C733A31333A223139322E3136382E312E313134223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('de0a278d71fe5fff1330ea56ed90c4d44e114a10', '192.168.1.100', '1496459509', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363435373939353B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343534363530223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('e118ed22232bd2d5d7076794087365791e24a92b', '192.168.1.110', '1496391773', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363338383931303B7265717565737465645F706167657C733A303A22223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333633393132223B6C6173745F69707C733A31333A223139322E3136382E312E313030223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C4E3B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A223945533266706435526C6D38495767595879364D223B72656D6F76655F73327C733A313A2231223B72656D6F76655F706F6C736F7C733A313A2231223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('e3173a0bc50ad9ae751849b7d3d5b627546a97dc', '192.168.1.114', '1496391354', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363338383337363B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333837383937223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A227444666D4B524D586C3745514E77476270634F50223B72656D6F76655F706F6C737C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('e3f3fd07cc2eb1f2a79019a434ab4c5fe23aa945', '192.168.1.15', '1496393810', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363339323539353B7265717565737465645F706167657C733A32303A2273616C65732F6164645F64656C69766572696573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936333835333834223B6C6173745F69707C733A31323A223139322E3136382E312E3239223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `erp_sessions` VALUES ('e6325d9ae667a30da6935962df9ef59db34637c6', '192.168.1.53', '1496463530', 0x5F5F63695F6C6173745F726567656E65726174657C693A313439363436303535383B7265717565737465645F706167657C733A353A2273616C6573223B6964656E746974797C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32313A226F776E657240636C6F75646E65742E636F6D2E6B68223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231343936343531353338223B6C6173745F69707C733A31323A223139322E3136382E312E3135223B6176617461727C733A303A22223B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C733A303A22223B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B72656D6F76655F73327C733A313A2230223B6C6173745F61637469766974797C693A313439363436333236313B72656769737465725F69647C733A313A2231223B636173685F696E5F68616E647C733A363A22302E30303030223B72656769737465725F6F70656E5F74696D657C733A31393A22323031372D30352D31332031343A33313A3539223B);

-- ----------------------------
-- Table structure for erp_settings
-- ----------------------------
DROP TABLE IF EXISTS `erp_settings`;
CREATE TABLE `erp_settings` (
  `setting_id` int(1) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logo2` varchar(255) NOT NULL,
  `site_name` varchar(55) NOT NULL,
  `language` varchar(20) NOT NULL,
  `default_warehouse` int(2) NOT NULL,
  `accounting_method` tinyint(4) NOT NULL DEFAULT '0',
  `default_currency` varchar(10) NOT NULL,
  `default_tax_rate` int(2) NOT NULL,
  `rows_per_page` int(2) NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT '1.0',
  `default_tax_rate2` int(11) NOT NULL DEFAULT '0',
  `dateformat` int(11) NOT NULL,
  `sales_prefix` varchar(20) DEFAULT NULL,
  `quote_prefix` varchar(20) DEFAULT NULL,
  `purchase_prefix` varchar(20) DEFAULT NULL,
  `transfer_prefix` varchar(20) DEFAULT NULL,
  `delivery_prefix` varchar(20) DEFAULT NULL,
  `payment_prefix` varchar(20) DEFAULT NULL,
  `return_prefix` varchar(20) DEFAULT NULL,
  `expense_prefix` varchar(20) DEFAULT NULL,
  `transaction_prefix` varchar(10) DEFAULT NULL,
  `item_addition` tinyint(1) NOT NULL DEFAULT '0',
  `theme` varchar(20) NOT NULL,
  `product_serial` tinyint(4) NOT NULL,
  `default_discount` int(11) NOT NULL,
  `product_discount` tinyint(1) NOT NULL DEFAULT '0',
  `discount_method` tinyint(4) NOT NULL,
  `tax1` tinyint(4) NOT NULL,
  `tax2` tinyint(4) NOT NULL,
  `overselling` tinyint(1) NOT NULL DEFAULT '0',
  `restrict_user` tinyint(4) NOT NULL DEFAULT '0',
  `restrict_calendar` tinyint(4) NOT NULL DEFAULT '0',
  `timezone` varchar(100) DEFAULT NULL,
  `iwidth` int(11) NOT NULL DEFAULT '0',
  `iheight` int(11) NOT NULL,
  `twidth` int(11) NOT NULL,
  `theight` int(11) NOT NULL,
  `watermark` tinyint(1) DEFAULT NULL,
  `reg_ver` tinyint(1) DEFAULT NULL,
  `allow_reg` tinyint(1) DEFAULT NULL,
  `reg_notification` tinyint(1) DEFAULT NULL,
  `auto_reg` tinyint(1) DEFAULT NULL,
  `protocol` varchar(20) NOT NULL DEFAULT 'mail',
  `mailpath` varchar(55) DEFAULT '/usr/sbin/sendmail',
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_user` varchar(100) DEFAULT NULL,
  `smtp_pass` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(10) DEFAULT '25',
  `smtp_crypto` varchar(10) DEFAULT NULL,
  `corn` datetime DEFAULT NULL,
  `customer_group` int(11) NOT NULL,
  `default_email` varchar(100) NOT NULL,
  `mmode` tinyint(1) NOT NULL,
  `bc_fix` tinyint(4) NOT NULL DEFAULT '0',
  `auto_detect_barcode` tinyint(1) NOT NULL DEFAULT '0',
  `captcha` tinyint(1) NOT NULL DEFAULT '1',
  `reference_format` tinyint(1) NOT NULL DEFAULT '1',
  `racks` tinyint(1) DEFAULT '0',
  `attributes` tinyint(1) NOT NULL DEFAULT '0',
  `product_expiry` tinyint(1) NOT NULL DEFAULT '0',
  `purchase_decimals` tinyint(2) NOT NULL DEFAULT '2',
  `decimals` tinyint(2) NOT NULL DEFAULT '2',
  `qty_decimals` tinyint(2) NOT NULL DEFAULT '2',
  `decimals_sep` varchar(2) NOT NULL DEFAULT '.',
  `thousands_sep` varchar(2) NOT NULL DEFAULT ',',
  `invoice_view` tinyint(1) DEFAULT '0',
  `default_biller` int(11) DEFAULT NULL,
  `envato_username` varchar(50) DEFAULT NULL,
  `purchase_code` varchar(100) DEFAULT NULL,
  `rtl` tinyint(1) DEFAULT '0',
  `each_spent` decimal(15,4) DEFAULT NULL,
  `ca_point` tinyint(4) DEFAULT NULL,
  `each_sale` decimal(15,4) DEFAULT NULL,
  `sa_point` tinyint(4) DEFAULT NULL,
  `update` tinyint(1) DEFAULT '0',
  `sac` tinyint(1) DEFAULT '0',
  `display_all_products` tinyint(1) DEFAULT '0',
  `display_symbol` tinyint(1) DEFAULT NULL,
  `symbol` varchar(50) DEFAULT NULL,
  `item_slideshow` tinyint(1) DEFAULT NULL,
  `barcode_separator` varchar(2) NOT NULL DEFAULT '_',
  `remove_expired` tinyint(1) DEFAULT '0',
  `sale_payment_prefix` varchar(20) DEFAULT NULL,
  `purchase_payment_prefix` varchar(20) DEFAULT NULL,
  `sale_loan_prefix` varchar(20) DEFAULT NULL,
  `auto_print` tinyint(1) DEFAULT '1',
  `returnp_prefix` varchar(20) DEFAULT NULL,
  `alert_day` tinyint(3) NOT NULL DEFAULT '0',
  `convert_prefix` varchar(20) DEFAULT NULL,
  `purchase_serial` tinyint(4) NOT NULL,
  `enter_using_stock_prefix` varchar(25) DEFAULT NULL,
  `enter_using_stock_return_prefix` varchar(25) DEFAULT NULL,
  `supplier_deposit_prefix` varchar(20) DEFAULT NULL,
  `sale_order_prefix` varchar(20) DEFAULT NULL,
  `boms_method` tinyint(1) DEFAULT '0',
  `separate_code` tinyint(1) DEFAULT NULL,
  `show_code` tinyint(1) DEFAULT NULL,
  `bill_to` tinyint(1) DEFAULT NULL,
  `show_po` tinyint(1) DEFAULT NULL,
  `show_company_code` tinyint(1) DEFAULT NULL,
  `purchase_order_prefix` varchar(20) DEFAULT NULL,
  `credit_limit` int(11) DEFAULT '0',
  `purchase_request_prefix` varchar(20) DEFAULT NULL,
  `acc_cate_separate` tinyint(1) DEFAULT NULL,
  `stock_deduction` varchar(10) DEFAULT NULL,
  `delivery` varchar(25) DEFAULT NULL,
  `authorization` varchar(50) DEFAULT NULL,
  `shipping` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_settings
-- ----------------------------
INSERT INTO `erp_settings` VALUES ('1', '', 'header_logo.png', 'iCloudERP Software', 'english', '1', '2', 'USD', '1', '10', '3.4', '1', '5', 'SALE', 'QUOTE', 'PO', 'TR', 'DO', 'IPAY', 'RE', 'EX', 'J', '0', 'default', '0', '1', '1', '1', '1', '1', '1', '1', '0', 'Asia/Phnom_Penh', '800', '800', '60', '60', '0', '0', '0', '0', null, 'smtp', '/usr/sbin/sendmail', 'icloud-erp.info', 'crm@icloud-erp.info', 'BOL/pT0aqYcUU8MtWnNSP1MTiL/3jLrS/QhYHMjd5XrGmLWyZiBUvGoySrReA47TOFetBI0LsTnx6i7uaEYnWA==', '465', 'ssl', '0000-00-00 00:00:00', '1', 'iclouderp@gmail.com', '0', '4', '0', '0', '1', '0', '0', '0', '6', '6', '6', '.', ',', '0', '1', 'cloud-net', '53d35644-a36e-45cd-b7ee-8dde3a08f83d', '0', '10.0000', '1', '100.0000', '1', '0', '0', '0', '0', 'B', '0', '_', '0', 'RV', 'PV', 'LOAN', '0', 'PRE', '7', 'CON', '0', 'ES', 'ESR', 'SDE', 'SAO', '0', '1', '1', '0', '0', '1', 'PAO', '0', 'PQ', '1', 'delivery', 'both', 'manual', '0');

-- ----------------------------
-- Table structure for erp_skrill
-- ----------------------------
DROP TABLE IF EXISTS `erp_skrill`;
CREATE TABLE `erp_skrill` (
  `id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `account_email` varchar(255) NOT NULL DEFAULT 'testaccount2@moneybookers.com',
  `secret_word` varchar(20) NOT NULL DEFAULT 'mbtest',
  `skrill_currency` varchar(3) NOT NULL DEFAULT 'USD',
  `fixed_charges` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `extra_charges_my` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `extra_charges_other` decimal(25,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_skrill
-- ----------------------------

-- ----------------------------
-- Table structure for erp_stock_counts
-- ----------------------------
DROP TABLE IF EXISTS `erp_stock_counts`;
CREATE TABLE `erp_stock_counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `initial_file` varchar(50) NOT NULL,
  `final_file` varchar(50) DEFAULT NULL,
  `brands` varchar(50) DEFAULT NULL,
  `brand_names` varchar(100) DEFAULT NULL,
  `categories` varchar(50) DEFAULT NULL,
  `category_names` varchar(100) DEFAULT NULL,
  `note` text,
  `products` int(11) DEFAULT NULL,
  `rows` int(11) DEFAULT NULL,
  `differences` int(11) DEFAULT NULL,
  `matches` int(11) DEFAULT NULL,
  `missing` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `finalized` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_stock_counts
-- ----------------------------

-- ----------------------------
-- Table structure for erp_stock_count_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_stock_count_items`;
CREATE TABLE `erp_stock_count_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_count_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_variant` varchar(55) DEFAULT NULL,
  `product_variant_id` int(11) DEFAULT NULL,
  `expected` decimal(15,4) NOT NULL,
  `counted` decimal(15,4) NOT NULL,
  `cost` decimal(25,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_count_id` (`stock_count_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_stock_count_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_subcategories
-- ----------------------------
DROP TABLE IF EXISTS `erp_subcategories`;
CREATE TABLE `erp_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `image` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_subcategories
-- ----------------------------

-- ----------------------------
-- Table structure for erp_suspended
-- ----------------------------
DROP TABLE IF EXISTS `erp_suspended`;
CREATE TABLE `erp_suspended` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `floor` varchar(20) DEFAULT '0',
  `ppl_number` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `inactive` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_suspended
-- ----------------------------
INSERT INTO `erp_suspended` VALUES ('1', 'Room 01', 'Room 01', '0', '4', '0', null, null, null, null, null);
INSERT INTO `erp_suspended` VALUES ('2', 'Room 02', 'Room 02', '0', '4', '0', null, null, null, null, null);
INSERT INTO `erp_suspended` VALUES ('3', 'Room 03', 'Room 03', '0', '2', '0', null, null, null, null, null);
INSERT INTO `erp_suspended` VALUES ('4', 'Room 04', 'Room 04', '0', '2', '0', null, null, null, null, null);

-- ----------------------------
-- Table structure for erp_suspended_bills
-- ----------------------------
DROP TABLE IF EXISTS `erp_suspended_bills`;
CREATE TABLE `erp_suspended_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_date` datetime DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) DEFAULT NULL,
  `count` int(11) NOT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `suspend_id` int(11) NOT NULL DEFAULT '0',
  `suspend_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_suspended_bills
-- ----------------------------

-- ----------------------------
-- Table structure for erp_suspended_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_suspended_items`;
CREATE TABLE `erp_suspended_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suspend_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `product_noted` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_suspended_items
-- ----------------------------

-- ----------------------------
-- Table structure for erp_suspend_layout
-- ----------------------------
DROP TABLE IF EXISTS `erp_suspend_layout`;
CREATE TABLE `erp_suspend_layout` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `suspend_id` int(20) NOT NULL,
  `order` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_suspend_layout
-- ----------------------------

-- ----------------------------
-- Table structure for erp_taxation_type_of_account
-- ----------------------------
DROP TABLE IF EXISTS `erp_taxation_type_of_account`;
CREATE TABLE `erp_taxation_type_of_account` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_code` int(10) NOT NULL,
  `specific_tax_on_certain_merchandise_and_services` int(10) DEFAULT NULL,
  `accommodation_tax` int(10) DEFAULT NULL,
  `public_lighting_tax` int(10) DEFAULT NULL,
  `other_tax` int(10) DEFAULT NULL,
  `withholding_tax_on_resident` varchar(10) DEFAULT NULL,
  `withholding_tax_on_non_resident` varchar(10) DEFAULT NULL,
  `account_tax_code` varchar(10) DEFAULT NULL,
  `deductible_expenses` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_taxation_type_of_account
-- ----------------------------

-- ----------------------------
-- Table structure for erp_taxation_type_of_product
-- ----------------------------
DROP TABLE IF EXISTS `erp_taxation_type_of_product`;
CREATE TABLE `erp_taxation_type_of_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `specific_tax_on_certain_merchandise_and_services` int(10) DEFAULT NULL,
  `accommodation_tax` int(10) DEFAULT NULL,
  `public_lighting_tax` int(10) DEFAULT NULL,
  `other_tax` int(10) DEFAULT NULL,
  `withholding_tax_on_resident` varchar(10) DEFAULT NULL,
  `withholding_tax_on_non_resident` varchar(10) DEFAULT NULL,
  `payment_of_profit_tax` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_taxation_type_of_product
-- ----------------------------

-- ----------------------------
-- Table structure for erp_tax_exchange_rate
-- ----------------------------
DROP TABLE IF EXISTS `erp_tax_exchange_rate`;
CREATE TABLE `erp_tax_exchange_rate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `usd` int(10) DEFAULT NULL,
  `salary_khm` int(50) DEFAULT NULL,
  `average_khm` varchar(50) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `tax_type` varchar(255) DEFAULT NULL,
  `usd_curency` varchar(255) DEFAULT NULL,
  `kh_curency` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_tax_exchange_rate
-- ----------------------------

-- ----------------------------
-- Table structure for erp_tax_purchase_vat
-- ----------------------------
DROP TABLE IF EXISTS `erp_tax_purchase_vat`;
CREATE TABLE `erp_tax_purchase_vat` (
  `vat_id` int(11) NOT NULL,
  `bill_num` varchar(100) DEFAULT NULL,
  `debtorno` varchar(100) DEFAULT NULL,
  `locationname` varchar(100) DEFAULT NULL,
  `issuedate` date DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `amount_tax` double DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `journal_location` varchar(255) DEFAULT NULL,
  `journal_date` date DEFAULT NULL,
  PRIMARY KEY (`vat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_tax_purchase_vat
-- ----------------------------

-- ----------------------------
-- Table structure for erp_tax_rates
-- ----------------------------
DROP TABLE IF EXISTS `erp_tax_rates`;
CREATE TABLE `erp_tax_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `rate` decimal(12,4) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_tax_rates
-- ----------------------------
INSERT INTO `erp_tax_rates` VALUES ('1', 'No Tax', 'NT', '0.0000', '2');
INSERT INTO `erp_tax_rates` VALUES ('2', 'VAT @10%', 'VAT10', '10.0000', '1');
INSERT INTO `erp_tax_rates` VALUES ('3', 'GST @6%', 'GST', '6.0000', '1');
INSERT INTO `erp_tax_rates` VALUES ('4', 'VAT @20%', 'VT20', '20.0000', '1');
INSERT INTO `erp_tax_rates` VALUES ('5', 'TAX @10%', 'TAX', '10.0000', '1');

-- ----------------------------
-- Table structure for erp_term_types
-- ----------------------------
DROP TABLE IF EXISTS `erp_term_types`;
CREATE TABLE `erp_term_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of erp_term_types
-- ----------------------------
INSERT INTO `erp_term_types` VALUES ('1', '001', 'abc');

-- ----------------------------
-- Table structure for erp_transfers
-- ----------------------------
DROP TABLE IF EXISTS `erp_transfers`;
CREATE TABLE `erp_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_warehouse_id` int(11) NOT NULL,
  `from_warehouse_code` varchar(55) NOT NULL,
  `from_warehouse_name` varchar(55) NOT NULL,
  `to_warehouse_id` int(11) NOT NULL,
  `to_warehouse_code` varchar(55) NOT NULL,
  `to_warehouse_name` varchar(55) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT NULL,
  `grand_total` decimal(25,4) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'pending',
  `shipping` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  `attachment1` varchar(55) DEFAULT NULL,
  `attachment2` varchar(55) DEFAULT NULL,
  `biller_id` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_transfers
-- ----------------------------
INSERT INTO `erp_transfers` VALUES ('1', 'TR/1706/00001', '2017-06-01 20:58:06', '2', 'HO-01', 'Head Office', '4', 'TK01', 'Takmao', '', '1000.0000', '0.0000', '1000.0000', '4', 'completed', '0.0000', null, null, null, '1');
INSERT INTO `erp_transfers` VALUES ('2', 'TR/1706/00002', '2017-05-27 19:42:00', '4', 'TK01', 'Takmao', '2', 'HO-01', 'Head Office', '', '1000.0000', '0.0000', '1000.0000', '1', 'completed', '0.0000', null, null, null, '1');
INSERT INTO `erp_transfers` VALUES ('3', 'TR/1706/00003', '2017-06-02 08:13:57', '2', 'HO-01', 'Head Office', '4', 'TK01', 'Takmao', '', '1000.0000', '0.0000', '1000.0000', '4', 'completed', '0.0000', null, null, null, '1');

-- ----------------------------
-- Table structure for erp_transfer_items
-- ----------------------------
DROP TABLE IF EXISTS `erp_transfer_items`;
CREATE TABLE `erp_transfer_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) DEFAULT NULL,
  `quantity_balance` decimal(15,4) NOT NULL,
  `unit_cost` decimal(25,4) DEFAULT NULL,
  `real_unit_cost` decimal(25,4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`transfer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_transfer_items
-- ----------------------------
INSERT INTO `erp_transfer_items` VALUES ('1', '1', '5', '01KD', 'KAKADA_01', '0', null, '50.0000', '1', '0.0000', '0.0000', '20.0000', '1000.0000', '50.0000', '20.0000', '20.0000', '2017-06-01', '4', null);
INSERT INTO `erp_transfer_items` VALUES ('2', '2', '5', '01KD', 'KAKADA_01', '0', null, '50.0000', '1', '0.0000', '0.0000', '20.0000', '1000.0000', '50.0000', '20.0000', '20.0000', '2017-05-27', '2', null);
INSERT INTO `erp_transfer_items` VALUES ('3', '3', '5', '01KD', 'KAKADA_01', '0', null, '50.0000', '1', '0.0000', '0.0000', '20.0000', '1000.0000', '50.0000', '20.0000', '20.0000', '2017-06-02', '4', null);

-- ----------------------------
-- Table structure for erp_units
-- ----------------------------
DROP TABLE IF EXISTS `erp_units`;
CREATE TABLE `erp_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(55) NOT NULL,
  `base_unit` int(11) DEFAULT NULL,
  `operator` varchar(1) DEFAULT NULL,
  `unit_value` varchar(55) DEFAULT NULL,
  `operation_value` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `base_unit` (`base_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_units
-- ----------------------------
INSERT INTO `erp_units` VALUES ('1', '1', 'each', null, null, null, null);
INSERT INTO `erp_units` VALUES ('2', 'RG', 'Return Group', null, null, null, null);
INSERT INTO `erp_units` VALUES ('3', 'K0001', 'Kakada', null, null, null, null);

-- ----------------------------
-- Table structure for erp_users
-- ----------------------------
DROP TABLE IF EXISTS `erp_users`;
CREATE TABLE `erp_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `last_ip_address` varbinary(45) DEFAULT NULL,
  `ip_address` varbinary(45) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `avatar` varchar(55) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `warehouse_id` varchar(20) DEFAULT NULL,
  `biller_id` int(10) unsigned DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `show_cost` tinyint(1) DEFAULT '0',
  `show_price` tinyint(1) DEFAULT '0',
  `award_points` int(11) DEFAULT '0',
  `view_right` tinyint(1) NOT NULL DEFAULT '0',
  `edit_right` tinyint(1) NOT NULL DEFAULT '0',
  `allow_discount` tinyint(1) DEFAULT '0',
  `annualLeave` int(11) DEFAULT '0',
  `sickday` int(11) DEFAULT '0',
  `speacialLeave` int(11) DEFAULT NULL,
  `othersLeave` int(11) DEFAULT NULL,
  `first_name_kh` varchar(50) DEFAULT NULL,
  `last_name_kh` varchar(50) DEFAULT NULL,
  `nationality_kh` varchar(50) DEFAULT NULL,
  `race_kh` varchar(20) NOT NULL,
  `pos_layout` tinyint(1) DEFAULT NULL,
  `pack_id` varchar(50) DEFAULT NULL,
  `sales_standard` tinyint(1) DEFAULT NULL,
  `sales_combo` tinyint(1) DEFAULT NULL,
  `sales_digital` tinyint(1) DEFAULT NULL,
  `sales_service` tinyint(1) DEFAULT NULL,
  `sales_category` varchar(150) DEFAULT NULL,
  `purchase_standard` tinyint(1) DEFAULT NULL,
  `purchase_combo` tinyint(1) DEFAULT NULL,
  `purchase_digital` tinyint(1) DEFAULT NULL,
  `purchase_service` tinyint(1) DEFAULT NULL,
  `purchase_category` varchar(150) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nationality` varchar(64) DEFAULT NULL,
  `position` varchar(150) DEFAULT NULL,
  `salary` decimal(24,4) DEFAULT NULL,
  `spouse` varchar(150) DEFAULT NULL,
  `number_of_child` tinyint(4) DEFAULT NULL,
  `employeed_date` date DEFAULT NULL,
  `last_paid` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `note` text,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `emp_code` varchar(50) DEFAULT NULL,
  `allowance` decimal(24,4) DEFAULT NULL,
  `emp_type` varchar(10) DEFAULT NULL,
  `tax_salary_type` varchar(10) DEFAULT NULL,
  `hide_row` tinyint(1) DEFAULT '0',
  `emp_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`warehouse_id`,`biller_id`),
  KEY `group_id_2` (`group_id`,`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_users
-- ----------------------------
INSERT INTO `erp_users` VALUES ('1', 0x3139322E3136382E312E313032, 0x0000, 'owner', '06e6c33bfa4496ceceb8eff15f40ec726d8d2336', '', 'owner@cloudnet.com.kh', '', '', null, '078c30f596fa50aa383a756752d503275fdc59c8', '1351661704', '1496466006', '1', 'Own', 'Owner', 'ABC Shop', '012345678', '', 'male', '1', '', null, null, '0', '0', '146328', '0', '0', '0', '0', '0', null, null, '', '', '', '', null, '5', '1', '1', '1', '1', null, '1', '1', '1', '1', null, '1970-01-01', 'Khmer', '', '0.0000', '', '0', '2016-05-01', '2016-12-09', '', '', '', '0012', '0.0000', '', '', '0', null);
INSERT INTO `erp_users` VALUES ('2', 0x3139322E3136382E312E3533, 0x3139322E3136382E312E3533, 'sale', '1e41a2ce4414e3dc910e9940cd7108eabc029cb8', null, 'nachanna@gmail.com', null, null, null, null, '1496320898', '1496324647', '1', 'sale', 'sale', 'Tiger Concrete Co.,  Ltd', '015443834', null, 'male', '9', '1', '1', null, '1', null, '0', '1', '0', '0', '0', '0', null, null, null, null, null, '', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null);
INSERT INTO `erp_users` VALUES ('3', 0x3139322E3136382E312E3135, 0x3139322E3136382E312E313035, 'saleoffice', '134234b6c1713d78671881d8a3ea7c45b32ebbd1', null, 'saleoffice@gmail.com', null, null, null, '81a50c9ffb31f134ced67935f464278bc98de37a', '1496321556', '1496451726', '1', 'sale', 'sale', 'RKS-Head Office', '0000', null, 'male', '10', '2', '4', null, null, '1', '6', '1', '0', '0', '0', '0', null, null, null, null, null, '', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null);
INSERT INTO `erp_users` VALUES ('4', 0x3139322E3136382E312E313030, 0x3139322E3136382E312E313035, 'stockrks', '8343bc8cad2508e9749a6eb3d5cdc808eea2b0b6', null, 'stock@gmail.com', null, null, null, null, '1496322537', '1496364470', '1', 'stock', 'stock', 'RKS-Head Office', '0000000000', null, 'male', '9', '3,2', '4', null, '1', null, '0', '1', '0', '0', '0', '0', null, null, null, null, null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null);
INSERT INTO `erp_users` VALUES ('5', 0x3139322E3136382E312E313030, 0x3139322E3136382E312E313035, 'salebranch', 'e07d064f36469e3447e2993b48313b2438e517e5', null, 'salebranch@gmail.com', null, null, null, null, '1496323313', '1496367283', '1', 'sale', 'branch', 'RKS-Ta Kmao', '0000', null, 'male', '8', '4', '5', null, null, '1', '-2', '1', '0', '1', '0', '0', null, null, null, null, null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null);
INSERT INTO `erp_users` VALUES ('6', 0x3139322E3136382E312E313239, 0x3139322E3136382E312E313239, 'jamekakada', '677da7ed8b4dfea2e38edb948333c691f9c7adf9', null, 'jamekakada@gmail.com', null, null, null, null, '1496460330', '1496460533', '1', 'jame', 'kakada', 'Head Office', '0000000000000', null, 'male', '9', '3,2', '4', null, '0', '0', '0', '1', '1', '1', '0', '0', null, null, null, null, null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null);

-- ----------------------------
-- Table structure for erp_user_logins
-- ----------------------------
DROP TABLE IF EXISTS `erp_user_logins`;
CREATE TABLE `erp_user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_user_logins
-- ----------------------------
INSERT INTO `erp_user_logins` VALUES ('1', '1', null, 0x3139322E3136382E312E313030, 'owner@cloudnet.com.kh', '2017-06-01 18:45:48');
INSERT INTO `erp_user_logins` VALUES ('2', '1', null, 0x3139322E3136382E312E313036, 'owner@cloudnet.com.kh', '2017-06-01 18:45:54');
INSERT INTO `erp_user_logins` VALUES ('3', '1', null, 0x3139322E3136382E312E32, 'owner@cloudnet.com.kh', '2017-06-01 18:45:58');
INSERT INTO `erp_user_logins` VALUES ('4', '1', null, 0x3139322E3136382E312E313130, 'owner@cloudnet.com.kh', '2017-06-01 18:46:28');
INSERT INTO `erp_user_logins` VALUES ('5', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 18:46:52');
INSERT INTO `erp_user_logins` VALUES ('6', '1', null, 0x3139322E3136382E312E3239, 'owner@cloudnet.com.kh', '2017-06-01 19:04:20');
INSERT INTO `erp_user_logins` VALUES ('7', '2', null, 0x3139322E3136382E312E3533, 'nachanna@gmail.com', '2017-06-01 19:43:20');
INSERT INTO `erp_user_logins` VALUES ('8', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 19:52:56');
INSERT INTO `erp_user_logins` VALUES ('9', '3', null, 0x3139322E3136382E312E313035, 'saleoffice@gmail.com', '2017-06-01 19:53:15');
INSERT INTO `erp_user_logins` VALUES ('10', '4', null, 0x3139322E3136382E312E313035, 'stock@gmail.com', '2017-06-01 20:09:28');
INSERT INTO `erp_user_logins` VALUES ('11', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 20:12:18');
INSERT INTO `erp_user_logins` VALUES ('12', '4', null, 0x3139322E3136382E312E313035, 'stock@gmail.com', '2017-06-01 20:16:34');
INSERT INTO `erp_user_logins` VALUES ('13', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 20:19:43');
INSERT INTO `erp_user_logins` VALUES ('14', '3', null, 0x3139322E3136382E312E313035, 'saleoffice@gmail.com', '2017-06-01 20:22:42');
INSERT INTO `erp_user_logins` VALUES ('15', '3', null, 0x3139322E3136382E312E313035, 'saleoffice@gmail.com', '2017-06-01 20:35:17');
INSERT INTO `erp_user_logins` VALUES ('16', '2', null, 0x3139322E3136382E312E3533, 'nachanna@gmail.com', '2017-06-01 20:44:08');
INSERT INTO `erp_user_logins` VALUES ('17', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 20:47:09');
INSERT INTO `erp_user_logins` VALUES ('18', '4', null, 0x3139322E3136382E312E313035, 'stock@gmail.com', '2017-06-01 20:56:39');
INSERT INTO `erp_user_logins` VALUES ('19', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 21:00:11');
INSERT INTO `erp_user_logins` VALUES ('20', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 21:02:12');
INSERT INTO `erp_user_logins` VALUES ('21', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 21:04:57');
INSERT INTO `erp_user_logins` VALUES ('22', '3', null, 0x3139322E3136382E312E313035, 'saleoffice@gmail.com', '2017-06-01 21:08:32');
INSERT INTO `erp_user_logins` VALUES ('23', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-01 21:10:53');
INSERT INTO `erp_user_logins` VALUES ('24', '1', null, 0x3139322E3136382E312E313030, 'owner@cloudnet.com.kh', '2017-06-02 07:38:32');
INSERT INTO `erp_user_logins` VALUES ('25', '1', null, 0x3139322E3136382E312E313130, 'owner@cloudnet.com.kh', '2017-06-02 07:39:41');
INSERT INTO `erp_user_logins` VALUES ('26', '3', null, 0x3139322E3136382E312E313030, 'saleoffice@gmail.com', '2017-06-02 07:44:10');
INSERT INTO `erp_user_logins` VALUES ('27', '4', null, 0x3139322E3136382E312E313030, 'stock@gmail.com', '2017-06-02 07:45:49');
INSERT INTO `erp_user_logins` VALUES ('28', '4', null, 0x3139322E3136382E312E313030, 'stock@gmail.com', '2017-06-02 07:47:51');
INSERT INTO `erp_user_logins` VALUES ('29', '5', null, 0x3139322E3136382E312E313130, 'salebranch@gmail.com', '2017-06-02 07:50:11');
INSERT INTO `erp_user_logins` VALUES ('30', '1', null, 0x3139322E3136382E312E313030, 'owner@cloudnet.com.kh', '2017-06-02 07:51:14');
INSERT INTO `erp_user_logins` VALUES ('31', '1', null, 0x3139322E3136382E312E313030, 'owner@cloudnet.com.kh', '2017-06-02 07:52:40');
INSERT INTO `erp_user_logins` VALUES ('32', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-02 07:56:16');
INSERT INTO `erp_user_logins` VALUES ('33', '1', null, 0x3139322E3136382E312E313030, 'owner@cloudnet.com.kh', '2017-06-02 08:00:33');
INSERT INTO `erp_user_logins` VALUES ('34', '3', null, 0x3139322E3136382E312E313030, 'saleoffice@gmail.com', '2017-06-02 08:01:21');
INSERT INTO `erp_user_logins` VALUES ('35', '1', null, 0x3139322E3136382E312E3939, 'owner@cloudnet.com.kh', '2017-06-02 08:02:05');
INSERT INTO `erp_user_logins` VALUES ('36', '1', null, 0x3139322E3136382E312E3239, 'owner@cloudnet.com.kh', '2017-06-02 08:02:16');
INSERT INTO `erp_user_logins` VALUES ('37', '1', null, 0x3139322E3136382E312E313136, 'owner@cloudnet.com.kh', '2017-06-02 08:05:24');
INSERT INTO `erp_user_logins` VALUES ('38', '1', null, 0x3139322E3136382E312E3135, 'owner@cloudnet.com.kh', '2017-06-02 08:13:56');
INSERT INTO `erp_user_logins` VALUES ('39', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 08:14:56');
INSERT INTO `erp_user_logins` VALUES ('40', '1', null, 0x3139322E3136382E312E313030, 'owner@cloudnet.com.kh', '2017-06-02 08:33:48');
INSERT INTO `erp_user_logins` VALUES ('41', '5', null, 0x3139322E3136382E312E313030, 'salebranch@gmail.com', '2017-06-02 08:34:43');
INSERT INTO `erp_user_logins` VALUES ('42', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 09:23:30');
INSERT INTO `erp_user_logins` VALUES ('43', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 09:30:55');
INSERT INTO `erp_user_logins` VALUES ('44', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 09:31:56');
INSERT INTO `erp_user_logins` VALUES ('45', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 09:32:15');
INSERT INTO `erp_user_logins` VALUES ('46', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 09:34:53');
INSERT INTO `erp_user_logins` VALUES ('47', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 09:36:30');
INSERT INTO `erp_user_logins` VALUES ('48', '1', null, 0x3139322E3136382E312E313134, 'owner@cloudnet.com.kh', '2017-06-02 09:54:49');
INSERT INTO `erp_user_logins` VALUES ('49', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-02 10:40:50');
INSERT INTO `erp_user_logins` VALUES ('50', '1', null, 0x3139322E3136382E312E3239, 'owner@cloudnet.com.kh', '2017-06-02 10:50:30');
INSERT INTO `erp_user_logins` VALUES ('51', '1', null, 0x3139322E3136382E312E3135, 'owner@cloudnet.com.kh', '2017-06-02 10:52:35');
INSERT INTO `erp_user_logins` VALUES ('52', '1', null, 0x3139322E3136382E312E313134, 'owner@cloudnet.com.kh', '2017-06-02 11:09:00');
INSERT INTO `erp_user_logins` VALUES ('53', '1', null, 0x3139322E3136382E312E3135, 'owner@cloudnet.com.kh', '2017-06-02 11:30:45');
INSERT INTO `erp_user_logins` VALUES ('54', '1', null, 0x3139322E3136382E312E313134, 'owner@cloudnet.com.kh', '2017-06-02 11:47:12');
INSERT INTO `erp_user_logins` VALUES ('55', '1', null, 0x3139322E3136382E312E3135, 'owner@cloudnet.com.kh', '2017-06-02 13:13:20');
INSERT INTO `erp_user_logins` VALUES ('56', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 13:13:46');
INSERT INTO `erp_user_logins` VALUES ('57', '1', null, 0x3139322E3136382E312E313134, 'owner@cloudnet.com.kh', '2017-06-02 13:22:43');
INSERT INTO `erp_user_logins` VALUES ('58', '1', null, 0x3139322E3136382E312E32, 'owner@cloudnet.com.kh', '2017-06-02 13:31:19');
INSERT INTO `erp_user_logins` VALUES ('59', '1', null, 0x3139322E3136382E312E3239, 'owner@cloudnet.com.kh', '2017-06-02 13:36:24');
INSERT INTO `erp_user_logins` VALUES ('60', '1', null, 0x3139322E3136382E312E3134, 'owner@cloudnet.com.kh', '2017-06-02 13:48:23');
INSERT INTO `erp_user_logins` VALUES ('61', '1', null, 0x3139322E3136382E312E313035, 'owner@cloudnet.com.kh', '2017-06-02 14:05:20');
INSERT INTO `erp_user_logins` VALUES ('62', '1', null, 0x3139322E3136382E312E3135, 'owner@cloudnet.com.kh', '2017-06-02 14:18:17');
INSERT INTO `erp_user_logins` VALUES ('63', '1', null, 0x3139322E3136382E312E313134, 'owner@cloudnet.com.kh', '2017-06-02 14:26:18');
INSERT INTO `erp_user_logins` VALUES ('64', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 14:35:54');
INSERT INTO `erp_user_logins` VALUES ('65', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 14:37:01');
INSERT INTO `erp_user_logins` VALUES ('66', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 14:54:38');
INSERT INTO `erp_user_logins` VALUES ('67', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 15:38:45');
INSERT INTO `erp_user_logins` VALUES ('68', '1', null, 0x3139322E3136382E312E3533, 'owner@cloudnet.com.kh', '2017-06-02 15:40:31');
INSERT INTO `erp_user_logins` VALUES ('69', '1', null, 0x3139322E3136382E312E313134, 'owner@cloudnet.com.kh', '2017-06-02 15:56:39');
INSERT INTO `erp_user_logins` VALUES ('70', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-02 17:05:33');
INSERT INTO `erp_user_logins` VALUES ('71', '1', null, 0x3139322E3136382E312E313130, 'owner@cloudnet.com.kh', '2017-06-03 07:41:45');
INSERT INTO `erp_user_logins` VALUES ('72', '1', null, 0x3139322E3136382E312E3135, 'owner@cloudnet.com.kh', '2017-06-03 07:58:59');
INSERT INTO `erp_user_logins` VALUES ('73', '3', null, 0x3139322E3136382E312E3135, 'saleoffice@gmail.com', '2017-06-03 08:02:07');
INSERT INTO `erp_user_logins` VALUES ('74', '1', null, 0x3139322E3136382E312E3533, 'owner@cloudnet.com.kh', '2017-06-03 08:12:09');
INSERT INTO `erp_user_logins` VALUES ('75', '1', null, 0x3139322E3136382E312E3239, 'owner@cloudnet.com.kh', '2017-06-03 08:19:52');
INSERT INTO `erp_user_logins` VALUES ('76', '1', null, 0x3139322E3136382E312E313134, 'owner@cloudnet.com.kh', '2017-06-03 08:48:53');
INSERT INTO `erp_user_logins` VALUES ('77', '1', null, 0x3139322E3136382E312E3135, 'owner@cloudnet.com.kh', '2017-06-03 08:50:50');
INSERT INTO `erp_user_logins` VALUES ('78', '1', null, 0x3139322E3136382E312E313030, 'owner@cloudnet.com.kh', '2017-06-03 09:46:38');
INSERT INTO `erp_user_logins` VALUES ('79', '1', null, 0x3139322E3136382E312E313239, 'owner@cloudnet.com.kh', '2017-06-03 10:16:51');
INSERT INTO `erp_user_logins` VALUES ('80', '6', null, 0x3139322E3136382E312E313239, 'jamekakada@gmail.com', '2017-06-03 10:28:54');
INSERT INTO `erp_user_logins` VALUES ('81', '1', null, 0x3139322E3136382E312E313239, 'owner@cloudnet.com.kh', '2017-06-03 10:30:53');
INSERT INTO `erp_user_logins` VALUES ('82', '1', null, 0x3139322E3136382E312E313135, 'owner@cloudnet.com.kh', '2017-06-03 11:44:33');
INSERT INTO `erp_user_logins` VALUES ('83', '1', null, 0x3139322E3136382E312E313032, 'owner@cloudnet.com.kh', '2017-06-03 12:00:06');

-- ----------------------------
-- Table structure for erp_variants
-- ----------------------------
DROP TABLE IF EXISTS `erp_variants`;
CREATE TABLE `erp_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_variants
-- ----------------------------
INSERT INTO `erp_variants` VALUES ('1', 'Unit');

-- ----------------------------
-- Table structure for erp_warehouses
-- ----------------------------
DROP TABLE IF EXISTS `erp_warehouses`;
CREATE TABLE `erp_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `map` varchar(255) DEFAULT NULL,
  `phone` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_warehouses
-- ----------------------------
INSERT INTO `erp_warehouses` VALUES ('1', 'pp', 'Phnom Penh', 'Phnom Penh', null, '012345678', 'test_pp@gmail.com');
INSERT INTO `erp_warehouses` VALUES ('2', 'HO-01', 'Head Office', '<p>Phnom Penh, Cambodia</p>', null, '', '');
INSERT INTO `erp_warehouses` VALUES ('3', '271', '271', '<p>Phnom Penh, Cambodia</p>', null, '', '');
INSERT INTO `erp_warehouses` VALUES ('4', 'TK01', 'Takmao', '<p>Takmao</p>', null, '', '');

-- ----------------------------
-- Table structure for erp_warehouses_products
-- ----------------------------
DROP TABLE IF EXISTS `erp_warehouses_products`;
CREATE TABLE `erp_warehouses_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `rack` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_warehouses_products
-- ----------------------------
INSERT INTO `erp_warehouses_products` VALUES ('1', '4', '1', '4.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('2', '6', '1', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('3', '2', '1', '-5.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('4', '3', '1', '10.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('5', '2', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('6', '2', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('7', '2', '4', '20.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('8', '4', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('9', '4', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('10', '4', '4', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('11', '5', '2', '48.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('12', '5', '4', '50.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('13', '5', '1', '-5.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('14', '5', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('15', '1', '1', '-13.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('16', '1', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('17', '1', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('18', '1', '4', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('19', '6', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('20', '6', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('21', '6', '4', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('22', '3', '4', '20.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('23', '7', '1', '10.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('24', '0', '1', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('25', '0', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('26', '0', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('27', '0', '4', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('28', '3', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('29', '3', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('30', '8', '1', '10.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('31', '11', '1', '10.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('32', '12', '1', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('33', '12', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('34', '12', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('35', '12', '4', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('36', '9', '1', '16.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('37', '10', '1', '22.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('38', '9', '2', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('39', '9', '3', '0.0000', null);
INSERT INTO `erp_warehouses_products` VALUES ('40', '9', '4', '0.0000', null);

-- ----------------------------
-- Table structure for erp_warehouses_products_variants
-- ----------------------------
DROP TABLE IF EXISTS `erp_warehouses_products_variants`;
CREATE TABLE `erp_warehouses_products_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `rack` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`),
  KEY `product_id` (`product_id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_warehouses_products_variants
-- ----------------------------
DROP TRIGGER IF EXISTS `gl_trans_adjustment_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_adjustment_insert` AFTER INSERT ON `erp_adjustments` FOR EACH ROW BEGIN

DECLARE v_tran_no INTEGER;
DECLARE v_default_stock_adjust INTEGER;
DECLARE v_default_stock INTEGER;


SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);

UPDATE erp_order_ref
SET tr = v_tran_no
WHERE
DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');

SET v_default_stock_adjust = (SELECT default_stock_adjust FROM erp_account_settings);
SET v_default_stock = (SELECT default_stock FROM erp_account_settings);


/* ==== Addition =====*/

	IF NEW.type = 'addition' THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)* abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock_adjust
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock_adjust;


	ELSE

  		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)*abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock;


		INSERT INTO erp_gl_trans (

			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock_adjust
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock_adjust;
	END IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_adjustment_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_adjustment_update` AFTER UPDATE ON `erp_adjustments` FOR EACH ROW BEGIN

DECLARE v_tran_no INTEGER;
DECLARE v_default_stock_adjust INTEGER;
DECLARE v_default_stock INTEGER;

SET v_tran_no = (SELECT tran_no FROM erp_gl_trans WHERE tran_type='STOCK_ADJUST' AND reference_no = NEW.id LIMIT 0,1); 

DELETE FROM erp_gl_trans WHERE tran_type='STOCK_ADJUST' AND reference_no = NEW.id;

SET v_default_stock_adjust = (SELECT default_stock_adjust FROM erp_account_settings);
SET v_default_stock = (SELECT default_stock FROM erp_account_settings);


/* ==== Addition =====*/

	IF NEW.type = 'addition' THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)* abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock_adjust
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock_adjust;

	ELSE

  		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)*abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			)
			SELECT
			'STOCK_ADJUST',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.total_cost),
			NEW.id,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_stock_adjust
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_stock_adjust;
	END IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_adjustment_delete`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_adjustment_delete` AFTER DELETE ON `erp_adjustments` FOR EACH ROW BEGIN

   UPDATE erp_gl_trans SET amount = 0, description = CONCAT(description,' (Cancelled)')
   WHERE tran_type='STOCK_ADJUST' AND reference_no = OLD.id;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_deliveries_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_deliveries_insert` AFTER INSERT ON `erp_deliveries` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
	IF NEW.delivery_status = "completed" THEN

		SET v_tran_no = (
			SELECT
				COALESCE (MAX(tran_no), 0) + 1
			FROM
				erp_gl_trans
		);
		UPDATE erp_order_ref
		SET tr = v_tran_no
		WHERE
			DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
		
		IF v_acc_cate_separate <> 1 THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,

				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
			) SELECT
				'DELIVERY',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				NEW.total_cost,
				NEW.do_reference_no,
				NEW.customer,
				NEW.biller_id,
				NEW.created_by,
				NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
			INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_cost;


			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
			) SELECT
				'DELIVERY',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(- 1) * abs(NEW.total_cost),
				NEW.do_reference_no,
				NEW.customer,
				NEW.biller_id,
				NEW.created_by,
				NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
			INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_stock;	
		END IF;
		
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_deliveries_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_deliveries_update` AFTER UPDATE ON `erp_deliveries` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
	
	IF NEW.updated_count <> OLD.updated_count AND NEW.updated_by > 0 THEN
	
		DELETE FROM erp_gl_trans WHERE erp_gl_trans.tran_type = 'DELIVERY' AND erp_gl_trans.reference_no = NEW.do_reference_no;
		
		IF NEW.delivery_status = "completed" THEN
			SET v_tran_no = (
				SELECT
					COALESCE (MAX(tran_no), 0) + 1
				FROM
					erp_gl_trans
			);
			UPDATE erp_order_ref
			SET tr = v_tran_no
			WHERE
				DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
			
			IF v_acc_cate_separate <> 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'DELIVERY',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.total_cost,
					NEW.do_reference_no,
					NEW.customer,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_cost;


				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'DELIVERY',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(- 1) * abs(NEW.total_cost),
					NEW.do_reference_no,
					NEW.customer,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_stock;	
			END IF;
		END IF;
	END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_delivery_items_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_delivery_items_insert` AFTER INSERT ON `erp_delivery_items` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_reference_no VARCHAR(50);
	DECLARE v_cost DECIMAL(4);
	DECLARE v_customer VARCHAR(55);
	DECLARE v_biller_id INTEGER;
	DECLARE v_created_by INTEGER;
	DECLARE v_updated_by INTEGER;
	DECLARE v_category_id INTEGER;
	DECLARE v_delivery_status VARCHAR(50);
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
	SET v_delivery_status = (SELECT erp_deliveries.delivery_status FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
	
	IF v_delivery_status = "completed" THEN
		SET v_tran_date = (
					SELECT
						erp_deliveries.date
					FROM
						erp_deliveries
					WHERE
						erp_deliveries.id = NEW.delivery_id
					LIMIT 1
				);
				
		SET v_reference_no = (SELECT erp_deliveries.do_reference_no FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
		SET v_tran_no = (SELECT erp_gl_trans.tran_no FROM erp_gl_trans WHERE erp_gl_trans.tran_type = "DELIVERY" AND reference_no = v_reference_no LIMIT 1);
		IF ISNULL(v_tran_no) THEN
			SET v_tran_no = (
				SELECT
					COALESCE (MAX(tran_no), 0) + 1
				FROM
					erp_gl_trans
			);
			UPDATE erp_order_ref
			SET tr = v_tran_no
			WHERE
				DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
		END IF;
		SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
		SET v_customer = (SELECT erp_deliveries.customer FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
		SET v_biller_id = (SELECT erp_deliveries.biller_id FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
		SET v_created_by = (SELECT erp_deliveries.created_by FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
		SET v_updated_by = (SELECT erp_deliveries.updated_by FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
		SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
		
		IF v_acc_cate_separate = 1 THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
			) SELECT
				'DELIVERY',
				v_tran_no,
				v_tran_date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(v_cost * NEW.quantity_received),
				v_reference_no,
				v_customer,
				v_biller_id,
				v_created_by,
				v_updated_by
			FROM
				erp_categories
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_cost
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_categories.id = v_category_id;


			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
			) SELECT
				'DELIVERY',
				v_tran_no,
				v_tran_date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(- 1) * abs(v_cost * NEW.quantity_received),
				v_reference_no,
				v_customer,
				v_biller_id,
				v_created_by,
				v_updated_by
			FROM
				erp_categories
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_stock
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_categories.id = v_category_id;
		END IF;
		
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_delivery_items_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_delivery_items_update` AFTER UPDATE ON `erp_delivery_items` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_reference_no VARCHAR(50);
	DECLARE v_cost DECIMAL(4);
	DECLARE v_customer VARCHAR(55);
	DECLARE v_biller_id INTEGER;
	DECLARE v_category_id INTEGER;
	DECLARE v_delivery_status VARCHAR(50);
	
	IF NEW.updated_count <> OLD.updated_count AND NEW.updated_by > 0 THEN
		
		SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
		SET v_delivery_status = (SELECT erp_deliveries.delivery_status FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
		
		IF v_delivery_status = "completed" THEN
			SET v_tran_date = (
						SELECT
							erp_deliveries.date
						FROM
							erp_deliveries
						WHERE
							erp_deliveries.id = NEW.delivery_id
						LIMIT 1
					);
					
			SET v_reference_no = (SELECT erp_deliveries.do_reference_no FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
			SET v_tran_no = (SELECT erp_gl_trans.tran_no FROM erp_gl_trans WHERE erp_gl_trans.tran_type = "DELIVERY" AND reference_no = v_reference_no LIMIT 1);
			IF ISNULL(v_tran_no) THEN
				SET v_tran_no = (
					SELECT
						COALESCE (MAX(tran_no), 0) + 1
					FROM
						erp_gl_trans
				);
				UPDATE erp_order_ref
				SET tr = v_tran_no
				WHERE
					DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
			END IF;
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_customer = (SELECT erp_deliveries.customer FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
			SET v_biller_id = (SELECT erp_deliveries.biller_id FROM erp_deliveries WHERE erp_deliveries.id = NEW.delivery_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			IF v_acc_cate_separate = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'DELIVERY',
					v_tran_no,
					v_tran_date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(v_cost * NEW.quantity_received),
					v_reference_no,
					v_customer,
					v_biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_categories
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_cost
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_category_id;

				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'DELIVERY',
					v_tran_no,
					v_tran_date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(- 1) * abs(v_cost * NEW.quantity_received),
					v_reference_no,
					v_customer,
					v_biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_categories
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_stock
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_category_id;
			END IF;
		END IF;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_salary_tax_small_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_salary_tax_small_insert` AFTER INSERT ON `erp_employee_salary_tax_small_taxpayers_trigger` FOR EACH ROW BEGIN
DECLARE
	v_tran_no INTEGER;
DECLARE
	v_default_payroll INTEGER;
DECLARE
	v_default_salary_tax_payable INTEGER;
DECLARE
	v_default_salary_expense INTEGER;
DECLARE
	v_default_tax_duties_expense INTEGER;
DECLARE
	v_bank_code INTEGER;
DECLARE
	v_account_code INTEGER;
DECLARE
	v_tran_date DATETIME;
DECLARE
	v_biller_id INTEGER;
DECLARE v_date DATE;

SET v_biller_id = (
                   SELECT default_biller FROM erp_settings
);


IF v_tran_date = DATE_FORMAT(NEW.year_month, '%Y-%m') THEN

SET v_tran_no = (
	SELECT
		MAX(tran_no)
	FROM
		erp_gl_trans
);

ELSE

SET v_tran_no = (
	SELECT
		COALESCE (MAX(tran_no), 0) + 1
	FROM
		erp_gl_trans
);


UPDATE erp_order_ref
SET tr = v_tran_no
WHERE
	DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
END
IF;

SET v_default_payroll = (
	SELECT
		default_payroll
	FROM
		erp_account_settings
);

SET v_default_salary_tax_payable = (
	SELECT
		default_salary_tax_payable
	FROM
		erp_account_settings
);
SET v_default_tax_duties_expense = (
	SELECT
		default_tax_duties_expense
	FROM
		erp_account_settings
);
SET v_default_salary_expense = (
	SELECT
		default_salary_expense
	FROM
		erp_account_settings
);


/* ==== Employee Salary Tax =====*/
IF NEW.isCompany = 0 THEN
	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
		DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * abs(NEW.total_salary_usd),
		NEW.reference_no,
        'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	(- 1) * abs(NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_tax_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_tax_duties_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_tax_duties_expense ;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense;

ELSE

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),

	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense ;

	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
		DATE_FORMAT(CONCAT(NEW.year_month,'-', DAY(CURRENT_DATE())), '%Y-%m-%d'),
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * (NEW.total_salary_usd - NEW.total_salary_tax_usd),
		NEW.reference_no,
        'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	(- 1) * (NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;

END
IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_salary_tax_small_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_salary_tax_small_update` AFTER UPDATE ON `erp_employee_salary_tax_small_taxpayers_trigger` FOR EACH ROW BEGIN
DECLARE
	v_tran_no INTEGER;
DECLARE
	v_default_payroll INTEGER;
DECLARE
	v_default_salary_tax_payable INTEGER;
DECLARE
	v_default_salary_expense INTEGER;
DECLARE
	v_default_tax_duties_expense INTEGER;
DECLARE
	v_bank_code INTEGER;
DECLARE
	v_account_code INTEGER;
DECLARE
	v_tran_date DATETIME;
DECLARE
	v_biller_id INTEGER;

SET v_tran_no = (SELECT tran_no FROM erp_gl_trans WHERE tran_type='SALARY TAX' AND reference_no = NEW.reference_no LIMIT 0,1); 

DELETE FROM erp_gl_trans WHERE tran_type='SALARY TAX' AND reference_no = NEW.reference_no;

SET v_biller_id = (
                   SELECT default_biller FROM erp_settings
);

SET v_default_payroll = (
	SELECT
		default_payroll
	FROM
		erp_account_settings
);

SET v_default_salary_tax_payable = (
	SELECT
		default_salary_tax_payable
	FROM
		erp_account_settings
);
SET v_default_tax_duties_expense = (
	SELECT
		default_tax_duties_expense
	FROM
		erp_account_settings
);
SET v_default_salary_expense = (
	SELECT
		default_salary_expense
	FROM
		erp_account_settings
);

/* ==== Employee Salary Tax =====*/
IF NEW.isCompany = 0 THEN
	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
		DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * abs(NEW.total_salary_usd),
		NEW.reference_no,
        'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	(- 1) * abs(NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_tax_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_tax_duties_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_tax_duties_expense ;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense ;


ELSE

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,

	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense ;

	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
		DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * (NEW.total_salary_usd - NEW.total_salary_tax_usd),
		NEW.reference_no,
                                     'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	DATE_FORMAT(CONCAT(NEW.year_month,'-', DAy(CURRENT_DATE())), '%Y-%m-%d'),
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	(- 1) * (NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;

END
IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_salary_tax_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_salary_tax_insert` AFTER INSERT ON `erp_employee_salary_tax_trigger` FOR EACH ROW BEGIN
DECLARE
	v_tran_no INTEGER;
DECLARE
	v_default_fringe_benefit_tax INTEGER;	
DECLARE
	v_default_payroll INTEGER;
DECLARE
	v_default_salary_tax_payable INTEGER;
DECLARE
	v_default_salary_expense INTEGER;
DECLARE
	v_default_tax_duties_expense INTEGER;
DECLARE
	v_bank_code INTEGER;
DECLARE
	v_account_code INTEGER;
DECLARE
	v_tran_date DATETIME;
DECLARE
	v_biller_id INTEGER;
DECLARE v_date DATE;

SET v_biller_id = (
                   SELECT default_biller FROM erp_settings
);


IF v_tran_date = DATE_FORMAT(NEW.year_month, '%Y-%m') THEN

SET v_tran_no = (
	SELECT
		MAX(tran_no)
	FROM
		erp_gl_trans
);

ELSE

SET v_tran_no = (
	SELECT
		COALESCE (MAX(tran_no), 0) + 1
	FROM
		erp_gl_trans

);


UPDATE erp_order_ref
SET tr = v_tran_no
WHERE
	DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
END
IF;

SET v_default_payroll = (
	SELECT
		default_payroll
	FROM
		erp_account_settings
);
SET v_default_fringe_benefit_tax = (
	SELECT
		default_fringe_benefit_tax
	FROM
		erp_account_settings
);
SET v_default_salary_tax_payable = (
	SELECT
		default_salary_tax_payable
	FROM
		erp_account_settings
);
SET v_default_tax_duties_expense = (
	SELECT
		default_tax_duties_expense
	FROM
		erp_account_settings
);
SET v_default_salary_expense = (
	SELECT
		default_salary_expense
	FROM
		erp_account_settings
);


/* ==== Employee Salary Tax =====*/
/* ==== Tab 1 =====*/

IF NEW.tab = 1 OR NEW.tab=2 THEN

IF NEW.isCompany = 0 THEN
	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
        NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * abs(NEW.total_salary_usd),
		NEW.reference_no,
        'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	(- 1) * abs(NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_tax_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_tax_duties_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_tax_duties_expense ;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense ;


ELSE

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense ;

	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * (NEW.total_salary_usd - NEW.total_salary_tax_usd),
		NEW.reference_no,
		'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	 (- 1) * (NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;

END IF;
END IF;
/* ==== END Tab 1 =====*/
IF NEW.tab =3 THEN

INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'Fringe Benefit',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		 abs(NEW.total_allowance_tax*0.2),
		NEW.reference_no_j,
		'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_tax_duties_expense 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_tax_duties_expense;



INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,

		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'Fringe Benefit',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * abs(NEW.total_allowance_tax*0.2),
		NEW.reference_no_j,
		'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_fringe_benefit_tax 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_fringe_benefit_tax;

END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_salary_tax_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_salary_tax_update` AFTER UPDATE ON `erp_employee_salary_tax_trigger` FOR EACH ROW BEGIN
DECLARE
	v_tran_no INTEGER;
DECLARE
	v_default_fringe_benefit_tax INTEGER;
DECLARE
	v_default_payroll INTEGER;
DECLARE
	v_default_salary_tax_payable INTEGER;
DECLARE
	v_default_salary_expense INTEGER;
DECLARE
	v_default_tax_duties_expense INTEGER;
DECLARE
	v_bank_code INTEGER;
DECLARE
	v_account_code INTEGER;
DECLARE
	v_tran_date DATETIME;
DECLARE
	v_biller_id INTEGER;
DECLARE
	v_tran_no_b INTEGER;

SET v_tran_no = (SELECT tran_no FROM erp_gl_trans WHERE tran_type='SALARY TAX' AND reference_no = NEW.reference_no LIMIT 0,1); 
SET v_tran_no_b = (SELECT tran_no FROM erp_gl_trans WHERE tran_type='Fringe Benefit' AND reference_no = NEW.reference_no_j LIMIT 0,1); 


DELETE FROM erp_gl_trans WHERE tran_type='SALARY TAX' AND reference_no = NEW.reference_no;

SET v_biller_id = (
                   SELECT default_biller FROM erp_settings
);


SET v_default_payroll = (
	SELECT
		default_payroll
	FROM
		erp_account_settings
);
SET v_default_fringe_benefit_tax = (
	SELECT
		default_fringe_benefit_tax
	FROM
		erp_account_settings
);
SET v_default_salary_tax_payable = (
	SELECT
		default_salary_tax_payable
	FROM
		erp_account_settings
);
SET v_default_tax_duties_expense = (
	SELECT
		default_tax_duties_expense
	FROM
		erp_account_settings
);
SET v_default_salary_expense = (
	SELECT
		default_salary_expense
	FROM
		erp_account_settings
);

/* ==== Employee Salary Tax =====*/
/* ==== Tab 1 =====*/

IF NEW.tab = 1 OR NEW.tab=2 THEN

IF NEW.isCompany = 0 THEN
	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * abs(NEW.total_salary_usd),
		NEW.reference_no,
		'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	(- 1) * abs(NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_tax_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_tax_duties_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_tax_duties_expense ;


INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense ;


ELSE

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,
	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	NEW.total_salary_usd,
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_expense
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_expense ;

	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'SALARY TAX',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * (NEW.total_salary_usd - NEW.total_salary_tax_usd),
		NEW.reference_no,
		'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_payroll 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_payroll;

INSERT INTO erp_gl_trans (
	tran_type,
	tran_no,
	tran_date,
	sectionid,
	account_code,
	narrative,
	amount,
	reference_no,
	description,

	biller_id,
	created_by,
	bank,
	updated_by
) SELECT
	'SALARY TAX',
	v_tran_no,
	NEW.date,
	erp_gl_sections.sectionid,
	erp_gl_charts.accountcode,
	erp_gl_charts.accountname,
	 (- 1) * (NEW.total_salary_tax_usd),
	NEW.reference_no,
	'Employee Salary Tax',
	v_biller_id,
	NEW.created_by,
	'1',
	NEW.updated_by
FROM
	erp_account_settings
INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_salary_tax_payable
INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
WHERE
	erp_gl_charts.accountcode =v_default_salary_tax_payable;

END IF;
END IF;
/* ==== END Tab 1 =====*/
IF NEW.tab =3 THEN

DELETE FROM erp_gl_trans WHERE tran_type='Fringe Benefit' AND reference_no = NEW.reference_no_j;


INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'Fringe Benefit',
		v_tran_no_b,
                                     NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		 abs(NEW.total_allowance_tax*0.2),
		NEW.reference_no_j,
                                     'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_tax_duties_expense 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_tax_duties_expense;



INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		bank,
		updated_by
	) SELECT
		'Fringe Benefit',
		v_tran_no_b,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		(- 1) * abs(NEW.total_allowance_tax*0.2),
		NEW.reference_no_j,
		'Employee Salary Tax',
		v_biller_id,
		NEW.created_by,
		'1',
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_fringe_benefit_tax 
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode =v_default_fringe_benefit_tax;

END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_enter_using_stock_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_enter_using_stock_insert` AFTER INSERT ON `erp_enter_using_stock` FOR EACH ROW BEGIN

	DECLARE e_tran_type VARCHAR (50);
	DECLARE e_tran_date DATETIME;
	DECLARE e_account_code INTEGER;
	DECLARE e_narrative VARCHAR (255);
	DECLARE v_tran_no INTEGER;
	DECLARE inv_account_code INTEGER;
	DECLARE inv_narrative VARCHAR (255);
	DECLARE cost_variant_account_code INTEGER;
	DECLARE cost_variant_narrative VARCHAR (255);
	DECLARE v_acc_cate_separate INTEGER;

	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
	SET v_tran_no = (
		SELECT
			COALESCE (MAX(tran_no), 0) + 1
		FROM
			erp_gl_trans
	);

	UPDATE erp_order_ref SET tr = v_tran_no WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');

	SET e_narrative = (
		SELECT
			erp_gl_charts.accountname
		FROM
			erp_gl_charts
		WHERE
			erp_gl_charts.accountcode = NEW.account
	);

	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by
	)
	SELECT
		'USING STOCK',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		NEW.total_cost,
		NEW.reference_no,
		NEW.note,
		NEW.shop,
		NEW.create_by
		FROM
			erp_account_settings
			INNER JOIN erp_gl_charts
			ON erp_gl_charts.accountcode = NEW.account
			INNER JOIN erp_gl_sections
			ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
		WHERE
			erp_gl_charts.accountcode = NEW.account;

	SET inv_account_code = (
		SELECT
			erp_account_settings.default_stock
		FROM
			erp_account_settings
	);
	SET inv_narrative = (
		SELECT
			erp_gl_charts.accountname
		FROM
			erp_gl_charts
		WHERE
			erp_gl_charts.accountcode = inv_account_code 
	);

	SET cost_variant_account_code = (
		SELECT
			erp_account_settings.default_cost_variant
		FROM
			erp_account_settings
	);
	SET cost_variant_narrative = (
		SELECT
			erp_gl_charts.accountname
		FROM
			erp_gl_charts
		WHERE
			erp_gl_charts.accountcode = cost_variant_account_code 
	);

	IF v_acc_cate_separate <> 1 THEN
		IF NEW.type = 'use' THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by
			)
			SELECT
				'USING STOCK',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(- 1) * abs(NEW.total_cost),
				NEW.reference_no,
				NEW.note,
				NEW.shop,
				NEW.create_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_stock
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_stock;
		END IF;
	END IF;

	IF NEW.type = 'return' THEN
		IF NEW.total_cost <> NEW.total_using_cost THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by
			)
			SELECT
				'USING STOCK',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(NEW.total_using_cost)-(NEW.total_cost),
				NEW.reference_no,
				NEW.note,
				NEW.shop,
				NEW.create_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_cost_variant
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_cost_variant;
		END IF;
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by
		)
		SELECT
				'USING STOCK',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(- 1) * abs(NEW.total_using_cost),
				NEW.reference_no,
				NEW.note,
				NEW.shop,
				NEW.create_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_stock
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_stock;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_enter_using_stock_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_enter_using_stock_update` AFTER UPDATE ON `erp_enter_using_stock` FOR EACH ROW BEGIN

	DECLARE e_tran_type VARCHAR (50);
	DECLARE e_tran_date DATETIME;
	DECLARE e_account_code INTEGER;
	DECLARE e_narrative VARCHAR (255);
	DECLARE v_tran_no INTEGER;
	DECLARE inv_account_code INTEGER;
	DECLARE inv_narrative VARCHAR (255);
	DECLARE cost_variant_account_code INTEGER;
	DECLARE cost_variant_narrative VARCHAR (255);
	DECLARE inv_created_by VARCHAR (255);
	
	SET  inv_created_by = (SELECT created_by from erp_gl_trans where reference_no = NEW.reference_no LIMIT 1);
	SET v_tran_no = (SELECT COALESCE (MAX(tran_no), 0) + 1 FROM erp_gl_trans);

	UPDATE erp_order_ref SET tr = v_tran_no WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');

	SET e_narrative = (
		SELECT
			erp_gl_charts.accountname
		FROM
			erp_gl_charts
		WHERE
			erp_gl_charts.accountcode = NEW.account
	);

	DELETE FROM erp_gl_trans WHERE tran_type='USING STOCK' AND bank=0 AND reference_no = NEW.reference_no;

	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		updated_by
	)
	SELECT
		'USING STOCK',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		NEW.total_cost,
		NEW.reference_no,
		NEW.note,
		NEW.shop,
		inv_created_by,
		NEW.create_by
		FROM
			erp_account_settings
			INNER JOIN erp_gl_charts
			ON erp_gl_charts.accountcode = NEW.account
			INNER JOIN erp_gl_sections
			ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
		WHERE
			erp_gl_charts.accountcode = NEW.account;

	SET inv_account_code = (
		SELECT
			erp_account_settings.default_stock
		FROM
			erp_account_settings
	);
	SET inv_narrative = (
		SELECT
			erp_gl_charts.accountname
		FROM
			erp_gl_charts
		WHERE
			erp_gl_charts.accountcode = inv_account_code 
	);
	SET cost_variant_account_code = (
		SELECT
			erp_account_settings.default_cost_variant
		FROM
			erp_account_settings
	);
	SET cost_variant_narrative = (
		SELECT
			erp_gl_charts.accountname
		FROM
			erp_gl_charts
		WHERE
			erp_gl_charts.accountcode = cost_variant_account_code 
	);

	IF NEW.type = 'use' THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by
		)
		SELECT
			'USING STOCK',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.total_cost),
			NEW.reference_no,
			NEW.note,
			NEW.shop,
			NEW.create_by
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = erp_account_settings.default_stock
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_stock;
	END IF;

	IF NEW.type = 'return' THEN
		IF NEW.total_cost <> NEW.total_using_cost THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by
			)
			SELECT
				'USING STOCK',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(NEW.total_using_cost)-(NEW.total_cost),
				NEW.reference_no,
				NEW.note,
				NEW.shop,
				NEW.create_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_cost_variant
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_cost_variant;
		END IF;
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by
		)
		SELECT
				'USING STOCK',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(- 1) * abs(NEW.total_using_cost),
				NEW.reference_no,
				NEW.note,
				NEW.shop,
				NEW.create_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_stock
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_stock;
	END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_enter_using_stock_items_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_enter_using_stock_items_insert` AFTER INSERT ON `erp_enter_using_stock_items` FOR EACH ROW BEGIN

	DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_tran_no INTEGER;
	DECLARE v_cate_id INTEGER;
	DECLARE v_type VARCHAR(50);
	DECLARE v_date DATETIME;
	DECLARE v_note VARCHAR(255);
	DECLARE v_shop VARCHAR(50);
	DECLARE v_created_by VARCHAR(50);

	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
	
	IF v_acc_cate_separate = 1 THEN
		SET v_tran_no = (
			SELECT
				erp_gl_trans.tran_no
			FROM
				erp_gl_trans
			WHERE
				erp_gl_trans.reference_no = NEW.reference_no LIMIT 1
		);
		SET v_type = (SELECT
				erp_enter_using_stock.type
			FROM
				erp_enter_using_stock
			WHERE
				erp_enter_using_stock.reference_no = NEW.reference_no LIMIT 1
		);
		SET v_date = (SELECT
				erp_enter_using_stock.date
			FROM
				erp_enter_using_stock
			WHERE
				erp_enter_using_stock.reference_no = NEW.reference_no LIMIT 1
		);
		SET v_note = (SELECT
				erp_enter_using_stock.note
			FROM
				erp_enter_using_stock
			WHERE
				erp_enter_using_stock.reference_no = NEW.reference_no LIMIT 1
		);
		SET v_shop = (SELECT
				erp_enter_using_stock.shop
			FROM
				erp_enter_using_stock
			WHERE
				erp_enter_using_stock.reference_no = NEW.reference_no LIMIT 1
		);
		SET v_created_by = (SELECT
				erp_enter_using_stock.create_by
			FROM
				erp_enter_using_stock
			WHERE
				erp_enter_using_stock.reference_no = NEW.reference_no LIMIT 1
		);
		SET v_cate_id = (SELECT
				erp_products.category_id
			FROM
				erp_products
			WHERE
				erp_products.code = NEW.code LIMIT 1
		);
		
		IF v_type = 'use' THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by
			)
			SELECT
				'USING STOCK',
				v_tran_no,
				v_date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(- 1) * ((SELECT erp_products.cost FROM erp_products WHERE erp_products.code = NEW.code)*NEW.qty_use),
				NEW.reference_no,
				v_note,
				v_shop,
				v_created_by
				FROM
					erp_categories
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_categories.ac_stock
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_cate_id;

		END IF;
	END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_expenses_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_expenses_insert` AFTER INSERT ON `erp_expenses` FOR EACH ROW BEGIN

DECLARE v_tran_no INTEGER;
DECLARE v_tran_date DATETIME;


IF NEW.created_by THEN

	SET v_tran_date = (SELECT erp_expenses.date 
		FROM erp_payments 
		INNER JOIN erp_expenses ON erp_expenses.id = erp_payments.expense_id
		WHERE erp_expenses.id = NEW.id LIMIT 0,1);

	IF v_tran_date = NEW.date THEN
		SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
	ELSE
		SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);
	
		UPDATE erp_order_ref
		SET tr = v_tran_no
		WHERE
		DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
	END IF;



	INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'JOURNAL',
			v_tran_no,
			NEW.date,
			erp_gl_charts.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			NEW.amount,
			NEW.reference,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_gl_charts
			WHERE
				erp_gl_charts.accountcode = NEW.account_code;

	INSERT INTO erp_gl_trans (
			tran_type,

			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'JOURNAL',
			v_tran_no,
			NEW.date,
			erp_gl_charts.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)*NEW.amount,
			NEW.reference,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_gl_charts
			WHERE
				erp_gl_charts.accountcode = NEW.bank_code;
	

END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_expenses_update`;
DELIMITER ;;
CREATE TRIGGER `audit_expenses_update` BEFORE UPDATE ON `erp_expenses` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_expenses_audit (
			id,
			date,
			reference,
			amount,
			note,
			created_by,
			attachment,
			account_code,
			bank_code,
			biller_id,
			updated_by,
			updated_at,
			tax,
			status,
			warehouse_id,
			audit_type
		) SELECT 
			id,
			date,
			reference,
			amount,
			note,
			created_by,
			attachment,
			account_code,
			bank_code,
			biller_id,
			updated_by,
			updated_at,
			tax,
			status,
			warehouse_id,
			"UPDATED"
		FROM
			erp_expenses
		WHERE
			erp_expenses.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_expenses_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_expenses_update` AFTER UPDATE ON `erp_expenses` FOR EACH ROW BEGIN

DECLARE v_tran_no INTEGER;


	SET v_tran_no = (SELECT tran_no FROM erp_gl_trans WHERE reference_no = NEW.reference LIMIT 0,1);
	IF v_tran_no < 1  THEN
		SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);
	                
		UPDATE erp_order_ref SET tr = v_tran_no WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
	ELSE
	                SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
	END IF;

IF NEW.updated_by THEN

   	
	DELETE FROM erp_gl_trans WHERE reference_no = NEW.reference;
	
	INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,

			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'JOURNAL',
			v_tran_no,
			NEW.date,
			erp_gl_charts.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			NEW.amount,
			NEW.reference,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_gl_charts
			WHERE
				erp_gl_charts.accountcode = NEW.account_code;

	INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'JOURNAL',
			v_tran_no,
			NEW.date,
			erp_gl_charts.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)*NEW.amount,
			NEW.reference,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_gl_charts
			WHERE
				erp_gl_charts.accountcode = NEW.bank_code;
		

END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_expenses_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_expenses_delete` BEFORE DELETE ON `erp_expenses` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_expenses_audit (
			id,
			date,
			reference,
			amount,
			note,
			created_by,
			attachment,
			account_code,
			bank_code,
			biller_id,
			updated_by,
			updated_at,
			tax,
			status,
			warehouse_id,
			audit_type
		) SELECT 
			id,
			date,
			reference,
			amount,
			note,
			created_by,
			attachment,
			account_code,
			bank_code,
			biller_id,
			updated_by,
			updated_at,
			tax,
			status,
			warehouse_id,
			"DELETED"
		FROM
			erp_expenses
		WHERE
			erp_expenses.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_expenses_delete`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_expenses_delete` AFTER DELETE ON `erp_expenses` FOR EACH ROW BEGIN

   UPDATE erp_gl_trans SET amount = 0, description = CONCAT(description,' (Cancelled)')
   WHERE reference_no = OLD.reference;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_gift_cards_update`;
DELIMITER ;;
CREATE TRIGGER `audit_gift_cards_update` BEFORE UPDATE ON `erp_gift_cards` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_gift_cards_audit (
			id,
			date,
			card_no,
			value,
			customer_id,
			customer,
			balance,
			expiry,
			created_by,
			audit_type
		) SELECT 
			id,
			date,
			card_no,
			value,
			customer_id,
			customer,
			balance,
			expiry,
			created_by,
			"UPDATED"
		FROM
			erp_gift_cards
		WHERE
			erp_gift_cards.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_gift_cards_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_gift_cards_delete` BEFORE DELETE ON `erp_gift_cards` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_gift_cards_audit (
			id,
			date,
			card_no,
			value,
			customer_id,
			customer,
			balance,
			expiry,
			created_by,
			audit_type
		) SELECT 
			id,
			date,
			card_no,
			value,
			customer_id,
			customer,
			balance,
			expiry,
			created_by,
			"DELETED"
		FROM
			erp_gift_cards
		WHERE
			erp_gift_cards.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_gl_trans_update`;
DELIMITER ;;
CREATE TRIGGER `audit_gl_trans_update` BEFORE UPDATE ON `erp_gl_trans` FOR EACH ROW BEGIN
	IF OLD.tran_id THEN
		INSERT INTO erp_gl_trans_audit (
			tran_id,
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by,
			bank,
			gov_tax,
			reference_gov_tax,
			people_id,
			invoice_ref,
			ref_type,
			created_name,
			created_type,
			people,
			type,
			status_tax,
			audit_type
		) SELECT 
			tran_id,
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by,
			bank,
			gov_tax,
			reference_gov_tax,
			people_id,
			invoice_ref,
			ref_type,
			created_name,
			created_type,
			people,
			type,
			status_tax,
			"UPDATED"
		FROM
			erp_gl_trans
		WHERE
			erp_gl_trans.tran_id= OLD.tran_id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_gl_trans_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_gl_trans_delete` BEFORE DELETE ON `erp_gl_trans` FOR EACH ROW BEGIN
	IF OLD.tran_id THEN
		INSERT INTO erp_gl_trans_audit (
			tran_id,
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by,
			bank,
			gov_tax,
			reference_gov_tax,
			people_id,
			invoice_ref,
			ref_type,
			created_name,
			created_type,
			people,
			type,
			status_tax,
			audit_type
		) SELECT 
			tran_id,
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by,
			bank,
			gov_tax,
			reference_gov_tax,
			people_id,
			invoice_ref,
			ref_type,
			created_name,
			created_type,
			people,
			type,
			status_tax,
			"DELETED"
		FROM
			erp_gl_trans
		WHERE
			erp_gl_trans.tran_id= OLD.tran_id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_loan_delete`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_loan_delete` AFTER DELETE ON `erp_loans` FOR EACH ROW BEGIN

   UPDATE erp_gl_trans SET amount = 0, description = CONCAT(description,' (Cancelled)')
   WHERE reference_no = OLD.reference_no;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_payments_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_payments_insert` AFTER INSERT ON `erp_payments` FOR EACH ROW BEGIN

DECLARE v_tran_no INTEGER;
DECLARE v_default_cash INTEGER;
DECLARE v_default_credit_card INTEGER;
DECLARE v_default_gift_card INTEGER;
DECLARE v_default_cheque INTEGER;
DECLARE v_default_sale_deposit INTEGER;
DECLARE v_default_purchase_deposit INTEGER;
DECLARE v_default_loan INTEGER;
DECLARE v_default_receivable INTEGER;
DECLARE v_default_payable INTEGER;
DECLARE v_bank_code INTEGER;
DECLARE v_account_code INTEGER;
DECLARE v_tran_date DATETIME;

DECLARE v_default_cost_variant INTEGER;

DECLARE v_real_amount DECIMAL(11,2);

SET v_tran_date = (SELECT erp_sales.date 
		FROM erp_payments 
		RIGHT JOIN erp_sales ON erp_sales.id = erp_payments.sale_id
		WHERE erp_sales.id = NEW.sale_id LIMIT 0,1);

IF v_tran_date = NEW.date THEN
	SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
ELSE
	SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);


	UPDATE erp_order_ref
	SET tr = v_tran_no
	WHERE
	DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
END IF;

/*
SET v_default_cash = (SELECT default_cash FROM erp_account_settings WHERE biller_id = NEW.biller_id);
SET v_default_credit_card = (SELECT default_credit_card FROM erp_account_settings WHERE biller_id = NEW.biller_id);
SET v_default_gift_card = (SELECT default_gift_card FROM erp_account_settings WHERE biller_id = NEW.biller_id);
SET v_default_cheque = (SELECT default_cheque FROM erp_account_settings WHERE biller_id = NEW.biller_id);
SET v_default_sale_deposit = (SELECT default_sale_deposit FROM erp_account_settings WHERE biller_id = NEW.biller_id);
SET v_default_purchase_deposit = (SELECT default_purchase_deposit FROM erp_account_settings WHERE biller_id = NEW.biller_id);
SET v_default_loan = (SELECT default_loan FROM erp_account_settings WHERE biller_id = NEW.biller_id);

SET v_default_receivable = (SELECT default_receivable FROM erp_account_settings WHERE biller_id = NEW.biller_id);
SET v_default_payable = (SELECT default_payable FROM erp_account_settings WHERE biller_id = NEW.biller_id);
*/

SET v_default_cash = (SELECT default_cash FROM erp_account_settings);
SET v_default_credit_card = (SELECT default_credit_card FROM erp_account_settings);
SET v_default_gift_card = (SELECT default_gift_card FROM erp_account_settings);
SET v_default_cheque = (SELECT default_cheque FROM erp_account_settings);
SET v_default_sale_deposit = (SELECT default_sale_deposit FROM erp_account_settings);
SET v_default_purchase_deposit = (SELECT default_purchase_deposit FROM erp_account_settings);

SET v_default_loan = (SELECT default_loan FROM erp_account_settings);

SET v_default_receivable = (SELECT default_receivable FROM erp_account_settings);
SET v_default_payable = (SELECT default_payable FROM erp_account_settings);

SET v_default_cost_variant = (SELECT default_cost_variant FROM erp_account_settings);

SET v_real_amount = (SELECT SUM(old_grand_total) as am FROM erp_return_purchases WHERE purchase_id = NEW.purchase_id);

IF NEW.paid_by = 'cash' THEN 
SET v_bank_code = v_default_cash;          
END IF;

IF NEW.paid_by = 'credit_card' THEN
SET v_bank_code = v_default_credit_card;
END IF;

IF NEW.paid_by = 'gift_card' THEN
SET v_bank_code = v_default_gift_card ;
END IF;

IF NEW.paid_by = 'cheque' THEN
SET v_bank_code = v_default_cheque;
END IF;

IF NEW.paid_by = 'deposit' AND (ISNULL(NEW.sale_id) OR NEW.sale_id > 0) THEN
	SET v_bank_code = v_default_sale_deposit;
END IF;

IF NEW.paid_by = 'depreciation' AND NEW.sale_id > 0 THEN
	SET v_bank_code = v_default_sale_deposit;
END IF;

IF NEW.paid_by = 'deposit' AND NEW.purchase_id > 0    THEN
	SET v_bank_code = v_default_purchase_deposit;
END IF;

IF NEW.paid_by = 'loan' THEN
SET v_bank_code = v_default_loan;
END IF;

IF NEW.bank_account THEN
	SET v_bank_code = NEW.bank_account;
END IF;

/* ==== SALE GL =====*/
	IF NEW.sale_id>0 THEN
		IF NEW.return_id>0 AND NEW.type = 'returned' AND NEW.amount>0 THEN
			
			SET v_tran_date = (SELECT erp_return_sales.date 
					FROM erp_return_sales 
					WHERE erp_return_sales.id = NEW.return_id LIMIT 0,1);

			IF v_tran_date = NEW.date THEN
				SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
			ELSE
				SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);


				UPDATE erp_order_ref
				SET tr = v_tran_no
				WHERE
				DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
			END IF;
			
			IF NEW.add_payment = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by
					)
					SELECT
					'SALES-RETURN',
					'payment',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.amount,
					NEW.reference_no,
					(
						SELECT customer FROM erp_return_sales WHERE erp_return_sales.id = NEW.return_id
					),
					NEW.biller_id,
					NEW.created_by,
					'1',
					NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_receivable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_receivable;
			END IF;

			IF NEW.bank_account THEN

				INSERT INTO erp_gl_trans (
				tran_type,
				type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by) 
				SELECT
				'SALES-RETURN',
				'payment',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1)*(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = NEW.bank_account
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = NEW.bank_account;
			
			ELSE

				INSERT INTO erp_gl_trans (
				tran_type,
				type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by) 
				SELECT
				'SALES-RETURN',
				'payment',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1)*(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = v_bank_code
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = v_bank_code;				

			END IF;


  		ELSE
			IF NEW.add_payment = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by)
					SELECT
					'SALES',
					'payment',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(-1)*(NEW.amount),
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					'1',
					NEW.created_by,
					NEW.updated_by
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_receivable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_receivable;
			END IF;

			IF NEW.bank_account THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by) 
					SELECT
					'SALES',
					'payment',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.amount,
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					NEW.updated_by
					FROM
					erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = NEW.bank_account
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = NEW.bank_account;
			ELSE
				INSERT INTO erp_gl_trans (
					tran_type,
					type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by) 
					SELECT
					'SALES',
					'payment',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.amount,
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					NEW.updated_by
					FROM
					erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_bank_code
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_bank_code;

            END IF;

		END IF;
		
	ELSE
	
		IF NEW.return_id>0 AND NEW.type = 'returned' AND NEW.amount>0 THEN
			
			SET v_tran_date = (SELECT erp_return_sales.date 
					FROM erp_return_sales 
					WHERE erp_return_sales.id = NEW.return_id LIMIT 0,1);

			IF v_tran_date = NEW.date THEN
				SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
			ELSE
				SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);


				UPDATE erp_order_ref
				SET tr = v_tran_no
				WHERE
				DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
			END IF;
			
			IF NEW.add_payment = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,

					bank,
					updated_by
					)
					SELECT
					'SALES-RETURN',
					'payment',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.amount,
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_receivable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_receivable;
			END IF;

			INSERT INTO erp_gl_trans (
				tran_type,
				type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by) 
				SELECT
				'SALES-RETURN',
				'payment',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1)*(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = v_bank_code
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = v_bank_code;
		END IF;
		
    END IF;


/* ==== SALE DEPOSIT GL =====*/
	IF NEW.deposit_id THEN

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.amount),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits	WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_sale_deposit
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_sale_deposit;
				
		IF NEW.bank_account THEN
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				NEW.amount,
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = NEW.bank_account
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = NEW.bank_account;
					
		ELSE
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				NEW.amount,
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = v_bank_code;
					
		END IF;
		
	END IF;
	
/* ==== SALE RETURN DEPOSIT GL =====*/
	IF NEW.return_deposit_id THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.amount),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits	WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_sale_deposit
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_sale_deposit;
				
		IF NEW.bank_account THEN
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * abs(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = NEW.bank_account
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = NEW.bank_account;

					
		ELSE
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * abs(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = v_bank_code;
					
		END IF;
	END IF;

/* ==== PURCHASE DEPOSIT GL =====*/
	IF NEW.purchase_deposit_id THEN

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			NEW.amount,
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits	WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_purchase_deposit
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_purchase_deposit;

		

      IF NEW.bank_account THEN
                                 
                               INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.amount),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = NEW.bank_account
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode =NEW.bank_account;

                          ELSE
                                            INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.amount),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_bank_code;
	END IF;
END IF;

/* ==== SALE LOAN GL =====*/
	IF NEW.loan_id > 0 THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'LOANS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.amount),
			(
				SELECT reference_no FROM erp_loans WHERE id = NEW.loan_id
			),
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_loans WHERE id = NEW.loan_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_loan
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_loan;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'LOANS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			NEW.amount,
			(
				SELECT reference_no FROM erp_loans WHERE id = NEW.loan_id
			),
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_loans WHERE id = NEW.loan_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_bank_code;
	END IF;

/* ==== PURCHASE GL =====*/
	IF NEW.purchase_id>0 THEN
		IF NEW.note = 'Returned' THEN

			IF (v_real_amount - NEW.amount) > 0 THEN

				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by)
					SELECT
					'PURCHASES-RETURN',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(select if( (v_real_amount - NEW.amount) < 0 , (-1) * NEW.amount, (-1) * v_real_amount) as amount),
					(
						SELECT reference_no FROM erp_return_purchases WHERE purchase_id = NEW.purchase_id
					),
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					(
						SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
					)
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_payable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_payable;

				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by)
					SELECT
					'PURCHASES-RETURN',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(select if( (v_real_amount - NEW.amount) < 0 , abs(v_real_amount), abs(NEW.amount)) as amount) ,
					(
						SELECT reference_no FROM erp_return_purchases WHERE purchase_id = NEW.purchase_id
					),
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					(
						SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
					)
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_bank_code
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_bank_code;

				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by)
					SELECT
					'PURCHASES-RETURN',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(v_real_amount - NEW.amount),
					(
						SELECT reference_no FROM erp_return_purchases WHERE purchase_id = NEW.purchase_id
					),
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					(
						SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
					)
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_cost_variant
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_cost_variant;

			ELSE

				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by)
					SELECT
					'PURCHASES-RETURN',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.amount,
					(
						SELECT reference_no FROM erp_return_purchases WHERE purchase_id = NEW.purchase_id
					),
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					(
						SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
					)
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_payable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_payable;

				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by)
					SELECT
					'PURCHASES-RETURN',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(-1)*abs(NEW.amount),
					(
						SELECT reference_no FROM erp_return_purchases WHERE purchase_id = NEW.purchase_id
					),
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					(
						SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
					)
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_bank_code
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_bank_code;

			END IF;
                                     ELSE

			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'PURCHASES',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				NEW.amount,
				(select if( NEW.paid_by = 'deposit' , (SELECT reference_no FROM erp_purchases WHERE id = NEW.purchase_id), NEW.reference_no ) as amount),
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
				)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_payable
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_payable;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'PURCHASES',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)*abs(NEW.amount),
			(select if( NEW.paid_by = 'deposit' , (SELECT reference_no FROM erp_purchases WHERE id = NEW.purchase_id), NEW.reference_no ) as amount),
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_bank_code
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_bank_code;
		END IF;
	END IF;
     
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_payments_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_payments_update` AFTER UPDATE ON `erp_payments` FOR EACH ROW BEGIN

DECLARE v_tran_no INTEGER;
DECLARE v_default_cash INTEGER;
DECLARE v_default_credit_card INTEGER;
DECLARE v_default_gift_card INTEGER;
DECLARE v_default_cheque INTEGER;
DECLARE v_default_sale_deposit INTEGER;
DECLARE v_default_purchase_deposit INTEGER;
DECLARE v_default_loan INTEGER;
DECLARE v_default_receivable INTEGER;
DECLARE v_default_payable INTEGER;
DECLARE v_bank_code INTEGER;
DECLARE v_account_code INTEGER;
DECLARE v_tran_date DATETIME;
DECLARE v_referece varchar(50);

IF NEW.sale_id > 0 THEN
	SET v_tran_no = (SELECT tran_no FROM erp_gl_trans WHERE erp_gl_trans.reference_no = NEW.old_reference_no LIMIT 0,1); 
ELSE
	SET v_tran_no = (SELECT tran_no FROM erp_gl_trans WHERE erp_gl_trans.reference_no = NEW.reference_no LIMIT 0,1); 
END IF;

IF ISNULL(NEW.sale_id) THEN
	DELETE FROM erp_gl_trans WHERE tran_type='DEPOSITS' AND reference_no = NEW.reference_no;
END IF;

SET v_default_cash = (SELECT default_cash FROM erp_account_settings);
SET v_default_credit_card = (SELECT default_credit_card FROM erp_account_settings);
SET v_default_gift_card = (SELECT default_gift_card FROM erp_account_settings);
SET v_default_cheque = (SELECT default_cheque FROM erp_account_settings);
SET v_default_sale_deposit = (SELECT default_sale_deposit FROM erp_account_settings);
SET v_default_purchase_deposit = (SELECT default_purchase_deposit FROM erp_account_settings);

SET v_default_loan = (SELECT default_loan FROM erp_account_settings);

SET v_default_receivable = (SELECT default_receivable FROM erp_account_settings);
SET v_default_payable = (SELECT default_payable FROM erp_account_settings);

IF NEW.paid_by = 'cash' THEN 
SET v_bank_code = v_default_cash;          
END IF;

IF NEW.paid_by = 'credit_card' THEN
SET v_bank_code = v_default_credit_card;
END IF;

IF NEW.paid_by = 'gift_card' THEN
SET v_bank_code = v_default_gift_card ;
END IF;

IF NEW.paid_by = 'cheque' THEN
SET v_bank_code = v_default_cheque;
END IF;

IF NEW.paid_by = 'deposit' AND (ISNULL(NEW.sale_id) OR NEW.sale_id > 0) THEN
SET v_bank_code = v_default_sale_deposit;
END IF;

IF NEW.paid_by = 'depreciation' AND NEW.sale_id > 0 THEN
	SET v_bank_code = v_default_sale_deposit;
END IF;

IF NEW.paid_by = 'deposit' AND NEW.purchase_id > 0    THEN
	SET v_bank_code = v_default_purchase_deposit;
END IF;

IF NEW.paid_by = 'loan' THEN
SET v_bank_code = v_default_loan;
END IF;

IF NEW.bank_account THEN
	SET v_bank_code = NEW.bank_account;
END IF;

/* ==== SALE GL =====*/
	IF NEW.sale_id>0 THEN
	
		IF NEW.updated_by > 0 AND NEW.updated_count <> OLD.updated_count THEN
			DELETE FROM erp_gl_trans WHERE erp_gl_trans.reference_no = NEW.old_reference_no AND erp_gl_trans.type = 'payment';
		END IF;
		
		IF NEW.return_id>0 AND NEW.type = 'returned' AND NEW.amount>0 THEN
			
			SET v_tran_date = (SELECT erp_return_sales.date 
					FROM erp_return_sales 
					WHERE erp_return_sales.id = NEW.return_id LIMIT 0,1);

			IF v_tran_date = NEW.date THEN
				SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
			ELSE
				SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);


				UPDATE erp_order_ref
				SET tr = v_tran_no
				WHERE
				DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
			END IF;
			
			IF NEW.add_payment = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by
					)
					SELECT
					'SALES-RETURN',
					'payment',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.amount,
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					'1',
					NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_receivable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_receivable;
			END IF;

			IF NEW.bank_account THEN
			
				INSERT INTO erp_gl_trans (
				tran_type,
				type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by) 
				SELECT
				'SALES-RETURN',
				'payment',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1)*(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = NEW.bank_account
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = NEW.bank_account;

			ELSE

				INSERT INTO erp_gl_trans (
				tran_type,
				type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by) 
				SELECT
				'SALES-RETURN',
				'payment',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1)*(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = v_bank_code
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = v_bank_code;

			END IF;


  		ELSE
			IF NEW.add_payment = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					bank,
					updated_by)
					SELECT
					'SALES',
					'payment',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(-1)*(NEW.amount),

					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					'1',
					NEW.created_by,
					NEW.updated_by
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = v_default_receivable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = v_default_receivable;
			END IF;

			IF NEW.bank_account THEN

				INSERT INTO erp_gl_trans (
						tran_type,
						type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						bank,
						updated_by) 
					SELECT
						'SALES',
						'payment',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.amount,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						'1',
						NEW.updated_by
					FROM
						erp_account_settings
							INNER JOIN erp_gl_charts
							ON erp_gl_charts.accountcode =NEW.bank_account
							INNER JOIN erp_gl_sections
							ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
							erp_gl_charts.accountcode = NEW.bank_account;

			ELSE

				INSERT INTO erp_gl_trans (
						tran_type,
						type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						bank,
						updated_by) 
					SELECT
						'SALES',
						'payment',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.amount,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						'1',
						NEW.updated_by
					FROM
						erp_account_settings
							INNER JOIN erp_gl_charts
							ON erp_gl_charts.accountcode = v_bank_code
							INNER JOIN erp_gl_sections
							ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = v_bank_code;

			END IF;
		END IF;
    END IF;

/* ==== SALE DEPOSIT GL =====*/
	IF NEW.deposit_id THEN

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.amount),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,

			'1',
			(
				SELECT updated_by FROM erp_deposits	WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_sale_deposit
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_sale_deposit;
				
		IF NEW.bank_account THEN
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				NEW.amount,
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = NEW.bank_account
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = NEW.bank_account;
					
		ELSE
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				NEW.amount,
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = v_bank_code;
					
		END IF;
		
	END IF;

/* ==== SALE RETURN DEPOSIT GL =====*/
	IF NEW.return_deposit_id THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.amount),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits	WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_sale_deposit
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_sale_deposit;
				
		IF NEW.bank_account THEN
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * abs(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = NEW.bank_account
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = NEW.bank_account;
					
		ELSE
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				bank,
				updated_by)
				SELECT
				'DEPOSITS',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * abs(NEW.amount),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				'1',
				(
					SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
				)
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = v_bank_code;
					
		END IF;
	END IF;

/* ==== PURCHASE DEPOSIT GL =====*/
	IF NEW.purchase_deposit_id THEN

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			NEW.amount,
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits	WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_purchase_deposit
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_purchase_deposit;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'DEPOSITS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.amount),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_deposits WHERE id = NEW.deposit_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_bank_code;
	END IF;

/* ==== SALE LOAN GL =====*/
	IF NEW.loan_id > 0 THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'LOANS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(NEW.amount),
			(
				SELECT reference_no FROM erp_loans WHERE id = NEW.loan_id
			),
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_loans WHERE id = NEW.loan_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_default_loan
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_loan;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'LOANS',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			NEW.amount,
			(
				SELECT reference_no FROM erp_loans WHERE id = NEW.loan_id
			),
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_loans WHERE id = NEW.loan_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = v_bank_code
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_bank_code;
	END IF;

/* ==== PURCHASE GL =====*/
	IF NEW.purchase_id>0 THEN
	
		IF NEW.paid_by = "deposit" THEN
			SET v_referece = (SELECT reference_no FROM erp_purchases WHERE id = NEW.purchase_id);
		ELSE
			SET v_referece = NEW.reference_no;
		END IF;
		
		SET v_tran_no = (SELECT erp_gl_trans.tran_no 
				FROM erp_gl_trans 
				WHERE reference_no = v_referece AND bank = 1 LIMIT 0,1);
		
		DELETE FROM erp_gl_trans WHERE reference_no = v_referece AND bank = 1;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'PURCHASES',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			NEW.amount,
			v_referece,
			(
				SELECT supplier FROM erp_purchases WHERE id = NEW.purchase_id
			),
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_default_payable
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_default_payable;

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			bank,
			updated_by)
			SELECT
			'PURCHASES',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1)*abs(NEW.amount),
			v_referece,
			(
				SELECT supplier FROM erp_purchases WHERE id = NEW.purchase_id
			),
			NEW.biller_id,
			NEW.created_by,
			'1',
			(
				SELECT updated_by FROM erp_purchases WHERE id = NEW.purchase_id
			)
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = v_bank_code
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = v_bank_code;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_purchase_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_purchase_insert` AFTER INSERT ON `erp_purchases` FOR EACH ROW BEGIN
	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;

	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');

	IF NEW.status="received" AND NEW.total > 0 THEN

		SET v_tran_date = (SELECT erp_purchases.date 
				FROM erp_payments 
				INNER JOIN erp_purchases ON erp_purchases.id = erp_payments.purchase_id
				WHERE erp_purchases.id = NEW.id LIMIT 0,1);

		IF v_tran_date = NEW.date THEN
			SET v_tran_no = (SELECT MAX(tran_no) + 1 FROM erp_gl_trans);
		ELSE
			SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);
			
			UPDATE erp_order_ref
			SET tr = v_tran_no
			WHERE
			DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
		END IF;

		IF NEW.type_of_po="po"  THEN

			IF NEW.opening_ap != 1 THEN
			
				IF  v_acc_cate_separate <> 1 THEN
				
					IF NEW.cogs <> 0 THEN
					
						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							NEW.cogs,
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_stock;
						
						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							(-1) * NEW.cogs,
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_cost;
						
					END IF;

					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'PURCHASES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.total +NEW.shipping,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase
						INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase;
					
				END IF;
			
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'PURCHASES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(-1) * abs(NEW.grand_total),
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_payable
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_payable;
			
			END IF;
			
			IF NEW.order_discount THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
					) SELECT
					'PURCHASES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(-1) * abs(NEW.order_discount),

					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_discount
						INNER JOIN erp_gl_sections

						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase_discount;
			END IF;

			IF NEW.order_tax THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
					) SELECT
					'PURCHASES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					NEW.order_tax,
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax;
			END IF;
		
		END IF;
		
		IF NEW.opening_ap = 1 THEN
			
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'PURCHASES',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				abs(NEW.grand_total),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				NEW.updated_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_open_balance
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_open_balance;

			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'PURCHASES',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * abs(NEW.grand_total),
				NEW.reference_no,
				NEW.note,
				NEW.biller_id,
				NEW.created_by,
				NEW.updated_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_payable
					INNER JOIN erp_gl_sections
					ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_payable;
			
		END IF;

		
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_purchases_update`;
DELIMITER ;;
CREATE TRIGGER `audit_purchases_update` BEFORE UPDATE ON `erp_purchases` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_purchases_audit (
			id,
			biller_id,
			reference_no,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			opening_ap,
			type_of_po,
			order_ref,
			request_ref,
			paid_by,
			order_id,
			account_code,
			pur_refer,
			purchase_type,
			purchase_status,
			tax_type,
			item_status,
			container_no,
			container_size,
			invoice_no,
			order_reference_no,
			good_or_services,
			acc_cate_separate,
			audit_type
		) SELECT 
			id,
			biller_id,
			reference_no,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			opening_ap,
			type_of_po,
			order_ref,
			request_ref,
			paid_by,
			order_id,
			account_code,
			pur_refer,
			purchase_type,
			purchase_status,
			tax_type,
			item_status,
			container_no,
			container_size,
			invoice_no,
			order_reference_no,
			good_or_services,
			acc_cate_separate,
			"UPDATED"
		FROM
			erp_purchases
		WHERE
			erp_purchases.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_purchase_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_purchase_update` AFTER UPDATE ON `erp_purchases` FOR EACH ROW BEGIN
	DECLARE v_tran_no INTEGER;
                  DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_tran_date DATETIME;

	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');

	IF NEW.type_of_po = "po" THEN
	
		IF NEW.updated_by > 0 AND NEW.updated_count <> OLD.updated_count THEN
	
			DELETE FROM erp_gl_trans WHERE tran_type = 'PURCHASES' AND reference_no = NEW.reference_no;
		
		END IF;

		IF NEW.STATUS = "received" AND NEW.total > 0 AND NEW.updated_by > 0 AND NEW.updated_count <> OLD.updated_count AND NEW.return_id IS NULL THEN

			SET v_tran_no = (
				SELECT
					tran_no
				FROM
					erp_gl_trans
				WHERE
					tran_type = 'PURCHASES'
				AND reference_no = NEW.reference_no
				LIMIT 0,
				1
			);

			IF v_tran_no < 1 OR ISNULL(v_tran_no) THEN

				SET v_tran_no = (
					SELECT
						COALESCE (MAX(tran_no), 0) + 1
					FROM
						erp_gl_trans
				);

				UPDATE erp_order_ref
					SET tr = v_tran_no
				WHERE
					DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');

			END IF;

			IF NEW.opening_ap != 1 THEN
			
				IF  v_acc_cate_separate <> 1 THEN
				
					IF NEW.cogs <> 0 THEN
					
						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							NEW.cogs,
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_stock;
						
						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							(-1) * NEW.cogs,
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_cost;
						
					END IF;
				
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'PURCHASES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.total + NEW.shipping,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase;
				END IF;
				
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'PURCHASES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(- 1) * abs(NEW.grand_total),
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_payable
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_payable;

				IF NEW.order_discount THEN
				
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'PURCHASES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						(- 1) * abs(NEW.order_discount),
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_discount
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase_discount;


				END IF;

				IF NEW.total_tax THEN
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'PURCHASES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.total_tax,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax;


				END IF;

			END IF;
			
			IF NEW.opening_ap = 1 THEN
				
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
					) SELECT
					'PURCHASES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					abs(NEW.grand_total),
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = erp_account_settings.default_open_balance
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_open_balance;

				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
					) SELECT
					'PURCHASES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(-1) * abs(NEW.grand_total),
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
					FROM
						erp_account_settings
						INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = erp_account_settings.default_payable
						INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_payable;
				
			END IF;
			
		END IF;
		
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_purchases_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_purchases_delete` BEFORE DELETE ON `erp_purchases` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_purchases_audit (
			id,
			biller_id,
			reference_no,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			opening_ap,
			type_of_po,
			order_ref,
			request_ref,
			paid_by,
			order_id,
			account_code,
			pur_refer,
			purchase_type,
			purchase_status,
			tax_type,
			item_status,
			container_no,
			container_size,
			invoice_no,
			order_reference_no,
			good_or_services,
			acc_cate_separate,
			audit_type
		) SELECT 
			id,
			biller_id,
			reference_no,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			opening_ap,
			type_of_po,
			order_ref,
			request_ref,
			paid_by,
			order_id,
			account_code,
			pur_refer,
			purchase_type,
			purchase_status,
			tax_type,
			item_status,
			container_no,
			container_size,
			invoice_no,
			order_reference_no,
			good_or_services,
			acc_cate_separate,
			"DELETED"
		FROM
			erp_purchases
		WHERE
			erp_purchases.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_purchase_delete`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_purchase_delete` AFTER DELETE ON `erp_purchases` FOR EACH ROW BEGIN

   UPDATE erp_gl_trans SET amount = 0, description = CONCAT(description,' (Cancelled)')
   WHERE reference_no = OLD.reference_no;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_purchases_order_update`;
DELIMITER ;;
CREATE TRIGGER `audit_purchases_order_update` BEFORE UPDATE ON `erp_purchases_order` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_purchases_order_audit (
			id,
			biller_id,
			reference_no,
			purchase_ref,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			purchase_type,
			purchase_status,
			tax_type,
			order_status,
			request_id,
			audit_type
		) SELECT 
			id,
			biller_id,
			reference_no,
			purchase_ref,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			purchase_type,
			purchase_status,
			tax_type,
			order_status,
			request_id,
			"UPDATED"
		FROM
			erp_purchases_order
		WHERE
			erp_purchases_order.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_purchases_order_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_purchases_order_delete` BEFORE DELETE ON `erp_purchases_order` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_purchases_order_audit (
			id,
			biller_id,
			reference_no,
			purchase_ref,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			purchase_type,
			purchase_status,
			tax_type,
			order_status,
			request_id,
			audit_type
		) SELECT 
			id,
			biller_id,
			reference_no,
			purchase_ref,
			date,
			supplier_id,
			supplier,
			warehouse_id,
			note,
			total,
			product_discount,
			order_discount_id,
			order_discount,
			total_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			paid,
			status,
			payment_status,
			created_by,
			updated_by,
			updated_at,
			attachment,
			payment_term,
			due_date,
			return_id,
			surcharge,
			suspend_note,
			reference_no_tax,
			tax_status,
			purchase_type,
			purchase_status,
			tax_type,
			order_status,
			request_id,
			"DELETED"
		FROM
			erp_purchases_order
		WHERE
			erp_purchases_order.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_purchase_items_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_purchase_items_insert` AFTER INSERT ON `erp_purchase_items` FOR EACH ROW BEGIN
	DECLARE v_reference_no VARCHAR(55);
	DECLARE v_tran_no INTEGER;
	DECLARE v_date DATETIME;
	DECLARE v_biller_id INTEGER;
	DECLARE v_supplier VARCHAR(55);
	DECLARE v_created_by INTEGER;
	DECLARE v_updated_by INTEGER;
	DECLARE v_cost DECIMAL(4);
	DECLARE v_status VARCHAR(50);
	DECLARE v_category_id INTEGER;
	DECLARE v_qoh INTEGER;
	DECLARE v_updated_at DATETIME;
	DECLARE v_transaction_id INTEGER;
	DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_transaction_type VARCHAR(25);
	DECLARE v_tran_note VARCHAR(255);
	DECLARE v_chk_acc  INTEGER;
	DECLARE v_old_cost DECIMAL(4);
	DECLARE v_old_qty DECIMAL(4);

	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
	SET v_transaction_id = NEW.transaction_id;
	SET v_transaction_type = NEW.transaction_type;

	IF NEW.product_id THEN

		IF NEW.transaction_id THEN 
			
			/* SALE */
			IF v_transaction_type = 'SALE' THEN
				SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
				SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
				SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
				SET v_date = (SELECT
					erp_sales.date
				FROM
					erp_sales
					JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
				WHERE
					erp_sale_items.id = v_transaction_id
				LIMIT 0,1);
														   
				SET v_reference_no = (SELECT
							erp_sales.reference_no
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_supplier = (SELECT
							erp_sales.customer
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_biller_id = (SELECT
							erp_sales.biller_id
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_created_by = (SELECT
							erp_sales.created_by
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_updated_by = (SELECT
							erp_sales.updated_by
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_status = (SELECT
							erp_sales.sale_status
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_updated_at = (SELECT
							erp_sales.updated_at
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
						
				IF v_status = 'completed' THEN
					INSERT INTO erp_inventory_valuation_details (
						type,
						biller_id,
						product_id,
						product_code,
						product_name,
						category_id,
						reference_no,
						date,
						NAME,
						quantity,
						warehouse_id,
						cost,
						qty_on_hand,
						avg_cost,
						created_by,
						updated_by,
						updated_at,
						field_id
						)
						VALUES
						(
						v_transaction_type,
						v_biller_id,
						NEW.product_id,
						NEW.product_code,
						NEW.product_name,
						v_category_id,
						v_reference_no,
						v_date ,
						v_supplier,
						(-1)*NEW.quantity_balance,
						NEW.warehouse_id,
						v_cost,
						v_qoh,
						v_cost,
						v_created_by,
						v_updated_by,
						v_updated_at,
						v_transaction_id
					);
				END IF;

			END IF;
		END IF;
		/* End SALE */
			
		/* SALE RETURN */
		IF v_transaction_type = 'SALE RETURN' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
		
			SET v_date = (SELECT
				erp_return_sales.date
			FROM
				erp_return_sales
				JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
			WHERE
				erp_return_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_return_sales.reference_no
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_return_sales.customer
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_return_sales.biller_id
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_return_sales.created_by
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_return_sales.updated_by
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_at = (SELECT
						erp_return_sales.updated_at
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
					
			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				updated_by,
				updated_at,
				field_id
				)
				VALUES
				(
				v_transaction_type,
				v_biller_id,
				NEW.product_id,
				NEW.product_code,
				NEW.product_name,
				v_category_id,
				v_reference_no,
				v_date ,
				v_supplier,
				NEW.quantity_balance,
				NEW.warehouse_id,
				v_cost,
				v_qoh,
				v_cost,
				v_created_by,
				v_updated_by,
				v_updated_at,
				v_transaction_id
				);
		END IF;
		/* End SALE RETURN */
		
		/* PURCHASE */
		IF NEW.transaction_type = 'PURCHASE' THEN
			SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id  = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			

			SET v_date = (SELECT
				erp_purchases.date
			FROM
				erp_purchases
				JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
			WHERE
				erp_purchase_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_purchases.reference_no
					FROM
						erp_purchases
					WHERE
						erp_purchases.id = NEW.purchase_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_purchases.supplier
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id  = (SELECT
						erp_purchases.biller_id
					FROM
						erp_purchases
					WHERE
						erp_purchases.id =  NEW.purchase_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_purchases.created_by
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_purchases.updated_by
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_at = (SELECT
						erp_purchases.updated_at
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						erp_purchases.status
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_tran_note = (SELECT
						erp_purchases.note
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_old_cost = (SELECT
						erp_products.cost
					FROM
						erp_products
					WHERE
						erp_products.id = NEW.product_id
					LIMIT 0,1);
			SET v_old_qty = (SELECT
						erp_warehouses_products.quantity
					FROM
						erp_warehouses_products
					WHERE
						erp_warehouses_products.product_id = NEW.product_id AND erp_warehouses_products.warehouse_id = NEW.warehouse_id
					LIMIT 0,1);
					
			IF NEW.item_tax > 0 THEN
					
				INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'PURCHASES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.item_tax,
						v_reference_no,
						v_tran_note   ,
						v_biller_id,
						v_created_by,
						v_updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax
					INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax;
						
			END IF;
					
			IF v_acc_cate_separate = 1 THEN  

				SET  v_chk_acc  =  ( SELECT
										COUNT(*) as row
									FROM
										erp_categories
									INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_purchase
									INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
									WHERE
										erp_categories.id = v_category_id );
										
				IF NEW.status = "received" THEN

					IF   v_chk_acc  > 0 THEN

						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							((NEW.subtotal - NEW.item_tax) + NEW.net_shipping),
							v_reference_no,
							v_tran_note   ,
							v_biller_id,
							v_created_by,
							v_updated_by
						FROM
							erp_categories
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_purchase
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_categories.id = v_category_id ;

						IF v_old_qty < 0 THEN
						
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								((NEW.unit_cost - v_old_cost) * v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_categories
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_stock
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_categories.id = v_category_id ;
								
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								(-1) * ((NEW.unit_cost - v_old_cost) * v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_categories
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_cost
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_categories.id = v_category_id ;
								
						END IF;
							
					END IF;
					
					IF   v_chk_acc  <= 0   THEN

						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT

							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							((NEW.subtotal - NEW.item_tax) + NEW.net_shipping),
							v_reference_no,
							v_tran_note   ,
							v_biller_id,
							v_created_by,
							v_updated_by
						FROM
							erp_account_settings
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_purchase;
							
						IF v_old_qty < 0 THEN
						
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								((NEW.unit_cost - v_old_cost) - v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_account_settings
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_gl_charts.accountcode = erp_account_settings.default_stock;
								
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								(-1) * ((NEW.unit_cost - v_old_cost) - v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_account_settings
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_gl_charts.accountcode = erp_account_settings.default_cost;
								
						END IF;
							
					END IF;
					
				END IF;
			
			END IF;

													  
			IF v_status = 'received' THEN
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					updated_at,
					field_id
					)
					VALUES
					(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					v_reference_no,
					v_date ,
					v_supplier,
					NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_updated_by,
					v_updated_at,
					v_transaction_id
				);
			END IF;
		END IF;
		/* End PURCHASE */
		
		/* PURCHASE RETURN */
		IF NEW.transaction_type = 'PURCHASE RETURN' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			SET v_date = (SELECT
				erp_return_purchases.date
			FROM
				erp_return_purchases
				JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
			WHERE
				erp_return_purchase_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_return_purchases.reference_no
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_return_purchases.supplier
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_return_purchases.biller_id
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_return_purchases.created_by
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_return_purchases.updated_by
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_at = (SELECT
						erp_return_purchases.updated_at
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);

			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				updated_by,
				updated_at,
				field_id
				)
				VALUES
				(
				v_transaction_type,
				v_biller_id,
				NEW.product_id,
				NEW.product_code,
				NEW.product_name,
				v_category_id,
				v_reference_no,
				v_date ,
				v_supplier,
				(-1)*NEW.quantity_balance,
				NEW.warehouse_id,
				v_cost,
				v_qoh,
				v_cost,
				v_created_by,
				v_updated_by,
				v_updated_at,
				v_transaction_id
			);
		END IF;
		/* End PURCHASE RETURN */
		
		/* TRANSFER */
		IF NEW.transaction_type = 'TRANSFER' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
		
			SET v_date = (SELECT
				erp_transfers.date
			FROM
				erp_transfers
				JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
			WHERE
				erp_transfer_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_transfers.transfer_no
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_transfers.biller_id
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_transfers.created_by
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						erp_transfers.status
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				field_id
				)
				VALUES
				(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					v_reference_no,
					v_date,
					NULL,
					(-1)*NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_transaction_id
				);
		END IF;
		/* End TRANSFER */
		
		/* USING STOCK */
		IF NEW.transaction_type = 'USING STOCK' THEN
			SET v_cost = (SELECT cost FROM erp_products WHERE id = NEW.product_id);
			SET v_category_id = (SELECT category_id FROM erp_products WHERE id = NEW.product_id);
			SET v_qoh =  (SELECT quantity FROM erp_products WHERE id = NEW.product_id);

			SET v_date = (SELECT
				erp_enter_using_stock.date
			FROM
				erp_enter_using_stock
				JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
			WHERE
				erp_enter_using_stock_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_enter_using_stock.reference_no
					FROM
						erp_enter_using_stock
						JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
					WHERE
						erp_enter_using_stock_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_enter_using_stock.shop
					FROM
						erp_enter_using_stock
						JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
					WHERE
						erp_enter_using_stock_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_enter_using_stock.create_by
					FROM
						erp_enter_using_stock
						JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
					WHERE
						erp_enter_using_stock_items.id = v_transaction_id
					LIMIT 0,1);
			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				field_id
				)
				VALUES
				(
				v_transaction_type,
				v_biller_id,
				NEW.product_id,
				NEW.product_code,
				NEW.product_name,
				v_category_id,
				v_reference_no,
				v_date ,
				NULL,
				(-1)*NEW.quantity_balance,
				NEW.warehouse_id,
				v_cost,
				v_qoh,
				v_cost,
				v_created_by,
				v_transaction_id
			);
		END IF;
		/* End USING STOCK */
		
		/* ADJUSTMENT */
		IF NEW.transaction_type = 'ADJUSTMENT' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			SET v_date = (SELECT
				erp_adjustments.date
			FROM
				erp_adjustments
			WHERE
				erp_adjustments.id = v_transaction_id
			LIMIT 0,1);
			SET v_biller_id = (SELECT
						biller_id
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						created_by
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						updated_by
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						type
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
			IF v_status = 'addition' THEN
			
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					NULL,
					v_date ,
					v_supplier,
					NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_updated_by,
					v_transaction_id
				);
				
			ELSE 
			
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					NULL,
					v_date ,
					v_supplier,
					(-1)*NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_updated_by,
					v_transaction_id
				);
			
			END IF;
			
		END IF;
		/* End ADJUSTMENT */
		
		/* CONVERT */
		IF NEW.transaction_type = 'CONVERT' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			SET v_date = (SELECT
				erp_convert.date
			FROM
				erp_convert
				JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
			WHERE
				erp_convert_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_convert.reference_no
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_convert.customer
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_convert.biller_id
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_convert.created_by
					FROM
						erp_purchases
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_convert.updated_by
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						erp_convert.status
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			IF v_status = 'add' THEN
			
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					v_reference_no,
					v_date ,
					NULL,
					NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_updated_by,
					v_transaction_id
				);
				
			ELSE 
			
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
						v_transaction_type,
						v_biller_id,
						NEW.product_id,
						NEW.product_code,
						NEW.product_name,
						v_category_id,
						v_reference_no,
						v_date ,
						NULL,
						(-1)*NEW.quantity_balance,
						NEW.warehouse_id,
						v_cost,
						v_qoh,
						v_cost,
						v_created_by,
						v_updated_by,
						v_transaction_id
					);
			
			END IF;
			
		END IF;
		/* End CONVERT */
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_purchase_items_update`;
DELIMITER ;;
CREATE TRIGGER `audit_purchase_items_update` BEFORE UPDATE ON `erp_purchase_items` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_purchase_items_audit (
			id,
			delivery_id,
			purchase_id,
			transfer_id,
			product_id,
			product_code,
			product_name,
			option_id,
			product_type,
			net_unit_cost,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			expiry,
			subtotal,
			quantity_balance,
			date,
			status,
			unit_cost,
			real_unit_cost,
			quantity_received,
			supplier_part_no,
			supplier_id,
			job_name,
			note,
			convert_id,
			type,
			reference,
			opening_stock,
			create_id,
			returned,
			acc_cate_separate,
			specific_tax_on_certain_merchandise_and_services,
			accommodation_tax,
			public_lighting_tax,
			other_tax,
			payment_of_profit_tax,
			performance_royalty_intangible,
			payment_interest_non_bank,
			payment_interest_taxpayer_fixed,
			payment_interest_taxpayer_non_fixed,
			payment_rental_immovable_property,
			payment_of_interest,
			payment_royalty_rental_income_related,
			payment_management_technical,
			payment_dividend,
			withholding_tax_on_resident,
			withholding_tax_on_non_resident,
			audit_type
		) SELECT 
			id,
			delivery_id,
			purchase_id,
			transfer_id,
			product_id,
			product_code,
			product_name,
			option_id,
			product_type,
			net_unit_cost,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			expiry,
			subtotal,
			quantity_balance,
			date,
			status,
			unit_cost,
			real_unit_cost,
			quantity_received,
			supplier_part_no,
			supplier_id,
			job_name,
			note,
			convert_id,
			type,
			reference,
			opening_stock,
			create_id,
			returned,
			acc_cate_separate,
			specific_tax_on_certain_merchandise_and_services,
			accommodation_tax,
			public_lighting_tax,
			other_tax,
			payment_of_profit_tax,
			performance_royalty_intangible,
			payment_interest_non_bank,
			payment_interest_taxpayer_fixed,
			payment_interest_taxpayer_non_fixed,
			payment_rental_immovable_property,
			payment_of_interest,
			payment_royalty_rental_income_related,
			payment_management_technical,
			payment_dividend,
			withholding_tax_on_resident,
			withholding_tax_on_non_resident,
			"UPDATED"
		FROM
			erp_purchase_items
		WHERE
			erp_purchase_items.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_purchase_items_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_purchase_items_update` AFTER UPDATE ON `erp_purchase_items` FOR EACH ROW BEGIN
	DECLARE v_reference_no VARCHAR(55);
	DECLARE v_date DATETIME;
	DECLARE v_biller_id INTEGER;
	DECLARE v_supplier VARCHAR(55);
	DECLARE v_created_by INTEGER;
	DECLARE v_updated_by INTEGER;
	DECLARE v_cost DECIMAL(4);
	DECLARE v_status VARCHAR(50);
	DECLARE v_category_id INTEGER;
	DECLARE v_qoh INTEGER;
	DECLARE v_updated_at DATETIME;
	DECLARE v_transaction_id INTEGER;
	DECLARE v_transaction_type VARCHAR(25);
	DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_tran_note VARCHAR(255);
    DECLARE v_chk_acc  INTEGER;
	DECLARE v_old_cost DECIMAL(4);
	DECLARE v_old_qty DECIMAL(4);
	DECLARE v_tran_no INTEGER;


	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');

	IF NEW.product_id THEN

		SET v_transaction_id = NEW.transaction_id;
		SET v_transaction_type = NEW.transaction_type;
		
		/* SALE */
		IF NEW.transaction_id THEN 
			IF v_transaction_type = 'SALE' THEN
				
				SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
				SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
				SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
															SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);			

				SET v_date = (SELECT
					erp_sales.date
				FROM
					erp_sales
					JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
				WHERE
					erp_sale_items.id = v_transaction_id
				LIMIT 0,1);
				SET v_reference_no = (SELECT
							erp_sales.reference_no
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_supplier = (SELECT
							erp_sales.customer
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_biller_id = (SELECT
							erp_sales.biller_id
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_created_by = (SELECT
							erp_sales.created_by
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items = v_transaction_id
						LIMIT 0,1);
				SET v_updated_by = (SELECT
							erp_sales.updated_by
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_status = (SELECT
							erp_sales.sale_status
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
				SET v_updated_at = (SELECT
							erp_sales.updated_at
						FROM
							erp_sales
							JOIN erp_sale_items ON erp_sales.id = erp_sale_items.sale_id
						WHERE
							erp_sale_items.id = v_transaction_id
						LIMIT 0,1);
						
				DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'SALE' AND field_id = v_transaction_id;
				
				IF v_status = 'completed' THEN
					INSERT INTO erp_inventory_valuation_details (
						type,
						biller_id,
						product_id,
						product_code,
						product_name,
						category_id,
						reference_no,
						date,
						NAME,
						quantity,
						warehouse_id,
						cost,
						qty_on_hand,
						avg_cost,
						created_by,
						updated_by,
						updated_at,
						field_id
						)
						VALUES
						(
						v_transaction_type,
						v_biller_id,
						NEW.product_id,
						NEW.product_code,
						NEW.product_name,
						v_category_id,
						v_reference_no,
						v_date ,
						v_supplier,
						(-1)*NEW.quantity_balance,
						NEW.warehouse_id,
						v_cost,
						v_qoh,
						v_cost,
						v_created_by,
						v_updated_by,
						v_updated_at,
						v_transaction_id
					);
				END IF;

				END IF;
		END IF;
		/* End SALE */
			
		/* SALE RETURN */
		IF v_transaction_type = 'SALE RETURN' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
		
			SET v_date = (SELECT
				erp_return_sales.date
			FROM
				erp_return_sales
				JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
			WHERE
				erp_return_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_return_sales.reference_no
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_return_sales.customer
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_return_sales.biller_id
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_return_sales.created_by
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_return_sales.updated_by
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_at = (SELECT
						erp_return_sales.updated_at
					FROM
						erp_return_sales
						JOIN erp_return_items ON erp_return_sales.id = erp_return_items.return_id
					WHERE
						erp_return_items.id = v_transaction_id
					LIMIT 0,1);
			
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'SALE RETURN' AND field_id = v_transaction_id;
			
			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				updated_by,
				updated_at,
				field_id
				)
				VALUES
				(
				v_transaction_type,
				v_biller_id,
				NEW.product_id,
				NEW.product_code,
				NEW.product_name,
				v_category_id,
				v_reference_no,
				v_date ,
				v_supplier,
				NEW.quantity_balance,
				NEW.warehouse_id,
				v_cost,
				v_qoh,
				v_cost,
				v_created_by,
				v_updated_by,
				v_updated_at,
				v_transaction_id
				);
		END IF;
		/* End SALE RETURN */
			
		/* PURCHASE */
		IF NEW.transaction_type = 'PURCHASE' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			SET v_date = (SELECT
				erp_purchases.date
			FROM
				erp_purchases
				JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
			WHERE
				erp_purchase_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_purchases.reference_no
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_purchases.supplier
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_purchases.biller_id
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_purchases.created_by
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_purchases.updated_by
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_at = (SELECT
						erp_purchases.updated_at
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						erp_purchases.status
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_tran_note = (SELECT
						erp_purchases.note
					FROM
						erp_purchases
						JOIN erp_purchase_items ON erp_purchases.id = erp_purchase_items.purchase_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_old_cost = (SELECT
						erp_products.cost
					FROM
						erp_products
					WHERE
						erp_products.id = NEW.product_id
					LIMIT 0,1);
			SET v_old_qty = (SELECT
						erp_warehouses_products.quantity
					FROM
						erp_warehouses_products
					WHERE
						erp_warehouses_products.product_id = NEW.product_id AND erp_warehouses_products.warehouse_id = NEW.warehouse_id
					LIMIT 0,1);

			/*
					
			IF NEW.item_tax > 0 THEN
					
				INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'PURCHASES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.item_tax,
						v_reference_no,
						v_tran_note   ,
						v_biller_id,
						v_created_by,
						v_updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts
						ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax
					INNER JOIN erp_gl_sections
						ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax;
						
			END IF;
					
			IF v_acc_cate_separate = 1 THEN 
																	
				SET  v_chk_acc  =  ( 
					SELECT
						COUNT(*) as row
					FROM
						 erp_categories
					 INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_purchase
					 INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					 WHERE
						 erp_categories.id = v_category_id );

				IF NEW.status = "received" THEN
																			
					IF   v_chk_acc  > 0 THEN

						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							((NEW.subtotal - NEW.item_tax) + NEW.net_shipping),
							v_reference_no,
							v_tran_note   ,
							v_biller_id,
							v_created_by,
							v_updated_by
						FROM
							erp_categories
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_purchase
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_categories.id = v_category_id ;

						IF v_old_qty < 0 THEN
						
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								((NEW.unit_cost - v_old_cost) * v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_categories
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_stock
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_categories.id = v_category_id ;
								
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								(-1) * ((NEW.unit_cost - v_old_cost) * v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_categories
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_cost
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_categories.id = v_category_id ;
								
						END IF;
							
					END IF;

					IF   v_chk_acc  <= 0   THEN

						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT

							'PURCHASES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							((NEW.subtotal - NEW.item_tax) + NEW.net_shipping),
							v_reference_no,
							v_tran_note   ,
							v_biller_id,
							v_created_by,
							v_updated_by
						FROM
							erp_account_settings
							INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase
							INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_purchase;
							
						IF v_old_qty < 0 THEN
						
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								((NEW.unit_cost - v_old_cost) - v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_account_settings
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_gl_charts.accountcode = erp_account_settings.default_stock;
								
							INSERT INTO erp_gl_trans (
								tran_type,
								tran_no,
								tran_date,
								sectionid,
								account_code,
								narrative,
								amount,
								reference_no,
								description,
								biller_id,
								created_by,
								updated_by
							) SELECT

								'PURCHASES',
								v_tran_no,
								NEW.date,
								erp_gl_sections.sectionid,
								erp_gl_charts.accountcode,
								erp_gl_charts.accountname,
								(-1) * ((NEW.unit_cost - v_old_cost) - v_old_qty),
								v_reference_no,
								v_tran_note   ,
								v_biller_id,
								v_created_by,
								v_updated_by
							FROM
								erp_account_settings
								INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
								INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
							WHERE
								erp_gl_charts.accountcode = erp_account_settings.default_cost;
								
						END IF;
							
					END IF;

				END IF;

			END IF;
			
			*/
					
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'PURCHASE' AND field_id = v_transaction_id;
			
			IF v_status = 'received' THEN
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					updated_at,
					field_id
					)
					VALUES
					(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					v_reference_no,
					v_date ,
					v_supplier,
					NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_updated_by,
					v_updated_at,
					v_transaction_id
				);
			END IF;
														
		END IF;
		/* End PURCHASE */
			
		/* PURCHASE RETURN */
		IF NEW.transaction_type = 'PURCHASE RETURN' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			SET v_date = (SELECT
				erp_return_purchases.date
			FROM
				erp_return_purchases
				JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
			WHERE
				erp_return_purchase_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_return_purchases.reference_no
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_return_purchases.supplier
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_return_purchases.biller_id
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_return_purchases.created_by
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_return_purchases.updated_by
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_at = (SELECT
						erp_return_purchases.updated_at
					FROM
						erp_return_purchases
						JOIN erp_return_purchase_items ON erp_return_purchases.id = erp_return_purchase_items.return_id
					WHERE
						erp_return_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'PURCHASE RETURN' AND field_id = v_transaction_id;
			
			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				updated_by,
				updated_at,
				field_id
				)
				VALUES
				(
				v_transaction_type,
				v_biller_id,
				NEW.product_id,
				NEW.product_code,
				NEW.product_name,
				v_category_id,
				v_reference_no,
				v_date ,
				v_supplier,
				(-1)*NEW.quantity_balance,
				NEW.warehouse_id,
				v_cost,
				v_qoh,
				v_cost,
				v_created_by,
				v_updated_by,
				v_updated_at,
				v_transaction_id
			);
		END IF;
		/* End PURCHASE RETURN */
		
		/* TRANSFER */
		IF NEW.transaction_type = 'TRANSFER' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
		
			SET v_date = (SELECT
				erp_transfers.date
			FROM
				erp_transfers
				JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
			WHERE
				erp_transfer_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_transfers.transfer_no
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_transfers.biller_id
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_transfers.created_by
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						erp_transfers.status
					FROM
						erp_transfers
						JOIN erp_transfer_items ON erp_transfers.id = erp_transfer_items.transfer_id
					WHERE
						erp_transfer_items.id = v_transaction_id
					LIMIT 0,1);
					
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'TRANSFER' AND field_id = v_transaction_id;
			
			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				field_id
				)
				VALUES
				(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					v_reference_no,
					v_date,
					NULL,
					(-1)*NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_transaction_id
				);
		END IF;
		/* End TRANSFER */
		
		/* USING STOCK */
		IF NEW.transaction_type = 'USING STOCK' THEN
			SET v_cost = (SELECT cost FROM erp_products WHERE id = NEW.product_id);
			SET v_category_id = (SELECT category_id FROM erp_products WHERE id = NEW.product_id);
			SET v_qoh =  (SELECT quantity FROM erp_products WHERE id = NEW.product_id);

			SET v_date = (SELECT
				erp_enter_using_stock.date
			FROM
				erp_enter_using_stock
				JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
			WHERE
				erp_enter_using_stock_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_enter_using_stock.reference_no
					FROM
						erp_enter_using_stock
						JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
					WHERE
						erp_enter_using_stock_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_enter_using_stock.shop
					FROM
						erp_enter_using_stock
						JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
					WHERE
						erp_enter_using_stock_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_enter_using_stock.create_by
					FROM
						erp_enter_using_stock
						JOIN erp_enter_using_stock_items ON erp_enter_using_stock.reference_no = erp_enter_using_stock_items.reference_no
					WHERE
						erp_enter_using_stock_items.id = v_transaction_id
					LIMIT 0,1);
					
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'USING STOCK' AND field_id = v_transaction_id;
			
			INSERT INTO erp_inventory_valuation_details (
				type,
				biller_id,
				product_id,
				product_code,
				product_name,
				category_id,
				reference_no,
				date,
				NAME,
				quantity,
				warehouse_id,
				cost,
				qty_on_hand,
				avg_cost,
				created_by,
				field_id
				)
				VALUES
				(
				v_transaction_type,
				v_biller_id,
				NEW.product_id,
				NEW.product_code,
				NEW.product_name,
				v_category_id,
				v_reference_no,
				v_date ,
				NULL,
				(-1)*NEW.quantity_balance,
				NEW.warehouse_id,
				v_cost,
				v_qoh,
				v_cost,
				v_created_by,
				v_transaction_id
			);
		END IF;
		/* End USING STOCK */
		
		/* ADJUSTMENT */
		IF NEW.transaction_type = 'ADJUSTMENT' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			SET v_date = (SELECT
				erp_adjustments.date
			FROM
				erp_adjustments
			WHERE
				erp_adjustments.id = v_transaction_id
			LIMIT 0,1);
			SET v_biller_id = (SELECT
						biller_id
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						created_by
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						updated_by
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						type
					FROM
						erp_adjustments
					WHERE
						id = v_transaction_id
					LIMIT 0,1);
					
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'ADJUSTMENT' AND field_id = v_transaction_id;
			
			IF v_status = 'addition' THEN
				
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
						v_transaction_type,
						v_biller_id,
						NEW.product_id,
						NEW.product_code,
						NEW.product_name,
						v_category_id,
						NULL,
						v_date ,
						v_supplier,
						NEW.quantity_balance,
						NEW.warehouse_id,
						v_cost,
						v_qoh,
						v_cost,
						v_created_by,
						v_updated_by,
						v_transaction_id
					);
				
			ELSE 
			
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					NULL,
					v_date ,
					v_supplier,
					(-1)*NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_updated_by,
					v_transaction_id
				);
			
			END IF;
			
		END IF;
		/* End ADJUSTMENT */
		
		/* CONVERT */
		IF NEW.transaction_type = 'CONVERT' THEN
			SET v_cost = (SELECT erp_products.cost FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
			SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
			
			SET v_date = (SELECT
				erp_convert.date
			FROM
				erp_convert
				JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
			WHERE
				erp_convert_items.id = v_transaction_id
			LIMIT 0,1);
			SET v_reference_no = (SELECT
						erp_convert.reference_no
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_supplier = (SELECT
						erp_convert.customer
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_biller_id = (SELECT
						erp_convert.biller_id
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_created_by = (SELECT
						erp_convert.created_by
					FROM
						erp_purchases
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_updated_by = (SELECT
						erp_convert.updated_by
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			SET v_status = (SELECT
						erp_convert.status
					FROM
						erp_convert
						JOIN erp_convert_items ON erp_convert.id = erp_convert_items.convert_id
					WHERE
						erp_purchase_items.id = v_transaction_id
					LIMIT 0,1);
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = NEW.product_id AND type = 'CONVERT' AND field_id = v_transaction_id;
			IF v_status = 'add' THEN
			
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
					v_transaction_type,
					v_biller_id,
					NEW.product_id,
					NEW.product_code,
					NEW.product_name,
					v_category_id,
					v_reference_no,
					v_date ,
					NULL,
					NEW.quantity_balance,
					NEW.warehouse_id,
					v_cost,
					v_qoh,
					v_cost,
					v_created_by,
					v_updated_by,
					v_transaction_id
				);
				
			ELSE 
			
				INSERT INTO erp_inventory_valuation_details (
					type,
					biller_id,
					product_id,
					product_code,
					product_name,
					category_id,
					reference_no,
					date,
					NAME,
					quantity,
					warehouse_id,
					cost,
					qty_on_hand,
					avg_cost,
					created_by,
					updated_by,
					field_id
					)
					VALUES
					(
						v_transaction_type,
						v_biller_id,
						NEW.product_id,
						NEW.product_code,
						NEW.product_name,
						v_category_id,
						v_reference_no,
						v_date ,
						NULL,
						(-1)*NEW.quantity_balance,
						NEW.warehouse_id,
						v_cost,
						v_qoh,
						v_cost,
						v_created_by,
						v_updated_by,
						v_transaction_id
					);
			
			END IF;
			
		END IF;
		/* End CONVERT */
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_purchase_items_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_purchase_items_delete` BEFORE DELETE ON `erp_purchase_items` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_purchase_items_audit (
			id,
			delivery_id,
			purchase_id,
			transfer_id,
			product_id,
			product_code,
			product_name,
			option_id,
			product_type,
			net_unit_cost,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			expiry,
			subtotal,
			quantity_balance,
			date,
			status,
			unit_cost,
			real_unit_cost,
			quantity_received,
			supplier_part_no,
			supplier_id,
			job_name,
			note,
			convert_id,
			type,
			reference,
			opening_stock,
			create_id,
			returned,
			acc_cate_separate,
			specific_tax_on_certain_merchandise_and_services,
			accommodation_tax,
			public_lighting_tax,
			other_tax,
			payment_of_profit_tax,
			performance_royalty_intangible,
			payment_interest_non_bank,
			payment_interest_taxpayer_fixed,
			payment_interest_taxpayer_non_fixed,
			payment_rental_immovable_property,
			payment_of_interest,
			payment_royalty_rental_income_related,
			payment_management_technical,
			payment_dividend,
			withholding_tax_on_resident,
			withholding_tax_on_non_resident,
			audit_type
		) SELECT 
			id,
			delivery_id,
			purchase_id,
			transfer_id,
			product_id,
			product_code,
			product_name,
			option_id,
			product_type,
			net_unit_cost,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			expiry,
			subtotal,
			quantity_balance,
			date,
			status,
			unit_cost,
			real_unit_cost,
			quantity_received,
			supplier_part_no,
			supplier_id,
			job_name,
			note,
			convert_id,
			type,
			reference,
			opening_stock,
			create_id,
			returned,
			acc_cate_separate,
			specific_tax_on_certain_merchandise_and_services,
			accommodation_tax,
			public_lighting_tax,
			other_tax,
			payment_of_profit_tax,
			performance_royalty_intangible,
			payment_interest_non_bank,
			payment_interest_taxpayer_fixed,
			payment_interest_taxpayer_non_fixed,
			payment_rental_immovable_property,
			payment_of_interest,
			payment_royalty_rental_income_related,
			payment_management_technical,
			payment_dividend,
			withholding_tax_on_resident,
			withholding_tax_on_non_resident,
			"DELETED"
		FROM
			erp_purchase_items
		WHERE
			erp_purchase_items.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_purchase_items_delete`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_purchase_items_delete` AFTER DELETE ON `erp_purchase_items` FOR EACH ROW BEGIN
DECLARE v_reference_no VARCHAR(55);
DECLARE v_status VARCHAR(50);
DECLARE v_transaction_id INTEGER;
DECLARE v_transaction_type VARCHAR(25);

IF OLD.product_id THEN

	SET v_transaction_id = OLD.transaction_id;
	SET v_transaction_type = OLD.transaction_type;
	
	IF OLD.transaction_id THEN 
		
		/* SALE */
		IF v_transaction_type = 'SALE' THEN
			IF v_status = 'completed' THEN
				DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'SALE' AND field_id = v_transaction_id;
			END IF;
		END IF;
		/* End SALE */
		
		/* SALE RETURN */
		IF v_transaction_type = 'SALE RETURN' THEN
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'SALE RETURN' AND field_id = v_transaction_id;
		END IF;
		/* End SALE RETURN */
		
		/* PURCHASE */
		IF v_transaction_type = 'PURCHASE' THEN
			IF v_status = 'received' THEN
				DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'PURCHASE' AND field_id = v_transaction_id;
			END IF;
		END IF;
		/* End PURCHASE */
		
		/* PURCHASE RETURN */
		IF v_transaction_type = 'PURCHASE RETURN' THEN	
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'PURCHASE RETURN' AND field_id = v_transaction_id;
		END IF;
		/* End PURCHASE RETURN */
		
		/* TRANSFER */
		IF v_transaction_type = 'TRANSFER' THEN
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'TRANSFER' AND field_id = v_transaction_id;
		END IF;
		/* End TRANSFER */
		
		/* USING STOCK */
		IF v_transaction_type = 'USING STOCK' THEN
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'USING STOCK' AND field_id = v_transaction_id;
		END IF;
		/* End USING STOCK */
		
		/* ADJUSTMENT */
		IF v_transaction_type = 'ADJUSTMENT' THEN
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'ADJUSTMENT' AND field_id = v_transaction_id;
		END IF;
		/* End ADJUSTMENT */
		
		/* CONVERT */
		IF v_transaction_type = 'CONVERT' THEN
			DELETE FROM erp_inventory_valuation_details WHERE reference_no = v_reference_no AND product_id = OLD.product_id AND type = 'CONVERT' AND field_id = v_transaction_id;			
		END IF;
		/* End CONVERT */
	END IF;
END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_return_items_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_return_items_insert` AFTER INSERT ON `erp_return_items` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_tran_reference_no VARCHAR(55);
	DECLARE v_tran_customer VARCHAR(55);
	DECLARE v_tran_biller_id INTEGER;
	DECLARE v_tran_created_by INTEGER;
	DECLARE v_tran_updated_by INTEGER;
	DECLARE v_tax_type INTEGER;
	DECLARE v_order_tax_id INTEGER;
	DECLARE v_sale_type INTEGER;
	DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_tran_note VARCHAR(255);
	DECLARE v_category_id INTEGER;
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');
	
	IF v_acc_cate_separate = 1 THEN
	
		SET v_tran_date = (SELECT erp_return_sales.date 
			FROM erp_return_sales
			WHERE erp_return_sales.id = NEW.return_id LIMIT 0,1);
			
		SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
		SET v_tran_reference_no = (SELECT erp_return_sales.reference_no FROM erp_return_sales WHERE erp_return_sales.id = NEW.return_id);
		SET v_tran_customer = (SELECT erp_return_sales.customer FROM erp_return_sales WHERE erp_return_sales.id = NEW.return_id);
		SET v_tran_biller_id = (SELECT erp_return_sales.biller_id FROM erp_return_sales WHERE erp_return_sales.id = NEW.return_id);
		SET v_tran_created_by = (SELECT erp_return_sales.created_by FROM erp_return_sales WHERE erp_return_sales.id = NEW.return_id);
		SET v_tran_updated_by = (SELECT erp_return_sales.updated_by FROM erp_return_sales WHERE erp_return_sales.id = NEW.return_id);
		SET v_tran_note = (SELECT erp_return_sales.note FROM erp_return_sales WHERE erp_return_sales.id = NEW.return_id);
		SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
		
		
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'SALES-RETURN',
			v_tran_no,
			v_tran_date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.subtotal),
			v_tran_reference_no,
			v_tran_customer,
			v_tran_biller_id,
			v_tran_created_by,
			v_tran_updated_by
			FROM
				erp_categories
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_sale
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_categories.id = v_category_id;
		
		IF (NEW.cost * NEW.quantity) > 0 THEN
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'SALES-RETURN',
				v_tran_no,
				v_tran_date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * (NEW.cost * NEW.quantity),
				v_tran_reference_no,
				v_tran_customer,
				v_tran_biller_id,
				v_tran_created_by,
				v_tran_updated_by
				FROM
					erp_categories
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_cost
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_category_id;

			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'SALES-RETURN',
				v_tran_no,
				v_tran_date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				abs(NEW.cost * NEW.quantity),
				v_tran_reference_no,
				v_tran_customer,
				v_tran_biller_id,
				v_tran_created_by,
				v_tran_updated_by
				FROM
					erp_categories
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_stock
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_category_id;
					
		END IF;
		
	END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_return_purchse_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_return_purchse_insert` AFTER INSERT ON `erp_return_purchases` FOR EACH ROW BEGIN

    DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;

	SET v_tran_date = (
		SELECT
			erp_purchases.date
		FROM
			erp_payments
		INNER JOIN erp_purchases ON erp_purchases.id = erp_payments.purchase_id
		WHERE
			erp_purchases.id = NEW.id
		LIMIT 0,
		1
	);

	SET v_acc_cate_separate = (
		SELECT 
			erp_settings.acc_cate_separate 
		FROM 
			erp_settings 
		WHERE 
			erp_settings.setting_id = '1'
	);
	
	IF v_tran_date = NEW.date THEN

		SET v_tran_no = (
			SELECT
				MAX(tran_no)
			FROM
				erp_gl_trans
		);

	ELSE

		SET v_tran_no = (
			SELECT
				COALESCE (MAX(tran_no), 0) + 1
			FROM
				erp_gl_trans
		);

		UPDATE erp_order_ref
		SET tr = v_tran_no
		WHERE
			DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');

	END IF;

	IF  v_acc_cate_separate <> 1 THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'PURCHASES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * (
				NEW.total + NEW.product_discount + NEW.shipping
			),
			NEW.reference_no,
			NEW.supplier,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
		FROM
			erp_account_settings
		INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase
		INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
		WHERE
			erp_gl_charts.accountcode = erp_account_settings.default_purchase;
	END IF;

	INSERT INTO erp_gl_trans (
		tran_type,
		tran_no,
		tran_date,
		sectionid,
		account_code,
		narrative,
		amount,
		reference_no,
		description,
		biller_id,
		created_by,
		updated_by
	) SELECT
		'PURCHASES-RETURN',
		v_tran_no,
		NEW.date,
		erp_gl_sections.sectionid,
		erp_gl_charts.accountcode,
		erp_gl_charts.accountname,
		abs(NEW.grand_total),
		NEW.reference_no,
		NEW.supplier,
		NEW.biller_id,
		NEW.created_by,
		NEW.updated_by
	FROM
		erp_account_settings
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_payable
	INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
	WHERE
		erp_gl_charts.accountcode = erp_account_settings.default_payable;

	IF NEW.total_discount THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'PURCHASES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.total_discount),
			NEW.reference_no,
			NEW.supplier,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
		FROM
			erp_account_settings
		INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_discount
		INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
		WHERE
			erp_gl_charts.accountcode = erp_account_settings.default_purchase_discount;


	END IF;

	IF NEW.total_tax THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'PURCHASES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * NEW.total_tax,
			NEW.reference_no,
			NEW.supplier,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
		FROM
			erp_account_settings
		INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax
		INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
		WHERE
			erp_gl_charts.accountcode = erp_account_settings.default_purchase_tax;

	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_return_sales_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_return_sales_insert` AFTER INSERT ON `erp_return_sales` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');

	SET v_tran_date = (SELECT erp_return_sales.date 
			FROM erp_payments 
			INNER JOIN erp_return_sales ON erp_return_sales.id = erp_payments.return_id
			WHERE erp_return_sales.id = NEW.id LIMIT 0,1);

	IF v_tran_date = NEW.date THEN
		SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
	ELSE
		SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);
		
		UPDATE erp_order_ref
		SET tr = v_tran_no
		WHERE
		DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
	END IF;

	IF NEW.grand_total > 0 THEN

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			) SELECT
			'SALES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1) * (NEW.grand_total),
			NEW.reference_no,
			NEW.customer,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = erp_account_settings.default_receivable
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_receivable;
			
	END IF;
	
	IF v_acc_cate_separate <> 1 THEN
		
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'SALES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.total),
			NEW.reference_no,
			NEW.customer,
			NEW.biller_id,
			NEW.created_by,

			NEW.updated_by
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_sale;
		
		IF NEW.total_cost > 0 THEN
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'SALES-RETURN',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * NEW.total_cost,
				NEW.reference_no,
				NEW.customer,
				NEW.biller_id,
				NEW.created_by,
				NEW.updated_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_cost
					INNER JOIN erp_gl_sections   ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_cost;

			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'SALES-RETURN',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				abs(NEW.total_cost),
				NEW.reference_no,
				NEW.customer,
				NEW.biller_id,
				NEW.created_by,
				NEW.updated_by
				FROM
					erp_account_settings
					INNER JOIN erp_gl_charts
					ON erp_gl_charts.accountcode = erp_account_settings.default_stock
					INNER JOIN erp_gl_sections   ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_stock;
					
		END IF;
		
	END IF;

	IF NEW.order_discount THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			) SELECT
			'SALES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1) * NEW.order_discount,
			NEW.reference_no,
			NEW.customer,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = erp_account_settings.default_sale_discount
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_sale_discount;
	END IF;

	IF NEW.order_tax THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			) SELECT
			'SALES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.order_tax),
			NEW.reference_no,
			NEW.customer,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = erp_account_settings.default_sale_tax
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_sale_tax;
	END IF;

	IF NEW.shipping THEN
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
			) SELECT
			'SALES-RETURN',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			abs(NEW.shipping),
			NEW.reference_no,
			NEW.customer,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
			FROM
				erp_account_settings
				INNER JOIN erp_gl_charts
				ON erp_gl_charts.accountcode = erp_account_settings.default_sale_freight
				INNER JOIN erp_gl_sections
				ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_sale_freight;
	END IF;
	
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_sales_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_sales_insert` AFTER INSERT ON `erp_sales` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');

	IF NEW.opening_ar != 2 THEN
		IF NEW.total > 0 || NEW.total_discount THEN
			SET v_tran_date = (
				SELECT
					erp_sales.date
				FROM
					erp_payments
				INNER JOIN erp_sales ON erp_sales.id = erp_payments.sale_id
				WHERE
					erp_sales.id = NEW.id
				LIMIT 0,
				1
			);


			IF v_tran_date = NEW.date THEN
				SET v_tran_no = (
					SELECT
						MAX(tran_no)
					FROM
						erp_gl_trans
				);
			ELSE
				SET v_tran_no = (
					SELECT
						COALESCE (MAX(tran_no), 0) + 1
					FROM
						erp_gl_trans
				);
				UPDATE erp_order_ref
				SET tr = v_tran_no
				WHERE
					DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');


			END IF;

			IF NEW.opening_ar = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'SALES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(- 1) * abs(
						NEW.total + NEW.product_discount
					),
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_open_balance
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_open_balance;

			ELSE
				IF v_acc_cate_separate <> 1 THEN
					INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'SALES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							(- 1) * abs(
								NEW.total
							),
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
						INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale
						INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_sale;

					IF NEW.sale_status = "completed" AND NEW.total_cost > 0 THEN		
						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'SALES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							NEW.total_cost,
							NEW.reference_no,
							NEW.customer,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
						INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
						INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_cost;


						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'SALES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							(- 1) * abs(NEW.total_cost),
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
						INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
						INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_stock;
					END IF;
				END IF;

				IF NEW.order_discount THEN
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.order_discount,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale_discount
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_sale_discount;

				END IF;

				IF NEW.shipping THEN
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						(- 1) * abs(NEW.shipping),
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale_freight
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_sale_freight;
						
				END IF;

				IF NEW.order_tax THEN
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						(- 1) * abs(NEW.order_tax),
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale_tax
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_sale_tax;


				END IF;

			END IF;
		END IF;

		IF NEW.grand_total > NEW.paid THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
			) SELECT
				'SALES',
				v_tran_no,
				NEW.date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(NEW.grand_total - NEW.paid),
				NEW.reference_no,
				NEW.customer,
				NEW.biller_id,
				NEW.created_by,
				NEW.updated_by
			FROM
				erp_account_settings
			INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_receivable
			INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
			WHERE
				erp_gl_charts.accountcode = erp_account_settings.default_receivable;
		END IF;

	END IF;

	IF NEW.opening_ar = 2 THEN
		SET v_tran_date = (
			SELECT
				erp_sales.date
			FROM
				erp_payments
			INNER JOIN erp_sales ON erp_sales.id = erp_payments.sale_id
			WHERE
				erp_sales.id = NEW.id
			LIMIT 0,
			1
		);
		
		IF v_tran_date = NEW.date THEN
			SET v_tran_no = (
				SELECT
					MAX(tran_no)
				FROM
					erp_gl_trans
			);
		ELSE
			SET v_tran_no = (
				SELECT
					COALESCE (MAX(tran_no), 0) + 1
				FROM
					erp_gl_trans
			);
			
			UPDATE erp_order_ref
			SET tr = v_tran_no
			WHERE
				DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');


		END IF;
		
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'SALES',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(
				NEW.total + NEW.product_discount
			),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
		FROM
			erp_account_settings
		INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_open_balance
		INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
		WHERE
			erp_gl_charts.accountcode = erp_account_settings.default_open_balance;
			
        IF NEW.paid <= 0 THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				   ) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.grand_total,
						NEW.reference_no,
						NEW.note,

						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
					erp_account_settings
					   INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_receivable
					   INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					   WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_receivable;
		END IF;
		
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_sales_update`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_sales_update` AFTER UPDATE ON `erp_sales` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_acc_cate_separate INTEGER;
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');

	IF NEW.opening_ar != 2 THEN
		IF NEW.total > 0 AND NEW.updated_by > 0 AND NEW.updated_count <> OLD.updated_count THEN

			SET v_tran_no = (SELECT tran_no FROM erp_gl_trans WHERE tran_type='SALES' AND reference_no = NEW.reference_no LIMIT 0,1);

			IF v_tran_no < 1  THEN
				SET v_tran_no = (SELECT COALESCE(MAX(tran_no),0) +1 FROM erp_gl_trans);	                
				UPDATE erp_order_ref SET tr = v_tran_no WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');
			END IF;

			DELETE FROM erp_gl_trans WHERE tran_type='SALES' AND reference_no = NEW.reference_no;
			
			IF NEW.opening_ar = 1 THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'SALES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(- 1) * abs(
						NEW.total + NEW.product_discount
					),
					NEW.reference_no,
					NEW.note,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_open_balance
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_open_balance;

			ELSE
				IF v_acc_cate_separate <> 1 THEN
					INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'SALES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							(- 1) * abs(
								NEW.total
							),
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
						INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale
						INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_sale;

					IF NEW.sale_status = "completed" AND NEW.total_cost > 0 THEN	
						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'SALES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							NEW.total_cost,
							NEW.reference_no,
							NEW.customer,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
						INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_cost
						INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_cost;


						INSERT INTO erp_gl_trans (
							tran_type,
							tran_no,
							tran_date,
							sectionid,
							account_code,
							narrative,
							amount,
							reference_no,
							description,
							biller_id,
							created_by,
							updated_by
						) SELECT
							'SALES',
							v_tran_no,
							NEW.date,
							erp_gl_sections.sectionid,
							erp_gl_charts.accountcode,
							erp_gl_charts.accountname,
							(- 1) * abs(NEW.total_cost),
							NEW.reference_no,
							NEW.note,
							NEW.biller_id,
							NEW.created_by,
							NEW.updated_by
						FROM
							erp_account_settings
						INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_stock
						INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
						WHERE
							erp_gl_charts.accountcode = erp_account_settings.default_stock;
					END IF;
				END IF;

				IF NEW.order_discount THEN
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.order_discount,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings

					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale_discount
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_sale_discount;

				END IF;

				IF NEW.shipping THEN
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						(- 1) * abs(NEW.shipping),
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale_freight
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_sale_freight;
						
				END IF;

				IF NEW.order_tax THEN
					INSERT INTO erp_gl_trans (
						tran_type,
						tran_no,
						tran_date,
						sectionid,
						account_code,
						narrative,
						amount,
						reference_no,
						description,
						biller_id,
						created_by,
						updated_by
					) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						(- 1) * abs(NEW.order_tax),
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
						erp_account_settings
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_sale_tax
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					WHERE
						erp_gl_charts.accountcode = erp_account_settings.default_sale_tax;


				END IF;

			END IF;
	
		END IF;
		IF NEW.total > 0 AND NEW.updated_by > 0 AND NEW.updated_count <> OLD.updated_count THEN
			IF NEW.grand_total > NEW.paid THEN
				INSERT INTO erp_gl_trans (
					tran_type,
					tran_no,
					tran_date,
					sectionid,
					account_code,
					narrative,
					amount,
					reference_no,
					description,
					biller_id,
					created_by,
					updated_by
				) SELECT
					'SALES',
					v_tran_no,
					NEW.date,
					erp_gl_sections.sectionid,
					erp_gl_charts.accountcode,
					erp_gl_charts.accountname,
					(NEW.grand_total - NEW.paid),
					NEW.reference_no,
					NEW.customer,
					NEW.biller_id,
					NEW.created_by,
					NEW.updated_by
				FROM
					erp_account_settings
				INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_receivable
				INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_receivable;
			END IF;
		END IF;

	END IF;

	IF NEW.opening_ar = 2 THEN
		SET v_tran_date = (
			SELECT
				erp_sales.date
			FROM
				erp_payments
			INNER JOIN erp_sales ON erp_sales.id = erp_payments.sale_id
			WHERE
				erp_sales.id = NEW.id
			LIMIT 0,
			1
		);
		
		IF v_tran_date = NEW.date THEN
			SET v_tran_no = (
				SELECT
					MAX(tran_no)
				FROM
					erp_gl_trans
			);
		ELSE
			SET v_tran_no = (
				SELECT
					COALESCE (MAX(tran_no), 0) + 1
				FROM
					erp_gl_trans
			);
			
			UPDATE erp_order_ref
			SET tr = v_tran_no
			WHERE
				DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m');


		END IF;
		
		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'SALES',
			v_tran_no,
			NEW.date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(- 1) * abs(
				NEW.total + NEW.product_discount
			),
			NEW.reference_no,
			NEW.note,
			NEW.biller_id,
			NEW.created_by,
			NEW.updated_by
		FROM
			erp_account_settings
		INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_open_balance
		INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
		WHERE
			erp_gl_charts.accountcode = erp_account_settings.default_open_balance;
			
        IF NEW.paid <= 0 THEN
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				   ) SELECT
						'SALES',
						v_tran_no,
						NEW.date,
						erp_gl_sections.sectionid,
						erp_gl_charts.accountcode,
						erp_gl_charts.accountname,
						NEW.grand_total,
						NEW.reference_no,
						NEW.note,
						NEW.biller_id,
						NEW.created_by,
						NEW.updated_by
					FROM
					erp_account_settings
					   INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_account_settings.default_receivable
					   INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
					   WHERE
					erp_gl_charts.accountcode = erp_account_settings.default_receivable;
		END IF;
		
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_sales_delete`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_sales_delete` AFTER DELETE ON `erp_sales` FOR EACH ROW BEGIN

   UPDATE erp_gl_trans SET amount = 0, description = CONCAT(description,' (Cancelled)')
   WHERE reference_no = OLD.reference_no;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_update`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_update` BEFORE UPDATE ON `erp_sales_audit` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_sales_audit (
			id,
			date,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			delivery_status,
			delivery_by,
			created_by,
			updated_by,
			updated_at,
			updated_count,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			type,
			type_id,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			sale_type,
			bill_to,
			po,
			suspend_note,
			tax_type,
			so_id,
			revenues_type,
			acc_cate_separate,
			hide_tax,
			audit_type
		) SELECT 
			id,
			date,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			delivery_status,
			delivery_by,
			created_by,
			updated_by,
			updated_at,
			updated_count,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			type,
			type_id,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			sale_type,
			bill_to,
			po,
			suspend_note,
			tax_type,
			so_id,
			revenues_type,
			acc_cate_separate,
			hide_tax,
			"UPDATED"
		FROM
			erp_sales
		WHERE
			erp_sales.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_delete` BEFORE DELETE ON `erp_sales_audit` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_sales_audit (
			id,
			date,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			delivery_status,
			delivery_by,
			created_by,
			updated_by,
			updated_at,
			updated_count,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			type,
			type_id,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			sale_type,
			bill_to,
			po,
			suspend_note,
			tax_type,
			so_id,
			revenues_type,
			acc_cate_separate,
			hide_tax,
			audit_type
		) SELECT 
			id,
			date,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			delivery_status,
			delivery_by,
			created_by,
			updated_by,
			updated_at,
			updated_count,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			type,
			type_id,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			sale_type,
			bill_to,
			po,
			suspend_note,
			tax_type,
			so_id,
			revenues_type,
			acc_cate_separate,
			hide_tax,
			"DELETED"
		FROM
			erp_sales
		WHERE
			erp_sales.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `gl_trans_sale_items_insert`;
DELIMITER ;;
CREATE TRIGGER `gl_trans_sale_items_insert` AFTER INSERT ON `erp_sale_items` FOR EACH ROW BEGIN

	DECLARE v_tran_no INTEGER;
	DECLARE v_tran_sale_type INTEGER;
	DECLARE v_tran_date DATETIME;
	DECLARE v_tran_reference_no VARCHAR(55);
	DECLARE v_tran_customer VARCHAR(55);
	DECLARE v_tran_biller_id INTEGER;
	DECLARE v_tran_created_by INTEGER;
	DECLARE v_tran_updated_by INTEGER;
	DECLARE v_tax_type INTEGER;
	DECLARE v_order_tax_id INTEGER;
	DECLARE v_sale_type INTEGER;
	DECLARE v_acc_cate_separate INTEGER;
	DECLARE v_tran_note VARCHAR(255);
	DECLARE v_sale_status VARCHAR(50);
	DECLARE v_category_id INTEGER;
	DECLARE v_qoh INTEGER;
	DECLARE v_updated_at DATETIME;
	DECLARE v_product_type VARCHAR(50);
	
	SET v_acc_cate_separate = (SELECT erp_settings.acc_cate_separate FROM erp_settings WHERE erp_settings.setting_id = '1');

	SET v_tran_date = (SELECT erp_sales.date 
			FROM erp_sales
			WHERE erp_sales.id = NEW.sale_id LIMIT 0,1);
			
	SET v_tran_no = (SELECT MAX(tran_no) FROM erp_gl_trans);
	SET v_tran_sale_type = (SELECT erp_sales.sale_type FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_tran_reference_no = (SELECT erp_sales.reference_no FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_tran_customer = (SELECT erp_sales.customer FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_tran_biller_id = (SELECT erp_sales.biller_id FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_tran_created_by = (SELECT erp_sales.created_by FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_tran_updated_by = (SELECT erp_sales.updated_by FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_tran_note = (SELECT erp_sales.note FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_sale_status = (SELECT erp_sales.sale_status FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	SET v_category_id = (SELECT erp_products.category_id FROM erp_products WHERE erp_products.id = NEW.product_id);
	SET v_qoh =  (SELECT erp_products.quantity FROM erp_products WHERE erp_products.id = NEW.product_id);
	SET v_product_type =  (SELECT erp_products.type FROM erp_products WHERE erp_products.id = NEW.product_id);
	SET v_updated_at = (SELECT erp_sales.updated_at FROM erp_sales WHERE erp_sales.id = NEW.sale_id);
	
	IF v_acc_cate_separate = 1 THEN

		INSERT INTO erp_gl_trans (
			tran_type,
			tran_no,
			tran_date,
			sectionid,
			account_code,
			narrative,
			amount,
			reference_no,
			description,
			biller_id,
			created_by,
			updated_by
		) SELECT
			'SALES',
			v_tran_no,
			v_tran_date,
			erp_gl_sections.sectionid,
			erp_gl_charts.accountcode,
			erp_gl_charts.accountname,
			(-1) * abs(NEW.subtotal),
			v_tran_reference_no,
			v_tran_note,
			v_tran_biller_id,
			v_tran_created_by,
			v_tran_updated_by
			FROM
					erp_categories
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_sale
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_category_id;
		
		IF v_sale_status = "completed" AND (NEW.unit_cost * NEW.quantity) > 0 AND v_product_type <> "service" THEN
		
			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'SALES',
				v_tran_no,
				v_tran_date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(NEW.unit_cost * NEW.quantity),
				v_tran_reference_no,
				v_tran_note,
				v_tran_biller_id,
				v_tran_created_by,
				v_tran_updated_by
				FROM
					erp_categories
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_cost
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_category_id;

			INSERT INTO erp_gl_trans (
				tran_type,
				tran_no,
				tran_date,
				sectionid,
				account_code,
				narrative,
				amount,
				reference_no,
				description,
				biller_id,
				created_by,
				updated_by
				) SELECT
				'SALES',
				v_tran_no,
				v_tran_date,
				erp_gl_sections.sectionid,
				erp_gl_charts.accountcode,
				erp_gl_charts.accountname,
				(-1) * abs(NEW.unit_cost * NEW.quantity),
				v_tran_reference_no,
				v_tran_note,
				v_tran_biller_id,
				v_tran_created_by,
				v_tran_updated_by
				FROM
					erp_categories
					INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_categories.ac_stock
					INNER JOIN erp_gl_sections ON erp_gl_sections.sectionid = erp_gl_charts.sectionid
				WHERE
					erp_categories.id = v_category_id;
		END IF;
	END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_items_update`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_items_update` BEFORE UPDATE ON `erp_sale_items` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_sale_items_audit (
			id,
			sale_id,
			category_id,
			product_id,
			product_code,
			product_name,
			product_type,
			option_id,
			net_unit_price,
			unit_price,
			quantity_received,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			subtotal,
			serial_no,
			real_unit_price,
			product_noted,
			returned,
			group_price_id,
			acc_cate_separate,
			specific_tax_on_certain_merchandise_and_services,
			accommodation_tax,
			public_lighting_tax,
			other_tax,
			payment_of_profit_tax,
			performance_royalty_intangible,
			payment_interest_non_bank,
			payment_interest_taxpayer_fixed,
			payment_interest_taxpayer_non_fixed,
			payment_rental_immovable_property,
			payment_of_interest,
			payment_royalty_rental_income_related,
			payment_management_technical,
			payment_dividend,
			withholding_tax_on_resident,
			withholding_tax_on_non_resident,
			audit_type
		) SELECT 
			id,
			sale_id,
			category_id,
			product_id,
			product_code,
			product_name,
			product_type,
			option_id,
			net_unit_price,
			unit_price,
			quantity_received,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			subtotal,
			serial_no,
			real_unit_price,
			product_noted,
			returned,
			group_price_id,
			acc_cate_separate,
			specific_tax_on_certain_merchandise_and_services,
			accommodation_tax,
			public_lighting_tax,
			other_tax,
			payment_of_profit_tax,
			performance_royalty_intangible,
			payment_interest_non_bank,
			payment_interest_taxpayer_fixed,
			payment_interest_taxpayer_non_fixed,
			payment_rental_immovable_property,
			payment_of_interest,
			payment_royalty_rental_income_related,
			payment_management_technical,
			payment_dividend,
			withholding_tax_on_resident,
			withholding_tax_on_non_resident,
			"UPDATED"
		FROM
			erp_sale_items
		WHERE
			erp_sale_items.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_items_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_items_delete` BEFORE DELETE ON `erp_sale_items` FOR EACH ROW BEGIN

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_orders_update`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_orders_update` BEFORE UPDATE ON `erp_sale_order` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_sale_order_audit (
			id,
			date,
			quote_id,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			order_status,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			created_by,
			updated_by,
			updated_at,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			suspend_note,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			delivery_by,
			sale_type,
			delivery_status,
			tax_type,
			bill_to,
			po,
			audit_type
		) SELECT 
			id,
			date,
			quote_id,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			order_status,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			created_by,
			updated_by,
			updated_at,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			suspend_note,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			delivery_by,
			sale_type,
			delivery_status,
			tax_type,
			bill_to,
			po,
			"UPDATED"
		FROM
			erp_sale_order
		WHERE
			erp_sale_order.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_orders_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_orders_delete` BEFORE DELETE ON `erp_sale_order` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_sale_order_audit (
			id,
			date,
			quote_id,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			order_status,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			created_by,
			updated_by,
			updated_at,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			suspend_note,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			delivery_by,
			sale_type,
			delivery_status,
			tax_type,
			bill_to,
			po,
			audit_type
		) SELECT 
			id,
			date,
			quote_id,
			reference_no,
			customer_id,
			customer,
			group_areas_id,
			biller_id,
			biller,
			warehouse_id,
			note,
			staff_note,
			total,
			product_discount,
			order_discount_id,
			total_discount,
			order_discount,
			product_tax,
			order_tax_id,
			order_tax,
			total_tax,
			shipping,
			grand_total,
			order_status,
			sale_status,
			payment_status,
			payment_term,
			due_date,
			created_by,
			updated_by,
			updated_at,
			total_items,
			total_cost,
			pos,
			paid,
			return_id,
			surcharge,
			attachment,
			attachment1,
			attachment2,
			suspend_note,
			other_cur_paid,
			other_cur_paid_rate,
			other_cur_paid1,
			other_cur_paid_rate1,
			saleman_by,
			reference_no_tax,
			tax_status,
			opening_ar,
			delivery_by,
			sale_type,
			delivery_status,
			tax_type,
			bill_to,
			po,
			"DELETED"
		FROM
			erp_sale_order
		WHERE
			erp_sale_order.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_order_items_update`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_order_items_update` BEFORE UPDATE ON `erp_sale_order_items` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_sale_order_items_audit (
			id,
			sale_order_id,
			product_id,
			product_code,
			product_name,
			product_type,
			option_id,
			net_unit_price,
			unit_price,
			quantity_received,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			subtotal,
			serial_no,
			real_unit_price,
			product_noted,
			group_price_id
		) SELECT 
			id,
			sale_order_id,
			product_id,
			product_code,
			product_name,
			product_type,
			option_id,
			net_unit_price,
			unit_price,
			quantity_received,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			subtotal,
			serial_no,
			real_unit_price,
			product_noted,
			group_price_id
		FROM
			erp_sale_order_items
		WHERE
			erp_sale_order_items.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `audit_sales_order_items_delete`;
DELIMITER ;;
CREATE TRIGGER `audit_sales_order_items_delete` BEFORE DELETE ON `erp_sale_order_items` FOR EACH ROW BEGIN
	IF OLD.id THEN
		INSERT INTO erp_sale_order_items_audit (
			id,
			sale_order_id,
			product_id,
			product_code,
			product_name,
			product_type,
			option_id,
			net_unit_price,
			unit_price,
			quantity_received,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			subtotal,
			serial_no,
			real_unit_price,
			product_noted,
			group_price_id
		) SELECT 
			id,
			sale_order_id,
			product_id,
			product_code,
			product_name,
			product_type,
			option_id,
			net_unit_price,
			unit_price,
			quantity_received,
			quantity,
			warehouse_id,
			item_tax,
			tax_rate_id,
			tax,
			discount,
			item_discount,
			subtotal,
			serial_no,
			real_unit_price,
			product_noted,
			group_price_id
		FROM
			erp_sale_order_items
		WHERE
			erp_sale_order_items.id = OLD.id;
	END IF;

END
;;
DELIMITER ;
