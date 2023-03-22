<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

include('includes/lang/'.$deflang.'/admin.php');
include('includes/lang/'.$deflang.'/main.php');
include('includes/lang/'.$deflang.'/message.php');
@$link = mysql_connect($db_host, $db_user, $db_pass);
@$flag = mysql_select_db($db_name);

if(!$link || !$flag){
	echo $M['qs_dberror']; 
	exit;
}

$user['timezone'] = $deftimezone;
$user['level'] = 0;
$user['lastf'] = gmdate("Y-m-d H:i:s");

session_start();

$user['nick'] = $_SESSION['nick'];
$user['pass'] = $_SESSION['pass'];
if($user['nick'] == "" || $user['pass'] == ""){
	
	$qsl = base64_decode($_COOKIE['qsl']);
	$qsl = explode(':_:',$qsl);
	$user['nick'] = $qsl[0];
	$user['pass'] = $qsl[1];
}
if($user['nick'] != "" && $user['pass'] != ""){
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_nick='".$user['nick']."'");
	$result = mysql_fetch_array($sql);
	if($user['pass'] == $result['user_password']){
		$user['level'] = $result['user_level'];
		$user['nick'] = $result['user_nick'];
		$user['id'] = $result['user_id'];
		$user['pass'] = $result['user_password'];
		$user['timezone'] = $result['user_timezone']+1;
		$user['lastf'] = $result['user_lastvisitf2'];
		$user['lastsid'] = $result['user_lastsesid'];
		$user['lastf1'] = $result['user_lastvisitf1'];
		foreach ($langs as $key => $value){
			if($result['user_lang'] == $key){
				$deflang = $result['user_lang'];
			}
		}
		foreach ($skins as $key => $value){
			if($result['user_skin'] == $key){
				$defskin = $result['user_skin'];
			}
		}
		if($_SESSION['nick'] == "" || $_SESSION['pass'] == ""){
			$logcount = $result['user_logcount']+1;
			$ip = $_SERVER['REMOTE_ADDR'];
			$date = gmdate("Y-m-d H:i:s");
			mysql_query("UPDATE ".$qs_db['users']." SET user_logcount='".$logcount."', user_lastip='".$ip."', user_lastvisit='".$date."' WHERE user_id='".$result['user_id']."'");
		}
		$nick = $user['nick'];
		$pass = $user['pass'];
		session_register('nick');
		session_register('pass');
	}
	else{
		session_unset();
		session_destroy();
		setcookie("qsl", "", time() - 3600);
		$user['level'] = 0;
		$user['timezone'] = '+01';
	}
}
else {
	session_unset();
	session_destroy();
	setcookie("qsl", "", time() - 3600);
}
if($user['level']>0){
	$ip = $_SERVER['REMOTE_ADDR'];
	$date = gmdate("Y-m-d H:i:s");
	mysql_query("UPDATE ".$qs_db['users']." SET user_lastvisit='".$date."', user_lastip='".$ip."' WHERE user_id='".$user['id']."'");
	
	$time = time();
	$sql = mysql_query("SELECT * FROM ".$qs_db['online']." WHERE online_userid='".$user['id']."'");
	if(mysql_num_rows($sql)>0){
		mysql_query("UPDATE ".$qs_db['online']." SET online_ip='".$ip."', online_lastvisit='".$time."' WHERE online_userid='".$user['id']."'");
	}
	else {
		mysql_query("INSERT INTO ".$qs_db['online']."(online_ip, online_userid, online_lastvisit) VALUES('".$ip."', '".$user['id']."', '".$time."')");
	}
	$where = strrchr($_SERVER['SCRIPT_NAME'], '/');
	$lenwhere = strlen($where)-5;
	$where = substr($where,1,$lenwhere);
	mysql_query("UPDATE ".$qs_db['online']." SET online_where='".$where."' WHERE online_userid='".$user['id']."'");
}
else {
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = time();
	$sql = mysql_query("SELECT * FROM ".$qs_db['online']." WHERE online_ip='".$ip."'");
	if(mysql_num_rows($sql)>0){
		mysql_query("UPDATE ".$qs_db['online']." SET online_ip='".$ip."', online_lastvisit='".$time."' WHERE online_ip='".$ip."'");
	}
	else {
		mysql_query("INSERT INTO ".$qs_db['online']."(online_ip, online_lastvisit) VALUES('".$ip."', '".$time."')");
	}
}
include('includes/lang/'.$deflang.'/admin.php');
include('includes/lang/'.$deflang.'/main.php');
include('includes/lang/'.$deflang.'/message.php');

mysql_query("DELETE FROM ".$qs_db['pms']." WHERE pm_status='2' AND pm_fromstatus='2'");

$sql = mysql_query("SELECT * FROM ".$qs_db['config']." ORDER BY config_id");
while ($result = mysql_fetch_array($sql)){
	$confadres = $result['config_cat'].'_'.$result['config_name'];
	$conf[$confadres] = stripslashes($result['config_value']);
}

$sql = mysql_query("SELECT * FROM ".$qs_db['levels']." ORDER BY level_level");
while ($result = mysql_fetch_array($sql)) {
	$level[$result['level_level']] = $result['level_name'];
}

$months = array(
	'01' => $L['january'],
	'02' => $L['february'],
	'03' => $L['march'],
	'04' => $L['april'],
	'05' => $L['may'],
	'06' => $L['june'],
	'07' => $L['july'],
	'08' => $L['august'],
	'09' => $L['september'],
	'10' => $L['october'],
	'11' => $L['november'],
	'12' => $L['december']
);

// MODULES

include('modules/global/default.php');
include('modules/global/shoutbox.php');

?>