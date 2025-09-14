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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `admin` SET username=%s, password=%s, akses=%s WHERE id_admin=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['akses'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
     echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_admin' />";
}

$colname_admin = "-1";
if (isset($_GET['id_admin'])) {
  $colname_admin = $_GET['id_admin'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_admin = sprintf("SELECT * FROM `admin` WHERE id_admin = %s", GetSQLValueString($colname_admin, "int"));
$admin = mysql_query($query_admin, $koneksi) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);
?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<p align="center"><strong>KELOLA ADMIN</strong> <strong>EDIT</strong></p>
<div style="border:1px solid #333; width:400px; margin:0 auto; padding:30px">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
    <table width="400" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="158">USERNAME</td>
        <td width="222"><span id="sprytextfield1">
          <label for="username"></label>
          <input name="username" type="text" id="username" value="<?php echo $row_admin['username']; ?>" />
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
</tr>
      <tr>
        <td>PASSWORD</td>
        <td><span id="sprytextfield2">
          <label for="password"></label>
          <input name="password" type="text" id="password" value="<?php echo $row_admin['password']; ?>" />
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
</tr>
      <tr>
        <td>AKSES</td>
        <td><label for="akses"></label>
          <select name="akses" id="akses">
            <option value="ADMIN" <?php if (!(strcmp("ADMIN", $row_admin['akses']))) {echo "selected=\"selected\"";} ?>>ADMIN</option>
            <option value="KEPSEK" <?php if (!(strcmp("KEPSEK", $row_admin['akses']))) {echo "selected=\"selected\"";} ?>>KEPSEK</option>
            <option value="" <?php if (!(strcmp("", $row_admin['akses']))) {echo "selected=\"selected\"";} ?>></option>
            <?php
do {  
?>
            <option value="<?php echo $row_admin['akses']?>"<?php if (!(strcmp($row_admin['akses'], $row_admin['akses']))) {echo "selected=\"selected\"";} ?>><?php echo $row_admin['akses']?></option>
            <?php
} while ($row_admin = mysql_fetch_assoc($admin));
  $rows = mysql_num_rows($admin);
  if($rows > 0) {
      mysql_data_seek($admin, 0);
	  $row_admin = mysql_fetch_assoc($admin);
  }
?>
          </select></td>
      </tr>
      <tr>
        <td align="right"><label for="id_admin"></label>
        <input name="id_admin" type="hidden" id="id_admin" value="<?php echo $row_admin['id_admin']; ?>" />          <input type="submit" name="submit" id="submit" value="SIMPAN" /></td>
        <td><input type="reset" name="Reset" id="button" value="BATAL" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
  </form>

</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
</script>
<?php
mysql_free_result($admin);
?>
