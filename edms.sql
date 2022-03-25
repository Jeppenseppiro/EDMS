/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : edms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2022-03-25 14:25:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `companies`
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_controller` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES ('1', null, null, 'Premium Megastructures Inc.', 'PMI', '');
INSERT INTO `companies` VALUES ('2', null, null, 'MAC Builders', 'MAC', '');
INSERT INTO `companies` VALUES ('3', null, null, 'Octagon Concrete Solutions', 'OCS', '');
INSERT INTO `companies` VALUES ('4', null, null, 'Obanana', 'OBN', '');
INSERT INTO `companies` VALUES ('5', null, null, 'Premium Capital Holdings Inc.', 'PCHI', '');

-- ----------------------------
-- Table structure for `departments`
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `head` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of departments
-- ----------------------------
INSERT INTO `departments` VALUES ('1', null, null, 'Accounting', '', '');
INSERT INTO `departments` VALUES ('2', null, null, 'Asset Management', '', '');
INSERT INTO `departments` VALUES ('3', null, null, 'Purchasing', '', '');
INSERT INTO `departments` VALUES ('4', null, null, 'Risk Management Group', '', '');
INSERT INTO `departments` VALUES ('5', null, null, 'Systems Development', '', '');

-- ----------------------------
-- Table structure for `document_categories`
-- ----------------------------
DROP TABLE IF EXISTS `document_categories`;
CREATE TABLE `document_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of document_categories
-- ----------------------------
INSERT INTO `document_categories` VALUES ('1', null, null, 'Power\'s of Attorney', 'Active', '2');
INSERT INTO `document_categories` VALUES ('2', null, null, 'Affidavits', 'Active', '2');
INSERT INTO `document_categories` VALUES ('3', null, null, 'Corporate Forms', 'Active', '2');
INSERT INTO `document_categories` VALUES ('4', null, null, 'Lease', 'Active', '2');
INSERT INTO `document_categories` VALUES ('5', null, null, 'Pleadings', 'Active', '2');
INSERT INTO `document_categories` VALUES ('6', null, null, 'Forms', 'Active', '1');
INSERT INTO `document_categories` VALUES ('7', null, null, 'Procedures', 'Active', '1');
INSERT INTO `document_categories` VALUES ('8', null, null, 'Work Instructions', 'Inactive', '1');
INSERT INTO `document_categories` VALUES ('9', null, null, 'Policy', 'Active', '1');
INSERT INTO `document_categories` VALUES ('10', null, null, 'Manual', 'Active', '1');
INSERT INTO `document_categories` VALUES ('11', null, null, 'TO', 'Active', '1');
INSERT INTO `document_categories` VALUES ('12', null, null, 'Memo', 'Active', '1');
INSERT INTO `document_categories` VALUES ('13', null, null, 'User Guidelines', 'Active', '1');

-- ----------------------------
-- Table structure for `document_libraries`
-- ----------------------------
DROP TABLE IF EXISTS `document_libraries`;
CREATE TABLE `document_libraries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `document_number_series` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `revision` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `attachment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `control` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `department` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of document_libraries
-- ----------------------------
INSERT INTO `document_libraries` VALUES ('1', '2022-03-24 14:49:37', '2022-03-24 14:49:37', 'Documented Information Change Request', '6', 'PCHI-CM-CMG-01F1', '1', 'Rev. 0 22/06/21', '1648104577-PurchaseOrder RO PO0002666.pdf', null, '4', '4', '1');

-- ----------------------------
-- Table structure for `document_revisions`
-- ----------------------------
DROP TABLE IF EXISTS `document_revisions`;
CREATE TABLE `document_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `document_library_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revision` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of document_revisions
-- ----------------------------
INSERT INTO `document_revisions` VALUES ('1', '2022-03-24 14:49:37', '2022-03-24 14:49:37', '1', 'Rev. 0 22/06/21', '1648104577-PurchaseOrder RO PO0002666.pdf', '4');
INSERT INTO `document_revisions` VALUES ('2', '2022-03-24 15:24:58', '2022-03-24 15:24:58', '1', 'Rev 1', '1648106698-PurchaseOrder RO PO0002666.pdf', '4');

-- ----------------------------
-- Table structure for `file_uploads`
-- ----------------------------
DROP TABLE IF EXISTS `file_uploads`;
CREATE TABLE `file_uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `request_entry` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `request_entry_history` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_upload` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of file_uploads
-- ----------------------------
INSERT INTO `file_uploads` VALUES ('1', '2022-03-24 19:03:43', '2022-03-24 19:03:43', '1', '1', '1648119823-PurchaseOrder RO PO0003286.pdf', '2', '5');
INSERT INTO `file_uploads` VALUES ('2', '2022-03-24 19:32:31', '2022-03-24 19:32:31', '2', '2', '1648121551-PurchaseOrder RO PO0003286.pdf', '2', '5');
INSERT INTO `file_uploads` VALUES ('3', '2022-03-24 19:38:36', '2022-03-24 19:38:36', '1', '3', '1648121916-PurchaseOrder RO PO0003286.pdf', '1', null);
INSERT INTO `file_uploads` VALUES ('4', '2022-03-24 19:46:11', '2022-03-24 19:46:11', '2', '4', '1648122371-PurchaseOrder RO PO0002666.pdf', '1', null);
INSERT INTO `file_uploads` VALUES ('5', '2022-03-24 20:08:26', '2022-03-24 20:08:26', '3', '5', '1648123706-PurchaseOrder RO PO0002053.pdf', '1', null);
INSERT INTO `file_uploads` VALUES ('6', '2022-03-24 20:10:36', '2022-03-24 20:10:36', '4', '6', '1648123836-PurchaseOrder RO PO0002053.pdf', '1', null);
INSERT INTO `file_uploads` VALUES ('7', '2022-03-24 20:13:01', '2022-03-24 20:13:01', '5', '7', '1648123981-PurchaseOrder RO PO0002053.pdf', '1', null);

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('7', '2022_02_23_071719_create_request_iso_entries_table', '2');
INSERT INTO `migrations` VALUES ('10', '2022_02_23_091901_create_document_categories_table', '3');
INSERT INTO `migrations` VALUES ('11', '2022_02_24_010806_create_companies_table', '3');
INSERT INTO `migrations` VALUES ('12', '2022_02_24_011220_create_departments_table', '3');
INSERT INTO `migrations` VALUES ('13', '2022_02_24_011505_create_request_types_table', '3');
INSERT INTO `migrations` VALUES ('14', '2022_02_26_055355_create_request_entry_statuses_table', '4');
INSERT INTO `migrations` VALUES ('15', '2022_02_26_060132_create_tags_table', '5');
INSERT INTO `migrations` VALUES ('16', '2022_02_27_050434_create_request_iso_entry_histories_table', '6');
INSERT INTO `migrations` VALUES ('17', '2022_02_28_005756_create_document_libraries_table', '7');
INSERT INTO `migrations` VALUES ('18', '2022_03_01_032610_create_file_upload_table', '8');
INSERT INTO `migrations` VALUES ('19', '2022_03_03_022709_create_request_legal_entries_table', '8');
INSERT INTO `migrations` VALUES ('20', '2022_03_16_024720_create_document_revisions_table', '9');
INSERT INTO `migrations` VALUES ('21', '2022_03_18_094751_create_request_iso_copies_table', '10');
INSERT INTO `migrations` VALUES ('22', '2022_03_18_095159_create_request_legal_copies_table', '10');
INSERT INTO `migrations` VALUES ('23', '2022_03_18_104648_create_request_iso_copy_statuses_table', '10');
INSERT INTO `migrations` VALUES ('24', '2022_03_18_104750_create_request_legal_copy_statuses_table', '10');
INSERT INTO `migrations` VALUES ('25', '2022_03_21_133319_create_notifications_table', '11');
INSERT INTO `migrations` VALUES ('26', '2022_03_21_154545_create_request_iso_copy_types_table', '12');
INSERT INTO `migrations` VALUES ('27', '2022_03_22_020651_create_request_copy_histories_table', '13');
INSERT INTO `migrations` VALUES ('28', '2022_03_24_164727_create_positions_table', '14');

-- ----------------------------
-- Table structure for `notifications`
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `request_copy_histories`
-- ----------------------------
DROP TABLE IF EXISTS `request_copy_histories`;
CREATE TABLE `request_copy_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `request_copy_id` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_copy_histories
-- ----------------------------
INSERT INTO `request_copy_histories` VALUES ('1', '2022-03-24 15:21:22', '2022-03-24 15:21:22', '1', 'New request copy', '1', '1', '4');
INSERT INTO `request_copy_histories` VALUES ('2', '2022-03-24 15:22:21', '2022-03-24 15:22:21', '1', 'emailed', '3', '1', '4');
INSERT INTO `request_copy_histories` VALUES ('3', '2022-03-25 10:47:46', '2022-03-25 10:47:46', '1', 'aSas', '3', '1', '5');

-- ----------------------------
-- Table structure for `request_entry_histories`
-- ----------------------------
DROP TABLE IF EXISTS `request_entry_histories`;
CREATE TABLE `request_entry_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `request_iso_entry_id` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_entry_histories
-- ----------------------------
INSERT INTO `request_entry_histories` VALUES ('1', '2022-03-24 19:03:43', '2022-03-24 19:03:43', '1', 'Created new request entry', '1', '2', '5');
INSERT INTO `request_entry_histories` VALUES ('2', '2022-03-24 19:32:31', '2022-03-24 19:32:31', '2', 'Created new request entry', '1', '2', '5');
INSERT INTO `request_entry_histories` VALUES ('3', '2022-03-24 19:38:36', '2022-03-24 19:38:36', '1', 'Created new request entry', '1', '1', '5');
INSERT INTO `request_entry_histories` VALUES ('4', '2022-03-24 19:46:11', '2022-03-24 19:46:11', '2', 'Created new request entry', '1', '1', '5');
INSERT INTO `request_entry_histories` VALUES ('5', '2022-03-24 20:08:26', '2022-03-24 20:08:26', '3', 'Created new request entry', '1', '1', '5');
INSERT INTO `request_entry_histories` VALUES ('6', '2022-03-24 20:10:36', '2022-03-24 20:10:36', '4', 'Created new request entry', '1', '1', '5');
INSERT INTO `request_entry_histories` VALUES ('7', '2022-03-24 20:13:01', '2022-03-24 20:13:01', '5', 'Created new request entry', '1', '1', '5');

-- ----------------------------
-- Table structure for `request_entry_statuses`
-- ----------------------------
DROP TABLE IF EXISTS `request_entry_statuses`;
CREATE TABLE `request_entry_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_entry_statuses
-- ----------------------------
INSERT INTO `request_entry_statuses` VALUES ('1', null, null, 'New Request', '1');
INSERT INTO `request_entry_statuses` VALUES ('2', null, null, 'Endorsed', '1');
INSERT INTO `request_entry_statuses` VALUES ('3', null, null, 'Further Review', '1');
INSERT INTO `request_entry_statuses` VALUES ('4', null, null, 'Approved', '1');
INSERT INTO `request_entry_statuses` VALUES ('5', null, null, 'Disapproved', '1');
INSERT INTO `request_entry_statuses` VALUES ('6', null, null, 'For Fine-tuning', '1');
INSERT INTO `request_entry_statuses` VALUES ('7', null, null, 'New Request', '2');
INSERT INTO `request_entry_statuses` VALUES ('8', null, null, 'Under Review', '2');
INSERT INTO `request_entry_statuses` VALUES ('9', null, null, 'For Printing', '2');
INSERT INTO `request_entry_statuses` VALUES ('10', null, null, 'For Pick-up', '2');
INSERT INTO `request_entry_statuses` VALUES ('11', null, null, 'For Notarization', '2');
INSERT INTO `request_entry_statuses` VALUES ('12', null, null, 'Submitted', '2');
INSERT INTO `request_entry_statuses` VALUES ('13', null, null, 'Forwarded to Holdings', '2');

-- ----------------------------
-- Table structure for `request_iso_copies`
-- ----------------------------
DROP TABLE IF EXISTS `request_iso_copies`;
CREATE TABLE `request_iso_copies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_request` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_library_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copy_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_iso_copies
-- ----------------------------
INSERT INTO `request_iso_copies` VALUES ('1', '2022-03-24 15:21:22', '2022-03-24 15:21:22', 'OCBFGN', '4', '24 March, 2022', '1', '1', null);

-- ----------------------------
-- Table structure for `request_iso_copy_statuses`
-- ----------------------------
DROP TABLE IF EXISTS `request_iso_copy_statuses`;
CREATE TABLE `request_iso_copy_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_iso_copy_statuses
-- ----------------------------
INSERT INTO `request_iso_copy_statuses` VALUES ('1', null, null, 'New');
INSERT INTO `request_iso_copy_statuses` VALUES ('2', null, null, 'Open');
INSERT INTO `request_iso_copy_statuses` VALUES ('3', null, null, 'Emailed');
INSERT INTO `request_iso_copy_statuses` VALUES ('4', null, null, 'Printed');
INSERT INTO `request_iso_copy_statuses` VALUES ('5', null, null, 'Closed');

-- ----------------------------
-- Table structure for `request_iso_copy_types`
-- ----------------------------
DROP TABLE IF EXISTS `request_iso_copy_types`;
CREATE TABLE `request_iso_copy_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_iso_copy_types
-- ----------------------------
INSERT INTO `request_iso_copy_types` VALUES ('1', null, null, 'Soft Copy');
INSERT INTO `request_iso_copy_types` VALUES ('2', null, null, 'Hard Copy');

-- ----------------------------
-- Table structure for `request_iso_entries`
-- ----------------------------
DROP TABLE IF EXISTS `request_iso_entries`;
CREATE TABLE `request_iso_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_request` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dicr_no` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestor_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proposed_effective_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_to_revise` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_purpose_request` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_iso_entries
-- ----------------------------
INSERT INTO `request_iso_entries` VALUES ('1', '2022-03-24 19:38:36', '2022-03-24 19:38:36', '24 March, 2022', '2022-000001', '5', 'asdasd', '24 March, 2022', '1', null, '6', null, 'asdasdas', '1');
INSERT INTO `request_iso_entries` VALUES ('2', '2022-03-24 19:46:11', '2022-03-24 19:46:11', '24 March, 2022', '2022-000002', '5', 'asdasd', '24 March, 2022', '2', null, '6', '1', 'asdasdasdasd', '1');
INSERT INTO `request_iso_entries` VALUES ('3', '2022-03-24 20:08:26', '2022-03-24 20:08:26', '24 March, 2022', '2022-000003', '5', 'Document Title', '24 March, 2022', '1', null, '6', null, 'Purpose of Documentation Request', '1');
INSERT INTO `request_iso_entries` VALUES ('4', '2022-03-24 20:10:36', '2022-03-24 20:10:36', '24 March, 2022', '2022-000004', '5', 'asd', '24 March, 2022', '3', null, '6', '1', 'asdasdasdas', '1');
INSERT INTO `request_iso_entries` VALUES ('5', '2022-03-24 20:13:01', '2022-03-24 20:13:01', '24 March, 2022', '2022-000005', '5', 'asdasd', '24 March, 2022', '1', null, '6', null, 'sdadasdasdasda', '1');

-- ----------------------------
-- Table structure for `request_legal_copies`
-- ----------------------------
DROP TABLE IF EXISTS `request_legal_copies`;
CREATE TABLE `request_legal_copies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_request` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_needed` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_return` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_library_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copy_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_legal_copies
-- ----------------------------

-- ----------------------------
-- Table structure for `request_legal_copy_statuses`
-- ----------------------------
DROP TABLE IF EXISTS `request_legal_copy_statuses`;
CREATE TABLE `request_legal_copy_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_legal_copy_statuses
-- ----------------------------

-- ----------------------------
-- Table structure for `request_legal_entries`
-- ----------------------------
DROP TABLE IF EXISTS `request_legal_entries`;
CREATE TABLE `request_legal_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_request` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestor_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_legal_entries
-- ----------------------------
INSERT INTO `request_legal_entries` VALUES ('1', '2022-03-24 19:03:43', '2022-03-24 19:03:43', '24 March, 2022', '5', '1', '1648119823-PurchaseOrder RO PO0003286.pdf', '1', 'ASDASDASDASDASD');
INSERT INTO `request_legal_entries` VALUES ('2', '2022-03-24 19:32:31', '2022-03-24 19:32:31', '24 March, 2022', '5', '2', '1648121551-PurchaseOrder RO PO0003286.pdf', '1', 'asdasdasda');

-- ----------------------------
-- Table structure for `request_types`
-- ----------------------------
DROP TABLE IF EXISTS `request_types`;
CREATE TABLE `request_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of request_types
-- ----------------------------
INSERT INTO `request_types` VALUES ('1', null, null, 'New');
INSERT INTO `request_types` VALUES ('2', null, null, 'Revision');
INSERT INTO `request_types` VALUES ('3', null, null, 'Discontinuance');
INSERT INTO `request_types` VALUES ('4', null, null, 'Obsolete');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', null, null, 'Administrator', '');
INSERT INTO `roles` VALUES ('2', null, null, 'Requestor', '');
INSERT INTO `roles` VALUES ('3', null, null, 'Document Control Officer', '');
INSERT INTO `roles` VALUES ('4', null, null, 'Business Process Manager', '');
INSERT INTO `roles` VALUES ('5', null, null, 'Immediate Head', '');

-- ----------------------------
-- Table structure for `tags`
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('1', null, null, 'ISO');
INSERT INTO `tags` VALUES ('2', null, null, 'Legal');
INSERT INTO `tags` VALUES ('3', null, null, 'Others');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `department` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Quinn Jeysen Nigel Cagara', 'jeffjurolan990@gmail.com', null, '$2y$10$iy3asifZnJfO3mqwiE49luoBgYYiNM6AbtycTQrZSbTfCpsjVsUL2', '4', '4', null, '3', 't7nOno3rDSJoS12wjguzc4XHkiZnjDBkYoftiKZRyFkLcJH5VZYtsqBWO9os', '2022-02-11 03:35:05', '2022-02-11 03:35:05');
INSERT INTO `users` VALUES ('4', 'Jeff Cefiro Jurolan', 'jcjurolan@premiummegastructures.com', null, '$2y$10$SVryrqTxTa8wc2rdA1.Rwu6KWMerqhcCx0g.yH.eK3ySE9kKlEcc.', '4', '5', null, '1', 's3IPKy6s1NuyNIbJmdAScC8Dn6fWpg8Ie3jQmPWQjmHtRBJzJffHVtupxxmk', '2022-03-21 08:31:48', '2022-03-21 08:31:48');
INSERT INTO `users` VALUES ('5', 'Renz Christian Cabato', 'jeffjurolan990@yahoo.com', null, '$2y$10$pcAo4RPWIGzqDZWLS19CLO8ngaY608YE6rK9lPYbFYTwGuRfl.kTO', '4', '5', null, '2', null, '2022-03-24 17:26:32', '2022-03-24 17:26:32');
