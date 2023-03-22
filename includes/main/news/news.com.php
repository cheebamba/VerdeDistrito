<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$id = $_GET['id'];
if(empty($id)){
	qs_redirect(117);
}
else {
	$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_status='1' AND news_id='".$id."'");
	if(mysql_num_rows($sql)<1){
		qs_redirect(117);
	}
	if($user['level']<$result['news_minlevel']){
		qs_redirect(107);
	}
	$result = mysql_fetch_array($sql);

	$title = qs_stripslashes($result['news_title']);

	require('includes/header.php');
	$tpl = new XTemplate(qs_tplfile('news.com'));
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result['news_ownerid']."'");
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='1' AND comment_pageid='".$id."'");
	$count = mysql_num_rows($sql3);
	$date = qs_userdate($result['news_date'], $user['timezone']);
	$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='1' AND cat_st='".$result['news_cat']."'");
	$cat = mysql_fetch_array($csql);
	if(empty($result['news_text2'])){
		$text = $result['news_text'];
	}
	else {
		$text = $result['news_text2'];
	}
	$tpl->assign(array(
			"NEWS_TITLE" => $result['news_title'],
			"NEWS_TEXT" => qs_bbcode(qs_match(nl2br($text))),
			"NEWS_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
			"NEWS_CAT" => $cat['cat_ico'],
			"NEWS_OWNER" => '<a href="users.php?a=details&id='.$result['news_ownerid'].'">'.$result2['user_nick'].'</a>',
			"NEWS_OWNER_TEXT" => $L['qs_ownern'],
	));
	if($user['level']>18 || (qs_acscheck($user['level'], 'news') && $result['news_ownerid'] == $user['id'])){
			$tpl->assign(array(
				"ADMIN_EDIT" => '<a href="admin.php?s=editnews&id='.$result['news_id'].'">'.$L['qs_edit'].'</a>',
				"ADMIN_WITHDRAW" => '<a href="admin.php?s=news&a=wd&id='.$result['news_id'].'">'.$L['qs_withdraw'].'</a>',
			));
			$tpl->parse('MAIN.ADMIN_ROW');
	}
	$tpl->parse('MAIN');
	$tpl->out('MAIN');
	$adres = 'index.php?id='.$id;
	$cat = '1';
	$id = $_GET['id'];
	require('includes/main/comments/comments.php');
	require('includes/footer.php');
}

?>