<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

function qs_catname($cat_id, $cat_subid){
	global $qs_db;
	$sql = mysql_query("SELECT * FROM ".$qs_db['cat']." WHERE cat_id='".$cat_id."' AND cat_subid='".$cat_subid."'");
	$result = mysql_fetch_array($sql);
	return $result['cat_title'];
}

function qs_userlevel($userid){
	global $qs_db;
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userid."'");
	if(mysql_num_rows($sql)<1){
		return '';
	}
	$result = mysql_fetch_array($sql);
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_level='".$result['user_level']."'");
	$result2 = mysql_fetch_array($sql2);
	return $result2['level_name'];
}

function qs_userdata($userid){
	global $qs_db;
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userid."'");
	if(mysql_num_rows($sql)<1){
		return FALSE;
	}
	return mysql_fetch_array($sql);
}

function qs_catdata($cat_st){
	global $qs_db;
	$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_st='".$cat_st."'");
	if(mysql_num_rows($sql)<1){
		return FALSE;
	}
	return mysql_fetch_array($sql);
}

function qs_tplfile($loc){
	global $defskin;
	return 'templates/'.$defskin.'/'.$loc.'.tpl';
}

function qs_tplafile($loc){
	global $defskin;
	return 'templates/'.$defskin.'/admin/'.$loc.'.tpl';
}

function qs_userdate($date, $timezone){
	if(strpos($date, ' ') == 10){
		$date = explode(' ', $date);
		$date1 = explode('-', $date[0]);
		$date2 = explode(':', $date[1]);
	}
	else {
		if(strpos($date, ':') == 2){
			$date2 = explode(':', $date);
		}
		else {
			$date1 = explode('-', $date);
		}
		
	}
	$year = $date1[0];
	$month = $date1[1];
	$day = $date1[2];
	$hour = $date2[0];
	$minute = $date2[1];
	$second = $date2[2];
	
	$hour += $timezone;
	if($hour>24){
		$day += 1;
		$hour -= 24;
	}
	if($month == 01 || $month == 03 || $month == 05 || $month == 07 || $month == 08 || $month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10){
			if($day > 31){
				$day = 1;
				$month += 1;
			}
	}
	elseif($month == 04 || $month == 06 || $month == 09 || $month == 4 || $month == 6 || $month == 9 || $month == 11){
			if($day > 30){
				$day = 1;
				$month += 1;
			}
	}
	elseif($month == 12){
		if($day > 31){
			$day = 1;
			$month = 1;
			$year += 1;
		}
	}
	if(is_int($year/4)){
		if($month == 02){
			if($day > 29){
				$day = '01';
				$month += 1;
			}
		}
	}
	else {
		if($month == 02){
			if($day > 28){
				$day = '01';
				$month += 1;
			}
			
		}
	}
	
	$hour = (strlen($hour) < 2) ? '0'.$hour : $hour;
	$day = (strlen($day) < 2) ? '0'.$day : $day;
	$month = (strlen($month) < 2) ? '0'.$month : $month;
	$date = array();
	$date['y'] = $year;
	$date['m'] = $month;
	$date['d'] = $day;
	$date['h'] = $hour;
	$date['i'] = $minute;
	$date['s'] = $second;
	
	return $date;
}

function qs_acscheck($level, $page){
	global $qs_db;
	$sql = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_acs_".$page."='1'");
	while($result = mysql_fetch_array($sql)){
		if($level == $result['level_level']){
			return TRUE;
		}
	}
	return FALSE;
}

function qs_log($value){
	global $qs_db;
	global $user;
	$ip = $_SERVER['REMOTE_ADDR'];
	$date = gmdate("Y-m-d H:i:s");
	mysql_query("INSERT INTO ".$qs_db['log']."(log_ip, log_date, log_nick, log_userid, log_text) VALUES('".$ip."', '".$date."', '".$user['nick']."', '".$user['id']."', '".$value."')");
}

function qs_mail($text, $addmail, $subject){
	$headers  = "MIME-Version: 1.0\r\n";
   	$headers .= "Content-Type: multipart/alternative; boundary=\r\n";
   	$headers .= "Content-type: text/html; charset=iso-8859-2\r\n";
   	$headers .= "Content-Transfer-Encoding: quoted-printable\r\n";
	$mailtop = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
   				<HTML><HEAD>
   				<META http-equiv=3DContent-Type content=3D"text/html; =
   				charset=3Diso-8859-2">
   				<META content=3D"MSHTML 6.00.2900.2180" name=3DGENERATOR>
   				<STYLE></STYLE>
   				</HEAD>
   				<BODY bgColor=3D#ffffff>
   				<DIV><FONT face=3DVerdana size=3D2>';
	$mailbottom = '</FONT></DIV>
   			   	<DIV><STRONG><FONT face=3DVerdana=20
   			   	size=3D2></FONT></STRONG></DIV></BODY></HTML>';
	$text = $mailtop.$text.$mailbottom;
	$mail = mail("$addmail", $subject, $text, $headers);
    if(!$mail){
    	return false;
    }
    else{
    	return true;
    }
}

function qs_redirect($msg, $site=0){
	header("Location: message.php?m=".$msg."&s=".$site."");
	exit;
}

function qs_islegal($text){
	if(strpos($text, "'") !== false) return false;
	return true;
}

function qs_isgoodlength($text, $min, $max){
	if(strlen($text)>=$min){
		if($max == 0){
			return true;
		}
		if(strlen($text)<=$max){
			return true;
		}
	}
	return false;
}

function qs_isemail($email){
	$normal = "^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$";
	$validButRare = "^[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+(\.[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,})$";
	if (eregi($normal, $email)) {
  		return true;
	}
	
	else if (eregi($validButRare, $email)) {
  		return true;
	}

	else {
  		return false;
	}
}

function qs_addslashes($text){
	if (MQGPC)
		{ return($text); }
	else
		{ return(addslashes($text)); }
}

function qs_stripslashes($text){
	$text = htmlspecialchars($text);
	if (MQGPC){ 
		return(stripslashes($text)); 
	}
    else{ 
       	return($text);
    }
}

function qs_viewtext($str){
	$str = nl2br(htmlspecialchars(trim($str)));
	return $str;
}

function qs_bbcbox(){
	global $L;
	$bbcbuttons = '<table><tr><td>
				<table width="100%"><tr>
				<td>
				<input type="button" class="submit" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbadd(0)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbadd(2)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbadd(4)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbadd(6)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbadd(8)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbadd(10)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="p" name="addbbcode12" value="Img" style="width: 40px"  onClick="bbadd(12)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="w" name="addbbcode14" value="URL" style="text-decoration: underline; width: 40px" onClick="bbadd(14)">
				</td></tr></table>
				<table width="100%"><tr>
				<td>
				<input type="button" class="submit" accesskey="b" name="addbbcode16" value=" '.$L['qs_match'].' " style="width: 40px" onClick="bbadd(16)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="b" name="addbbcode18" value=" '.$L['qs_hide'].' " style="width: 40px" onClick="bbadd(18)">
				</td>
				<td>
				&nbsp;'.$L['qs_color'].':<select name="addbbcode18" onChange="bbfontstyle(\'[color=\' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;"">
				<option style="color:#3E3E3E" value="#3E3E3E">'.$L['qs_default'].'</option>
				<option style="color:darkred" value="darkred">'.$L['qs_darkred'].'</option>
				<option style="color:red" value="red">'.$L['qs_red'].'</option>
				<option style="color:orange" value="orange">'.$L['qs_orange'].'</option>
				<option style="color:brown" value="brown">'.$L['qs_brown'].'</option>
				<option style="color:yellow" value="yellow">'.$L['qs_yellow'].'</option>
				<option style="color:green" value="green">'.$L['qs_green'].'</option>
				<option style="color:olive" value="olive">'.$L['qs_olive'].'</option>
				<option style="color:cyan" value="cyan">'.$L['qs_cyan'].'</option>
				<option style="color:blue" value="blue">'.$L['qs_blue'].'</option>
				<option style="color:darkblue" value="darkblue">'.$L['qs_darkblue'].'</option>
				<option style="color:indigo" value="indigo">'.$L['qs_indigo'].'</option>
				<option style="color:violet" value="violet">'.$L['qs_violet'].'</option>
				<option style="color:white" value="white">'.$L['qs_white'].'</option>
				<option style="color:black" value="black">'.$L['qs_black'].'</option>
				</select>
				</td>
				<td>
				&nbsp;'.$L['qs_size'].':<select name="addbbcode20" onChange="bbfontstyle(\'[size=\' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + \']\', \'[/size]\')">
				<option value="7">'.$L['qs_min'].'</option>
				<option value="9">'.$L['qs_small'].'</option>
				<option value="12" selected>'.$L['qs_normal'].'</option>
				<option value="18">'.$L['qs_big'].'</option>
				<option  value="24">'.$L['qs_huge'].'</option>
				</select>
				</td>
				</tr></table>
				</td></tr></table>';
	return $bbcbuttons;
}

function qs_bbcbox2(){
	global $L;
	$bbcbuttons = '
				<table width="100%"><tr>
				<td>
				<input type="button" class="submit" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbadd(0)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbadd(2)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbadd(4)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbadd(6)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbadd(8)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbadd(10)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="p" name="addbbcode12" value="Img" style="width: 40px"  onClick="bbadd(12)">
				</td>
				<td>
				<input type="button" class="submit" accesskey="w" name="addbbcode14" value="URL" style="text-decoration: underline; width: 40px" onClick="bbadd(14)">
				</td></tr></table>';
	return $bbcbuttons;
}

function qs_match($str){
$asd = strstr($str, '[match]');
while(!empty($asd)){
	global $qs_db;
	global $L;
	global $user;
	$match = strstr($str, '[match]');
	$match = substr($match, 0, 19);
	$match = strrev($match);
	if(strstr($match, ']hctam/[')){
	$match = strstr($match, ']hctam/[');
	$match = strrev($match);
	$match = str_replace('[match]', '', $match);
	$match = str_replace('[/match]', '', $match);
	$sql = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE war_id='".$match."'");
	if(mysql_num_rows($sql)>0){
		$result = mysql_fetch_array($sql);
		$sql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='5' AND cat_st='".$result['war_div']."'");
		$result2 = mysql_fetch_array($sql2);
		$sql3 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='4' AND cat_st='".$result['war_lst']."'");
		$result3 = mysql_fetch_array($sql3);
		$date = qs_userdate($result['war_date'], $user['timezone']);
		if($result['war_ur']>$result['war_or']){
			$score = '<font color="green">'.$result['war_ur'].':'.$result['war_or'].'</font>';
		}
		elseif($result['war_ur']<$result['war_or']){
			$score = '<font color="red">'.$result['war_ur'].':'.$result['war_or'].'</font>';
		}
		elseif($result['war_ur'] == '0' && $result['war_or'] == '0'){
			$score = '';
		}
		else{
			$score = '<font color="blue">'.$result['war_ur'].':'.$result['war_or'].'</font>';
		}
		if(!file_exists($result['war_avatar'])){
			$avatar = 'includes/images/teams/none.gif';
		}
		else {
			$avatar = $result['war_avatar'];
		}
		$WAR_TEXT_DATE = $L['qs_date'];
		$WAR_FORM_DATE = $date['d'].'.'.$date['m'].'.'.$date['y'];
		$WAR_TEXT_TIME = $L['qs_tm'];
		$WAR_FORM_TIME = $date['h'].':'.$date['i'];
		$WAR_TEXT_DIV = $L['qs_div'];
		$WAR_FORM_DIV = 'VD.'.$result['war_div'].' <img src="includes/images/flags/pl.gif">';
		$WAR_FORM_ULOGO = '<img src="includes/images/teams/vd.jpg">';
		$WAR_FORM_OPP = '<img src="includes/images/flags/'.$result['war_ocountry'].'.gif"> '.$result['war_opp'];
		$WAR_FORM_OLOGO = '<img src="'.$avatar.'">';
		$WAR_TEXT_MAPS = $L['qs_maps'];
		$WAR_FORM_MAP1 = $result['war_map1'];
		$WAR_FORM_MAP2 = $result['war_map2'];
		$WAR_TEXT_TV = $L['qs_see'];
		$WAR_FORM_TV = $result['war_tv'];
		$WAR_TEXT_SB = $L['qs_sb'];
		$WAR_FORM_SB = $result['war_sb'];
		$WAR_TEXT_L = $L['qs_leev'];
		$WAR_FORM_L = '<img src="includes/images/flags/'.$result['war_lcountry'].'.gif"> <img src="includes/images/icons/'.$result3['cat_ico'].'"> '.$result['war_ltitle'].'';
		$WAR_TEXT_RESULT = $L['qs_result'];
		$WAR_FORM_RESULT = $score;
		$WAR_TEXT_GAME = $L['qs_game'];
		$WAR_FORM_GAME = '<img src="includes/images/games/'.$result2['cat_ico'].'"> '.$result2['cat_title'];
		$WAR_TEXT_SQUAD = $L['qs_squad'];
		$WAR_FORM_USQUAD = qs_bbcode(nl2br($result['war_us']));
		$WAR_FORM_OSQUAD = qs_bbcode(nl2br($result['war_os']));
		$WAR_TEXT_TEXT = $L['qs_des'];
		$WAR_FORM_TEXT = qs_bbcode(nl2br($result['war_text']));
		$done = '<div align="center"><table border="0" width="427" cellspacing="0" cellpadding="0"><tr><td><br><br><table border="0" width="100%" cellspacing="0" cellpadding="0" background="includes/images/teams/match.gif"><tr><td width="120" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td height="44" align="right"><font class="text3"><b>'.$WAR_FORM_DIV.'</b></font></td></tr><tr><td valign="top" height="100" width="120">'.$WAR_FORM_ULOGO.'</td></tr><tr><td valign="top" align="right">'.$WAR_FORM_USQUAD.'</td></tr></table></td><td width="184" align="center" valign="top"><br><font class="text4">'.$WAR_FORM_RESULT.'</font><br><br>'.$WAR_FORM_L.'<br><br>'.$WAR_TEXT_DATE.': '.$WAR_FORM_DATE.'<br>'.$WAR_TEXT_TIME.': '.$WAR_FORM_TIME.'<br><br>'.$WAR_FORM_MAP1.'<br>'.$WAR_FORM_MAP2.'<br><br>'.$WAR_FORM_TV.'<br>'.$WAR_FORM_SB.'<br><br>'.$WAR_TEXT_GAME.': '.$WAR_FORM_GAME.'</td><td width="121" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td height="44"><font class="text3"><b>'.$WAR_FORM_OPP.'</b></font></td></tr><tr><td align="right" height="100" valign="top">'.$WAR_FORM_OLOGO.'</td></tr><tr><td>'.$WAR_FORM_OSQUAD.'</td></tr></table></td></tr></table><table width="100%"><tr><td background="includes/images/teams/match2.gif" valign="bottom"><img src="templates/vd_blue/images/spacer.gif" height="6"</td></tr></table></td></tr></table></div>';
		$str = str_replace('[match]'.$match.'[/match]', $done, $str);
	}
	else {
		$str = str_replace('[match]'.$match.'[/match]', '', $str);
	}
	}
	else {
		$str = str_replace('[match]', '', $str);
	}
	$asd = strstr($str, '[match]');
}
return $str;
}

// bbcode
Function qs_bbcode2($str){
	
global $L;

// Kolorowanie sk³adni
$str=preg_replace_callback("#\[php\](.*?)\[/php\]#si", "bbcode_phpCode", $str);

// Odnoœnik e-mail(w³asne definiowanie wyœwietlanego tekstu)
$str = preg_replace("#\[email=([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)?(.*?)\](.*?)\[/email\]#i", "<a href=\"mailto:\\1@\\2\">\\5</a>", $str);

// Odnoœnik, otwieranie w nowym oknie
$str = preg_replace("#\[url\](.*?)?(.*?)\[/url\]#si", "<A HREF=\"\\1\\2\" TARGET=\"_blank\">\\1\\2</A>", $str);

// Odnoœnik, otwieranie w nowym oknie, definiowanie treœci odnoœnika
$str = preg_replace("#\[url=(.*?)?(.*?)\](.*?)\[/url\]#si", "<A HREF=\"\\2\" TARGET=\"_blank\">\\3</A>", $str);

// Odnoœnik, otwieranie w tym samym oknie
$str = preg_replace("#\[url2\](.*?)?(.*?)\[/url2\]#si", "<A HREF=\"\\1\\2\">\\1\\2</A>", $str);

// Odnoœnik, otwieranie w tym samym oknie, definiowanie treœci odnoœnika
$str = preg_replace("#\[url2=(.*?)?(.*?)\](.*?)\[/url2\]#si", "<A HREF=\"\\2\">\\3</A>", $str);

// Automatyczne tworzenie linków
$str = preg_replace_callback("#([\n ])([a-z]+?)://([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]+)#si", "bbcode_autolink", $str);
$str = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]*)?)#i", " <a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $str);
$str = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)#i", "\\1<a href=\"javascript:mailto:mail('\\2','\\3');\">\\2@\\3</a>", $str);

// Pogrubiony tekst
$str = preg_replace("#\[b\](.*?)\[/b\]#si", "<b>\\1</b>", $str);

// Pochylony tekst
$str = preg_replace("#\[i\](.*?)\[/i\]#si", "<i>\\1</i>", $str);

// Podkreœlony tekst
$str = preg_replace("#\[u\](.*?)\[/u\]#si", "<u>\\1</u>", $str);

// Pomniejszanie tekstu
$str = preg_replace("#\[sm\](.*?)\[/sm\]#si", "<small>\\1</small>", $str);

// Powiêkszanie tekstu
$str = preg_replace("#\[big\](.*?)\[/big\]#si", "<big>\\1</big>", $str);

// Akapit
$str = preg_replace("/\[p\](.*?)\[\/p\]/si", "<p>\\1</p>", $str);

// Akapit z wyrównaniem
$str = preg_replace("#\[p=(http://)?(.*?)\](.*?)\[/p\]#si", "<p align=\"\\2\">\\3</p>", $str);

// Wyœrodkowanie tekstu
$str = preg_replace("/\[center\](.*?)\[\/center\]/si", "<center>\\1</center>", $str);

// Kolor tekstu
$str = preg_replace("#\[color=(http://)?(.*?)\](.*?)\[/color\]#si", "<span style=\"color:\\2\">\\3</span>", $str);

// Wielkoœæ czcionki
$str = preg_replace("#\[size=(http://)?(.*?)\](.*?)\[/size\]#si", "<span style=\"font-size:\\2\">\\3</span>", $str);

// Obrazek
$str = preg_replace("#\[img\](.*?)\[/img\]#si", "<img src=\"\\1\" border=\"0\" alt=\"Obrazek\" />", $str);

// Obrazek z katalogu img
$str = preg_replace("#\[ftp_img\](.*?)\[/ftp_img\]#si", "<img src=\"img/\\1\" border=\"0\" alt=\"Obrazek\" />", $str);

// Pozioma linia
$str = preg_replace("#\[hr=(\d{1,2}|100)\]#si", "<hr class=\"linia\" width=\"\\1%\">", $str);

// Spacja
$str=str_replace('[spacja]','&nbsp;',$str);

// znaki specjalne
$str = str_replace('&amp;plusmn;', '&plusmn;', $str);
$str = str_replace('&amp;trade;', '&trade;', $str);
$str = str_replace('&amp;bull;', '&bull;', $str);
$str = str_replace('&amp;deg;', '&deg;', $str);
$str = str_replace('&amp;copy;', '&copy;', $str);
$str = str_replace('&amp;reg;', '&reg;', $str);
$str = str_replace('&amp;hellip;', '&hellip;', $str);

// b³êdne kodowanie m.in. z phpmyadmina
$str = str_replace('&amp;#261;', '¹', $str);
$str = str_replace('&amp;#263;', 'æ', $str);
$str = str_replace('&amp;#281;', 'ê', $str);
$str = str_replace('&amp;#322;', '³', $str);
$str = str_replace('&amp;#347;', 'œ', $str);
$str = str_replace('&amp;#378;', '¼', $str);
$str = str_replace('&amp;#380;', '¿', $str);
$str = str_replace('&amp;#378;', 'Ÿ', $str);

// znaki specjalne z m$ word
$str = str_replace('&amp;#177;', '¹', $str);
$str = str_replace('&amp;#8217;', '\'', $str);
$str = str_replace('&amp;#8222;', '"', $str);
$str = str_replace('&amp;#8221;', '"', $str);
$str = str_replace('&amp;#8220;', '"', $str);
$str = str_replace('&amp;#8211;', '-', $str);
$str = str_replace('&amp;#8230;', '&hellip;', $str);

// Kod
$str = preg_replace("#\[code\](.*?)\[/code]#si", "<table width=\"90%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr> <td><span><b>".$L['qs_code'].":</b></span></td></tr><tr><td class=\"code\">\\1</td></tr></table>", $str);

// Cytat
$str = preg_replace("#\[quote\](.*?)\[/quote]#si", "<table width=\"90%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr> <td><span><b>".$L['qs_quotation'].":</b></span></td></tr><tr><td class=\"quote\">\\1</td></tr></table>", $str);

// Cytat, podany autor
$str = preg_replace("#\[quote=(http://)?(.*?)\](.*?)\[/quote]#si", "<table width=\"90%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr> <td><span><b>\\2 ".$L['qs_wroteby2'].":</b></span></td></tr><tr><td class=\"quote\">\\3</td></tr></table>", $str);

// Lista

$str = preg_replace("#\[list\](.*?)\[/list\]#si", "<ul>\\1</ul>", $str);
$str = preg_replace("#\[list=(http://)?(.*?)\](.*?)\[/list\]#si", "<ol type=\"\\2\">\\3</ol>", $str);
$str = preg_replace("#\[\*\](.*?)\\s#si", "<li>\\1</li>", $str);

// Odnoœnik e-mail
$str = preg_replace("#\[email\]([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#i", "<a href=\"mailto:\\1@\\2\">\\1@\\2</a>", $str);

// Ikonki gier
$str = preg_replace("#\[g\](.*?)\[/g\]#si", "<img src=\"includes/images/games/\\1.gif\">", $str);

// Flagi
$str = preg_replace("#\[f\](.*?)\[/f\]#si", "<img src=\"includes/images/flags/\\1.gif\">", $str);

// wynik
return $str;}


// bbcode
Function qs_bbcode($str){

// Kolorowanie sk³adni
$str=preg_replace_callback("#\[php\](.*?)\[/php\]#si", "bbcode_phpCode", $str);

// Odnoœnik e-mail(w³asne definiowanie wyœwietlanego tekstu)
$str = preg_replace("#\[email=([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)?(.*?)\](.*?)\[/email\]#i", "<a href=\"mailto:\\1@\\2\">\\5</a>", $str);

// Odnoœnik, otwieranie w nowym oknie
$str = preg_replace("#\[url\](.*?)?(.*?)\[/url\]#si", "<A HREF=\"\\1\\2\" TARGET=\"_blank\">\\1\\2</A>", $str);

// Odnoœnik, otwieranie w nowym oknie, definiowanie treœci odnoœnika
$str = preg_replace("#\[url=(.*?)?(.*?)\](.*?)\[/url\]#si", "<A HREF=\"\\2\" TARGET=\"_blank\">\\3</A>", $str);

// Odnoœnik, otwieranie w tym samym oknie
$str = preg_replace("#\[url2\](.*?)?(.*?)\[/url2\]#si", "<A HREF=\"\\1\\2\">\\1\\2</A>", $str);

// Odnoœnik, otwieranie w tym samym oknie, definiowanie treœci odnoœnika
$str = preg_replace("#\[url2=(.*?)?(.*?)\](.*?)\[/url2\]#si", "<A HREF=\"\\2\">\\3</A>", $str);

// Automatyczne tworzenie linków
$str = preg_replace_callback("#([\n ])([a-z]+?)://([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]+)#si", "bbcode_autolink", $str);
$str = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]*)?)#i", " <a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $str);
$str = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)#i", "\\1<a href=\"javascript:mailto:mail('\\2','\\3');\">\\2@\\3</a>", $str);

// Ukrywanie treœci
$str = preg_replace_callback("#\[roll=\"?(.*?)\"?\](.*?)\[/roll]#si", 'ukryj', $str);

// Pogrubiony tekst
$str = preg_replace("#\[b\](.*?)\[/b\]#si", "<b>\\1</b>", $str);

// Pochylony tekst
$str = preg_replace("#\[i\](.*?)\[/i\]#si", "<i>\\1</i>", $str);

// Podkreœlony tekst
$str = preg_replace("#\[u\](.*?)\[/u\]#si", "<u>\\1</u>", $str);

// Pomniejszanie tekstu
$str = preg_replace("#\[sm\](.*?)\[/sm\]#si", "<small>\\1</small>", $str);

// Powiêkszanie tekstu
$str = preg_replace("#\[big\](.*?)\[/big\]#si", "<big>\\1</big>", $str);

// Akapit
$str = preg_replace("/\[p\](.*?)\[\/p\]/si", "<p>\\1</p>", $str);

// Akapit z wyrównaniem
$str = preg_replace("#\[p=(http://)?(.*?)\](.*?)\[/p\]#si", "<p align=\"\\2\">\\3</p>", $str);

// Wyœrodkowanie tekstu
$str = preg_replace("/\[center\](.*?)\[\/center\]/si", "<center>\\1</center>", $str);

// Kolor tekstu
$str = preg_replace("#\[color=(http://)?(.*?)\](.*?)\[/color\]#si", "<span style=\"color:\\2\">\\3</span>", $str);

// Wielkoœæ czcionki
$str = preg_replace("#\[size=(http://)?(.*?)\](.*?)\[/size\]#si", "<span style=\"font-size:\\2\">\\3</span>", $str);

// Obrazek
$str = preg_replace("#\[img\](.*?)\[/img\]#si", "<img src=\"\\1\" border=\"0\" alt=\"Obrazek\" />", $str);

// Obrazek z katalogu img
$str = preg_replace("#\[ftp_img\](.*?)\[/ftp_img\]#si", "<img src=\"img/\\1\" border=\"0\" alt=\"Obrazek\" />", $str);

// Pozioma linia
$str = preg_replace("#\[hr=(\d{1,2}|100)\]#si", "<hr class=\"linia\" width=\"\\1%\">", $str);

// Spacja
$str=str_replace('[spacja]','&nbsp;',$str);

// znaki specjalne
$str = str_replace('&amp;plusmn;', '&plusmn;', $str);
$str = str_replace('&amp;trade;', '&trade;', $str);
$str = str_replace('&amp;bull;', '&bull;', $str);
$str = str_replace('&amp;deg;', '&deg;', $str);
$str = str_replace('&amp;copy;', '&copy;', $str);
$str = str_replace('&amp;reg;', '&reg;', $str);
$str = str_replace('&amp;hellip;', '&hellip;', $str);

// b³êdne kodowanie m.in. z phpmyadmina
$str = str_replace('&amp;#261;', '¹', $str);
$str = str_replace('&amp;#263;', 'æ', $str);
$str = str_replace('&amp;#281;', 'ê', $str);
$str = str_replace('&amp;#322;', '³', $str);
$str = str_replace('&amp;#347;', 'œ', $str);
$str = str_replace('&amp;#378;', '¼', $str);
$str = str_replace('&amp;#380;', '¿', $str);

// znaki specjalne z m$ word
$str = str_replace('&amp;#177;', '¹', $str);
$str = str_replace('&amp;#8217;', '\'', $str);
$str = str_replace('&amp;#8222;', '"', $str);
$str = str_replace('&amp;#8221;', '"', $str);
$str = str_replace('&amp;#8220;', '"', $str);
$str = str_replace('&amp;#8211;', '-', $str);
$str = str_replace('&amp;#8230;', '&hellip;', $str);

// Kod
$str = preg_replace("#\[code\](.*?)\[/code]#si", "<pre class=\"code\"><u><b>".$L['qs_code'].":</b></u><br/>\\1</pre>", $str);

// Kod, podany autor
$str = preg_replace("#\[code=(http://)?(.*?)\](.*?)\[/code]#si", "<pre class=\"code\"><u><b>".$L['qs_code']." \\2:</b></u><br/>\\3</pre>", $str);

// Cytat
$str = preg_replace("#\[quote\](.*?)\[/quote]#si", "<p class=\"quote\"><u><b>".$L['qs_quotation'].":</b></u><br/>\\1</p>", $str);

// Cytat, podany autor
$str = preg_replace("#\[quote=(http://)?(.*?)\](.*?)\[/quote]#si", "<p class=\"quote\"><u><b>".$L['qs_quotation']." \\2:</b></u><br/>\\3</p>", $str);

// Lista

$str = preg_replace("#\[list\](.*?)\[/list\]#si", "<ul>\\1</ul>", $str);
$str = preg_replace("#\[list=(http://)?(.*?)\](.*?)\[/list\]#si", "<ol type=\"\\2\">\\3</ol>", $str);
$str = preg_replace("#\[\*\](.*?)\\s#si", "<li>\\1</li>", $str);

// Odnoœnik e-mail
$str = preg_replace("#\[email\]([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#i", "<a href=\"mailto:\\1@\\2\">\\1@\\2</a>", $str);

// Ikonki
$str = preg_replace("#\[c\](.*?)\[/c\]#si", "<img src=\"includes/images/icons/\\1.gif\">", $str);

// Ikonki gier
$str = preg_replace("#\[g\](.*?)\[/g\]#si", "<img src=\"includes/images/games/\\1.gif\">", $str);

// Flagi
$str = preg_replace("#\[f\](.*?)\[/f\]#si", "<img src=\"includes/images/flags/\\1.gif\">", $str);

// Miejsce
$str = preg_replace("#\[pl\](.*?)\[/pl\]#si", "<img src=\"includes/images/place/\\1.gif\">", $str);

// kodowanie kodu
$str = preg_replace_callback("#\<base64\>(.*?)\</base64\>#si", "base64decode", $str);

// js
$str = preg_replace_callback("#\<(.*?)javascript(.*?)\>#si", "bbcode_js", $str);

// wynik
return $str;}


function bbcode_phpCode($code){
if(!$code){return;}
$code[1]=trim($code[1]);
$code[1]=html_entity_decode($code[1]);
$code[1]=str_replace('<br />','',$code[1]);
$kod=highlight_string($code[1], TRUE);
$numerki=explode('|',bbcode_numeruj($kod));
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
$sys[0]='<code><span style="color: #000000">'."\n";
$sys[1]=chr(10).'</code>';
}else{
$sys[0]="<font color=\"#000000\">\n";
$sys[1]="\n</code>";
}
$kod=str_replace(array($sys[0],$sys[1]),array('<code><font color="#000000">','</code>'),$kod);
$ret='<div class="php"><div class="lang"><b>Kod PHP ('.$numerki[0].' lini):</b></div><div class="container"><table class="block"><tr><td class="linenumber" style="font-size: 12px;">'.$numerki[1].'</td><td width="100%" style="font-size: 12px;"><pre class="pcode"><span class="html"><div style="line-height: 15px">'.$kod.'</div></span></pre></td></tr></table></div></div>';
return '<base64>'.base64_encode($ret).'</base64>';}

// zakodowanie kodu
Function base64decode($str){
return base64_decode(substr($str[0],8,strlen($str[0])-8));
}

// numeracja
Function bbcode_numeruj($str){
$linia=explode('<br />', $str);
$l=count($linia);
for($i=1;$i<=$l;$i++){
$ret.=$i.'<br>';
}
return $l.'|'.$ret;}
function bbcode_autolink($str){
$lnk=$str[3];
if(strlen($lnk)>30){
if(substr($lnk,0,3)=='www'){$l=9;}else{$l=5;}
$lnk=substr($lnk,0,$l).'(...)'.substr($lnk,strlen($lnk)-8);}
return ' <a href="'.$str[2].'://'.$str[3].'" target="_blank">'.$str[2].'://'.$lnk.'</a>';}
function ukryj ( $match ) {
$id = uniqid(''); 
return '<a href="#" onclick="flip(\'' . $id . '\'); return false;"><img src="templates/vd_blue/icons/arrow1.gif"> <b>' . $match[1] . '</b></a><div id="' . $id . '" class="ukryj" style="display: none;">' . $match[2] . '</div>';
}

// anti js
Function bbcode_js($str){
if(!eregi('<a href=\"javascript:mailto:mail\(\'',$str[0])){
return str_replace('javascript','java_script',$str[0]);
}else{return $str[0];}}

function qs_html($str){
	$str = htmlentities($str);
	return $str;
}

function qs_smiles($str){
	global $qs_db;
	$sql = mysql_query("SELECT * FROM ".$qs_db['smiles']." ORDER BY smile_id");
	while ($result = mysql_fetch_array($sql)) {
		$str = str_replace(qs_stripslashes($result['smile_code']), '<img src="'.$result['smile_image'].'" alt="'.$result['smile_text'].'">', $str);
	}
	return $str;
}

function qs_smilescript($form, $input){
	return '<head><script type="text/javascript">
<!--
window.name=\'main\';

	function addtext'.$form.'(text)
	{
	document.'.$form.'.'.$input.'.value += text;
	document.'.$form.'.'.$input.'.focus();
	}

//-->
</script></head>';
}

function qs_smilesbox($form, $input){
	global $qs_db;
	$sql = mysql_query("SELECT * FROM ".$qs_db['smiles']." ORDER BY smile_id DESC");
	while ($result = mysql_fetch_array($sql)) {
		$smiles .= '<a href="javascript:addtext'.$form.'(\''.$result['smile_code'].'\')"><img src="'.$result['smile_image'].'" alt="'.$result['smile_text'].'" border="0"></a> ';
	}
	return $smiles;
}

?>