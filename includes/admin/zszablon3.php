<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'XXXXXX')){
	qs_redirect(107);
}

$loc = '';
$title = $T[''];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/XXXXXX'));

$tpl->assign(array(
));

?>