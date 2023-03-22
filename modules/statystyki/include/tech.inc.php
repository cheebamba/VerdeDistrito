<?
// najczesciej uzywane przegladarki
horizontal($rmsg['title']['browser'], 'browser.isl', 'barh2.gif', $istat['count_browser'], $rmsg['raport']['no_data']);

print('<br>');
// najvczesciej uzywane systemy operacyjne
horizontal($rmsg['title']['os'], 'os.isl', 'barh1.gif', $istat['count_os'], $rmsg['raport']['no_data']);

print('<br>');
?>
<table align='center' width='775' cellspacing='0'>
       <tr>
              <td>
                     <table border='0' cellspacing='0' cellpadding='0' width='380' align='left' align='center' bgcolor='#336699'>
                            <tr>
                                   <td>
                                          <table width='100%' align='center' cellspacing='1' cellpadding='2' border='0'>
                                                 <tr bgcolor='#336699' height='10'>
                                                        <td align='center' class='bmiddle' colspan='12'><b><? print($rmsg['title']['res']); ?></td>
                                                 </tr>
                                                 <?
                                                 $max_res = 0;
                                                 for($n=1; $n<=6; $n++) if($max_res < $dane['stat'][$n]) $max_res = $dane['stat'][$n];
                                                 for($n=1; $n<=6; $n++) {
                                                        if(!empty($max_res)) $dlugosc = round(200*$dane['stat'][$n]/$max_res);
                                                        else $dlugosc = 1;
                                                        print('<tr><td class=\'small\' bgcolor=\'#EEEEEE\'>'.$rmsg['res'][$n-1].'</td><td bgcolor=\'#EEEEEE\' class=\'small\'>');
                                                        print('<img src=\'img/barh2.gif\' border=\'0\' width=\''.$dlugosc.'\' height=\'10\' align=\'absmiddle\'>');
                                                        print('</td><td class=\'small\' bgcolor=\'#EEEEEE\' width=\'60\'>'.$dane['stat'][$n].'</td></tr>');
                                                 }
                                                 ?>
                                          </table>
                                   </td>
                            </tr>
                     </table>
              </td>
              <td>
                     <table border='0' cellspacing='0' cellpadding='0' width='380' align='right' align='center' bgcolor='#336699'>
                            <tr>
                                   <td>
                                          <table width='100%' align='center' cellspacing='1' cellpadding='2' border='0'>
                                                 <tr bgcolor='#336699' height='10'>
                                                        <td align='center' class='bmiddle' colspan='12'><b><? print($rmsg['title']['colors']); ?></td>
                                                 </tr>
                                                 <?
                                                 $max_color = 0;
                                                 for($n=7; $n<=12; $n++) if($max_color < $dane['stat'][$n]) $max_color = $dane['stat'][$n];
                                                 for($n=1; $n<=6; $n++) {
                                                        if(!empty($max_color)) $dlugosc = round(200*$dane['stat'][$n+6]/$max_color);
                                                        else $dlugosc = 1;
                                                        print('<tr><td class=\'small\' bgcolor=\'#EEEEEE\'>'.$rmsg['color'][$n-1].'</td><td class=\'small\' bgcolor=\'#EEEEEE\'>');
                                                        print('<img src=\'img/barh3.gif\' border=\'0\' width=\''.$dlugosc.'\' height=\'10\' align=\'absmiddle\'>');

                                                        print('</td><td class=\'small\' bgcolor=\'#EEEEEE\'>'.$dane['stat'][$n+6].'</td></tr>');

                                                 }

                                                 ?>

                                          </table>

                                   </td>

                            </tr>

                     </table>

              </td>

       </tr>

</table>




