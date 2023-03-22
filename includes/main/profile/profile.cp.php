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
$title = $T['profile.cp'];

// CHANGE PASSWORD  VARIABLES - START

$a = $_POST['a'];
if($a == 'cp'){
	$passo = md5($_POST['passo']);
	$passn1 = $_POST['passn1'];
	$passn2 = $_POST['passn2'];
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$user['id']."'");
	$result = mysql_fetch_array($sql);
	
	if($passo == $result['user_password']){
		if($passn1 == $passn2){
			if(qs_isgoodlength($passn1, 4, 32)){
				$pass = md5($passn1);
				mysql_query("UPDATE ".$qs_db['users']." SET user_password='".$pass."' WHERE user_id='".$user['id']."'");
				qs_redirect(111, 'profile.php');
			}
			else {
				$cp_errortext .= $L['qs_wrongpasslen'].'<br>';
			}
		}
		else {
			$cp_errortext = $L['qs_wrongpass'].'<br>';
		}
	}
	else{
		$cp_errortext = $L['qs_wrongpasso'];
	}
}

// TEMPLATE VARIABLES
require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('profile.cp'));

$tpl->assign(array(
	"CP_TEXT_CHANGEPASS" => $L['qs_cp'],
	"CP_TEXT_ERROR" => $cp_errortext,
	"CP_FORM_PASSO" => '<input type="password" name="passo">',
	"CP_TEXT_PASSO" => $L['qs_passo'],
	"CP_FORM_PASSN1" => '<input type="password" name="passn1">',
	"CP_TEXT_PASSN1" => $L['qs_passn1'],
	"CP_FORM_PASSN2" => '<input type="password" name="passn2">',
	"CP_TEXT_PASSN2" => $L['qs_passn2'],
	"CP_FORM_SEND" => '<input type="hidden" name="a" value="cp"><input type="submit" class="submit" name="send" value="'.$L['qs_cp'].'">',
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>