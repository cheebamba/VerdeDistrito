<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'articles';
$title = $T['articles'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('articles'));
$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_page='1' AND article_status='1' ORDER BY article_date");
if(mysql_num_rows($sql)<1){
	$tpl->assign("ARTICLES_NONE", $L['qs_none']);
}
else {
	$i = 0;
	while ($result = mysql_fetch_array($sql)){
		$i++;
		$avatar = $result['article_avatar'];
		$owner = qs_userdata($result['article_ownerid']);
		$csql= mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='2' AND cat_st='".$result['article_cat']."'");
		$cat = mysql_fetch_array($csql);
		$date = qs_userdate($result['article_date'], $user['timezone']);
		if(file_exists($avatar)){
			$avatar = '<img border="0" src="'.$avatar.'" width="60" height="60" align="left">';
		}
		else {
			$avatar = '';
		}
		$comments = mysql_num_rows(mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='2' AND comment_pageid='".$result['article_id']."'"));
		$tpl->assign(array(
			"ARTICLE_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
			"ARTICLE_TITLE" => '<a href="articles.php?id='.$result['article_id'].'">'.$result['article_title'].'</a>',
			"ARTICLE_OWNER" => '<a href="users.php?id='.$owner['user_id'].'">'.$owner['user_nick'].'</a>',
			"ARTICLE_OWNER_TEXT" => $L['qs_ownern'],
			"ARTICLE_CAT" => '<img src="includes/images/icons/'.$cat['cat_ico'].'">',
			"ARTICLE_AVATAR" => $avatar,
			"ARTICLE_COMMENTS_TEXT" => $L['qs_comments'],
		));
		if($i == 2){
			$i = 0;
			$tpl->assign(array(
				"ARTICLE_COMMENTS" => $comments.'<br><br><hr></td></tr><tr><td width="50%" valign="top">',
			));
		}
		else {
			$tpl->assign(array(
				"ARTICLE_COMMENTS" => $comments.'<br><br><hr></td><td width="50%" valign="top">',
			));
		}
		$tpl->parse('MAIN.ARTICLES_ROW');
	}
}

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>