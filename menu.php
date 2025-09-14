<?php 
switch(@$_GET['menu']){
	
	default : include "home.php"; break;
	
	case "kelola_pendaftaran"; include "kelola_pendaftaran.php"; break;
	case "kelola_pendaftaran_detail"; include "kelola_pendaftaran_detail.php"; break;
	case "kelola_pendaftaran_proses"; include "kelola_pendaftaran_proses.php"; break;
	case "kelola_pendaftaran_hapus"; include "kelola_pendaftaran_hapus.php"; break;
	
	case "kelola_siswa"; include "kelola_siswa.php"; break;
	case "kelola_siswa_edit"; include "kelola_siswa_edit.php"; break;
	case "kelola_siswa_cetak"; include "kelola_siswa_cetak.php"; break;
	case "kelola_siswa_hapus"; include "kelola_siswa_hapus.php"; break;
	
	
	
	case "kelola_profil"; include "kelola_profil.php"; break;
	case "kelola_profil_edit"; include "kelola_profil_edit.php"; break;
	case "kelola_profil_hapus"; include "kelola_profil_hapus.php"; break;
	
	case "kelola_jurusan"; include "kelola_jurusan.php"; break;
	case "kelola_jurusan_edit"; include "kelola_jurusan_edit.php"; break;
	case "kelola_jurusan_hapus"; include "kelola_jurusan_hapus.php"; break;
	
	case "kelola_organisasi"; include "kelola_organisasi.php"; break;
	case "kelola_organisasi_edit"; include "kelola_organisasi_edit.php"; break;
	case "kelola_organisasi_hapus"; include "kelola_organisasi_hapus.php"; break;
	
	case "kelola_berita"; include "kelola_berita.php"; break;
	case "kelola_berita_edit"; include "kelola_berita_edit.php"; break;
	case "kelola_berita_hapus"; include "kelola_berita_hapus.php"; break;
	
	case "kelola_galeri"; include "kelola_galeri.php"; break;
	case "kelola_galeri_edit"; include "kelola_galeri_edit.php"; break;
	case "kelola_galeri_hapus"; include "kelola_galeri_hapus.php"; break;
	
	case "kelola_bukutamu"; include "kelola_bukutamu.php"; break;
	case "kelola_bukutamu_hapus"; include "kelola_bukutamu_hapus.php"; break;
	
	case "kelola_kontak"; include "kelola_kontak.php"; break;
	
	case "kelola_admin"; include "kelola_admin.php"; break;
	case "kelola_admin_edit"; include "kelola_admin_edit.php"; break;
	case "kelola_admin_hapus"; include "kelola_admin_hapus.php"; break;
	
	
	case "kelola_polling_web"; include "kelola_polling_web.php"; break;
	case "kelola_polling_pelayanan"; include "kelola_polling_pelayanan.php"; break;
	
	case "kelola_laporan"; include "kelola_laporan.php"; break;
	case "laporan_siswa"; include "laporan_siswa.php"; break;
	case "laporan_alumni"; include "laporan_alumni.php"; break;
	case "laporan_guru"; include "laporan_guru.php"; break;


}
?>