<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'wars')){
	qs_redirect(107);
}

$loc = 'war.add';
$title = $T['war.add'];

$a = $_POST['a'];
if($a == 'add'){
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
	$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='4' AND cat_st='".$plst."'");
	$result = mysql_fetch_array($sql);
	$pltitle = $result['cat_title'];
	$popp = $_POST['opp'];
	$pucountry = $_POST['ucountry'];
	$pocountry = $_POST['ocountry'];
	$pur = $_POST['ur'];
	$por = $_POST['or'];
	$pus = $_POST['us'];
	$pos = $_POST['os'];
	$avatar = $_POST['avatar'];
	$text = $_POST['text'];
	if(mysql_query("INSERT INTO ".$qs_db['wars']."(war_div, war_date, war_map1, war_map2, war_tv, war_sb, war_lcountry, war_lst, war_ltitle, war_opp, war_ucountry, war_ocountry, war_ur, war_or, war_us, war_os, war_avatar, war_text) VALUES('".$pdiv."', '".$pdate."', '".$pmap1."', '".$pmap2."', '".$ptv."', '".$psb."', '".$plcountry."', '".$plst."', '".$pltitle."', '".$popp."', '".$pucountry."', '".$pocountry."', '".$pur."', '".$por."', '".$pus."', '".$pos."', '".$avatar."', '".$text."')")){
		qs_redirect(400, 'admin.php');
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='5' AND cat_subid<>'1'");

$div = '<select name="div">';
while ($result = mysql_fetch_array($sql)) {
	$selected = ($result['cat_st'] == 'cs') ? 'selected' : '';
	$div .= '<option value="'.$result['cat_st'].'" '.$selected.'>'.$result['cat_title'].'</option>';
}
$div .= '</select>';

	$day = '<select name="day">';
	for ($i=1; $i<10; $i++){
		if('0'.$i == gmdate("d")){
			$day .= '<option value="0'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$day .= '<option value="0'.$i.'">'.$i.'</option>';
		}
	}
	for ($i=10; $i<32; $i++){
		if($i == gmdate("d")){
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
			if($key == gmdate("m")){
				$month .= '<option value="0'.$key.'" selected>0'.$value.'</option>';
			}
			else {
				$month .= '<option value="0'.$key.'">0'.$value.'</option>';
			}
		}
		else {
			if($key == gmdate("m")){
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
		if($i == gmdate("Y")){
			$year .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$year .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$year .= '</select>';
	$hour = '<select name="hour">';
	for ($i=0; $i<10; $i++){
		if($i == '20'){
			$hour .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$hour .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<25; $i++){
		if($i == '20'){
			$hour .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$hour .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$hour .= '</select>';
	$minute = '<select name="minute">';
	for ($i=0; $i<10; $i++){
		if($i == '00'){
			$minute .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$minute .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<60; $i++){
		if($i == '00'){
			$minute .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$minute .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$minute .= '</select>';
	$second = '<select name="second">';
	for ($i=0; $i<10; $i++){
		if($i == '00'){
			$second .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$second .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<60; $i++){
		if($i == '00'){
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
	if($st == "pl"){
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
	$lst .= '<option value="'.$result['cat_st'].'">'.$result['cat_title'].'</option>';
}
$lst .= '</select>';

$ocountry = '<select name="ocountry">';
foreach ($F as $st => $name){
	if($st == "pl"){
		$ocountry .= '<option value="'.$st.'" selected>'.$name.'</option>';
	}
	else{
		$ocountry .= '<option value="'.$st.'">'.$name.'</option>';
	}
}
$ocountry .= '</select>';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/war.add'));

$tpl->assign(array(
	"WAR_TEXT_DIV" => $L['qs_div'],
	"WAR_FORM_DIV" => $div,
	"WAR_TEXT_DATE" => $L['qs_date'],
	"WAR_FORM_DATE" => $date,
	"WAR_TEXT_MAP1" => $L['qs_map1'],
	"WAR_FORM_MAP1" => '<input type="text" name="map1">',
	"WAR_TEXT_MAP2" => $L['qs_map2'],
	"WAR_FORM_MAP2" => '<input type="text" name="map2">',
	"WAR_TEXT_TV" => $L['qs_tva'],
	"WAR_FORM_TV" => '<input type="text" name="tv">',
	"WAR_TEXT_SB" => $L['qs_sb'],
	"WAR_FORM_SB" => '<input type="text" name="sb">',
	"WAR_TEXT_LCOUNTRY" => $L['qs_lcountry'],
	"WAR_FORM_LCOUNTRY" => $lcountry,
	"WAR_TEXT_LST" => $L['qs_leev'],
	"WAR_FORM_LST" => $lst,
	"WAR_TEXT_OPP" => $L['qs_opp'],
	"WAR_FORM_OPP" => '<input type="text" name="opp">',
	"WAR_TEXT_OCOUNTRY" => $L['qs_ocountry'],
	"WAR_FORM_OCOUNTRY" => $ocountry,
	"WAR_TEXT_AVATAR" => $L['qs_opplogo'],
	"WAR_FORM_AVATAR" => '<input type="text" name="avatar">',
	"WAR_TEXT_RESULT" => $L['qs_result'],
	"WAR_FORM_RESULT" => '<input type="text" size="2" name="ur"> : <input type="text" size="2" name="or">',
	"WAR_TEXT_US" => $L['qs_usquad'],
	"WAR_FORM_US" => '<textarea rows="5" name="us" cols="20"></textarea>',
	"WAR_TEXT_OS" => $L['qs_osquad'],
	"WAR_FORM_OS" => '<textarea rows="5" name="os" cols="20"></textarea>',
	"WAR_TEXT_TEXT" => $L['qs_des'],
	"WAR_FORM_TEXT" => '<textarea rows="5" name="text" cols="45"></textarea>',
	"WAR_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
));

?>