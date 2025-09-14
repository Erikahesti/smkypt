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

$maxRows_profil = 10;
$pageNum_profil = 0;
if (isset($_GET['pageNum_profil'])) {
  $pageNum_profil = $_GET['pageNum_profil'];
}
$startRow_profil = $pageNum_profil * $maxRows_profil;

mysql_select_db($database_koneksi, $koneksi);
$query_profil = "SELECT * FROM profil ORDER BY id_profil ASC";
$query_limit_profil = sprintf("%s LIMIT %d, %d", $query_profil, $startRow_profil, $maxRows_profil);
$profil = mysql_query($query_limit_profil, $koneksi) or die(mysql_error());
$row_profil = mysql_fetch_assoc($profil);

if (isset($_GET['totalRows_profil'])) {
  $totalRows_profil = $_GET['totalRows_profil'];
} else {
  $all_profil = mysql_query($query_profil);
  $totalRows_profil = mysql_num_rows($all_profil);
}
$totalPages_profil = ceil($totalRows_profil/$maxRows_profil)-1;

$queryString_profil = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_profil") == false && 
        stristr($param, "totalRows_profil") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_profil = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_profil = sprintf("&totalRows_profil=%d%s", $totalRows_profil, $queryString_profil);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $gambarnya = $_FILES['gambar']['name'];
  $insertSQL = sprintf("INSERT INTO profil (id_profil, judul, isi, gambar) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_profil'], "int"),
                       GetSQLValueString($_POST['judul'], "text"),
                       GetSQLValueString($_POST['isi'], "text"),
                       GetSQLValueString($gambarnya, "text"));
  
  $gambarnya = $_FILES['gambar']['name'];
  $lokasi   = "../gambar/";
  move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$gambarnya);

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
  
   echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_profil' />";
}
?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<p align="center">KELOLA PROFIL</p>
<p>&nbsp;</p>
<?php 
$query = "SELECT MAX(id_profil) AS maxID FROM profil";

$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idMax = $data['maxID'];

$idMax++;

$nourut = $idMax;
?>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
  <table width="400" align="center">
    <tr valign="baseline">
      <td align="left" valign="top" nowrap>Id Profil</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><input name="id_profil" type="text" value="<?php echo $nourut; ?>" size="15" readonly="readonly"></td>
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
      <td align="left" valign="top" nowrap>Isi</td>
      <td align="left" valign="top" nowrap>:</td>
      <td align="left" valign="top"><span id="sprytextarea1">
        <label for="isi"></label>
        <textarea name="isi" id="isi" cols="35" rows="5"></textarea>
      <span class="textareaRequiredMsg">Harus diisi</span></span></td>
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
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<table border="1" align="center">
  <tr align="center">
    <td>ID Profil</td>
    <td>Judul</td>
    <td>Isi</td>
    <td>Gambar</td>
    <td colspan="2">Aksi</td>
  </tr>
  <?php do { ?>
  <tr valign="top">
    <td><?php echo $row_profil['id_profil']; ?>&nbsp; </td>
    <td><?php echo $row_profil['judul']; ?>&nbsp; </td>
    <td><?php echo strip_tags(substr(substr($row_profil['isi'],0,200),0,strrpos(substr($row_profil['isi'],0,200),' '))); ?>&nbsp; </td>
    <td><?php if($row_profil['gambar']!=''){ ?>&nbsp;<img src="../gambar/<?php echo $row_profil['gambar']; ?>" width="100" height="80" />      <?php } ?></td>
    <td>&nbsp; <a href="admin.php?menu=kelola_profil_edit&recordID=<?php echo $row_profil['id_profil']; ?>">Edit</a> &nbsp;</td>
    <td>&nbsp; <a href="admin.php?menu=kelola_profil_hapus&recordID=<?php echo $row_profil['id_profil']; ?>">Hapus</a> &nbsp;</td>
  </tr>
  <?php } while ($row_profil = mysql_fetch_assoc($profil)); ?>
</table>
<br />
<table border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td><a href="<?php printf("%s?pageNum_profil=%d%s", $currentPage, max(0, $pageNum_profil - 1), $queryString_profil); ?>">Back</a></td>
    <td><a href="<?php printf("%s?pageNum_profil=%d%s", $currentPage, min($totalPages_profil, $pageNum_profil + 1), $queryString_profil); ?>">Next</a></td>
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
mysql_free_result($profil);
?>
