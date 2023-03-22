<?
/*************************************************
  AnubisDev.com 2004 by logic@anubisdev.com
*************************************************/
session_start();
include('conf.php');

if($_GET['p']=='admin' AND $istat['pass_conf']!='' AND $_SESSION['auth']!=2) header('location: login.php');
if($istat['pass_stat']!='' AND $_SESSION['auth']==0) header('location: login.php');
include('./lib/statclass.php');
include('lang/'.$istat['lang'].'.php');



if(!isset($_GET['p'])) $_GET['p'] = '';

$cistat=new statclass(dirname(__FILE__));

// Var to annotate all errors
$error = '';


// Test new Configuration variables
if(isset($_POST['is']))
{
       // ensure these vars are numbers
       $pola = array($_POST['count_host'], $_POST['count_domain'], $_POST['count_referer'], $_POST['count_keyword'], $_POST['count_country'], $_POST['count_last'], $_POST['count_search'], $_POST['count_os'], $_POST['count_browser']);
       for($n=0; $n<count($pola); $n++) sprawdz_pole($pola[$n]);

       // check e-mail addr.
       //sprawdz_email($_POST['email']);

       // ensure there are hours (0-23) or empty
       //$godz = array($_POST['r_dzien_godz'], $_POST['r_tydzien_godz'], $_POST['r_miesiac_godz'], $_POST['r_rok_godz']);
       //for($n=0; $n<count($godz); $n++) sprawdz_godz($godz[$n]);

       $istat = $_POST;   // replace the conf.php vars with the new one in the memory
}


// If errors add this text ?
if($error != '') $error = '<b>'.$rmsg['error']['prepend'].'</b><br>'.$error.'<br>';

// If new conf and no errors continue

$path = dirname(__FILE__);
$rok = date('Y');
$miesiac = date('n');
$dzien = date('d');
$godzina = date('H');

$istat_path = dirname(__FILE__);
if(!empty($istat_path)) $istat_path .= '/';
include('include/month.inc.php');

$dane['logs'] = @file('logs/'.$rok.'/'.$miesiac.'.php');
$nrmonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
if(date('L') == 1) $nrmonth[1] = 29;
$dane['stat']=LoadData();
?>

<html>
       <head>
              <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-2'>
              <meta http-equiv='Reply-to' content='logic@anubisdev.com'>
              <meta name='Author' content='Logic'>
              <title>Statystyka ISTATS</title>
              <link href='istats.css' rel='stylesheet' type='text/css'>
       </head>

       <body topmargin='0' leftmargin='0'>

       <table width='775' align='center' cellpadding='0' cellspacing='0' background='img/panel.jpg' height='60'>
              <tr>
                     <td align='right'>
                            <font color='white' face='verdana' style='font-size: 12px'><b>Imperator STATS <? print($istat['ver']); ?>&nbsp;&nbsp;&nbsp;</b><br></font>
                            <font color='white' face='verdana' style='font-size: 10px'><b><? print($rmsg['author']); ?>Adam Sobociñski&nbsp;&nbsp;&nbsp;<br><? print($rmsg['coop']); ?>Piotr Galas&nbsp;&nbsp;&nbsp;<br>Micha³ Bundyra&nbsp;&nbsp;&nbsp;<br></b></font>
                     </td>
              </tr>
       </table>

       <?
       $count = 6;
       if(!empty($_SESSION['auth'])) $count++;
       if($_SESSION['auth'] == 2) $count++;
       $width = round(775/$count, 0);
       ?>
       <table width='775' align='center' bgcolor='#336699' cellspacing='0' cellpadding='3'>
              <tr align='center'>
                     <td width='<? print($width); ?>'><a href='index.php' class='head' title='<? print($rmsg['menuc'][0]); ?>'><? print($rmsg['menu'][0]); ?></a></td>
                     <td width='<? print($width); ?>'><a href='index.php?p=tech' class='head' title='<? print($rmsg['menuc'][1]); ?>'><? print($rmsg['menu'][1]); ?></a></td>
                     <td width='<? print($width); ?>'><a href='index.php?p=search' class='head' title='<? print($rmsg['menuc'][2]); ?>'><? print($rmsg['menu'][2]); ?></a></td>
                     <td width='<? print($width); ?>'><a href='index.php?p=nets' class='head' title='<? print($rmsg['menuc'][3]); ?>'><? print($rmsg['menu'][3]); ?></a></td>
                     <td width='<? print($width); ?>'><a href='index.php?p=pages' class='head' title='<? print($rmsg['menuc'][4]); ?>'><? print($rmsg['menu'][4]); ?></a></td>
                     <td width='<? print($width); ?>'><a href='index.php?p=last' class='head' title='<? print($rmsg['menuc'][5]); ?>'><? print($rmsg['menu'][5]); ?></a></td>
                     <? if(!empty($_SESSION['auth'])) { ?><td width='<? print($width); ?>'><a href='login.php?p=wyloguj' class='head'><? print($rmsg['menu'][6]); ?></a></td><? } ?>
                     <td width='<? print($width); ?>'><a href='index.php?p=admin' class='head'><? print($rmsg['menu'][7]); ?></a></td>
              </tr>
       </table>

       <br>

<?
switch($_GET['p'])
{
       case 'tech'  : include('include/tech.inc.php');   break;
       case 'search': include('include/search.inc.php'); break;
       case 'nets'  : include('include/hosts.inc.php');  break;
       case 'pages' : include('include/pages.inc.php');  break;
       case 'last'  : include('include/last.inc.php');   break;
       case 'admin' : include('include/admin.inc.php'); break;
       case 'pass'  : include('include/pass.inc.php');   break;
       default: include('include/ogolne.inc.php');       break;
}
?>   <br>
       <table width='775' align='center' bgcolor='#336699' cellspacing='0' cellpadding='3'>
              <tr align='center' class=wsmall>
              <td align=right>
              Copyright &copy 1999-<? echo date("Y") ?>&nbsp;
              </td>
              </tr>
       </table>
       <br><br>

       </body>
</html>


<?
/*************************************************************8
*  Function
********************/



// should only be numbers
function sprawdz_pole($pole) {
       GLOBAL $error, $rmsg;
       if(!ereg('^[0-9]{1,4}$', $pole)) $error .= $rmsg['error']['num1'].$pole.$rmsg['error']['num2'].'<br>';
}

// should only be numbers between 0 and 23 or empty
function sprawdz_godz($pole) {
       GLOBAL $error, $rmsg;
       if($pole != '') if($pole < 0 || $pole > 23 || !ereg('^[0-9]{1,2}$', $pole)) $error .= $rmsg['error']['hour1'].$pole.$rmsg['error']['hour2'].'<br>';
}

// e-mail syntax verification
function sprawdz_email($pole) {
       GLOBAL $error, $rmsg;
       if(!ereg('^[a-z0-9_-]+((\.)[a-z0-9_-]+)*(@)([a-z0-9_-]+(\.))+[a-z]{2,5}$', $pole)) $error .= $rmsg['error']['email'].$pole.'<br>';
}

// for passwords : min. 5 chars and only chars a-z, A-Z and numbers
function sprawdz_haslo($pole) {
       GLOBAL $error, $rmsg;
       if($pole != '') if(!ereg('^[a-zA-Z0-9]{5,}$', $pole)) $error .= $rmsg['error']['pass_num'].'<br>';
}


function LoadData()
{
        $fid = fopen('logs/stat.isl', 'r');
        while(!flock($fid, 2+4));
        $dane = fgetcsv($fid, 1024, ',');
        flock($fid, 3);
        fclose($fid);
        return $dane;
}


class licz {
       var $nr, $str, $date;
}

function sortuj($name) {
       sort($name, SORT_NUMERIC);
       $ile = count($name);
       $tab = array();
       for($n=0; $n<$ile; $n++) {
              $split = explode('|', $name[($ile-$n-1)]);
              settype($split[0], 'integer');
              $tab[$n] = new licz;
              $tab[$n]->nr = $split[0];
              $tab[$n]->str = $split[1];
              $tab[$n]->date = $split[2];
       }
       return $tab;
}





// funkcje wykresu pionowego i poziomego
function vertical($title, $ile, $for, $full, $get, $img, $plus, $stan, $topproc, $bottom, $botproc) {
       ?>
       <table border='0' cellspacing='0' cellpadding='0' width='776' align='center' bgcolor='#336699'>
              <tr>
                     <td height=250>
                            <table width='774' align='center' cellspacing='0' cellpadding='2' height='250' border='0'>
                                   <tr bgcolor='#336699'>
                                          <td align='center' class='bmiddle' colspan='<? print($ile); ?>' height='10'><? print($title); ?></td>
                                   </tr>
                                   <tr valign='bottom' bgcolor='#EFEFEF'>
                                          <?
                                          $width = round(774/$ile, 0);

                                          $min = $full;
                                          $max = 0;

                                          //if($for > 2) $f = $for;
                                          //else $f = 2;
                                         $for=count($get);
                                          for($x=1; $x<=$for; $x++) {
                                                 if($get[$x] > $max) $max = $get[$x];
                                                 if($get[$x] < $min) $min = $get[$x];
                                          }

                                          for($n=0; $n<$ile; $n++) {
                                                 if($plus == 0) $k = $n;
                                                 else $k = $n+1;
                                                 if(!empty($max)) $wysokosc = round((200*$get[$n+1]/$max));
                                                 else $wysokosc = 1;
                                                 print('<td height=230 align=\'center\' width=\''.$width.'\' class=\'');
                                                 if($k <= $for) print('small');
                                                 else print('small3');
                                                 if($topproc == 0) $top = $get[$n+1];
                                                 else $top = round(100*$get[$n+1]/$get[0], 0).'%';
                                                 if($bottom == 0) $bot = $k;
                                                 else $bot = $bottom[$n];
                                                 if($botproc == 1) $bp = round(100*$get[$n+1]/$get[0], 0).'%';
                                                 print('\' background=\'img/krata.gif\'>'.$top.'<br>');
                                                 if($k <= $for) print('<img src=\'img/'.$img.'\' border=\'0\' height=\''.$wysokosc.'\' width=\'14\'><br>');
                                                 if($k == $for) print('<span style=\'color:#FF0000\'>');
                                                 print($bot);
                                                 if($k == $for) print('</span>');
                                                 if($botproc == 1) print('<br>'.$bp);
                                                 print('</td>');
                                          }

                                          ?>
                                   </tr>
                                   <?
                                   if($stan == 0) {
                                          ?>
                                          <tr><td colspan='<? print($ile); ?>' class='middle'>&nbsp;</td></tr>
                                          <?
                                   }
                                   ?>
                            </table>
                            <? if($stan == 1) pokazstan($max, $min, $ile, $get[0]); ?>
                     </td>
              </tr>
       </table>
       <?
}





function horizontal($title, $plik, $img, $count, $brak, $flags=0,$width1=200, $width2=300)
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
                      if(!empty($max)) $dlugosc = round($width2*$numer/$max);
                      else $dlugosc = 1;
                      print('<tr><td bgcolor=\'#EEEEEE\' class=\'small\' width=\''.$width1.'\'>');
                      if($flags != '') print('<img src=\'img/flags/'.$tekst.'.png\'> '.$istat_tld[$tekst]);
                      else print($tekst);
                      print('</td><td bgcolor=\'#EEEEEE\' class=\'small\'>');
                      print('<img src=\'img/'.$img.'\' border=\'0\' width=\''.$dlugosc.'\' height=\'10\' align=\'absmiddle\'>');
                      print('</td><td class=\'small\' bgcolor=\'#EEEEEE\' width=\'80\'>'.$numer.'</td></tr>');
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
