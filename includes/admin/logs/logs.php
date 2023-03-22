<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'logs')){
	qs_redirect(107);
}

$title = $T['logs'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/logs'));

$sql = mysql_query("SELECT * FROM ".$qs_db['log']." ORDER BY log_date DESC");
while ($result = mysql_fetch_array($sql)) {
	$tpl->assign(array(
		"LOG_DATE" => $result['log_date'],
		"LOG_IP" => $result['log_ip'],
		"LOG_NICK" => '<a href="users.php?id='.$result['log_userid'].'">'.$result['log_nick'].'</a>',
		"LOG_TEXT" => $result['log_text']
	));
	$tpl->parse('MAIN.LOG_ROW');
}

?>