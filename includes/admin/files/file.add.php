<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'upload')){
	qs_redirect(107);
}

$loc = 'admin';
$title = $T['file.add'];

$a = $_POST['a'];
if($a == 'add'){
	$minlevel = $_POST['minlevel'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$url = $_POST['url'];
	$size = $_POST['size'];
	$cat = $_POST['cat'];
	$date = gmdate("Y-m-d H:i:s");
	if(mysql_query("INSERT INTO ".$qs_db['files']."(file_minlevel, file_title, file_text, file_url, file_size, file_cat, file_ownerid, file_date) VALUES('".$minlevel."', '".$title."', '".$text."', '".$url."', '".$size."', '".$cat."', '".$user['id']."', '".$date."')")){
		qs_redirect(400, 'admin.php');
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

$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='6' AND cat_subid<>'1' ORDER BY cat_subid");
$cat = '<select name="cat">';
while ($result = mysql_fetch_array($sql)) {
	$i = 0;
	if($i == 0){
		$cat .= '<option value="'.$result['cat_st'].'" selected>'.$result['cat_title'].'</option>';
	}
	else {
		$cat .= '<option value="'.$result['cat_st'].'">'.$result['cat_title'].'</option>';
	}
	$i++;
}
$cat .= '</select>';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/file.add'));

$tpl->assign(array(
	"FILE_FORM_TITLE" => '<input type="text" name="title">',
	"FILE_TEXT_TITLE" => $L['qs_title'],
	"FILE_FORM_URL" => '<input type="text" name="url">',
	"FILE_TEXT_URL" => $L['qs_fileurl'],
	"FILE_FORM_SIZE" => '<input type="text" name="size">',
	"FILE_TEXT_SIZE" => $L['qs_filesize'],
	"FILE_FORM_TEXT" => '<textarea rows="10" name="text" cols="60"></textarea>',
	"FILE_TEXT_TEXT" => $L['qs_des'],
	"FILE_FORM_MINLEVEL" => $minlevel,
	"FILE_TEXT_MINLEVEL" => $L['qs_minlevel'],
	"FILE_FORM_CAT" => $cat,
	"FILE_TEXT_CAT" => $L['qs_category'],
	"FILE_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
));

?>