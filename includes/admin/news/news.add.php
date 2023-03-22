<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'news')){
	qs_redirect(107);
}

$loc = 'add_news';
$title = $T['news.add'];

$a = $_POST['a'];
if($a == 'add'){
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
		if(mysql_query("INSERT INTO ".$qs_db['news']."(news_title, news_text, news_text2, news_minlevel, news_cat, news_date, news_ownerid) VALUES('".$ptitle."', '".$ptext1."', '".$ptext2."', '".$pminlevel."', '".$pcat."', '".$pdate."', '".$user['id']."')")){
			qs_redirect(130, 'admin.php');
		}
		else {
			qs_redirect(800, 'admin.php?s=news');
		}
	}
	else {
		$news_error = $L['qs_newswronglen'];
	}
}
if(empty($a)){
	$a = $_GET['a'];
}
if($a == 'wd'){
	$id = $_GET['id'];
	if($user['level']>18){
		mysql_query("UPDATE ".$qs_db['news']." SET news_status='0' WHERE news_id='".$id."'");
		qs_redirect(400);
	}
}

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
		if($i == gmdate("H")){
			$hour .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$hour .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<25; $i++){
		if($i == gmdate("H")){
			$hour .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$hour .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$hour .= '</select>';
	$minute = '<select name="minute">';
	for ($i=0; $i<10; $i++){
		if($i == gmdate("i")){
			$minute .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$minute .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<60; $i++){
		if($i == gmdate("i")){
			$minute .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$minute .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$minute .= '</select>';
	$second = '<select name="second">';
	for ($i=0; $i<10; $i++){
		if($i == gmdate("s")){
			$second .= '<option value="0'.$i.'" selected>0'.$i.'</option>';
		}
		else {
			$second .= '<option value="0'.$i.'">0'.$i.'</option>';
		}
	}
	for ($i=10; $i<60; $i++){
		if($i == gmdate("s")){
			$second .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else {
			$second .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$second .= '</select>';

$minlevel = '<select name="minlevel">';
for ($i=0; $i<21; $i++){
	if($i == 0){
		$minlevel .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$minlevel .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$minlevel .= '</select>';

$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='1' AND cat_subid<>'1' ORDER BY cat_subid");
$cat = '<select name="cat">';
while ($result = mysql_fetch_array($sql)) {
	$i = 0;
	if($i == 0){
		$cat .= '<option value="'.$result['cat_st'].'" selected>'.$result['cat_title'].'</option>';
	}
	else {
		$cat .= '<option value="'.$result['cat_st'].'">'.$result['cat_title'].'</option>';
	}
	$i++;
}
$cat .= '</select>';
$i = "";

	
$date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;

$bbform = 'news';
$bbinput = 'text1';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/news.add'));

$tpl->assign(array(
	"NEWS_FORM_ERROR" => $news_error,
	"NEWS_FORM_TITLE" => '<input type="text" name="title" value="'.$ptitle.'">',
	"NEWS_TEXT_TITLE" => $L['qs_title'],
	"NEWS_FORM_TEXT1" => '<textarea rows="25" name="text1" cols="60">'.$ptext1.'</textarea>',
	"NEWS_TEXT_TEXT1" => $L['qs_text1'],
	"NEWS_FORM_TEXT2" => '<textarea rows="25" name="text2" cols="60">'.$ptext2.'</textarea>',
	"NEWS_TEXT_TEXT2" => $L['qs_text2'],
	"NEWS_FORM_BBCODE" => qs_bbcbox(),
	"NEWS_FORM_MINLEVEL" => $minlevel,
	"NEWS_TEXT_MINLEVEL" => $L['qs_minlevel'],
	"NEWS_FORM_CAT" => $cat,
	"NEWS_TEXT_CAT" => $L['qs_category'],
	"NEWS_FORM_DATE" => $date,
	"NEWS_TEXT_DATE" => $L['qs_date'],
	"NEWS_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
));

?>