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

$colname_profi = "-1";
if (isset($_GET['id_profil'])) {
  $colname_profi = $_GET['id_profil'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_profi = sprintf("SELECT * FROM profil WHERE id_profil = %s", GetSQLValueString($colname_profi, "int"));
$profi = mysql_query($query_profi, $koneksi) or die(mysql_error());
$row_profi = mysql_fetch_assoc($profi);
$totalRows_profi = mysql_num_rows($profi);
?>
<b><?php echo $row_profi['judul']; ?></b>
<p><?php if($row_profi['gambar']!=''){ ?><img src="gambar/<?php echo $row_profi['gambar']; ?>" width="100%" height="auto" /><?php } ?></p>
<p><?php echo $row_profi['isi']; ?></p>
<p></p>
<?php
mysql_free_result($profi);
?>
