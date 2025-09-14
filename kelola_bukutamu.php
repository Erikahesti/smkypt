<?php require_once('../Connections/koneksi.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE bukutamu SET balasan=%s WHERE kd_buku=%s",
                       GetSQLValueString($_POST['balasan'], "text"),
                       GetSQLValueString($_POST['kd_buku'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "admin.php?menu=kelola_bukutamu";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
   echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_bukutamu' />";

}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_bukutamu = 10;
$pageNum_bukutamu = 0;
if (isset($_GET['pageNum_bukutamu'])) {
  $pageNum_bukutamu = $_GET['pageNum_bukutamu'];
}
$startRow_bukutamu = $pageNum_bukutamu * $maxRows_bukutamu;

mysql_select_db($database_koneksi, $koneksi);
$query_bukutamu = "SELECT * FROM bukutamu ORDER BY kd_buku ASC";
$query_limit_bukutamu = sprintf("%s LIMIT %d, %d", $query_bukutamu, $startRow_bukutamu, $maxRows_bukutamu);
$bukutamu = mysql_query($query_limit_bukutamu, $koneksi) or die(mysql_error());
$row_bukutamu = mysql_fetch_assoc($bukutamu);

if (isset($_GET['totalRows_bukutamu'])) {
  $totalRows_bukutamu = $_GET['totalRows_bukutamu'];
} else {
  $all_bukutamu = mysql_query($query_bukutamu);
  $totalRows_bukutamu = mysql_num_rows($all_bukutamu);
}
$totalPages_bukutamu = ceil($totalRows_bukutamu/$maxRows_bukutamu)-1;

$queryString_bukutamu = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_bukutamu") == false && 
        stristr($param, "totalRows_bukutamu") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_bukutamu = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_bukutamu = sprintf("&totalRows_bukutamu=%d%s", $totalRows_bukutamu, $queryString_bukutamu);

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
$query_DetailRS1 = sprintf("SELECT * FROM bukutamu WHERE kd_buku = %s ORDER BY kd_buku ASC", GetSQLValueString($colname_DetailRS1, "int"));
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

<p align="center"><strong>KELOLA BUKU TAMU
</strong>
<table width="600" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center">Kode <br />
    Buku Tamu</td>
    <td align="center">Nama</td>
    <td align="center">Tanggal</td>
    <td align="center">Alamat</td>
    <td align="center">Pesan</td>
    <td align="center">Balasan</td>
    <td colspan="2" align="center">Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><?php echo $row_bukutamu['kd_buku']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['nama']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['tgl_input']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['alamat']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['pesan']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['balasan']; ?>&nbsp; </td>
      <td align="center"><a href="admin.php?menu=kelola_bukutamu&recordID=<?php echo $row_bukutamu['kd_buku']; ?>">Balas</a></td>
      <td align="center"><a href="admin.php?menu=kelola_bukutamu_hapus&amp;recordID=<?php echo $row_bukutamu['kd_buku']; ?>">Hapus</a></td>
    </tr>
    <?php } while ($row_bukutamu = mysql_fetch_assoc($bukutamu)); ?>
</table>
<br />
<table border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td><?php if ($pageNum_bukutamu > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_bukutamu=%d%s", $currentPage, max(0, $pageNum_bukutamu - 1), $queryString_bukutamu); ?>">Back</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_bukutamu < $totalPages_bukutamu) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_bukutamu=%d%s", $currentPage, min($totalPages_bukutamu, $pageNum_bukutamu + 1), $queryString_bukutamu); ?>">Next</a>
      <?php } // Show if not last page ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
</p>
<p>&nbsp;</p>

<?php 

if(empty($_GET['recordID'])){ } else{?>
<hr />
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="500" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <td width="141" align="left" valign="top" nowrap="nowrap">Kode Buku Tamu</td>
      <td width="347" align="left" valign="top"><?php echo $row_DetailRS1['kd_buku']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Nama</td>
      <td align="left" valign="top"><?php echo htmlentities($row_DetailRS1['nama'], ENT_COMPAT, ''); ?></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Tgl Input</td>
      <td align="left" valign="top"><?php echo htmlentities($row_DetailRS1['tgl_input'], ENT_COMPAT, ''); ?></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Alamat</td>
      <td align="left" valign="top"><?php echo htmlentities($row_DetailRS1['alamat'], ENT_COMPAT, ''); ?></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Saran</td>
      <td align="left" valign="top"><?php echo htmlentities($row_DetailRS1['pesan'], ENT_COMPAT, ''); ?></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Balasan</td>
      <td align="left" valign="top"><label for="balasan"></label>
      <textarea name="balasan" id="balasan" cols="45" rows="5"><?php echo htmlentities($row_DetailRS1['balasan'], ENT_COMPAT, ''); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><input type="submit" value="BALAS" /></td>
      <td><input type="reset" name="Reset" id="button" value="BATAL" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="kd_buku" value="<?php echo $row_DetailRS1['kd_buku']; ?>" />
</form>
<?php } ?>
<p>&nbsp;</p>
<?php
mysql_free_result($bukutamu);
?>
