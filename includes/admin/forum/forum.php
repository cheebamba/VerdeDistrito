<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'forums')){
	qs_redirect(107);
}

$title = $T['forum'];

$a = $_POST['a'];
if($a == 'upcat'){
	$id = $_POST['id'];
	$del = $_POST['del'];
	if(!empty($del)){
		mysql_query("DELETE FROM ".$qs_db['fcats']." WHERE cat_id='".$id."'");
	}
	else {
		$subid = $_POST['subid'];
		$title2 = qs_addslashes($_POST['title']);
		$minlevel = $_POST['minlevel'];
		if(!empty($subid)){
			mysql_query("UPDATE ".$qs_db['fcats']." SET cat_subid='".$subid."', cat_title='".$title2."', cat_minlevel='".$minlevel."' WHERE cat_id='".$id."'");
		}
	}
}
if($a == 'upsub'){
	$id = $_POST['id'];
	$del = $_POST['del'];
	if(!empty($del)){
		mysql_query("DELETE FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
	}
	else {
		$subid = $_POST['subid'];
		$catid = $_POST['catid'];
		$title2 = qs_addslashes($_POST['title']);
		$status = $_POST['status'];
		$des = $_POST['des'];
		$minlevel = $_POST['minlevel'];
		if(!empty($subid)){
			mysql_query("UPDATE ".$qs_db['fsubcats']." SET sub_subid='".$subid."', sub_catid='".$catid."', sub_status='".$status."', sub_title='".$title2."', sub_des='".$des."', sub_minlevel='".$minlevel."' WHERE sub_id='".$id."'");
		}
	}
}
elseif($a == 'addsub'){
	$subid = $_POST['subid'];
	$catid = $_POST['catid'];
	$title2 = qs_addslashes($_POST['title']);
	$des = $_POST['des'];
	$minlevel = $_POST['minlevel'];
	if(!empty($subid)){
		mysql_query("INSERT INTO ".$qs_db['fsubcats']."(sub_subid, sub_catid, sub_title, sub_des, sub_minlevel) VALUES('".$subid."', '".$catid."', '".$title2."', '".$des."', '".$minlevel."')");
	}
}
elseif($a == 'addcat'){
	$subid = $_POST['subid'];
	$title2 = qs_addslashes($_POST['title']);
	$minlevel = $_POST['minlevel'];
	if(!empty($subid)){
		mysql_query("INSERT INTO ".$qs_db['fcats']."(cat_subid, cat_title, cat_minlevel) VALUES('".$subid."', '".$title2."', '".$minlevel."')");
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/forum'));

$tpl->assign(array(
	"TEXT_DEL" => $L['qs_delete'],
	"TEXT_ID" => $L['qs_id'],
	"TEXT_SUBID" => $L['qs_subid'],
	"TEXT_TITLE" => $L['qs_cattitle'],
	"TEXT_DES" => $L['qs_des'],
	"TEXT_LOCKED" => $L['qs_stlocked'],
	"TEXT_ST" => $L['qs_st'],
	"TEXT_ICO" => $L['qs_ico'],
	"TEXT_MINLEVEL" => $L['qs_minlvl'],
	"NEWC_ADD_TEXT" => $L['qs_addcat'],
	"NEWS_ADD_TEXT" => $L['qs_addscat'],
	"TEXT_CATID" => $L['qs_catid'],
));

$sql = mysql_query("SELECT * FROM ".$qs_db['fcats']." ORDER BY cat_subid");
while($result = mysql_fetch_array($sql)){
	$minlevel = '<select name="minlevel">';
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
		"CAT_SUBID" => '<input type="text" size="1" name="subid" value="'.$result['cat_subid'].'">',
		"CAT_TITLE" => '<input type="text" name="title" value="'.qs_stripslashes($result['cat_title']).'">',
		"CAT_MINLEVEL" => $minlevel,
		"CAT_SEND" => '<input type="hidden" name="a" value="upcat"><input type="hidden" name="id" value="'.$result['cat_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
	));
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_catid='".$result['cat_id']."' ORDER BY sub_subid");
	while($result2 = mysql_fetch_array($sql2)){
		$minlevel = '<select name="minlevel">';
		for ($i=0; $i<21; $i++){
			if($i == $result2['sub_minlevel']){
				$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
			}
			else {
				$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$minlevel .= '</select>';
		$catid = '<select name="catid">';
		$sql3 = mysql_query("SELECT * FROM ".$qs_db['fcats']." ORDER BY cat_subid");
		while($result3 = mysql_fetch_array($sql3)){
			if($result3['cat_id'] == $result2['sub_catid']){
				$catid .= '<option value="'.$result3['cat_id'].'" selected>'.$result3['cat_subid'].'</option>';
			}
			else {
				$catid .= '<option value="'.$result3['cat_id'].'">'.$result3['cat_subid'].'</option>';
			}
		}
		$catid .= '</select>';
		
		if($result2['sub_status'] == '1'){
			$checked = 'checked';
		}
		else {
			$checked = '';
		}
		
		$tpl->assign(array(
			"SUB_DEL" => '<input type="checkbox" name="del" value="ON">',
			"SUB_SUBID" => '<input type="text" size="1" name="subid" value="'.$result2['sub_subid'].'">',
			"SUB_CATID" => $catid,
			"SUB_LOCKED" => '<input type="checkbox" name="status" value="1" '.$checked.'>',
			"SUB_TITLE" => '<input type="text" name="title" value="'.qs_stripslashes($result2['sub_title']).'">',
			"SUB_DES" => '<textarea rows="3" name="des" cols="35">'.$result2['sub_des'].'</textarea>',
			"SUB_MINLEVEL" => $minlevel,
			"SUB_SEND" => '<input type="hidden" name="a" value="upsub"><input type="hidden" name="id" value="'.$result2['sub_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
		));
		$tpl->parse('MAIN.CAT_ROW.SUB_ROW');
	}
	$tpl->parse('MAIN.CAT_ROW');
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

$tpl->assign(array(
	"NEWC_SUBID" => '<input type="text" size="1" name="subid">',
	"NEWC_TITLE" => '<input type="text" name="title">',
	"NEWC_MINLEVEL" => $minlevel,
	"NEWC_SEND" => '<input type="hidden" name="a" value="addcat"><input type="submit" name="send" class="submit" value="'.$L['qs_add'].'">',
));

$sql = mysql_query("SELECT * FROM ".$qs_db['fcats']." ORDER BY cat_subid");

$catid = '<select name="catid">';
$i = 0;
while($result = mysql_fetch_array($sql)){
	if($i == 0){
		$catid .= '<option value="'.$result['cat_id'].'" selected>'.$result['cat_subid'].'</option>';
	}
	else {
		$catid .= '<option value="'.$result['cat_id'].'">'.$result['cat_subid'].'</option>';
	}
	$i++;
}
$catid .= '</select>';

$tpl->assign(array(
	"NEWS_SUBID" => '<input type="text" size="1" name="subid">',
	"NEWS_CATID" => $catid,
	"NEWS_TITLE" => '<input type="text" name="title">',
	"NEWS_DES" => '<textarea rows="3" name="des" cols=35"></textarea>',
	"NEWS_MINLEVEL" => $minlevel,
	"NEWS_SEND" => '<input type="hidden" name="a" value="addsub"><input type="submit" name="send" class="submit" value="'.$L['qs_add'].'">',
));

?>