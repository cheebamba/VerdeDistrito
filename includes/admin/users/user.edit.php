<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$permission = qs_acscheck($user['level'], 'users');

$userdd['id'] = $_GET['id'];
if($permission){
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'");
	$result = mysql_fetch_array($sql);
	if($result['user_level']>=$user['level']){
		qs_redirect(114);
	}
}
else {
	qs_redirect(107);
}
if(mysql_num_rows(mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'"))<1){
	qs_redirect(113, 'admin.php');
}

$loc = 'edit_user';
$title = $L['qs_edit'].' - '.$result['user_nick'];

// UPDATE VARIABLES - START

$a = $_POST['a'];
if($a == 'update'){
	
	$userdd['id'] = $_POST['id'];
	
	$del = $_POST['del'];
	if(!empty($del)){
		if(mysql_query("DELETE FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'")){
			qs_redirect(133, 'admin.php');
		}
	}

	$active = $_POST['active'];
	if(empty($active)){
		$active = '0';
	}
	else {
		$active = '1';
	}
	$passn = $_POST['pass'];
	$member = (empty($_POST['member']) ? '0' : '1');
	$name = qs_addslashes($_POST['name']);
	$surname = qs_addslashes($_POST['surname']);
	$country = $_POST['country'];
	$text = qs_addslashes($_POST['text']);
	$avatar = $_FILES["avatar"];
	$photo = $_FILES["photo"];
	$level = $_POST['level'];
	$signature = qs_addslashes($_POST['signature']);
	$occupation = qs_addslashes($_POST['occupation']);
	$origin = $_POST['origin'];
	$location = qs_addslashes($_POST['location']);
	$timezone = $_POST['timezone'];
	$bday = $_POST['bday'];
	$bmonth = $_POST['bmonth'];
	$byear = $_POST['byear'];
	$birthdate = $byear.'-'.$bmonth.'-'.$bday;
	$gender = $_POST['gender'];
	$gg = qs_addslashes($_POST['gg']);
	$irc = qs_addslashes($_POST['irc']);
	$msn = qs_addslashes($_POST['msn']);
	$icq = qs_addslashes($_POST['icq']);
	$website = qs_addslashes($_POST['website']);
	$email = qs_addslashes($_POST['email']);
	$skin = $_POST['skin'];
	$lang = $_POST['lang'];
	
	$hardcpu = qs_addslashes($_POST['cpu']);
	$hardmb = qs_addslashes($_POST['mb']);
	$hardram = qs_addslashes($_POST['ram']);
	$hardgc = qs_addslashes($_POST['gc']);
	$hardmc = qs_addslashes($_POST['mc']);
	$hardmon = qs_addslashes($_POST['mon']);
	$hardmouse = qs_addslashes($_POST['mouse']);
	$hardpad = qs_addslashes($_POST['pad']);
	$hardhp = qs_addslashes($_POST['hp']);
	$hardnet = qs_addslashes($_POST['net']);
	$hardos = qs_addslashes($_POST['os']);
	$hardres = qs_addslashes($_POST['res']);
	$hardsens = qs_addslashes($_POST['sens']);
	$favdrink = qs_addslashes($_POST['drink']);
	$favfood = qs_addslashes($_POST['food']);
	$favbook = qs_addslashes($_POST['book']);
	$favmov = qs_addslashes($_POST['mov']);
	$favact = qs_addslashes($_POST['act']);
	$favmus = qs_addslashes($_POST['mus']);
	$favplr = qs_addslashes($_POST['plr']);
	$favourplr = qs_addslashes($_POST['ourplr']);
	$favteam = qs_addslashes($_POST['team']);
	$favhobby = qs_addslashes($_POST['hobby']);
	$favsport = qs_addslashes($_POST['sport']);
	$favgame = qs_addslashes($_POST['game']);
	
// UPDATE VARIABLES - END
	
	$edit_errortext = "";
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'");
	$result = mysql_fetch_array($sql);
	
	if($passn != ""){
		if(qs_isgoodlength($passn, 4, 32)){
			$passn = md5($passn);
		}
		else {
			$edit_error = TRUE;
			$edit_errortext .= $L['qs_wrongpasslen'].'<br>';
		}
	}
	else {
		$passn = $result['user_password'];
	}
	
	
	if($email != $result['user_email']){
		$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_email='".$email."'");
		$result = mysql_fetch_array($sql);
		
		if($email == $result['user_email']){
			$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'");
			$result = mysql_fetch_array($sql);
			$email = $result['user_email'];
			$edit_error = TRUE;
			$edit_errortext .= $L['qs_inuseemail'];
		}
		if(!qs_isemail($email)){
			$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'");
			$result = mysql_fetch_array($sql);
			$email = $result['user_email'];
			$edit_error = TRUE;
			$edit_errortext .= $L['qs_wrongemail'];
		}
	}
	
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'");
	$result = mysql_fetch_array($sql);
	
// AVATAR
	if(!empty($avatar["tmp_name"])){
		if($avatar["type"]=='image/jpeg' || $avatar["type"]=='image/pjpeg' || $avatar["type"]=='image/gif' || $avatar["type"]=='image/png' || $avatar["type"]=='image/x-png'){
			if($avatar["size"]>$conf['images_avatarmaxs']){
				$edit_error1 = TRUE;
				$edit_errortext .= $L['qs_avatartoobig'].'(max: '.$conf['images_avatarmaxs'].'b)<br>';
			}
			list($avatary, $avatarx) = @getimagesize($avatar["tmp_name"]);
			if($avatarx != $avatary || $avatarx>$conf['images_avatarmaxx']){
				$edit_error1 = TRUE;
				$edit_errortext .= $L['qs_avatarwrongxy'];
			}
		}
		else{
			$edit_error1 = TRUE;
			$edit_errortext .= $L['qs_avatarwrongext'];
		}
		if($edit_error1 == TRUE){
			$avatar = $result['user_avatar'];
		}
		else{
			if(file_exists($result['user_avatar'])){
				unlink($result['user_avatar']);
			}
			$ext = strtolower(strrchr($avatar["name"], '.'));
			$dest = 'includes/images/users/'.$userdd['id'].'_avatar'.$ext;
			move_uploaded_file($avatar["tmp_name"], $dest);
			$avatar = $dest;
			chmod($dest, 0755);
		}
		
	}
	elseif($delavatar == 'on'){
		@unlink($result['user_avatar']);
		$avatar = '';
	}
	else {
		$avatar = $result['user_avatar'];
	}
// AVATAR - END
// PHOTO - START
	if(!empty($photo["tmp_name"])){
		if($photo["type"]=='image/jpeg' || $photo["type"]=='image/pjpeg' || $photo["type"]=='image/gif' || $photo["type"]=='image/png' || $photo["type"]=='image/x-png'){
			if(getimagesize($source)>$conf['images_photomaxs']){
				$edit_error2 = TRUE;
				$edit_errortext .= $L['qs_phototoobig'];
			}
			list($photoy, $photox) = @getimagesize($photo["tmp_name"]);
			if($photoy>$conf['images_photomaxy'] || $photox>$conf['images_photomaxx']){
				$edit_error2 = TRUE;
				$edit_errortext .= $L['qs_photowrongxy'];
			}
		}
		else{
			$edit_error1 = TRUE;
			$edit_errortext .= $L['qs_avatarwrongext'];
		}
		if($profile_error1 == TRUE){
			$avatar = $result['user_avatar'];
		}
		else{
			unlink($result['user_photo']);
			$ext = strtolower(strrchr($photo["name"], '.'));
			$dest = 'includes/images/users/'.$userdd['id'].'_photo'.$ext;
			move_uploaded_file($photo["tmp_name"], $dest);
			$photo = $dest;
			chmod($dest, 0755);
		}
	}
	elseif($delphoto == 'on'){
		@unlink($result['user_photo']);
		$photo = '';
	}
	else {
		$photo = $result['user_photo'];
	}
// PHOTO - END

// SQL UPDATE
	$sql = mysql_query("UPDATE ".$qs_db['users']." SET user_active='".$active."', user_password='".$passn."', user_member='".$member."', user_name='".$name."', user_surname='".$surname."', user_level='".$level."', user_country='".$country."', user_text='".$text."', user_avatar='".$avatar."', user_photo='".$photo."', user_signature='".$signature."', user_occupation='".$occupation."', user_origin='".$origin."', user_location='".$location."', user_timezone='".$timezone."', user_birthdate='".$birthdate."', user_gender='".$gender."', user_gg='".$gg."', user_irc='".$irc."', user_msn='".$msn."', user_icq='".$icq."', user_website='".$website."', user_email='".$email."', user_skin='".$skin."', user_lang='".$lang."', user_hardcpu='".$hardcpu."', user_hardmb='".$hardmb."', user_hardram='".$hardram."', user_hardgc='".$hardgc."', user_hardmc='".$hardmc."', user_hardmon='".$hardmon."', user_hardmouse='".$hardmouse."', user_hardpad='".$hardpad."', user_hardhp='".$hardhp."', user_hardnet='".$hardnet."', user_hardos='".$hardos."', user_hardres='".$hardres."', user_hardsens='".$hardsens."', user_favdrink='".$favdrink."', user_favfood='".$favfood."', user_favbook='".$favbook."', user_favmov='".$favmov."', user_favact='".$favact."', user_favmus='".$favmus."', user_favplr='".$favplr."', user_favourplr='".$favourplr."', user_favteam='".$favteam."', user_favhobby='".$favhobby."', user_favsport='".$favsport."', user_favgame='".$favgame."' WHERE user_id='".$userdd['id']."'");
// REDIRECT
	if($edit_error1 != TRUE && $edit_error2 != TRUE && $edit_error != TRUE){
		qs_redirect(108, 'users.php');
	}

}

// FORM VARIABLES - START

$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$userdd['id']."'");
$result = mysql_fetch_array($sql);

$checked = ($result['user_active'] == '1') ? 'checked' : '';
if(qs_acscheck($user['level'], 'team')){
	$checked2 = ($result['user_member'] == '1') ? 'checked' : '';
	$member = '<input type="checkbox" class="checkbox" name="member" value="1" '.$checked2.'>';
}
else {
	if($userd['member'] == '1'){
		$member = $L['qs_yes'];
	}
	else {
		$member = $L['qs_no'];
	}
}

$birthdate = $result['user_birthdate'];
$birthdate = explode('-', $birthdate);
$userd = array(
	id => $result['user_id'],
	nick  => $result['user_nick'],
	member => $result['user_member'],
	memberimg => ($result['user_member'] == '1') ? '<img src="templates/'.$defskin.'/icons/member.gif" alt="'.$L['qs_member'].'">' : '',
	name => qs_stripslashes($result['user_name']),
	surname => qs_stripslashes($result['user_surname']),
	level => $result['user_level'],
	country => $result['user_country'],
	flag => '<img src="includes/images/flags/'.$result['user_country'].'.gif" alt="'.$userd['country'].'">',
	text => qs_stripslashes($result['user_text']),
	avatar => $result['user_avatar'],
	photo => $result['user_photo'],
	signature => qs_stripslashes($result['user_signature']),
	occupation => qs_stripslashes($result['user_occupation']),
	origin => $result['user_origin'],
	location => qs_stripslashes($result['user_location']),
	timezone => $result['user_timezone'],
	bday => $birthdate[2],
	bmonth => $birthdate[1],
	byear => $birthdate[0],
	gender => $result['user_gender'],
	gg => qs_stripslashes($result['user_gg']),
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

$countrys = '<select name="country">';
foreach ($F as $st => $name){
	if($st == $userd['country']){
		$countrys .= '<option value="'.$st.'" selected>'.$name.'</option>';
	}
	else{
		$countrys .= '<option value="'.$st.'">'.$name.'</option>';
	}
}
$countrys .= '</select>';

$ocountrys = '<select name="origin">';
foreach ($F as $st => $name){
	if($st == $userd['origin']){
		$ocountrys .= '<option value="'.$st.'" selected>'.$name.'</option>';
	}
	else{
		$ocountrys .= '<option value="'.$st.'">'.$name.'</option>';
	}
}
$ocountrys .= '</select>';

$timezones = array('-12', '-11', '-10', '-09', '-08', '-07', '-06', '-05', '-04', '-03.5', '-03', '-02', '-01', '+00', '+01', '+02', '+03', '+03.5', '+04', '+04.5', '+05', '+05.5', '+06', '+07', '+08', '+09', '+09.5', '+10', '+11', '+12');

$timezone = '<select name="timezone">';
foreach ($timezones as $key){
	if($key == $userd['timezone']){
		$timezone .= '<option value="'.$key.'" selected>GMT '.$key.'</option>';
	}
	else {
		$timezone .= '<option value="'.$key.'">GMT '.$key.'</option>';
	}
}
$timezone .= '</select>';

$day = '<select name="bday">';
for ($i=1; $i<10; $i++){
	if('0'.$i == $userd['bday']){
		$day .= '<option value="0'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$day .= '<option value="0'.$i.'">'.$i.'</option>';
	}
}
for ($i=10; $i<32; $i++){
	if($i == $userd['bday']){
		$day .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$day .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$day .= '</select>';

$month = '<select name="bmonth">';
foreach ($months as $key => $value){
	if($key == $userd['bmonth']){
		$month .= '<option value="'.$key.'" selected>'.$value.'</option>';
	}
	else {
		$month .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$month .= '</select>';
$year = '<select name="byear">';
for ($i=1900; $i<gmdate("Y")+1; $i++){
	if($i == $userd['byear']){
		$year .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$year .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$year .= '</select>';

if($userd['gender'] == 1){
	$selected1 = 'selected';
}
elseif ($userd['gender'] == 2){
	$selected2 = 'selected';
}

$skin = '<select name="skin">';
foreach ($skins as $key => $value){
	if($key == $userd['lang']){
		$skin .= '<option value="'.$key.'" selected>'.$value.'</option>';
	}
	else{
		$skin .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$skin .= '</select>';

$lang = '<select name="skin">';
foreach ($langs as $key => $value){
	if($key == $userd['lang']){
		$lang .= '<option value="'.$key.'" selected>'.$value.'</option>';
	}
	else{
		$lang .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$lang .= '</select>';

if($userd['avatar'] != ""){
	$avatar = '<img src="'.$userd['avatar'].'"><br>'.$L['qs_delete'].': <input type="checkbox" name="delavatar" values="ON"><br>';
}
else {
	$avatar = $L['qs_none'].'<br>';
}
if($userd['photo'] != ""){
	$photo = '<img src="'.$userd['photo'].'"><br>'.$L['qs_delete'].': <input type="checkbox" name="delphoto" values="ON"><br>';
}
else {
	$photo = $L['qs_none'].'<br>';
}

$sql = mysql_query("SELECT * FROM ".$qs_db['levels']." ORDER BY level_level ASC");
$levels = '<select name="level">';
while ($result = mysql_fetch_array($sql)){
	if($result['level_level']<=$user['level']){
		$levelname = (empty($result['level_name'])) ? '' : ' - '.$result['level_name'] ;
		if($result['level_level'] == $userd['level']){
			$levels .= '<option value="'.$result['level_level'].'" selected>'.$result['level_level'].$levelname.'</option>';
		}
		else {
			$levels .= '<option value="'.$result['level_level'].'">'.$result['level_level'].$levelname.'</option>';
		}
	}
}
$levels .= '</select>';

// FORM VARIABLES - END

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/user.edit'));

if(!empty($edit_errortext)){
	$tpl->assign("USERS_TEXT_ERROR", $edit_errortext);
	$tpl->parse('MAIN.USERS_ERROR');
}

$tpl->assign(array(
	"USERS_FORM" => '<form method="POST" action="users.php?a=edit&id='.$userdd['id'].'" name="profile" enctype="multipart/form-data">',
	"USERS_TEXT_ACTIVE" => $L['qs_active'],
	"USERS_FORM_ACTIVE" => '<input type="checkbox" name="active" value="ON" '.$checked.'>',
	"USERS_TEXT_FAV" => $L['qs_fav'],
	"USERS_TEXT_HARD" => $L['qs_hard'],
	"USERS_TEXT_DATA" => $L['qs_data'],
	"USERS_TEXT_SETTINGS" => $L['qs_websettings'],
	"USERS_TEXT_IMAGES" => $L['qs_images'],
	"USERS_TEXT_CONTACT" => $L['qs_contact'],
	"USERS_FORM_NICK" => $userd['nick'],
	"USERS_TEXT_NICK" => $L['qs_nick'],
	"USERS_FORM_MEMBER" => $member,
	"USERS_TEXT_MEMBER" => $L['qs_member'],
	"USERS_FORM_MEMBERIMG" => $userd['membersimg'],
	"USERS_FORM_NAME" => '<input type="text" class="input" name="name" value="'.$userd['name'].'">',
	"USERS_TEXT_NAME" => $L['qs_name'],
	"USERS_FORM_SURNAME" => '<input type="text" class="input" name="surname" value="'.$userd['surname'].'">',
	"USERS_TEXT_SURNAME" => $L['qs_surname'],
	"USERS_FORM_LEVEL" => $levels,
	"USERS_TEXT_LEVEL" => $L['qs_level'],
	"USERS_FORM_COUNTRY" => $countrys,
	"USERS_TEXT_COUNTRY" => $L['qs_country'],
	"USERD_FORM_FLAG" => $userd['flag'],
	"USERS_FORM_ORIGIN" => $ocountrys,
	"USERS_TEXT_ORIGIN" => $L['qs_origin'],
	"USERS_FORM_TEXT" => '<textarea rows="5" name="text" cols="25">'.$userd['text'].'</textarea>',
	"USERS_TEXT_TEXT" => $L['qs_text'],
	"USERS_FORM_AVATAR" => $avatar.'<input type="file" class="file" name="avatar">',
	"USERS_TEXT_AVATAR" => $L['qs_avatar'],
	"USERS_FORM_PHOTO" => $photo.'<input type="file" class="file" name="photo">',
	"USERS_TEXT_PHOTO" => $L['qs_photo'],
	"USERS_FORM_SIGNATURE" => '<textarea rows="5" name="signature" cols="25">'.$userd['signature'].'</textarea>',
	"USERS_TEXT_SIGNATURE" => $L['qs_signature'],
	"USERS_FORM_OCCUPATION" => '<input type="text" class="input" name="occupation" value="'.$userd['occupation'].'">',
	"USERS_TEXT_OCCUPATION" => $L['qs_occupation'],
	"USERS_FORM_LOCATION" => '<input type="text" class="input" name="location" value="'.$userd['location'].'">',
	"USERS_TEXT_LOCATION" => $L['qs_location'],
	"USERS_FORM_TIMEZONE" => $timezone,
	"USERS_TEXT_TIMEZONE" => $L['qs_timezone'],
	"USERS_FORM_BIRTHDATE" => $year.$month.$day,
	"USERS_TEXT_BIRTHDATE" => $L['qs_birthdate'],
	"USERS_FORM_GENDER" => '<select name="gender"><option value="0">'.$L['qs_gender_unknown'].'</option><option '.$selected1.' value="1">'.$L['qs_gender_male'].'</option><option '.$selected2.' value="2">'.$L['qs_gender_female'].'</option></select>',
	"USERS_TEXT_GENDER" => $L['qs_gender'],
	"USERS_FORM_GG" => '<input type="text" class="input" name="gg" value="'.$userd['gg'].'">',
	"USERS_TEXT_GG" => $L['qs_gg'],
	"USERS_FORM_IRC" => '<input type="text" class="input" name="irc" value="'.$userd['irc'].'">',
	"USERS_TEXT_IRC" => $L['qs_irc'],
	"USERS_FORM_MSN" => '<input type="text" class="input" name="msn" value="'.$userd['msn'].'">',
	"USERS_TEXT_MSN" => $L['qs_msn'],
	"USERS_FORM_ICQ" => '<input type="text" class="input" name="icq" value="'.$userd['icq'].'">',
	"USERS_TEXT_ICQ" => $L['qs_icq'],
	"USERS_FORM_WEBSITE" => '<input type="text" class="input" name="website" value="'.$userd['website'].'">',
	"USERS_TEXT_WEBSITE" => $L['qs_website'],
	"USERS_FORM_EMAIL" => '<input type="text" class="input" name="email" value="'.$userd['email'].'">',
	"USERS_TEXT_EMAIL" => $L['qs_email'],
	"USERS_FORM_SKIN" => $skin,
	"USERS_TEXT_SKIN" => $L['qs_skin'],
	"USERS_FORM_LANG" => $lang,
	"USERS_TEXT_LANG" => $L['qs_lang'],
	"USERS_FORM_PASS" => '<input type="password" name="pass" class="input">',
	"USERS_TEXT_PASS" => $L['qs_passn1'],
	"USERS_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="id" value="'.$userdd['id'].'"><input type="submit" class="submit" name="send" value="'.$L['qs_send'].'">',
	"USERS_FORM_CPU" => '<input type="text" name="cpu" value="'.$hardfav['cpu'].'">',
	"USERS_TEXT_CPU" => $L['qs_cpu'],
	"USERS_FORM_MB" => '<input type="text" name="mb" value="'.$hardfav['mb'].'">',
	"USERS_TEXT_MB" => $L['qs_mb'],
	"USERS_FORM_RAM" => '<input type="text" name="ram" value="'.$hardfav['ram'].'">',
	"USERS_TEXT_RAM" => $L['qs_ram'],
	"USERS_FORM_GC" => '<input type="text" name="gc" value="'.$hardfav['gc'].'">',
	"USERS_TEXT_GC" => $L['qs_gc'],
	"USERS_FORM_MC" => '<input type="text" name="mc" value="'.$hardfav['mc'].'">',
	"USERS_TEXT_MC" => $L['qs_mc'],
	"USERS_FORM_MON" => '<input type="text" name="mon" value="'.$hardfav['mon'].'">',
	"USERS_TEXT_MON" => $L['qs_mon'],
	"USERS_FORM_MOUSE" => '<input type="text" name="mouse" value="'.$hardfav['mouse'].'">',
	"USERS_TEXT_MOUSE" => $L['qs_mouse'],
	"USERS_FORM_PAD" => '<input type="text" name="pad" value="'.$hardfav['pad'].'">',
	"USERS_TEXT_PAD" => $L['qs_pad'],
	"USERS_FORM_HP" => '<input type="text" name="hp" value="'.$hardfav['hp'].'">',
	"USERS_TEXT_HP" => $L['qs_hp'],
	"USERS_FORM_NET" => '<input type="text" name="net" value="'.$hardfav['net'].'">',
	"USERS_TEXT_NET" => $L['qs_net'],
	"USERS_FORM_OS" => '<input type="text" name="os" value="'.$hardfav['os'].'">',
	"USERS_TEXT_OS" => $L['qs_os'],
	"USERS_FORM_RES" => '<input type="text" name="res" value="'.$hardfav['res'].'">',
	"USERS_TEXT_RES" => $L['qs_res'],
	"USERS_FORM_SENS" => '<input type="text" name="sens" value="'.$hardfav['sens'].'">',
	"USERS_TEXT_SENS" => $L['qs_sens'],
	"USERS_FORM_DRINK" => '<input type="text" name="drink" value="'.$hardfav['drink'].'">',
	"USERS_TEXT_DRINK" => $L['qs_drink'],
	"USERS_FORM_FOOD" => '<input type="text" name="food" value="'.$hardfav['food'].'">',
	"USERS_TEXT_FOOD" => $L['qs_food'],
	"USERS_FORM_BOOK" => '<input type="text" name="book" value="'.$hardfav['book'].'">',
	"USERS_TEXT_BOOK" => $L['qs_book'],
	"USERS_FORM_MOV" => '<input type="text" name="mov" value="'.$hardfav['mov'].'">',
	"USERS_TEXT_MOV" => $L['qs_mov'],
	"USERS_FORM_ACT" => '<input type="text" name="act" value="'.$hardfav['act'].'">',
	"USERS_TEXT_ACT" => $L['qs_act'],
	"USERS_FORM_MUS" => '<input type="text" name="mus" value="'.$hardfav['mus'].'">',
	"USERS_TEXT_MUS" => $L['qs_mus'],
	"USERS_FORM_PLR" => '<input type="text" name="plr" value="'.$hardfav['plr'].'">',
	"USERS_TEXT_PLR" => $L['qs_plr'],
	"USERS_FORM_OURPLR" => '<input type="text" name="ourplr" value="'.$hardfav['ourplr'].'">',
	"USERS_TEXT_OURPLR" => $L['qs_ourplr'],
	"USERS_FORM_TEAM" => '<input type="text" name="team" value="'.$hardfav['team'].'">',
	"USERS_TEXT_TEAM" => $L['qs_team'],
	"USERS_FORM_HOBBY" => '<input type="text" name="hobby" value="'.$hardfav['hobby'].'">',
	"USERS_TEXT_HOBBY" => $L['qs_hobby'],
	"USERS_FORM_SPORT" => '<input type="text" name="sport" value="'.$hardfav['sport'].'">',
	"USERS_TEXT_SPORT" => $L['qs_sport'],
	"USERS_FORM_GAME" => '<input type="text" name="game" value="'.$hardfav['game'].'">',
	"USERS_TEXT_GAME" => $L['qs_game'],
	"USERS_FORM_DEL" => '<input type="checkbox" name="del" value="ON">',
	"USERS_TEXT_DEL" => $L['qs_delete'],
	"USERS_FORM_SENDPM" => '<a href="pm.php?s=new&to='.$userdd['id'].'"><img border="0" src="templates/'.$defskin.'/icons/pm.gif"> '.$L['qs_newpm'].'</a>',
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>