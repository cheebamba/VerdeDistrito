<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'config')){
	qs_redirect(107);
}

$title = $T['config'];

$a = $_POST['a'];
if($a == 'update'){
	$cid = $_POST['id'];
	$value = $_POST['value'];
	if(mysql_query("UPDATE ".$qs_db['config']." SET config_value='".$value."' WHERE config_id='".$cid."'")){
		qs_redirect(108, 'admin.php?s=config');
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/config'));

$sql = mysql_query("SELECT * FROM ".$qs_db['config']." ORDER BY config_cat");
while($result = mysql_fetch_array($sql)){
	$tpl->assign(array(
		"CONFIG_CAT" => $result['config_cat'],
		"CONFIG_NAME" => $result['config_name'],
		"CONFIG_VALUE" => '<input name="value" type="text" value="'.$result['config_value'].'">',
		"CONFIG_TEXT" => $result['config_text'],
		"CONFIG_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$result['config_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
	));
	$tpl->parse('MAIN.CONFIG_ROW');
}

?>