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

$maxRows_alumni = 10;
$pageNum_alumni = 0;
if (isset($_GET['pageNum_alumni'])) {
  $pageNum_alumni = $_GET['pageNum_alumni'];
}
$startRow_alumni = $pageNum_alumni * $maxRows_alumni;

mysql_select_db($database_koneksi, $koneksi);
$query_alumni = "SELECT * FROM alumni,siswa,pendaftaran WHERE siswa.no_daftar=pendaftaran.no_daftar AND siswa.NISN=alumni.NISN AND pendaftaran.nama_lengkap LIKE '%$_GET[katakunci]%' OR alumni.NIA ='$_GET[katakunci]' GROUP BY alumni.NIA";
$query_limit_alumni = sprintf("%s LIMIT %d, %d", $query_alumni, $startRow_alumni, $maxRows_alumni);
$alumni = mysql_query($query_limit_alumni, $koneksi) or die(mysql_error());
$row_alumni = mysql_fetch_assoc($alumni);

if (isset($_GET['totalRows_alumni'])) {
  $totalRows_alumni = $_GET['totalRows_alumni'];
} else {
  $all_alumni = mysql_query($query_alumni);
  $totalRows_alumni = mysql_num_rows($all_alumni);
}
$totalPages_alumni = ceil($totalRows_alumni/$maxRows_alumni)-1;

$queryString_alumni = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_alumni") == false && 
        stristr($param, "totalRows_alumni") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_alumni = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_alumni = sprintf("&totalRows_alumni=%d%s", $totalRows_alumni, $queryString_alumni);

?>

<p align="center"><strong>DATA ALUMNI</strong></p>
<form id="form1" name="form1" method="get" action="">
<input type="hidden" name="menu" id="pelayanan_alumni" value="pelayanan_alumni" />

  <label for="katakunci"></label>
  <table width="300" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td align="right"><input type="text" name="katakunci" id="katakunci" /></td>
      <td><input type="submit" name="button" id="button" value="CARI" /></td>
    </tr>
  </table>
</form><br />

<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr align="center">
    <td width="100"><h3>Foto Alumni</h3></td>
    <td width="100"><strong>Nomor <br />
    Induk Alumni</strong></td>
    <td><strong>Nama Alumni</strong></td>
    <td><strong>Alamat</strong></td>
    <td width="50"><strong>Aksi</strong></td>
  </tr>
  <?php do { ?>
    <tr align="center">
      <td><?php if($row_alumni['foto']!=''){ ?><img src="gambar/<?php echo $row_alumni['foto']; ?>" height="100" width="100"/><?php } ?></td>
      <td><a href="pelayanan_alumni_detail.php?recordID=<?php echo $row_alumni['NIA']; ?>"> <?php echo $row_alumni['NIA']; ?></a></td>
      <td><?php echo $row_alumni['nama_lengkap']; ?>&nbsp; </td>
      <td><?php echo $row_alumni['alamat']; ?>&nbsp; </td>
      <td><a href="index.php?menu=pelayanan_alumni_detail&recordID=<?php echo $row_alumni['NIA']; ?>">Detail</a>&nbsp; </td>
    </tr>
    <?php } while ($row_alumni = mysql_fetch_assoc($alumni)); ?>
</table>
<br />
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_alumni > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_alumni=%d%s", $currentPage, 0, $queryString_alumni); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_alumni > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_alumni=%d%s", $currentPage, max(0, $pageNum_alumni - 1), $queryString_alumni); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_alumni < $totalPages_alumni) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_alumni=%d%s", $currentPage, min($totalPages_alumni, $pageNum_alumni + 1), $queryString_alumni); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_alumni < $totalPages_alumni) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_alumni=%d%s", $currentPage, $totalPages_alumni, $queryString_alumni); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
  <?php
mysql_free_result($alumni);
?>
</p>
