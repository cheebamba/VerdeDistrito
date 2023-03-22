<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$sql = mysql_query("SELECT * FROM ".$qs_db['online']." WHERE online_ip='count'");
if(mysql_num_rows($sql)<1){
	mysql_query("INSERT INTO ".$qs_db['online']."(online_ip, online_lastvisit) VALUES('count', '1')");
	$sql = mysql_query("SELECT * FROM ".$qs_db['online']." WHERE online_ip='count'");
}
$result = mysql_fetch_array($sql);
$count = $result['online_lastvisit']+1;
mysql_query("UPDATE ".$qs_db['online']." SET online_lastvisit='".$count."' WHERE online_ip='count'");
$odslon = $count;

if($menuleft == 'OFF'){
	$tpl = new XTemplate(qs_tplfile('footer2'));
}
else{
	$tpl = new XTemplate(qs_tplfile('footer'));
}

$tpl->parse('FOOTER');
$tpl->out('FOOTER');

?>