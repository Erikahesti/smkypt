<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">

<style type="text/css">
body {
	background-color:#900;
}
body,td,th {
	color:#333;
}
</style>
</head>

<body>
<div style="border:1px solid #333; width:900px; margin:0 auto;">
<table width="900" border="10" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td height="105" colspan="2" valign="top" bgcolor="#990000"><img src="../header22.jpg" width="931" height="214"></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#990000" style="color:#FFF;"><marquee><strong>SELAMAT DATANG DI HALAMAN ADMIN WEBSITE</strong></marquee></td>
  </tr>
  <tr>
    <td width="250" valign="top" bgcolor="#FFFFFF"><ul id="MenuBar1" class="MenuBarVertical">
      <li><a href="admin.php?menu=home" style="border-radius:300px">HOME</a></li>
      <li><a href="admin.php?menu=kelola_pendaftaran&pilihan=nama_lengkap&katakunci=" style="border-radius:300px">KELOLA DATA PENDAFTARAN</a></li>
      <li><a href="admin.php?menu=kelola_siswa" style="border-radius:300px">KELOLA DATA SISWA</a></li>
     
      <li><a href="admin.php?menu=kelola_admin" style="border-radius:300px">KELOLA ADMIN</a></li>
      <li><a href="admin.php?menu=kelola_profil" style="border-radius:300px">KELOLA PROFIL</a></li>
<li><a href="admin.php?menu=kelola_organisasi" style="border-radius:300px">KELOLA ORGANISASI</a></li>
      <li><a href="admin.php?menu=kelola_berita" style="border-radius:300px">KELOLA BERITA</a></li>
      <li><a href="admin.php?menu=kelola_bukutamu" style="border-radius:300px">KELOLA BUKU TAMU</a></li>
      <li><a href="admin.php?menu=kelola_galeri" style="border-radius:300px">KELOLA GALERI</a></li>
      <li><a href="admin.php?menu=kelola_kontak" style="border-radius:300px">KELOLA KONTAK KAMI</a></li>
      <li><a href="#" class="MenuBarItemSubmenu"style="border-radius:300px">KELOLA POLLING</a>
        <ul>
          <li><a href="admin.php?menu=kelola_polling_web" style="border-radius:300px">Polling web</a></li>
          <li><a href="admin.php?menu=kelola_polling_pelayanan" style="border-radius:300px">Polling Pelayanan</a></li>
        </ul>
      </li>
      <li><a href="admin.php?menu=kelola_laporan" style="border-radius:300px">LAPORAN-LAPORAN</a></li>
 
      <li><a href="<?php echo $logoutAction ?>" style="border-radius:300px">LOG OUT</a></li>
    </ul></td>
    <td width="682" valign="top" bgcolor="#FFFFFF"><p>
      <?php include "menu.php"; ?>
    </p>
      <p>&nbsp; </p></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#990000"><span style="color:#FFF;">Copyright 2025 By Erika
      ITB Bina Sriwijaya Palembang<br>
Jl. H.M Ryacudu 24 Telp. 0711-5210019<br>
Website: www.binasriwijaya.ac.id Email: info@binasriwijaya.ac.id</span></td>
  </tr>
</table>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>