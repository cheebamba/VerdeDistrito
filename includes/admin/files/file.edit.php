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
$title = $T['file.update'];

$id = $_GET['id'];
if(empty($id)){
	$id = $_POST['id'];
}

$a = $_POST['a'];
if($a == 'update'){
	$del = $_POST['del'];
	if($del == 'ON'){
		if(mysql_query("DELETE FROM ".$qs_db['files']." WHERE file_id='".$id."'")){
			qs_redirect(400, 'admin.php');
		}
	}
	$minlevel = $_POST['minlevel'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$url = $_POST['url'];
	$size = $_POST['size'];
	$cat = $_POST['cat'];
	$date = gmdate("Y-m-d H:i:s");
	if(mysql_query("UPDATE ".$qs_db['files']." SET file_minlevel='".$minlevel."', file_title='".$title."', file_text='".$text."', file_url='".$url."', file_size='".$size."', file_cat='".$cat."', file_date='".$date."' WHERE file_id='".$id."'")){
		qs_redirect(400, 'admin.php');
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['files']." WHERE file_id='".$id."'");
if(mysql_num_rows($sql)<1){
	qs_redirect(900, 'admin.php');
}
$result = mysql_fetch_array($sql);

$minlevel = '<select name="minlevel">';
for ($i=0; $i<21; $i++){
	if($i == $result['file_minlevel']){
		$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$minlevel .= '</select>';

$sql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='6' AND cat_subid<>'1' ORDER BY cat_subid");
$cat = '<select name="cat">';
while ($result2 = mysql_fetch_array($sql2)) {
	if($result2['cat_st'] == $result['file_cat']){
		$cat .= '<option value="'.$result2['cat_st'].'" selected>'.$result2['cat_title'].'</option>';
	}
	else {
		$cat .= '<option value="'.$result2['cat_st'].'">'.$result2['cat_title'].'</option>';
	}
}
$cat .= '</select>';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/file.edit'));

$tpl->assign(array(
	"FILE_FORM_TITLE" => '<input type="text" name="title" value="'.$result['file_title'].'">',
	"FILE_TEXT_TITLE" => $L['qs_title'],
	"FILE_FORM_URL" => '<input type="text" name="url" value="'.$result['file_url'].'">',
	"FILE_TEXT_URL" => $L['qs_fileurl'],
	"FILE_FORM_SIZE" => '<input type="text" name="size" value="'.$result['file_size'].'">',
	"FILE_TEXT_SIZE" => $L['qs_filesize'],
	"FILE_FORM_TEXT" => '<textarea rows="10" name="text" cols="60">'.$result['file_text'].'</textarea>',
	"FILE_TEXT_TEXT" => $L['qs_des'],
	"FILE_FORM_MINLEVEL" => $minlevel,
	"FILE_TEXT_MINLEVEL" => $L['qs_minlevel'],
	"FILE_FORM_CAT" => $cat,
	"FILE_TEXT_CAT" => $L['qs_category'],
	"FILE_FORM_DEL" => '<input type="checkbox" name="del" value="ON">',
	"FILE_TEXT_DEL" => $L['qs_delete'],
	"FILE_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$result['file_id'].'"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
));

?>