<?php require_once('Connections/koneksi.php'); ?>
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

$maxRows_bukutamu = 10;
$pageNum_bukutamu = 0;
if (isset($_GET['pageNum_bukutamu'])) {
  $pageNum_bukutamu = $_GET['pageNum_bukutamu'];
}
$startRow_bukutamu = $pageNum_bukutamu * $maxRows_bukutamu;

mysql_select_db($database_koneksi, $koneksi);
$query_bukutamu = "SELECT * FROM bukutamu WHERE balasan!='' ORDER BY tgl_input DESC";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO bukutamu (nama, tgl_input, alamat, pesan) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['tgl_input'], "date"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['pesan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "index.php?menu=bukutamu";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}
?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>

<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<p align="center"><strong>HALAMAN BUKU TAMU</strong></p>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="380" align="center">
    <tr valign="baseline">
      <td width="108" nowrap="nowrap">Nama</td>
      <td width="280"><span id="sprytextfield1">
        <label for="nama"></label>
        <input type="text" name="nama" id="nama" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap">Alamat</td>
      <td><span id="sprytextfield2">
        <label for="alamat"></label>
        <input type="text" name="alamat" id="alamat" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td valign="top" nowrap="nowrap">Pesan</td>
      <td><span id="sprytextarea1">
        <label for="pesan"></label>
        <textarea name="pesan" id="pesan" cols="35" rows="5"></textarea>
      <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap"><input type="hidden" name="tgl_input" value="<?php $tgl=date('Y-m-d'); echo "$tgl"; ?>" size="32" /></td>
      <td><input type="submit" value="Kirim" />
      <input type="reset" name="Reset" id="button" value="Batal" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;
<table width="380" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"><strong>Nama</strong></td>
    <td align="center"><strong>Alamat</strong></td>
    <td align="center"><strong>Pesan</strong></td>
    <td align="center"><strong>Balasan</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_bukutamu['nama']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['alamat']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['pesan']; ?>&nbsp; </td>
      <td><?php echo $row_bukutamu['balasan']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_bukutamu = mysql_fetch_assoc($bukutamu)); ?>
</table>
<br />
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_bukutamu > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_bukutamu=%d%s", $currentPage, 0, $queryString_bukutamu); ?>">First</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_bukutamu > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_bukutamu=%d%s", $currentPage, max(0, $pageNum_bukutamu - 1), $queryString_bukutamu); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_bukutamu < $totalPages_bukutamu) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_bukutamu=%d%s", $currentPage, min($totalPages_bukutamu, $pageNum_bukutamu + 1), $queryString_bukutamu); ?>">Next</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_bukutamu < $totalPages_bukutamu) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_bukutamu=%d%s", $currentPage, $totalPages_bukutamu, $queryString_bukutamu); ?>">Last</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp; </p>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["change"]});
</script>
<?php
mysql_free_result($bukutamu);
?>
