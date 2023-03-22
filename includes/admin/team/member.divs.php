<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'team')){
	qs_redirect(107);
}

$loc = 'team';
$title = $T['team'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/member.divs'));

$a = $_POST['a'];
if($a == 'update'){
	$del = $_POST['del'];
	$id = $_POST['id'];
	$subid = $_POST['subid'];
	$name = $_POST['name'];
	$st = $_POST['st'];
	if($del == 'ON'){
		mysql_query("DELETE FROM ".$qs_db['divs']." WHERE div_id='".$id."'");
	}
	else {
		mysql_query("UPDATE ".$qs_db['divs']." SET div_subid='".$subid."', div_name='".$name."', div_st='".$st."' WHERE div_id='".$id."'");
	}
}
elseif($a == 'new'){
	$subid = $_POST['subid'];
	$name = $_POST['name'];
	$st = $_POST['st'];
	mysql_query("INSERT INTO ".$qs_db['divs']."(div_subid, div_name, div_st) VALUES('".$subid."', '".$name."', '".$st."')");
}

$tpl->assign(array(
	"TEXT_DEL" => $L['qs_delete'],
	"TEXT_SUBID" => $L['qs_order'],
	"TEXT_NAME" => $L['qs_cattitle'],
	"TEXT_ST" => $L['qs_st'],
	"TEXT_MEMBERS" => $L['qs_members']
));

$sql = mysql_query("SELECT * FROM ".$qs_db['divs']." ORDER BY div_subid");
while($result = mysql_fetch_array($sql)){
	$tpl->assign(array(
		"DIV_DEL" => '<input type="checkbox" name="del" value="ON">',
		"DIV_SUBID" => '<input type="text" size="1" name="subid" value="'.$result['div_subid'].'">',
		"DIV_NAME" => '<input type="text" size="20" name="name" value="'.$result['div_name'].'">',
		"DIV_ST" => '<input type="text" size="8" name="st" value="'.$result['div_st'].'">',
		"DIV_MEMBERS" => '<a href="admin.php?s=div&id='.$result['div_id'].'">['.$L['qs_edit'].']</a>',
		"DIV_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$result['div_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
	));
	$tpl->parse('MAIN.DIV_ROW');
}
$tpl->assign(array(
	"NEW_ADD_TEXT" => $L['qs_adddiv'],
	"NEW_SUBID" => '<input type="text" size="1" name="subid">',
	"NEW_NAME" => '<input type="text" size="20" name="name">',
	"NEW_ST" => '<input type="text" size="8" name="st">',
	"NEW_SEND" => '<input type="hidden" name="a" value="new"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
));


?>