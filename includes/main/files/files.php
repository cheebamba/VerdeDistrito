<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'files';
$title = $T['files'];

$cat = $_GET['cat'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('files'));
if(!empty($cat)){
	$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='6' AND cat_st='".$cat."'");
	$result = mysql_fetch_array($sql);
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['files']." WHERE file_cat='".$result['cat_st']."'");
	$files = mysql_num_rows($sql2);
	$tpl->assign(array(
		"CAT_FORM_TITLE" => '<img src="includes/images/icons/'.$result['cat_ico'].'"> '.$result['cat_title'],
		"CAT_FORM_FILES" => $files,
	));
	$sql = mysql_query("SELECT * FROM ".$qs_db['files']." WHERE file_minlevel<='".$user['level']."' AND file_cat='".$cat."'");
	
	while ($result = mysql_fetch_array($sql)) {
		$tpl->assign(array(
			"FILE_FORM_TITLE" => '<a href="files.php?id='.$result['file_id'].'">'.$result['file_title'].'</a>',
			"FILE_FORM_DOWN" => $result['file_down'],
		));
		$tpl->parse('MAIN.FILES.FILES_ROW');
	}
	$tpl->parse('MAIN.FILES');
}
else {
	$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='6' AND cat_subid<>'1'");
	while ($result = mysql_fetch_array($sql)) {
		$sql2 = mysql_query("SELECT * FROM ".$qs_db['files']." WHERE file_cat='".$result['cat_st']."'");
		$files = mysql_num_rows($sql2);
		$tpl->assign(array(
			"CAT_FORM_TITLE" => '<img src="includes/images/icons/'.$result['cat_ico'].'"> <a href="files.php?cat='.$result['cat_st'].'">'.$result['cat_title'].'</a>',
			"CAT_FORM_FILES" => $files,
		));
		$tpl->parse('MAIN.CATS_ROW');
	}
}

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>