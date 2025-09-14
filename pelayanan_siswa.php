<?php require_once('Connections/koneksi.php'); ?>
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

$maxRows_siswa = 10;
$pageNum_siswa = 0;
if (isset($_GET['pageNum_siswa'])) {
  $pageNum_siswa = $_GET['pageNum_siswa'];
}
$startRow_siswa = $pageNum_siswa * $maxRows_siswa;

mysql_select_db($database_koneksi, $koneksi);
if($_GET['button']=='CARI'){
$query_siswa = "SELECT siswa.*, pendaftaran.* FROM siswa, pendaftaran WHERE  siswa.no_daftar=pendaftaran.no_daftar AND siswa.status='SISWA' AND pendaftaran.nama_lengkap LIKE '%$_GET[katakunci]%' OR siswa.NISN LIKE '%$_GET[katakunci]%' GROUP BY siswa.NISN ORDER BY siswa.NISN ASC";
}else{
$query_siswa = "SELECT siswa.*, pendaftaran.* FROM siswa, pendaftaran WHERE  siswa.no_daftar=pendaftaran.no_daftar AND siswa.status='SISWA' GROUP BY siswa.NISN ORDER BY siswa.NISN ASC";
}
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

<p align="center"><strong>DATA SISWA</strong></p>
<form id="form1" name="form1" method="get" action="">
<input type="hidden" name="menu" id="pelayanan_siswa" value="pelayanan_siswa" />
  <label for="katakunci"></label>
  <table width="300" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td align="right"><input type="text" name="katakunci" id="katakunci" /></td>
      <td><input type="submit" name="button" id="button" value="CARI" /></td>
    </tr>
  </table>
</form>
<br />
<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr align="center">
    <td><strong>NISN</strong></td>
    <td><strong>Nama Lengkap</strong></td>
    <td><strong>Kelas</strong></td>
    <td><strong>Foto</strong></td>
    <td><strong>Aksi</strong></td>
  </tr>
  <?php do { ?>
    <tr align="center">
      <td valign="top"><?php echo $row_siswa['NISN']; ?></td>
      <td><?php echo $row_siswa['nama_lengkap']; ?>&nbsp; </td>
      <td><?php echo $row_siswa['kelas']; ?>&nbsp; </td>
      <td><img src="gambar/<?php echo $row_siswa['foto']; ?>" width="100" height="120" /></td>
      <td>&nbsp; <a href="index.php?menu=pelayanan_siswa_detail&recordID=<?php echo $row_siswa['NISN']; ?>">Detail</a></td>
    </tr>
    <?php } while ($row_siswa = mysql_fetch_assoc($siswa)); ?>
</table>
<br />
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
<p align="center">&nbsp;</p>
<?php
mysql_free_result($siswa);
?>
