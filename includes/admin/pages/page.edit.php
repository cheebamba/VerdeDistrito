<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'pages')){
	qs_redirect(107);
}

$loc = 'edit_site';
$title = $T['page.edit'];

$a = $_POST['a'];
$id = $_GET['id'];
if(empty($id)){
	$id = $_POST['id'];
}

if($a == 'update'){
	$del = $_POST['del'];
	if(!empty($del)){
		if(mysql_query("DELETE FROM ".$qs_db." WHERE page_id='".$id."'")){
			qs_redirect(400, 'admin.php');
		}
	}
	$minlevel = $_POST['minlevel'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$date = gmdate("Y-m-d H:i:s");
	if(mysql_query("UPDATE ".$qs_db['pages']." SET page_minlevel='".$minlevel."', page_title='".$title."', page_text='".$text."', page_date='".$date."', page_ownerid='".$user['id']."' WHERE page_id='".$id."'")){
		qs_redirect(400, 'admin.php');
	}
	else {
		qs_redirect(800, 'admin.php');
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['pages']." WHERE page_id='".$id."'");
if(mysql_num_rows($sql)<1){
	qs_redirect(900, 'admin.php');
}
$result = mysql_fetch_array($sql);

$minlevel = '<select name="minlevel">';
for ($i=0; $i<21; $i++){
	if($i == $result['page_minlevel']){
		$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$minlevel .= '</select>';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/page.edit'));

$tpl->assign(array(
	"PAGE_TEXT_TITLE" => $L['qs_title'],
	"PAGE_FORM_TITLE" => '<input type="text" name="title" value="'.$result['page_title'].'">',
	"PAGE_TEXT_TEXT" => $L['qs_url'].': <input name="Text1" type="text" readonly="readonly" value="pages.php?id='.$result['page_id'].'"><br>'.$L['qs_content'],
	"PAGE_FORM_TEXT" => '<textarea rows="25" name="text" cols="60">'.$result['page_text'].'</textarea>',
	"PAGE_TEXT_MINLEVEL" => $L['qs_minlevel'],
	"PAGE_FORM_MINLEVEL" => $minlevel,
	"PAGE_TEXT_DELETE" => $L['qs_delete'],
	"PAGE_FORM_DELETE" => '<input type="checkbox" name="del" value="ON">',
	"PAGE_FORM_SEND" => '<input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="a" value="update"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">'
));

?>