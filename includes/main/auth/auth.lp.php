<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'lostpass';
$title = $T['lost.pass'];

if($user['level']>0){
	qs_redirect(102);
}

$send = $_POST['send'];
if(!empty($send)){
	$email = $_POST['email'];
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_email='".$email."'");
	if(mysql_num_rows($sql)>0){
		$result = mysql_fetch_array($sql);
		$chars = "abcdefghijklmnopqrstuvwxyz";
		$chars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$chars .= "1234567890";
		$length = strlen($chars) - 1;
		$randtext = "";
		for($i = 0; $i < 6; $i++){
   			$rand = rand(0, $length);
   			$randchar = $chars[$rand];
   			$randtext .= $randchar;
		}
		if(mysql_query("UPDATE ".$qs_db['users']." SET user_password='".md5($randtext)."' WHERE user_id='".$result['user_id']."'")){
			$text = $L['qs_welcome'].' '.$result['user_nick'].' !<br>'.$MT['lp1'].' '.$conf['global_domain'].' . '.$MT['lp2'].'<a href=3D"mailto:'.$conf['global_admail'].'">'.$conf['global_admail'].'</a>.<br><br>'.$MT['reg4'].'<br> '.$L['qs_nick'].' =3D '.$result['user_nick'].'<br> '.$L['qs_pass'].' =3D '.$randtext.'<br><br>'.$MT['lp3'].' <br>'.$conf['global_maintitle'].' - <a href=3D"'.$conf['global_mainurl'].'">'.$conf['global_domain'].'</a><br>'.$conf['global_subtitle'];
			qs_mail($text, $email, $L['qs_lostpass']);
		}
		qs_log('lost pass - good - '.$email.'');
		qs_redirect(501);
	}
	else {
		qs_log('lost pass - bad - '.$email.'');
		qs_redirect(133);
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('auth.lp'));

$tpl->assign(array(
	"LP_TEXT" => $L['qs_lptext'],
	"LP_EMAIL" => '<input type="text" name="email">',
	"LP_SEND" => '<input type="hidden" name="send" value="OK"><input type="submit" class="submit" value="'.$L['qs_send'].'">',
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>