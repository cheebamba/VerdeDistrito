<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if($user['level']>0){
	qs_redirect(105, 'index.php');
}

$loc = 'reg';
$title = $T['auth.reg'];

$countrys = '<select name="country">';

$a = $_POST['a'];

if($a == 'add'){
	$regdate = gmdate("Y-m-d H:i:s");
	$nick = qs_addslashes($_POST['nick']);
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$email = qs_addslashes($_POST['email']);
	$gender = $_POST['gender'];
	$country = $_POST['country'];
	$byear = $_POST['byear'];
	$bmonth = $_POST['bmonth'];
	$bday = $_POST['bday'];
	$codetext = qs_addslashes($_POST['codetext']);
	$birthdate = $byear.'-'.$bmonth.'-'.$bday;
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_nick='".$nick."'");
	$result = mysql_fetch_array($sql);
	if ($nick == ""){
		$reg_errortext1 = $L['qs_emptyfields'].'<br>';
		$reg_error = TRUE;
	}
	elseif (strchr($nick, " ") || strchr($nick, ",") || strchr($nick, "'")){
		$reg_errortext2 .= $L['qs_wrongnick'].'<br>';
		$nick = "";
		$reg_error = TRUE;
	}
	elseif (!qs_isgoodlength($nick, 2, 20)){
		$reg_errortext2 .= $L['qs_wrongnicklen'].'<br>';
		$nick = "";
		$reg_error = TRUE;
	}
	elseif (strtolower($nick) == strtolower($result['user_nick'])){
		$reg_errortext2 .= $L['qs_inusenick'].'<br>';
		$nick = "";
		$reg_error = TRUE;
	}
	if ($pass1 == "" || $pass2 == ""){
		$pass1 = "";
		$pass2 = "";
		$reg_errortext1 = $L['qs_emptyfields'].'<br>';
		$reg_error = TRUE;
	}
	elseif ($pass1 != $pass2){
		$reg_errortext2 .= $L['qs_wrongpass'].'<br>';
		$pass1 = "";
		$pass2 = "";
		$reg_error = TRUE;
	}
	elseif (!qs_isgoodlength($pass1, 4, 32)){
		$reg_errortext2 .= $L['qs_wrongpasslen'].'<br>';
		$pass1 = "";
		$pass2 = "";
		$reg_error = TRUE;
	}
	elseif (!qs_islegal($pass1)){
		$reg_errortext2 .= $L['qs_illegalpass'].'<br>';
		$pass1 = "";
		$pass2 = "";
		$reg_error = TRUE;
	}
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_email='".$email."'");
	$result = mysql_fetch_array($sql);
	if($email == ""){
		$email = "";
		$reg_errortext1 = $L['qs_emptyfields'].'<br>';
		$reg_error = TRUE;
	}
	elseif (!qs_isemail($email)){
		$email = "";
		$reg_errortext2 .= $L['qs_wrongemail'].'<br>';
		$reg_error = TRUE;
	}
	elseif ($email == $result['user_email']){
		$email = "";
		$reg_errortext2 .= $L['qs_inuseemail'].'<br>';
		$reg_error = TRUE;
	}
	if ($codetext == ""){
		$reg_errortext1 = $L['qs_emptyfields'].'<br>';
		$reg_error = TRUE;
	}
	elseif ($codetext != $_COOKIE['randtext']){
		$reg_errortext2 .= $L['qs_wrongcode'].'<br>';
		$reg_error = TRUE;
	}
	@session_unregister('randtext');
	if ($reg_error != TRUE) {
		$pass = md5($pass1);
		$code = md5(microtime());
		$text = $L['qs_welcome'].' '.$nick.' !<br><br>'.$MT['reg1'].' '.$conf['global_domain'].' . '.$MT['reg2'].'<a href=3D"mailto:'.$conf['global_admail'].'">'.$conf['global_admail'].'</a>. '.$MT['reg3'].'<br><br><a href=3D"'.$conf['global_mainurl'].'auth.php?a=3Dactivate&amp;code=3D'.$code.'">'.$conf['global_mainurl'].'auth.php?a=3Dactivate&code=3D'.$code.'</a><br><br>'.$MT['reg4'].'<br> '.$L['qs_nick'].' =3D '.qs_stripslashes($nick).'<br> '.$L['qs_pass'].' =3D '.$pass1.'<br><br>'.$MT['reg5'].' <br>'.$conf['global_maintitle'].' - <a href=3D"'.$conf['global_mainurl'].'">'.$conf['global_domain'].'</a><br>'.$conf['global_subtitle'];
		//if(qs_mail($text, qs_stripslashes($email), $L['qs_registration'], $nick)){
			if(mysql_query("INSERT INTO ".$qs_db['users']."(user_nick, user_active, user_password, user_email, user_gender, user_country, user_regdate, user_lastvisitf2, user_code, user_birthdate) VALUES('".$nick."', '1', '".$pass."', '".$email."', '".$gender."', '".$country."', '".$regdate."', '".$regdate."', '".$code."', '".$birthdate."')")){
				qs_redirect(502);
			}
		//}
		else {
			$reg_errortext1 = $L['qs_actionproblem'].' '.$L['qs_mailnotsend'];
		}
	}
	else{
		$nick = qs_stripslashes($nick);
		$pass1 = "";
		$pass2 = "";
		$email = qs_stripslashes($email);
		switch ($gender){
			case '1':
				$selected1 = 'selected';
			break;
			case '2':
				$selected2 = 'selected';
			break;
			default:
			break;	
		}
		foreach ($F as $st => $name){
			if($st == $country){
				$countrys .= '<option value="'.$st.'" selected>'.$name.'</option>';
			}
			else{
				$countrys .= '<option value="'.$st.'">'.$name.'</option>';
			}
		}
	}
}
else {
	foreach ($F as $st => $name){
		if($st == "pl"){
			$countrys .= '<option value="'.$st.'" selected>'.$name.'</option>';
		}
		else{
			$countrys .= '<option value="'.$st.'">'.$name.'</option>';
		}
	}
}

$countrys .= '</select>';

$day = '<select name="bday">';
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

$month = '<select name="bmonth">';
foreach ($months as $key => $value){
	if($key == gmdate("m")){
		$month .= '<option value="'.$key.'" selected>'.$value.'</option>';
	}
	else {
		$month .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$month .= '</select>';
$year = '<select name="byear">';
for ($i=1900; $i<gmdate("Y"); $i++){
	if($i == gmdate("Y")-1){
		$year .= '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else {
		$year .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
$year .= '</select>';


// TEMPLATE 

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('auth.reg'));

$tpl->assign(array(

	"REG_ERROR_TEXT" => $reg_errortext1.$reg_errortext2,
	"REG_FORM_NICK" => '<input type="text" class="input" name="nick" value="'.$nick.'">',
	"REG_TEXT_NICK" => $L['qs_nick'],
	"REG_FORM_PASS1" => '<input type="password" class="input" name="pass1" value="'.$pass1.'">',
	"REG_TEXT_PASS1" => $L['qs_pass'],
	"REG_FORM_PASS2" => '<input type="password" class="input" name="pass2" value="'.$pass2.'">',
	"REG_TEXT_PASS2" => $L['qs_pass2'],
	"REG_FORM_EMAIL" => '<input type="text" class="input" name="email" value="'.$email.'">',
	"REG_TEXT_EMAIL" => $L['qs_email'],
	"REG_FORM_GENDER" => '<select name="gender"><option value="0">'.$L['qs_gender_unknown'].'</option><option '.$selected1.' value="1">'.$L['qs_gender_male'].'</option><option '.$selected2.' value="2">'.$L['qs_gender_female'].'</option></select>',
	"REG_TEXT_GENDER" => $L['qs_gender'],
	"REG_FORM_BIRTHDATE" => $year.$month.$day,
	"REG_TEXT_BIRTHDATE" => $L['qs_birthdate'],
	"REG_FORM_COUNTRY" => $countrys,
	"REG_TEXT_COUNTRY" => $L['qs_country'],
	"REG_FORM_CODE" => '<img src="randimg.php">',
	"REG_FORM_CODETEXT" => '<input type="text" class="input" name="codetext">',
	"REG_TEXT_CODETEXT" => $L['qs_codetxt'],
	"REG_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="submit" class="submit" value="'.$L['qs_send'].'">',

));

$tpl->parse('MAIN');
$tpl->out('MAIN');

require('includes/footer.php');

?>