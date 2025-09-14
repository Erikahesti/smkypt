
<?php require_once('Connections/koneksi.php'); ?>
<?php
//$_POST['pilihan']=0;
if(isset($_POST['pilihan'])){
	if($_POST['pilihan']=='sangat_baik'){
		$vote="sangat_baik";
	}elseif($_POST['pilihan']=='baik'){
		$vote="baik";
	}elseif($_POST['pilihan']=='cukup'){
		$vote="cukup";
	}elseif($_POST['pilihan']=='kurang'){
		$vote="kurang";
	}
$query = "UPDATE polling_web SET $vote=$vote+1 WHERE id_polling='1'";	
$simpan= mysql_query($query);
	
}
$lihat = "SELECT * FROM polling_web WHERE id_polling='1'";	
$hasil= mysql_query($lihat);

$hasil= mysql_fetch_array($hasil);
$totalpemilih= $hasil['sangat_baik']+$hasil['baik']+$hasil['cukup']+$hasil['kurang'];

?>
<table width="280" border="0" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="3" align="center"><strong>HASIL POLLING WEB</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="25">&nbsp;</td>
                <td width="133">Sangat Baik</td>
                <td width="92">= <?php echo $hasil['sangat_baik']; ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Baik</td>
                <td>= <?php echo $hasil['baik']; ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Cukup</td>
                <td>= <?php echo $hasil['cukup']; ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Kurang</td>
                <td>= <?php echo $hasil['kurang']; ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="id_polling"></label></td>
                <td>Total Pemilih</td>
                <td>= <?php echo $totalpemilih; ?></td>
              </tr>
            </table>