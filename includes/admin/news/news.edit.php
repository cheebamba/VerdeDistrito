<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'news')){
	qs_redirect(107);
}

$loc = 'edit_news';
$title = $T['news.edit'];

$id = $_GET['id'];

$a = $_POST['a'];
if($a == 'update'){
	$del = $_POST['del'];
	if(!empty($del)){
		if(mysql_query("DELETE FROM ".$qs_db['news']." WHERE news_id='".$id."'")){
			mysql_query("DELETE FROM ".$qs_db['comments']." WHERE comment_cat='1' AND comment_pageid='".$id."'");
			qs_redirect(132, 'admin.php');
		}
	}
	$ptitle = $_POST['title'];
	$ptext1 = $_POST['text1'];
	$ptext2 = $_POST['text2'];
	$pminlevel = $_POST['minlevel'];
	$pcat = $_POST['cat'];
	$pyear = $_POST['year'];
	$pmonth = $_POST['month'];
	$pday = $_POST['day'];
	$phour = $_POST['hour'];
	$pminute = $_POST['minute'];
	$psecond = $_POST['second'];
	$pdate = qs_userdate($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second,-$user['timezone']);
	$pdate = $pdate['y'].'-'.$pdate['m'].'-'.$pdate['d'].' '.$pdate['h'].':'.$pdate['i'].':'.$pdate['s'];
	
	if(qs_isgoodlength($ptext1, 1, 0) && qs_isgoodlength($ptitle, 1, 64)){
		if(mysql_query("UPDATE ".$qs_db['news']." SET news_title='".$ptitle."', news_text='".$ptext1."', news_text2='".$ptext2."', news_minlevel='".$pminlevel."', news_cat='".$pcat."', news_date='".$pdate."' WHERE news_id='".$id."'")){
			qs_redirect(131, 'admin.php');
		}
		else {
			qs_redirect(800, 'admin.php?s=editnews');
		}
	}
	else {
		$news_error = $L['qs_newswronglen'];
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_id='".$id."'");
$result = mysql_fetch_array($sql);

if(mysql_num_rows($sql)<1){
	qs_redirect(900, 'admin.php');
}

$date = qs_userdate($result['news_date'], $user['timezone']);

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

$minlevel = '<select name="minlevel">';
for ($i=0; $i<21; $i++){
	if($i == $result['news_minlevel']){
		$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$minlevel .= '</select>';

$sql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='1' AND cat_subid<>'1' ORDER BY cat_subid");
$cat = '<select name="cat">';
while ($result2 = mysql_fetch_array($sql2)) {
	if($result2['cat_st'] == $result['news_cat']){
		$cat .= '<option value="'.$result2['cat_st'].'" selected>'.$result2['cat_title'].'</option>';
	}
	else {
		$cat .= '<option value="'.$result2['cat_st'].'">'.$result2['cat_title'].'</option>';
	}
}
$cat .= '</select>';

	
$date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/news.edit'));

$tpl->assign(array(
	"EDIT_FORM_FORM" => '<form method="POST" action="admin.php?s=editnews&id='.$result['news_id'].'">',
	"EDIT_FORM_ERROR" => $news_error,
	"EDIT_FORM_TITLE" => '<input type="text" name="title" value="'.$result['news_title'].'">',
	"EDIT_TEXT_TITLE" => $L['qs_title'],
	"EDIT_FORM_TEXT1" => '<textarea rows="25" name="text1" cols="60">'.qs_stripslashes($result['news_text']).'</textarea>',
	"EDIT_TEXT_TEXT1" => $L['qs_text1'],
	"EDIT_FORM_TEXT2" => '<textarea rows="25" name="text2" cols="60">'.$result['news_text2'].'</textarea>',
	"EDIT_TEXT_TEXT2" => $L['qs_text2'],
	"EDIT_FORM_MINLEVEL" => $minlevel,
	"EDIT_TEXT_MINLEVEL" => $L['qs_minlevel'],
	"EDIT_FORM_CAT" => $cat,
	"EDIT_TEXT_CAT" => $L['qs_category'],¹
	"EDIT_FORM_DATE" => $date,
	"EDIT_TEXT_DATE" => $L['qs_date'],
	"EDIT_FORM_DEL" => '<input type="checkbox" name="del" value="ON">',
	"EDIT_TEXT_DEL" => $L['qs_delete'],
	"EDIT_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
));

?>