<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$title = $conf['global_subtitle'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('news'));

$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_minlevel<='".$user['level']."' AND news_status='1' ORDER BY news_date DESC LIMIT ".$conf['news_maxindex']."");
if(mysql_num_rows($sql)<1){
	$tpl->assign("NEWS_NONE", $L['qs_none']);
	$tpl->parse('MAIN.NEWS_NONE');
}
else {
	while ($result = mysql_fetch_array($sql)) {
		$sql2 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result['news_ownerid']."'");
		$result2 = mysql_fetch_array($sql2);
		$sql3 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='1' AND comment_pageid='".$result['news_id']."'");
		$count = mysql_num_rows($sql3);
		$date = qs_userdate($result['news_date'], $user['timezone']);
		$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='1' AND cat_st='".$result['news_cat']."'");
		$cat = mysql_fetch_array($csql);
		$tpl->assign(array(
			"NEWS_TITLE" => $result['news_title'],
			"NEWS_TEXT" => qs_bbcode(qs_match(nl2br($result['news_text']))),
			"NEWS_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
			"NEWS_CAT" => $cat['cat_ico'],
			"NEWS_OWNER" => '<a href="users.php?id='.$result['news_ownerid'].'">'.$result2['user_nick'].'</a>',
			"NEWS_OWNER_TEXT" => $L['qs_ownern'],
			"NEWS_COMMENT" => '<a href="index.php?id='.$result['news_id'].'">'.$L['qs_readmore'].'</a>',
			"NEWS_COMMENTS" => $count,
			"NEWS_ARCHIVES" => '<a href="index.php?s=archives">'.$L['qs_archives'].'</a>',
		));
		
		if($user['level']>18 || (qs_acscheck($user['level'], 'news') && $result['news_ownerid'] == $user['id'])){
			$tpl->assign(array(
				"ADMIN_EDIT" => '<a href="admin.php?s=editnews&id='.$result['news_id'].'">'.$L['qs_edit'].'</a>',
				"ADMIN_WITHDRAW" => '<a href="admin.php?s=news&a=wd&id='.$result['news_id'].'">'.$L['qs_withdraw'].'</a>',
			));
			$tpl->parse('MAIN.NEWS_ROW.ADMIN_ROW');
		}
		$tpl->parse('MAIN.NEWS_ROW');
	}
}

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>