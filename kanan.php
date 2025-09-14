<style type="text/css">
body {
	background-color: #3F9;
}
</style>
<table width="210" border="0" cellspacing="0" cellpadding="5" style="border-collapse:collapse; border-top:0px solid #33FF99;border-right:0px solid #33FF99;border-bottom:0px solid #33FF99;border-left:0px solid #33FF99;">
        <tr>
          <td width="198" align="center" bgcolor="#990000" class="footer-text" style="border-radius:100px;
	box-shadow: 10px 10px;-webkit-box-shadow: 10px 10px 0px 0px rgba(251,255,23,1);
-moz-box-shadow: 10px 10px 0px 0px rgba(251,255,23,1);
box-shadow: 10px 10px 0px 0px rgba(251,255,23,1); ">Statistik</td>
  </tr>
        <tr>
          <td ><?php
   $ip   = $_SERVER['REMOTE_ADDR'];
   $tanggal = date("Ymd");
   $waktu  = time();
   $bln=date("m");
   $tgl=date("d");
   $blan=date("Y-m");
   $thn=date("Y");
   $tglk=$tgl-1;

              $s = mysql_query("SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");

              if(mysql_num_rows($s) == 0){
                mysql_query("INSERT INTO statistik(ip, tanggal, hits, online) VALUES('$ip','$tanggal','1','$waktu')");
              } 
              else{
                mysql_query("UPDATE statistik SET hits=hits+1, online='$waktu' WHERE ip='$ip' AND tanggal='$tanggal'");
              }
     if($tglk=='1' | $tglk=='2' | $tglk=='3' | $tglk=='4' | $tglk=='5' | $tglk=='6' | $tglk=='7' | $tglk=='8' | $tglk=='9'){
    $kemarin=mysql_query("SELECT * FROM statistik WHERE tanggal='$thn-$bln-0$tglk'");
     } else {
    $kemarin=mysql_query("SELECT * FROM statistik WHERE tanggal='$thn-$bln-$tglk'");
     }
     $bulan=mysql_query("SELECT * FROM statistik WHERE tanggal LIKE '%$blan%'");
     $bulan1=mysql_num_rows($bulan);
     $tahunini=mysql_query("SELECT * FROM statistik WHERE tanggal LIKE '%$thn%'");
     $tahunini1=mysql_num_rows($tahunini);
              $pengunjung       = mysql_num_rows(mysql_query("SELECT * FROM statistik WHERE tanggal='$tanggal' GROUP BY ip"));
              $totalpengunjung  = mysql_result(mysql_query("SELECT COUNT(hits) FROM statistik"), 0); 
              $hits             = mysql_fetch_assoc(mysql_query("SELECT SUM(hits) as hitstoday FROM statistik WHERE tanggal='$tanggal' GROUP BY tanggal")); 
              $totalhits        = mysql_result(mysql_query("SELECT SUM(hits) FROM statistik"), 0); 
              $bataswaktu       = time() - 300;
              $pengunjungonline = mysql_num_rows(mysql_query("SELECT * FROM statistik WHERE online > '$bataswaktu'"));
     $kemarin1 = mysql_num_rows($kemarin);


?>
<table width="200" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="120">Hari ini</td>
              <td>: <?php echo $pengunjung; ?></td>
            </tr>
            <tr>
              <td>Kemarin</td>
              <td>: <?php echo $kemarin1; ?></td>
            </tr>
            <tr>
              <td>Bulan Ini</td>
              <td>: <?php echo $bulan1; ?></td>
            </tr>
            <tr>
              <td>Total Hits</td>
              <td>: <?php echo $totalhits; ?></td>
            </tr>
            <tr>
              <td>Online</td>
              <td>: <?php echo $pengunjungonline; ?></td>
            </tr>
          </table></td>
  </tr>
        <tr>
          <td align="center" bgcolor="#990000" class="footer-text" style="border-radius:100px; box-shadow: 10px 10px;-webkit-box-shadow: 10px 10px 0px 0px rgba(251,255,23,1); -moz-box-shadow: 10px 10px 0px 0px rgba(251,255,23,1); box-shadow: 10px 10px 0px 0px rgba(251,255,23,1); "> Kalender</td>
  </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><?php include "kalender.php"; ?>
		  </td>
  </tr>
        <tr>
          <td align="center" bgcolor="#990000" class="footer-text" style="border-radius:100px; box-shadow: 10px 10px;-webkit-box-shadow: 10px 10px 0px 0px rgba(251,255,23,1); -moz-box-shadow: 10px 10px 0px 0px rgba(251,255,23,1); box-shadow: 10px 10px 0px 0px rgba(251,255,23,1); ">Polling Pelayanan</td>
  </tr>
        <tr>
          <td height="192"><form id="form1" name="form1" method="post" action="index.php?menu=polling_pelayanan">
            <table width="200" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFCC">
                <td width="25"><input name="pilihan" type="radio" id="pilihan" value="sangat_memuaskan" />
                <label for="pilihan"></label></td>
                <td>Sangat Memuaskan</td>
              </tr>
              <tr bgcolor="#FFFFCC">
                <td><input name="pilihan" type="radio" id="pilihan2" value="memuaskan" /></td>
                <td>Memuaskan</td>
              </tr>
              <tr bgcolor="#FFFFCC">
                <td><input name="pilihan" type="radio" id="pilihan3" value="cukup" /></td>
                <td>Cukup Memuaskan</td>
              </tr>
              <tr bgcolor="#FFFFCC">
                <td><input name="pilihan" type="radio" id="pilihan4" value="kurang" /></td>
                <td>Kurang Memuaskan</td>
              </tr>
              <tr bgcolor="#FFFFCC">
                <td height="34">&nbsp;</td>
                <td><input type="submit" name="submit" id="submit" value="PILIH" />
                <input type="button" name="lihat" id="lihat" value="HASIL" onclick="window.location.href='index.php?menu=polling_pelayanan'" /></td>
              </tr>
            </table>
          </form></td>
  </tr>
</table>