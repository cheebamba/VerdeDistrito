<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$a = $_GET['a'];

if($a == 'logout'){
	if(session_destroy()){
		if(setcookie("qsl", "", time() - 3600)){
			qs_redirect(124, 'index.php');
		}
	}
}
if($a == 'activate'){
	$code = $_GET['code'];
	if($code != ''){
		$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_code='".$code."'");
		$row = mysql_num_rows($sql);
		$result = mysql_fetch_array($sql);
		if($row>0){
			if($result['user_active'] != '1'){
				if(mysql_query("UPDATE ".$qs_db['users']." SET user_active='1' WHERE user_id='".$result['user_id']."'")){
					qs_redirect(112, 'index.php');
				}
			}
			else {
				qs_redirect(109, 'index.php');
			}
		}
		else {
			qs_redirect(110, 'index.php');
		}
	}
	else {
		qs_redirect(110, 'index.php');
	}
}

if($user['level']>0){
	qs_redirect('102');
}

$loc = 'login';
$title = $T['auth'];

if($a == 'login'){
	$nick = $_POST['nick'];
	$pass = $_POST['pass'];
	$rem = $_POST['rem'];
	if($nick != "" && $pass != ""){
		$nick = qs_addslashes($nick);
		$pass = md5($pass);
		$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_nick='".$nick."'");
		$result = mysql_fetch_array($sql);
		if($result['user_active'] == 1){
			if($pass == $result['user_password']){
				session_register('nick');
				session_register('pass');
				if(isset($rem)){
					$qsl = base64_encode("$nick:_:$pass");
					setcookie("qsl", "$qsl", time() + 5184000);
				}
				$logcount = $result['user_logcount'];
				$ip = $_SERVER['REMOTE_ADDR'];
				$date = gmdate("Y-m-d H:i:s");
				mysql_query("UPDATE ".$qs_db['users']." SET user_logcount='".$logcount."', user_lastip='".$ip."', user_lastlog='".$date."', user_lastvisit='".$date."' WHERE user_id='".$result['user_id']."'");
				qs_redirect(103, 'index.php');
			}
			else{
				$auth_errortext = $L['qs_logerror'];
				qs_log('bad login - '.$nick.'', $nick, $result['user_id']);
			}
		}
		else {
			$auth_errortext = $L['qs_usernotactive'];
		}
	}
	else{
		$auth_errortext = $L['qs_emptyfieldslog'];
	}
}

// TEMPLATE 

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('auth'));

$tpl->assign(array(
	"AUTH_TEXT_ERROR" => $auth_errortext,
	"AUTH_FORM_NICK" => '<input type="text" name="nick" class="input">',
	"AUTH_TEXT_NICK" => $L['qs_nick'],
	"AUTH_FORM_PASS" => '<input type="password" name="pass" class="input">',
	"AUTH_TEXT_PASS" => $L['qs_pass'],
	"AUTH_FORM_REM" => '<input type="checkbox" class="checkbox" name="rem" value="REM" checked>',
	"AUTH_TEXT_REM" => $L['qs_remember'],
	"AUTH_FORM_SEND" => '<input type="submit" class="submit" name="send" value="'.$L['qs_login'].'">',
));

$tpl->parse('MAIN');
$tpl->out('MAIN');

require('includes/footer.php');

?>