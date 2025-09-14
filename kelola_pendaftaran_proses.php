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

$colname_pendaftaran = "-1";
if (isset($_GET['recordID'])) {
  $colname_pendaftaran = $_GET['recordID'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_pendaftaran = sprintf("SELECT * FROM pendaftaran WHERE no_daftar = %s", GetSQLValueString($colname_pendaftaran, "int"));
$pendaftaran = mysql_query($query_pendaftaran, $koneksi) or die(mysql_error());
$row_pendaftaran = mysql_fetch_assoc($pendaftaran);
$totalRows_pendaftaran = mysql_num_rows($pendaftaran);

$tgl=date('Y-m-d');; 

$query= "INSERT INTO siswa (no_daftar, tgl_diterima) VALUES ('$row_pendaftaran[no_daftar]', '$tgl')";
$insertsiswa = mysql_query($query);

$status= "UPDATE pendaftaran SET status_daftar='DITERIMA' WHERE no_daftar = '$row_pendaftaran[no_daftar]'";
$updatestatus = mysql_query($status);

//$queryhapusdaftar="DELETE FROM pendaftaran_online WHERE no_daftar='$row_pendaftaran[no_daftar]'";
//$hapusdaftar=mysql_query($queryhapusdaftar);
	echo	"<script>alert('Pendaftaran Siswa Baru berhasil di proses.');</script>";
    echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_pendaftaran' />";

?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php 
mysql_free_result($pendaftaran);
?>
