<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$id = $_GET['id'];
$p = (empty($_GET['p'])) ? 1 : $_GET['p'] ;

$loc = 'article';

$sql2 = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_page='1' AND article_status='1' AND article_id='".$id."'");
if(mysql_num_rows($sql2)<1){
	qs_redirect(118);
}
$result2 = mysql_fetch_array($sql2);
$title = $result2['article_title'];
$date = qs_userdate($result2['article_date'], $user['timezone']);
$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='2' AND cat_st='".$result2['article_cat']."'");
$cat = mysql_fetch_array($csql);
$owner = qs_userdata($result2['article_ownerid']);
$sql2 = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."'");
$count = mysql_num_rows($sql2);
if($count>1){
	for ($i=1; $i<=$count; $i++){
		$a = ($i == $p) ? 'a' : '' ;
		if ($i == 1){
			$pages = '<a '.$a.'href="articles.php?id='.$id.'&p='.$i.'">'.$i.'</a>';
		}
		else {
			$pages .= ' | <a '.$a.'href="articles.php?id='.$id.'&p='.$i.'">'.$i.'</a>';
		}
	}
}
$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."' AND article_page='".$p."'");
if(mysql_num_rows($sql)<1){
	qs_redirect(118);
}
$result = mysql_fetch_array($sql);
require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('article.com'));
$tpl->assign("ARTICLE_PAGES", $pages);
$tpl->assign(array(
	"ARTICLE_TITLE" => $title,
	"ARTICLE_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
	"ARTICLE_CAT" => $cat['cat_ico'],
	"ARTICLE_OWNER" => '<a href="users.php?a=details&id='.$owner['user_id'].'">'.$owner['user_nick'].'</a>',
	"ARTICLE_OWNER_TEXT" => $L['qs_ownern'],
	"ARTICLE_TEXT" => qs_bbcode(qs_match(nl2br($result['article_text']))),
));
if($user['level']>18 || (qs_acscheck($user['level'], 'articles') && $result2['article_ownerid'] == $user['id'])){
			$tpl->assign(array(
				"ADMIN_EDIT" => '<a href="admin.php?s=editart&id='.$result2['article_id'].'">'.$L['qs_edit'].'</a>',
				"ADMIN_WITHDRAW" => '<a href="admin.php?s=art&a=wd&id='.$result2['article_id'].'">'.$L['qs_withdraw'].'</a>',
			));
			$tpl->parse('MAIN.ADMIN_ROW');
}

$tpl->parse('MAIN');
$tpl->out('MAIN');

$adres = 'articles.php?id='.$id.'&p='.$p;
$cat = '2';
$id = $_GET['id'];
require('includes/main/comments/comments.php');

require('includes/footer.php');

?>