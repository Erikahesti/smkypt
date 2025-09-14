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

mysql_select_db($database_koneksi, $koneksi);
$query_guru = "SELECT * FROM guru WHERE nama LIKE '%$_GET[katakunci]%' OR NIP LIKE '%$_GET[katakunci]%' ORDER BY nama ASC";
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
<p align="center"><strong>HALAMAN DATA GURU</strong></p>
<form id="form1" name="form1" method="get" action="">
<input type="hidden" name="menu" id="pelayanan_dataguru" value="pelayanan_dataguru" />

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
  <tr>
    <td align="center"><strong>NIP</strong></td>
    <td align="center"><strong>Nama Guru</strong></td>
    <td align="center"><strong>Alamat</strong></td>
    <td align="center"><strong>Jabatan</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><?php echo $row_guru['NIP']; ?></td>
      <td><?php echo $row_guru['nama']; ?>&nbsp; </td>
      <td><?php echo $row_guru['alamat']; ?>&nbsp; </td>
      <td><?php echo $row_guru['jabatan']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_guru = mysql_fetch_assoc($guru)); ?>
</table>
<br />
<p>&nbsp;</p>
<?php
mysql_free_result($guru);
?>
