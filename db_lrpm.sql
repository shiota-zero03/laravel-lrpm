/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : db_lrpm

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 25/02/2024 03:08:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configs
-- ----------------------------
INSERT INTO `configs` VALUES (2, 'usulan_baru', 1, '2024-02-17 15:04:39', '2024-02-17 15:08:36');

-- ----------------------------
-- Table structure for departments
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fakultas` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `departments_id_fakultas_foreign`(`id_fakultas` ASC) USING BTREE,
  CONSTRAINT `departments_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `faculties` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of departments
-- ----------------------------
INSERT INTO `departments` VALUES (7, 'Akutansi', 2, '2024-02-07 08:48:51', '2024-02-07 08:48:51');
INSERT INTO `departments` VALUES (8, 'Manajemen', 2, '2024-02-07 08:49:01', '2024-02-07 08:49:01');
INSERT INTO `departments` VALUES (9, 'Ilmu Komunikasi', 2, '2024-02-07 08:49:15', '2024-02-07 08:49:15');
INSERT INTO `departments` VALUES (10, 'Sastra Inggris', 2, '2024-02-07 08:49:26', '2024-02-07 08:49:26');
INSERT INTO `departments` VALUES (11, 'Teknik Mesin', 1, '2024-02-17 14:31:37', '2024-02-17 14:31:37');
INSERT INTO `departments` VALUES (12, 'Teknik Elektro', 1, '2024-02-17 14:31:49', '2024-02-17 14:31:49');
INSERT INTO `departments` VALUES (13, 'Teknik Sipil', 1, '2024-02-17 14:32:02', '2024-02-17 14:32:02');
INSERT INTO `departments` VALUES (14, 'Teknik Informatika', 1, '2024-02-17 14:32:11', '2024-02-17 14:32:11');

-- ----------------------------
-- Table structure for faculties
-- ----------------------------
DROP TABLE IF EXISTS `faculties`;
CREATE TABLE `faculties`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_fakultas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of faculties
-- ----------------------------
INSERT INTO `faculties` VALUES (1, 'Fakultas Teknik dan Informatika (FTI)', '2024-02-07 04:32:03', '2024-02-07 04:32:03');
INSERT INTO `faculties` VALUES (2, 'Fakultas Bisnis dan Ilmu Sosial (FBIS)', '2024-02-07 04:32:03', '2024-02-07 04:32:03');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for fbis_evaluations
-- ----------------------------
DROP TABLE IF EXISTS `fbis_evaluations`;
CREATE TABLE `fbis_evaluations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_submission` bigint UNSIGNED NOT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qa1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sa1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qa2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sa2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qa3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sa3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qa4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sa4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qb1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sb1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qb2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sb2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qb3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sb3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qc1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sc1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qc2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sc2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qc3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sc3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qc4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sc4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qd1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sd1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qd2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sd2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qd3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sd3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qd4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sd4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qd5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sd5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qe1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `se1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qe2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `se2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qf1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sf1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qf2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sf2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qg1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sg1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qh1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sh1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qh2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sh2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qh3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sh3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qh4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sh4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `average` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `last_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `grade_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fbis_evaluations_id_submission_foreign`(`id_submission` ASC) USING BTREE,
  CONSTRAINT `fbis_evaluations_id_submission_foreign` FOREIGN KEY (`id_submission`) REFERENCES `submissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fbis_evaluations
-- ----------------------------

-- ----------------------------
-- Table structure for fti_evaluations
-- ----------------------------
DROP TABLE IF EXISTS `fti_evaluations`;
CREATE TABLE `fti_evaluations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_submission` bigint UNSIGNED NOT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `q1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `k1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `q2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `k2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `q3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `k3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `q4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `k4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `q5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `k5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `q6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `k6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `q7` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `k7` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `total` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `average` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `orisinalitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kualitas_teknikal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `metodologi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kejelasan_kalimat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `urgensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `last_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `grade_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fti_evaluations_id_submission_foreign`(`id_submission` ASC) USING BTREE,
  CONSTRAINT `fti_evaluations_id_submission_foreign` FOREIGN KEY (`id_submission`) REFERENCES `submissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fti_evaluations
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2024_02_07_031808_create_positions_table', 2);
INSERT INTO `migrations` VALUES (6, '2024_02_07_031825_create_faculties_table', 2);
INSERT INTO `migrations` VALUES (7, '2024_02_07_031905_create_departments_table', 2);
INSERT INTO `migrations` VALUES (8, '2024_02_07_153535_create_mitra_fundings_table', 3);
INSERT INTO `migrations` VALUES (9, '2024_02_08_024056_create_submissions_table', 4);
INSERT INTO `migrations` VALUES (10, '2024_02_08_030939_create_participants_table', 4);
INSERT INTO `migrations` VALUES (11, '2024_02_08_150050_create_template_documents_table', 5);
INSERT INTO `migrations` VALUES (12, '2024_02_09_224923_create_schemas_table', 6);
INSERT INTO `migrations` VALUES (13, '2024_02_09_230323_create_superior_research_table', 7);
INSERT INTO `migrations` VALUES (16, '2024_02_09_230358_create_outers_table', 7);
INSERT INTO `migrations` VALUES (17, '2024_02_09_230412_create_rabs_table', 7);
INSERT INTO `migrations` VALUES (19, '2024_02_10_000628_create_rab_submissions_table', 8);
INSERT INTO `migrations` VALUES (20, '2024_02_10_091300_create_notifications_table', 9);
INSERT INTO `migrations` VALUES (22, '2024_02_09_230335_create_themes_table', 10);
INSERT INTO `migrations` VALUES (23, '2024_02_09_230341_create_topics_table', 10);
INSERT INTO `migrations` VALUES (24, '2024_02_10_091517_create_timeline_progress_table', 10);
INSERT INTO `migrations` VALUES (25, '2024_02_19_013759_create_fti_evaluations_table', 11);
INSERT INTO `migrations` VALUES (26, '2024_02_19_014354_create_fbis_evaluations_table', 11);

-- ----------------------------
-- Table structure for mitra_fundings
-- ----------------------------
DROP TABLE IF EXISTS `mitra_fundings`;
CREATE TABLE `mitra_fundings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_pendanaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mitra_fundings
-- ----------------------------
INSERT INTO `mitra_fundings` VALUES (1, 'In Cash', '2024-02-07 15:45:35', '2024-02-07 15:45:35');
INSERT INTO `mitra_fundings` VALUES (2, 'In Kind', '2024-02-07 15:45:45', '2024-02-07 15:45:45');

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_jenis` bigint NULL DEFAULT NULL,
  `jenis_notifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `judul_notifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `text_notifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `to_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `to_id` bigint NULL DEFAULT NULL,
  `read_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 226 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for outers
-- ----------------------------
DROP TABLE IF EXISTS `outers`;
CREATE TABLE `outers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_luaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outers
-- ----------------------------
INSERT INTO `outers` VALUES (1, 'Jurnal Internasional Bereputasi', '2024-02-09 23:22:40', '2024-02-12 04:42:12');
INSERT INTO `outers` VALUES (2, 'Jurnal Internasional', '2024-02-09 23:22:46', '2024-02-12 04:42:23');
INSERT INTO `outers` VALUES (4, 'Jurnal Nasional Terakreditasi', '2024-02-12 04:42:32', '2024-02-12 04:42:32');
INSERT INTO `outers` VALUES (5, 'Prosiding Nasional/Internasional', '2024-02-12 04:42:43', '2024-02-12 04:42:43');

-- ----------------------------
-- Table structure for participants
-- ----------------------------
DROP TABLE IF EXISTS `participants`;
CREATE TABLE `participants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_submission` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pendidikan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nidn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fakultas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `program_studi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_sinta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tugas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `participants_id_submission_foreign`(`id_submission` ASC) USING BTREE,
  CONSTRAINT `participants_id_submission_foreign` FOREIGN KEY (`id_submission`) REFERENCES `submissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of participants
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for positions
-- ----------------------------
DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of positions
-- ----------------------------
INSERT INTO `positions` VALUES (1, 'Tenaga Pengajar', '5', '2024-02-07 03:56:31', '2024-02-07 03:56:31');
INSERT INTO `positions` VALUES (2, 'Asisten Ahli', '5', '2024-02-07 03:57:17', '2024-02-07 03:57:17');
INSERT INTO `positions` VALUES (3, 'Lektor', '5', '2024-02-07 03:58:34', '2024-02-07 03:58:34');
INSERT INTO `positions` VALUES (4, 'Lektor Kepala', '5', '2024-02-07 03:59:47', '2024-02-07 03:59:47');
INSERT INTO `positions` VALUES (5, 'Guru Besar', '5', '2024-02-07 04:00:07', '2024-02-07 04:00:07');
INSERT INTO `positions` VALUES (6, 'Staff', '1', '2024-02-07 04:05:09', '2024-02-07 04:05:09');
INSERT INTO `positions` VALUES (7, 'Ka. Biro', '1', '2024-02-07 04:05:20', '2024-02-07 04:05:20');
INSERT INTO `positions` VALUES (8, 'Direktur', '1', '2024-02-07 04:05:31', '2024-02-07 04:05:31');
INSERT INTO `positions` VALUES (13, 'Guru Honor', '5', '2024-02-12 13:11:03', '2024-02-12 13:11:03');
INSERT INTO `positions` VALUES (14, 'Reviewer utama', '2', '2024-02-13 10:34:58', '2024-02-13 10:34:58');
INSERT INTO `positions` VALUES (15, 'Reviewer tambahan', '2', '2024-02-13 10:35:14', '2024-02-13 10:35:14');

-- ----------------------------
-- Table structure for rab_submissions
-- ----------------------------
DROP TABLE IF EXISTS `rab_submissions`;
CREATE TABLE `rab_submissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_submission` bigint UNSIGNED NOT NULL,
  `nama_item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` bigint NOT NULL,
  `volume` int NOT NULL,
  `total` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rab_submissions_id_submission_foreign`(`id_submission` ASC) USING BTREE,
  CONSTRAINT `rab_submissions_id_submission_foreign` FOREIGN KEY (`id_submission`) REFERENCES `submissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rab_submissions
-- ----------------------------

-- ----------------------------
-- Table structure for rabs
-- ----------------------------
DROP TABLE IF EXISTS `rabs`;
CREATE TABLE `rabs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rabs
-- ----------------------------
INSERT INTO `rabs` VALUES (1, 'Bahan baku', '2024-02-09 23:25:27', '2024-02-09 23:25:27');
INSERT INTO `rabs` VALUES (2, 'ATK', '2024-02-09 23:25:36', '2024-02-09 23:25:36');
INSERT INTO `rabs` VALUES (3, 'Analisis Data', '2024-02-09 23:25:47', '2024-02-09 23:25:47');
INSERT INTO `rabs` VALUES (4, 'Pengumpulan Data', '2024-02-09 23:26:01', '2024-02-09 23:26:01');
INSERT INTO `rabs` VALUES (5, 'FGD', '2024-02-09 23:26:11', '2024-02-09 23:26:11');
INSERT INTO `rabs` VALUES (6, 'Publikasi', '2024-02-09 23:26:19', '2024-02-09 23:26:19');
INSERT INTO `rabs` VALUES (7, 'Haki', '2024-02-09 23:26:28', '2024-02-09 23:26:28');
INSERT INTO `rabs` VALUES (8, 'Uji Lab', '2024-02-09 23:26:35', '2024-02-09 23:26:35');

-- ----------------------------
-- Table structure for schemas
-- ----------------------------
DROP TABLE IF EXISTS `schemas`;
CREATE TABLE `schemas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_skema` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of schemas
-- ----------------------------
INSERT INTO `schemas` VALUES (1, 'Internal', '2024-02-09 23:00:23', '2024-02-09 23:00:23');
INSERT INTO `schemas` VALUES (2, 'KDN', '2024-02-09 23:00:31', '2024-02-09 23:00:31');
INSERT INTO `schemas` VALUES (3, 'KLN', '2024-02-09 23:00:38', '2024-02-09 23:00:38');

-- ----------------------------
-- Table structure for submissions
-- ----------------------------
DROP TABLE IF EXISTS `submissions`;
CREATE TABLE `submissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `submission_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengaju` bigint UNSIGNED NOT NULL,
  `nama_mitra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `institusi_mitra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_pendanaan_mitra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_usulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `skema` bigint NULL DEFAULT NULL,
  `judul_usulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `judul_publikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `riset_unggulan` bigint NULL DEFAULT NULL,
  `tema` bigint NULL DEFAULT NULL,
  `topik` bigint NULL DEFAULT NULL,
  `target_luaran` bigint NULL DEFAULT NULL,
  `target_luaran_tambahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `proposal_usulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `laporan_akhir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ppt_laporan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `laporan_final` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `luaran_publikasi` bigint NULL DEFAULT NULL,
  `nama_jurnal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `link_jurnal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `draft_artikel` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status_publikasi_jurnal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipe_submission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `spk_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `spk_download` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `waktu_usulan` datetime NULL DEFAULT NULL,
  `status_usulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_tambahan_usulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alasan_usulan_ditolak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `waktu_proposal` datetime NULL DEFAULT NULL,
  `status_proposal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_tambahan_proposal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alasan_proposal_ditolak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `waktu_spk` datetime NULL DEFAULT NULL,
  `status_spk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alasan_spk_ditolak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `waktu_laporan_akhir` datetime NULL DEFAULT NULL,
  `status_laporan_akhir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_tambahan_laporan_akhir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alasan_laporan_akhir_ditolak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `waktu_monev` datetime NULL DEFAULT NULL,
  `status_monev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alasan_monev_ditolak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_tambahan_monev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `waktu_sidang` datetime NULL DEFAULT NULL,
  `komentar_reviewer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `waktu_laporan_final` datetime NULL DEFAULT NULL,
  `status_laporan_final` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alasan_laporan_final_ditolak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_tambahan_laporan_final` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `waktu_publikasi` datetime NULL DEFAULT NULL,
  `status_publikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alasan_publikasi_ditolak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_submit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_submit` date NULL DEFAULT NULL,
  `dokumen_revision` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_revision` date NULL DEFAULT NULL,
  `dokumen_accepted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_accepted` date NULL DEFAULT NULL,
  `dokumen_publish` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_publish` date NULL DEFAULT NULL,
  `dokumen_rejected` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_rejected` date NULL DEFAULT NULL,
  `review_proposal_by` bigint NULL DEFAULT NULL,
  `review_laporan_akhir_by` bigint NULL DEFAULT NULL,
  `second_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status_akhir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `submissions_id_pengaju_foreign`(`id_pengaju` ASC) USING BTREE,
  CONSTRAINT `submissions_id_pengaju_foreign` FOREIGN KEY (`id_pengaju`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of submissions
-- ----------------------------

-- ----------------------------
-- Table structure for superior_research
-- ----------------------------
DROP TABLE IF EXISTS `superior_research`;
CREATE TABLE `superior_research`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_riset` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of superior_research
-- ----------------------------
INSERT INTO `superior_research` VALUES (1, 'Transformasi Industri Menuju Ekonomi Hijau dan Ekonomi Biru', '2024-02-09 23:12:46', '2024-02-09 23:12:46');
INSERT INTO `superior_research` VALUES (2, 'Inovasi dan Sustainable Engineering', '2024-02-09 23:12:56', '2024-02-09 23:12:56');
INSERT INTO `superior_research` VALUES (3, 'Komputasi Kreatif dan Pemanfaatan Kecerdasan Buatan', '2024-02-09 23:13:08', '2024-02-09 23:13:08');
INSERT INTO `superior_research` VALUES (4, 'Pengembangan Humaniora dan Kewirausahaan Indonesia dalam Globalisasi', '2024-02-09 23:13:18', '2024-02-09 23:13:18');
INSERT INTO `superior_research` VALUES (5, 'Konsolidasi Ketahanan Nasional', '2024-02-09 23:13:29', '2024-02-09 23:13:29');

-- ----------------------------
-- Table structure for template_documents
-- ----------------------------
DROP TABLE IF EXISTS `template_documents`;
CREATE TABLE `template_documents`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cant_delete` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of template_documents
-- ----------------------------
INSERT INTO `template_documents` VALUES (1, 'Formulir Usulan', '1707465687_alur.docx', 1, NULL, '2024-02-09 08:07:45');
INSERT INTO `template_documents` VALUES (2, 'Proposal', NULL, 1, NULL, NULL);
INSERT INTO `template_documents` VALUES (3, 'Laporan Akhir', NULL, 1, NULL, NULL);
INSERT INTO `template_documents` VALUES (4, 'PPT Monev', '', 1, NULL, NULL);
INSERT INTO `template_documents` VALUES (5, 'Form Penilaian FTI', '1707466065_SOAL MATEMATIKA.docx', 1, '2024-02-09 08:01:27', '2024-02-09 08:01:27');
INSERT INTO `template_documents` VALUES (6, 'Form Penilaian FBIS', NULL, 1, NULL, NULL);
INSERT INTO `template_documents` VALUES (7, 'Laporan Final', NULL, 1, NULL, NULL);

-- ----------------------------
-- Table structure for themes
-- ----------------------------
DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_tema` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_riset` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `themes_id_riset_foreign`(`id_riset` ASC) USING BTREE,
  CONSTRAINT `themes_id_riset_foreign` FOREIGN KEY (`id_riset`) REFERENCES `superior_research` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of themes
-- ----------------------------
INSERT INTO `themes` VALUES (1, 'Kemaritiman', 1, '2024-02-12 13:55:18', '2024-02-12 13:55:18');
INSERT INTO `themes` VALUES (2, 'Teknologi dan manajemen lingkungan', 1, '2024-02-12 13:57:54', '2024-02-12 13:57:54');
INSERT INTO `themes` VALUES (3, 'Energi Baru dan Terbarukan', 2, '2024-02-12 13:58:07', '2024-02-12 13:58:07');
INSERT INTO `themes` VALUES (4, 'Sosial Humaniora - Seni Budaya - Pendidikan', 2, '2024-02-12 13:58:20', '2024-02-12 13:58:20');
INSERT INTO `themes` VALUES (5, 'Teknologi Informasi dan Komunikasi', 3, '2024-02-12 13:58:32', '2024-02-12 13:58:32');
INSERT INTO `themes` VALUES (6, 'Sustainable Mobility', 3, '2024-02-12 13:58:47', '2024-02-12 13:58:47');
INSERT INTO `themes` VALUES (7, 'Teknologi pendidikan dan pembelajaran', 3, '2024-02-12 13:58:59', '2024-02-12 13:58:59');
INSERT INTO `themes` VALUES (8, 'Pembangunan dan penguatan sosial budaya', 4, '2024-02-12 13:59:12', '2024-02-12 13:59:12');
INSERT INTO `themes` VALUES (9, 'Penguatan Modal Sosial', 4, '2024-02-12 13:59:24', '2024-02-12 13:59:24');
INSERT INTO `themes` VALUES (10, 'Komunikasi Digital dan Kewirausahaan', 4, '2024-02-12 13:59:36', '2024-02-12 13:59:36');
INSERT INTO `themes` VALUES (11, 'Teknologi pendidikan dan pembelajaran', 4, '2024-02-12 13:59:47', '2024-02-12 13:59:47');
INSERT INTO `themes` VALUES (12, 'Kearifan lokal', 4, '2024-02-12 14:00:02', '2024-02-12 14:00:02');
INSERT INTO `themes` VALUES (13, 'Pengarusutamaan gender dalam pembangunan', 4, '2024-02-12 14:00:17', '2024-02-12 14:00:17');
INSERT INTO `themes` VALUES (14, 'Pertahanan dan Keamanan', 5, '2024-02-12 14:00:29', '2024-02-12 14:00:29');
INSERT INTO `themes` VALUES (15, 'Kebencanaan', 5, '2024-02-12 14:00:42', '2024-02-12 14:00:42');
INSERT INTO `themes` VALUES (16, 'Transportasi', 5, '2024-02-12 14:00:51', '2024-02-12 14:00:51');
INSERT INTO `themes` VALUES (17, 'Pembangunan dan penguatan sosial budaya', 5, '2024-02-12 14:01:03', '2024-02-12 14:01:03');
INSERT INTO `themes` VALUES (18, 'Teknologi dan manajemen lingkungan', 5, '2024-02-12 14:01:15', '2024-02-12 14:01:15');
INSERT INTO `themes` VALUES (19, 'Mitigasi berkelanjutan terhadap bencana alam', 5, '2024-02-12 14:01:27', '2024-02-12 14:01:27');
INSERT INTO `themes` VALUES (20, 'Komunikasi Kebencanaan', 5, '2024-02-12 14:01:38', '2024-02-12 14:01:38');

-- ----------------------------
-- Table structure for timeline_progress
-- ----------------------------
DROP TABLE IF EXISTS `timeline_progress`;
CREATE TABLE `timeline_progress`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_submission` bigint UNSIGNED NOT NULL,
  `judul_progress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `text_progress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status_progress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `timeline_progress_id_submission_foreign`(`id_submission` ASC) USING BTREE,
  CONSTRAINT `timeline_progress_id_submission_foreign` FOREIGN KEY (`id_submission`) REFERENCES `submissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 139 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of timeline_progress
-- ----------------------------

-- ----------------------------
-- Table structure for topics
-- ----------------------------
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_topik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tema` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `topics_id_tema_foreign`(`id_tema` ASC) USING BTREE,
  CONSTRAINT `topics_id_tema_foreign` FOREIGN KEY (`id_tema`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of topics
-- ----------------------------
INSERT INTO `topics` VALUES (2, 'Teknologi konservasi lingkungan maritim', 1, '2024-02-12 14:35:48', '2024-02-12 14:35:48');
INSERT INTO `topics` VALUES (3, 'Eksplorasi nilai-nilai kearifan lokal dalam pengelolaan dan pemanfaatan sumber daya laut dan pesisir.', 1, '2024-02-12 14:36:10', '2024-02-12 14:36:10');
INSERT INTO `topics` VALUES (4, 'Optimalisasi Pemberdayaan dan peningkatan partisipasi penduduk dan inklusi sosial dalam lingkungan kemaritiman.', 1, '2024-02-12 14:36:33', '2024-02-12 14:36:33');
INSERT INTO `topics` VALUES (5, 'Revitalisasi kearifan lokal untuk ketahanan, keluarga dan pelestarian sumber daya kelautan.', 1, '2024-02-12 14:36:48', '2024-02-12 14:36:48');
INSERT INTO `topics` VALUES (6, 'Promosi, Sosialisasi dan Edukasi mengenai transformasi lingkungan kemaritiman kepada tenaga kerja, komunitas, dan penduduk lokal', 1, '2024-02-12 14:37:01', '2024-02-12 14:37:01');
INSERT INTO `topics` VALUES (7, 'Pengembangan kebijakan atau peraturan tentang kegiatan produksi dan konsumsi yang pro lingkungan', 2, '2024-02-12 14:37:15', '2024-02-12 14:37:15');
INSERT INTO `topics` VALUES (8, 'Pengembangan Energi Ramah Lingkungan Melalui Sistem Terintegrasi dan Pengembangan Energi Baru Terbarukan', 3, '2024-02-12 14:37:31', '2024-02-12 14:37:31');
INSERT INTO `topics` VALUES (9, 'Material Baru dan Material Maju', 3, '2024-02-12 14:37:47', '2024-02-12 14:37:47');
INSERT INTO `topics` VALUES (10, 'Pengembangan Kontruksi dan Otomasi Sistem Terintegrasi', 3, '2024-02-12 14:38:00', '2024-02-12 14:38:00');
INSERT INTO `topics` VALUES (11, 'Kemandirian teknologi pembangkit listrik', 3, '2024-02-12 14:38:12', '2024-02-12 14:38:12');
INSERT INTO `topics` VALUES (12, 'Pemenuhan keperluan masyarakat Guna peningkatan kegiatan ekonomi di daerah penghasil sumber EBT', 3, '2024-02-12 14:38:23', '2024-02-12 14:38:23');
INSERT INTO `topics` VALUES (13, 'Carbon Pricing Mechanism dan Carbon Trading', 3, '2024-02-12 14:38:36', '2024-02-12 14:38:36');
INSERT INTO `topics` VALUES (14, 'Promosi, Sosialisasi dan Edukasi mengenai isu krisis energi dan dampaknya terhadap hidup berkelanjutan', 3, '2024-02-12 14:38:46', '2024-02-12 14:38:46');
INSERT INTO `topics` VALUES (15, 'Pariwisata dan Ekonomi Kreatif', 4, '2024-02-12 14:38:58', '2024-02-12 14:38:58');
INSERT INTO `topics` VALUES (16, 'Pendidikan', 4, '2024-02-12 14:39:10', '2024-02-12 14:39:10');
INSERT INTO `topics` VALUES (17, 'Teknologi untuk peningkatan konten TIK', 5, '2024-02-12 14:39:29', '2024-02-12 14:39:29');
INSERT INTO `topics` VALUES (18, 'Pengembangan Infrastruktur TIK', 5, '2024-02-12 14:39:42', '2024-02-12 14:39:42');
INSERT INTO `topics` VALUES (19, 'Pengembangan Sistem / Platform berbasis Open Source', 5, '2024-02-12 14:39:54', '2024-02-12 14:39:54');
INSERT INTO `topics` VALUES (20, 'Sistem informasi berbasis kearifan lokal', 5, '2024-02-12 14:40:04', '2024-02-12 14:40:04');
INSERT INTO `topics` VALUES (21, 'Teknologi untuk data informasi berbagai bentuk kearifan lokal di Indonesia', 5, '2024-02-12 14:40:19', '2024-02-12 14:40:19');
INSERT INTO `topics` VALUES (22, 'Sistem informasi berbasis teknologi pendukung industri mikro berwawasan gender dan berkelanjutan', 5, '2024-02-12 14:40:33', '2024-02-12 14:40:33');
INSERT INTO `topics` VALUES (23, 'Kecakapan Komunikasi dalam Pemanfaatan Teknologi Komputansi Kreatif dan Kecerdasan Buatan untuk Keberdayaan', 5, '2024-02-12 14:40:45', '2024-02-12 14:40:45');
INSERT INTO `topics` VALUES (24, 'Teknologi untuk Peningkatan Konten TIK', 5, '2024-02-12 14:41:07', '2024-02-12 14:41:07');
INSERT INTO `topics` VALUES (25, 'Mobilitas berbasis pengetahuan lokal dan pekerja keluarga untuk industri.', 6, '2024-02-12 14:41:19', '2024-02-12 14:41:19');
INSERT INTO `topics` VALUES (26, 'Mobilitas orang, nilai, dan barang serta implikasinya pada transformasi nilai budaya dan perilaku komsumtif dalam era global.', 6, '2024-02-12 14:41:31', '2024-02-12 14:41:31');
INSERT INTO `topics` VALUES (27, 'Mobilitas pada Perempuan dan Kelompok Rentan sebagai resiliensi dalam sistem dan struktur masyarakat dalam era global', 6, '2024-02-12 14:41:42', '2024-02-12 14:41:42');
INSERT INTO `topics` VALUES (28, 'Inovasi digital dalam kelas pembelajaran bahasa Inggris', 6, '2024-02-12 14:41:57', '2024-02-12 14:41:57');
INSERT INTO `topics` VALUES (29, 'Budaya dalam upaya mencegah dan menangani akibat dari kekerasan, radikalisme, kekerasan berbasis gender, anak, etnisitas, agama, dan identitas lainnya, serta dalam upaya mengembangkan kesejahteraan dan keunggulan prestasi.', 8, '2024-02-12 14:42:08', '2024-02-12 14:42:08');
INSERT INTO `topics` VALUES (30, 'Kewirausahaan, Koperasi dan UMKM', 9, '2024-02-12 14:42:26', '2024-02-12 14:42:26');
INSERT INTO `topics` VALUES (31, 'Ekonomi Digital dan Sustainable Mediapreneurship dalam Ekosistem Masyarakat Digital yang Berdaya', 10, '2024-02-12 14:42:37', '2024-02-12 14:42:37');
INSERT INTO `topics` VALUES (32, 'Teknologi pendidikan dan pembelajaran', 11, '2024-02-12 14:42:54', '2024-02-12 14:43:06');
INSERT INTO `topics` VALUES (33, 'Kajian penerjemahan karya sastra dan non-sastra', 11, '2024-02-12 14:43:19', '2024-02-12 14:43:19');
INSERT INTO `topics` VALUES (34, 'Kearifan Lokal', 12, '2024-02-12 14:43:34', '2024-02-12 14:43:34');
INSERT INTO `topics` VALUES (35, 'Pengarusutamaan gender dalam pembangunan', 13, '2024-02-12 14:43:46', '2024-02-12 14:43:46');
INSERT INTO `topics` VALUES (36, 'Teknologi pendukung hankam', 14, '2024-02-12 14:44:00', '2024-02-12 14:44:00');
INSERT INTO `topics` VALUES (37, 'Teknologi dan manajemen bencana alam, gempa bumi, tsunami, banjir bandang, tanah longsor, kekeringan (kemarau), gunung meletus (fokus di gunung api dengan satu lokasi)', 15, '2024-02-12 14:44:13', '2024-02-12 14:44:13');
INSERT INTO `topics` VALUES (38, 'Teknologi Infrastruktur dan pendukung sistem transportasi', 16, '2024-02-12 14:44:29', '2024-02-12 14:44:29');
INSERT INTO `topics` VALUES (39, 'Corporate Social Responsibility (CSR) dan Tatakelola dan Pemerintahan', 17, '2024-02-12 14:44:40', '2024-02-12 14:44:40');
INSERT INTO `topics` VALUES (40, 'Adaptasi lingkungan terhadap perubahan iklim dan/atau pencemaran.', 18, '2024-02-12 14:44:53', '2024-02-12 14:44:53');
INSERT INTO `topics` VALUES (41, 'Bencana dan kearifan lokal.', 19, '2024-02-12 14:45:07', '2024-02-12 14:45:07');
INSERT INTO `topics` VALUES (42, 'Sistem Komunikasi Kebencanaan dengan Keterlibatan Multi Stakeholder dengan memanfaatkan fasilitas TIK untuk membangun persepsi terhadap risiko kebencanaan, membangun mitigasi dan kesiapsiagaan terhadap bencana untuk hidup berkelanjutan.', 20, '2024-02-12 14:45:18', '2024-02-12 14:45:18');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nidn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jabatan` bigint NULL DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` int NOT NULL,
  `institusi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_sinta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_google_scholar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_scopus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fakultas` bigint NULL DEFAULT NULL,
  `prodi` bigint NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `users_nidn_unique`(`nidn` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrator', '1234567890', 1, NULL, 'admin@example.com', '2024-02-05 10:57:14', '$2y$10$OBvukaiB7g7DJJJYTpkMguiaNReTjIx.DNT.1hNrTP1eDTcEQScZ2', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-05 10:57:14', '2024-02-05 10:57:14');
INSERT INTO `users` VALUES (16, 'Dosen 1', '123456789012', 1, NULL, 'dosen@gmail.com', '2024-02-17 14:33:29', '$2y$12$YP/wmHHi1VefAxBnFJ/.f.kdO/zUTw5utKznDvHuRCnthO.F58/4e', '1234567890', 5, NULL, 'www.sinta.kemdikbud.com', 'scholar.google.com', 'scopus.com', 1, 14, NULL, '2024-02-17 14:33:29', '2024-02-17 14:33:29');
INSERT INTO `users` VALUES (17, 'Prodi', '3516067979', NULL, NULL, 'prodi.informatika@gmail.com', '2024-02-18 00:24:03', '$2y$12$Kse/5wuUqxMHbMQrCjTun.zvExbEqV0DbfUNM8H..eAPGVTos2Ugu', '14839403121', 3, NULL, NULL, NULL, NULL, 1, 14, NULL, '2024-02-18 00:24:03', '2024-02-18 00:24:03');
INSERT INTO `users` VALUES (18, 'reviewer 1', '1234567890987', 14, 'Universitas Indonesia', 'reviewer.1@gmail.com', '2024-02-18 04:26:21', '$2y$12$R.CGUX9Yj3syVoPLpHMBmOXBEW/cfbtKt4N7r3svq/C3V5qLJ0WZi', '1234567899898', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-18 04:26:22', '2024-02-18 04:26:22');
INSERT INTO `users` VALUES (19, 'Reviewer 2', '67812798211', 15, 'Universitas Indonesia', 'reviewer.2@gmail.com', '2024-02-18 04:26:56', '$2y$12$3tNOimqoeHS.Ca1JoBkH4.nEmdiMfuplOxb4xlx7BYC8P9ZdDH.cu', '67897645656788', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-18 04:26:56', '2024-02-18 04:26:56');
INSERT INTO `users` VALUES (20, 'fakultas fti', '5389508275', NULL, NULL, 'fakultas.fti@gmail.com', '2024-02-22 11:12:19', '$2y$12$xEfpPH9X.qfg39QXp3GFxeJ0wmtKu4Rq8oz297z/BpzaCys4KyigC', '0812312312', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-02-22 11:12:19', '2024-02-22 11:12:19');

SET FOREIGN_KEY_CHECKS = 1;
