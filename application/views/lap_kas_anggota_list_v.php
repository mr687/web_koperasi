<!-- Styler -->
<style type="text/css">
.panel * {
	font-family: "Arial","​Helvetica","​sans-serif";
}
.fa {
	font-family: "FontAwesome";
}
.datagrid-header-row * {
	font-weight: bold;
}
.messager-window * a:focus, .messager-window * span:focus {
	color: blue;
	font-weight: bold;
}
.daterangepicker * {
	font-family: "Source Sans Pro","Arial","​Helvetica","​sans-serif";
	box-sizing: border-box;
}
.glyphicon	{font-family: "Glyphicons Halflings"}

.form-control {
	height: 20px;
	padding: 4px;
}	
</style>

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">Cetak Data Kas Anggota</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body">
		<table>
			<tr>
				<td> Pilih ID Anggota </td>
				<td>
					<form id="fmCari">
					 <input id="anggota_id" name="anggota_id" value="" style="width:200px; height:25px" class="">
					 </form>
					 <input type="hidden" name="tgl_dari">
					 <input type="hidden" name="tgl_sampai">
				</td>	
				<td>
					<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Lihat Laporan</a>
					<?php if (isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0): ?>
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan Simpanan</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetakpinjaman()">Cetak Laporan Pinjaman</a>
					<?php else: ?>
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
					<?php endif ?>
					<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
				</td>
				<?php if (isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0 ) : ?>
					<td>
						<div class="pull-right" style="vertical-align: middle;">
							<div id="filter_tgl" class="input-group" style="display: inline;">
								<button class="btn btn-default" id="daterange-btn" style="line-height:8px;border:1px solid #ccc">
									<i class="fa fa-calendar"></i> <span id="reportrange"><span> Tanggal</span></span>
									<i class="fa fa-caret-down"></i>
								</button>
							</div>
						</div>
					</td>
				<?php endif; ?>
				</tr>
			</table>
		</div>
</div>

<div class="box box-primary">
	<div class="box-body">
	<p></p>
	<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Data Kas Per Anggota </p>
	<table  class="table table-bordered">
		<tr class="header_kolom">
			<?php if (isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0) : ?>
				<th style="width:10%; vertical-align: middle; text-align:center">Photo</th>
			<?php else: ?>
				<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
				<th style="width:5%; vertical-align: middle; text-align:center">Photo</th>
			<?php endif ?>
			<th style="width:25%; vertical-align: middle; text-align:center"> Identitas  </th>
			<th style="width:20%; vertical-align: middle; text-align:center">Saldo Simpanan</th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Tagihan Kredit </th>
			<th style="width:23%; vertical-align: middle; text-align:center"> Keterangan </th>
		</tr>
	<?php
	
	$no = $offset + 1;
	$mulai=1;
	if (!empty($data_anggota)) {

		foreach ($data_anggota as $row) {
		if(($no % 2) == 0) {
			$warna="#EEEEEE"; } 
		else {
			$warna="#FFFFFF";}

		//pinjaman
		$pinjaman = $this->lap_kas_anggota_m->get_data_pinjam($row->id);
		$pinjam_id = @$pinjaman->id;
		$anggota_id = @$pinjaman->anggota_id;

		$jml_pj = $this->lap_kas_anggota_m->get_jml_pinjaman($anggota_id);
		$pj_anggota= @$jml_pj->total;

		//denda
		$denda = $this->lap_kas_anggota_m->get_jml_denda($pinjam_id);
		$tagihan= @$pinjaman->tagihan + $denda->total_denda;
		//dibayar
		$dibayar = $this->lap_kas_anggota_m->get_jml_bayar($pinjam_id);
		$sisa_tagihan = $tagihan - $dibayar->total;

		$peminjam_tot = $this->lap_kas_anggota_m->get_peminjam_tot($row->id);
		$peminjam_lunas = $this->lap_kas_anggota_m->get_peminjam_lunas($row->id);

		$tgl_tempo = explode(' ', @$pinjaman->tempo);
		$tgl_tempo_txt = jin_date_ina($tgl_tempo[0],'p');
		$tgl_tempo_r = $tgl_tempo[0];

		$tgl_tempo_rr = explode('-', $tgl_tempo_r);
		$thn = $tgl_tempo_rr[0];
		$bln = @$tgl_tempo_rr[1];

		if ((@$pinjaman->lunas == 'Belum') && (date('m') > $bln )) {
			$data = 'Macet';
		} else {
			$data = 'Lancar';
		}

		//photo
		$photo_w = 3 * 20;
		$photo_h = 4 * 20;
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
	 	echo '
			<tr bgcolor='.$warna.' >';
			if (isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0):
			else:
				echo '<td class="h_tengah" style="vertical-align: middle "> '.$no++.' </td>';
			endif;
				echo '<td class="h_tengah" style="vertical-align: middle "> '.$photo.'</td>
				<td> 
					<table>
						<tr><td> ID Anggota : '.$row->identitas.'</td></tr>
						<tr><td> Nama : <b>'.strtoupper($row->nama).'</b> </td></tr>
						<tr><td> Jenis Kelamin : '.$jk.' </td></tr>
						<tr><td> Jabatan : '.$jabatan.' - '.$row->departement.'</td></tr>
						<tr><td> Alamat  : '.$row->alamat.' Telp.'.$row->notelp.' </td></tr>
					</table>
				</td>
				<td>';
				$simpanan_arr = array();
				$simpanan_row_total = 0; 
				$simpanan_total = 0; 
				foreach ($data_jns_simpanan as $jenis) {
					$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
					$nilai_s = $this->lap_kas_anggota_m->get_jml_simpanan($jenis->id, $row->id);
					$nilai_p = $this->lap_kas_anggota_m->get_jml_penarikan($jenis->id, $row->id);
					
					$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
					$simpanan_row_total += $simpanan_row;
					$simpanan_total += $simpanan_row_total;

					echo'<table style="width:100%;">
							<tr>
								<td>'.$jenis->jns_simpan.'</td>
								<td class="h_kanan">'. number_format($simpanan_row).'</td>
							</tr>';
					}
					echo '<tr>
								<td><strong> Jumlah Simpanan </strong></td>
								<td class="h_kanan"><strong> '.number_format($simpanan_row_total).'</strong></td>
							</tr>
							</table>';
					echo '		
					<td>
						<table style="width:100%;"> 
							<tr>
								<td> Pokok Pinjaman</td>
								<td class="h_kanan">'.number_format(@nsi_round($pinjaman->jumlah)).'</td>
							</tr>
							<tr>
								<td> Tagihan + Denda </td> 
								<td class="h_kanan"> '.number_format(nsi_round($tagihan)).' </td>
							</tr>
							<tr>
								<td> Dibayar </td>
								<td class="h_kanan"> '.number_format(nsi_round($dibayar->total)).'</td>
							</tr>
							<tr>
								<td><strong> Sisa Tagihan</strong></td>
								<td class="h_kanan"> <strong>'.number_format(nsi_round($sisa_tagihan)).'</strong></td>
							</tr>
						</table>
					</td>
					<td> 
						<table style="width:100%;"> 
							<tr>
								<td> Jumlah Pinjaman </td>
								<td class="h_kanan">'.$peminjam_tot.'</td>
							</tr>
							<tr>
								<td> Pinjaman Lunas </td>
								<td class="h_kanan">'.$peminjam_lunas.'</td>
							</tr>
							<tr>
								<td> Pembayaran</td>
								<td class="h_kanan"> <code>'.$data.'</code></td>
							</tr>
							<tr>
								<td> Tanggal Tempo</td>
								<td class="h_kanan"> <code>'.$tgl_tempo_txt.'</code></td>
							</tr>
						</table>
					</td>
				</tr>';
			}
		echo '</table>';
		if (isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0):
			?>
	<?php
			echo '
					<style>
						.h_tengah {text-align: center;}
						.h_kiri {text-align: left;}
						.h_kanan {text-align: right;}
						.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
						.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
						.txt_content {font-size: 10pt; font-style: arial;}
					</style>';
			echo '<br><p id="atas"></p>';
			echo '<table width="100%" id="tblshow" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">';
			echo '</table>';
			echo '<br><p id="atas2"></p>';
			echo '<table width="100%" id="tblshow2" cellspacing="0" cellpadding="3" border="1" nobr="true">';
			echo '</table>';
		endif;
		echo '<div class="box-footer">'.$halaman.'</div>';
	} else {
		echo '<tr>
					<td colspan="9" >
						<code> Tidak Ada Data <br> </code>
					</td>
				</tr>';
			}
	?>
</div>
</div>
	
<script type="text/javascript">
	$(document).ready(function() {

	<?php 
		if(isset($_REQUEST['anggota_id'])) {
			echo 'var anggota_id = "'.$_REQUEST['anggota_id'].'";';
		} else {
			echo 'var anggota_id = "";';
		}
		echo '$("#anggota_id").val(anggota_id);';
	?>

		$('#anggota_id').combogrid({
			panelWidth:300,
			url: '<?php echo site_url('lap_shu_anggota/list_anggota'); ?>' ,
			idField:'id',
			valueField:'id',
			textField:'id_nama',
			mode:'remote',
			fitColumns:true,
			columns:[[
				{field:'photo',title:'Photo',align:'center',width:5},
				{field:'id',title:'ID', hidden: true},
				{field:'id_nama', title:'IDNama', hidden: true},
				{field:'kode_anggota', title:'ID', align:'center', width:15},
				{field:'nama',title:'Nama Anggota',align:'left',width:20}
			]]
		});



fm_filter_tgl();
}); // ready

	function fm_filter_tgl() {
	$('#daterange-btn').daterangepicker({
		ranges: {
			'Hari ini': [moment(), moment()],
			'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
			'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
			'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
			'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
			'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
			'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
		},
		showDropdowns: true,
		format: 'YYYY-MM-DD',
		startDate: moment().startOf('year').startOf('month'),
		endDate: moment().endOf('year').endOf('month')
	},

	function(start, end) {
		$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
		$('input[name=tgl_dari]').val(start.format('YYYY-MM-DD'));
		$('input[name=tgl_sampai]').val(end.format('YYYY-MM-DD'));
		sortingbydate(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),$('#anggota_id').val());
	});
}

function sortingbydate(start,end,id){
	var tgl_dari = start;
	var tgl_sampai = end;
	var anggota_id = id;
	var site_url  = "<?php echo site_url(); ?>";
	var html = '';
	var atas = '';
	var flickerAPI = site_url + "lap_kas_anggota/getdatabydate?anggota_id=" + anggota_id + "&tgl_dari=" + tgl_dari + "&tgl_sampai=" + tgl_sampai;
  $.getJSON( flickerAPI, {
    format: "json"
  })
    .done(function( data ) {
    	atas = "Transaksi Simpanan :";
    	html = "<tr class=\"header_kolom\">\<th class=\"h_tengah\" style=\"width:5%;\" > No. </th><th class=\"h_tengah\" style=\"width:9%;\"> No Transaksi</th><th class=\"h_tengah\" style=\"width:17%;\"> Tanggal </th><th class=\"h_tengah\" style=\"width:25%;\"> Akun </th><th class=\"h_tengah\" style=\"width:13%;\"> Dept </th><th class=\"h_tengah\" style=\"width:18%;\"> Jenis Simpanan </th><th class=\"h_tengah\" style=\"width:13%;\"> Jumlah  </th></tr>";
    	$.each(data, function(key,value){
    		var no = key + 1;
    		html += "<tr><td class='h_tengah' >" + no + "</td><td class='h_tengah'> "+'TRD'+pad(value.id,5)+"</td><td class=\"h_tengah\"> "+jin_date_ina(value.tgl_transaksi)+"</td><td class=\"h_tengah\"> "+ value.akun +"</td><td> "+value.departement+"</td><td> "+value.jns_simpan+"</td><td class=\"h_kanan\"> "+money_format(value.jumlah)+"</td></tr>";
    	});
    	getsaldoakhir(id);
    	$("#tblshow").html(html);
    	$("#atas").html(atas);
    });
    tampilkaspinjaman(id,tgl_dari,tgl_sampai);
}

function tampilkaspinjaman(id,tgl_dari,tgl_sampai){
	var atas = "Transaksi Pinjaman :";
	var site_url = "<?php echo site_url() ?>";
	var fliAPI = site_url + "lap_rekap_pinjaman/showlappinjaman?anggota_id=" + id + "&tgl_dari=" +tgl_dari+ "&tgl_sampai=" +tgl_sampai;
	$.ajax({url: fliAPI, success: function(data){
        $("#tblshow2").html(data);
			$("#atas2").html(atas);
    }});
}

function getsaldoakhir(id){
	var site_url  = "<?php echo site_url(); ?>";
	var flickerAPI = site_url + "lap_kas_anggota/getsaldoakhir?anggota_id=" + id;
	$.getJSON( flickerAPI, {
    format: "json"
  })
    .done(function( data ) {
    	$("#tblshow").append("<tr><td colspan=\"6\" class=\"h_tengah\"><strong> Saldo Akhir </strong></td><td class=\"h_kanan\"> <strong>"+ money_format(data) +"</strong></td></tr></table>");
    });
}

function money_format(int){
	var	number_string = int.toString(),
	sisa 	= number_string.length % 3,
	rupiah 	= number_string.substr(0, sisa),
	ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
		
	if (ribuan) {
		separator = sisa ? ',' : '';
		rupiah += separator + ribuan.join(',');
	}
	return rupiah;
}

function jin_date_ina(date_sql) {
		var date = '';
		var nama_bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
		var exp = date_sql.split(' ');
			exp = exp[0].split('-');
			if(exp.length == 3) {
				var bln = exp[1] - 1;
				date = exp[2]+' '+nama_bulan[bln]+' '+exp[0];
			}		
			var exp_time = exp = date_sql.split(' ');
			date += ' - ' + exp_time[1].substr(0, 5);
		return date;
	}

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}

function clearSearch(){
	window.location.href = '<?php echo site_url("lap_kas_anggota"); ?>';
}

function cetak () {
	// if(($('input[name=tgl_sampai]').val() == '')  && (isset($_GET['anggota_id'])) && ($_GET['anggota_id'] > 0)){
				<?php 
				if(isset($_REQUEST['anggota_id'])) {
					echo 'var anggota_id = "'.$_REQUEST['anggota_id'].'";';
				} else {
					echo 'var anggota_id = $("#anggota_id").val();';
				}
			?>
			var tgl_dari = $('input[name=tgl_dari]').val();
			var tgl_sampai = $('input[name=tgl_sampai]').val();
			var win = window.open('<?php echo site_url("lap_kas_anggota/cetak_laporan/?anggota_id=' + anggota_id +'&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
			if (win) {
				win.focus();
			} else {
				alert('Popup jangan di block');
			}
	// }else{
	// 	alert('Pilih tanggal periode terlebih dahulu.');
	// }
}
function cetakpinjaman () {
	// if($('input[name=tgl_sampai]').val() != '' && isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0){
		<?php 
			if(isset($_REQUEST['anggota_id'])) {
				echo 'var anggota_id = "'.$_REQUEST['anggota_id'].'";';
			} else {
				echo 'var anggota_id = $("#anggota_id").val();';
			}
		?>
		var tgl_dari = $('input[name=tgl_dari]').val();
		var tgl_sampai = $('input[name=tgl_sampai]').val();
		var win = window.open('<?php echo site_url("lap_rekap_pinjaman/cetak_laporan_pinjaman/?anggota_id=' + anggota_id +'&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}
		//$('#fmCari').attr('action', '<?php echo site_url('lap_kas_anggota/cetak_laporan'); ?>');
		//$('#fmCari').submit();
	// }else{
	// 	alert('Pilih tanggal periode terlebih dahulu.');
	// }
}

function doSearch() {
	$('#fmCari').submit();
}
</script>