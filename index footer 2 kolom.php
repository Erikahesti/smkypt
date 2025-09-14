<?php session_start(); require_once('Connections/koneksi.php'); ?>
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

mysql_select_db($database_koneksi, $koneksi);
$query_rec_profil = "SELECT * FROM profil ORDER BY id_profil ASC";
$rec_profil = mysql_query($query_rec_profil, $koneksi) or die(mysql_error());
$row_rec_profil = mysql_fetch_assoc($rec_profil);
$totalRows_rec_profil = mysql_num_rows($rec_profil);

mysql_select_db($database_koneksi, $koneksi);
$query_rec_organisasi = "SELECT * FROM organisasi ORDER BY id_organisasi ASC";
$rec_organisasi = mysql_query($query_rec_organisasi, $koneksi) or die(mysql_error());
$row_rec_organisasi = mysql_fetch_assoc($rec_organisasi);
$totalRows_rec_organisasi = mysql_num_rows($rec_organisasi);

$maxRows_berita = 3;
$pageNum_berita = 0;
if (isset($_GET['pageNum_berita'])) {
  $pageNum_berita = $_GET['pageNum_berita'];
}
$startRow_berita = $pageNum_berita * $maxRows_berita;

mysql_select_db($database_koneksi, $koneksi);
$query_berita = "SELECT * FROM berita ORDER BY id_berita DESC";
$query_limit_berita = sprintf("%s LIMIT %d, %d", $query_berita, $startRow_berita, $maxRows_berita);
$berita = mysql_query($query_limit_berita, $koneksi) or die(mysql_error());
$row_berita = mysql_fetch_assoc($berita);

if (isset($_GET['totalRows_berita'])) {
  $totalRows_berita = $_GET['totalRows_berita'];
} else {
  $all_berita = mysql_query($query_berita);
  $totalRows_berita = mysql_num_rows($all_berita);
}
$totalPages_berita = ceil($totalRows_berita/$maxRows_berita)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Websitesmppti</title>
<style type="text/css">
body {
	background-color: #FF0;
	background-image: url(background-2899263_960_720.jpg);
}
#container {
	width:1000px;
	margin:0 auto;
}
.footer-text {
	color: #FFF;
}
.row-padding {padding:0;}
.mySlides {display:none;}
</style>
<link href="slide.css" media="all" rel="stylesheet">

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<style type="text/css">
body,td,th {
	color: #000;
}
</style>
</head>

<body>
<div id="container">
  <table width="1011" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="150" colspan="3" valign="top" bgcolor="#FFFF00"><img src="header2.JPG" width="1011" height="200"></td>
    </tr>
    <tr>
      <td  colspan="3" valign="top" bgcolor="#99FFFF" style="padding:10px;"><marquee>
      ***SELAMAT DATANG DI WEB SMP PTI PALEMBANG***
      </marquee></td>
    </tr>
    <tr>
      <td colspan="10" valign="top" bgcolor="#FFFF00" class="row-padding"><hr></td>
    </tr>
    <tr>
      <td colspan="10" align="center" valign="top" bgcolor="#FFFF00" class="row-padding"><div align="center">
        <ul id="MenuBar1" class="MenuBarHorizontal">
          <li class="w3-amber"><a href="index.php">Beranda</a> </li>
          <li><a class="MenuBarItemSubmenu" href="#">Profil</a>
            <ul>
              <?php do { ?>
                <li><a href="index.php?menu=profil&id_profil=<?php echo $row_rec_profil['id_profil']; ?>"><?php echo $row_rec_profil['judul']; ?></a></li>
                <?php } while ($row_rec_profil = mysql_fetch_assoc($rec_profil)); ?>
              
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Pelayanan</a>
            <ul>
              <li><a href="index.php?menu=pelayanan_siswa&katakunci=">Data Siswa</a></li>
              <li><a href="index.php?menu=pelayanan_alumni&katakunci=">data alumni</a></li>
              <li><a href="index.php?menu=pelayanan_dataguru&katakunci=">Data Guru</a></li>
              <li><a href="index.php?menu=pelayanan_pendaftaran">Pendafaran</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Organisasi</a>
            <ul>
              <?php do { ?>
                <li><a href="index.php?menu=organisasi&id_organisasi=<?php echo $row_rec_organisasi['id_organisasi']; ?>"><?php echo $row_rec_organisasi['judul']; ?></a></li>
                <?php } while ($row_rec_organisasi = mysql_fetch_assoc($rec_organisasi)); ?>
            </ul>
          </li>
          <li><a href="index.php?menu=galeri">Galeri</a></li>
          <li><a href="index.php?menu=bukutamu">Buku Tamu</a></li>
          <li><a href="index.php?menu=kontak">Kontak Kami</a></li>
        </ul>
        <br>
        <br>
      </div></td>
    </tr>
    <tr>
      <td colspan="10" valign="top" bgcolor="#FFFF00" class="row-padding"><hr></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" bgcolor="#990066">
      <div class="w3-content w3-display-container">

<div class="w3-display-container mySlides">
  <img src="gambar/1.png" style="width:100%">
</div>

<div class="w3-display-container mySlides">
  <img src="gambar/2.png" style="width:100%">
</div>



<button class="w3-button w3-display-left w3-black" onclick="plusDivs(-1)">&#10094;</button>
<button class="w3-button w3-display-right w3-black" onclick="plusDivs(1)">&#10095;</button>

</div>
      </td>
    </tr>
    <tr valign="top">
      <td width="212" rowspan="2" bgcolor="#FF66CC" cellspacing="0" cellpadding="5"><?php include "kiri.php"; ?><p class="footer-text">&nbsp;</p></td>
      <td width="581" bgcolor="#FFFF00" style="padding:10px;"><?php include "menu.php"; ?>
      </td>
      <td width="218" bgcolor="#FF66CC"><?php include "kanan.php"; ?></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#990066"><span class="footer-text">Copyright &copy; 2019<br>
        Design by Diana Kurniati<br>
        AMIK Bina Sriwijaya Palembang<br>
        Jl. H.M Ryacudu 24 Telp. 0711-5210019<br>
      Website: www.binasriwijaya.ac.id Email: info@binasriwijaya.ac.id </span></td>
      <td align="center" valign="top" bgcolor="#990066">&nbsp;</td>
    </tr>
  </table>
</div>
<script>
var slideIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none"; 
  }
  slideIndex++;
  if (slideIndex > x.length) {slideIndex = 1} 
  x[slideIndex-1].style.display = "block"; 
  setTimeout(carousel, 2000); // Change image every 2 seconds
}
</script>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($rec_profil);

mysql_free_result($rec_organisasi);
?>
