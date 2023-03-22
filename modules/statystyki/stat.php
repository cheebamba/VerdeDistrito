<?
/*************************************************************
    Statystyka Imperator STATS v-5
    Strona domowa: www.iportal.nano.pl
*************************************************************/
if(empty($PHPSESSID)){
session_start();
}
else{
session_start($PHPSESSID);
}

error_reporting(0);

$istat['base_path']=dirname(__FILE__);

$i_err=@include($istat['base_path'].'/conf.php');
if(!$i_err) { echo '<span style="color:red">Error 001 in file '.__FILE__.'</span>'; exit; }

$i_err=@include($istat['base_path'].'/lang/'.$istat['lang'].'.php');
if(!$i_err) { echo '<span style="color:red">Error 002 in file '.__FILE__.'</span>'; exit; }

$i_err=@include($istat['base_path'].'/lib/statclass.php');
if(!$i_err) { echo '<span style="color:red">Error 003 in file '.__FILE__.'</span>'; exit; }

$cistat = new statclass($istat['base_path']);

$fid=fopen($istat['base_path'].'/img/nistat.gif',"r");
$dane=fread($fid,filesize($istat['base_path'].'/img/nistat.gif'));
fclose($fid);
echo $dane;


// jezeli user wszedl z zabronionego ip, nie zliczaj
if(IstatsExclude($istat['wyklucz'], $cistat->dane['ip']))  return;

$cistat->SetVisits($cistat->log_data['calls']);            // zliczaj odslony o danym czasie
$cistat->CountHits(0);                                     // zwieksz liczbe ods³on ogolnie


if($istat['pages'] == '1')
{
  $cistat->GetPages($_SERVER['HTTP_REFERER']);  // zliczanie odwiedzin podstron
}


// czy user ciagle jest aktywny
if(time()-$_SESSION['lock']<($istat['expired']*60)) return;
$_SESSION['lock']=time();  // zakladamy blokade na usera, zeby dalej zliczac jego tylko odslony


include($istat['base_path'].'/lib/get_browser.php');
include($istat['base_path'].'/lib/get_os.php');
include($istat['base_path'].'/lib/get_search.php');
include('rstat.php');

$cistat->dane['browser'] = istatBrowser($cistat->dane['agent']);              // rozpoznanie przegladarki
$cistat->isave($cistat->log_data['browser'], $cistat->dane['browser']);       // zapis przegladarki

$cistat->dane['os'] = istatOS($cistat->dane['agent']);                        // rozpoznanie systemu operacyjnego
$cistat->isave($cistat->log_data['os'], $cistat->dane['os']);                 // zapis systemu operacyjnego

$cistat->SetVisits($cistat->log_data['hits']);            // zliczaj odwiedziny o danym czasie

$cistat->CountHits(1);                                     // zwieksz liczbe wejsc ogolnie
$cistat->GetDomain();
$cistat->GetCountry();                                                                                                                                                                                                    // zapis kraju
$cistat->LastVisit();
$cistat->isave($cistat->log_data['host'], $cistat->dane['host']);             // zapis hosta

// lista wyszukiwarek
if(!empty($_GET['idref']))
{
    $istat_s = istatSearch($_GET['idref']);
    if(!$istat_s[0]) $cistat->GetReferer($_GET['idref']);
}


if($istat_s[0]) $cistat->isave($cistat->log_data['search'], $istat_s[0]);        // zapis wyszukiwarek
if($istat_s[1]) $cistat->isave($cistat->log_data['keyword'], $istat_s[1]);       // zapis s³ow kluczowych


/***********************************************************************
*   Funkcje
***********************************************************************/


/************************************************************************
*   Wykluczania ip, czyli adres IP,
*   z które beda pomijane przy zlicznia wejsc
*   $wyklucz - lancuch adresow IP do wkluczenia, $ipx - aktualny adres IP
*****/
function IstatsExclude($wyklucz, $ipx)
{
       // utworz tablice z numerów IP do wykluczenia
       $ip = explode(';', $wyklucz);
       $nw = count($ip);                       // ile adresow

       // ip usera, ktory wszedl na strone
       $MyIP = explode('.', $ipx);
       for($n=0; $n<$nw; $n++)
       {
              $flaga = 4;
              $ips = explode('.',$ip[$n]);    // ip do wykluczenia
              if($ips[0] == '*' || $ips[0] == $MyIP[0]) $flaga--;
              if($ips[1] == '*' || $ips[1] == $MyIP[1]) $flaga--;
              if($ips[2] == '*' || $ips[2] == $MyIP[2]) $flaga--;
              if($ips[3] == '*' || $ips[3] == $MyIP[3]) $flaga--;
              if($flaga==0) return true;
       }
       return false;
}


?>

