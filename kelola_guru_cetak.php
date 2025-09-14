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
$query_DetailRS1 = sprintf("SELECT * FROM guru WHERE NIP = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Guru</title>
</head>

<body>
<div style="border:1px solid #333; width:500px; margin:0 auto; padding:10px">
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="3" align="left" valign="top" nowrap="nowrap"><h3 align="center"><img src="../logo pti.png" alt="" width="90" height="113" align="left" /><br>
      SMP PTI PALEMBANG</h3>
      <p align="center">Jalan Mesuji III/ Sei Putih No. 3264 <br />
        Kec. Ilir Barat 1  Kel. Demang Lebar Daun Pakjo  Kota Palembang    </p>
      <hr /></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top" nowrap="nowrap"><strong>DATA GURU</strong></td>
  </tr>
  <tr>
    <td width="62" align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td width="137" align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td width="271">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>NIP</td>
    <td>: <?php echo $row_DetailRS1['NIP']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Nama</td>
    <td>: <?php echo $row_DetailRS1['nama']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Jabatan</td>
    <td>: <?php echo $row_DetailRS1['jabatan']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Jenis Kelamin</td>
    <td>: <?php echo $row_DetailRS1['jenis_kelamin']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Tempat Lahir</td>
    <td>: <?php echo $row_DetailRS1['template_lahir']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Tanggal Lahir</td>
    <td>: <?php echo $row_DetailRS1['tanggal_lahir']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Agama</td>
    <td>: <?php echo $row_DetailRS1['agama']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Alamat</td>
    <td>: <?php echo $row_DetailRS1['alamat']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>No Telpon</td>
    <td>: <?php echo $row_DetailRS1['no_telpon']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap>Pendidikan</td>
    <td>: <?php echo $row_DetailRS1['pendidikan']; ?></td>
  </tr>
</table>
</div>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>