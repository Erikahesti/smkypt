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

$maxRows_galeri = 10;
$pageNum_galeri = 0;
if (isset($_GET['pageNum_galeri'])) {
  $pageNum_galeri = $_GET['pageNum_galeri'];
}
$startRow_galeri = $pageNum_galeri * $maxRows_galeri;

mysql_select_db($database_koneksi, $koneksi);
$query_galeri = "SELECT * FROM galeri ORDER BY id_galeri ASC";
$query_limit_galeri = sprintf("%s LIMIT %d, %d", $query_galeri, $startRow_galeri, $maxRows_galeri);
$galeri = mysql_query($query_limit_galeri, $koneksi) or die(mysql_error());
$row_galeri = mysql_fetch_assoc($galeri);

if (isset($_GET['totalRows_galeri'])) {
  $totalRows_galeri = $_GET['totalRows_galeri'];
} else {
  $all_galeri = mysql_query($query_galeri);
  $totalRows_galeri = mysql_num_rows($all_galeri);
}
$totalPages_galeri = ceil($totalRows_galeri/$maxRows_galeri)-1;

$queryString_galeri = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_galeri") == false && 
        stristr($param, "totalRows_galeri") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_galeri = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_galeri = sprintf("&totalRows_galeri=%d%s", $totalRows_galeri, $queryString_galeri);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $gambar = $_FILES['gambar']['name'];
  $insertSQL = sprintf("INSERT INTO galeri (id_galeri, photo, keterangan) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_galeri'], "int"),
					   GetSQLValueString($gambar, "text"),
                       GetSQLValueString($_POST['keterangan'], "text"));
  
  $gambar = $_FILES['gambar']['name'];
  $lokasi   = "../gambar/";
  move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$gambar);

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
  
   echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_galeri' />";
}
?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<p align="center">KELOLA GALERI</p>
<p>&nbsp;</p>
<?php 
$query = "SELECT MAX(id_galeri) AS maxID FROM galeri";

$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idMax = $data['maxID'];

$idMax++;

$nourut = $idMax;
?>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
  <table width="400" align="center">
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Id Galeri</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><input name="id_galeri" type="text" value="<?php echo $nourut; ?>" size="15" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Gambar</td>
      <td align="left" valign="top" nowrap="nowrap">:</td>
      <td align="left" valign="top"><label for="gambar"></label>
        <input type="file" name="gambar" id="gambar" /></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Keterangan</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><span id="sprytextfield1">
        <label for="keterangan"></label>
        <input name="keterangan" type="text" id="keterangan" size="40">
      <span class="textfieldRequiredMsg">Harus diisi</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>&nbsp;</td>
      <td align="left" valign="top" nowrap>&nbsp;</td>
      <td align="left" valign="top"><input type="submit" value="Simpan">
      <input type="reset" name="Reset" id="button" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<table width="600" border="1" align="center">
  <tr align="center">
    <td>ID Galeri</td>
    <td>Photo</td>
    <td>Keterangan</td>
    <td colspan="2">Aksi</td>
  </tr>
  <?php do { ?>
  <tr valign="top">
    <td align="center"><?php echo $row_galeri['id_galeri']; ?>&nbsp; </td>
    <td><?php if($row_galeri['photo']!=''){ ?>&nbsp;<img src="../gambar/<?php echo $row_galeri['photo']; ?>" width="100" height="80" />      <?php } ?></td>
    <td><?php echo $row_galeri['keterangan']; ?></td>
    <td align="center">&nbsp; <a href="admin.php?menu=kelola_galeri_edit&recordID=<?php echo $row_galeri['id_galeri']; ?>">Edit</a> &nbsp;</td>
    <td align="center">&nbsp; <a href="admin.php?menu=kelola_galeri_hapus&recordID=<?php echo $row_galeri['id_galeri']; ?>">Hapus</a> &nbsp;</td>
  </tr>
  <?php } while ($row_galeri = mysql_fetch_assoc($galeri)); ?>
</table>
<br />
<table border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td><a href="<?php printf("%s?pageNum_galeri=%d%s", $currentPage, max(0, $pageNum_galeri - 1), $queryString_galeri); ?>">Back</a></td>
    <td><a href="<?php printf("%s?pageNum_galeri=%d%s", $currentPage, min($totalPages_galeri, $pageNum_galeri + 1), $queryString_galeri); ?>">Next</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
</script>
<?php
mysql_free_result($galeri);
?>
