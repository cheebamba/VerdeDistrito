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

/*
$sql1 = mysql_query("SELECT * FROM ".$qs_db['users']." ORDER BY user_id");
while($result1 = mysql_fetch_array($sql1)){
	$sql = mysql_query("SELECT * FROM ".$qs_db['shoutbox']." WHERE shout_ownerid='".$result1['user_id']."'");
	$scount = mysql_num_rows($sql);
	if($scount > 60){
	echo $result1['user_nick'].': '.$scount.'<br>';
	}
}
*/

/*
$sql1 = mysql_query("SELECT * FROM ".$qs_db['users']." ORDER BY user_id");
while($result1 = mysql_fetch_array($sql1)){
	$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_ownerid='".$result1['user_id']."'");
	$scount = mysql_num_rows($sql);
	if($scount > 0){
	echo $result1['user_nick'].': '.$scount.'<br>';
	}
}
*/

?>