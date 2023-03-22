<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'forum';

$id = $_GET['t'];

$sql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_id='".$id."'");
$result = mysql_fetch_array($sql);

$topicaid = 'a'.$result['topic_id'];
if($user['lastf'] < $result['topic_lpdate']){
	$$topicaid = gmdate("Y-m-d H:i:s");
	session_register(''.$topicaid.'');
}

$title = $L['qs_forum'].': '.qs_stripslashes($result['topic_title']);

if(mysql_num_rows($sql)<=0){
	qs_redirect(134);
}

$catsql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$result['topic_subcatid']."'");
$catresult = mysql_fetch_array($catsql);

if($catresult['sub_minlevel']>$user['level']){
	qs_redirect(107);
}

$views = $result['topic_views']+1;
mysql_query("UPDATE ".$qs_db['topics']." SET topic_views='".$views."' WHERE topic_id='".$id."'");

	$pp = 30;

	$psql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$id."'");
	$psqlcount = mysql_num_rows($psql);
	
	$pages = ceil($psqlcount/($pp));
	
	$pages = ($pages == 0) ? 1 : $pages;
	
	$p = (empty($_GET['p'])) ? 1 : $_GET['p'] ;
	
	$p = ($p == 'last') ? $pages : $p;
	
	$tpp = ($p == 1) ? ($pp-1) : $pp;
	$pe = $pp*($p-1);
	$pe = ($pe>0) ? $pe-1 : $pe;

	$p1 = $pe;
	$p2 = $tpp;
	
	if($p>$pages){
		qs_redirect(134);
	}
	
	$pages1 = $L['qs_page'].'&nbsp;&nbsp;'.$p.'&nbsp;&nbsp;'.$L['qs_from2'].'&nbsp;&nbsp;'.$pages;
	
	if($p != 1){
		$posts_pages .= '<b><a href="forum.php?t='.$id.'&p='.($p-1).'">&laquo;</a></b> ';
	}
	for ($i=1; $i<=$pages; $i++){
		if($pages != 1){
			$a = ($i == $p) ? $i : '<b><a href="forum.php?t='.$id.'&p='.$i.'">'.$i.'</a></b>' ;
			if ($i == 1){
				$posts_pages .= $a;
			}
			else {
				$posts_pages .= ' | '.$a;
			}
		}
	}
	if($p != $pages){
		$posts_pages .= ' <b><a href="forum.php?t='.$id.'&p='.($p+1).'">&raquo;</a></b>';
	}

$menuleft = 'OFF';
require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('forum.topic'));
$sql3 = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$result['topic_subcatid']."'");
$result3 = mysql_fetch_array($sql3);
$owner = qs_userdata($result['topic_ownerid']);
$regdate = qs_userdate($owner['user_regdate'], $owner['user_timezone']);
$ownerpostssql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_ownerid='".$owner['user_id']."'");
$ownertopicssql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_ownerid='".$owner['user_id']."'");
$ownerposts = mysql_num_rows($ownerpostssql)+mysql_num_rows($ownertopicssql);
$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);
if($result3['sub_status'] == '0'){
	$buttonn = '<a href="forum.php?m=new&id='.$result3['sub_id'].'"><img src="templates/'.$defskin.'/icons/forum_new_topic.gif"></a>';
}
elseif($result3['sub_status'] == '1'){
	$buttonn = '<img src="templates/'.$defskin.'/icons/forum_new_locked.gif">';
}
if($result['topic_status'] == '0' || $result['topic_status'] == '2' || $result['topic_status'] == '4'){
	$buttonr = '<a href="forum.php?m=reply&t='.$result['topic_id'].'"><img src="templates/'.$defskin.'/icons/forum_reply.gif"></a>';
}
elseif($result['topic_status'] == '1' || $result['topic_status'] == '3' || $result['topic_status'] == '5'){
	$buttonr = '<img src="templates/'.$defskin.'/icons/forum_new_locked.gif">';
}
$sdate = qs_userdate($result['topic_date'], $user['timezone']);
$gg = (!empty($owner['user_gg']) && $owner['user_gg'] != 0) ? '<a href="gg:'.$owner['user_gg'].'"><img valign="middle" src="templates/'.$defskin.'/icons/forum_gg.gif"</a>' : '' ;
$www = (!empty($owner['user_website'])) ? '<a href="http://'.$owner['user_website'].'"><img valign="middle" src="templates/'.$defskin.'/icons/forum_www.gif"</a>' : '' ;
if(file_exists($owner['user_avatar'])){
	$avatar = '<img src="'.$owner['user_avatar'].'">';
}
else {
	$avatar = '';
}
$kasdek = strstr($result['topic_text'], '[quote');
$kasdek2 = strstr($result['topic_text'], '[/quote]');
if(!empty($kasdek) && !empty($kasdek2)){
	$quotethis = '';
}
else{
	$quotethis = '<a href="forum.php?m=quote&t='.$result['topic_id'].'"><img src="templates/'.$defskin.'/icons/forum_quote.gif"></a>';
}
$tpl->assign(array(
	"TOPIC_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$result3['sub_id'].'">'.$result3['sub_title'].'</a> &raquo; <a href="forum.php?t='.$id.'">'.$result['topic_title'].'</a>',
	"TOPIC_BUTTON_NEW" => $buttonn,
	"TOPIC_BUTTON_REPLY" => $buttonr,
	"TOPIC_TOP" => '<a href="#top">'.$L['qs_top'].'</a>',
	"TOPIC_ID" => $result['topic_id'],
	"TOPIC_TITLE" => qs_stripslashes($result['topic_title']),
	"TOPIC_TEXT" => qs_smiles(qs_bbcode2(qs_viewtext($result['topic_text']))),
	"TOPIC_OWNER_NICK" => '<img src="includes/images/flags/'.$owner['user_origin'].'.gif"> <a href="users.php?id='.$owner['user_id'].'">'.$owner['user_nick'].'</a>',
	"TOPIC_OWNER_AVATAR" => $avatar,
	"TOPIC_OWNER_LEVEL" => qs_userlevel($owner['user_id']),
	"TOPIC_TEXT_REGDATE" => $L['qs_joined'],
	"TOPIC_OWNER_REGDATE" => $regdate['d'].'.'.$regdate['m'].'.'.$regdate['y'],
	"TOPIC_TEXT_FROM" => $L['qs_wfrom'],
	"TOPIC_OWNER_FROM" => $owner['user_location'],
	"TOPIC_TEXT_POSTS" => $L['qs_posts'],
	"TOPIC_QUOTE" => $quotethis,
	"TOPIC_OWNER_POSTS" => $ownerposts,
	"TOPIC_OWNER_SIGNATURE" => qs_bbcode2(qs_viewtext($owner['user_signature'])),
	"TOPIC_OWNER_GG" => $gg,
	"TOPIC_OWNER_WWW" => $www,
	"TOPIC_OWNER_PROFILE" => '<a href="users.php?id='.$owner['user_id'].'"><img src="templates/'.$defskin.'/icons/forum_profile.gif"></a>',
	"TOPIC_OWNER_PW" => '<a href="pm.php?s=new&to='.$owner['user_id'].'"><img src="templates/'.$defskin.'/icons/forum_pw.gif"></a>',
	"TOPIC_TEXT_SENT" => $L['qs_sent'],
	"TOPIC_SENT" => $sdate['d'].' '.$months[$sdate['m']].' '.$sdate['y'].', '.$sdate['h'].':'.$sdate['i'],
	"TOPIC_PAGES1" => $pages1,
	"TOPIC_PAGES2" => $posts_pages,
	"TOPIC_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
	"TOPIC_TEXT_AUTHOR" => $L['qs_author'],
	"TOPIC_TEXT_MESSAGE" => $L['qs_message'],
));
$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$result3['sub_id']."'");
if(($owner['user_id'] == $user['id']) || qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
	$tpl->assign(array(
		"TOPIC_EDIT" => '<a href="forum.php?m=edit&t='.$result['topic_id'].'"><img src="templates/'.$defskin.'/icons/forum_edit.gif"></a>&nbsp;&nbsp;&nbsp;',
	));
}

if($p == 1){
	$tpl->parse('MAIN.TOPIC_ROW');
}

if((qs_acscheck($user['level'], 'forums') && $user['level']>$owner['user_level']) || ($user['id'] == $owner['user_id'])){
	$tpl->assign(array(
		"TOPIC_EDIT" => 'forum.php?m=edit&t='.$result2['post_id']
	));
	$tpl->parse('MAIN.TOPIC_EDIT');
}
$sql2 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$id."' ORDER BY post_date ASC LIMIT ".$p1.",".$p2."");
while($result2 = mysql_fetch_array($sql2)) {
	$owner = qs_userdata($result2['post_ownerid']);
	$regdate = qs_userdate($owner['user_regdate'], $owner['user_timezone']);
	$ownerpostssql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_ownerid='".$owner['user_id']."'");
	$ownertopicssql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_ownerid='".$owner['user_id']."'");
	$ownerposts = mysql_num_rows($ownerpostssql)+mysql_num_rows($ownertopicssql);
	$sdate = qs_userdate($result2['post_date'], $user['timezone']);
	$gg = (!empty($owner['user_gg']) && $owner['user_gg'] != 0) ? '<a href="gg:'.$owner['user_gg'].'"><img src="templates/'.$defskin.'/icons/forum_gg.gif"</a>' : '' ;
	$www = (!empty($owner['user_website'])) ? '<a href="http://'.$owner['user_website'].'"><img src="templates/'.$defskin.'/icons/forum_www.gif"</a>' : '' ;
	if(file_exists($owner['user_avatar'])){
		$avatar = '<img src="'.$owner['user_avatar'].'">';
	}
	else {
		$avatar = '';
	}
	$pkasdek = strstr($result2['post_text'], '[quote');
	$pkasdek2 = strstr($result2['post_text'], '[/quote]');
	if(!empty($pkasdek) && !empty($pkasdek2)){
		$pquotethis = '';
	}
	else{
		$pquotethis = '<a href="forum.php?m=quote&p='.$result2['post_id'].'"><img src="templates/'.$defskin.'/icons/forum_quote.gif"></a>';
	}
	$tpl->assign(array(
		"POST_ID" => $result2['post_id'],
		"POST_TEXT" => qs_smiles(qs_bbcode2(qs_viewtext($result2['post_text']))),
		"POST_OWNER_NICK" => '<img src="includes/images/flags/'.$owner['user_origin'].'.gif"> <a href="users.php?id='.$owner['user_id'].'">'.$owner['user_nick'].'</a>',
		"POST_OWNER_AVATAR" => $avatar,
		"POST_OWNER_LEVEL" => qs_userlevel($owner['user_id']),
		"POST_TEXT_REGDATE" => $L['qs_joined'],
		"POST_OWNER_REGDATE" => $regdate['d'].'.'.$regdate['m'].'.'.$regdate['y'],
		"POST_TEXT_FROM" => $L['qs_wfrom'],
		"POST_OWNER_FROM" => $owner['user_location'],
		"POST_TEXT_POSTS" => $L['qs_posts'],
		"POST_QUOTE" => $pquotethis,
		"POST_OWNER_POSTS" => $ownerposts,
		"POST_OWNER_SIGNATURE" => qs_bbcode2(qs_viewtext($owner['user_signature'])),
		"POST_OWNER_GG" => $gg,
		"POST_OWNER_WWW" => $www,
		"POST_OWNER_PROFILE" => '<a href="users.php?id='.$owner['user_id'].'"><img src="templates/'.$defskin.'/icons/forum_profile.gif"></a>',
		"POST_OWNER_PW" => '<a href="pm.php?s=new&to='.$owner['user_id'].'"><img src="templates/'.$defskin.'/icons/forum_pw.gif"></a>',
		"POST_TEXT_SENT" => $L['qs_sent'],
		"POST_SENT" => $sdate['d'].' '.$months[$sdate['m']].' '.$sdate['y'].', '.$sdate['h'].':'.$sdate['i'],
	));
	$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$result3['sub_id']."'");
	if(($owner['user_id'] == $user['id']) || qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
		$tpl->assign(array(
			"POST_EDIT" => '<a href="forum.php?m=edit&p='.$result2['post_id'].'&pa='.$p.'"><img src="templates/'.$defskin.'/icons/forum_edit.gif"></a>&nbsp;&nbsp;&nbsp;',
		));
	}
	$tpl->parse('MAIN.POST_ROW');
}

$tpl->assign(array(
	"TEXT_REGDATE" => $L['qs_joined'],
	"TEXT_POSTS" => $L['qs_posts'],
	"TEXT_FROM" => $L['qs_wfrom'],
	"TEXT_SENT" => $L['qs_sent'],
	"TEXT_TITLE" => $L['qs_topic'],
	"TEXT_MSG" => $L['qs_msg'],
	"TEXT_AUTHOR" => $L['qs_author'],
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>