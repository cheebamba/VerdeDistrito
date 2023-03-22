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
$title = $T['upload'];

$a = $_POST['a'];
if($a == 'upload'){
	$img = $_FILES["img"];
	if(!empty($img["tmp_name"])){
		$dest = 'includes/images/upload/'.strtolower($img["name"]);
		if(file_exists($dest)){
			$dest = 'includes/images/upload/'.gmdate("d").'_'.strtolower($img["name"]);
		}
		if(file_exists($dest)){
			$ext = strtolower(strrchr($img["name"], '.'));
			$dest = 'includes/images/upload/'.time().$ext;
		}
		if(move_uploaded_file($img["tmp_name"], $dest)){
			chmod($dest, 0755);
			$done = 'OK';
		}
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/upload'));

if(empty($done)){
	$tpl->assign(array(
		"UPLOAD_TEXT_FILE" => $L['qs_picture'],
		"UPLOAD_FORM_FILE" => '<input type="file" name="img" class="file">',
		"UPLOAD_FORM_SEND" => '<input type="hidden" name="a" value="upload"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
	));
	$tpl->parse('MAIN.UPLOAD_ROW');
}
else {
	$tpl->assign(array(
		"UPLOAD_TEXT_URL" => $L['qs_urltoimg'],
		"UPLOAD_FORM_URL" => '<a href="'.$dest.'">'.$dest.'</a>',
	));
	$tpl->parse('MAIN.UPLOAD_URL');
}

?>