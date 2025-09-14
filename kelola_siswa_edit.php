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
  $updateSQL = sprintf("UPDATE siswa SET NIS=%s, no_daftar=%s, nama_lengkap=%s, jurusan=%s, ttl=%s, jenis_kelamin=%s, agama=%s, kewarganegaraan=%s, nm_asal_sekolah=%s, alamat=%s, kelas=%s, no_telpon=%s, nm_orang_tua=%s, pekerjaan=%s, tgl_pendaftaran=%s, nilai_rata_ujian_nasional=%s WHERE nik=%s",
                       GetSQLValueString($_POST['nis'], "text"),
                       GetSQLValueString($_POST['no_daftar'], "text"),
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['jurusan'], "text"),
                       GetSQLValueString($_POST['ttl'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['kewarganegaraan'], "text"),
                       GetSQLValueString($_POST['nm_asal_sekolah'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['kelas'], "text"),
                       GetSQLValueString($_POST['no_telpon'], "text"),
                       GetSQLValueString($_POST['nm_orang_tua'], "text"),
                       GetSQLValueString($_POST['pekerjaan'], "text"),
                       GetSQLValueString($_POST['tgl_pendaftaran'], "date"),
                       GetSQLValueString($_POST['nilai_rata_ujian_nasional'], "int"),
                       GetSQLValueString($_POST['nik'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
    echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_siswa' />";

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
$query_siswa = sprintf("SELECT * FROM siswa WHERE nik = %s", GetSQLValueString($colname_siswa, "int"));
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

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="80%" align="center" cellpadding="5">
    <tr valign="baseline">
      <td height="38" colspan="2" align="center" valign="top" nowrap="nowrap"><strong>EDIT DATA SISWA</strong></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">NIS</td>
      <td valign="top"><span id="sprytextfield6">
        <label for="nis"></label>
        <input name="nis" type="text" id="nis" value="<?php echo $row_siswa['NIS']; ?>">
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">No Daftar</td>
      <td valign="top"><span id="sprytextfield1">
        <input name="no_daftar" type="text" value="<?php echo $row_siswa['no_daftar']; ?>" size="15" readonly="readonly" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Nama Lengkap</td>
      <td valign="top"><span id="sprytextfield2">
        <input type="text" name="nama_lengkap" value="<?php echo $row_siswa['nama_lengkap']; ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Jurusan</td>
      <td valign="top"><span id="spryselect1">
        <label for="jurusan"></label>
        <select name="jurusan" id="jurusan">
          <option value="" <?php if (!(strcmp("", $row_siswa['jurusan']))) {echo "selected=\"selected\"";} ?>>-Pilih-</option>
          <option value="ap" <?php if (!(strcmp("ap", $row_siswa['jurusan']))) {echo "selected=\"selected\"";} ?>>Aplikasi Perkantoran</option>
          <option value="tkj" <?php if (!(strcmp("tkj", $row_siswa['jurusan']))) {echo "selected=\"selected\"";} ?>>Teknik Jaringan Komputer</option>
          <option value="tsm" <?php if (!(strcmp("tsm", $row_siswa['jurusan']))) {echo "selected=\"selected\"";} ?>>Teknik Sepeda Motor</option>
          <?php
do {  
?>
          <option value="<?php echo $row_siswa['jurusan']?>"<?php if (!(strcmp($row_siswa['jurusan'], $row_siswa['jurusan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_siswa['jurusan']?></option>
          <?php
} while ($row_siswa = mysql_fetch_assoc($siswa));
  $rows = mysql_num_rows($siswa);
  if($rows > 0) {
      mysql_data_seek($siswa, 0);
	  $row_siswa = mysql_fetch_assoc($siswa);
  }
?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">NIK</td>
      <td valign="top"><span id="sprytextfield3">
      <input type="text" name="nik" value="<?php echo $row_siswa['nik']; ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Tempat Tanggal Lahir</td>
      <td valign="top"><span id="sprytextfield4">
        <input type="text" name="ttl" value="<?php echo $row_siswa['ttl']; ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Jenis Kelamin</td>
      <td valign="top"><span id="spryselect2">
        <label for="jenis_kelamin"></label>
        <select name="jenis_kelamin" id="jenis_kelamin">
          <option value="" <?php if (!(strcmp("", $row_siswa['jenis_kelamin']))) {echo "selected=\"selected\"";} ?>>-Pilih-</option>
          <option value="LK" <?php if (!(strcmp("LK", $row_siswa['jenis_kelamin']))) {echo "selected=\"selected\"";} ?>>Laki-laki</option>
          <option value="P" <?php if (!(strcmp("P", $row_siswa['jenis_kelamin']))) {echo "selected=\"selected\"";} ?>>Perempuan</option>
          <?php
do {  
?>
          <option value="<?php echo $row_siswa['jenis_kelamin']?>"<?php if (!(strcmp($row_siswa['jenis_kelamin'], $row_siswa['jenis_kelamin']))) {echo "selected=\"selected\"";} ?>><?php echo $row_siswa['jenis_kelamin']?></option>
          <?php
} while ($row_siswa = mysql_fetch_assoc($siswa));
  $rows = mysql_num_rows($siswa);
  if($rows > 0) {
      mysql_data_seek($siswa, 0);
	  $row_siswa = mysql_fetch_assoc($siswa);
  }
?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Agama</td>
      <td valign="top"><span id="spryselect3">
        <label for="agama"></label>
        <select name="agama" id="agama">
          <option value="" <?php if (!(strcmp("", $row_siswa['agama']))) {echo "selected=\"selected\"";} ?>>-Pilih-</option>
          <option value="Islam" <?php if (!(strcmp("Islam", $row_siswa['agama']))) {echo "selected=\"selected\"";} ?>>Islam</option>
          <option value="Kristen Protestan" <?php if (!(strcmp("Kristen Protestan", $row_siswa['agama']))) {echo "selected=\"selected\"";} ?>>Kristen Protestan</option>
          <option value="Kristen Katolik" <?php if (!(strcmp("Kristen Katolik", $row_siswa['agama']))) {echo "selected=\"selected\"";} ?>>Kristen Katolik</option>
          <option value="Hindu" <?php if (!(strcmp("Hindu", $row_siswa['agama']))) {echo "selected=\"selected\"";} ?>>Hindu</option>
          <option value="Budha" <?php if (!(strcmp("Budha", $row_siswa['agama']))) {echo "selected=\"selected\"";} ?>>Budha</option>
          <?php
do {  
?>
          <option value="<?php echo $row_siswa['agama']?>"<?php if (!(strcmp($row_siswa['agama'], $row_siswa['agama']))) {echo "selected=\"selected\"";} ?>><?php echo $row_siswa['agama']?></option>
          <?php
} while ($row_siswa = mysql_fetch_assoc($siswa));
  $rows = mysql_num_rows($siswa);
  if($rows > 0) {
      mysql_data_seek($siswa, 0);
	  $row_siswa = mysql_fetch_assoc($siswa);
  }
?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Kewarganegaraan</td>
      <td valign="top"><span id="spryselect4">
        <label for="kewarganegaraan"></label>
        <select name="kewarganegaraan" id="kewarganegaraan">
          <option value="" <?php if (!(strcmp("", $row_siswa['kewarganegaraan']))) {echo "selected=\"selected\"";} ?>>-Pilih-</option>
          <option value="WNI" <?php if (!(strcmp("WNI", $row_siswa['kewarganegaraan']))) {echo "selected=\"selected\"";} ?>>WNI</option>
          <option value="WNA" <?php if (!(strcmp("WNA", $row_siswa['kewarganegaraan']))) {echo "selected=\"selected\"";} ?>>WNA</option>
          <?php
do {  
?>
          <option value="<?php echo $row_siswa['kewarganegaraan']?>"<?php if (!(strcmp($row_siswa['kewarganegaraan'], $row_siswa['kewarganegaraan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_siswa['kewarganegaraan']?></option>
          <?php
} while ($row_siswa = mysql_fetch_assoc($siswa));
  $rows = mysql_num_rows($siswa);
  if($rows > 0) {
      mysql_data_seek($siswa, 0);
	  $row_siswa = mysql_fetch_assoc($siswa);
  }
?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Nama Asal Sekolah</td>
      <td valign="top"><input type="text" name="nm_asal_sekolah" value="<?php echo $row_siswa['nm_asal_sekolah']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Alamat</td>
      <td valign="top"><input type="text" name="alamat" value="<?php echo $row_siswa['alamat']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Kelas</td>
      <td valign="top"><span id="spryselect5">
        <label for="kelas"></label>
        <select name="kelas" id="kelas">
          <option value="" <?php if (!(strcmp("", $row_siswa['kelas']))) {echo "selected=\"selected\"";} ?>>-Pilih-</option>
          <option value="X" <?php if (!(strcmp("X", $row_siswa['kelas']))) {echo "selected=\"selected\"";} ?>>X</option>
          <option value="XI" <?php if (!(strcmp("XI", $row_siswa['kelas']))) {echo "selected=\"selected\"";} ?>>XI</option>
          <option value="XII" <?php if (!(strcmp("XII", $row_siswa['kelas']))) {echo "selected=\"selected\"";} ?>>XII</option>
          <?php
do {  
?>
          <option value="<?php echo $row_siswa['kelas']?>"<?php if (!(strcmp($row_siswa['kelas'], $row_siswa['kelas']))) {echo "selected=\"selected\"";} ?>><?php echo $row_siswa['kelas']?></option>
          <?php
} while ($row_siswa = mysql_fetch_assoc($siswa));
  $rows = mysql_num_rows($siswa);
  if($rows > 0) {
      mysql_data_seek($siswa, 0);
	  $row_siswa = mysql_fetch_assoc($siswa);
  }
?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">No Telpon</td>
      <td valign="top"><input type="text" name="no_telpon" value="<?php echo $row_siswa['no_telpon']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Nama Orang Tua</td>
      <td valign="top"><input type="text" name="nm_orang_tua" value="<?php echo $row_siswa['nm_orang_tua']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Pekerjaan</td>
      <td valign="top"><input type="text" name="pekerjaan" value="<?php echo $row_siswa['pekerjaan']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Tanggal Daftar</td>
      <td valign="top"><input name="tgl_pendaftaran" type="text" value="<?php echo $row_siswa['tgl_pendaftaran']; ?>" size="20" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap">Nilai Ujian Nasional</td>
      <td valign="top"><span id="sprytextfield5">
        <input type="text" name="nilai_rata_ujian_nasional" value="<?php echo $row_siswa['nilai_rata_ujian_nasional']; ?>" size="15" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><input type="submit" value="SIMPAN" /></td>
      <td align="left" valign="top"><input type="reset" name="Reset" id="button" value="BATAL" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>
  <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
  <script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
</p>
<p>&nbsp;</p>
<p>
  <?php
mysql_free_result($siswa);
?>
</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {useCharacterMasking:true, validateOn:["change"], maxChars:16});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["change"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {validateOn:["change"]});
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4", {validateOn:["change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["change"]});
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
</script>