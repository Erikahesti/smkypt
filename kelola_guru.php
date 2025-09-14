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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO guru (NIP, nama, jabatan, jenis_kelamin, template_lahir, tanggal_lahir, agama, alamat, no_telpon, pendidikan) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NIP'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['template_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telpon'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
    echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_guru' />";
}

$maxRows_guru = 10;
$pageNum_guru = 0;
if (isset($_GET['pageNum_guru'])) {
  $pageNum_guru = $_GET['pageNum_guru'];
}
$startRow_guru = $pageNum_guru * $maxRows_guru;

mysql_select_db($database_koneksi, $koneksi);
$query_guru = "SELECT * FROM guru";
$query_limit_guru = sprintf("%s LIMIT %d, %d", $query_guru, $startRow_guru, $maxRows_guru);
$guru = mysql_query($query_limit_guru, $koneksi) or die(mysql_error());
$row_guru = mysql_fetch_assoc($guru);

if (isset($_GET['totalRows_guru'])) {
  $totalRows_guru = $_GET['totalRows_guru'];
} else {
  $all_guru = mysql_query($query_guru);
  $totalRows_guru = mysql_num_rows($all_guru);
}
$totalPages_guru = ceil($totalRows_guru/$maxRows_guru)-1;

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
<p align="center"><strong>KELOLA DATA GURU</strong></p>
<div style="border:1px solid #333; width:500px; margin:0 auto; padding:30px">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
    <table width="450" align="center" cellpadding="5" cellspacing="0">
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>NIP</td>
        <td valign="top"><input type="text" name="NIP" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Nama</td>
        <td valign="top"><input type="text" name="nama" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
        <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>
        
        </td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Jabatan</td>
        <td valign="top"><input type="text" name="jabatan" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
        <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>
        
        </td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Jenis Kelamin</td>
        <td valign="top"><input type="text" name="jenis_kelamin" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
        <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>
        
        </td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Tempat Lahir</td>
        <td valign="top"><input name="template_lahir" type="text" id="template_lahir" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
        <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>
        
        </td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Tanggal Lahir</td>
        <td valign="top"><input name="tanggal_lahir" type="date" id="tanggal_lahir" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Agama</td>
        <td valign="top"><input type="text" name="agama" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
        <script type="text/javascript">
	 function hanyaHuruf (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return true;
		 return false;
	 }
	 </script>
        
        </td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Alamat</td>
        <td valign="top"><input type="text" name="alamat" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>No Telpon</td>
        <td valign="top"><input type="text" name="no_telpon" value="" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
        
        <script type="text/javascript">
	 function hanyaAngka (evt) {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
		 return false;
		 return true;
	 }
	 </script>
        
        </td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Pendidikan</td>
        <td valign="top"><input type="text" name="pendidikan" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><input type="submit" value="SIMPAN"></td>
        <td><input type="reset" name="Reset" id="button" value="BATAL"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
</div>
<p>&nbsp;</p>
<p>&nbsp;
<table width="600" border="1" align="center">
  <tr>
    <td width="100">NIP</td>
    <td>nama</td>
    <td>jabatan</td>
    <td>pendidikan</td>
    <td>alamat</td>
    <td width="150" align="center">AKSI</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_guru['NIP']; ?></td>
      <td><?php echo $row_guru['nama']; ?>&nbsp; </td>
      <td><?php echo $row_guru['jabatan']; ?>&nbsp; </td>
      <td><?php echo $row_guru['pendidikan']; ?>&nbsp; </td>
      <td>&nbsp; <?php echo $row_guru['alamat']; ?></td>
      <td width="100" align="center"><a href="admin.php?menu=kelola_guru_edit&recordID=<?php echo $row_guru['NIP']; ?>">Edit</a> <a href="admin.php?menu=kelola_guru_hapus&recordID=<?php echo $row_guru['NIP']; ?>">Hapus</a> <a href="kelola_guru_cetak.php?recordID=<?php echo $row_guru['NIP']; ?>">Cetak</a></td>
    </tr>
    <?php } while ($row_guru = mysql_fetch_assoc($guru)); ?>
</table>
<br>
<table border="0" align="center">
  <tr>
    <td></td>
    <td>
        <a href="<?php printf("%s?pageNum_guru=%d%s", $currentPage, max(0, $pageNum_guru - 1), $queryString_guru); ?>">Back</a>
    </td>
    <td>
        <a href="<?php printf("%s?pageNum_guru=%d%s", $currentPage, min($totalPages_guru, $pageNum_guru + 1), $queryString_guru); ?>">Next</a>
   </td>
    <td></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
mysql_free_result($guru);
?>
