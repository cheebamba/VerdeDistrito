<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'articles')){
	qs_redirect(107);
}

$loc = 'add_article';
$title = $T['article.add'];

$a = $_POST['a'];
if($a == 'add'){
		$title = $_POST['title'];
		$cat = $_POST['cat'];
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$hour = $_POST['hour'];
		$minute = $_POST['minute'];
		$second = $_POST['second'];
		$pdate = qs_userdate($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second,-$user['timezone']);
		$date = $pdate['y'].'-'.$pdate['m'].'-'.$pdate['d'].' '.$pdate['h'].':'.$pdate['i'].':'.$pdate['s'];
		$avatar = $_FILES["avatar"];
		$text = $_POST['text'];
		$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." ORDER BY article_id DESC");
		$result = mysql_fetch_array($sql);
		$id = $result['article_id']+1;
		if(!empty($avatar["tmp_name"])){
			if($avatar["type"]=='image/jpeg' || $avatar["type"]=='image/pjpeg' || $avatar["type"]=='image/gif' || $avatar["type"]=='image/png' || $avatar["type"]=='image/x-png'){
				if($avatar["size"]>$conf['images_avatarmaxs']){
					$error = TRUE;
					$action_text .= $L['qs_avatartoobig'].'(max: '.$conf['images_avatarmaxs'].'b)<br>';
				}
				list($avatary, $avatarx) = @getimagesize($avatar["tmp_name"]);
				if($avatarx != $avatary || $avatarx>$conf['images_avatarmaxx']){
					$error = TRUE;
					$action_text .= $L['qs_avatarwrongxy'];
				}
			}
			else{
				$error = TRUE;
				$action_text .= $L['qs_avatarwrongext'];
			}
			if($error == TRUE){
				$avatar = '';
			}
			else{
				$img = $id.'_article';
				$ext = strtolower(strrchr($avatar["name"], '.'));
				$dest = 'includes/images/articles/'.$img.$ext;
				if(file_exists($dest)){
					unlink($dest);
				}
				move_uploaded_file($avatar["tmp_name"], $dest);
				$avatar = $dest;
				chmod($dest, 0755);
			}
			
		}
		if(mysql_query("INSERT INTO ".$qs_db['articles']."(article_id, article_page, article_title, article_text, article_cat, article_avatar, article_ownerid, article_date) VALUES('".$id."', '1', '".$title."', '".$text."', '".$cat."', '".$avatar."', '".$user['id']."', '".$date."')")){
			header("Location: admin.php?s=editart&id=".$id."");
		}
}
if(empty($a)){
	$a = $_GET['a'];
}
if($a == 'wd'){
	$id = $_GET['id'];
	if($user['level']>18){
		mysql_query("UPDATE ".$qs_db['articles']." SET article_status='0' WHERE article_id='".$id."' AND article_page='1'");
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

$sql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='2' AND cat_subid<>'1' ORDER BY cat_subid");
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
$i = "";
$cat .= '</select>';
	
$date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/article.add'));

$tpl->assign(array(
	"ARTICLE_TEXT_ACTION" => $action_text,
	"ARTICLE_TEXT_TITLE" => $L['qs_title'],
	"ARTICLE_FORM_TITLE" => '<input type="text" name="title">',
	"ARTICLE_TEXT_TEXT" => $L['qs_content'],
	"ARTICLE_FORM_TEXT" => '<textarea rows="25" name="text" cols="60"></textarea>',
	"ARTICLE_TEXT_CAT" => $L['qs_category'],
	"ARTICLE_FORM_CAT" => $cat,
	"ARTICLE_TEXT_AVATAR" => $L['qs_picture'],
	"ARTICLE_FORM_AVATAR" => '<input type="file" name="avatar" class="file">',
	"ARTICLE_TEXT_DATE" => $L['qs_date'],
	"ARTICLE_FORM_DATE" => $date,
	"ARTICLE_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="add" value="1"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
));

?>