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

$s = $_GET['s'];
switch ($s){
	case 'reg':
		include('includes/main/auth/auth.reg.php');
	break;
	case 'lp':
		include('includes/main/auth/auth.lp.php');
	break;
	default:
		include('includes/main/auth/auth.php');
	break;
}

?>