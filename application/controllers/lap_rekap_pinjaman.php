<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_rekap_pinjaman extends AdminController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('pinjaman_m');
	}	

	function showlappinjaman(){
		$data_pinjam = $this->pinjaman_m->lap_data_pinjaman();
		if(!$data_pinjam):
			echo '<b>Tidak ada data</b>';
			return;
		endif;
		$html = '';
		$html .= '
			<tr class="header_kolom">
				<th style="width:5%;" > No </th>
				<th style="width:10%;"> Nomor Kontrak</th>
				<th style="width:17%;"> Nama Anggota</th>
				<th style="width:12%;"> Tanggal Pinjam  </th>
				<th style="width:17%;"> Total Tagihan </th>
				<th style="width:15%;"> Jumlah Angsuran  </th>
				<th style="width:11%;"> Sisa Tagihan  </th>
				<th style="width:10%;"> Sisa Angsuran  </th>
			</tr>';
		$no =1;
		$batas = 1;
		$total_pinjaman = 0;
		$total_denda = 0;
		$total_tagihan = 0;
		$tot_sdh_dibayar = 0;
		$tot_sisa_tagihan = 0;
		foreach ($data_pinjam as $r) {
			if($batas == 0) {
				$html .= '
				<tr class="header_kolom" pagebreak="false">
				<th style="width:5%;" > No </th>
				<th style="width:10%;"> Nomor Kontrak</th>
				<th style="width:17%;"> Nama Anggota</th>
				<th style="width:12%;"> Tanggal Pinjam  </th>
				<th style="width:17%;"> Total Tagihan </th>
				<th style="width:15%;"> Jumlah Angsuran  </th>
				<th style="width:11%;"> Sisa Tagihan  </th>
				<th style="width:102%;"> Sisa Angsuran  </th>
				</tr>';
				$batas = 1;
			}
			$batas++;

			$barang = $this->pinjaman_m->get_data_barang($r->barang_id);   
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   
			$jml_bayar = $this->general_m->get_jml_bayar($r->id); 
			$jml_denda = $this->general_m->get_jml_denda($r->id); 
			$jml_tagihan = $r->tagihan + $jml_denda->total_denda;
			$sisa_tagihan = $jml_tagihan - $jml_bayar->total;


			//total pinjaman
			$total_pinjaman += @$r->jumlah;
			//total tagihan
			$total_tagihan += $jml_tagihan;
			//total dibayar
			$tot_sdh_dibayar += $jml_bayar->total;
			//sisa tagihan
			$tot_sisa_tagihan += $sisa_tagihan;

			//jabatan
			if ($anggota->jabatan_id == "1"){
				$jabatan = "Pengurus";
			} else {
				$jabatan = "Anggota";
			}

			//jk
			if ($anggota->jk == "L"){
				$jk = "Laki-laki";
			} else {
				$jk = "Perempuan";
			}

			$tgl_pinjam = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_pinjam[0],'full');

			$tgl_tempo = explode(' ', $r->tempo);
			$txt_tempo = jin_date_ina($tgl_tempo[0],'full');

			$sisa_angsur = 0;
			if($r->lunas == 'Belum') {
				$sisa_angsur = $r->lama_angsuran - $r->bln_sudah_angsur;
			}


			// AG'.sprintf('%04d',$anggota->id).'
			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td class="h_tengah">'.'PJ'.sprintf('%05d',$r->id).'</td>
				<td class="h_kiri"><strong>'.strtoupper($anggota->nama). ' <br>'.$anggota->departement.'</strong></td>
                               	<td class="h_tengah">'.$txt_tanggal.'</td>
				<td class="h_tengah"> '.number_format(nsi_round($r->tagihan)).' </td>
				<td class="h_tengah"> '.number_format(nsi_round(@$r->ags_per_bulan)).'</td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($sisa_tagihan)).'</strong></td>
                                <td class="h_tengah"><strong>'.number_format(nsi_round($sisa_angsur)).'</strong></td>



			</tr>';
			}
		echo $html;
	}


	function cetak_laporan() {
		$data_pinjam = $this->pinjaman_m->lap_data_pinjaman();
		if($data_pinjam == FALSE) {
			echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
			exit();
		}

		$tgl_dari = $_REQUEST['tgl_dari']; 
		$tgl_sampai = $_REQUEST['tgl_sampai'];
		$cari_status = $_REQUEST['cari_status']; 

		if ($cari_status == "") {
			$status = "Status Pelunasan : Semua";
		} else {
			$status = "Status Pelunasan :". $cari_status ;
		}

		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '';
		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Rekap Pinjaman <br></span> <span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).' | '.$status.'</span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
			<tr class="header_kolom">
				<th style="width:5%;" > No </th>
				<th style="width:10%;"> Nomor Kontrak</th>
				<th style="width:17%;"> Nama Anggota</th>
				<th style="width:12%;"> Tanggal Pinjam  </th>
				<th style="width:17%;"> Total Tagihan </th>
				<th style="width:15%;"> Jumlah Angsuran  </th>
				<th style="width:11%;"> Sisa Tagihan  </th>
				<th style="width:10%;"> Sisa Angsuran  </th>
			</tr>';
		$no =1;
		$batas = 1;
		$total_pinjaman = 0;
		$total_denda = 0;
		$total_tagihan = 0;
		$tot_sdh_dibayar = 0;
		$tot_sisa_tagihan = 0;
		foreach ($data_pinjam as $r) {
			if($batas == 0) {
				$html .= '
				<tr class="header_kolom" pagebreak="false">
				<th style="width:5%;" > No </th>
				<th style="width:10%;"> Nomor Kontrak</th>
				<th style="width:17%;"> Nama Anggota</th>
				<th style="width:12%;"> Tanggal Pinjam  </th>
				<th style="width:17%;"> Total Tagihan </th>
				<th style="width:15%;"> Jumlah Angsuran  </th>
				<th style="width:11%;"> Sisa Tagihan  </th>
				<th style="width:102%;"> Sisa Angsuran  </th>
				</tr>';
				$batas = 1;
			}
			$batas++;

			$barang = $this->pinjaman_m->get_data_barang($r->barang_id);   
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   
			$jml_bayar = $this->general_m->get_jml_bayar($r->id); 
			$jml_denda = $this->general_m->get_jml_denda($r->id); 
			$jml_tagihan = $r->tagihan + $jml_denda->total_denda;
			$sisa_tagihan = $jml_tagihan - $jml_bayar->total;


			//total pinjaman
			$total_pinjaman += @$r->jumlah;
			//total tagihan
			$total_tagihan += $jml_tagihan;
			//total dibayar
			$tot_sdh_dibayar += $jml_bayar->total;
			//sisa tagihan
			$tot_sisa_tagihan += $sisa_tagihan;

			//jabatan
			if ($anggota->jabatan_id == "1"){
				$jabatan = "Pengurus";
			} else {
				$jabatan = "Anggota";
			}

			//jk
			if ($anggota->jk == "L"){
				$jk = "Laki-laki";
			} else {
				$jk = "Perempuan";
			}

			$tgl_pinjam = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_pinjam[0],'full');

			$tgl_tempo = explode(' ', $r->tempo);
			$txt_tempo = jin_date_ina($tgl_tempo[0],'full');

			$sisa_angsur = 0;
			if($r->lunas == 'Belum') {
				$sisa_angsur = $r->lama_angsuran - $r->bln_sudah_angsur;
			}


			// AG'.sprintf('%04d',$anggota->id).'
			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td class="h_tengah">'.'PJ'.sprintf('%05d',$r->id).'</td>
				<td class="h_kiri"><strong>'.strtoupper($anggota->nama). ' <br>'.$anggota->departement.'</strong></td>
                               	<td class="h_tengah">'.$txt_tanggal.'</td>
				<td class="h_tengah"> '.number_format(nsi_round($r->tagihan)).' </td>
				<td class="h_tengah"> '.number_format(nsi_round(@$r->ags_per_bulan)).'</td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($sisa_tagihan)).'</strong></td>
                                <td class="h_tengah"><strong>'.number_format(nsi_round($sisa_angsur)).'</strong></td>



			</tr>';
			}

		$html .= '
				<tr>
					<td colspan="6" class="h_kanan"> <strong> Total Pokok Pinjaman </strong> </td>
					<td class="h_kanan"><strong> '.number_format(nsi_round($total_pinjaman)).' </strong></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6" class="h_kanan"> <strong> Total Tagihan </strong> </td>
					<td class="h_kanan"><strong>'.number_format(nsi_round($total_tagihan)).'</strong></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6" class="h_kanan"> <strong> Total Dibayar </strong> </td>
					<td class="h_kanan"><strong>'.number_format(nsi_round($tot_sdh_dibayar)).'</strong></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6" class="h_kanan"> <strong> Sisa Tagihan </strong> </td>
					<td class="h_kanan"><strong>'.number_format(nsi_round($tot_sisa_tagihan)).'</strong></td>
					<td></td>
				</tr>
			</table>';
		$pdf->nsi_html($html);
		$pdf->Output('pinjam'.date('Ymd_His') . '.pdf', 'I');
	} 

	function cetak_laporan_pinjaman() {
		$this->load->model('simpanan_m');
		$this->load->model('lap_kas_anggota_m');

		$data_pinjam = $this->pinjaman_m->lap_data_pinjaman();
		$anggota = $this->lap_kas_anggota_m->lap_data_anggota();
		$data_jns_simpanan = $this->lap_kas_anggota_m->get_jenis_simpan();
		$data_detail_anggota = $this->lap_kas_anggota_m->get_detail_data();
		if($data_pinjam == FALSE) {
			echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
			exit();
		}

		if($anggota == FALSE) {
			redirect('lap_kas_anggota');
			exit();
		}

		$tgl_dari = $_REQUEST['tgl_dari']; 
		$tgl_sampai = $_REQUEST['tgl_sampai'];

		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('P');
		$html = '';

		$html .= '
         <style>
             .h_tengah {text-align: center;}
             .h_kiri {text-align: left;}
             .h_kanan {text-align: right;}
             .txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
             .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
         </style>
         '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Kas Pinjaman Anggota</span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center');
         if (isset($_REQUEST['tgl_dari']) && $_REQUEST['tgl_dari'] != '') {
         	$html.= $pdf->nsi_box($text = '<span> Periode '.jin_date_ina($_REQUEST['tgl_dari']).' - '.jin_date_ina($_REQUEST['tgl_sampai']).'</span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center');
         }
      $html .= '<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
         <tr class="header_kolom">';
         if (isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0) {
         	$html .= '<th class="header_tengah" style="width:7%;"> Photo</th>';
         	$html .= '<th style="width:33%;"> Identitas  </th>';
					}else{
						$html .='<th style="width:3%;" > No </th>
            <th class="header_tengah" style="width:5%;"> Photo</th>';
            $html .= '<th style="width:32%;"> Identitas  </th>';
					}
            $html .= '<th style="width:30%;"> Kas Simpanan </th>
            <th style="width:30%;"> Tagihan Pinjaman </th>
         </tr>';
			$no =1;
			$batas = 1;
			foreach ($anggota as $row) {
				if($batas == 0) {
					$html .= '
					<tr class="header_kolom" pagebreak="false">
		            <th style="width:3%;" > No </th>
		            <th class="header_tengah" style="width:5%;"> Photo</th>
		            <th style="width:32%;"> Identitas  </th>
		            <th style="width:30%;"> Kas Simpanan </th>
		            <th style="width:30%;"> Tagihan Pinjaman </th>
	            </tr>';
	            $batas = 1;
				}
				$batas++;
			
			//pinjaman
			$pinjaman = $this->lap_kas_anggota_m->get_data_pinjam($row->id);
			$pinjam_id = @$pinjaman->id;

			//denda
			$denda = $this->lap_kas_anggota_m->get_jml_denda($pinjam_id);
			$tagihan= @$pinjaman->tagihan + $denda->total_denda;
			
			//dibayar
			$dibayar = $this->lap_kas_anggota_m->get_jml_bayar($pinjam_id);
			$sisa_tagihan = $tagihan - $dibayar->total;

			//photo
			$photo_w = 3 * 12;
			$photo_h = 4 * 12;
			if($row->file_pic == '') {
				$photo ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
			} else {
				$photo= '<img src="'.base_url().'uploads/anggota/' . $row->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
			}

			//jk
			if ($row->jk == "L") {
				$jk="Laki-Laki"; 
			} else {
				$jk="Perempuan"; 
			}

			//jabatan
			if ($row->jabatan_id == "1") {
				$jabatan="Pengurus";
			} else {
				$jabatan="Anggota"; 
			}
			// AG'.sprintf('%04d', $row->id).'
         $html .= '
         <tr nobr="true">';
         if (isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0) {
         	$html .= '<td class="h_tengah" style="vertical-align: middle ">'.$photo.'</td>';
					}else{
						$html .='<td class="h_tengah" style="vertical-align: middle ">'.$no++.' </td>
				<td class="h_tengah" style="vertical-align: middle ">'.$photo.'</td>';
					}
				$html .= '<td> 
				<table>
					<tr>
						<td><strong> '.$row->nama.'</strong></td>
					</tr>
					<tr>
						<td> '.$row->identitas.' </td>
					</tr>
					<tr>
						<td> '.$jk.' </td>
					</tr>
					<tr>
						<td> '.$jabatan.' - '.$row->departement.'</td>
					</tr>
					<tr>
						<td> '.$row->alamat.' Telp. '.$row->notelp.' </td>
					</tr>
				</table>
				</td>
				<td> 
					<table width="100%">';
					$simpanan_arr = array();
					$simpanan_row_total = 0; 
					foreach ($data_jns_simpanan as $jenis) {
						$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
						$nilai_s = $this->lap_kas_anggota_m->get_jml_simpanan($jenis->id, $row->id);
						$nilai_p = $this->lap_kas_anggota_m->get_jml_penarikan($jenis->id, $row->id);	
						$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
						$simpanan_row_total += $simpanan_row;
		$html.=' <tr>
						<td> '.$jenis->jns_simpan.'</td>
						<td class="h_kanan"> '. number_format($simpanan_row).'</td>
					</tr>';
					}
		$html.='<tr>
						<td> <strong>Total Simpanan</strong></td>
						<td class="h_kanan"><strong> '.number_format($simpanan_row_total).'</strong></td>
					</tr>
					</table>
				</td> 
				<td>
					<table> 
					<tr>
						<td> Pokok Pinjaman</td>
						<td class="h_kanan">'.number_format(@nsi_round($pinjaman->jumlah)).'</td>
					</tr>
					<tr>
						<td> Total Tagihan </td> 
						<td class="h_kanan"> '.number_format(nsi_round($tagihan)).' </td>
					</tr>
					<tr>
						<td> Dibayar </td>
						<td class="h_kanan"> '.number_format(nsi_round($dibayar->total)).'</td></tr>
					<tr>
						<td> Sisa Tagihan </td>
						<td class="h_kanan"> <strong> '.number_format(nsi_round($sisa_tagihan)).'</strong>
						</td>
					</tr>
				</table>
			</td>
		</tr>'; 
		}     
      $html .= '</table>';

		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>';
		$html .= '<br><p>Transaksi Pinjaman :</p>';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
			<tr class="header_kolom">
				<th style="width:5%;" > No </th>
				<th style="width:10%;"> Nomor Kontrak</th>
				<th style="width:17%;"> Nama Anggota</th>
				<th style="width:17%;"> Tanggal Pinjam  </th>
				<th style="width:15%;"> Total Tagihan </th>
				<th style="width:15%;"> Jumlah Angsuran  </th>
				<th style="width:11%;"> Sisa Tagihan  </th>
				<th style="width:10%;"> Sisa Angsuran  </th>
			</tr>';
		$no =1;
		$batas = 1;
		$total_pinjaman = 0;
		$total_denda = 0;
		$total_tagihan = 0;
		$tot_sdh_dibayar = 0;
		$tot_sisa_tagihan = 0;
		foreach ($data_pinjam as $r) {
			if($batas == 0) {
				$html .= '
				<tr class="header_kolom" pagebreak="false">
				<th style="width:5%;" > No </th>
				<th style="width:10%;"> Nomor Kontrak</th>
				<th style="width:17%;"> Nama Anggota</th>
				<th style="width:12%;"> Tanggal Pinjam  </th>
				<th style="width:17%;"> Total Tagihan </th>
				<th style="width:15%;"> Jumlah Angsuran  </th>
				<th style="width:11%;"> Sisa Tagihan  </th>
				<th style="width:102%;"> Sisa Angsuran  </th>
				</tr>';
				$batas = 1;
			}
			$batas++;

			$barang = $this->pinjaman_m->get_data_barang($r->barang_id);   
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   
			$jml_bayar = $this->general_m->get_jml_bayar($r->id); 
			$jml_denda = $this->general_m->get_jml_denda($r->id); 
			$jml_tagihan = $r->tagihan + $jml_denda->total_denda;
			$sisa_tagihan = $jml_tagihan - $jml_bayar->total;


			//total pinjaman
			$total_pinjaman += @$r->jumlah;
			//total tagihan
			$total_tagihan += $jml_tagihan;
			//total dibayar
			$tot_sdh_dibayar += $jml_bayar->total;
			//sisa tagihan
			$tot_sisa_tagihan += $sisa_tagihan;

			//jabatan
			if ($anggota->jabatan_id == "1"){
				$jabatan = "Pengurus";
			} else {
				$jabatan = "Anggota";
			}

			//jk
			if ($anggota->jk == "L"){
				$jk = "Laki-laki";
			} else {
				$jk = "Perempuan";
			}

			$tgl_pinjam = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_pinjam[0],'full');

			$tgl_tempo = explode(' ', $r->tempo);
			$txt_tempo = jin_date_ina($tgl_tempo[0],'full');

			$sisa_angsur = 0;
			if($r->lunas == 'Belum') {
				$sisa_angsur = $r->lama_angsuran - $r->bln_sudah_angsur;
			}


			// AG'.sprintf('%04d',$anggota->id).'
			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td class="h_tengah">'.'PJ'.sprintf('%05d',$r->id).'</td>
				<td class="h_kiri"><strong>'.strtoupper($anggota->nama). ' <br>'.$anggota->departement.'</strong></td>
                               	<td class="h_tengah">'.$txt_tanggal.'</td>
				<td class="h_tengah"> '.number_format(nsi_round($r->tagihan)).' </td>
				<td class="h_tengah"> '.number_format(nsi_round(@$r->ags_per_bulan)).'</td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($sisa_tagihan)).'</strong></td>
                                <td class="h_tengah"><strong>'.number_format(nsi_round($sisa_angsur)).'</strong></td>



			</tr>';
			}

		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('pinjam'.date('Ymd_His') . '.pdf', 'I');
	} 
}