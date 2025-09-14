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
  $insertSQL = sprintf("INSERT INTO alumni (NIA, NISN, no_ijazah, tahun_tamat) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['NIA'], "int"),
                       GetSQLValueString($_POST['NISN'], "text"),
                       GetSQLValueString($_POST['no_ijazah'], "text"),
                       GetSQLValueString($_POST['tahun_tamat'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
  
  $updateSQL2 = sprintf("UPDATE siswa SET status=%s  WHERE NISN=%s",
                       GetSQLValueString("ALUMNI", "text"),				   
                       GetSQLValueString($_POST['NISN'], "text"));
					   
	mysql_select_db($database_koneksi, $koneksi);
  $Result2 = mysql_query($updateSQL2, $koneksi) or die(mysql_error());				   

  $insertGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
      echo	"<meta http-equiv='refresh' content='0;URL=admin.php?menu=kelola_alumni' />";
}



$maxRows_alumni = 10;
$pageNum_alumni = 0;
if (isset($_GET['pageNum_alumni'])) {
  $pageNum_alumni = $_GET['pageNum_alumni'];
}
$startRow_alumni = $pageNum_alumni * $maxRows_alumni;

mysql_select_db($database_koneksi, $koneksi);
$query_alumni = "SELECT * FROM alumni,siswa,pendaftaran WHERE siswa.no_daftar=pendaftaran.no_daftar AND siswa.NISN=alumni.NISN GROUP BY alumni.NIA";
$query_limit_alumni = sprintf("%s LIMIT %d, %d", $query_alumni, $startRow_alumni, $maxRows_alumni);
$alumni = mysql_query($query_limit_alumni, $koneksi) or die(mysql_error());
$row_alumni = mysql_fetch_assoc($alumni);

if (isset($_GET['totalRows_alumni'])) {
  $totalRows_alumni = $_GET['totalRows_alumni'];
} else {
  $all_alumni = mysql_query($query_alumni);
  $totalRows_alumni = mysql_num_rows($all_alumni);
}
$totalPages_alumni = ceil($totalRows_alumni/$maxRows_alumni)-1;

$queryString_alumni = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_alumni") == false && 
        stristr($param, "totalRows_alumni") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_alumni = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_alumni = sprintf("&totalRows_alumni=%d%s", $totalRows_alumni, $queryString_alumni);
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function suggest(inputString){
	if(inputString.length == 0) {
		$('#suggestions').fadeOut();
	} else {
	$('#country').addClass('load');
		$.post("kelola_alumni_data.php", {nomor: ""+inputString+""}, function(data){
			if(data.length >0) {
				$('#suggestions').fadeIn();
				$('#suggestionsList').html(data);
				$('#country').removeClass('load');
			}
		});
	}
}

function fill(thisValue) {
	$('#nama_lengkap').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);
}
                      
function fill2(thisValue) {
	$('#NISN').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill3(thisValue) {
	$('#tahun_kelulusan').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill4(thisValue) {
	$('#nm_asl_sekolah').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill5(thisValue) {
	$('#jenis_kelamin').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill6(thisValue) {
	$('#tempat_lahir').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill7(thisValue) {
	$('#tanggal_lahir').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);
}
function fill8(thisValue) {
	$('#alamat').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill9(thisValue) {
	$('#no_telpon').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill10(thisValue) {
	$('#nm_orang_tua').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill11(thisValue) {
	$('#agama').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill12(thisValue) {
	$('#pekerjaan_ortu').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill13(thisValue) {
	$('#tgl_daftar').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
function fill14(thisValue) {
	$('#NIS').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 100);  
}
</script>
<style>
#result {
	height:20px;
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#FFFF99;
}
#country{
	padding:3px;
	border:1px #CCC solid;
	font-size:12px;
}
.suggestionsBox {
	
	left: 0px;
	top:12px;
	margin: 0px 0px 0px 0px;
	width: 220px;
	padding:0px;
	background-color:#666;
	color: #fff;
}
.suggestionList {
	margin: 0px;
	padding: 0px;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
}
.suggestionList ul li:hover {
	background-color: #999;
	color:#000;
}
.suggestionList ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#FFF;
	padding:0;
	margin:0;
}

.load{}

#suggest {
	position:relative;
}
</style>
<p align="center"><strong>KELOLA DATA ALUMNI</strong></p>
<div style="border:1px solid #333; width:500px; margin:0 auto; padding:30px">
<?php 
$query = "SELECT MAX(NIA) AS maxID FROM alumni";

$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idMax = $data['maxID'];

$idMax++;

$nodaftar = $idMax;
?>
  <form method="POST" name="form1" action="<?php echo $editFormAction; ?>">
    <table width="500" align="center" cellpadding="5" cellspacing="0">
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>NIA</td>
        <td align="left" valign="top"><input type="text" name="NIA" value="<?php echo $nodaftar; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>NISN</td>
        <td align="left" valign="top"><input name="NISN" type="text" id="NISN" value="" size="32" onkeyup="suggest(this.value);" onblur="fill2();">
        <div class="suggestionsBox" id="suggestions" style="display: none;">
           <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
         </div>
        </td>
      </tr>
      
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Nama Lengkap</td>
        <td align="left" valign="top"><input type="text" name="nama_lengkap" id="nama_lengkap" value="" onkeypress="return hanyaHuruf(event);" placeholder="di isi dengan huruf">
        
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
        <td align="left" valign="top"><label for="jenis_kelamin"></label>
          <select name="jenis_kelamin" id="jenis_kelamin">
          <option value="">-Pilih-</option>
            <option value="laki-laki">laki-laki</option>
            <option value="perempuan">perempuan</option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Tempat Lahir</td>
        <td align="left" valign="top"><input name="tempat_lahir" type="text" id="tempat_lahir" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top"><input name="tanggal_lahir" type="date" id="tanggal_lahir" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Alamat</td>
        <td align="left" valign="top"><input type="text" name="alamat" id="alamat" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="left" valign="top" nowrap>Nomor Telpon</td>
        <td align="left" valign="top"><input type="text" name="no_telpon" id="no_telpon" value="" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
        
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
        <td align="left" valign="top" nowrap="nowrap">Nama Orang Tua</td>
        <td align="left" valign="top"><input type="text" name="nm_orang_tua" id="nm_orang_tua" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top" nowrap="nowrap">Agama</td>
        <td align="left" valign="top"><input name="agama" type="text" id="agama" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top" nowrap="nowrap">Pekerjaan Orang Tua</td>
        <td align="left" valign="top"><input name="pekerjaan_ortu" type="text" id="pekerjaan_ortu" value="" placeholder="di isi dengan huruf" onkeypress="return hanyaHuruf(event)" >
        
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
        <td align="left" valign="top" nowrap>Tahun Tamat</td>
        <td align="left" valign="top"><input type="text" name="tahun_tamat" value="" placeholder="di isi dengan angka" onkeypress="return hanyaAngka(event)" >
        
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
        <td align="left" valign="top" nowrap="nowrap">No Ijazah</td>
        <td align="left" valign="top"><input name="no_ijazah" type="text" id="no_ijazah" value="" size="32" /></td>
      </tr>
      <tr align="left" valign="baseline">
        <td align="right" valign="top" nowrap>&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr align="left" valign="baseline">
        <td align="right" valign="top" nowrap><input name="tgl_daftar" type="hidden" id="tgl_daftar" value="" size="32" />          <input type="submit" value="SIMPAN"></td>
        <td valign="top"><input type="reset" name="Reset" id="button" value="BATAL"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form></div>
<p>&nbsp;</p>
<p>&nbsp;
<table width="600" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>NIA</td>
    <td>NISN</td>
    <td>Nama Lengkap</td>
    <td>Alamat</td>
    <td>Tahun Tamat</td>
    <td width="150" align="center">AKSI</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_alumni['NIA']; ?></td>
      <td><?php echo $row_alumni['NISN']; ?>&nbsp; </td>
      <td><?php echo $row_alumni['nama_lengkap']; ?>&nbsp; </td>
      <td><?php echo $row_alumni['alamat']; ?>&nbsp; </td>
      <td><?php echo $row_alumni['tahun_tamat']; ?>&nbsp; </td>
      <td align="center"><a href="admin.php?menu=kelola_alumni_detail&recordID=<?php echo $row_alumni['NIA']; ?>">Detail</a>  <a href="admin.php?menu=kelola_alumni_hapus&recordID=<?php echo $row_alumni['NIA']; ?>">Hapus</a> <a href="kelola_alumni_cetak.php?recordID=<?php echo $row_alumni['NIA']; ?>">Cetak</a></td>
    </tr>
    <?php } while ($row_alumni = mysql_fetch_assoc($alumni)); ?>
</table>
<br>
<table border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td><?php if ($pageNum_alumni > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_alumni=%d%s", $currentPage, max(0, $pageNum_alumni - 1), $queryString_alumni); ?>">Back</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_alumni < $totalPages_alumni) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_alumni=%d%s", $currentPage, min($totalPages_alumni, $pageNum_alumni + 1), $queryString_alumni); ?>">Next</a>
      <?php } // Show if not last page ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;
  <?php
mysql_free_result($alumni);
?>
