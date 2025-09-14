<?php 
switch(@$_GET['menu']){
	
	default : include "beranda.php"; break;
	
	case "profil"; include "profil.php"; break;
	case "organisasi"; include "organisasi.php"; break;
	
	case "polling_web"; include "polling_web.php"; break;
	case "polling_pelayanan"; include "polling_pelayanan.php"; break;
	

	case "pelayanan_informasi"; include "pelayanan_informasi.php"; break;
	case "pelayanan_dataguru"; include "pelayanan_dataguru.php"; break;
	
	case "pelayanan_siswa"; include "pelayanan_siswa.php"; break;
	case "pelayanan_siswa_detail"; include "pelayanan_siswa_detail.php"; break;
	
	case "pelayanan_alumni"; include "pelayanan_alumni.php"; break;
	case "pelayanan_alumni_detail"; include "pelayanan_alumni_detail.php"; break;
	
	case "pelayanan_pendaftaran"; include "pelayanan_pendaftaran.php"; break;
	case "pelayanan_pendaftaran_sukses"; include "pelayanan_pendaftaran_sukses.php"; break;
	case "pelayanan_pendaftaran_cetak"; include "pelayanan_pendaftaran_cetak.php"; break;
	case "pelayanan_pendaftaran_edit"; include "pelayanan_pendaftaran_edit.php"; break;
	
	case "organisasi_struktur"; include "organisasi_struktur.php"; break;
	case "organisasi_tugas"; include "organisasi_tugas.php"; break;
	
	case "galeri"; include "galeri.php"; break;
	case "fasilitas"; include "fasilitas.php"; break;
	case "bukutamu"; include "bukutamu.php"; break;
	case "kontak"; include "kontak.php"; break;
	case "login"; include "login.php"; break;
	case "berita_detail"; include "berita_detail.php"; break;


}
?>