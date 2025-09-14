<?php require_once('../Connections/koneksi.php'); ?><?php
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
$gambar = $_FILES['gambar']['name'];
  
  if($gambar==''){
  $updateSQL = sprintf("UPDATE galeri SET keterangan=%s WHERE id_galeri=%s",
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['id_galeri'], "int"));
					   
  }else{
  $updateSQL = sprintf("UPDATE galeri SET keterangan=%s, photo=%s WHERE id_galeri=%s",
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($gambar , "text"),
                       GetSQLValueString($_POST['id_galeri'], "int"));					   
  }
  
  $gambar = $_FILES['gambar']['name'];
$lokasi   = "../gambar/";
move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$gambar);

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
    echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_galeri' />";

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
$query_DetailRS1 = sprintf("SELECT * FROM galeri WHERE id_galeri = %s ORDER BY id_galeri ASC", GetSQLValueString($colname_DetailRS1, "int"));
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
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css"><br>
<p align="center">EDIT GALERI</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
  <table width="400" align="center">
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Id Galeri</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><input name="id_galeri" type="text" value="<?php echo $row_DetailRS1['id_galeri']; ?>" size="15" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Keterangan</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><span id="sprytextfield1">
        <label for="keterangan"></label>
        <input name="keterangan" type="text" id="keterangan" value="<?php echo $row_DetailRS1['keterangan']; ?>">
      <span class="textfieldRequiredMsg">Harus diisi</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Gambar</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><label for="gambar"></label>
      <input type="file" name="gambar" id="gambar"></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>&nbsp;</td>
      <td align="left" valign="top" nowrap>&nbsp;</td>
      <td align="left" valign="top"><input type="submit" value="Simpan">
      <input type="reset" name="Reset" id="button" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
</script>
<?php
mysql_free_result($DetailRS1);
?>