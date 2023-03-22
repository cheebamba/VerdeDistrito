<script language='JavaScript'>
<!--
function winopen(r, m) {
       win = window.open('winday.php?r='+r+'&m='+m,'ISTAT','width=470,height=582,toolbar=0,location=0,directories=0,status=0,menuBar=0,scrollBars=0,resizable=0,top=20,left=20');
}
//-->
</script>

<?
       $s_rok = getyear($rok);
       $s_day = getday($dzien, $miesiac, $rok);

       $odw_w_roku = $s_rok[0];
       $wywolan = $dane['stat'][46];
       $odwiedzin = $dane['stat'][0];
       $odw_w_miesiacu = $s_rok[$miesiac];
       $odw_dzisiaj = $s_day[0];
       $odw_godz = $s_day[$godzina+1];
       if(empty($odw_godz)) $odw_godz = 0;
       $dane['url'] = file('logs/referer.isl');
       $dane['host'] = file('logs/host.isl');

       if(empty($wywolan)) $wywolan = 0;
       if(empty($odwiedzin)) $odwiedzin = 0;
?>

<table width='775' align='center' cellspacing='0'>
       <tr>
              <td valign='top'>
                     <table border='0' cellspacing='0' cellpadding='0' align='left' bgcolor='#336699'>
                            <tr>
                                   <td>
                                          <table width='100%' cellspacing='1' cellpadding='2' border='0'>
                                                 <tr bgcolor='#336699'>
                                                        <td align='center' class='bmiddle' colspan='13'><? print($rmsg['cal']); ?></td>
                                                 </tr>
                                                 <tr bgcolor='#1F98DA'>
                                                        <td class='wsmall'>rok/m</td>
                                                        <? for($n=0; $n<12; $n++) print('<td align=\'center\' class=\'wsmall\'>'.substr($rmsg['month'][$n], 0, 3).'</td>'); ?>
                                                 </tr>
                                                 <?
                                                 for($a=$rok; $a>$rok-7; $a--) {
                                                        if(!is_dir('logs/'.$a)) {
                                                               print('<tr><td align=\'center\' class=\'wsmall\' bgcolor=\'#1F98DA\'>'.$a.'</td>');
                                                               for($n=0; $n<12; $n++) print('<td align=\'center\' width=\'38\' bgcolor=\'#EEEEEE\' class=\'small\'>0</td>');
                                                               print('</tr>');
                                                        }
                                                        else {
                                                               $ms = 0;
                                                               $lines = array();
                                                               for($m=1; $m<=12; $m++) $lines = array_merge($lines, file('logs/'.$a.'/'.$m.'.php'));
                                                               print('<tr><td align=\'center\' bgcolor=\'#1F98DA\' class=\'small\'><font color=\'yellow\'>'.$a.'</a></td>');
                                                               $istat_poz = 0;
                                                               for($n=0; $n<12; $n++) {
                                                                      $istat_max['day'] = 0;
                                                                      $ile_dni = $nrmonth[$n];
                                                                      for($x=1; $x<=$ile_dni; $x++) {
                                                                             $a_dzien = explode(',', $lines[$x-1+$istat_poz]);
                                                                             for($d=0; $d<24; $d++) $istat_max['day'] = $istat_max['day']+$a_dzien[$d];
                                                                      }
                                                                      $istat_poz += $nrmonth[$n];
                                                                      print('<td align=\'center\' width=\'38\' bgcolor=\'#EEEEEE\' class=\'small\'>');
                                                                      print('<a class=\'small\' href=\'javascript:winopen('.$a.', '.$n.')\'>');
                                                                      if($miesiac == ($n+1) && $rok == $a) print('<font color=\'red\'>'.$istat_max['day'].'</font></a>');
                                                                      else print($istat_max['day']);
                                                                      print('</a></td>');
                                                                      $istat_max['day'] = 0;
                                                               }
                                                               print('</tr>');
                                                        }
                                                 }
                                                 ?>
                                          </table>
                                   </td>
                            </tr>
                     </table>
              </td>
              <td width='2' class='small'>&nbsp;</td>
              <td valign='top'>
                     <table border='0' cellspacing='0' cellpadding='0' width='260' align='right' bgcolor='#336699'>
                            <tr>
                                   <td>
                                          <table width='100%' cellspacing='1' cellpadding='2' border='0'>
                                                 <tr bgcolor='#336699'><td align='center' class='bmiddle' colspan='2'><? print($rmsg['ogolne']['title']); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][0]); ?></td><td class='small'>&nbsp;<? print($wywolan); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][1]); ?></td><td class='small'>&nbsp;<? print($odwiedzin); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][2]); ?></td><td class='small'>&nbsp;<? print($odw_w_roku); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][3]); ?></td><td class='small'>&nbsp;<? print($odw_w_miesiacu); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][4]); ?></td><td class='small'>&nbsp;<? print($odw_dzisiaj); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][5]); ?></td><td class='small'>&nbsp;<? print($odw_godz); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][6]); ?></td><td class='small'>&nbsp;<? print(count($dane['host'])); ?></td></tr>
                                                 <tr bgcolor='#EFEFEF'><td class='small'>&nbsp;<? print($rmsg['ogolne'][7]); ?></td><td class='small'>&nbsp;<? print(count($dane['url'])); ?></td></tr>
                                          </table>
                                   </td>
                            </tr>
                     </table>
              </td>
       </tr>
</table>

<br>

<?
// zestawienie roczne
$get[5] = getyear($rok);
vertical($rmsg['title']['year'].' <font color=\'#FFFF00\'>'.$rok.'</font>', 12, $miesiac, $dane['stat'][46], $get[5], 'vgreenbar.jpg', 1, 1, 0, $rmsg['month'], 1);

print('<br>');

// odwiedziny wczoraj
$get[0] = getday($dzien-1, $miesiac, $rok);
if(!empty($get[0][0])) {
       vertical($rmsg['title']['rday'], 24, 24, $dane['stat'][46], $get[0], 'vbluebar2.jpg', 0, 1, 0, 0, 0);
       print('<br>');
}

// odwiedziny dzisiaj
$get[1] = getday($dzien, $miesiac, $rok);
vertical($rmsg['title']['day'], 24, $godzina, $dane['stat'][46], $get[1], 'vbluebar2.jpg', 0, 1, 0, 0, 0);

print('<br>');

// zestawienie miesieczne
$get[2] = getmonth($miesiac, $rok);
vertical($rmsg['title']['month'].'<font color=\'#FFFF00\'>'.$rmsg['month'][$miesiac-1].'</font>', date('t'), $dzien, $dane['stat'][46], $get[2], 'vgreenbar.jpg', 1, 1, 0, 0, 0);

print('<br>');

// najczêsciej w godzinach
$get[3][0] = 0;
for($n=1; $n<=24; $n++) {
       $get[3][$n] = $dane['stat'][$n+12];
       $get[3][0] += $get[3][$n];
}
vertical($rmsg['title']['hours'], 24, 24, 0, $get[3], 'vbluebar2.jpg', 0, 0, 1, 0, 0);

print('<br>');

// najczesciej w dniach tygodnia
$get[4][0] = 0;
for($n=1; $n<=7; $n++) {
       $get[4][$n] = $dane['stat'][$n+36];
       $get[4][0] += $get[4][$n];
}
vertical($rmsg['title']['days_week'], 7, 7, 0, $get[4], 'vredbar.jpg', 0, 0, 1, $rmsg['week'], 0);


?>
