<?
$lines = file('logs/last.isl');
$num = count($lines);
if($istat['count_last'] > $num) $istat['count_last'] = $num;
?>
<table border='0' cellspacing='0' cellpadding='0' width='776' align='center' bgcolor='#336699'>
  <tr>
    <td>
      <table width='776' align='center' cellspacing='1' cellpadding='3' border='0'>
        <tr bgcolor='#336699' height='10'>
          <td align='center' class='bmiddle' colspan='4'><b><? print($istat['count_last'].$rmsg['title']['last']); ?></td>
        </tr>
        <tr bgcolor='#1F98DA' class=wsmall>
          <td align=center><? echo $rmsg['last']['date'] ?> </td>
          <td align=center><? echo $rmsg['last']['info'] ?> </td>
          <td align=center><? echo $rmsg['last']['tech'] ?> </td>
          <td align=center><? echo $rmsg['last']['last'] ?> </td>
        </tr>
<?
if($istat['count_last'] > 0)
{
  for($n=0; $n<$istat['count_last']; $n++)
  {
    $str = explode('::', $lines[$n]);
?>
        <tr class='small' bgcolor='#EEEEEE' style='font-size:9px'>
          <td width='100' align='center'><? echo date("d-m-Y\nH:i:s",$str[1]); ?></td>
          <td>
            <? echo $str[2]; ?></b><br>
            <? print('<a href=\''.$str[3].'\' target=\'_blank\'>'.$str[3].'</a>'); ?><br>
          </td>
          <td align=center width=120>
            <? print($str[4]); ?><br>
            <? print($str[5]); ?>
          </td>
          <td width=90 align=center>
            <?

                               if($str[6]>0) echo date("d-m-Y\nH:i:s",$str[7]);
                                else echo '<span class=ret>'.$rmsg['last']['new'].'</span>';
?>
          </td>
        </tr>
        <?
  }
}
else print('<tr><td colspan=\'4\' class=\'small\' bgcolor=\'#EEEEEE\'><font color=\'#FF0000\'>'.$rmsg['raport']['no_data'].'</font></td></tr>'); ?>
      </table>
    </td>
  </tr>
</table>