<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'articles')){
	qs_redirect(107);
}

$loc = 'edit_article';
$title = $T['article.edit'];

$a = $_POST['a'];
$id = $_GET['id'];
if(empty($id)){
	$id = $_POST['id'];
}
$page = $_POST['page'];
if($a == 'add'){
	$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."' ORDER BY article_page DESC");
	$result = mysql_fetch_array($sql);
	$page = $result['article_page']+1;
	if(mysql_num_rows(mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."'"))>0){
		$text = $_POST['text'];
		if(mysql_query("INSERT INTO ".$qs_db['articles']."(article_id, article_page, article_text) VALUES('".$id."', '".$page."', '".$text."')")){
			$action_text = $L['qs_done'];
		}
	}
}
elseif($a == 'edit'){
	$del = $_POST['del'];
	if(!empty($del)){
		if($page == '1'){
			$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."'");
			$result = mysql_fetch_array($sql);
			if(mysql_query("DELETE FROM ".$qs_db['articles']." WHERE article_id='".$id."'")){
				if(file_exists($result['article_avatar'])){
					unlink($result['article_avatar']);
				}
				mysql_query("DELETE FROM ".$qs_db['comments']." WHERE comment_cat='2' AND comment_pageid='".$id."'");
				qs_redirect(400, 'admin.php');
			}
		}
		else {
			if(mysql_query("DELETE FROM ".$qs_db['articles']." WHERE article_id='".$id."' AND article_page='".$page."'")){
				$action_text = $L['qs_done'];
			}
		}
	}
	else {
		if($page == '1'){
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
			$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."' AND article_page='1'");
			$result = mysql_fetch_array($sql);
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
					$avatar = $result['article_avatar'];
				}
				else{
					if(file_exists($result['article_avatar'])){
						unlink($result['article_avatar']);
					}
					$img = $id.'_article';
					$ext = strtolower(strrchr($avatar["name"], '.'));
					$dest = 'includes/images/articles/'.$img.$ext;
					move_uploaded_file($avatar["tmp_name"], $dest);
					$avatar = $dest;
					chmod($dest, 0755);
				}	
			}
			else {
				$avatar = $result['article_avatar'];
			}
			if(mysql_query("UPDATE ".$qs_db['articles']." SET article_title='".$title."', article_text='".$text."', article_cat='".$cat."', article_avatar='".$avatar."', article_date='".$date."' WHERE article_id='".$id."' AND article_page='1'")){
				$action_text = $L['qs_done'];
			}
		}
		else {
			$pagenum = $_POST['pagenum'];
			$text = $_POST['text'];
			if(mysql_query("UPDATE ".$qs_db['articles']." SET article_text='".$text."', article_page='".$pagenum."' WHERE article_id='".$id."' AND article_page='".$page."'")){
				$action_text = $L['qs_done'];
			}
		}
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."' AND article_page='1'");
if(mysql_num_rows($sql)<1){
	qs_redirect(900);
}
$result = mysql_fetch_array($sql);
$date = qs_userdate($result['article_date'], $user['timezone']);


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

$sql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='2' AND cat_subid<>'1' ORDER BY cat_subid");
$cat = '<select name="cat">';
while ($result2 = mysql_fetch_array($sql2)) {
	if($result2['cat_st'] == $result['article_cat']){
		$cat .= '<option value="'.$result2['cat_st'].'" selected>'.$result2['cat_title'].'</option>';
	}
	else {
		$cat .= '<option value="'.$result2['cat_st'].'">'.$result2['cat_title'].'</option>';
	}
}
$cat .= '</select>';
	
$date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/article.edit'));

$tpl->assign(array(
	"TEXT_ADDPAGE" => $L['qs_addpage'],
	"TEXT_PAGE" => $L['qs_page'],
	"ARTICLE_TEXT_DELETE" => $L['qs_deleteart'],
	"ARTICLE_FORM_DELETE" => '<input type="checkbox" name="del" value="ON">',
	"ARTICLE_TEXT_ACTION" => $action_text,
	"ARTICLE_TEXT_TITLE" => $L['qs_title'],
	"ARTICLE_FORM_TITLE" => '<input type="text" name="title" value="'.$result['article_title'].'">',
	"ARTICLE_TEXT_TEXT" => $L['qs_content'],
	"ARTICLE_FORM_TEXT" => '<textarea rows="25" name="text" cols="60">'.$result['article_text'].'</textarea>',
	"ARTICLE_TEXT_CAT" => $L['qs_category'],
	"ARTICLE_FORM_CAT" => $cat,
	"ARTICLE_TEXT_AVATAR" => $L['qs_picture'],
	"ARTICLE_FORM_AVATAR" => '<img src="'.$result['article_avatar'].'"><br><input type="file" name="avatar" class="file">',
	"ARTICLE_TEXT_DATE" => $L['qs_date'],
	"ARTICLE_FORM_DATE" => $date,
	"ARTICLE_FORM_SEND" => '<input type="hidden" name="a" value="edit"><input type="hidden" name="id" value="'.$result['article_id'].'"><input type="hidden" name="page" value="1"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
	"ADD_TEXT_TEXT" => $L['qs_content'],
	"ADD_FORM_TEXT" => '<textarea rows="25" name="text" cols="60"></textarea>',
	"ADD_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="id" value="'.$result['article_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_add'].'">',
));

$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_id='".$id."' AND article_page<>'1' ORDER BY article_page");
if(mysql_num_rows($sql)>0){
while($result = mysql_fetch_array($sql)){
	$tpl->assign(array(	
		"PAGE_NUM_PAGE" => $result['article_page'],
		"PAGE_TEXT_DELETE" => $L['qs_deletepage'],
		"PAGE_FORM_DELETE" => '<input type="checkbox" name="del" value="ON">',
		"PAGE_TEXT_PAGE" => $L['qs_pagenum'],
		"PAGE_FORM_PAGE" => '<input type="text" name="pagenum" value="'.$result['article_page'].'">',
		"PAGE_TEXT_TEXT" => $L['qs_content'],
		"PAGE_FORM_TEXT" => '<textarea rows="25" name="text" cols="60">'.$result['article_text'].'</textarea>',
		"PAGE_FORM_SEND" => '<input type="hidden" name="a" value="edit"><input type="hidden" name="id" value="'.$result['article_id'].'"><input type="hidden" name="page" value="'.$result['article_page'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_change'].'">',
	));
	$tpl->parse('MAIN.ARTICLE_PAGES');
}
}

?>