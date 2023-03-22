<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'wars')){
	qs_redirect(107);
}

$loc = 'war.edit';
$title = $T['war.edit'];

$id = $_GET['id'];
if(empty($id)){
	$id = $_POST['id'];
}

$a = $_POST['a'];
if($a == 'update'){
	$del = $_POST['del'];
	if($del == 'ON'){
		if(mysql_query("DELETE FROM ".$qs_db['wars']." WHERE war_id='".$id."'")){
			mysql_query("DELETE FROM ".$qs_db['comments']." WHERE comment_cat='3' AND comment_pageid='".$id."'");
			qs_redirect(400, 'admin.php');
		}
	}
	$pdiv = $_POST['div'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$hour = $_POST['hour'];
	$minute = $_POST['minute'];
	$second = $_POST['second'];
	$pdate = qs_userdate($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second,-$user['timezone']);
	$pdate = $pdate['y'].'-'.$pdate['m'].'-'.$pdate['d'].' '.$pdate['h'].':'.$pdate['i'].':'.$pdate['s'];
	$pmap1 = $_POST['map1'];
	$pmap2 = $_POST['map2'];
	$ptv = $_POST['tv'];
	$psb = $_POST['sb'];
	$plcountry = $_POST['lcountry'];
	$plst = $_POST['lst'];
	$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='4' AND cat_st='".$lst."'");
	$result = mysql_fetch_array($sql);
	$pltitle = $result['cat_title'];
	$popp = $_POST['opp'];
	$pucountry = $_POST['ucountry'];
	$pocountry = $_POST['ocountry'];
	$pur = $_POST['ur'];
	$por = $_POST['or'];
	$pus = $_POST['us'];
	$pos = $_POST['os'];
	$pavatar = $_POST['avatar'];
	$ptext = $_POST['text'];
	if(mysql_query("UPDATE ".$qs_db['wars']." SET war_div='".$pdiv."', war_date='".$pdate."', war_map1='".$pmap1."', war_map2='".$pmap2."', war_tv='".$ptv."', war_sb='".$psb."', war_lcountry='".$plcountry."', war_lst='".$plst."', war_ltitle='".$pltitle."', war_opp='".$popp."', war_ucountry='".$pucountry."', war_ocountry='".$pocountry."', war_ur='".$pur."', war_or='".$por."', war_us='".$pus."', war_os='".$pos."', war_avatar='".$pavatar."', war_text='".$ptext."' WHERE war_id='".$id."'")){
		qs_redirect(400, 'admin.php');
	}
}

$sql9 = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE war_id='".$id."'");
$result9 = mysql_fetch_array($sql9);
$date = qs_userdate($result9['war_date'], $user['timezone']);

$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='5' AND cat_subid<>'1'");

$div = '<select name="div">';
while ($result = mysql_fetch_array($sql)) {
	$selected = ($result['cat_st'] == $result9['war_div']) ? 'selected' : '';
	$div .= '<option value="'.$result['cat_st'].'" '.$selected.'>'.$result['cat_title'].'</option>';
}
$div .= '</select>';

	$day = '<select name="day">';
	for ($i=1; $i<10; $i++){
		if($i == $date["d"]){
			$day .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$day .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<32; $i++){
		if($i == $date["d"]){
			$day .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$day .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$day .= '</select>';
	
	$month = '<select name="month">';
	foreach ($months as $key => $value){
		if(strlen($key)<2){
			if($key == $date["m"]){
				$month .= '<option value="0'.$key.'" selected>'.$value.'</option>';
			}
			else {
				$month .= '<option value="0'.$key.'">'.$value.'</option>';
			}
		}
		else {
			if($key == $date["m"]){
				$month .= '<option value="'.$key.'" selected>'.$value.'</option>';
			}
			else {
				$month .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
	}
	$month .= '</select>';
	$year = '<select name="year">';
	for ($i=1900; $i<gmdate("Y")+1; $i++){
		if($i == $date["y"]){
			$year .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$year .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$year .= '</select>';
	$hour = '<select name="hour">';
	for ($i=1; $i<10; $i++){
		if($i == $date["h"]){
			$hour .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$hour .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<25; $i++){
		if($i == $date["h"]){
			$hour .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$hour .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$hour .= '</select>';
	$minute = '<select name="minute">';
	for ($i=0; $i<10; $i++){
		if($i == $date["i"]){
			$minute .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$minute .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<60; $i++){
		if($i == $date["i"]){
			$minute .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$minute .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$minute .= '</select>';
	$second = '<select name="second">';
	for ($i=0; $i<10; $i++){
		if($i == $date["s"]){
			$second .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$second .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<60; $i++){
		if($i == $date["s"]){
			$second .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$second .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$second .= '</select>';
	
$date = $hour.':'.$minute.':'.$second.' '.$year.'-'.$month.'-'.$day;

$lcountry = '<select name="lcountry">';
foreach ($F as $st => $name){
	if($st == $result9['war_lcountry']){
		$lcountry .= '<option value="'.$st.'" selected>'.$name.'</option>';
	}
	else{
		$lcountry .= '<option value="'.$st.'">'.$name.'</option>';
	}
}
$lcountry .= '</select>';

$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='4' AND cat_subid<>'1'");
$lst = '<select name="lst">';
while ($result = mysql_fetch_array($sql)) {
	$selected = ($result['cat_st'] == $result9['war_lst']) ? 'selected' : '';
	$lst .= '<option value="'.$result['cat_st'].'" '.$selected.'>'.$result['cat_title'].'</option>';
}
$lst .= '</select>';

$ocountry = '<select name="ocountry">';
foreach ($F as $st => $name){
	if($st == $result9['war_ocountry']){
		$ocountry .= '<option value="'.$st.'" selected>'.$name.'</option>';
	}
	else{
		$ocountry .= '<option value="'.$st.'">'.$name.'</option>';
	}
}
$ocountry .= '</select>';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/war.edit'));

$tpl->assign(array(
	"WAR_TEXT_DIV" => $L['qs_div'],
	"WAR_FORM_DIV" => $div,
	"WAR_TEXT_DATE" => $L['qs_date'],
	"WAR_FORM_DATE" => $date,
	"WAR_TEXT_MAP1" => $L['qs_map1'],
	"WAR_FORM_MAP1" => '<input type="text" name="map1" value="'.$result9['war_map1'].'">',
	"WAR_TEXT_MAP2" => $L['qs_map2'],
	"WAR_FORM_MAP2" => '<input type="text" name="map2" value="'.$result9['war_map2'].'">',
	"WAR_TEXT_TV" => $L['qs_tva'],
	"WAR_FORM_TV" => '<input type="text" name="tv" value="'.$result9['war_tv'].'">',
	"WAR_TEXT_SB" => $L['qs_sb'],
	"WAR_FORM_SB" => '<input type="text" name="sb" value="'.$result9['war_sb'].'">',
	"WAR_TEXT_LCOUNTRY" => $L['qs_lcountry'],
	"WAR_FORM_LCOUNTRY" => $lcountry,
	"WAR_TEXT_LST" => $L['qs_leev'],
	"WAR_FORM_LST" => $lst,
	"WAR_TEXT_OPP" => $L['qs_opp'],
	"WAR_FORM_OPP" => '<input type="text" name="opp" value="'.$result9['war_opp'].'">',
	"WAR_TEXT_OCOUNTRY" => $L['qs_ocountry'],
	"WAR_FORM_OCOUNTRY" => $ocountry,
	"WAR_TEXT_AVATAR" => $L['qs_opplogo'],
	"WAR_FORM_AVATAR" => '<input type="text" name="avatar" value="'.$result9['war_avatar'].'">',
	"WAR_TEXT_RESULT" => $L['qs_result'],
	"WAR_FORM_RESULT" => '<input type="text" size="2" name="ur" value="'.$result9['war_ur'].'"> : <input type="text" size="2" name="or" value="'.$result9['war_or'].'">',
	"WAR_TEXT_US" => $L['qs_usquad'],
	"WAR_FORM_US" => '<textarea rows="5" name="us" cols="20">'.$result9['war_us'].'</textarea>',
	"WAR_TEXT_OS" => $L['qs_osquad'],
	"WAR_FORM_OS" => '<textarea rows="5" name="os" cols="20">'.$result9['war_os'].'</textarea>',
	"WAR_TEXT_TEXT" => $L['qs_des'],
	"WAR_FORM_TEXT" => '<textarea rows="5" name="text" cols="45">'.$result9['war_text'].'</textarea>',
	"WAR_TEXT_DEL" => $L['qs_delete'],
	"WAR_FORM_DEL" => '<input type="checkbox" name="del" value="ON">',
	"WAR_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$id.'"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
));

?>