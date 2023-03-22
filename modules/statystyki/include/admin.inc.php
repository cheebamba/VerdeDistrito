<?


if(get_mode('conf.php')!='111')
{
    echo '<center><span style="color:red">ERROR: Nie mo¿na zapisywaæ dla pliku conf.php. Zmieñ jego uprawnienia (chmod 0666).<br></span>';
    echo '<br>Zmiana konfiguracji nie jest mo¿liwa, poniewa¿ nie mo¿na zmieniæ zawarto¶ci pliku konfiguracyjnego';
    exit;
}


if(isset($_POST['is']) && $error == '')
{
    ChangeConfig();
    include('conf.php');
    include('lang/'.$istat['lang'].'.php');
}
session_start();
$haslo_ad = 'niemampomyslu';
$haslo = $_SESSION['haslo'];
$wyslij = $_POST['wyslij'];
if(empty($haslo)){
	$haslo = $_POST['haslo'];
}
if(!empty($wyslij)){
	if($haslo == $haslo_ad){
		$zezwalam = '1';
		$haslo = $_POST['haslo'];
		session_register('haslo');
	}
	else {
		$zezwalam = '0';
		$wyswietlane = '<b>Z³e has³o !</b><br><hr><br>';
	}
}
else {
	if($haslo == $haslo_ad){
		$zezwalam = '1';
		
	}
	else {
		$zezwalam = '0';
	}
}
if($zezwalam == '0'){
	$wyswietlane .= '<form method="POST" action="index.php?p=admin">Has³o: <input type="password" name="haslo"><input type="hidden" name="wyslij" value="OK"><br><input type="submit" name="submit" value="Wyslij">';
	echo '<div align="center"><table width="30%"><tr><td align="center">'.$wyswietlane.'</td></tr></div>';
	exit;
}

?>
<center><font class='error'><? print($error); ?></font></center>
<table border='0' cellspacing='0' cellpadding='0' width='776' align='center' bgcolor='#336699'>
       <tr>
              <td>
                     <table width='776' align='center' cellspacing='1' cellpadding='2' border='0' class='small'>
                     <form action='index.php?p=<? print($_GET['p']); ?>' method='post'>
                            <tr bgcolor='#336699' height='10'>
                                   <td align='center' class='bmiddle' colspan='2'><? print($rmsg['admin']['title']); ?>
                                          <input type='hidden' name='ver' value='<? print($istat['ver']); ?>'>
                                          <input type='hidden' name='img' value='<? print($istat['img']); ?>'>
                                   </td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td height='28'><? print($rmsg['admin']['code']); ?></td>
                                   <td>
                                   <? $http_path=$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']); ?>
                                   <textarea cols=55 rows=6>
<!-- start istats code -->
<script language="javascript">
<!--
var ipath='<? echo $http_path ?>'
document.write('<SCR' + 'IPT LANGUAGE="JavaScript" SRC="http://'+ ipath +'/istats.js"><\/SCR' + 'IPT>');
//-->
</script>
<!-- end istats code -->

</textarea></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['pages']); ?></td>
                                   <td><input type='checkbox' name='pages'<? if(isset($istat['pages']) && $istat['pages'] == '1') print(' checked'); ?>></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['base_url']); ?></td>
                                   <td><input type='text' name='base_url' value='<? print($istat['base_url']); ?>' size=50></td>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['pass']); ?></td>
                                   <td><input type='text' name='pass_stat'></td>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['pass_conf']); ?></td>
                                   <td><input type='text' name='pass_conf'></td>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['lang']); ?></td>
                                   <td><select name='lang'>
                                       <?
                                         if ($handle = opendir('lang'))
                                         {
                                            while ($file = readdir($handle))
                                            {
                                               if($file=='..' || $file=='.') continue;
                                              $file=substr($file,0,3);
                                               echo "<option value='".$file."'";
                                               if($istat['lang']==$file) echo ' selected ';
                                               echo '>'.$file."\n";
                                            }
                                         }
                                       ?>
                                   </select></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['expired']); ?></td>
                                   <td><input type='text' name='expired' value='<? print($istat['expired']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['ip_out']); ?></td>
                                   <td><input type='text' name='wyklucz' size='50' value='<? print($istat['wyklucz']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_host']); ?></td>
                                   <td><input type='text' name='count_host' value='<? print($istat['count_host']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_domain']); ?></td>
                                   <td><input type='text' name='count_domain' value='<? print($istat['count_domain']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_referer']); ?></td>
                                   <td><input type='text' name='count_referer' value='<? print($istat['count_referer']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_keyword']); ?></td>
                                   <td><input type='text' name='count_keyword' value='<? print($istat['count_keyword']); ?>'></td>
                            </tr>
                            <tr bgcolor='#efefef'>
                                   <td><? print($rmsg['admin']['count_country']); ?></td>
                                   <td><input type='text' name='count_country' value='<? print($istat['count_country']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_last']); ?></td>
                                   <td><input type='text' name='count_last' value='<? print($istat['count_last']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_search']); ?></td>
                                   <td><input type='text' name='count_search' value='<? print($istat['count_search']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_os']); ?></td>
                                   <td><input type='text' name='count_os' value='<? print($istat['count_os']); ?>'></td>
                            </tr>
                            <tr bgcolor='#EFEFEF'>
                                   <td><? print($rmsg['admin']['count_browser']); ?></td>
                                   <td><input type='text' name='count_browser' value='<? print($istat['count_browser']); ?>'></td>
                            </tr>
                            <tr>
                                   <td colspan='2' bgcolor='#EFEFEF' align='center'><input type='submit' value=' - OK - ' name='is' class='small'></td>
                            </tr>
                     </form>
                     </table>
              </td>
       </tr>
</table>

<br>

<?

 function ChangeConfig()
 {
       $lines = file('conf.php');
       $ile=count($lines);
       if(!$_POST['pages']) $_POST['pages']='0';  else $_POST['pages']='1';
       for($n=0; $n<$ile; $n++)
       {
           if(substr($lines[$n],0,1)=='#') continue;
           foreach($_POST as $key => $var)
           {
             if($key=='is' || $var=='') continue;
             if(ereg("'$key'",$lines[$n]))
              {
                 if($key=='pass_stat' AND $_POST['pass_stat']!='') $_POST[$key]=md5($_POST[$key]);
                 if($key=='pass_conf' AND $_POST['pass_conf']!='') $_POST[$key]=md5($_POST[$key]);
                 $lines[$n] = '$istat[\''.$key.'\'] = \''.$_POST[$key].'\';';
               }
           }

       }
       // lock the file for sec. and write the data
       $fid = fopen('conf.php', 'w');                                                                                                                                                   // open
       flock($fid, 2);                                                                                                                                                                                                    // lock
       for($n=0; $n<$ile; $n++) fwrite($fid, chop($lines[$n])."\n");              // write
       flock($fid, 3);                                                                                                                                                                                                    // unlock
       fclose($fid);                                                                                                                                                                                                           // close
 }

function get_mode($filepath)
{
     $mode = fileperms($filepath);
      $d[] = ($mode & 00200) ? '1' : '';
      $d[] = ($mode & 00020) ? '1' : '';
      $d[] = ($mode & 00002) ? '1' : '';
      return implode('',$d);

}

?>
