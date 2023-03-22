<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = '';
$title = '';

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('XXXXXX'));

$tpl->assign(array(
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>