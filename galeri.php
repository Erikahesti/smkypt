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

$maxRows_galeri = 4;
$pageNum_galeri = 0;
if (isset($_GET['pageNum_galeri'])) {
  $pageNum_galeri = $_GET['pageNum_galeri'];
}
$startRow_galeri = $pageNum_galeri * $maxRows_galeri;

mysql_select_db($database_koneksi, $koneksi);
$query_galeri = "SELECT * FROM galeri ORDER BY id_galeri ASC";
$query_limit_galeri = sprintf("%s LIMIT %d, %d", $query_galeri, $startRow_galeri, $maxRows_galeri);
$galeri = mysql_query($query_limit_galeri, $koneksi) or die(mysql_error());
$row_galeri = mysql_fetch_assoc($galeri);

if (isset($_GET['totalRows_galeri'])) {
  $totalRows_galeri = $_GET['totalRows_galeri'];
} else {
  $all_galeri = mysql_query($query_galeri);
  $totalRows_galeri = mysql_num_rows($all_galeri);
}
$totalPages_galeri = ceil($totalRows_galeri/$maxRows_galeri)-1;

$queryString_galeri = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_galeri") == false && 
        stristr($param, "totalRows_galeri") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_galeri = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_galeri = sprintf("&totalRows_galeri=%d%s", $totalRows_galeri, $queryString_galeri);
?>
<p align="center">HALAMAN GALERI PFOTO</p>
<div style="width:100%; margin:0; padding:30px; text-align:center;">
<?php do { ?>
  <div style="float:left; border:0; width:45%;">
  <p align="center"><img src="gambar/<?php echo $row_galeri['photo']; ?>" width="50%" height="auto" style="border: 1px solid #333;"/></p>
  <p align="center"><?php echo $row_galeri['keterangan']; ?></p>
  </div>

<?php } while ($row_galeri = mysql_fetch_assoc($galeri)); ?>
</div>
<div style="clear:both;"></div>
<p align="center">
<a href="<?php printf("%s?pageNum_galeri=%d%s", $currentPage, max(0, $pageNum_galeri - 1), $queryString_galeri); ?>">Back</a>
<a href="<?php printf("%s?pageNum_galeri=%d%s", $currentPage, min($totalPages_galeri, $pageNum_galeri + 1), $queryString_galeri); ?>">Next</a>
</p>

<?php
mysql_free_result($galeri);
?>
