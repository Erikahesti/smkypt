
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
  $updateSQL = sprintf("UPDATE polling_web SET pertanyaan=%s, sangat_baik=%s, baik=%s, cukup=%s, kurang=%s WHERE id_polling=%s",
                       GetSQLValueString($_POST['pertanyaan'], "text"),
                       GetSQLValueString($_POST['sangat_baik'], "int"),
                       GetSQLValueString($_POST['baik'], "int"),
                       GetSQLValueString($_POST['cukup'], "int"),
                       GetSQLValueString($_POST['kurang'], "int"),
                       GetSQLValueString($_POST['id_polling'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
}

mysql_select_db($database_koneksi, $koneksi);
$query_polling_web = "SELECT * FROM polling_web WHERE id_polling='1'";
$polling_web = mysql_query($query_polling_web, $koneksi) or die(mysql_error());
$row_polling_web = mysql_fetch_assoc($polling_web);
$totalRows_polling_web = mysql_num_rows($polling_web);
?>
<p align="center"><strong>KELOLA POLLING WEB</strong></p>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="400" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>ID</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input name="id_polling" type="text" value="<?php echo $row_polling_web['id_polling']; ?>" size="15" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>PERTANYAAN</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><textarea name="pertanyaan" id="pertanyaan" cols="45" rows="5"><?php echo htmlentities($row_polling_web['pertanyaan'], ENT_COMPAT, ''); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>SANGAT BAIK</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="text" name="sangat_baik" value="<?php echo htmlentities($row_polling_web['sangat_baik'], ENT_COMPAT, ''); ?>" size="32">
      <label for="pertanyaan"></label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>BAIK</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="text" name="baik" value="<?php echo htmlentities($row_polling_web['baik'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>CUKUP</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="text" name="cukup" value="<?php echo htmlentities($row_polling_web['cukup'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>KURANG</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="text" name="kurang" value="<?php echo htmlentities($row_polling_web['kurang'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><input type="submit" value="Edit"></td>
      <td>&nbsp;</td>
      <td><input type="reset" name="Reset" id="button" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
mysql_free_result($polling_web);
?>
