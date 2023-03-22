<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$title = $T['news.archives'];

$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_minlevel<=".$user['level']." ORDER BY news_date DESC");
require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('news.archives'));
if(mysql_num_rows($sql)<1){
	$tpl->assign("NEWS_NONE", $L['qs_none']);
}
else {
	while ($result = mysql_fetch_array($sql)) {
		$date = qs_userdate($result['news_date'], $user['timezone']);
		$tpl->assign(array(
			"NEWS_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
			"NEWS_TITLE" => '<a href="index.php?id='.$result['news_id'].'">'.$result['news_title'].'</a>'
		));
		$tpl->parse('MAIN.NEWS_ROW');
	}
}

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>