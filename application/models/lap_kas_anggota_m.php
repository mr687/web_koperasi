<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_kas_anggota_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	//menghitung jumlah simpanan
	function get_jml_simpanan($jenis, $id) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('anggota_id',$id);
		$this->db->where('dk','D');
		$this->db->where('jenis_id', $jenis);
		$query = $this->db->get();
		return $query->row();
	}

	//panggil data jenis simpan
	function get_jenis_simpan() {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('tampil','Y');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	//menghitung jumlah penarikan
	function get_jml_penarikan($jenis, $id) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','K');
		$this->db->where('anggota_id', $id);
		$this->db->where('jenis_id', $jenis);
		$query = $this->db->get();
		return $query->row();
	}

	function get_detail_data(){
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		$tgl_dari = (isset($_REQUEST['tgl_dari'])) ? $_REQUEST['tgl_dari'] : '' ;
		$tgl_sampai = (isset($_REQUEST['tgl_sampai'])) ? $_REQUEST['tgl_sampai'] : '' ;
		$sql = "SELECT * FROM tbl_trans_sp WHERE anggota_id='".$anggota_id."'";
		if (($tgl_dari != '') AND ($tgl_sampai != '')) {
			$sql .= " AND date(tgl_transaksi) >= '" . $tgl_dari . "'";
			$sql .= " AND date(tgl_transaksi) <= '" . $tgl_sampai . "'";
		}
		
		$query = $this->db->query($sql);
		if($query->num_rows() >0){
			$out = $query->result();
			return $out;
		}else{
			return array();
		}
	}

	function get_saldo_akhir(){
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';

		$simpanan_row_total = 0; 
		$data_jns_simpanan = $this->get_jenis_simpan();
		foreach ($data_jns_simpanan as $jenis) {
			$nilai_s = $this->get_jml_simpanan($jenis->id, $anggota_id);
			$nilai_p = $this->get_jml_penarikan($jenis->id, $anggota_id);	
			$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
			$simpanan_row_total += $simpanan_row;
		}
		return $simpanan_row_total;
	}

	function get_detail_data_cetak(){
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		$tgl_dari = (isset($_REQUEST['tgl_dari'])) ? $_REQUEST['tgl_dari'] : '' ;
		$tgl_sampai = (isset($_REQUEST['tgl_sampai'])) ? $_REQUEST['tgl_sampai'] : '' ;

		$sql = "SELECT a.id,a.tgl_transaksi,a.akun,b.departement,c.jns_simpan,a.jumlah FROM tbl_trans_sp a JOIN tbl_anggota b ON b.id=a.anggota_id JOIN jns_simpan c ON c.id=a.jenis_id WHERE anggota_id='".$anggota_id."'";
		if (($tgl_dari != '') AND ($tgl_sampai != '')) {
			$sql .= " AND date(a.tgl_transaksi) >= '" . $tgl_dari . "'";
			$sql .= " AND date(a.tgl_transaksi) <= '" . $tgl_sampai . "'";
		}
		
		$query = $this->db->query($sql);
		if($query->num_rows() >0){
			$out = $query->result();
			return $out;
		}else{
			return array();
		}
	}

	function get_data_anggota($limit, $start, $q='') {
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		$sql = '';
		$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
		$q = array('anggota_id' => $anggota_id);
		if (is_array($q)){
			if($q['anggota_id'] != '') {
				$q['anggota_id'] = str_replace('AG', '', $q['anggota_id']);
				$sql .=" AND (id LIKE '".$q['anggota_id']."' OR nama LIKE '".$q['anggota_id']."') ";
			}
		}
		$sql .= "LIMIT ".$start.", ".$limit." ";
		//$this->db->limit($limit, $start);
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}
	
	//panggil data anggota
	function lap_data_anggota() {
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		$sql = '';
		$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
		$q = array('anggota_id' => $anggota_id);
		if (is_array($q)){
			if($q['anggota_id'] != '') {
				$q['anggota_id'] = str_replace('AG', '', $q['anggota_id']);
				$sql .=" AND (id LIKE '".$q['anggota_id']."') ";
			}
		}
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	function get_jml_data_anggota() {
		$this->db->where('aktif', 'Y');
		return $this->db->count_all_results('tbl_anggota');
	}

//ambil data pinjaman header berdasarkan ID peminjam
	function get_data_pinjam($id) {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('anggota_id',$id);
		$this->db->where('lunas','Belum');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->row();
			return $out;
		} else {
			return array();
		}
	}


	function get_peminjam_lunas($id) {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('lunas','Lunas');
		$this->db->where('anggota_id',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_peminjam_tot($id) {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('anggota_id',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	//menghitung jumlah yang sudah dibayar
	function get_jml_pinjaman($id) {
		$this->db->select('SUM(jumlah) AS total');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('anggota_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah yang sudah dibayar
	function get_jml_tagihan($id) {
		$this->db->select('SUM(tagihan) AS total');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('anggota_id',$id);
		$query = $this->db->get();
		return $query->row();
	}


	//menghitung jumlah yang sudah dibayar
	function get_jml_bayar($id) {
		$this->db->select('SUM(jumlah_bayar) AS total');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah denda harus dibayar
	function get_jml_denda($id) {
		$this->db->select('SUM(denda_rp) AS total_denda');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

}

