<?php
$hari = date("d");
$bulan = date ("m");
$tahun = date("Y");
$jumlahhari=date("t",mktime(0,0,0,$bulan,$hari,$tahun));
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse;">
  <tr bgcolor="#FFC20E">
  <td align=center><font color="#FF0000">Mg</font></td>
  <td align=center>Sen</td>
  <td align=center>Sel</td>
  <td align=center>Rab</td>
  <td align=center>Kam</td>
  <td align=center>Jum</td>
  <td align=center>Sab</td>
  </tr>
  <?php
$s=date ("w", mktime (0,0,0,$bulan,1,$tahun));
 
for ($ds=1;$ds<=$s;$ds++) {
echo "<td></td>";
}
 
for ($d=1;$d<=$jumlahhari;$d++) {
 
 if (date("w",mktime (0,0,0,$bulan,$d,$tahun)) == 0) {
  echo "<tr>"; 
  }
$warna="#000000"; 
 
if (date("l",mktime (0,0,0,$bulan,$d,$tahun)) == "Sunday") { $warna="#FF0000"; }
echo "<td align=center valign=middle> <span style=\"color:$warna\">$d</span></td>"; 
if (date("w",mktime (0,0,0,$bulan,$d,$tahun)) == 6) { echo "</tr>"; }
}
?>
</table>