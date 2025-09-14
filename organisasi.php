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

$colname_organisasi = "-1";
if (isset($_GET['id_organisasi'])) {
  $colname_organisasi = $_GET['id_organisasi'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_organisasi = sprintf("SELECT * FROM organisasi WHERE id_organisasi = %s", GetSQLValueString($colname_organisasi, "int"));
$organisasi = mysql_query($query_organisasi, $koneksi) or die(mysql_error());
$row_organisasi = mysql_fetch_assoc($organisasi);
$totalRows_organisasi = mysql_num_rows($organisasi);
?>
<p><?php echo $row_organisasi['judul']; ?></p>
<p>&nbsp;</p>
<p><?php echo $row_organisasi['isi']; ?></p>
<p><?php if($row_organisasi['gambar']!=''){ ?><img src="gambar/<?php echo $row_organisasi['gambar']; ?>" width="100%" height="auto" /><?php } ?></p>
<p>&nbsp;</p>
<?php
mysql_free_result($organisasi);
?>
