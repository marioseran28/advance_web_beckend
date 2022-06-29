/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.16-MariaDB : Database - uji_coba
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`uji_coba` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `uji_coba`;

/*Table structure for table `surat_masuk` */

DROP TABLE IF EXISTS `surat_masuk`;

CREATE TABLE `surat_masuk` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `no_surat` varchar(5) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `surat_masuk` */

insert  into `surat_masuk`(`id_surat`,`no_surat`,`deadline`) values (1,'1','2022-06-07'),(2,'2','2022-06-06'),(3,'3','2022-06-09'),(4,'4','2022-06-10'),(5,'6','2022-06-11');

/*Table structure for table `tb_hak_akses_m` */

DROP TABLE IF EXISTS `tb_hak_akses_m`;

CREATE TABLE `tb_hak_akses_m` (
  `id_hak_akses_m` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_hak_akses_m`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `tb_hak_akses_m` */

insert  into `tb_hak_akses_m`(`id_hak_akses_m`,`id_user`,`id_menu`) values (1,1,1),(2,1,6),(3,1,7),(4,2,10),(5,2,11),(6,2,12),(7,3,3),(10,4,14),(11,4,15),(12,4,16);

/*Table structure for table `tb_hak_akses_t` */

DROP TABLE IF EXISTS `tb_hak_akses_t`;

CREATE TABLE `tb_hak_akses_t` (
  `id_hak_akses_t` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_treeview` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_hak_akses_t`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tb_hak_akses_t` */

insert  into `tb_hak_akses_t`(`id_hak_akses_t`,`id_user`,`id_treeview`) values (1,1,2),(2,2,3),(5,4,2);

/*Table structure for table `tb_menu` */

DROP TABLE IF EXISTS `tb_menu`;

CREATE TABLE `tb_menu` (
  `id_menu` tinyint(5) NOT NULL AUTO_INCREMENT,
  `id_treeview` tinyint(5) DEFAULT NULL,
  `nama_menu` varchar(15) DEFAULT NULL,
  `status_aktif` enum('0','1') DEFAULT '1',
  `nama_link` varchar(20) DEFAULT NULL,
  `nama_mn_icon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `tb_menu` */

insert  into `tb_menu`(`id_menu`,`id_treeview`,`nama_menu`,`status_aktif`,`nama_link`,`nama_mn_icon`) values (1,2,'TAMBAH USER','1','tb_user','fa fa-circle-o'),(3,1,'TIMER','1','tb_timer','fa fa-clock-o'),(6,2,'TAMBAH MENU','1','tb_menu','fa fa-circle-o'),(7,2,'TAMBAH TREEVIEW','1','tb_treeview','fa fa-circle-o'),(10,3,'TAMBAH PASIEN','1','tb_pasien','fa fa-circle-o'),(11,3,'PEMERIKSAAN','1','tb_pemeriksaan','fa fa-circle-o'),(12,3,'POLIKLINIK','0','tb_poliklinik','fa fa-circle-o'),(14,2,'HA MENU','1','tb_hak_akses_m','fa fa-circle-o'),(15,2,'HA TREEVIEW','1','tb_hak_akses_t','fa fa-circle-o'),(16,3,'OBAT PASIEN','1','tb_obat','fa fa-circle-o');

/*Table structure for table `tb_obat` */

DROP TABLE IF EXISTS `tb_obat`;

CREATE TABLE `tb_obat` (
  `id_obat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_obat` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_obat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tb_obat` */

insert  into `tb_obat`(`id_obat`,`nama_obat`) values (1,'panadol');

/*Table structure for table `tb_pasien` */

DROP TABLE IF EXISTS `tb_pasien`;

CREATE TABLE `tb_pasien` (
  `id_pasien` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pasien` varchar(10) DEFAULT NULL,
  `alamat_pasien` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_pasien`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tb_pasien` */

insert  into `tb_pasien`(`id_pasien`,`nama_pasien`,`alamat_pasien`) values (1,'verania','bali');

/*Table structure for table `tb_pemeriksaan` */

DROP TABLE IF EXISTS `tb_pemeriksaan`;

CREATE TABLE `tb_pemeriksaan` (
  `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pasien` int(11) DEFAULT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `keterangan` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_pemeriksaan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tb_pemeriksaan` */

insert  into `tb_pemeriksaan`(`id_pemeriksaan`,`id_pasien`,`id_obat`,`keterangan`) values (1,0,0,'sakit flu');

/*Table structure for table `tb_poliklinik` */

DROP TABLE IF EXISTS `tb_poliklinik`;

CREATE TABLE `tb_poliklinik` (
  `id_poli` int(11) NOT NULL AUTO_INCREMENT,
  `nama_poli` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_poli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_poliklinik` */

/*Table structure for table `tb_timer` */

DROP TABLE IF EXISTS `tb_timer`;

CREATE TABLE `tb_timer` (
  `id_timer` smallint(7) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(20) DEFAULT NULL,
  `timer` time DEFAULT NULL,
  PRIMARY KEY (`id_timer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_timer` */

/*Table structure for table `tb_treeview` */

DROP TABLE IF EXISTS `tb_treeview`;

CREATE TABLE `tb_treeview` (
  `id_treeview` tinyint(5) NOT NULL AUTO_INCREMENT,
  `nama_treeview` varchar(15) DEFAULT NULL,
  `status_aktif` enum('0','1') DEFAULT '1',
  `nama_icon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_treeview`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tb_treeview` */

insert  into `tb_treeview`(`id_treeview`,`nama_treeview`,`status_aktif`,`nama_icon`) values (1,'-','1','-'),(2,'DATA MASTER','1','fa fa-archive'),(3,'RUMAH SAKIT','1','fa fa-hospital-o');

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `kode_user` varchar(6) DEFAULT NULL,
  `nama_user` varchar(30) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_hp` varchar(12) DEFAULT NULL,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tgl_pembuatan` date DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id_user`,`kode_user`,`nama_user`,`alamat`,`no_hp`,`username`,`password`,`email`,`tgl_pembuatan`) values (1,'US0001','Verania','Bali','1234','vlystudio','vlystudio','verania@gmail.com','2022-06-06'),(2,'US0002','Lois','Badung','0361','loisvee','loisvee','loisvee@gmail.com','2022-06-05'),(3,'US0003','Sintia','Denpasar','76543','sintia98','sintia98','sintia98@gmail.com','2022-06-09'),(4,'US0004','dasad','dsadsa','32','dfdf','dfdf','fsdfsd','2022-06-17');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
