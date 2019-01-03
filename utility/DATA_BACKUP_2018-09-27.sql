CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ci_sessions VALUES("95d5614a9b55423334515e19990f34e0","::1","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36","1538019502","a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";}");
INSERT INTO ci_sessions VALUES("9408ba0d61de6a5b932747ade4af5caa","::1","Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/7.0.185.1002 Sa","1538020517","a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";}");


CREATE TABLE `jns_akun` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kd_aktiva` varchar(5) DEFAULT NULL,
  `jns_trans` varchar(50) NOT NULL,
  `akun` enum('Aktiva','Pasiva') DEFAULT NULL,
  `laba_rugi` enum('','PENDAPATAN','BIAYA') NOT NULL DEFAULT '',
  `pemasukan` enum('Y','N') DEFAULT NULL,
  `pengeluaran` enum('Y','N') DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kd_aktiva` (`kd_aktiva`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

INSERT INTO jns_akun VALUES("5","A4","Piutang Usaha","Aktiva","","Y","Y","Y");
INSERT INTO jns_akun VALUES("6","A5","Piutang Karyawan","Aktiva","","N","Y","N");
INSERT INTO jns_akun VALUES("7","A6","Pinjaman Anggota","Aktiva","","","","Y");
INSERT INTO jns_akun VALUES("8","A7","Piutang Anggota","Aktiva","","Y","Y","N");
INSERT INTO jns_akun VALUES("9","A8","Persediaan Barang","Aktiva","","N","Y","Y");
INSERT INTO jns_akun VALUES("10","A9","Biaya Dibayar Dimuka","Aktiva","","N","Y","Y");
INSERT INTO jns_akun VALUES("11","A10","Perlengkapan Usaha","Aktiva","","N","Y","Y");
INSERT INTO jns_akun VALUES("17","C","Aktiva Tetap Berwujud","Aktiva","","","","Y");
INSERT INTO jns_akun VALUES("18","C1","Peralatan Kantor","Aktiva","","N","Y","Y");
INSERT INTO jns_akun VALUES("19","C2","Inventaris Kendaraan","Aktiva","","N","Y","Y");
INSERT INTO jns_akun VALUES("20","C3","Mesin","Aktiva","","N","Y","Y");
INSERT INTO jns_akun VALUES("21","C4","Aktiva Tetap Lainnya","Aktiva","","Y","N","Y");
INSERT INTO jns_akun VALUES("26","E","Modal Pribadi","Aktiva","","","","N");
INSERT INTO jns_akun VALUES("27","E1","Prive","Aktiva","","Y","Y","N");
INSERT INTO jns_akun VALUES("28","F","Utang","Pasiva","","","","Y");
INSERT INTO jns_akun VALUES("29","F1","Utang Usaha","Pasiva","","Y","Y","Y");
INSERT INTO jns_akun VALUES("31","K3","Pengeluaran Lainnya","Aktiva","","N","Y","N");
INSERT INTO jns_akun VALUES("32","F4","Simpanan Sukarela","Pasiva","","","","Y");
INSERT INTO jns_akun VALUES("33","F5","Utang Pajak","Pasiva","","Y","Y","Y");
INSERT INTO jns_akun VALUES("36","H","Utang Jangka Panjang","Pasiva","","","","Y");
INSERT INTO jns_akun VALUES("37","H1","Utang Bank","Pasiva","","Y","Y","Y");
INSERT INTO jns_akun VALUES("38","H2","Obligasi","Pasiva","","Y","Y","N");
INSERT INTO jns_akun VALUES("39","I","Modal","Pasiva","","","","Y");
INSERT INTO jns_akun VALUES("40","I1","Simpanan Pokok","Pasiva","","","","Y");
INSERT INTO jns_akun VALUES("41","I2","Simpanan Wajib","Pasiva","","","","Y");
INSERT INTO jns_akun VALUES("42","I3","Modal Awal","Pasiva","","Y","Y","Y");
INSERT INTO jns_akun VALUES("43","I4","Modal Penyertaan","Pasiva","","Y","Y","N");
INSERT INTO jns_akun VALUES("44","I5","Modal Sumbangan","Pasiva","","Y","Y","Y");
INSERT INTO jns_akun VALUES("45","I6","Modal Cadangan","Pasiva","","Y","Y","Y");
INSERT INTO jns_akun VALUES("47","J","Pendapatan","Pasiva","PENDAPATAN","","","Y");
INSERT INTO jns_akun VALUES("48","J1","Pembayaran Angsuran","Pasiva","","","","Y");
INSERT INTO jns_akun VALUES("49","J2","Pendapatan Lainnya","Pasiva","PENDAPATAN","Y","N","Y");
INSERT INTO jns_akun VALUES("50","K","Beban","Aktiva","","","","Y");
INSERT INTO jns_akun VALUES("52","K2","Beban Gaji Karyawan","Aktiva","BIAYA","N","Y","Y");
INSERT INTO jns_akun VALUES("53","K3","Biaya Listrik dan Air","Aktiva","BIAYA","N","Y","Y");
INSERT INTO jns_akun VALUES("54","K4","Biaya Transportasi","Aktiva","BIAYA","N","Y","Y");
INSERT INTO jns_akun VALUES("60","K10","Biaya Lainnya","Aktiva","BIAYA","N","Y","Y");
INSERT INTO jns_akun VALUES("110","TRF","Transfer Antar Kas","","","","","N");
INSERT INTO jns_akun VALUES("111","A11","Permisalan","Aktiva","","Y","Y","Y");



CREATE TABLE `jns_angsuran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ket` int(11) NOT NULL,
  `aktif` enum('Y','T','','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO jns_angsuran VALUES("1","1","Y");
INSERT INTO jns_angsuran VALUES("2","3","Y");
INSERT INTO jns_angsuran VALUES("3","6","Y");
INSERT INTO jns_angsuran VALUES("4","18","Y");
INSERT INTO jns_angsuran VALUES("11","24","Y");
INSERT INTO jns_angsuran VALUES("12","36","Y");
INSERT INTO jns_angsuran VALUES("13","5","Y");



CREATE TABLE `jns_simpan` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `jns_simpan` varchar(30) NOT NULL,
  `jumlah` double NOT NULL,
  `tampil` enum('Y','T') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

INSERT INTO jns_simpan VALUES("32","Simpanan Sukarela","0","Y");
INSERT INTO jns_simpan VALUES("40","Simpanan Pokok","100000","Y");
INSERT INTO jns_simpan VALUES("41","Simpanan Wajib","50000","Y");


CREATE TABLE `nama_kas_tbl` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(225) CHARACTER SET latin1 NOT NULL,
  `aktif` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_simpan` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_penarikan` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_pinjaman` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_bayar` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_pemasukan` enum('Y','T') NOT NULL,
  `tmpl_pengeluaran` enum('Y','T') NOT NULL,
  `tmpl_transfer` enum('Y','T') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO nama_kas_tbl VALUES("1","Kas Tunai","Y","Y","Y","Y","Y","Y","Y","Y");
INSERT INTO nama_kas_tbl VALUES("2","Kas Besar","Y","T","T","Y","T","Y","Y","Y");
INSERT INTO nama_kas_tbl VALUES("3","Bank BNI","Y","T","T","T","T","Y","Y","Y");


CREATE TABLE `pekerjaan` (
  `id_kerja` varchar(5) NOT NULL,
  `jenis_kerja` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO pekerjaan VALUES("1","TNI");
INSERT INTO pekerjaan VALUES("2","PNS");
INSERT INTO pekerjaan VALUES("3","Karyawan Swasta");
INSERT INTO pekerjaan VALUES("4","Guru");
INSERT INTO pekerjaan VALUES("5","Buruh");
INSERT INTO pekerjaan VALUES("6","Tani");
INSERT INTO pekerjaan VALUES("7","Pedagang");
INSERT INTO pekerjaan VALUES("8","Wiraswasta");
INSERT INTO pekerjaan VALUES("9","Mengurus Rumah Tangga");
INSERT INTO pekerjaan VALUES("99","Lainnya");
INSERT INTO pekerjaan VALUES("98","Pensiunan");
INSERT INTO pekerjaan VALUES("97","Penjahit");


CREATE TABLE `suku_bunga` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `opsi_key` varchar(20) NOT NULL,
  `opsi_val` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO suku_bunga VALUES("1","bg_tab","0");
INSERT INTO suku_bunga VALUES("2","bg_pinjam","2");
INSERT INTO suku_bunga VALUES("3","biaya_adm","1500");
INSERT INTO suku_bunga VALUES("4","denda","1000");
INSERT INTO suku_bunga VALUES("5","denda_hari","15");
INSERT INTO suku_bunga VALUES("6","dana_cadangan","40");
INSERT INTO suku_bunga VALUES("7","jasa_anggota","40");
INSERT INTO suku_bunga VALUES("8","dana_pengurus","5");
INSERT INTO suku_bunga VALUES("9","dana_karyawan","5");
INSERT INTO suku_bunga VALUES("10","dana_pend","5");
INSERT INTO suku_bunga VALUES("11","dana_sosial","5");
INSERT INTO suku_bunga VALUES("12","jasa_usaha","70");
INSERT INTO suku_bunga VALUES("13","jasa_modal","30");
INSERT INTO suku_bunga VALUES("14","pjk_pph","5");
INSERT INTO suku_bunga VALUES("15","pinjaman_bunga_tipe","A");


CREATE TABLE `tbl_anggota` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 NOT NULL,
  `identitas` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tmp_lahir` varchar(225) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `status` varchar(30) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` text CHARACTER SET latin1 NOT NULL,
  `kota` varchar(255) NOT NULL,
  `notelp` varchar(12) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `jabatan_id` int(10) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `pass_word` varchar(225) NOT NULL,
  `file_pic` varchar(225) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identitas` (`identitas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tbl_barang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nm_barang` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `jml_brg` int(11) NOT NULL,
  `ket` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO tbl_barang VALUES("1","Lemari Es","Elektronik","Toshiba","500000","4","");
INSERT INTO tbl_barang VALUES("2","Komputer","K300 Corei3","Asus","5000000","4","");
INSERT INTO tbl_barang VALUES("3","Kompor Gas","Tr675000","Rinai","100000","7","");
INSERT INTO tbl_barang VALUES("4","Pinjaman Uang","Uang","-","0","0","");


CREATE TABLE `tbl_pengajuan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_ajuan` int(11) NOT NULL,
  `ajuan_id` varchar(255) NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `lama_ags` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `tgl_cair` date NOT NULL,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`anggota_id`),
  CONSTRAINT `tbl_pengajuan_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `tbl_pinjaman_d` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_bayar` datetime NOT NULL,
  `pinjam_id` bigint(20) NOT NULL,
  `angsuran_ke` bigint(20) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `denda_rp` int(11) NOT NULL,
  `terlambat` int(11) NOT NULL,
  `ket_bayar` enum('Angsuran','Pelunasan','Bayar Denda') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kas_id` (`kas_id`),
  KEY `user_name` (`user_name`),
  KEY `pinjam_id` (`pinjam_id`),
  KEY `jns_trans` (`jns_trans`),
  CONSTRAINT `tbl_pinjaman_d_ibfk_1` FOREIGN KEY (`pinjam_id`) REFERENCES `tbl_pinjaman_h` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_pinjaman_d_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pinjaman_d_ibfk_3` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON DELETE CASCADE,
  CONSTRAINT `tbl_pinjaman_d_ibfk_4` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `tbl_pinjaman_h` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_pinjam` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `barang_id` bigint(20) NOT NULL,
  `lama_angsuran` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bunga` float(10,2) NOT NULL,
  `biaya_adm` int(11) NOT NULL,
  `lunas` enum('Belum','Lunas') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `contoh` int(23) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `anggota_id` (`anggota_id`),
  KEY `kas_id` (`kas_id`),
  KEY `user_name` (`user_name`),
  KEY `jns_trans` (`jns_trans`),
  KEY `barang_id` (`barang_id`),
  CONSTRAINT `tbl_pinjaman_h_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pinjaman_h_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pinjaman_h_ibfk_3` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pinjaman_h_ibfk_4` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pinjaman_h_ibfk_5` FOREIGN KEY (`barang_id`) REFERENCES `tbl_barang` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tbl_setting` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `opsi_key` varchar(255) NOT NULL,
  `opsi_val` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO tbl_setting VALUES("1","nama_lembaga","KOPERASI MITRA USAHA BERDIKARI");
INSERT INTO tbl_setting VALUES("2","nama_ketua","BAMBANG ");
INSERT INTO tbl_setting VALUES("3","hp_ketua","08123235468");
INSERT INTO tbl_setting VALUES("4","alamat","Jl. Jati Padang Raya ");
INSERT INTO tbl_setting VALUES("5","telepon","021-123456789");
INSERT INTO tbl_setting VALUES("6","kota","DKI Jakarta");
INSERT INTO tbl_setting VALUES("7","email","mub_koperasi@gmail.com");
INSERT INTO tbl_setting VALUES("8","web","mub-koperasi.blogspot.com");



DROP TABLE tbl_trans_kas;

CREATE TABLE `tbl_trans_kas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_catat` datetime NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Pemasukan','Pengeluaran','Transfer') NOT NULL,
  `dari_kas_id` bigint(20) DEFAULT NULL,
  `untuk_kas_id` bigint(20) DEFAULT NULL,
  `jns_trans` bigint(20) DEFAULT NULL,
  `dk` enum('D','K') DEFAULT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_name` (`user_name`),
  KEY `dari_kas_id` (`dari_kas_id`,`untuk_kas_id`),
  KEY `untuk_kas_id` (`untuk_kas_id`),
  KEY `jns_trans` (`jns_trans`),
  CONSTRAINT `tbl_trans_kas_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_trans_kas_ibfk_3` FOREIGN KEY (`dari_kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_trans_kas_ibfk_4` FOREIGN KEY (`untuk_kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_trans_kas_ibfk_5` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE tbl_trans_sp;

CREATE TABLE `tbl_trans_sp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_transaksi` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `jenis_id` int(5) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Setoran','Penarikan') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `nama_penyetor` varchar(255) NOT NULL,
  `no_identitas` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `anggota_id` (`anggota_id`),
  KEY `jenis_id` (`jenis_id`),
  KEY `kas_id` (`kas_id`),
  KEY `user_name` (`user_name`),
  CONSTRAINT `tbl_trans_sp_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_trans_sp_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_trans_sp_ibfk_4` FOREIGN KEY (`jenis_id`) REFERENCES `jns_simpan` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_trans_sp_ibfk_5` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE tbl_user;

CREATE TABLE `tbl_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(255) NOT NULL,
  `pass_word` varchar(255) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `level` enum('admin','operator','pinjaman') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_name` (`u_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO tbl_user VALUES("1","admin","224bec3dd08832bc6a69873f15a50df406045f40","Y","admin");
INSERT INTO tbl_user VALUES("4","user","e22b7d59cb35d199ab7e54ed0f2ef58f5da5347b","Y","operator");
INSERT INTO tbl_user VALUES("5","pinjaman","efd2770f6782f7218be595baf2fc16bc7cf45143","Y","pinjaman");



DROP TABLE v_hitung_pinjaman;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hitung_pinjaman` AS select `tbl_pinjaman_h`.`id` AS `id`,`tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`,`tbl_pinjaman_h`.`anggota_id` AS `anggota_id`,`tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`,`tbl_pinjaman_h`.`jumlah` AS `jumlah`,`tbl_pinjaman_h`.`bunga` AS `bunga`,`tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`,`tbl_pinjaman_h`.`lunas` AS `lunas`,`tbl_pinjaman_h`.`dk` AS `dk`,`tbl_pinjaman_h`.`kas_id` AS `kas_id`,`tbl_pinjaman_h`.`user_name` AS `user_name`,(`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) AS `pokok_angsuran`,round(ceiling((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100)),-(2)) AS `bunga_pinjaman`,round(ceiling((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),-(2)) AS `ags_per_bulan`,(`tbl_pinjaman_h`.`tgl_pinjam` + interval `tbl_pinjaman_h`.`lama_angsuran` month) AS `tempo`,(round(ceiling((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),-(2)) * `tbl_pinjaman_h`.`lama_angsuran`) AS `tagihan`,`tbl_pinjaman_h`.`keterangan` AS `keterangan`,`tbl_pinjaman_h`.`barang_id` AS `barang_id`,ifnull(max(`tbl_pinjaman_d`.`angsuran_ke`),0) AS `bln_sudah_angsur` from (`tbl_pinjaman_h` left join `tbl_pinjaman_d` on((`tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id`))) group by `tbl_pinjaman_h`.`id`;




DROP TABLE v_transaksi;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_transaksi` AS select 'A' AS `tbl`,`tbl_pinjaman_h`.`id` AS `id`,`tbl_pinjaman_h`.`tgl_pinjam` AS `tgl`,`tbl_pinjaman_h`.`jumlah` AS `kredit`,0 AS `debet`,`tbl_pinjaman_h`.`kas_id` AS `dari_kas`,NULL AS `untuk_kas`,`tbl_pinjaman_h`.`jns_trans` AS `transaksi`,`tbl_pinjaman_h`.`keterangan` AS `ket`,`tbl_pinjaman_h`.`user_name` AS `user` from `tbl_pinjaman_h` union select 'B' AS `tbl`,`tbl_pinjaman_d`.`id` AS `id`,`tbl_pinjaman_d`.`tgl_bayar` AS `tgl`,0 AS `kredit`,`tbl_pinjaman_d`.`jumlah_bayar` AS `debet`,NULL AS `dari_kas`,`tbl_pinjaman_d`.`kas_id` AS `untuk_kas`,`tbl_pinjaman_d`.`jns_trans` AS `transaksi`,`tbl_pinjaman_d`.`keterangan` AS `ket`,`tbl_pinjaman_d`.`user_name` AS `user` from `tbl_pinjaman_d` union select 'C' AS `tbl`,`tbl_trans_sp`.`id` AS `id`,`tbl_trans_sp`.`tgl_transaksi` AS `tgl`,if((`tbl_trans_sp`.`dk` = 'K'),`tbl_trans_sp`.`jumlah`,0) AS `kredit`,if((`tbl_trans_sp`.`dk` = 'D'),`tbl_trans_sp`.`jumlah`,0) AS `debet`,if((`tbl_trans_sp`.`dk` = 'K'),`tbl_trans_sp`.`kas_id`,NULL) AS `dari_kas`,if((`tbl_trans_sp`.`dk` = 'D'),`tbl_trans_sp`.`kas_id`,NULL) AS `untuk_kas`,`tbl_trans_sp`.`jenis_id` AS `transaksi`,`tbl_trans_sp`.`keterangan` AS `ket`,`tbl_trans_sp`.`user_name` AS `user` from `tbl_trans_sp` union select 'D' AS `tbl`,`tbl_trans_kas`.`id` AS `id`,`tbl_trans_kas`.`tgl_catat` AS `tgl`,if((`tbl_trans_kas`.`dk` = 'K'),`tbl_trans_kas`.`jumlah`,if(isnull(`tbl_trans_kas`.`dk`),`tbl_trans_kas`.`jumlah`,0)) AS `kredit`,if((`tbl_trans_kas`.`dk` = 'D'),`tbl_trans_kas`.`jumlah`,if(isnull(`tbl_trans_kas`.`dk`),`tbl_trans_kas`.`jumlah`,0)) AS `debet`,`tbl_trans_kas`.`dari_kas_id` AS `dari_kas`,`tbl_trans_kas`.`untuk_kas_id` AS `untuk_kas`,`tbl_trans_kas`.`jns_trans` AS `transaksi`,`tbl_trans_kas`.`keterangan` AS `ket`,`tbl_trans_kas`.`user_name` AS `user` from `tbl_trans_kas` order by `tgl`;




