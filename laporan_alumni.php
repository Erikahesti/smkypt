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

mysql_select_db($database_koneksi, $koneksi);
$query_alumni = "SELECT siswa.*, alumni.*, pendaftaran.* FROM siswa, alumni, pendaftaran WHERE siswa.no_daftar=pendaftaran.no_daftar AND siswa.NISN=alumni.NISN AND alumni.tahun_tamat='$_GET[tahun]'";
$alumni = mysql_query($query_alumni, $koneksi) or die(mysql_error());
$row_alumni = mysql_fetch_assoc($alumni);
$totalRows_alumni = mysql_num_rows($alumni);

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="900" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="738" align="center"><h2> PONDOK PESANTREN ASSANADIYAH</h2>
    <p>&nbsp;</p></td>
    <td width="136" align="center"><img src="../logo11.jpg" alt="" width="134" height="113" align="left" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p>&nbsp;</p>
      <p><strong>LAPORAN DATA ALUMNI</strong></p>
      <p><strong>TAHUN</strong> <strong><?php echo "$_GET[tahun]";?></strong></p>
      <p>&nbsp;      </p>
      <table border="1" align="center">
        <tr>
          <td>NIA</td>
          <td>NISN</td>
          <td>Nama Lengkap</td>
          <td>Jenis Kelamin</td>
          <td>no_ijazah</td>
          <td>tahun_tamat</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="laporan_alumni_detail.php?recordID=<?php echo $row_alumni['NIA']; ?>"> <?php echo $row_alumni['NIA']; ?>&nbsp; </a></td>
            <td><?php echo $row_alumni['NISN']; ?>&nbsp; </td>
            <td><?php echo $row_alumni['nama_lengkap']; ?></td>
            <td><?php echo $row_alumni['jenis_kelamin']; ?></td>
            <td><?php echo $row_alumni['no_ijazah']; ?>&nbsp; </td>
            <td><?php echo $row_alumni['tahun_tamat']; ?>&nbsp; </td>
          </tr>
          <?php } while ($row_alumni = mysql_fetch_assoc($alumni)); ?>
      </table>
      <br />
      <p>&nbsp; <br />
<p align="right">Palembang, <?php echo date('d-m-Y'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p>&nbsp;</p>
      <p align="right">&nbsp;&nbsp; Kepala Sekolah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p align="left">&nbsp; &nbsp; <input type="submit" name="button" id="button" value="CETAK" onClick="window.print();"></p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($alumni);
?>
