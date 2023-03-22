<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'emots')){
	qs_redirect(107);
}

$title = $T['emots'];

$a = $_POST['a'];
$del = $_POST['del'];
if($del == 'ON'){
	$id = $_POST['id'];
	if(mysql_query("DELETE FROM ".$qs_db['smiles']." WHERE smile_id='".$id."'")){
		qs_redirect(400, 'admin.php?s=emots');
	}
}
elseif($a == 'update'){
	$id = $_POST['id'];
	$code = qs_addslashes($_POST['code']);
	$text = $_POST['text'];
	$url = $_POST['url'];
	if(mysql_query("UPDATE ".$qs_db['smiles']." SET smile_code='".$code."', smile_text='".$text."', smile_image='".$url."' WHERE smile_id='".$id."'")){
		qs_redirect(400, 'admin.php?s=emots');
	}
}
elseif($a == 'add'){
	$code = qs_addslashes($_POST['code']);
	$text = $_POST['text'];
	$url = $_POST['url'];
	if(mysql_query("INSERT INTO ".$qs_db['smiles']."(smile_code, smile_text, smile_image) VALUES('".$code."', '".$text."', '".$url."')")){
		qs_redirect(400, 'admin.php?s=emots');
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/emots'));

$sql = mysql_query("SELECT * FROM ".$qs_db['smiles']." ORDER BY smile_id");
while($result = mysql_fetch_array($sql)){
	$tpl->assign(array(
		"SMILE_FORM_DEL" => '<input type="checkbox" name="del" value="ON">',
		"SMILE_TEXT_DEL" => $L['qs_delete'],
		"SMILE_FORM_CODE" => '<input type="text" name="code" value="'.qs_stripslashes($result['smile_code']).'">',
		"SMILE_TEXT_CODE" => $L['qs_character'],
		"SMILE_FORM_TEXT" => '<input type="text" name="text" value="'.$result['smile_text'].'">',
		"SMILE_TEXT_TEXT" => $L['qs_des'],
		"SMILE_FORM_URL" => '<input type="text" name="url" value="'.$result['smile_image'].'">',
		"SMILE_TEXT_URL" => $L['qs_imgurl'],
		"SMILE_FORM_IMG" => '<img src="'.$result['smile_image'].'">',
		"SMILE_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$result['smile_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
	));
	$tpl->parse('MAIN.SMILES_ROW');
}

$tpl->assign(array(
	"SMILE_TEXT_NEW" => $L['qs_addnewsmile'],
	"SMILE_FORM_CODE" => '<input type="text" name="code">',
	"SMILE_TEXT_CODE" => $L['qs_character'],
	"SMILE_FORM_TEXT" => '<input type="text" name="text">',
	"SMILE_TEXT_TEXT" => $L['qs_des'],
	"SMILE_FORM_URL" => '<input type="text" name="url">',
	"SMILE_TEXT_URL" => $L['qs_imgurl'],
	"SMILE_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="id" value="'.$result['smile_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_add'].'">',
));

?>