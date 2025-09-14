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
  $updateSQL = sprintf("UPDATE guru SET nama=%s, jabatan=%s, jenis_kelamin=%s, template_lahir=%s, tanggal_lahir=%s, agama=%s, alamat=%s, no_telpon=%s, pendidikan=%s WHERE NIP=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['template_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telpon'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['NIP'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_guru' />";
}

$colname_guru = "-1";
if (isset($_GET['recordID'])) {
  $colname_guru = $_GET['recordID'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_guru = sprintf("SELECT * FROM guru WHERE NIP = %s", GetSQLValueString($colname_guru, "int"));
$guru = mysql_query($query_guru, $koneksi) or die(mysql_error());
$row_guru = mysql_fetch_assoc($guru);
$totalRows_guru = mysql_num_rows($guru);
?>
<p align="center"><strong>KELOLA DATA GURU</strong></p>
<div style="border:1px solid #333; width:500px; margin:0 auto; padding:30px">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
    <table width="450" align="center" cellpadding="5" cellspacing="0">
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>NIP</td>
        <td valign="top"><input type="text" name="NIP" value="<?php echo $row_guru['NIP']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Nama</td>
        <td valign="top"><input type="text" name="nama" value="<?php echo $row_guru['nama']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top" nowrap>Jabatan</td>
        <td valign="top"><input type="text" name="jabatan" value="<?php echo $row_guru['jabatan']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top" nowrap>Jenis Kelamin</td>
        <td valign="top"><label for="jenis_kelamin"></label>
          <select name="jenis_kelamin" id="jenis_kelamin">
            <option value="laki-laki">laki-laki</option>
            <option value="perempuan">perempuan</option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Tempat Lahir</td>
        <td valign="top"><input name="template_lahir" type="text" id="template_lahir" value="<?php echo $row_guru['template_lahir']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top" nowrap>Tanggal Lahir</td>
        <td valign="top"><input name="tanggal_lahir" type="date" id="tanggal_lahir" value="<?php echo $row_guru['tanggal_lahir']; ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Agama</td>
        <td valign="top"><input type="text" name="agama" value="<?php echo $row_guru['agama']; ?>" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top" nowrap>Alamat</td>
        <td valign="top"><input type="text" name="alamat" value="<?php echo $row_guru['alamat']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>No Telpon</td>
        <td valign="top"><input type="text" name="no_telpon" value="<?php echo $row_guru['no_telpon']; ?>" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
        
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
        <td align="left" valign="top" nowrap>Pendidikan</td>
        <td valign="top"><input type="text" name="pendidikan" value="<?php echo $row_guru['pendidikan']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><input type="submit" value="SIMPAN"></td>
        <td><input type="reset" name="Reset" id="button" value="BATAL"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
  </form>
</div>
<p>&nbsp;</p>
<?php
mysql_free_result($guru);
?>
