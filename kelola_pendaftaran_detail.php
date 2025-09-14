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
$query_DetailRS1 = sprintf("SELECT * FROM pendaftaran WHERE no_daftar = %s ORDER BY no_daftar ASC", GetSQLValueString($colname_DetailRS1, "int"));
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
?>

<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><strong>DETAIL PENDAFTARAN</strong></td>
  </tr>
  <tr>
    <td width="166">&nbsp;</td>
    <td width="314">&nbsp;</td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">No Daftar</td>
    <td><?php echo $row_DetailRS1['no_daftar']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Nama Lengkap</td>
    <td><?php echo $row_DetailRS1['nama_lengkap']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Tahun Kelulusan</td>
    <td><?php echo $row_DetailRS1['tahun_kelulusan']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Nama Asal Sekolah</td>
    <td><?php echo $row_DetailRS1['nm_asl_sekolah']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Jenis Kelamin</td>
    <td><?php echo $row_DetailRS1['jenis_kelamin']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Tempat Lahir</td>
    <td><?php echo $row_DetailRS1['tempat_lahir']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Tanggal Lahir</td>
    <td><?php echo $row_DetailRS1['tanggal_lahir']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Alamat</td>
    <td><?php echo $row_DetailRS1['alamat']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">No Telpon</td>
    <td><?php echo $row_DetailRS1['no_telpon']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Nama Orang Tua</td>
    <td><?php echo $row_DetailRS1['nm_orang_tua']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Program</td>
    <td><?php echo $row_DetailRS1['program']; ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Pekerjaan Orang Tua</td>
    <td><?php echo $row_DetailRS1['pekerjaan_ortu']; ?></td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap">Foto</td>
    <td><?php if($row_DetailRS1['foto']!=''){ ?><img src="../gambar/<?php echo $row_DetailRS1['foto']; ?>" width="150" height="200" /><?php } ?></td>
  </tr>
  <tr>
    <td valign="baseline" nowrap="nowrap">Tanggal Daftar</td>
    <td><?php echo $row_DetailRS1['tgl_daftar']; ?></td>
  </tr>
</table>

<?php
mysql_free_result($DetailRS1);
?>