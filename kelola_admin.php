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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO `admin` (username, password, akses) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['akses'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "admin.php?menu=kelola_admin";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
     echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_admin' />";

}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_admin = 10;
$pageNum_admin = 0;
if (isset($_GET['pageNum_admin'])) {
  $pageNum_admin = $_GET['pageNum_admin'];
}
$startRow_admin = $pageNum_admin * $maxRows_admin;

mysql_select_db($database_koneksi, $koneksi);
$query_admin = "SELECT * FROM `admin` ORDER BY id_admin ASC";
$query_limit_admin = sprintf("%s LIMIT %d, %d", $query_admin, $startRow_admin, $maxRows_admin);
$admin = mysql_query($query_limit_admin, $koneksi) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);

if (isset($_GET['totalRows_admin'])) {
  $totalRows_admin = $_GET['totalRows_admin'];
} else {
  $all_admin = mysql_query($query_admin);
  $totalRows_admin = mysql_num_rows($all_admin);
}
$totalPages_admin = ceil($totalRows_admin/$maxRows_admin)-1;

$queryString_admin = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_admin") == false && 
        stristr($param, "totalRows_admin") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_admin = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_admin = sprintf("&totalRows_admin=%d%s", $totalRows_admin, $queryString_admin);


?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<p align="center"><strong>KELOLA ADMIN</strong></p>
<div style="border:1px solid #333; width:400px; margin:0 auto; padding:30px">
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td width="158">USERNAME</td>
      <td width="222"><span id="sprytextfield1">
        <label for="username"></label>
        <input type="text" name="username" id="username">
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td>PASSWORD</td>
      <td><span id="sprytextfield2">
        <label for="password"></label>
        <input type="text" name="password" id="password">
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td>AKSES</td>
      <td><label for="akses"></label>
        <select name="akses" id="akses">
          <option value="ADMIN">ADMIN</option>
          <option value="KEPSEK">KEPSEK</option>
        </select></td>
    </tr>
    <tr>
      <td align="right"><input type="submit" name="submit" id="submit" value="SIMPAN"></td>
      <td><input type="reset" name="Reset" id="button" value="BATAL"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</div>
<p>&nbsp;</p>
<table width="600" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr align="center">
    <td>ID</td>
    <td>Username</td>
    <td>Password</td>
    <td>Akses</td>
    <td>Proses</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><?php echo $row_admin['id_admin']; ?></td>
      <td><?php echo $row_admin['username']; ?></td>
      <td><?php echo $row_admin['password']; ?></td>
      <td><?php echo $row_admin['akses']; ?></td>
      <td align="center"><a href="admin.php?menu=kelola_admin_edit&amp;id_admin=<?php echo $row_admin['id_admin']; ?>">Edit</a> / <a href="admin.php?menu=kelola_admin_hapus&amp;id_admin=<?php echo $row_admin['id_admin']; ?>">Hapus</a></td>
    </tr>
    <?php } while ($row_admin = mysql_fetch_assoc($admin)); ?>
</table>
<p>&nbsp;</p>
<table width="200" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"><?php if ($pageNum_admin > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_admin=%d%s", $currentPage, max(0, $pageNum_admin - 1), $queryString_admin); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td align="center"><?php if ($pageNum_admin < $totalPages_admin) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_admin=%d%s", $currentPage, min($totalPages_admin, $pageNum_admin + 1), $queryString_admin); ?>">Next</a>
  <?php } // Show if not last page ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp; </p>
<?php
mysql_free_result($admin);
?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
  </script>
