<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'cats')){
	qs_redirect(107);
}

$title = $T['cats'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/cats'));

$a = $_POST['a'];
if($a == 'update'){
	$aid = $_POST['aid'];
	$id = $_POST['id'];
	$subid = $_POST['subid'];
	$del = $_POST['del'];
	$cat_id = $_POST['cat_id'];
	$cat_subid = $_POST['cat_subid'];
	$cat_title = $_POST['cat_title'];
	$cat_st = $_POST['cat_st'];
	$cat_ico = $_POST['cat_ico'];
	$cat_minlevel = $_POST['cat_minlevel'];
	if($cat_subid != 1){
		$changeid = "cat_id='".$cat_id."', cat_subid='".$cat_subid."', ";
	}
	else {
		$changeid = "";
	}
	$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='".$id."' AND cat_subid='".$subid."'");
	if(mysql_num_rows($sql)>0){
		if($del == 'ON'){
			mysql_query("DELETE FROM ".$qs_db['cats']." WHERE cat_id='".$id."' AND cat_subid='".$subid."'");
		}
		else {
			mysql_query("UPDATE ".$qs_db['cats']." SET ".$changeid."cat_title='".$cat_title."', cat_st='".$cat_st."', cat_ico='".$cat_ico."', cat_minlevel='".$cat_minlevel."' WHERE cat_id='".$id."' AND cat_subid='".$subid."'");
		}
	}
}
elseif($a == 'new'){
	$cat_id = $_POST['cat_id'];
	$cat_subid = $_POST['cat_subid'];
	$cat_title = $_POST['cat_title'];
	$cat_st = $_POST['cat_st'];
	$cat_ico = $_POST['cat_ico'];
	$cat_minlevel = $_POST['cat_minlevel'];
	$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='".$cat_id."' AND cat_subid='".$cat_subid."'");
	if(mysql_num_rows($sql)<1){
		mysql_query("INSERT INTO ".$qs_db['cats']."(cat_id, cat_subid, cat_title, cat_st, cat_ico, cat_minlevel) VALUES('".$cat_id."', '".$cat_subid."', '".$cat_title."', '".$cat_st."', '".$cat_ico."', '".$cat_minlevel."')");
	}
	else {
		$tpl->assign("NEW_ACTION", $L['qs_catalreadyexists']); 
	}
}

$tpl->assign(array(
	"TEXT_DEL" => $L['qs_delete'],
	"TEXT_ID" => $L['qs_id'],
	"TEXT_SUBID" => $L['qs_subid'],
	"TEXT_TITLE" => $L['qs_cattitle'],
	"TEXT_ST" => $L['qs_st'],
	"TEXT_ICO" => $L['qs_ico'],
	"TEXT_MINLEVEL" => $L['qs_minlvl'],
));

$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_subid='1' ORDER BY cat_id");
while($result = mysql_fetch_array($sql)){
	$minlevel = '<select name="cat_minlevel">';
	for ($i=0; $i<21; $i++){
		if($i == $result['cat_minlevel']){
			$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$minlevel .= '</select>';
	
	$tpl->assign(array(
		"CAT_DEL" => '<input type="checkbox" name="del" value="ON">',
		"CAT_ID" => $result['cat_id'],
		"CAT_SUBID" => '1',
		"CAT_TITLE" => '<input type="text" size="20" name="cat_title" value="'.$result['cat_title'].'">',
		"CAT_ST" => '<input type="text" size="8" name="cat_st" value="'.$result['cat_st'].'">',
		"CAT_ICO" => '<input type="text" size="8" name="cat_ico" value="'.$result['cat_ico'].'">',
		"CAT_MINLEVEL" => $minlevel,
		"CAT_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="sid" value="'.$result['cat_subid'].'"><input type="hidden" name="id" value="'.$result['cat_id'].'"><input type="hidden" name="subid" value="'.$result['cat_subid'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
	));
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='".$result['cat_id']."' AND cat_subid<>'1' ORDER BY cat_subid");
	while($result2 = mysql_fetch_array($sql2)){
		$minlevel = '<select name="cat_minlevel">';
		for ($i=0; $i<21; $i++){
			if($i == $result2['cat_minlevel']){
				$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
			}
			else {
				$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$minlevel .= '</select>';
		$tpl->assign(array(
			"SUBCAT_DEL" => '<input type="checkbox" name="del" value="ON">',
			"SUBCAT_ID" => '<input type="text" size="1" name="cat_id" value="'.$result2['cat_id'].'">',
			"SUBCAT_SUBID" => '<input type="text" size="1" name="cat_subid" value="'.$result2['cat_subid'].'">',
			"SUBCAT_TITLE" => '<input type="text" size="20" name="cat_title" value="'.$result2['cat_title'].'">',
			"SUBCAT_ST" => '<input type="text" size="8" name="cat_st" value="'.$result2['cat_st'].'">',
			"SUBCAT_ICO" => '<input type="text" size="8" name="cat_ico" value="'.$result2['cat_ico'].'">',
			"SUBCAT_MINLEVEL" => $minlevel,
			"SUBCAT_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="sid" value="'.$result2['cat_subid'].'"><input type="hidden" name="id" value="'.$result2['cat_id'].'"><input type="hidden" name="subid" value="'.$result2['cat_subid'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
		));
		$tpl->parse('MAIN.CATS_ROW.SUBCATS_ROW');
	}
	$tpl->parse('MAIN.CATS_ROW');
}
$minlevel = '<select name="cat_minlevel">';
for ($i=0; $i<21; $i++){
	if($i == 0){
		$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$minlevel .= '</select>';
$tpl->assign(array(
	"NEW_ADD_TEXT" => $L['qs_addcat'],
	"NEW_ID" => '<input type="text" size="1" name="cat_id">',
	"NEW_SUBID" => '<input type="text" size="1" name="cat_subid">',
	"NEW_TITLE" => '<input type="text" size="20" name="cat_title">',
	"NEW_ST" => '<input type="text" size="8" name="cat_st">',
	"NEW_ICO" => '<input type="text" size="8" name="cat_ico">',
	"NEW_MINLEVEL" => $minlevel,
	"NEW_SEND" => '<input type="hidden" name="a" value="new"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
));

?>