
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
  $updateSQL = sprintf("UPDATE polling_pelayanan SET pertanyaan=%s, sangat_memuaskan=%s, memuaskan=%s, cukup=%s, kurang=%s WHERE id_polling=%s",
                       GetSQLValueString($_POST['pertanyaan'], "text"),
                       GetSQLValueString($_POST['sangat_memuaskan'], "int"),
                       GetSQLValueString($_POST['memuaskan'], "int"),
                       GetSQLValueString($_POST['cukup'], "int"),
                       GetSQLValueString($_POST['kurang'], "int"),
                       GetSQLValueString($_POST['id_polling'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
}

mysql_select_db($database_koneksi, $koneksi);
$query_polling_pelayanan = "SELECT * FROM polling_pelayanan WHERE id_polling='1'";
$polling_pelayanan = mysql_query($query_polling_pelayanan, $koneksi) or die(mysql_error());
$row_polling_pelayanan = mysql_fetch_assoc($polling_pelayanan);
$totalRows_polling_pelayanan = mysql_num_rows($polling_pelayanan);
?>
<p align="center"><strong>KELOLA POLLING PELAYANAN</strong></p>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="400" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>ID</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input name="id_polling" type="text" value="<?php echo $row_polling_pelayanan['id_polling']; ?>" size="15" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>PERTANYAAN</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><textarea name="pertanyaan" id="pertanyaan" cols="40" rows="5"><?php echo htmlentities($row_polling_pelayanan['pertanyaan'], ENT_COMPAT, ''); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>SANGAT MEMUASKAN</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input name="sangat_memuaskan" type="text" id="sangat_memuaskan" value="<?php echo htmlentities($row_polling_pelayanan['sangat_memuaskan'], ENT_COMPAT, ''); ?>" size="32">
      <label for="pertanyaan"></label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>MEMUASKAN</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input name="memuaskan" type="text" id="memuaskan" value="<?php echo htmlentities($row_polling_pelayanan['memuaskan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>CUKUP MEMUASKAN</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="text" name="cukup" value="<?php echo htmlentities($row_polling_pelayanan['cukup'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>KURANG MEMUASKAN</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="text" name="kurang" value="<?php echo htmlentities($row_polling_pelayanan['kurang'], ENT_COMPAT, ''); ?>" size="32"></td>
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
<p>a</p>
<p>a</p>
<p>&nbsp;</p>
<?php
mysql_free_result($polling_pelayanan);
?>
