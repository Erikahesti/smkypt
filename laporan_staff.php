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
$query_guru = "SELECT * FROM guru WHERE jabatan NOT LIKE 'guru%'";
$guru = mysql_query($query_guru, $koneksi) or die(mysql_error());
$row_guru = mysql_fetch_assoc($guru);
$totalRows_guru = mysql_num_rows($guru);

$queryString_guru = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_guru") == false && 
        stristr($param, "totalRows_guru") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_guru = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_guru = sprintf("&totalRows_guru=%d%s", $totalRows_guru, $queryString_guru);
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
    <td colspan="2" align="center"><p><strong>LAPORAN DATA STAFF</strong></p>
      <p>&nbsp;
      <table border="1" align="center">
        <tr>
          <td>NIP</td>
          <td>nama</td>
          <td>jabatan</td>
          <td>jenis_kelamin</td>
          <td>template_lahir</td>
          <td>tanggal_lahir</td>
          <td>agama</td>
          <td>alamat</td>
          <td>no_telpon</td>
          <td>pendidikan</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="laporan_guru_detail.php?recordID=<?php echo $row_guru['NIP']; ?>"> <?php echo $row_guru['NIP']; ?>&nbsp; </a></td>
            <td><?php echo $row_guru['nama']; ?>&nbsp; </td>
            <td><?php echo $row_guru['jabatan']; ?>&nbsp; </td>
            <td><?php echo $row_guru['jenis_kelamin']; ?>&nbsp; </td>
            <td><?php echo $row_guru['template_lahir']; ?>&nbsp; </td>
            <td><?php echo $row_guru['tanggal_lahir']; ?>&nbsp; </td>
            <td><?php echo $row_guru['agama']; ?>&nbsp; </td>
            <td><?php echo $row_guru['alamat']; ?>&nbsp; </td>
            <td><?php echo $row_guru['no_telpon']; ?>&nbsp; </td>
            <td><?php echo $row_guru['pendidikan']; ?>&nbsp; </td>
          </tr>
          <?php } while ($row_guru = mysql_fetch_assoc($guru)); ?>
      </table>
      <br />
      <p align="right">Palembang, <?php echo date('d-m-Y'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p>&nbsp;</p>
      <p align="right">&nbsp;&nbsp; Kepala Sekolah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p>&nbsp;</p>
     <p align="left">&nbsp; &nbsp; <input type="submit" name="button" id="button" value="CETAK" onClick="window.print();"></p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($guru);
?>
