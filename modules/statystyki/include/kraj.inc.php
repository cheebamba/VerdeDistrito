<br>
<table border=0 cellspacing=0 cellpadding=0 width=776 align=center bgcolor=#336699 >
  <tr><td>
	   <table width=776 align=center cellspacing=1 cellpadding=2 border=0>
		<tr bgcolor=#336699 height=10><td align=center class=bmiddle colspan=4><b><? echo $rmsg[title][country]; ?></td></tr>
<?

$addr=file("logs/lang.isl");
$ds=count($addr);
if($istat[count_country]>$ds) $istat[count_country]=$ds;

if($addr!=0){
 $s_pages=sortuj($addr);
 for($n=0; $n<$ds; $n++) if($max_pages<$s_pages[$n]->nr) $max_pages=$s_pages[$n]->nr;
} 
else $max_pages=1;

for($n=0; $n<$ds; $n++)
{
 $numer=$s_pages[$n]->nr;
 $tekst=$s_pages[$n]->str;
 if($s_pages[$n]->nr<1) continue;
 $dlugosc=round((100*$numer/$max_pages)*4);
 echo "<tr bgcolor=#eeeeee class=small>";
 echo "<td>$numer</td>";
 echo "<td><img src=images/barh3.gif border=0 width=$dlugosc height=10></td>";
 echo "<td>$tekst</td>";
 echo "</tr>";
}
if($istat[count_country]==0) echo "<tr><td class=small bgcolor=#eeeeee><font color=red>".$rmsg[raport][no_data]."</td></tr>";

?>
</table>
</td></tr></table>

