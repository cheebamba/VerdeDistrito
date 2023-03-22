<?
// najczesciej z url
horizontal_referer($rmsg['title']['referer'], 'referer.isl', 'barh2.gif', $istat['count_referer'], $rmsg['raport']['no_data'],0,420,400);

print('<br>');

// najczesciej z wyszukiwarek
horizontal($rmsg['title']['search'], 'search.isl', 'barh3.gif', $istat['count_search'], $rmsg['raport']['no_data']);

print('<br>');

// s³owa kluczowe
horizontal($rmsg['title']['keyword'], 'keyword.isl', 'barh3.gif', $istat['count_keyword'], $rmsg['raport']['no_data']);


function horizontal_referer($title, $plik, $img, $count, $brak, $flags=0,$width1=200, $width2=400)
{
?>
   <table border='0' cellspacing='0' cellpadding='0' width='776' align='center' bgcolor='#336699'>
   <tr>
       <td>
            <table width='776' align='center' cellspacing='1' cellpadding='2' border='0'>
            <tr bgcolor='#336699' height='10'>
                 <td align='center' class='bmiddle' colspan='12'><b><? print($title); ?></td>
            </tr>
            <?
               if($flags != 0) include('include/lang.inc.php');
               $file = file('logs/'.$plik);
               $sort = sortuj($file);
               $ile = count($file);
               if($count==0) $count=$ile;
               $max = 0;
               for($n=0; $n<$ile; $n++) if($max < $sort[$n]->nr) $max = $sort[$n]->nr;
               if($ile < $count) $count = $ile;
               if($ile > 0)
               {
                  for($n=0; $n<$count; $n++)
                  {
                      $numer = trim($sort[$n]->nr);
                      $tekst = trim($sort[$n]->str);
                      $date = trim($sort[$n]->date);
                      if(!empty($max)) $dlugosc = round($width2*$numer/$max);
                      else $dlugosc = 1;
                      print('<tr bgcolor="#EEEEEE" class=small><td rowspan=2>'.($n+1).'</td><td  colspan=3 class=small width=\''.$width1.'\'>');
                      print '<a href='.$tekst.' target=_blank class=small style="text-decoration:none">'.$tekst.'</a>';
                      print'</td></tr><tr bgcolor="#EEEEEE"><td class=small>';
                      print'<img src=\'img/'.$img.'\' border=0 width=\''.$dlugosc.'\' height=\'10\' align=\'absmiddle\'>';
                      print'</td><td class=small  width=\'80\'>'.$numer.'</td>';
                      echo '<td class=small width=150 align=center>'.date("d-m-Y H:i",$date).'</td>';
                      echo '</tr>';
                  }
               }
               else print('<tr><td class=\'small\' bgcolor=\'#EEEEEE\'><font color=\'#FF0000\'>'.$brak.'</td></font></tr>');
             ?>
             </table>
         </td>
     </tr>
     </table>
   <?
}


?>
