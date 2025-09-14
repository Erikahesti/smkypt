<p>Berita</p>
<?php do { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="64" valign="top">Judul</td>
      <td width="316"><?php echo $row_berita['judul']; ?></td>
    </tr>
    <tr>
      <td valign="top">Isi </td>
      <td><?php echo strip_tags(substr(substr($row_berita['isi_berita'],0,200),0,strrpos(substr($row_berita['isi_berita'],0,200),' '))); ?> <a href="index.php?menu=berita_detail&amp;id_berita=<?php echo $row_berita['id_berita']; ?>">Detail...</a></td>
    </tr>
  </table>
  <?php } while ($row_berita = mysql_fetch_assoc($berita)); ?>
<p>&nbsp;</p>
<?php
mysql_free_result($berita);
?>