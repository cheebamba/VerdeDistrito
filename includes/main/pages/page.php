<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$id = $_GET['id'];

$sql = mysql_query("SELECT * FROM ".$qs_db['pages']." WHERE page_id='".$id."'");
if(mysql_num_rows($sql)<1){
	qs_redirect(900);
}

$result = mysql_fetch_array($sql);

if($result['page_minlevel']>$user['level']){
	qs_redirect(107);
}

$loc = $result['page_title'];
$title = $T[$result['page_title']];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('page'));

if(qs_acscheck($user['level'], 'pages')){
	$tpl->assign(array(
	"PAGE_EDIT" => '<a href="admin.php?s=editpage&id='.$id.'">['.$L['qs_edit'].']</a><br>',
	));
}

$tpl->assign(array(
	"PAGE_TITLE" => $result['page_title'],
	"PAGE_TEXT" => qs_bbcode2($result['page_text']),
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>