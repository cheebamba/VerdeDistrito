<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'file';
$title = $T['file'];

$down = $_POST['down'];
$id = $_GET['id'];
if(!empty($down)){
	$sql = mysql_query("SELECT * FROM ".$qs_db['files']." WHERE file_id='".$id."'");
	$result = mysql_fetch_array($sql);
	$count = $result['file_down']+1;
	mysql_query("UPDATE ".$qs_db['files']." SET file_down='".$count."' WHERE file_id='".$id."'");
	header("Location: ".$result['file_url']."");
	exit;
}
$sql = mysql_query("SELECT * FROM ".$qs_db['files']." WHERE file_id='".$id."'");
if(mysql_num_rows($sql)<1){
	qs_redirect(900, 'admin');
}
$result = mysql_fetch_array($sql);
if($user['level']<$result['file_minlevel']){
	qs_redirect(107);
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('file.details'));
$date = qs_userdate($result['file_date'], $user['timezone']);
$date = $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'];
$owner = qs_userdata($result['file_ownerid']);
$tpl->assign(array(
	"FILE_TEXT_TITLE" => $L['qs_filename'],
	"FILE_FORM_TITLE" => $result['file_title'],
	"FILE_TEXT_TEXT" => $L['qs_des'],
	"FILE_FORM_TEXT" => qs_bbcode(nl2br($result['file_text'])),
	"FILE_TEXT_SIZE" => $L['qs_size'],
	"FILE_FORM_SIZE" => $result['file_size'],
	"FILE_TEXT_DOWN" => $L['qs_downloaded'],
	"FILE_FORM_DOWN" => $result['file_down'],
	"FILE_FORM_CAT" => '<img src="includes/images/icons/'.$result['file_cat'].'.gif">',
	"FILE_TEXT_OWNER" => $L['qs_sentby'],
	"FILE_FORM_OWNER" => '<a href="users.php?id='.$owner['user_id'].'">'.$owner['user_nick'].'</a>',
	"FILE_TEXT_DATE" => $L['qs_sentat'],
	"FILE_FORM_DATE" => $date,
));

if($user['level']>0){
	$tpl->assign("FILE_FORM_DOWNLOAD", '<form method="POST" action="files.php?id='.$result['file_id'].'"><input type="hidden" name="down" value="ON"><input type="submit" name="send" class="submit" value="'.$L['qs_download'].'"></form>');
}
else {
	$tpl->assign("FILE_FORM_DOWNLOAD", '<b>'.$L['qs_logtodown'].'</b><br>');
}

if(qs_acscheck($user['level'], 'upload')){
	$tpl->assign("EDIT_LINK", '<a href="admin.php?s=editfile&id='.$result['file_id'].'">['.$L['qs_edit'].']</a>');
}

$tpl->parse('MAIN');
$tpl->out('MAIN');
$adres = 'files.php?id='.$id;
$cat = '4';
$id = $_GET['id'];
require('includes/main/comments/comments.php');
require('includes/footer.php');

?>