<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'team';
$title = $T['team'];

$div = $_GET['div'];
$sql = mysql_query("SELECT * FROM ".$qs_db['divs']." WHERE div_st='".$div."'");
if(mysql_num_rows($sql)<1){
	qs_redirect(900);
}
$resultdd = mysql_fetch_array($sql);
require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('team.div'));
$tpl->assign(array(
	"DIV_TITLE" => $result['div_name'],
	"DIV_IMG" => '<img src="includes/images/div/'.$resultdd['div_st'].'.gif"></div>',
));

$lsql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_userid='".$user['id']."' && member_leader='1' && member_div='".$resultdd['div_id']."'");

if(mysql_num_rows($lsql) > 0){
	$tpl->assign(array(
		"DIV_EDIT" => '<a href="admin.php?s=div&id='.$resultdd['div_id'].'">['.$L['qs_edit'].']</a>',
	));
}

$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$resultdd['div_id']."' && member_leader='1' && member_inactive='0' ORDER BY member_subid");
if(mysql_num_rows($sql)>0){
	while ($result = mysql_fetch_array($sql)) {
		$member = qs_userdata($result['member_userid']);
		$userid = $member['user_id'];
		$birthdate = $member['user_birthdate'];
		$birthdate = explode('-', $birthdate);
		$bday = $birthdate[2];
		$bmonth = $months[$birthdate[1]];
		$byear = $birthdate[0];
		
		if(file_exists('includes/images/users/'.$userid.'_member.gif')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.gif">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpg">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpeg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpeg">';
		}
		else {
			$photo = '<img src="includes/images/users/0_member.jpg">';
		}
		
		if($result['member_inactive'] == 0){
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="green">'.$L['qs_active'].'</font>';
		}
		else{
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">'.$L['qs_inactive'].'</font>';
		}

		$tpl->assign(array(
			"MEMBER_FORM_FLAG" => '<img src="includes/images/flags/'.$member['user_origin'].'.gif">',
			"MEMBER_FORM_NAME" => $member['user_name'],
			"MEMBER_FORM_SURNAME" => $member['user_surname'],
			"MEMBER_FORM_NICK" => $member['user_nick'],
			"MEMBER_FORM_PROFILE" => '<a href="users.php?id='.$member['user_id'].'">'.$L['qs_gotoprofile'].'</a>',
			"MEMBER_FORM_PHOTO" => $photo,
			"MEMBER_TEXT_BIRTHDATE" => $L['qs_birthdate'],
			"MEMBER_FORM_BIRTHDATE" => $bday.' '.$bmonth.' '.$byear,
			"MEMBER_TEXT_LOCAL" => $L['qs_location'],
			"MEMBER_FORM_LOCAL" => '<img src="includes/images/flags/'.$member['user_country'].'.gif"> '.$member['user_location'],
			"MEMBER_TEXT_SENS" => $L['qs_sens'],
			"MEMBER_FORM_SENS" => $member['user_hardsens'],
			"MEMBER_TEXT_RES" => $L['qs_res'],
			"MEMBER_FORM_RES" => $member['user_hardres'],
			"MEMBER_TEXT_MOUSE" => $L['qs_mouse'],
			"MEMBER_FORM_MOUSE" => $member['user_hardmouse'],
			"MEMBER_TEXT_PAD" => $L['qs_pad'],
			"MEMBER_FORM_PAD" => $member['user_hardpad'],
			"MEMBER_TEXT_HP" => $L['qs_hp'],
			"MEMBER_FORM_HP" => $member['user_hardhp'],
			"MEMBER_FORM_TEXT" => $active.'<br>'.$result['member_text']
		));
		$tpl->parse('MAIN.LEADER_ROW');
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$resultdd['div_id']."' && member_leader='0' && member_inactive='0' ORDER BY member_subid");
if(mysql_num_rows($sql)>0){
	while ($result = mysql_fetch_array($sql)) {
		$member = qs_userdata($result['member_userid']);
		$userid = $member['user_id'];
		$birthdate = $member['user_birthdate'];
		$birthdate = explode('-', $birthdate);
		$bday = $birthdate[2];
		$bmonth = $months[$birthdate[1]];
		$byear = $birthdate[0];
		
		if(file_exists('includes/images/users/'.$userid.'_member.gif')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.gif">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpg">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpeg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpeg">';
		}
		else {
			$photo = '<img src="includes/images/users/0_member.jpg">';
		}
		
		if($result['member_inactive'] == 0){
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="green">'.$L['qs_active'].'</font>';
		}
		else{
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">'.$L['qs_inactive'].'</font>';
		}

		$tpl->assign(array(
			"MEMBER_FORM_FLAG" => '<img src="includes/images/flags/'.$member['user_origin'].'.gif">',
			"MEMBER_FORM_NAME" => $member['user_name'],
			"MEMBER_FORM_SURNAME" => $member['user_surname'],
			"MEMBER_FORM_NICK" => $member['user_nick'],
			"MEMBER_FORM_PROFILE" => '<a href="users.php?id='.$member['user_id'].'">'.$L['qs_gotoprofile'].'</a>',
			"MEMBER_FORM_PHOTO" => $photo,
			"MEMBER_TEXT_BIRTHDATE" => $L['qs_birthdate'],
			"MEMBER_FORM_BIRTHDATE" => $bday.' '.$bmonth.' '.$byear,
			"MEMBER_TEXT_LOCAL" => $L['qs_location'],
			"MEMBER_FORM_LOCAL" => '<img src="includes/images/flags/'.$member['user_country'].'.gif"> '.$member['user_location'],
			"MEMBER_TEXT_SENS" => $L['qs_sens'],
			"MEMBER_FORM_SENS" => $member['user_hardsens'],
			"MEMBER_TEXT_RES" => $L['qs_res'],
			"MEMBER_FORM_RES" => $member['user_hardres'],
			"MEMBER_TEXT_MOUSE" => $L['qs_mouse'],
			"MEMBER_FORM_MOUSE" => $member['user_hardmouse'],
			"MEMBER_TEXT_PAD" => $L['qs_pad'],
			"MEMBER_FORM_PAD" => $member['user_hardpad'],
			"MEMBER_TEXT_HP" => $L['qs_hp'],
			"MEMBER_FORM_HP" => $member['user_hardhp'],
			"MEMBER_FORM_TEXT" => $active.'<br>'.$result['member_text']
		));
		$tpl->parse('MAIN.MEMBER_ROW');
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$resultdd['div_id']."' AND member_leader='1' AND member_inactive='1' ORDER BY member_subid");

if(mysql_num_rows($sql)>0){
	while ($result = mysql_fetch_array($sql)) {
		$member = qs_userdata($result['member_userid']);
		$userid = $member['user_id'];
		$birthdate = $member['user_birthdate'];
		$birthdate = explode('-', $birthdate);
		$bday = $birthdate[2];
		$bmonth = $months[$birthdate[1]];
		$byear = $birthdate[0];
		
		if(file_exists('includes/images/users/'.$userid.'_member.gif')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.gif">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpg">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpeg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpeg">';
		}
		else {
			$photo = '<img src="includes/images/users/0_member.jpg">';
		}
		
		if($result['member_inactive'] == 0){
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="green">'.$L['qs_active'].'</font>';
		}
		else{
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">'.$L['qs_inactive'].'</font>';
		}

		$tpl->assign(array(
			"MEMBER_FORM_FLAG" => '<img src="includes/images/flags/'.$member['user_origin'].'.gif">',
			"MEMBER_FORM_NAME" => $member['user_name'],
			"MEMBER_FORM_SURNAME" => $member['user_surname'],
			"MEMBER_FORM_NICK" => $member['user_nick'],
			"MEMBER_FORM_PROFILE" => '<a href="users.php?id='.$member['user_id'].'">'.$L['qs_gotoprofile'].'</a>',
			"MEMBER_FORM_PHOTO" => $photo,
			"MEMBER_TEXT_BIRTHDATE" => $L['qs_birthdate'],
			"MEMBER_FORM_BIRTHDATE" => $bday.' '.$bmonth.' '.$byear,
			"MEMBER_TEXT_LOCAL" => $L['qs_location'],
			"MEMBER_FORM_LOCAL" => '<img src="includes/images/flags/'.$member['user_country'].'.gif"> '.$member['user_location'],
			"MEMBER_TEXT_SENS" => $L['qs_sens'],
			"MEMBER_FORM_SENS" => $member['user_hardsens'],
			"MEMBER_TEXT_RES" => $L['qs_res'],
			"MEMBER_FORM_RES" => $member['user_hardres'],
			"MEMBER_TEXT_MOUSE" => $L['qs_mouse'],
			"MEMBER_FORM_MOUSE" => $member['user_hardmouse'],
			"MEMBER_TEXT_PAD" => $L['qs_pad'],
			"MEMBER_FORM_PAD" => $member['user_hardpad'],
			"MEMBER_TEXT_HP" => $L['qs_hp'],
			"MEMBER_FORM_HP" => $member['user_hardhp'],
			"MEMBER_FORM_TEXT" => $active.'<br>'.$result['member_text']
		));
		$tpl->parse('MAIN.LEADERINACTIVE_ROW');
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['members']." WHERE member_div='".$resultdd['div_id']."' && member_leader='0' && member_inactive='1' ORDER BY member_subid");
if(mysql_num_rows($sql)>0){
	while ($result = mysql_fetch_array($sql)) {
		$member = qs_userdata($result['member_userid']);
		$userid = $member['user_id'];
		$birthdate = $member['user_birthdate'];
		$birthdate = explode('-', $birthdate);
		$bday = $birthdate[2];
		$bmonth = $months[$birthdate[1]];
		$byear = $birthdate[0];
		
		if(file_exists('includes/images/users/'.$userid.'_member.gif')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.gif">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpg">';
		}
		elseif(file_exists('includes/images/users/'.$userid.'_member.jpeg')){
			$photo = '<img src="includes/images/users/'.$userid.'_member.jpeg">';
		}
		else {
			$photo = '<img src="includes/images/users/0_member.jpg">';
		}
		
		if($result['member_inactive'] == 0){
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="green">'.$L['qs_active'].'</font>';
		}
		else{
			$active = '&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">'.$L['qs_inactive'].'</font>';
		}

		$tpl->assign(array(
			"MEMBER_FORM_FLAG" => '<img src="includes/images/flags/'.$member['user_origin'].'.gif">',
			"MEMBER_FORM_NAME" => $member['user_name'],
			"MEMBER_FORM_SURNAME" => $member['user_surname'],
			"MEMBER_FORM_NICK" => $member['user_nick'],
			"MEMBER_FORM_PROFILE" => '<a href="users.php?id='.$member['user_id'].'">'.$L['qs_gotoprofile'].'</a>',
			"MEMBER_FORM_PHOTO" => $photo,
			"MEMBER_TEXT_BIRTHDATE" => $L['qs_birthdate'],
			"MEMBER_FORM_BIRTHDATE" => $bday.' '.$bmonth.' '.$byear,
			"MEMBER_TEXT_LOCAL" => $L['qs_location'],
			"MEMBER_FORM_LOCAL" => '<img src="includes/images/flags/'.$member['user_country'].'.gif"> '.$member['user_location'],
			"MEMBER_TEXT_SENS" => $L['qs_sens'],
			"MEMBER_FORM_SENS" => $member['user_hardsens'],
			"MEMBER_TEXT_RES" => $L['qs_res'],
			"MEMBER_FORM_RES" => $member['user_hardres'],
			"MEMBER_TEXT_MOUSE" => $L['qs_mouse'],
			"MEMBER_FORM_MOUSE" => $member['user_hardmouse'],
			"MEMBER_TEXT_PAD" => $L['qs_pad'],
			"MEMBER_FORM_PAD" => $member['user_hardpad'],
			"MEMBER_TEXT_HP" => $L['qs_hp'],
			"MEMBER_FORM_HP" => $member['user_hardhp'],
			"MEMBER_FORM_TEXT" => $active.'<br>'.$result['member_text']
		));
		$tpl->parse('MAIN.INACTIVE_ROW');
	}
}

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>