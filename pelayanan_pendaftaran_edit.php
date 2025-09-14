<?php require_once('Connections/koneksi.php'); ?><?php
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
$gambar = $_FILES['foto']['name'];	
  if($gambar==''){
	    $updateSQL = sprintf("UPDATE pendaftaran SET nama_lengkap=%s, tahun_kelulusan=%s, nm_asl_sekolah=%s, jenis_kelamin=%s, tempat_lahir=%s, tanggal_lahir=%s, alamat=%s, no_telpon=%s, nm_orang_tua=%s, program=%s, pekerjaan_ortu=%s, tgl_daftar=%s WHERE no_daftar=%s",
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
					   
  $updateSQL = sprintf("UPDATE pendaftaran SET nama_lengkap=%s, tahun_kelulusan=%s, nm_asl_sekolah=%s, jenis_kelamin=%s, tempat_lahir=%s, tanggal_lahir=%s, alamat=%s, no_telpon=%s, nm_orang_tua=%s, program=%s, pekerjaan_ortu=%s, foto=%s, tgl_daftar=%s WHERE no_daftar=%s",
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
                       GetSQLValueString($gambar, "date"),
					   GetSQLValueString($_POST['tgl_daftar'], "date"),					   
                       GetSQLValueString($_POST['no_daftar'], "int"));	
  }

  $gambar = $_FILES['foto']['name'];
$lokasi   = "gambar/";
move_uploaded_file($_FILES['foto']['tmp_name'], $lokasi.$gambar);

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "index.php?menu=pelayanan_pendaftaran_sukses&no_daftar=";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
    echo	"<meta http-equiv='refresh' content='0;URL=index.php?menu=pelayanan_pendaftaran_sukses&no_daftar=".$_POST['no_daftar']."' />";
}

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_DetailRS1 = sprintf("SELECT * FROM pendaftaran  WHERE no_daftar = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $koneksi) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="500" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap"><strong>EDIT PENDAFTARAN ONLINE</strong></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">No Daftar</td>
      <td><input name="no_daftar" type="text" value="<?php echo $row_DetailRS1['no_daftar']; ?>" size="20" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Nama Lengkap</td>
      <td><input type="text" name="nama_lengkap" value="<?php echo $row_DetailRS1['nama_lengkap']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
      <td><input type="text" name="tahun_kelulusan" value="<?php echo $row_DetailRS1['tahun_kelulusan']; ?>" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
      
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
    <tr valign="baseline">
      <td nowrap="nowrap">Nama Asal Sekolah</td>
      <td><span id="sprytextfield1">
        <input type="text" name="nm_asl_sekolah" value="<?php echo $row_DetailRS1['nm_asl_sekolah']; ?>" size="32" />
      <span class="textfieldRequiredMsg">harus di isi.</span></span></td>
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
      <td><input type="text" name="tempat_lahir" value="<?php echo $row_DetailRS1['tempat_lahir']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
      <td><input type="date" name="tanggal_lahir" value="<?php echo $row_DetailRS1['tanggal_lahir']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Alamat</td>
      <td><span id="sprytextfield2">
        <input type="text" name="alamat" value="<?php echo $row_DetailRS1['alamat']; ?>" size="32" />
      <span class="textfieldRequiredMsg">harap di isi.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">No Telpon</td>
      <td><input type="text" name="no_telpon" value="<?php echo $row_DetailRS1['no_telpon']; ?>" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
      
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
    <tr valign="baseline">
      <td nowrap="nowrap">Nama Orang Tua</td>
      <td><input type="text" name="nm_orang_tua" value="<?php echo $row_DetailRS1['nm_orang_tua']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
      <td><input type="text" name="agama" value="<?php echo $row_DetailRS1['program']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
      <td nowrap="nowrap">Pekerjaan Orang Tua</td>
      <td><input type="text" name="pekerjaan_ortu" value="<?php echo $row_DetailRS1['pekerjaan_ortu']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
      
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
      <td><input name="tgl_daftar" type="date" value="<?php echo $row_DetailRS1['tgl_daftar']; ?>" size="20" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap"><input type="submit" value="SIMPAN PERUBAHAN" /></td>
      <td><input type="reset" name="Reset" id="button" value="BATAL" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1">
</form>
<?php
mysql_free_result($DetailRS1);
?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
</script>
