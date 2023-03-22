<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if($user['level']<1){
	qs_redirect(106, 'index.php');
}

$loc = 'profile';
$title = $T['profile'].' - '.$user['nick'];

// UPDATE VARIABLES - START

$a = $_POST['a'];
if($a == 'update'){
	
	$nick = qs_addslashes($_POST['nick']);
	$name = qs_addslashes($_POST['name']);
	$surname = qs_addslashes($_POST['surname']);
	$country = $_POST['country'];
	$text = qs_addslashes($_POST['text']);
	$avatar = $_FILES["avatar"];
	$delavatar = $_POST['delavatar'];
	$photo = $_FILES["photo"];
	$delphoto = $_POST['delphoto'];
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
	$hardstor = qs_addslashes($_POST['stor']);
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
	
	$profile_errortext = "";
	
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$user['id']."'");
	$result = mysql_fetch_array($sql);
	if($email != $result['user_email']){
		$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_email='".$email."'");
		$result = mysql_fetch_array($sql);
		
		if($email == $result['user_email']){
			$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$user['id']."'");
			$result = mysql_fetch_array($sql);
			$email = $result['user_email'];
			$profile_error = TRUE;
			$profile_errortext .= $L['qs_inuseemail'];
		}
		if(!qs_isemail($email)){
			$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$user['id']."'");
			$result = mysql_fetch_array($sql);
			$email = $result['user_email'];
			$profile_error = TRUE;
			$profile_errortext .= $L['qs_wrongemail'];
		}
	}
	
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$user['id']."'");
	$result = mysql_fetch_array($sql);
	
// AVATAR
	if(!empty($avatar["tmp_name"])){
		if($avatar["type"]=='image/jpeg' || $avatar["type"]=='image/pjpeg' || $avatar["type"]=='image/gif' || $avatar["type"]=='image/png' || $avatar["type"]=='image/x-png'){
			if($avatar["size"]>$conf['images_avatarmaxs']){
				$profile_error1 = TRUE;
				$profile_errortext .= $L['qs_avatartoobig'].'(max: '.$conf['images_avatarmaxs'].'b)<br>';
			}
			list($avatary, $avatarx) = getimagesize($avatar["tmp_name"]);
			if($avatarx != $avatary || $avatarx>$conf['images_avatarmaxx']){
				$profile_error1 = TRUE;
				$profile_errortext .= $L['qs_avatarwrongxy'];
			}
		}
		else{
			$profile_error1 = TRUE;
			$profile_errortext .= $L['qs_avatarwrongext'];
		}
		if($profile_error1 == TRUE){
			$avatar = $result['user_avatar'];
		}
		else{
			if(file_exists($result['user_avatar'])){
				unlink($result['user_avatar']);
			}
			$ext = strtolower(strrchr($avatar["name"], '.'));
			$dest = 'includes/images/users/'.$user['id'].'_avatar'.$ext;
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
			if($photo["size"]>$conf['images_photomaxs']){
				$profile_error2 = TRUE;
				$profile_errortext .= $L['qs_phototoobig'];
			}
			list($photoy, $photox) = getimagesize($photo["tmp_name"]);
			if($photoy>$conf['images_photomaxy'] || $photox>$conf['images_photomaxx']){
				$profile_error2 = TRUE;
				$profile_errortext .= $L['qs_photowrongxy'];
			}
		}
		else{
			$profile_error2 = TRUE;
			$profile_errortext .= $L['qs_photowrongext'];
		}
		if($profile_error2 == TRUE){
			$photo = $result['user_photo'];
		}
		else{
			if(file_exists($result['user_photo'])){
				unlink($result['user_photo']);
			}
			$ext = strtolower(strrchr($photo["name"], '.'));
			$dest = 'includes/images/users/'.$user['id'].'_photo'.$ext;
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
	$sql = mysql_query("UPDATE ".$qs_db['users']." SET user_name='".$name."', user_surname='".$surname."', user_country='".$country."', user_text='".$text."', user_avatar='".$avatar."', user_photo='".$photo."', user_signature='".$signature."', user_occupation='".$occupation."', user_origin='".$origin."', user_location='".$location."', user_timezone='".$timezone."', user_birthdate='".$birthdate."', user_gender='".$gender."', user_gg='".$gg."', user_irc='".$irc."', user_msn='".$msn."', user_icq='".$icq."', user_website='".$website."', user_email='".$email."', user_skin='".$skin."', user_lang='".$lang."', user_hardcpu='".$hardcpu."', user_hardmb='".$hardmb."', user_hardram='".$hardram."', user_hardstor='".$hardstor."', user_hardgc='".$hardgc."', user_hardmc='".$hardmc."', user_hardmon='".$hardmon."', user_hardmouse='".$hardmouse."', user_hardpad='".$hardpad."', user_hardhp='".$hardhp."', user_hardnet='".$hardnet."', user_hardos='".$hardos."', user_hardres='".$hardres."', user_hardsens='".$hardsens."', user_favdrink='".$favdrink."', user_favfood='".$favfood."', user_favbook='".$favbook."', user_favmov='".$favmov."', user_favact='".$favact."', user_favmus='".$favmus."', user_favplr='".$favplr."', user_favourplr='".$favourplr."', user_favteam='".$favteam."', user_favhobby='".$favhobby."', user_favsport='".$favsport."', user_favgame='".$favgame."' WHERE user_id='".$user['id']."'");
// REDIRECT
	if($profile_error1 != TRUE && $profile_error2 != TRUE && $profile_error != TRUE){
		qs_redirect(108, 'profile.php');
	}

}

// FORM VARIABLES - START

$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$user['id']."'");
$result = mysql_fetch_array($sql);

$birthdate = $result['user_birthdate'];
$birthdate = explode('-', $birthdate);
$user = array(
	id => $result['user_id'],
	nick  => $result['user_nick'],
	name => qs_stripslashes($result['user_name']),
	surname => qs_stripslashes($result['user_surname']),
	level => $result['user_level'],
	country => $result['user_country'],
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

$sql = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_level='".$user['level']."'");
$result = mysql_fetch_array($sql);

$countrys = '<select name="country">';
foreach ($F as $st => $name){
	if($st == $user['country']){
		$countrys .= '<option value="'.$st.'" selected>'.$name.'</option>';
	}
	else{
		$countrys .= '<option value="'.$st.'">'.$name.'</option>';
	}
}
$countrys .= '</select>';

$ocountrys = '<select name="origin">';
foreach ($F as $st => $name){
	if($st == $user['origin']){
		$ocountrys .= '<option value="'.$st.'" selected>'.$name.'</option>';
	}
	else{
		$ocountrys .= '<option value="'.$st.'">'.$name.'</option>';
	}
}
$ocountrys .= '</select>';

$timezones = array('-12', '-11', '-10', '-09', '-08', '-07', '-06', '-05', '-04', '-03', '-02', '-01', '+00', '+01', '+02', '+03', '+04', '+05', '+06', '+07', '+08', '+09', '+10', '+11', '+12');

$timezone = '<select name="timezone">';
foreach ($timezones as $key){
	if($key == $user['timezone']){
		$timezone .= '<option value="'.$key.'" selected>GMT '.$key.'</option>';
	}
	else {
		$timezone .= '<option value="'.$key.'">GMT '.$key.'</option>';
	}
}
$timezone .= '</select>';

$day = '<select name="bday">';
for ($i=1; $i<10; $i++){
	if('0'.$i == $user['bday']){
		$day .= '<option value="0'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$day .= '<option value="0'.$i.'">'.$i.'</option>';
	}
}
for ($i=10; $i<32; $i++){
	if($i == $user['bday']){
		$day .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$day .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$day .= '</select>';

$month = '<select name="bmonth">';
foreach ($months as $key => $value){
	if($key == $user['bmonth']){
		$month .= '<option value="'.$key.'" selected>'.$value.'</option>';
	}
	else {
		$month .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$month .= '</select>';
$year = '<select name="byear">';
for ($i=1900; $i<gmdate("Y"); $i++){
	if($i == $user['byear']){
		$year .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$year .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$year .= '</select>';

if($user['gender'] == 1){
	$selected1 = 'selected';
}
elseif ($user['gender'] == 2){
	$selected2 = 'selected';
}

$form_skins = '<select name="skin">';
foreach ($skins as $key => $value){
	if($key == $defskin){
		$form_skins .= '<option value="'.$key.'" selected>'.$value.'</option>';
	}
	else{
		$form_skins .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$form_skins .= '</select>';

$form_langs = '<select name="lang">';
foreach ($langs as $key => $value){
	if($key == $deflang){
		$form_langs .= '<option value="'.$key.'" selected>'.$value.'</option>';
	}
	else{
		$form_langs .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$form_langs .= '</select>';

if($user['avatar'] != ""){
	$avatar = '<img src="'.$user['avatar'].'"><br>'.$L['qs_delete'].': <input type="checkbox" name="delavatar" values="ON"><br>';
}
else {
	$avatar = $L['qs_none'].'<br>';
}
if($user['photo'] != ""){
	$photo = '<img src="'.$user['photo'].'"><br>'.$L['qs_delete'].': <input type="checkbox" name="delphoto" values="ON"><br>';
}
else {
	$photo = $L['qs_none'].'<br>';
}

// FORM VARIABLES - END

// TEMPLATE VARIABLES

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('profile'));

if(!empty($profile_errortext)){
	$tpl->assign("PROFILE_TEXT_ERROR", $profile_errortext);
	$tpl->parse('MAIN.PROFILE_ERROR');
}

$tpl->assign(array(
	"PROFILE_TEXT_FAV" => $L['qs_fav'],
	"PROFILE_TEXT_HARD" => $L['qs_hard'],
	"PROFILE_TEXT_DATA" => $L['qs_data'],
	"PROFILE_TEXT_SETTINGS" => $L['qs_websettings'],
	"PROFILE_TEXT_IMAGES" => $L['qs_images'],
	"PROFILE_TEXT_CONTACT" => $L['qs_contact'],
	"PROFILE_FORM_NICK" => '<input type="text" name="name" value="'.$user['nick'].'">',
	"PROFILE_TEXT_NICK" => $L['qs_nick'],
	"PROFILE_FORM_NAME" => '<input type="text" name="name" value="'.$user['name'].'">',
	"PROFILE_TEXT_NAME" => $L['qs_name'],
	"PROFILE_FORM_SURNAME" => '<input type="text" name="surname" value="'.$user['surname'].'">',
	"PROFILE_TEXT_SURNAME" => $L['qs_surname'],
	"PROFILE_TEXT_LEVEL" => $result['level_name'],
	"PROFILE_FORM_COUNTRY" => $countrys,
	"PROFILE_TEXT_COUNTRY" => $L['qs_country'],
	"PROFILE_FORM_TEXT" => '<textarea rows="15" name="text" cols="45">'.$user['text'].'</textarea>',
	"PROFILE_TEXT_TEXT" => $L['qs_text'],
	"PROFILE_FORM_AVATAR" => $avatar.'<input type="file" name="avatar" class="file">',
	"PROFILE_TEXT_AVATAR" => $L['qs_avatar'],
	"PROFILE_FORM_PHOTO" => $photo.'<input type="file" name="photo" class="file">',
	"PROFILE_TEXT_PHOTO" => $L['qs_photo'],
	"PROFILE_FORM_SIGNATURE" => '<textarea rows="5" name="signature" cols="40">'.$user['signature'].'</textarea>',
	"PROFILE_TEXT_SIGNATURE" => $L['qs_signature'],
	"PROFILE_FORM_OCCUPATION" => '<input type="text" name="occupation" value="'.$user['occupation'].'">',
	"PROFILE_TEXT_OCCUPATION" => $L['qs_occupation'],
	"PROFILE_FORM_ORIGIN" => $ocountrys,
	"PROFILE_TEXT_ORIGIN" => $L['qs_origin'],
	"PROFILE_FORM_LOCATION" => '<input type="text" name="location" value="'.$user['location'].'">',
	"PROFILE_TEXT_LOCATION" => $L['qs_location'],
	"PROFILE_FORM_TIMEZONE" => $timezone,
	"PROFILE_TEXT_TIMEZONE" => $L['qs_timezone'],
	"PROFILE_FORM_BIRTHDATE" => $year.$month.$day,
	"PROFILE_TEXT_BIRTHDATE" => $L['qs_birthdate'],
	"PROFILE_FORM_GENDER" => '<select name="gender"><option value="0">'.$L['qs_gender_unknown'].'</option><option '.$selected1.' value="1">'.$L['qs_gender_male'].'</option><option '.$selected2.' value="2">'.$L['qs_gender_female'].'</option></select>',
	"PROFILE_TEXT_GENDER" => $L['qs_gender'],
	"PROFILE_FORM_GG" => '<input type="text" name="gg" value="'.$user['gg'].'">',
	"PROFILE_TEXT_GG" => $L['qs_gg'],
	"PROFILE_FORM_IRC" => '<input type="text" name="irc" value="'.$user['irc'].'">',
	"PROFILE_TEXT_IRC" => $L['qs_irc'],
	"PROFILE_FORM_MSN" => '<input type="text" name="msn" value="'.$user['msn'].'">',
	"PROFILE_TEXT_MSN" => $L['qs_msn'],
	"PROFILE_FORM_ICQ" => '<input type="text" name="icq" value="'.$user['icq'].'">',
	"PROFILE_TEXT_ICQ" => $L['qs_icq'],
	"PROFILE_FORM_WEBSITE" => '<input type="text" name="website" value="'.$user['website'].'">',
	"PROFILE_TEXT_WEBSITE" => $L['qs_website'],
	"PROFILE_FORM_EMAIL" => '<input type="text" name="email" value="'.$user['email'].'">',
	"PROFILE_TEXT_EMAIL" => $L['qs_email'],
	"PROFILE_FORM_SKIN" => $form_skins,
	"PROFILE_TEXT_SKIN" => $L['qs_skin'],
	"PROFILE_FORM_LANG" => $form_langs,
	"PROFILE_TEXT_LANG" => $L['qs_lang'],
	"PROFILE_TEXT_CP" => '<a href="profile.php?a=changepass">'.$L['qs_cp'].'</a>',
	"PROFILE_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="submit" name="send" class="submit" value="'.$L['qs_send'].'">',
	"PROFILE_FORM_CPU" => '<input type="text" name="cpu" value="'.$hardfav['cpu'].'">',
	"PROFILE_TEXT_CPU" => $L['qs_cpu'],
	"PROFILE_FORM_MB" => '<input type="text" name="mb" value="'.$hardfav['mb'].'">',
	"PROFILE_TEXT_MB" => $L['qs_mb'],
	"PROFILE_FORM_RAM" => '<input type="text" name="ram" value="'.$hardfav['ram'].'">',
	"PROFILE_TEXT_RAM" => $L['qs_ram'],
	"PROFILE_FORM_STOR" => '<input type="text" name="stor" value="'.$hardfav['stor'].'">',
	"PROFILE_TEXT_STOR" => $L['qs_stor'],
	"PROFILE_FORM_GC" => '<input type="text" name="gc" value="'.$hardfav['gc'].'">',
	"PROFILE_TEXT_GC" => $L['qs_gc'],
	"PROFILE_FORM_MC" => '<input type="text" name="mc" value="'.$hardfav['mc'].'">',
	"PROFILE_TEXT_MC" => $L['qs_mc'],
	"PROFILE_FORM_MON" => '<input type="text" name="mon" value="'.$hardfav['mon'].'">',
	"PROFILE_TEXT_MON" => $L['qs_mon'],
	"PROFILE_FORM_MOUSE" => '<input type="text" name="mouse" value="'.$hardfav['mouse'].'">',
	"PROFILE_TEXT_MOUSE" => $L['qs_mouse'],
	"PROFILE_FORM_PAD" => '<input type="text" name="pad" value="'.$hardfav['pad'].'">',
	"PROFILE_TEXT_PAD" => $L['qs_pad'],
	"PROFILE_FORM_HP" => '<input type="text" name="hp" value="'.$hardfav['hp'].'">',
	"PROFILE_TEXT_HP" => $L['qs_hp'],
	"PROFILE_FORM_NET" => '<input type="text" name="net" value="'.$hardfav['net'].'">',
	"PROFILE_TEXT_NET" => $L['qs_net'],
	"PROFILE_FORM_OS" => '<input type="text" name="os" value="'.$hardfav['os'].'">',
	"PROFILE_TEXT_OS" => $L['qs_os'],
	"PROFILE_FORM_RES" => '<input type="text" name="res" value="'.$hardfav['res'].'">',
	"PROFILE_TEXT_RES" => $L['qs_res'],
	"PROFILE_FORM_SENS" => '<input type="text" name="sens" value="'.$hardfav['sens'].'">',
	"PROFILE_TEXT_SENS" => $L['qs_sens'],
	"PROFILE_FORM_DRINK" => '<input type="text" name="drink" value="'.$hardfav['drink'].'">',
	"PROFILE_TEXT_DRINK" => $L['qs_drink'],
	"PROFILE_FORM_FOOD" => '<input type="text" name="food" value="'.$hardfav['food'].'">',
	"PROFILE_TEXT_FOOD" => $L['qs_food'],
	"PROFILE_FORM_BOOK" => '<input type="text" name="book" value="'.$hardfav['book'].'">',
	"PROFILE_TEXT_BOOK" => $L['qs_book'],
	"PROFILE_FORM_MOV" => '<input type="text" name="mov" value="'.$hardfav['mov'].'">',
	"PROFILE_TEXT_MOV" => $L['qs_mov'],
	"PROFILE_FORM_ACT" => '<input type="text" name="act" value="'.$hardfav['act'].'">',
	"PROFILE_TEXT_ACT" => $L['qs_act'],
	"PROFILE_FORM_MUS" => '<input type="text" name="mus" value="'.$hardfav['mus'].'">',
	"PROFILE_TEXT_MUS" => $L['qs_mus'],
	"PROFILE_FORM_PLR" => '<input type="text" name="plr" value="'.$hardfav['plr'].'">',
	"PROFILE_TEXT_PLR" => $L['qs_plr'],
	"PROFILE_FORM_OURPLR" => '<input type="text" name="ourplr" value="'.$hardfav['ourplr'].'">',
	"PROFILE_TEXT_OURPLR" => $L['qs_ourplr'],
	"PROFILE_FORM_TEAM" => '<input type="text" name="team" value="'.$hardfav['team'].'">',
	"PROFILE_TEXT_TEAM" => $L['qs_team'],
	"PROFILE_FORM_HOBBY" => '<input type="text" name="hobby" value="'.$hardfav['hobby'].'">',
	"PROFILE_TEXT_HOBBY" => $L['qs_hobby'],
	"PROFILE_FORM_SPORT" => '<input type="text" name="sport" value="'.$hardfav['sport'].'">',
	"PROFILE_TEXT_SPORT" => $L['qs_sport'],
	"PROFILE_FORM_GAME" => '<input type="text" name="game" value="'.$hardfav['game'].'">',
	"PROFILE_TEXT_GAME" => $L['qs_game'],
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>