<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$id = $_GET['id'];
$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$id."'");
$result = mysql_fetch_array($sql);

$loc = 'users';
$title = $result['user_nick'];

if(mysql_num_rows($sql)<1){
	qs_redirect(113, 'index');
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('user.details'));

$birthdate = $result['user_birthdate'];
$birthdate = explode('-', $birthdate);
$bday = $birthdate[2];
$bmonth = $months[$birthdate[1]];
$byear = $birthdate[0];

$genders = array(
	0 => $L['qs_gender_unknown'],
	1 => $L['qs_gender_male'],
	2 => $L['qs_gender_female']
);

$rdate = qs_userdate($result['user_regdate'], $user['timezone']);

$member = ($result['user_member'] == '1') ? '<img src="includes/images/icons/member.gif" alt="'.$L['qs_member'].'">' : '';

$af = 0;
$aft = $birthdate[1].$birthdate[2];
if(gmdate("md")>=$aft){
	$af = 1;
}

$gg = (qs_stripslashes($result['user_gg']) == 0) ? '' : qs_stripslashes($result['user_gg']);

$userd = array(
	id => $result['user_id'],
	nick  => $result['user_nick'],
	name => qs_stripslashes($result['user_name']),
	level => $result['user_level'],
	surname => qs_stripslashes($result['user_surname']),
	country => $F[$result['user_country']],
	flag => '<img src="includes/images/flags/'.$result['user_country'].'.gif" alt="'.$F[$result['user_country']].'">',
	oflag => '<img src="includes/images/flags/'.$result['user_origin'].'.gif" alt="'.$F[$result['user_origin']].'">',
	text => qs_bbcode2(qs_viewtext($result['user_text'])),
	photo => (!file_exists($result['user_photo'])) ? $L['qs_none'] : '<img src="'.$result['user_photo'].'" border="1" alt="'.$result['user_nick'].'">',
	birthdate => $bday.' '.$bmonth.' '.$byear,
	age => ((gmdate("Y")-$byear)-1)+$af,
	occupation => qs_stripslashes($result['user_occupation']),
	origin => $F[$result['user_origin']],
	location => qs_stripslashes($result['user_location']),
	regdate => $rdate['d'].'-'.$rdate['m'].'-'.$rdate['y'],
	timezone => $result['user_timezone'],
	gender => $genders[$result['user_gender']],
	gg => $gg,
	irc => qs_stripslashes($result['user_irc']),
	msn => qs_stripslashes($result['user_msn']),
	icq => qs_stripslashes($result['user_icq']),
	website => qs_stripslashes($result['user_website']),
	email => qs_stripslashes($result['user_email']),
	skin => $result['user_skin'],
	lang => $result['user_lang']
);

$hardfav = array(
	cpu => qs_stripslashes($result['user_hardcpu']),
	mb => qs_stripslashes($result['user_hardmb']),
	ram => qs_stripslashes($result['user_hardram']),
	stor => qs_stripslashes($result['user_hardstor']),
	gc => qs_stripslashes($result['user_hardgc']),
	mc => qs_stripslashes($result['user_hardmc']),
	mon => qs_stripslashes($result['user_hardmon']),
	mouse => qs_stripslashes($result['user_hardmouse']),
	pad => qs_stripslashes($result['user_hardpad']),
	hp => qs_stripslashes($result['user_hardhp']),
	net => qs_stripslashes($result['user_hardnet']),
	os => qs_stripslashes($result['user_hardos']),
	res => qs_stripslashes($result['user_hardres']),
	sens => qs_stripslashes($result['user_hardsens']),
	drink => qs_stripslashes($result['user_favdrink']),
	food => qs_stripslashes($result['user_favfood']),
	book => qs_stripslashes($result['user_favbook']),
	mov => qs_stripslashes($result['user_favmov']),
	act => qs_stripslashes($result['user_favact']),
	mus => qs_stripslashes($result['user_favmus']),
	plr => qs_stripslashes($result['user_favplr']),
	ourplr => qs_stripslashes($result['user_favourplr']),
	team => qs_stripslashes($result['user_favteam']),
	hobby => qs_stripslashes($result['user_favhobby']),
	sport => qs_stripslashes($result['user_favsport']),
	game => qs_stripslashes($result['user_favgame'])
);

if($user['level']>0){
	if($user['id'] != $userd['id']){
		$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$user['id']."' AND friend_2='".$userd['id']."' AND friend_status='1'");
		if(mysql_num_rows($sql)>0){
			$friend_action = '<a href="users.php?a=friend&e=r&fid='.$userd['id'].'">'.$L['qs_delfriend'].'</a>';
		}
		else {
			$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$user['id']."' AND friend_2='".$userd['id']."'");
			if(mysql_num_rows($sql)<1){
				$friend_action = '<a href="users.php?a=friend&fid='.$userd['id'].'">'.$L['qs_addasfriend'].'</a>';
			}
		}
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$userd['id']."' AND friend_status='1' ORDER BY friend_id");
while ($result = mysql_fetch_array($sql)) {
	$friend = qs_userdata($result['friend_2']);
	$member2 = ($friend['user_member'] == '1') ? '<img src="includes/images/icons/member.gif" border="0" alt="'.$L['qs_member'].'">' : '<img src="templates/'.$defskin.'/images/spacer.gif" width="13" height="13">';
	$tpl->assign("FRIEND_ROW", '<a href="users.php?id='.$result['friend_2'].'">'.$member2.' <img border="0" src="includes/images/flags/'.$friend['user_country'].'.gif"><b> '.$friend['user_nick'].'</b></a>');
	$tpl->parse('MAIN.FRIENDS_ROW');
}

$tpl->assign(array(
	"USERD_FRIEND_ACTION" => '<br>'.$friend_action,
	"USERD_TEXT_FAV" => $L['qs_fav'],
	"USERD_TEXT_HARD" => $L['qs_hard'],
	"USERD_TEXT_DATA" => $L['qs_data'],
	"USERD_TEXT_SETTINGS" => $L['qs_websettings'],
	"USERD_TEXT_IMAGES" => $L['qs_images'],
	"USERD_TEXT_CONTACT" => $L['qs_contact'],
	"USERD_FORM_LEVEL" => qs_userlevel($userd['id']),
	"USERD_TEXT_LEVEL" => $L['qs_level'],
	"USERD_FORM_NICK" => $userd['nick'],
	"USERD_TEXT_NICK" => $L['qs_nick'],
	"USERD_FORM_MEMBER" => $member,
	"USERD_TEXT_MEMBER" => $L['qs_member'],
	"USERD_FORM_NAME" => $userd['name'],
	"USERD_TEXT_NAME" => $L['qs_name'],
	"USERD_FORM_SURNAME" => $userd['surname'],
	"USERD_TEXT_SURNAME" => $L['qs_surname'],
	"USERD_FORM_FLAG" => $userd['flag'],
	"USERD_FORM_OFLAG" => $userd['oflag'],
	"USERD_FORM_COUNTRY" => $userd['country'],
	"USERD_TEXT_COUNTRY" => $L['qs_country'],
	"USERD_FORM_ORIGIN" => $userd['origin'],
	"USERD_TEXT_ORIGIN" => $L['qs_origin'],
	"USERD_FORM_TEXT" => $userd['text'],
	"USERD_TEXT_TEXT" => $L['qs_text'],
	"USERD_FORM_PHOTO" => $userd['photo'],
	"USERD_TEXT_PHOTO" => $L['qs_photo'],
	"USERD_FORM_OCCUPATION" => $userd['occupation'],
	"USERD_TEXT_OCCUPATION" => $L['qs_occupation'],
	"USERD_FORM_LOCATION" => $userd['location'],
	"USERD_TEXT_LOCATION" => $L['qs_location'],
	"USERD_FORM_TIMEZONE" => $timezone,
	"USERD_TEXT_TIMEZONE" => $L['qs_timezone'],
	"USERD_FORM_BIRTHDATE" => $bday.' '.$bmonth.' '.$byear,
	"USERD_TEXT_BIRTHDATE" => $L['qs_birthdate'],
	"USERD_FORM_AGE" => $userd['age'],
	"USERD_TEXT_AGE" => $L['qs_age'],
	"USERD_FORM_GENDER" => $userd['gender'],
	"USERD_TEXT_GENDER" => $L['qs_gender'],
	"USERD_FORM_GG" => $userd['gg'],
	"USERD_TEXT_GG" => $L['qs_gg'],
	"USERD_FORM_IRC" => $userd['irc'],
	"USERD_TEXT_IRC" => $L['qs_irc'],
	"USERD_FORM_MSN" => $userd['msn'],
	"USERD_TEXT_MSN" => $L['qs_msn'],
	"USERD_FORM_ICQ" => $userd['icq'],
	"USERD_TEXT_ICQ" => $L['qs_icq'],
	"USERD_FORM_WEBSITE" => $userd['website'],
	"USERD_TEXT_WEBSITE" => $L['qs_website'],
	"USERD_FORM_EMAIL" => $userd['email'],
	"USERD_TEXT_EMAIL" => $L['qs_email'],
	"USERD_TEXT_HARD" => $L['qs_hardwares'],
	"USERD_TEXT_FAV" => $L['qs_favourites'],
	"USERD_FORM_CPU" => $hardfav['cpu'],
	"USERD_TEXT_CPU" => $L['qs_cpu'],
	"USERD_FORM_MB" => $hardfav['mb'],
	"USERD_TEXT_MB" => $L['qs_mb'],
	"USERD_FORM_RAM" => $hardfav['ram'],
	"USERD_TEXT_RAM" => $L['qs_ram'],
	"USERD_FORM_STOR" => $hardfav['stor'],
	"USERD_TEXT_STOR" => $L['qs_stor'],
	"USERD_FORM_GC" => $hardfav['gc'],
	"USERD_TEXT_GC" => $L['qs_gc'],
	"USERD_FORM_MC" => $hardfav['mc'],
	"USERD_TEXT_MC" => $L['qs_mc'],
	"USERD_FORM_MON" => $hardfav['mon'],
	"USERD_TEXT_MON" => $L['qs_mon'],
	"USERD_FORM_MOUSE" => $hardfav['mouse'],
	"USERD_TEXT_MOUSE" => $L['qs_mouse'],
	"USERD_FORM_PAD" => $hardfav['pad'],
	"USERD_TEXT_PAD" => $L['qs_pad'],
	"USERD_FORM_HP" => $hardfav['hp'],
	"USERD_TEXT_HP" => $L['qs_hp'],
	"USERD_FORM_NET" => $hardfav['net'],
	"USERD_TEXT_NET" => $L['qs_net'],
	"USERD_FORM_OS" => $hardfav['os'],
	"USERD_TEXT_OS" => $L['qs_os'],
	"USERD_FORM_RES" => $hardfav['res'],
	"USERD_TEXT_RES" => $L['qs_res'],
	"USERD_FORM_SENS" => $hardfav['sens'],
	"USERD_TEXT_SENS" => $L['qs_sens'],
	"USERD_FORM_DRINK" => $hardfav['drink'],
	"USERD_TEXT_DRINK" => $L['qs_drink'],
	"USERD_FORM_FOOD" => $hardfav['food'],
	"USERD_TEXT_FOOD" => $L['qs_food'],
	"USERD_FORM_BOOK" => $hardfav['book'],
	"USERD_TEXT_BOOK" => $L['qs_book'],
	"USERD_FORM_MOV" => $hardfav['mov'],
	"USERD_TEXT_MOV" => $L['qs_mov'],
	"USERD_FORM_ACT" => $hardfav['act'],
	"USERD_TEXT_ACT" => $L['qs_act'],
	"USERD_FORM_MUS" => $hardfav['mus'],
	"USERD_TEXT_MUS" => $L['qs_mus'],
	"USERD_FORM_PLR" => $hardfav['plr'],
	"USERD_TEXT_PLR" => $L['qs_plr'],
	"USERD_FORM_OURPLR" => $hardfav['ourplr'],
	"USERD_TEXT_OURPLR" => $L['qs_ourplr'],
	"USERD_FORM_TEAM" => $hardfav['team'],
	"USERD_TEXT_TEAM" => $L['qs_team'],
	"USERD_FORM_HOBBY" => $hardfav['hobby'],
	"USERD_TEXT_HOBBY" => $L['qs_hobby'],
	"USERD_FORM_SPORT" => $hardfav['sport'],
	"USERD_TEXT_SPORT" => $L['qs_sport'],
	"USERD_FORM_GAME" => $hardfav['game'],
	"USERD_TEXT_GAME" => $L['qs_game'],
	"USERD_TEXT_FRIENDS" => $L['qs_friends'],
	"USERD_FORM_SINCE" => $userd['regdate'],
	"USERD_TEXT_SINCE" => $L['qs_since'],
	"USERD_FORM_SENDPM" => '<a href="pm.php?s=new&to='.$userd['id'].'"><img border="0" src="templates/'.$defskin.'/icons/pm.gif"> '.$L['qs_newpm'].'</a>',
));

if(qs_acscheck($user['level'], 'users') && $user['level']>$userd['level']){
	$tpl->assign("USERD_FORM_EDIT", '<br><a href="users.php?a=edit&id='.$userd['id'].'">'.$L['qs_edit'].'</a>');
}

if(!empty($userd['gg'])){
	$tpl->assign("USERD_FORM_GGIMG", '&nbsp;<img border="0" src="http://status.gadu-gadu.pl/users/status.asp?id='.$userd['gg'].'&styl=1" height="13" width="13">');
}

$spacer = '<img src="templates/'.$defskin.'/images/spacer.gif" width="4">';

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>