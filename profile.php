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

$a = $_GET['a'];
switch ($a) {
	case 'changepass':
		include('includes/main/profile/profile.cp.php');
	break;

	default:
		include('includes/main/profile/profile.php');
	break;
}

?>