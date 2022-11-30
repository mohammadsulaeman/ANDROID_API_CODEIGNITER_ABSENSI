/*
 Navicat Premium Data Transfer

 Source Server         : localnode
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : absensi

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 05/01/2022 11:23:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_hadir
-- ----------------------------
DROP TABLE IF EXISTS `tbl_hadir`;
CREATE TABLE `tbl_hadir`  (
  `hadir_id` int NOT NULL AUTO_INCREMENT,
  `hadir_nama` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_phone` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_waktu` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_tanggal` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_photo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_status` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_latitude` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hadir_longitude` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`hadir_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_hadir
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_karyawan`;
CREATE TABLE `tbl_karyawan`  (
  `karyawan_id` int NOT NULL AUTO_INCREMENT,
  `karyawan_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `karyawan_phone` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `karyawan_status` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `karyawan_gender` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `karyawan_email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `karyawan_photo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `karyawan_code` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `karyawan_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `karyawan_lahir` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `karyawan_tempat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `karyawan_token` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `karyawan_ktp` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`karyawan_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 82 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_karyawan
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_news
-- ----------------------------
DROP TABLE IF EXISTS `tbl_news`;
CREATE TABLE `tbl_news`  (
  `id_news` int NOT NULL AUTO_INCREMENT,
  `judul_news` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug_news` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_news` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_post` datetime NOT NULL,
  PRIMARY KEY (`id_news`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_news
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_perijinan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_perijinan`;
CREATE TABLE `tbl_perijinan`  (
  `perijinan_id` int NOT NULL AUTO_INCREMENT,
  `perijinan_nama` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `perijinan_phone` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `perijinan_keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `perijinan_status` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `perijinan_tanggal` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `perijinan_bukti` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `perijinan_waktu` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `perijinan_lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `reponse_kepala` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_kepala` varchar(257) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `perijinan_latitude` float NOT NULL,
  `perijinan_longitude` float NOT NULL,
  PRIMARY KEY (`perijinan_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_perijinan
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_pulang
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pulang`;
CREATE TABLE `tbl_pulang`  (
  `pulang_id` int NOT NULL AUTO_INCREMENT,
  `pulang_nama` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pulang_phone` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pulang_lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pulang_status` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pulang_waktu` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pulang_bukti` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pulang_tanggal` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pulang_latitude` float NOT NULL,
  `pulang_longitude` float NOT NULL,
  PRIMARY KEY (`pulang_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_pulang
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_sakit
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sakit`;
CREATE TABLE `tbl_sakit`  (
  `sakit_id` int NOT NULL AUTO_INCREMENT,
  `sakit_nama` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sakit_phone` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sakit_status` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sakit_lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sakit_tanggal` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sakit_bukti` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sakit_waktu` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sakit_keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sakit_latitude` float NOT NULL,
  `sakit_longitude` float NOT NULL,
  PRIMARY KEY (`sakit_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_sakit
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_setting
-- ----------------------------
DROP TABLE IF EXISTS `tbl_setting`;
CREATE TABLE `tbl_setting`  (
  `id_setting` int NOT NULL AUTO_INCREMENT,
  `namaweb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tagline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `metatext` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `youtube` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `maps` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `working_hour` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_setting`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_setting
-- ----------------------------
INSERT INTO `tbl_setting` VALUES (1, 'PT. Redioro Tunggal Jaya', 'Perusahaan Penyedia Jasa Bidang Teknologi Infomasi', 'https://rtj.co.id/', '<p>sdsddd</p>\r\n', '', 'Berdiri sejak tahun 2014 sebagai perusahaan penyedia layanan di bidang teknologi informasi, PT. Redioro Tunggal Jaya berkomitmen untuk selalu memberikan layanan dan solusi IT yang berkualitas dan terpercaya untuk klien kami. Setelah memulai perjalanan kami di Serpong, Tangerang Selatan, kami telah mengembangkan perusahaan kami, dan kini kami beroperasi dari Bekasi Selatan, tepatnya di Ruko Grand Galaxy Park, sejak tahun 2019. Perusahaan kami beranggotakan orang orang terpilih yang memiliki komitmen, kredibilitas, dan kompetensi yang mampu menunjang visi dan misi kami untuk memberikan layanan IT yang terbaik untuk Anda.\r\n', 'cs@rtj.co.id', '+6285882067855', 'Ruko Grand Galaxy City Blok RGF, Jl. Boulevard Raya No.23, Jaka Setia, Bekasi', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/', 'https://www.youtube.com/', 'logo.png', 'favicon.png', 'Hedi Harsono', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15863.728245778877!2d106.9730739!3d-6.2726643!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x54dbdcfff276409f!2sYPCC%20(Yayasan%20Pelatihan%20Cad%20Cam)%20Accurate!5e0!3m2!1sid!2sid!4v1614616276019!5m2!1sid!2sid\" width=\"100%\" height=\"100%\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'Senin-Jumat (09:00-17:30)', '2021-09-28 18:55:05');

-- ----------------------------
-- Table structure for tbl_support
-- ----------------------------
DROP TABLE IF EXISTS `tbl_support`;
CREATE TABLE `tbl_support`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pendidikan` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fakultas` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `instansi` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hobi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `github` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `portofolio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_support
-- ----------------------------
INSERT INTO `tbl_support` VALUES (1, 'Mohammad Sulaeman', 'Rawa Bambu RT 006 RW 016 NO 73 Kelurahan Harapan Jaya Kecamatan Bekasi Utara', 'Absensi Karyawan adalah sebuah software berbasis mobile android\r\n                                            dengan web service api sebagai monitoring data dari absensi karyawan ini,\r\n                                            yang dibuat sebagai bahan penelitian tugas akhir yang dilakukan,\r\n                                            oleh mohammad sulaeman pada univeristas mercu buana dengan mengambil data pada\r\n                                            PT REDIORO TUNGGAL JAYA yang dimana perusahaan ini\r\n                                            bergerak di bidang penyedian layanan teknologi informasi', '083808182181', 'mohammadsulaeman24@gmail.com', 'Teknik Informatika', 'Ilmu Komputer', 'Universitas Mercu Buana', 'mohammadsulaeman.jpg', 'Jakarta 23 Juni 1998', 'Belajar Bahasa Pemrogaman dan ilmu seputar teknologi informatika', 'mohammadsulaeman', 'mohammadsulaeman.github.io');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` int NOT NULL,
  `role_id` int NOT NULL,
  `date_created` int NOT NULL,
  `jabatan` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pendidikan` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ttl` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_user_access_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_access_menu`;
CREATE TABLE `tbl_user_access_menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user_access_menu
-- ----------------------------
INSERT INTO `tbl_user_access_menu` VALUES (1, 1, 1);
INSERT INTO `tbl_user_access_menu` VALUES (3, 1, 3);
INSERT INTO `tbl_user_access_menu` VALUES (5, 2, 2);
INSERT INTO `tbl_user_access_menu` VALUES (6, 1, 2);
INSERT INTO `tbl_user_access_menu` VALUES (10, 1, 8);
INSERT INTO `tbl_user_access_menu` VALUES (11, 1, 6);
INSERT INTO `tbl_user_access_menu` VALUES (12, 1, 9);
INSERT INTO `tbl_user_access_menu` VALUES (13, 2, 7);
INSERT INTO `tbl_user_access_menu` VALUES (14, 4, 3);
INSERT INTO `tbl_user_access_menu` VALUES (15, 4, 2);
INSERT INTO `tbl_user_access_menu` VALUES (16, 2, 11);
INSERT INTO `tbl_user_access_menu` VALUES (17, 1, 12);
INSERT INTO `tbl_user_access_menu` VALUES (18, 1, 11);

-- ----------------------------
-- Table structure for tbl_user_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_menu`;
CREATE TABLE `tbl_user_menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user_menu
-- ----------------------------
INSERT INTO `tbl_user_menu` VALUES (1, 'admin');
INSERT INTO `tbl_user_menu` VALUES (2, 'USER');
INSERT INTO `tbl_user_menu` VALUES (3, 'MENU');
INSERT INTO `tbl_user_menu` VALUES (6, 'ABSENSI SUPER');
INSERT INTO `tbl_user_menu` VALUES (7, 'ABSENSI MEMBERS');
INSERT INTO `tbl_user_menu` VALUES (8, 'CREATE USERS');
INSERT INTO `tbl_user_menu` VALUES (9, 'NEWS');
INSERT INTO `tbl_user_menu` VALUES (11, 'SUPPORT DAN ABOUT');
INSERT INTO `tbl_user_menu` VALUES (12, 'SETTING');

-- ----------------------------
-- Table structure for tbl_user_role
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_role`;
CREATE TABLE `tbl_user_role`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user_role
-- ----------------------------
INSERT INTO `tbl_user_role` VALUES (1, 'Superadmin');
INSERT INTO `tbl_user_role` VALUES (2, 'Member');

-- ----------------------------
-- Table structure for tbl_user_sub_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_sub_menu`;
CREATE TABLE `tbl_user_sub_menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user_sub_menu
-- ----------------------------
INSERT INTO `tbl_user_sub_menu` VALUES (1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (2, 1, 'Role Access', 'admin/role', 'fas fa-fw fa-universal-access', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (3, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (5, 3, 'Menu Management', 'menu', 'fas fa-fw fa-bars', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (6, 3, 'SubMenu Management', 'menu/submenu', 'fas fa-folder-open', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (9, 6, 'KaryawanSuper', 'Karyawan_Super', 'fas fa-fw fa-user-tie', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (10, 6, 'KehadiranSuper', 'Kehadiran_Super', 'fas fa-fw fa-calendar-check', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (11, 6, 'PerizinanSuper', 'Perizinan_Super', 'fas fa-fw fa-calendar-alt', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (12, 6, 'PulangSuper', 'Pulang_Super', 'fas fa-fw fa-sign-out-alt', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (13, 6, 'SakitSuper', 'Sakit_Super', 'fas fa-fw fa-user-injured', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (14, 7, 'Karyawan', 'Karyawan', 'fas fa-fw fa-user-tie', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (15, 7, 'Kehadiran', 'Kehadiran', 'fas fa-fw fa-calendar-check', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (16, 7, 'Perizinan', 'Perizinan', 'fas fa-fw fa-calendar-alt', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (17, 7, 'Pulang', 'Pulang', 'fas fa-fw fa-sign-out-alt', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (18, 7, 'Sakit', 'Sakit', 'fas fa-fw fa-user-injured', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (19, 8, 'CreateUsers', 'Create_Users', 'fas fa-fw fa-user-plus', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (20, 9, 'News', 'News', 'far fa-fw fa-newspaper', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (22, 11, 'Support', 'Support', 'fas fa-fw fa-user-cog', 1);
INSERT INTO `tbl_user_sub_menu` VALUES (23, 12, 'Setting', 'Setting', 'fas fa-users-cog', 1);

-- ----------------------------
-- Table structure for tbl_user_token
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_token`;
CREATE TABLE `tbl_user_token`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user_token
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
