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

$maxRows_berita = 10;
$pageNum_berita = 0;
if (isset($_GET['pageNum_berita'])) {
  $pageNum_berita = $_GET['pageNum_berita'];
}
$startRow_berita = $pageNum_berita * $maxRows_berita;

mysql_select_db($database_koneksi, $koneksi);
$query_berita = "SELECT * FROM berita ORDER BY id_berita ASC";
$query_limit_berita = sprintf("%s LIMIT %d, %d", $query_berita, $startRow_berita, $maxRows_berita);
$berita = mysql_query($query_limit_berita, $koneksi) or die(mysql_error());
$row_berita = mysql_fetch_assoc($berita);

if (isset($_GET['totalRows_berita'])) {
  $totalRows_berita = $_GET['totalRows_berita'];
} else {
  $all_berita = mysql_query($query_berita);
  $totalRows_berita = mysql_num_rows($all_berita);
}
$totalPages_berita = ceil($totalRows_berita/$maxRows_berita)-1;

$queryString_berita = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_berita") == false && 
        stristr($param, "totalRows_berita") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_berita = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_berita = sprintf("&totalRows_berita=%d%s", $totalRows_berita, $queryString_berita);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO berita (id_berita, judul, isi_berita) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_berita'], "int"),
                       GetSQLValueString($_POST['judul'], "text"),
                       GetSQLValueString($_POST['isi_berita'], "text"));


  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
  
   echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_berita' />";
}
?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<p align="center">KELOLA BERITA</p>
<p>&nbsp;</p>
<?php 
$query = "SELECT MAX(id_berita) AS maxID FROM berita";

$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idMax = $data['maxID'];

$idMax++;

$nourut = $idMax;
?>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
  <table width="400" align="center">
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Id Berita</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><input name="id_berita" type="text" value="<?php echo $nourut; ?>" size="15" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Judul</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><span id="sprytextfield1">
        <label for="judul"></label>
        <input type="text" name="judul" id="judul">
      <span class="textfieldRequiredMsg">Harus diisi</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Isi Berita</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><span id="sprytextarea1">
        <label for="isi"></label>
        <textarea name="isi_berita" id="isi" cols="35" rows="5"></textarea>
      <span class="textareaRequiredMsg">Harus diisi</span></span></td>
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
<table border="1" align="center">
  <tr align="center">
    <td width="50">ID berita</td>
    <td width="200">Judul</td>
    <td>Isi Berita</td>
    <td colspan="2">Aksi</td>
  </tr>
  <?php do { ?>
  <tr valign="top">
    <td><?php echo $row_berita['id_berita']; ?>&nbsp; </td>
    <td><?php echo $row_berita['judul']; ?>&nbsp; </td>
    <td><?php echo $row_berita['isi_berita']; ?>&nbsp; </td>
    <td>&nbsp; <a href="admin.php?menu=kelola_berita_edit&recordID=<?php echo $row_berita['id_berita']; ?>">Edit</a> &nbsp;</td>
    <td>&nbsp; <a href="admin.php?menu=kelola_berita_hapus&recordID=<?php echo $row_berita['id_berita']; ?>">Hapus</a> &nbsp;</td>
  </tr>
  <?php } while ($row_berita = mysql_fetch_assoc($berita)); ?>
</table>
<br />
<table border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td><a href="<?php printf("%s?pageNum_berita=%d%s", $currentPage, max(0, $pageNum_berita - 1), $queryString_berita); ?>">Back</a></td>
    <td><a href="<?php printf("%s?pageNum_berita=%d%s", $currentPage, min($totalPages_berita, $pageNum_berita + 1), $queryString_berita); ?>">Next</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["change"]});
</script>
<?php
mysql_free_result($berita);
?>
