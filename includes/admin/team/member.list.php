<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'team';
$title = $T['team'];

$id = $_GET['id'];
if(empty($id)){
	$id = $_POST['id'];
}

$dsql = mysql_query("SELECT * FROM ".$qs_db['divs']." WHERE div_id='".$id."'");

if(mysql_num_rows($dsql) < 1){
	qs_redirect(134);
}

$dresult = mysql_fetch_array($dsql);

$lsql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_userid='".$user['id']."' && member_leader='1' && member_div='".$id."'");

if(mysql_num_rows($lsql) < 1 && !qs_acscheck($user['level'], 'team')){
	qs_redirect(107);
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/member.list'));

$a = $_POST['a'];

if($a == 'add'){
	
	$userid = $_POST['userid'];
	$div = $id;
	
	$kksql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$div."' ORDER BY member_subid DESC LIMIT 0,1");
	$kkresult = mysql_fetch_array($kksql);
	$subid = $kkresult['member_subid']+1;
	
	$leader = ($_POST['leader'] == "ON") ? '1' : '0';
	$inactive = ($_POST['inactive'] == "ON") ? '1' : '0';
	$text = $_POST['text'];
	$photo = $_FILES["photo"];
	
	// PHOTO - START
	if(!empty($photo["tmp_name"])){
		@unlink('includes/images/users/'.$userid.'_member.gif');
		@unlink('includes/images/users/'.$userid.'_member.jpg');
		@unlink('includes/images/users/'.$userid.'_member.jpeg');
		$ext = strtolower(strrchr($photo["name"], '.'));
		$dest = 'includes/images/users/'.$userid.'_member'.$ext;
		move_uploaded_file($photo["tmp_name"], $dest);
		chmod($dest, 0755);
	}
	// PHOTO - END
	
	mysql_query("INSERT INTO ".$qs_db['members']."(member_div, member_subid, member_leader, member_inactive, member_text, member_userid) VALUES('".$div."', '".$subid."', '".$leader."', '".$inactive."', '".$text."', '".$userid."')");
	
}
elseif($a == 'update'){
	$memberid = $_POST['memberid'];
	
	$del = $_POST['del'];
	
	if($del == "ON"){
		mysql_query("DELETE FROM ".$qs_db['members']." WHERE member_id='".$memberid."'");
	}
	else{
		
		$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_id='".$memberid."'");
		$result = mysql_fetch_array($sql);
		
		$userid = $_POST['userid'];
		$div = $id;
		$subid = $_POST['subid'];
		$leader = ($_POST['leader'] == 'ON') ? '1' : '0';
		$inactive = ($_POST['inactive'] == 'ON') ? '1' : '0';
		$text = $_POST['text'];
		$photo = $_FILES["photo"];
		
		if($_POST['delphoto'] == "ON"){
			@unlink('includes/images/users/'.$userid.'_member.gif');
			@unlink('includes/images/users/'.$userid.'_member.jpg');
			@unlink('includes/images/users/'.$userid.'_member.jpeg');
		}
		else{
			// PHOTO - START
			if(!empty($photo["tmp_name"])){
				@unlink('includes/images/users/'.$userid.'_member.gif');
				@unlink('includes/images/users/'.$userid.'_member.jpg');
				@unlink('includes/images/users/'.$userid.'_member.jpeg');
				$ext = strtolower(strrchr($photo["name"], '.'));
				$dest = 'includes/images/users/'.$userid.'_member'.$ext;
				move_uploaded_file($photo["tmp_name"], $dest);
				$photo = $dest;
				chmod($dest, 0755);
			}
		// PHOTO - END
		}
		
		$asssdd = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$div."' AND member_subid='".$subid."' AND member_id<>'".$memberid."'");
		if(mysql_num_rows($asssdd) > 0){
			$pksql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$div."' AND member_subid>='".$subid."' AND member_id<>'".$memberid."'");
			while($pkresult = mysql_fetch_array($pksql)){
				$newsubid = $pkresult['member_subid']+1;
				mysql_query("UPDATE ".$qs_db['members']." SET member_subid='".$newsubid."' WHERE member_id='".$pkresult['member_id']."'");
			}
		}
		
		mysql_query("UPDATE ".$qs_db['members']." SET member_div='".$div."', member_subid='".$subid."', member_leader='".$leader."', member_inactive='".$inactive."', member_text='".$text."', member_userid='".$userid."' WHERE member_id='".$memberid."'");
		
	}
}

$tpl->assign(array(
"ADD_DIV_NAME" => $dresult['div_name'],
"ADD_ADDNEW" => $L['qs_addmem'],
"ADD_ID_TEXT" => $L['qs_userid'],
"ADD_ID" => '<input type="text" size="3" name="userid">',
"ADD_LEADER_TEXT" => $L['qs_leader'],
"ADD_LEADER" => '<input type="checkbox" name="leader" value="ON">',
"ADD_INACTIVE_TEXT" => $L['qs_inactive'],
"ADD_INACTIVE" => '<input type="checkbox" name="inactive" value="ON">',
"ADD_PHOTO_TEXT" => $L['qs_photo'],
"ADD_PHOTO" => '<input type="file" name="photo" class="file">',
"ADD_TEXT_TEXT" => $L['qs_des'],
"ADD_TEXT" => '<textarea rows="5" cols="45" name="text"></textarea>',
"ADD_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="id" value="'.$id.'"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
));



$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$dresult['div_id']."' && member_leader='1' && member_inactive='0' ORDER BY member_subid");
while ($result = mysql_fetch_array($sql)) {
	$member = qs_userdata($result['member_userid']);
	
	if(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpg';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.gif')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.gif';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpeg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpeg';
	}
	else {
		$photo = 'includes/images/users/0_member.jpg';
	}
	
	if($result['member_leader'] == 1){
		$checked1 = 'checked';
	}
	else{
		$checked1 = '';
	}
	
	if($result['member_inactive'] == 1){
		$checked2 = 'checked';
	}
	else{
		$checked2 = '';
	}
	
	$tpl->assign(array(
	"MEMBER_NICK_TEXT" => $L['qs_nick'],
	"MEMBER_NICK" => '<a href="users.php?id='.$member['user_id'].'">'.$member['user_nick'].'</a>',
	"MEMBER_ID_TEXT" => $L['qs_userid'],
	"MEMBER_ID" => '<input type="text" size="3" name="userid" value="'.$member['user_id'].'">',
	"MEMBER_DIV_TEXT" => $L['qs_div'],
	"MEMBER_DIV" => $div,
	"MEMBER_SUBID_TEXT" => $L['qs_order'],
	"MEMBER_SUBID" => '<input type="text" size="3" name="subid" value="'.$result['member_subid'].'">',
	"MEMBER_LEADER_TEXT" => $L['qs_leader'],
	"MEMBER_LEADER" => '<input type="checkbox" name="leader" value="ON" '.$checked1.'>',
	"MEMBER_INACTIVE_TEXT" => $L['qs_inactive'],
	"MEMBER_INACTIVE" => '<input type="checkbox" name="inactive" value="ON" '.$checked2.'>',
	"MEMBER_PHOTO_TEXT" => $L['qs_photo'],
	"MEMBER_PHOTO_IMG" => '<img src="'.$photo.'">',
	"MEMBER_DELPHOTO_TEXT" => $L['qs_delete'],
	"MEMBER_DELPHOTO" => '<input type="checkbox" name="delphoto" value="ON">',
	"MEMBER_PHOTO" => '<input type="file" name="photo" class="file">',
	"MEMBER_TEXT_TEXT" => $L['qs_des'],
	"MEMBER_TEXT" => '<textarea rows="5" cols="45" name="text">'.$result['member_text'].'</textarea>',
	"MEMBER_DEL_TEXT" => $L['qs_delmember'],
	"MEMBER_DEL" => '<input type="checkbox" name="del" value="ON">',
	"MEMBER_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="memberid" value="'.$result['member_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
	));
	$tpl->parse('MAIN.LEADER_ROW');
}

$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$dresult['div_id']."' && member_leader='0' && member_inactive='0' ORDER BY member_subid");
while ($result = mysql_fetch_array($sql)) {
	$member = qs_userdata($result['member_userid']);
	
	if(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpg';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.gif')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.gif';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpeg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpeg';
	}
	else {
		$photo = 'includes/images/users/0_member.jpg';
	}
	
	if($result['member_leader'] == 1){
		$checked1 = 'checked';
	}
	else{
		$checked1 = '';
	}
	
	if($result['member_inactive'] == 1){
		$checked2 = 'checked';
	}
	else{
		$checked2 = '';
	}
	
	$tpl->assign(array(
	"MEMBER_NICK_TEXT" => $L['qs_nick'],
	"MEMBER_NICK" => '<a href="users.php?id='.$member['user_id'].'">'.$member['user_nick'].'</a>',
	"MEMBER_ID_TEXT" => $L['qs_userid'],
	"MEMBER_ID" => '<input type="text" size="3" name="userid" value="'.$member['user_id'].'">',
	"MEMBER_DIV_TEXT" => $L['qs_div'],
	"MEMBER_DIV" => $div,
	"MEMBER_SUBID_TEXT" => $L['qs_order'],
	"MEMBER_SUBID" => '<input type="text" size="3" name="subid" value="'.$result['member_subid'].'">',
	"MEMBER_LEADER_TEXT" => $L['qs_leader'],
	"MEMBER_LEADER" => '<input type="checkbox" name="leader" value="ON" '.$checked1.'>',
	"MEMBER_INACTIVE_TEXT" => $L['qs_inactive'],
	"MEMBER_INACTIVE" => '<input type="checkbox" name="inactive" value="ON" '.$checked2.'>',
	"MEMBER_PHOTO_TEXT" => $L['qs_photo'],
	"MEMBER_PHOTO_IMG" => '<img src="'.$photo.'">',
	"MEMBER_DELPHOTO_TEXT" => $L['qs_delete'],
	"MEMBER_DELPHOTO" => '<input type="checkbox" name="delphoto" value="ON">',
	"MEMBER_PHOTO" => '<input type="file" name="photo" class="file">',
	"MEMBER_TEXT_TEXT" => $L['qs_des'],
	"MEMBER_TEXT" => '<textarea rows="5" cols="45" name="text">'.$result['member_text'].'</textarea>',
	"MEMBER_DEL_TEXT" => $L['qs_delmember'],
	"MEMBER_DEL" => '<input type="checkbox" name="del" value="ON">',
	"MEMBER_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="memberid" value="'.$result['member_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
	));
	$tpl->parse('MAIN.LEADER_ROW');
}

$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$dresult['div_id']."' && member_leader='1' && member_inactive='1' ORDER BY member_subid");
while ($result = mysql_fetch_array($sql)) {
	$member = qs_userdata($result['member_userid']);
	
	if(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpg';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.gif')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.gif';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpeg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpeg';
	}
	else {
		$photo = 'includes/images/users/0_member.jpg';
	}
	
	if($result['member_leader'] == 1){
		$checked1 = 'checked';
	}
	else{
		$checked1 = '';
	}
	
	if($result['member_inactive'] == 1){
		$checked2 = 'checked';
	}
	else{
		$checked2 = '';
	}
	
	$tpl->assign(array(
	"MEMBER_NICK_TEXT" => $L['qs_nick'],
	"MEMBER_NICK" => '<a href="users.php?id='.$member['user_id'].'">'.$member['user_nick'].'</a>',
	"MEMBER_ID_TEXT" => $L['qs_userid'],
	"MEMBER_ID" => '<input type="text" size="3" name="userid" value="'.$member['user_id'].'">',
	"MEMBER_DIV_TEXT" => $L['qs_div'],
	"MEMBER_DIV" => $div,
	"MEMBER_SUBID_TEXT" => $L['qs_order'],
	"MEMBER_SUBID" => '<input type="text" size="3" name="subid" value="'.$result['member_subid'].'">',
	"MEMBER_LEADER_TEXT" => $L['qs_leader'],
	"MEMBER_LEADER" => '<input type="checkbox" name="leader" value="ON" '.$checked1.'>',
	"MEMBER_INACTIVE_TEXT" => $L['qs_inactive'],
	"MEMBER_INACTIVE" => '<input type="checkbox" name="inactive" value="ON" '.$checked2.'>',
	"MEMBER_PHOTO_TEXT" => $L['qs_photo'],
	"MEMBER_PHOTO_IMG" => '<img src="'.$photo.'">',
	"MEMBER_DELPHOTO_TEXT" => $L['qs_delete'],
	"MEMBER_DELPHOTO" => '<input type="checkbox" name="delphoto" value="ON">',
	"MEMBER_PHOTO" => '<input type="file" name="photo" class="file">',
	"MEMBER_TEXT_TEXT" => $L['qs_des'],
	"MEMBER_TEXT" => '<textarea rows="5" cols="45" name="text">'.$result['member_text'].'</textarea>',
	"MEMBER_DEL_TEXT" => $L['qs_delmember'],
	"MEMBER_DEL" => '<input type="checkbox" name="del" value="ON">',
	"MEMBER_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="memberid" value="'.$result['member_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
	));
	$tpl->parse('MAIN.LEADER_ROW');
}

$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$dresult['div_id']."' && member_leader='0' && member_inactive='1' ORDER BY member_subid");
while ($result = mysql_fetch_array($sql)) {
	$member = qs_userdata($result['member_userid']);
	
	if(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpg';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.gif')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.gif';
	}
	elseif(file_exists('includes/images/users/'.$result['member_userid'].'_member.jpeg')){
		$photo = 'includes/images/users/'.$result['member_userid'].'_member.jpeg';
	}
	else {
		$photo = 'includes/images/users/0_member.jpg';
	}
	
	if($result['member_leader'] == 1){
		$checked1 = 'checked';
	}
	else{
		$checked1 = '';
	}
	
	if($result['member_inactive'] == 1){
		$checked2 = 'checked';
	}
	else{
		$checked2 = '';
	}
	
	$tpl->assign(array(
	"MEMBER_NICK_TEXT" => $L['qs_nick'],
	"MEMBER_NICK" => '<a href="users.php?id='.$member['user_id'].'">'.$member['user_nick'].'</a>',
	"MEMBER_ID_TEXT" => $L['qs_userid'],
	"MEMBER_ID" => '<input type="text" size="3" name="userid" value="'.$member['user_id'].'">',
	"MEMBER_DIV_TEXT" => $L['qs_div'],
	"MEMBER_DIV" => $div,
	"MEMBER_SUBID_TEXT" => $L['qs_order'],
	"MEMBER_SUBID" => '<input type="text" size="3" name="subid" value="'.$result['member_subid'].'">',
	"MEMBER_LEADER_TEXT" => $L['qs_leader'],
	"MEMBER_LEADER" => '<input type="checkbox" name="leader" value="ON" '.$checked1.'>',
	"MEMBER_INACTIVE_TEXT" => $L['qs_inactive'],
	"MEMBER_INACTIVE" => '<input type="checkbox" name="inactive" value="ON" '.$checked2.'>',
	"MEMBER_PHOTO_TEXT" => $L['qs_photo'],
	"MEMBER_PHOTO_IMG" => '<img src="'.$photo.'">',
	"MEMBER_DELPHOTO_TEXT" => $L['qs_delete'],
	"MEMBER_DELPHOTO" => '<input type="checkbox" name="delphoto" value="ON">',
	"MEMBER_PHOTO" => '<input type="file" name="photo" class="file">',
	"MEMBER_TEXT_TEXT" => $L['qs_des'],
	"MEMBER_TEXT" => '<textarea rows="5" cols="45" name="text">'.$result['member_text'].'</textarea>',
	"MEMBER_DEL_TEXT" => $L['qs_delmember'],
	"MEMBER_DEL" => '<input type="checkbox" name="del" value="ON">',
	"MEMBER_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="memberid" value="'.$result['member_id'].'"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
	));
	$tpl->parse('MAIN.LEADER_ROW');
}


?>