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

$colname_pendaftaran = "-1";
if (isset($_GET['no_daftar'])) {
  $colname_pendaftaran = $_GET['no_daftar'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_pendaftaran = sprintf("SELECT * FROM pendaftaran WHERE no_daftar = %s", GetSQLValueString($colname_pendaftaran, "int"));
$pendaftaran = mysql_query($query_pendaftaran, $koneksi) or die(mysql_error());
$row_pendaftaran = mysql_fetch_assoc($pendaftaran);
$totalRows_pendaftaran = mysql_num_rows($pendaftaran);

$queryString_pendaftaran = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_pendaftaran") == false && 
        stristr($param, "totalRows_pendaftaran") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_pendaftaran = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_pendaftaran = sprintf("&totalRows_pendaftaran=%d%s", $totalRows_pendaftaran, $queryString_pendaftaran);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p align="center"><strong>KONFIRMASI SUKSES PENDAFTARAN ONLINE</strong></p>
<h3 align="center"><strong>Terima Kasih telah melakukan Pendaftaran Siswa secara online, Silahkan Cetak Bukti Pendaftaran di bawah ini, dan diharapkan calon siswa utuk datang melengkapi berkas pendaftaran, ditunggu selama 3 hari setelah mendaftar</strong></h3>
<h3 align="center"><strong>note : membawa surat keterangan lulus, nilai rapot, kartu keluarga, akte kelahiran, bukti nomor pendaftaran</strong><strong><br />
</strong></h3>
<table border="1" align="center" cellpadding="5" cellspacing="0">
  <tr align="center">
    <td><strong>No Daftar</strong></td>
    <td><strong>Nama Lengkap</strong></td>
    <td><strong>Jenis Kelamin</strong></td>
    <td><strong>Tanggal Daftar</strong></td>
    <td width="100"><strong>Aksi</strong></td>
  </tr>
  <tr align="center">
    <td><?php echo $row_pendaftaran['no_daftar']; ?></td>
    <td><?php echo $row_pendaftaran['nama_lengkap']; ?>&nbsp; </td>
    <td><?php echo $row_pendaftaran['jenis_kelamin']; ?>&nbsp; </td>
    <td><?php echo $row_pendaftaran['tgl_daftar']; ?>&nbsp; </td>
    <td><a href="pelayanan_pendaftaran_cetak.php?recordID=<?php echo $row_pendaftaran['no_daftar']; ?>">Cetak</a> || <a href="index.php?menu=pelayanan_pendaftaran_edit&recordID=<?php echo $row_pendaftaran['no_daftar']; ?>">Edit</a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($pendaftaran);
?>
