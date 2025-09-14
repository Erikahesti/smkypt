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

$colname_detailberita = "-1";
if (isset($_GET['id_berita'])) {
  $colname_detailberita = $_GET['id_berita'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_detailberita = sprintf("SELECT * FROM berita WHERE id_berita = %s", GetSQLValueString($colname_detailberita, "int"));
$detailberita = mysql_query($query_detailberita, $koneksi) or die(mysql_error());
$row_detailberita = mysql_fetch_assoc($detailberita);
$totalRows_detailberita = mysql_num_rows($detailberita);
?>
<p><?php echo $row_detailberita['judul']; ?></p>
<p><?php echo $row_detailberita['isi_berita']; ?></p>
<p>&nbsp;</p>
<?php
mysql_free_result($detailberita);
?>
