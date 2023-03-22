<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'pages')){
	qs_redirect(107);
}

$loc = 'page.add';
$title = $T['page.add'];

$a = $_POST['a'];

if($a == 'add'){
	$minlevel = $_POST['minlevel'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$date = gmdate("Y-m-d H:i:s");
	if(mysql_query("INSERT INTO ".$qs_db['pages']."(page_minlevel, page_title, page_text, page_date, page_ownerid) VALUES('".$minlevel."', '".$title."', '".$text."', '".$date."', '".$user['id']."')")){
		qs_redirect(400, 'admin.php');
	}
	else {
		qs_redirect(800, 'admin.php');
	}
}

$minlevel = '<select name="minlevel">';
for ($i=0; $i<21; $i++){
	if($i == 0){
		$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$minlevel .= '</select>';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/page.add'));

$tpl->assign(array(
	"PAGE_TEXT_TITLE" => $L['qs_title'],
	"PAGE_FORM_TITLE" => '<input type="text" name="title">',
	"PAGE_TEXT_TEXT" => $L['qs_content'],
	"PAGE_FORM_TEXT" => '<textarea rows="25" name="text" cols="60"></textarea>',
	"PAGE_TEXT_MINLEVEL" => $L['qs_minlevel'],
	"PAGE_FORM_MINLEVEL" => $minlevel,
	"PAGE_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">'
));

?>