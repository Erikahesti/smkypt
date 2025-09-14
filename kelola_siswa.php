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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE siswa SET kelas=%s WHERE NISN=%s",                       
                       GetSQLValueString($_POST['kelas'], "text"),
                       GetSQLValueString($_POST['NISN'], "text"));
mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
  					   
 $gambar = $_FILES['foto']['name'];	
  if($gambar==''){
	    $updateSQL2 = sprintf("UPDATE pendaftaran SET nama_lengkap=%s, tahun_kelulusan=%s, nm_asl_sekolah=%s, jenis_kelamin=%s, tempat_lahir=%s, tanggal_lahir=%s, alamat=%s, no_telpon=%s, nm_orang_tua=%s, program=%s, pekerjaan_ortu=%s, tgl_daftar=%s WHERE no_daftar=%s",
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
                       GetSQLValueString($_POST['tgl_daftar'], "date"),
                       GetSQLValueString($_POST['no_daftar'], "int"));
  }else{
					   
  $updateSQL2 = sprintf("UPDATE pendaftaran SET nama_lengkap=%s, tahun_kelulusan=%s, nm_asl_sekolah=%s, jenis_kelamin=%s, tempat_lahir=%s, tanggal_lahir=%s, alamat=%s, no_telpon=%s, nm_orang_tua=%s, program=%s, pekerjaan_ortu=%s, foto=%s, tgl_daftar=%s WHERE no_daftar=%s",
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
					   GetSQLValueString($_POST['tgl_daftar'], "date"),					   
                       GetSQLValueString($_POST['no_daftar'], "int"));	

$gambar = $_FILES['foto']['name'];
$lokasi   = "../gambar/";
move_uploaded_file($_FILES['foto']['tmp_name'], $lokasi.$gambar);

  mysql_select_db($database_koneksi, $koneksi);
  $Result2 = mysql_query($updateSQL2, $koneksi) or die(mysql_error());
  
  }
 


  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
    echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_siswa' />";
}


$maxRows_siswa = 10;
$pageNum_siswa = 0;
if (isset($_GET['pageNum_siswa'])) {
  $pageNum_siswa = $_GET['pageNum_siswa'];
}
$startRow_siswa = $pageNum_siswa * $maxRows_siswa;

mysql_select_db($database_koneksi, $koneksi);
$query_siswa = "SELECT siswa.*, pendaftaran.* FROM siswa, pendaftaran WHERE  siswa.no_daftar=pendaftaran.no_daftar AND siswa.status='SISWA' ORDER BY siswa.no_daftar ASC";
$query_limit_siswa = sprintf("%s LIMIT %d, %d", $query_siswa, $startRow_siswa, $maxRows_siswa);
$siswa = mysql_query($query_limit_siswa, $koneksi) or die(mysql_error());
$row_siswa = mysql_fetch_assoc($siswa);

if (isset($_GET['totalRows_siswa'])) {
  $totalRows_siswa = $_GET['totalRows_siswa'];
} else {
  $all_siswa = mysql_query($query_siswa);
  $totalRows_siswa = mysql_num_rows($all_siswa);
}
$totalPages_siswa = ceil($totalRows_siswa/$maxRows_siswa)-1;

$colname_siswa_edit = "-1";
if (isset($_GET['recordID'])) {
  $colname_siswa_edit = $_GET['recordID'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_siswa_edit = sprintf("SELECT siswa.*, pendaftaran.* FROM siswa, pendaftaran WHERE  siswa.no_daftar=pendaftaran.no_daftar AND siswa.NISN = %s", GetSQLValueString($colname_siswa_edit, "text"));
$siswa_edit = mysql_query($query_siswa_edit, $koneksi) or die(mysql_error());
$row_siswa_edit = mysql_fetch_assoc($siswa_edit);
$totalRows_siswa_edit = mysql_num_rows($siswa_edit);

$queryString_siswa = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_siswa") == false && 
        stristr($param, "totalRows_siswa") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_siswa = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_siswa = sprintf("&totalRows_siswa=%d%s", $totalRows_siswa, $queryString_siswa);
?>

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	color: #000;
}
</style>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="80%" align="center" cellpadding="5" cellspacing="5">
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td height="38" colspan="2" align="center" valign="top" nowrap="nowrap"><strong>KELOLA DATA SISWA</strong></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td align="left" valign="top" nowrap="nowrap">NISN</td>
      <td valign="top"><span id="sprytextfield6">
        <label for="NISN"></label>
        <span id="sprytextfield2">
        <input name="NISN" type="text" id="NISN" value="<?php echo $row_siswa_edit['NISN']; ?>" />
        <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span><span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">No Daftar</td>
      <td><input name="no_daftar" type="text" value="<?php echo $row_siswa_edit['no_daftar']; ?>" size="10" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Nama Lengkap</td>
      <td><span id="sprytextfield1">
        <input type="text" name="nama_lengkap" value="<?php echo $row_siswa_edit['nama_lengkap']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
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
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Tahun Kelulusan</td>
      <td><input type="date" name="tahun_kelulusan" value="<?php echo $row_siswa_edit['tahun_kelulusan']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Nama Asal Sekolah</td>
      <td><input type="text" name="nm_asl_sekolah" value="<?php echo $row_siswa_edit['nm_asl_sekolah']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Jenis Kelamin</td>
      <td><input type="text" name="jenis_kelamin" value="<?php echo $row_siswa_edit['jenis_kelamin']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Tempat Lahir</td>
      <td><input type="text" name="tempat_lahir" value="<?php echo $row_siswa_edit['tempat_lahir']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Tanggal Lahir</td>
      <td><input type="date" name="tanggal_lahir" value="<?php echo $row_siswa_edit['tanggal_lahir']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Alamat</td>
      <td><input type="text" name="alamat" value="<?php echo $row_siswa_edit['alamat']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">No Telpon</td>
      <td><input type="text" name="no_telpon" value="<?php echo $row_siswa_edit['no_telpon']; ?>" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
      
      <script type="text/javascript">
	 function hanyaAngka (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return false;
		 return true;
	 }
	 </script>

      
      </td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Nama Orang Tua</td>
      <td><input type="text" name="nm_orang_tua" value="<?php echo $row_siswa_edit['nm_orang_tua']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Program</td>
      <td><input type="text" name="program" value="<?php echo $row_siswa_edit['program']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Pekerjaan Orang Tua</td>
      <td><input type="text" name="pekerjaan_ortu" value="<?php echo $row_siswa_edit['pekerjaan_ortu']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Foto</td>
      <td><label for="foto"></label>
      <input type="file" name="foto" id="foto" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Tanggal Daftar</td>
      <td><input name="tgl_daftar" type="text" value="<?php echo $row_siswa_edit['tgl_daftar']; ?>" size="20" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Kelas</td>
      <td><span id="sprytextfield3">
        <label for="kelas"></label>
        <input name="kelas" type="text" id="kelas" value="<?php echo $row_siswa_edit['kelas']; ?>" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">Tanggal Diterima</td>
      <td><input name="tgl_diterima" type="text" id="tgl_diterima" value="<?php $tgl=date('Y-m-d'); echo "$tgl"; ?>" size="20" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td nowrap="nowrap">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline" bgcolor="#FFFFFF">
      <td align="right" nowrap="nowrap"><input type="submit" value="SIMPAN" /></td>
      <td><input type="reset" name="Reset" id="button" value="BATAL" /></td>
    </tr>
    </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>

<table width="550" border="0" align="center" cellpadding="10" cellspacing="7">
  <tr align="center" bgcolor="#FFFFFF">
    <td width="80">NISN</td>
    <td width="80">No Daftar</td>
    <td>Nama Lengkap</td>
    <td>No Telpon</td>
    <td>Alamat</td>
    <td width="100">AKSI</td>
  </tr>
  <?php do { ?>
  <tr bgcolor="#FFFFFF">
    <td><?php echo $row_siswa['NISN']; ?></td>
    <td><?php echo $row_siswa['no_daftar']; ?></td>
    <td><?php echo $row_siswa['nama_lengkap']; ?>&nbsp; </td>
    <td><?php echo $row_siswa['no_telpon']; ?></td>
    <td><?php echo $row_siswa['alamat']; ?></td>
    <td align="center"> <a href="admin.php?menu=kelola_siswa&recordID=<?php echo $row_siswa['NISN']; ?>">Edit</a>&nbsp; <a href="admin.php?menu=kelola_siswa_hapus&recordID=<?php echo $row_siswa['NISN']; ?>">Hapus</a>&nbsp; <a href="kelola_siswa_cetak.php?recordID=<?php echo $row_siswa['NISN']; ?>">Cetak</a>&nbsp;</td>
  </tr>
  <?php } while ($row_siswa = mysql_fetch_assoc($siswa)); ?>
</table>
<br>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_siswa > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_siswa=%d%s", $currentPage, 0, $queryString_siswa); ?>">First</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_siswa > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_siswa=%d%s", $currentPage, max(0, $pageNum_siswa - 1), $queryString_siswa); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_siswa < $totalPages_siswa) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_siswa=%d%s", $currentPage, min($totalPages_siswa, $pageNum_siswa + 1), $queryString_siswa); ?>">Next</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_siswa < $totalPages_siswa) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_siswa=%d%s", $currentPage, $totalPages_siswa, $queryString_siswa); ?>">Last</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<p>&nbsp;</p>
<p>
  <?php
mysql_free_result($siswa);

mysql_free_result($siswa_edit);
?>
</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["change"], useCharacterMasking:true});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["change"]});
</script>
