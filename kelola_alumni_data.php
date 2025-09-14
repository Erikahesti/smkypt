<?php
   $db = new mysqli('localhost', 'root' ,'', 'db_smp_pti');
	
	if(!$db) {
		echo 'Tidak dapat melakukan koneksi ke database. Harap periksa kembali database anda.';
	} else {
	
		if(isset($_POST['nomor'])) {
			$queryString = $db->real_escape_string($_POST['nomor']);
			
			if(strlen($queryString) >0) {

				$query = $db->query("SELECT siswa.*, pendaftaran.* FROM siswa, pendaftaran WHERE siswa.no_daftar=pendaftaran.no_daftar AND siswa.NISN = '$queryString'");
				
				if($query) {
				echo '<ul>';
					while ($result = $query ->fetch_object()) {
	         			echo '<li onClick="fill(\''.addslashes($result->nama_lengkap).'\'); fill2(\''.addslashes($result->NISN).'\'); fill3(\''.addslashes($result->tahun_kelulusan).'\'); fill4(\''.addslashes($result->nm_asl_sekolah).'\'); fill5(\''.addslashes($result->jenis_kelamin).'\'); fill6(\''.addslashes($result->tempat_lahir).'\'); fill7(\''.addslashes($result->tanggal_lahir).'\');  fill8(\''.addslashes($result->alamat).'\'); fill9(\''.addslashes($result->no_telpon).'\'); fill10(\''.addslashes($result->nm_orang_tua).'\'); fill11(\''.addslashes($result->agama).'\'); fill12(\''.addslashes($result->pekerjaan_ortu).'\'); fill13(\''.addslashes($result->tgl_daftar).'\'); fill14(\''.addslashes($result->NIS).'\'); ">'.$result->NISN.'&nbsp;&nbsp;'.$result->nama_lengkap.'</li>';
	         		}
				echo '</ul>';
					
				} else {
					echo 'ada masalah pada koneksi anda. silahkan refresh halaman ini';
				}
			} else {
				// do nothing
			}
		} else {
			echo 'forbidden!';
		}
	}
?>