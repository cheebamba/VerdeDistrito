<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'authorizer')){
	qs_redirect(107);
}

$title = $T['authorize'];

$idn = $_GET['idn'];
$ida = $_GET['ida'];

if(!empty($idn)){
	if(mysql_query("UPDATE ".$qs_db['news']." SET news_status='1' WHERE news_id='".$idn."'")){
		qs_redirect(400, 'admin.php');
	}
}
if(!empty($ida)){
	if(mysql_query("UPDATE ".$qs_db['articles']." SET article_status='1' WHERE article_id='".$ida."' AND article_page='1'")){
		qs_redirect(400, 'admin.php');
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/authorize'));

$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_status='0' ORDER BY news_date");
while ($result = mysql_fetch_array($sql)) {
	$owner = qs_userdata($result['news_ownerid']);
	$date = qs_userdate($result['news_date'], $user['timezone']);
	$tpl->assign(array(
		"AUTH_TYPE" => $L['qs_news'],
		"AUTH_TITLE_TEXT" => $L['qs_title'],
		"AUTH_TITLE" => $result['news_title'],
		"AUTH_DATE_TEXT" => $L['qs_date'],
		"AUTH_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
		"AUTH_OWNER_TEXT" => $L['qs_ownern'],
		"AUTH_OWNER" => '<a href="users.php?id='.$result['news_ownerid'].'">'.$owner['user_nick'].'</a>',
		"AUTH_EDIT" => '<a href="admin.php?s=editnews&id='.$result['news_id'].'">['.$L['qs_edit'].']</a>',
		"AUTH_VIEW" => '<a href="admin.php?s=viewn&id='.$result['news_id'].'">['.$L['qs_view'].']</a>',
		"AUTH_ACCEPT" => '<a href="admin.php?s=authorize&idn='.$result['news_id'].'">['.$L['qs_accept'].']</a>'
	));
	$tpl->parse('MAIN.AUTH_QUEUE');
}
$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_status='0' AND article_page='1' ORDER BY article_date");
while ($result = mysql_fetch_array($sql)) {
	$owner = qs_userdata($result['article_ownerid']);
	$date = qs_userdate($result['article_date'], $user['timezone']);
	$tpl->assign(array(
		"AUTH_TYPE" => $L['qs_article'],
		"AUTH_TITLE_TEXT" => $L['qs_title'],
		"AUTH_TITLE" => $result['article_title'],
		"AUTH_DATE_TEXT" => $L['qs_date'],
		"AUTH_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
		"AUTH_OWNER_TEXT" => $L['qs_ownern'],
		"AUTH_OWNER" => '<a href="users.php?id='.$result['article_ownerid'].'">'.$owner['user_nick'].'</a>',
		"AUTH_EDIT" => '<a href="admin.php?s=editart&id='.$result['article_id'].'">['.$L['qs_edit'].']</a>',
		"AUTH_VIEW" => '<a href="admin.php?s=viewa&id='.$result['article_id'].'">['.$L['qs_view'].']</a>',
		"AUTH_ACCEPT" => '<a href="admin.php?s=authorize&ida='.$result['article_id'].'">['.$L['qs_accept'].']</a>'
	));
	$tpl->parse('MAIN.AUTH_QUEUE');
}

$tpl->assign(array(
));

?>