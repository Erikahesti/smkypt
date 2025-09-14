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
  $updateSQL = sprintf("UPDATE kontak SET isi=%s WHERE id_kontak=%s",
                       GetSQLValueString($_POST['isi'], "text"),
                       GetSQLValueString($_POST['id_kontak'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
}

mysql_select_db($database_koneksi, $koneksi);
$query_kontak = "SELECT * FROM kontak WHERE id_kontak='1'";
$kontak = mysql_query($query_kontak, $koneksi) or die(mysql_error());
$row_kontak = mysql_fetch_assoc($kontak);
$totalRows_kontak = mysql_num_rows($kontak);
?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">

<p align="center"><strong>KELOLA KONTAK KAMI</strong></p>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td width="135">ID Kontak</td>
      <td width="345"><label for="id_kontak"></label>
      <input name="id_kontak" type="text" id="id_kontak" value="<?php echo $row_kontak['id_kontak']; ?>" size="10"></td>
    </tr>
    <tr>
      <td valign="top">Isi</td>
      <td valign="top"><span id="sprytextarea1">
        <label for="isi"></label>
        <textarea name="isi" id="isi" cols="45" rows="5"><?php echo $row_kontak['isi']; ?></textarea>
      <span class="textareaRequiredMsg"><br> 
      Harus di isi.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Simpan">
      <input type="reset" name="button2" id="button2" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
mysql_free_result($kontak);
?>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["change"]});
</script>
