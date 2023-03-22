<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$onlinetimeout = 5; // TIMEOUT ONLINE W MINUTACH

$latestnews_max = 26; // MAXYMALNA DLUGOSC TEMATU W OSTATNICH NEWSACH
$latestarts_max = 28; // MAXYMALNA DLUGOSC TEMATU W OSTATNICH ARTYKU£ACH
$latestfiles_max = 23; // MAXYMALNA DLUGOSC NAZWY PLIKU W OSTATNICH PLIKACH
$latestvisit_max = 23; // MAXYMALNA DLUGOSC NICKA OSTATIO ZALOGOWANYCH
$latestposts_max = 22; // MAXYMALNA DLUGOSC NAZWY TEMATU W OSTATNICH POSTACH
$latestnews_index = 8; // ILOSC WYSWIETLANYCH OSTATNICH NEWSOW
$latestarts_index = 8; // ILOSC WYSWIETLANYCH OSTATNICH ARTYKU£ÓW
$latestwars_index = 8; // ILOSC WYSWIETLANYCH OSTATNICH MECZY
$latestfiles_index = 8; // ILOSC WYSWIETLANYCH OSTATNICH PLIKÓW
$latestvisit_index = 10; // ILOSC WYSWIETLANYCH OSTATNIO WIDZIANYCH
$latestposts_index = 10; // ILOSC WYSWIETLANYCH OSTATNICH POSTOW

// MENU - LAST SEEN

$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id<>'".$user['id']."' ORDER BY user_lastvisit DESC limit 0,".$latestvisit_index."");
if (mysql_num_rows($sql)<1) {
	$latestvisit = '<center>'.$L['qs_none'].'</center>';
}
else {
	while ($result = mysql_fetch_array($sql)) {
		if(strlen($result['user_nick'])>$latestvisit_max){
			$unick = substr($result['user_nick'], 0, $latestfiles_max).'...';
		}
		else {
			$unick = $result['user_nick'];
		}
		if($result['user_member'] == '1'){
			$member = '<img src="includes/images/icons/member.gif"> ';
		}
		else {
			$member = '<img src="templates/'.$defskin.'/images/spacer.gif" width="13" height="13"> ';
		}
		$latestvisit .= $member.'<img src="includes/images/flags/'.$result['user_origin'].'.gif"> <a href="users.php?id='.$result['user_id'].'">'.$unick.'</a><br>';
	}
}

// MENU - LAST POSTS

$hr = '<img border="0" src="templates/'.$defskin.'/images/hr_shout.jpg">';


$sql = mysql_query("SELECT * FROM ".$qs_db['topics']." ORDER BY topic_lpdate DESC LIMIT 0,100");
$i = 0;
$latestpostsrss = '';
while($result = mysql_fetch_array($sql)) {
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$result['topic_subcatid']."'");
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query("SELECT * FROM ".$qs_db['fcats']." WHERE cat_id='".$result2['sub_catid']."'");
	$resul3 = mysql_fetch_array($sql3);
	if($resul3['cat_minlevel'] <= $user['level']){
		if($result2['sub_minlevel'] <= $user['level']){
			if($i <= $latestposts_index){
				$i++;
				$sql4 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result['topic_id']."'");
				$ico = '<img src="templates/'.$defskin.'/icons/arrow_ar.gif">';
				$topicaid = 'a'.$result['topic_id'];
				if(($result['topic_status'] == 0 || $result['topic_status'] == 2 || $result['topic_status'] == 4) && $_SESSION[''.$topicaid.''] < $result['topic_lpdate'] && $user['lastf'] < $result['topic_lpdate']){
					$ico = '<img src="templates/'.$defskin.'/icons/arrow_ur.gif">';
				}
				$topic_title = (strlen($result['topic_title']) > $latestposts_max) ? substr($result['topic_title'], 0, $latestposts_max).'...' : $result['topic_title'];
				$latestpostsrss .= '<b><a href="forum.php?t='.$result['topic_id'].'&p=last">'.$ico.' '.$topic_title.'</a></b> ('.mysql_num_rows($sql4).') <br>';
			}
		}
	}
}
$data = qs_userdata($user['id']);
if($data['user_member'] != '1'){
	
	$latestpostsr = '<tr>
							<td>
							<img border="0" src="templates/'.$defskin.'/images/menu_forum_left.jpg" width="219" height="35"></td>
						</tr>
						<tr>
							<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td width="18">&nbsp;</td>
									<td width="195"><br>';
	
	$latestpostsr .= $latestpostsrss;
	
	if ($i == 0) {
		$latestpostsr .= '<center><b>'.$L['qs_none'].'</b>';
	}
	
	$latestpostsr .= '<center><br>'.$hr.'</center></td>
									<td width="6">&nbsp;</td>
								</tr>
							</table>
							</td>
						</tr>';
}
else{
	
	$latestpostsl = '<tr>
							<td>
							<img border="0" src="templates/'.$defskin.'/images/menu_forum_right.jpg" width="216" height="35"></td>
						</tr>
						<tr>
							<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td width="5">&nbsp;</td>
									<td width="193"><br>';
	
	$latestpostsl .= $latestpostsrss;
	
	if ($i == 0) {
		$latestpostsl .= '<center><b>'.$L['qs_none'].'</b><br>'.$hr.'</center>';
	}
	
	$latestpostsl .= '<center><br>'.$hr.'</center></td>
									<td width="18">&nbsp;</td>
								</tr>
							</table>
							</td>
						</tr>';
	
}

// LATEST FILES

$sql = mysql_query("SELECT * FROM ".$qs_db['files']." WHERE file_minlevel<='".$user['level']."' ORDER BY file_down DESC limit 0,".$latestfiles_index."");
if (mysql_num_rows($sql)<1) {
	$latestfiles = '<center>'.$L['qs_none'].'</center>';
}
else {
	$hrlw = '<center><img src="templates/vd_blue/images/spacer.gif" height="1"><br><img src="templates/vd_blue/images/hr_lastnews.jpg" height="3" width="152"></center>';
	$latestfiles = '';
	while ($result = mysql_fetch_array($sql)) {
		if(strlen($result['file_title'])>$latestfiles_max){
			$title = substr($result['file_title'], 0, $latestfiles_max).'...';
		}
		else {
			$title = $result['file_title'];
		}
		$latestfiles .= '<table width="100%"><tr><td width="1"><img src="includes/images/icons/'.$result['file_cat'].'.gif"></td><td>&nbsp;<a href="files.php?id='.$result['file_id'].'">'.$title.'</a></td><td align="right">('.$result['file_down'].')</td></tr></table>'.$hrlw.'';
	}
}

// LATEST WARS

$sql = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE war_ur<>'0' OR war_or<>'0' ORDER BY war_date DESC limit 0,".$latestwars_index."");
if (mysql_num_rows($sql)<1) {
	$latestwars = '<center>'.$L['qs_none'].'</center>';
}
else {
	$hrlw = '<center><img src="templates/vd_blue/images/hr_lastnews.jpg" width="267" height="3"></center>';
	$latestwars = '';
	while ($result = mysql_fetch_array($sql)) {
		$date = qs_userdate($result['war_date'],$user['timezone']);
		$date = $date['d'].'.'.$date['m'];
		$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='5' AND cat_st='".$result['war_div']."'");
		$cat = mysql_fetch_array($csql);
		if($result['war_ur']>$result['war_or']){
			$score = '<font color="green">'.$result['war_ur'].':'.$result['war_or'].'</font></td><td width="13" align="center"><img src="includes/images/icons/won.jpg">';
		}
		elseif($result['war_ur']<$result['war_or']){
			$score = '<font color="red">'.$result['war_ur'].':'.$result['war_or'].'</font></td><td width="13" align="center"><img src="includes/images/icons/lost.jpg">';
		}
		else{
			$score = '<font color="blue">'.$result['war_ur'].':'.$result['war_or'].'</font></td><td width="13" align="center"><img src="includes/images/icons/draw.jpg">';
		}
		$latestwars .= qs_bbcode('<table width="100%"><tr><td width="40" align="center"><font class="text2">'.$date.'</font></td><td width="160"><a href="wars.php?id='.$result['war_id'].'"> <img src="includes/images/games/'.$cat['cat_ico'].'">  [f]'.$result['war_ocountry'].'[/f]  '.$result['war_opp'].'</a></td><td width="40" align="center">'.$score.'<br></td></tr></table><center>'.$hrlw.'</center>');
	}
}

// LATEST ARTICLES

$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_status='1' AND article_page='1' ORDER BY article_date DESC limit 0,".$latestarts_index."");
if (mysql_num_rows($sql)<1) {
	$latestarts = '<center>'.$L['qs_none'].'</center>';
}
else {
	$hrlw = '<center><img src="templates/vd_blue/images/spacer.gif" height="1"><br><img src="templates/vd_blue/images/hr_lastnews.jpg" height="3" width="220"></center>';
	$latestarts = '';
	$i = 0;
	while ($result = mysql_fetch_array($sql)) {
		$i++;
		$sql2 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='2' AND comment_pageid=".$result['article_id']."");
		$count2 = mysql_num_rows($sql2);
		$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='2' AND cat_st='".$result['article_cat']."'");
		$cat = mysql_fetch_array($csql);
		if(strlen($result['article_title'])>$latestarts_max){
			$title = substr($result['article_title'], 0, $latestarts_max).'...';
		}
		else {
			$title = $result['article_title'];
		}
		$latestarts .= '<table width="100%"><tr><td width="1"><img src="includes/images/icons/'.$cat['cat_ico'].'"></td><td>&nbsp;<a href="articles.php?id='.$result['article_id'].'">'.$title.'</a></td><td align="right">('.$count2.')</td></tr></table>'.$hrlw.'';
	}
	if($if<$latestarts_index){
		for($a=$i; $a<8; $a++){
			$latestarts .= '<table width="100%"><tr><td width="1"><img src="includes/images/icons/vd.gif"></td><td>&nbsp;'.$L['qs_none'].'</td><td align="right">(0)</td></tr></table>'.$hrlw.'';
		}
	}
}

// LATEST NEWS

$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_status='1' AND news_minlevel<='".$user['level']."' ORDER BY news_date DESC limit 0,".$latestnews_index."");
if (mysql_num_rows($sql)<1) {
	$latestnews = '<center>'.$L['qs_none'].'</center>';
}
else {
	$hrlw = '<center><img src="templates/vd_blue/images/spacer.gif" height="1"><br><img src="templates/vd_blue/images/hr_lastnews.jpg" height="3"></center>';
	$latestnews = '';
	$i = 0;
	while ($result = mysql_fetch_array($sql)) {
		$i++;
		$sql2 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='1' AND comment_pageid=".$result['news_id']."");
		$count2 = mysql_num_rows($sql2);
		$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='1' AND cat_st='".$result['news_cat']."'");
		$cat = mysql_fetch_array($csql);
		if(strlen($result['news_title'])>$latestnews_max){
			$title = substr($result['news_title'], 0, $latestnews_max).'...';
		}
		else {
			$title = $result['news_title'];
		}
		$latestnews .= '<table width="100%"><tr><td width="1"><img src="includes/images/icons/'.$cat['cat_ico'].'"></td><td>&nbsp;<a href="index.php?id='.$result['news_id'].'">'.$title.'</a></td><td align="right">('.$count2.')</td></tr></table>'.$hrlw.'';
	}
	if($if<$latestnews_index){
		for($a=$i; $a<8; $a++){
			$latestnews .= '<table width="100%"><tr><td width="1"><img src="includes/images/icons/vd.gif"></td><td>&nbsp;'.$L['qs_none'].'</td><td align="right">(0)</td></tr></table>'.$hrlw.'';
		}
	}
}

// ONLINE

$registeredtext = $L['qs_registered'];
$onlinetext = $L['qs_online'];
$memberstext = $L['qs_users'];
$gueststext = $L['qs_guests'];

$sql = mysql_query("SELECT DISTINCT * FROM ".$qs_db['online']." WHERE online_userid<>'0' ORDER BY online_id");
$monline = 0;
while ($result = mysql_fetch_array($sql)) {
	$time = time();
	$last = $time-$result['online_lastvisit'];
	if($last<($onlinetimeout*60)){
		$monline++;
	}
}
$sql = mysql_query("SELECT DISTINCT * FROM ".$qs_db['online']." WHERE online_ip<>'' ORDER BY online_id");
$gonline = 0;
while ($result = mysql_fetch_array($sql)) {
	$last = time()-$result['online_lastvisit'];
	if($last<($onlinetimeout*60)){
		$gonline++;
	}
}
$sql = mysql_query("SELECT * FROM ".$qs_db['users']." ORDER BY user_id");
$registered = mysql_num_rows($sql);

// INDEX LOGIN

if($user['level']>0){
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$user['id']."'");
	$result = mysql_fetch_array($sql);
	if(file_exists($result['user_avatar'])){
		$avatar = '<img src="'.$result['user_avatar'].'" width="60" height="60">';
	}
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_touser='".$user['id']."' AND pm_status='0'");
	$pm_count = mysql_num_rows($sql2);
	if($pm_count>0){
		$pms = '<b>'.$L['qs_privatemessages'].'</b> (<b>'.$pm_count.'</b>)';
	}
	else {
		$pms = $L['qs_privatemessages'].' (0)';
	}
	$arrow = '<img src="templates/'.$defskin.'/icons/arrow1.gif">';
	$global_login = '<center>'.$L['qs_welcome'].' <b><a href="users.php?id='.$user['id'].'">'.$user['nick'].'</a></b></center><hr><br><div align="center"><table width="90%"><tr><td valign="top" width="1">'.$avatar.'</td><td valign="top">';
	$global_login .= $arrow.' <a href="profile.php">'.$L['qs_profile'].'</a><br>';
	$global_login .= $arrow.' <a href="pm.php">'.$pms.'</a><br>';
	if($user['level']>4){
		$global_login .= $arrow.' <a href="admin.php">'.$T['administration'].'</a><br>';
	}
	$global_login .= '<br>'.$arrow.' <a href="auth.php?a=logout">'.$L['qs_logout'].'</a><br>';
	$global_login .= '</td><tr></table></div><br>';
}
else{
	$global_login = '<form method="post" action="auth.php?a=login" name="login" class="form">
		<div align="center">
		<table width="80%">
		<tr><td>'.$L['qs_nick'].'<br><input type="text" name="nick" class="input"></td></tr>
		<tr><td>'.$L['qs_pass'].'<br><input type="password" name="pass" class="input"></td></tr>
		<tr><td><table class="table"><tr><td>'.$L['qs_remember'].'</td><td align="right"><input type="checkbox" class="checkbox" name="rem" value="REM" checked></td></tr></table></td></tr>
		<tr><td><input type="submit" class="submit" name="send" value="'.$L['qs_login'].'"></td></tr>
		</table>
		<a href="auth.php?s=reg">'.$L['qs_registration'].'</a><br>
		<a href="auth.php?s=lp">'.$L['qs_lostpass'].'</a><br>
		</div>
		</form>';
}

$scrolltext = "
		<script language=\"JavaScript1.2\">
		/*
        Fading Scroller- By DynamicDrive.com
        For full source code, and usage terms, visit http://www.dynamicdrive.com
        This notice MUST stay intact for use
        */

        var delay=3000 //set delay between message change (in miliseconds)
        var fcontent=new Array()
        begintag='<div id=\"datebar\"><font class=\"body\">' //set opening tag, such as font declarations
                            fcontent[0]=\"".$onlinetext." ".$memberstext.": <b>".$monline."</b>, ".$gueststext.": <b>".$gonline."</b>\"
                            fcontent[1]=\"".$registeredtext.": <b>".$registered."</b>\"
                            closetag='</font></div>'

        

        var fwidth='478px' //set scroller width
        var fheight='14px' //set scroller height

        var fadescheme=1 //set 0 to fade text color from (white to black), 1 for (black to white)
        var fadelinks=1  //should links inside scroller content also fade like text? 0 for no, 1 for yes.

        ///No need to edit below this line/////////////////

        var hex=(fadescheme==0)? 240 : 0
        var startcolor=(fadescheme==0)? \"rgb(240,240,240)\" : \"rgb(0,0,0)\"
        var endcolor=(fadescheme==0)? \"rgb(0,0,0)\" : \"rgb(240,240,240)\"

        var ie4=document.all&&!document.getElementById
        var ns4=document.layers
        var DOM2=document.getElementById
        var faderdelay=0
        var index=0

        if (DOM2)
            faderdelay=2000

        //function to change content
        function changecontent(){
            if (index>=fcontent.length)
                index=0
            if (DOM2){
                document.getElementById(\"fscroller\").style.color=startcolor
                document.getElementById(\"fscroller\").innerHTML=begintag+fcontent[index]+closetag
                linksobj=document.getElementById(\"fscroller\").getElementsByTagName(\"A\")
                if (fadelinks)
                    linkcolorchange(linksobj)
                colorfade()
            }
            else if (ie4)
                document.all.fscroller.innerHTML=begintag+fcontent[index]+closetag
            else if (ns4){
                document.fscrollerns.document.fscrollerns_sub.document.write(begintag+fcontent[index]+closetag)
                document.fscrollerns.document.fscrollerns_sub.document.close()
            }

            index++
            setTimeout(\"changecontent()\",delay+faderdelay)
        }

        // colorfade() partially by Marcio Galli for Netscape Communications.  ////////////
        // Modified by Dynamicdrive.com

        frame=20;

        function linkcolorchange(obj){
            if (obj.length>0){
                for (i=0;i<obj.length;i++)
                obj[i].style.color=\"rgb(\"+hex+\",\"+hex+\",\"+hex+\")\"
            }
        }

        function colorfade() {	         	
            // 20 frames fading process
            if(frame>0) {	
                hex=(fadescheme==0)? hex-12 : hex+12 // increase or decrease color value depd on fadescheme
                document.getElementById(\"fscroller\").style.color=\"rgb(\"+hex+\",\"+hex+\",\"+hex+\")\"; // Set color value.
                if (fadelinks)
                linkcolorchange(linksobj)
                frame--;
                setTimeout(\"colorfade()\",5);	
            }
            else{
                document.getElementById(\"fscroller\").style.color=endcolor;
                frame=20;
                hex=(fadescheme==0)? 255 : 0
            }   
        }

        if (ie4||DOM2)
            document.write('<div id=\"fscroller\" style=\"width:'+fwidth+';height:'+fheight+';padding:2px\"></div>')

        window.onload=changecontent
        </script>";

?>