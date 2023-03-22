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
$id = $_GET['id'];
switch ($a) {
	case 'edit':
		include('includes/admin/users/user.edit.php');
	break;

	default:
		if(!empty($id)){
			include('includes/main/users/user.details.php');
		}
		else {
			include('includes/main/users/users.php');
		}
	break;
}

?>