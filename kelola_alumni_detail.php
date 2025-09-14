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
$query_DetailRS1 = sprintf("SELECT * FROM alumni,siswa,pendaftaran WHERE siswa.no_daftar=pendaftaran.no_daftar AND siswa.NISN=alumni.NISN AND alumni.NIA = %s ORDER BY nama_lengkap ASC", GetSQLValueString($colname_DetailRS1, "int"));
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div style="border:1px solid #333; width:500px; margin:0 auto; padding:0 10px 10px 10px">
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="3" align="center" valign="top" nowrap="nowrap"><strong>DETAIL DATA ALUMNI</strong></td>
  </tr>
  <tr>
    <td width="37" align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td width="144" align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td width="289">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">NIA</td>
    <td>: <?php echo $row_DetailRS1['NIA']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">NISN</td>
    <td>: <?php echo $row_DetailRS1['NISN']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Tahun Kelulusan</td>
    <td>: <?php echo $row_DetailRS1['tahun_kelulusan']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Nama Lengkap</td>
    <td>: <?php echo $row_DetailRS1['nama_lengkap']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Jenis Kelamin</td>
    <td>: <?php echo $row_DetailRS1['jenis_kelamin']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Tempat Lahir</td>
    <td>: <?php echo $row_DetailRS1['tempat_lahir']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Tanggal Lahir</td>
    <td>: <?php echo $row_DetailRS1['tanggal_lahir']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Alamat</td>
    <td>: <?php echo $row_DetailRS1['alamat']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Nomor Telpon</td>
    <td>: <?php echo $row_DetailRS1['no_telpon']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Nama Orang Tua</td>
    <td>: <?php echo $row_DetailRS1['nm_orang_tua']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Agama</td>
    <td>: <?php echo $row_DetailRS1['agama']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Pekerjaan Orang Tua</td>
    <td>: <?php echo $row_DetailRS1['pekerjaan_ortu']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">Tahun Tamat</td>
    <td>: <?php echo $row_DetailRS1['tahun_tamat']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">No Ijazah</td>
    <td>: <?php echo $row_DetailRS1['no_ijazah']; ?></td>
    </tr>
</table>
</div>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>