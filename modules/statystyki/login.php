<?
session_start();
error_reporting(0);

if($_GET['p']=='wyloguj') $_SESSION['auth']=0;

include('conf.php');
include('lang/'.$istat['lang'].'.php');

if(!isset($_GET['p'])) $_GET['p'] = '';
if(!isset($_POST['pass'])) $_POST['pass'] = '';

if(!empty($_POST['ok']))
{
        if(md5($_POST['pass'])==$istat['pass_conf']) $_SESSION['auth']=2;
        else if(md5($_POST['pass'])==$istat['pass_stat']) $_SESSION['auth']=1;
    if($_SESSION['auth']==2) header('location: index.php?p=admin');
    else if($_SESSION['auth']==1) header('location: index.php');
}

logowanie($istat['ver']);



function logowanie($v) {
  global $rmsg;
  ?>
<html>
<head>
      <title>Statystyka WWW - Imperator Stats</title>
      <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-2'>
      <meta name='Author' content='Logic'>
      <meta http-equiv='Reply-to' content='logic@stone.pl'>
      <link href='istats.css' rel='stylesheet' type='text/css'>
</head>
<body bgcolor='#FFFFFF'>
   <table cellpadding='0' cellspacing='0' width='100%' height='90%'>
   <tr>
       <td>
           <table align='center' class='barmiddle' bgcolor='#DFDFDF' cellpadding='0' cellspacing='0'>
           <tr align='center'>
                 <td bgcolor='navy' class='bmiddle'><blockquote style='margin: 2px, 5px, 2px, 5px'>Imperator STATS <? print($v); ?></blockquote></td>
            </tr>
            <tr>
                <td align='center' class='small'>
                           <form action='login.php' method='post' name='form'>
                              <blockquote style='margin: 14px, 14px, 14px, 14px'>
                                   <input type='hidden' name='ok' value='ok'>
                                   <? print($rmsg['login']['enter']); ?><input type='password' name='pass'>
                                   <div align='right'><input type='submit' value='<? print($rmsg['login']['login']); ?>' class='small'></div><br>
                                   <div align='left'><? print($rmsg['author']); ?>&nbsp;&nbsp;<a href='mailto:logic@anubisdev.com' class='asmall'>Adam Sobociński</a>
                                   <br><? print($rmsg['coop']); ?>&nbsp;&nbsp;<a href='mailto:geos@anubisdev.com' class='asmall'>Piotr Galas</a>, <a href='mailto:md5@pf.pl' class='asmall'>Michał Bundyra</a><br><br>
                                   &copy; 2000-2003 <a href='http://anubisdev.com' class='asmall'>anubisdev.com</a></div>
                              </blockquote>
                          </form>
                   </td>
             </tr>
             </table>
        </td>
   </tr>
   </table>
</body>
</html>
<?
}
?>
