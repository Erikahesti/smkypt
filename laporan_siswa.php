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
$query_siswa = "SELECT siswa.*, pendaftaran.* FROM siswa, pendaftaran WHERE siswa.no_daftar=pendaftaran.no_daftar AND siswa.kelas='$_GET[kelas]'";
$siswa = mysql_query($query_siswa, $koneksi) or die(mysql_error());
$row_siswa = mysql_fetch_assoc($siswa);
$totalRows_siswa = mysql_num_rows($siswa);

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="900" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="738" align="center"><h2>SMK YAYASAN PENDIDIKAN TELKOM (YPT) PEMBANGUNAN</h2>
    <p>&nbsp;</p></td>
    <td width="136" align="center"><img src="../gambar/logo11.jpg" alt="" width="146" height="146" align="left" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p>&nbsp;</p>
      <p><strong>LAPORAN DATA SISWA</strong></p>
      <p>&nbsp; 
        <strong>KELAS <?php echo "$_GET[kelas]";?></strong>
      <p>
      <p>&nbsp; </p>      
      <table border="1" align="center">
        <tr>
          <td>NIS</td>
          <td>Nomor Pendaftaran</td>
          <td>Nama Lengkap</td>
          <td>Jenis Kelamin</td>
          <td>Tanggal Lahir</td>
          <td>Tempat Lahir</td>
          <td>Alamat</td>
          <td>kelas</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="laporan_siswa_detail.php?recordID=<?php echo $row_siswa['NISN']; ?>"> <?php echo $row_siswa['NISN']; ?>&nbsp; </a></td>
            <td><?php echo $row_siswa['no_daftar']; ?>&nbsp; </td>
            <td><?php echo $row_siswa['nama_lengkap']; ?></td>
            <td><?php echo $row_siswa['jenis_kelamin']; ?></td>
            <td><?php echo $row_siswa['tanggal_lahir']; ?></td>
            <td><?php echo $row_siswa['tempat_lahir']; ?></td>
            <td><?php echo $row_siswa['alamat']; ?></td>
            <td><?php echo $row_siswa['kelas']; ?>&nbsp; </td>
          </tr>
          <?php } while ($row_siswa = mysql_fetch_assoc($siswa)); ?>
      </table>
      <br />
      <br />
<p align="right">Palembang, <?php echo date('d-m-Y'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p>&nbsp;</p>
      <p align="right">&nbsp;&nbsp; Kepala Sekolah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p>&nbsp;</p> <p align="left">&nbsp; &nbsp; <input type="submit" name="button" id="button" value="CETAK" onClick="window.print();"></p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($siswa);
?>
