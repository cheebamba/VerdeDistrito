<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if (!defined('QS_SYSTEM')) define( 'QS_SYSTEM', 1 );

require('includes/config.php');
require('includes/functions.php');
require('includes/common.php');
require('includes/template.php');

$id = $_GET['id'];
$m = $_GET['m'];
$t = $_GET['t'];

if($user['level'] > 0){
	if($user['lastsid'] != session_id()){
		mysql_query("UPDATE ".$qs_db['users']." SET user_lastvisitf2='".$user['lastf1']."' WHERE user_id='".$user['id']."'");
	}
	$datetime = gmdate("Y-m-d H:i:s");
	mysql_query("UPDATE ".$qs_db['users']." SET user_lastvisitf1='".$datetime."', user_lastsesid='".session_id()."' WHERE user_id='".$user['id']."'");
	$ssuser = qs_userdata($user['id']);
}

if(!empty($m)){
	include('includes/main/forum/forum.edit.php');
}
elseif(!empty($id)){
	include('includes/main/forum/forum.subcat.php');
}
elseif(!empty($t)){
	include('includes/main/forum/forum.topic.php');
}
else{
	include('includes/main/forum/forum.cats.php');
}

?>