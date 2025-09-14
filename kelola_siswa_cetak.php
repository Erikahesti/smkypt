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


$maxRows_siswa = 10;
$pageNum_siswa = 0;
if (isset($_GET['pageNum_siswa'])) {
  $pageNum_siswa = $_GET['pageNum_siswa'];
}
$startRow_siswa = $pageNum_siswa * $maxRows_siswa;

$colname_siswa = "-1";
if (isset($_GET['recordID'])) {
  $colname_siswa = $_GET['recordID'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_siswa = sprintf("SELECT siswa.*, pendaftaran.* FROM siswa, pendaftaran WHERE  siswa.no_daftar=pendaftaran.no_daftar AND siswa.NISN = %s", GetSQLValueString($colname_siswa, "text"));
$query_limit_siswa = sprintf("%s LIMIT %d, %d", $query_siswa, $startRow_siswa, $maxRows_siswa);
$siswa = mysql_query($query_limit_siswa, $koneksi) or die(mysql_error());
$row_siswa = mysql_fetch_assoc($siswa);

if (isset($_GET['totalRows_siswa'])) {
  $totalRows_siswa = $_GET['totalRows_siswa'];
} else {
  $all_siswa = mysql_query($query_siswa);
  $totalRows_siswa = mysql_num_rows($all_siswa);
}
$totalPages_siswa = ceil($totalRows_siswa/$maxRows_siswa)-1;

$queryString_siswa = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_siswa") == false && 
        stristr($param, "totalRows_siswa") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_siswa = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_siswa = sprintf("&totalRows_siswa=%d%s", $totalRows_siswa, $queryString_siswa);
?>
<table width="600" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><table width="600" align="center" cellpadding="5">
      <tr valign="baseline">
        <td height="38" colspan="4" align="center" valign="top" nowrap="nowrap"><h3 align="center"><img src="../logo pti.png" alt="" width="90" height="113" align="left" /><br>
      SMP PTI PALEMBANG</h3>
    <p align="center">Jalan Mesuji III/ Sei Putih No. 3264 <br />
      Kec. Ilir Barat 1  Kel. Demang Lebar Daun Pakjo  Kota Palembang</p>
    <hr /></td>
      </tr>
      <tr valign="baseline">
        <td height="38" colspan="4" align="center" valign="top" nowrap="nowrap"><strong> DATA SISWA</strong></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td width="39" align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="left" valign="top" nowrap="nowrap">NISN</td>
        <td width="1" valign="top">&nbsp;</td>
        <td width="273" valign="top"><?php echo $row_siswa['NISN']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">No Daftar</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['no_daftar']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Nama Lengkap</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['nama_lengkap']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Tahun Kelulusan</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['tahun_kelulusan']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Nama Asal Sekolah</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['nm_asl_sekolah']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Jenis Kelamin</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['jenis_kelamin']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Tempat Lahir</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['tempat_lahir']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Tanggal Lahir</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['tanggal_lahir']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Alamat</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['alamat']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">No Telpon</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['no_telpon']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Nama Orang Tua</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['nm_orang_tua']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Agama</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['agama']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Pekerjaan Orang Tua</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['pekerjaan_ortu']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Tanggal Daftar</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['tgl_daftar']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Kelas</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['kelas']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td valign="top" nowrap="nowrap">Foto</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><img src="../gambar/<?php echo $row_siswa['foto']; ?>" width="150" height="200" /></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap">Tanggal Diterima</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo $row_siswa['tgl_diterima']; ?></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
  <?php
mysql_free_result($siswa);
?>
</p>
