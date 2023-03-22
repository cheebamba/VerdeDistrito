<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'message';
$title = $T['message'];

$site = $_GET['s'];
$msg1 = $_GET['m'];
$msg2 = 'qs_msg'.$msg1;

$msg = $M['qs_msg900'];
foreach ($M as $key => $value){
	if($msg2 == $key){
		$msg = $M[$msg2];
	}
}
/*if(!file_exists(strrev(strstr(strrev($site), '.'))).'php'){
	$site = 'index.php';
}*/

if(empty($site)){
	$site = 'index.php';
}

if($msg1{0} != '5'){
	echo '<head><meta HTTP-EQUIV="Refresh" CONTENT="1; URL='.$site.'"></head>';
}
else {
	$M['qs_redirecting'] = '';
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('message'));

$tpl->assign(array(
	"MSG_TEXT" => $msg,
	"MSG_REDIRECT" => $M['qs_redirecting'],
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>