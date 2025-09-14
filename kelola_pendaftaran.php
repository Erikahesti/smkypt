<?php require_once('../Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
   $gambar = $_FILES['foto']['name'];
  $insertSQL = sprintf("INSERT INTO pendaftaran (no_daftar, nama_lengkap, tahun_kelulusan, nm_asl_sekolah, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_telpon, nm_orang_tua, program, pekerjaan_ortu, foto, tgl_daftar) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_daftar'], "int"),
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['tahun_kelulusan'], "int"),
                       GetSQLValueString($_POST['nm_asl_sekolah'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telpon'], "text"),
                       GetSQLValueString($_POST['nm_orang_tua'], "text"),
                       GetSQLValueString($_POST['program'], "text"),
                       GetSQLValueString($_POST['pekerjaan_ortu'], "text"),
					   GetSQLValueString($gambar, "text"),
                       GetSQLValueString($_POST['tgl_daftar'], "date"));

    $gambar = $_FILES['foto']['name'];
$lokasi   = "../gambar/";
move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$gambar);
  
  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "index.php?menu=pelayanan_registrasi_sukses";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
    echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_pendaftaran' />";
}


$maxRows_pendaftaran = 10;
$pageNum_pendaftaran = 0;
if (isset($_GET['pageNum_pendaftaran'])) {
  $pageNum_pendaftaran = $_GET['pageNum_pendaftaran'];
}
$startRow_pendaftaran = $pageNum_pendaftaran * $maxRows_pendaftaran;

mysql_select_db($database_koneksi, $koneksi);
$query_pendaftaran = "SELECT * FROM pendaftaran WHERE no_daftar='$_GET[katakunci]' OR nama_lengkap LIKE '%$_GET[katakunci]%' AND status_daftar='DAFTAR' ORDER BY no_daftar ASC";
$query_limit_pendaftaran = sprintf("%s LIMIT %d, %d", $query_pendaftaran, $startRow_pendaftaran, $maxRows_pendaftaran);
$pendaftaran = mysql_query($query_limit_pendaftaran, $koneksi) or die(mysql_error());
$row_pendaftaran = mysql_fetch_assoc($pendaftaran);

if (isset($_GET['totalRows_pendaftaran'])) {
  $totalRows_pendaftaran = $_GET['totalRows_pendaftaran'];
} else {
  $all_pendaftaran = mysql_query($query_pendaftaran);
  $totalRows_pendaftaran = mysql_num_rows($all_pendaftaran);
}
$totalPages_pendaftaran = ceil($totalRows_pendaftaran/$maxRows_pendaftaran)-1;

$queryString_pendaftaran = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_pendaftaran") == false && 
        stristr($param, "totalRows_pendaftaran") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_pendaftaran = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_pendaftaran = sprintf("&totalRows_pendaftaran=%d%s", $totalRows_pendaftaran, $queryString_pendaftaran);
?>
<?php 
$query = "SELECT MAX(no_daftar) AS maxID FROM pendaftaran";

$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idMax = $data['maxID'];

$idMax++;

$nodaftar = $idMax;
?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<p align="center"><strong>DATA PENDAFTARAN</strong></p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="500" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <td nowrap="nowrap">No Daftar</td>
      <td><input name="no_daftar" type="text" value="<?php echo $nodaftar; ?>" size="10" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Nama Lengkap</td>
      <td><span id="sprytextfield1">
        <input type="text" name="nama_lengkap" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      <span class="textfieldRequiredMsg">A value is required.</span></span>
      
       <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Tahun Kelulusan</td>
      <td><input type="text" name="tahun_kelulusan" value="" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
      
      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Nama Asal Sekolah</td>
      <td><input type="text" name="nm_asl_sekolah" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Jenis Kelamin</td>
      <td><label for="jenis_kelamin"></label>
        <select name="jenis_kelamin" id="jenis_kelamin">
          <option value="laki-laki">laki-laki</option>
          <option value="perempuan">perempuan</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Tempat Lahir</td>
      <td><input type="text" name="tempat_lahir" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >  
      
      <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>

      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Tanggal Lahir</td>
      <td><input type="date" name="tanggal_lahir" value="" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
      
      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Alamat</td>
      <td><input type="text" name="alamat" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">No Telpon</td>
      <td><input type="text" name="no_telpon" value="" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
      
      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Nama Orang Tua</td>
      <td><input type="text" name="nm_orang_tua" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >  
      
      <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>

      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Program</td>
      <td><label for="program"></label>
        <select name="program" id="program">
            <option value="Teknik Instalasi Tenaga Listrik">Teknik Instalasi Tenaga Listrik</option>
          <option value="Teknik Pemesinan ">Teknik Pemesinan </option>
          <option value="Teknik Kendaraan Ringan Otomotif">Teknik Kendaraan Ringan Otomotif </option>
          <option value="Teknik dan Bisnis Sepeda Motor">Teknik dan Bisnis Sepeda Motor</option>
          <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
         
      </select></td>
          </tr>
          
          
    <tr valign="baseline">
      <td nowrap="nowrap">Pekerjaan Orang Tua</td>
      <td><input type="text" name="pekerjaan_ortu" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >  
      <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>

      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Foto</td>
      <td><label for="foto"></label>
      <input type="file" name="foto" id="foto" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Tanggal Daftar</td>
      <td><input type="text" name="tgl_daftar" value="<?php $tgl=date('Y-m-d'); echo "$tgl"; ?>" size="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap"><input type="submit" value="DAFTAR" /></td>
      <td><input type="reset" name="Reset" id="button" value="BATAL" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="get" action="" style="margin:0 auto; text-align:center;">
  <input type="hidden" name="menu" value="kelola_pendaftaran" id="katakunci" />
  <label for="pilihan"></label>
  <select name="pilihan" id="pilihan">
    <option value="no_daftar">no_daftar</option>
    <option value="nama_lengkap">nama_lengkap</option>
    <option value="jurusan">jurusan</option>
  </select>
  <label for="katakunci"></label>
  <input type="text" name="katakunci" id="katakunci" />
  <input type="submit" name="button2" id="button2" value="Cari" />
</form>
<p>&nbsp;</p>

<table width="550" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr align="center">
    <td width="80">No Daftar</td>
    <td>Nama Lengkap</td>
    <td>Jurusan</td>
    <td>NIK</td>
    <td>TTL</td>
    <td width="100">AKSI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_pendaftaran['no_daftar']; ?></td>
    <td><?php echo $row_pendaftaran['nama_lengkap']; ?>&nbsp; </td>
    <td><?php echo $row_pendaftaran['jenis_kelamin']; ?>&nbsp; </td>
    <td><?php echo $row_pendaftaran['no_telpon']; ?></td>
    <td><?php echo $row_pendaftaran['alamat']; ?></td>
    <td align="center"><a href="admin.php?menu=kelola_pendaftaran_detail&recordID=<?php echo $row_pendaftaran['no_daftar']; ?>">Detail</a>&nbsp; <a href="admin.php?menu=kelola_pendaftaran_proses&recordID=<?php echo $row_pendaftaran['no_daftar']; ?>">Proses</a>&nbsp; <a href="admin.php?menu=kelola_pendaftaran_hapus&recordID=<?php echo $row_pendaftaran['no_daftar']; ?>">Hapus</a>&nbsp; </td>
  </tr>
  <?php } while ($row_pendaftaran = mysql_fetch_assoc($pendaftaran)); ?>
</table>
<br>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_pendaftaran > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_pendaftaran=%d%s", $currentPage, 0, $queryString_pendaftaran); ?>">First</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_pendaftaran > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_pendaftaran=%d%s", $currentPage, max(0, $pageNum_pendaftaran - 1), $queryString_pendaftaran); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_pendaftaran < $totalPages_pendaftaran) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_pendaftaran=%d%s", $currentPage, min($totalPages_pendaftaran, $pageNum_pendaftaran + 1), $queryString_pendaftaran); ?>">Next</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_pendaftaran < $totalPages_pendaftaran) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_pendaftaran=%d%s", $currentPage, $totalPages_pendaftaran, $queryString_pendaftaran); ?>">Last</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<p>&nbsp;</p>
<p>
  <?php
mysql_free_result($pendaftaran);
?>
</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
</script>
