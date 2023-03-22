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
switch($s){
	case 'archives':
		include('includes/main/news/news.archives.php');
	break;
	default:
		$id = $_GET['id'];
		if($id != ''){
			include('includes/main/news/news.com.php');
		}
		else {
			include('includes/main/news/news.php');
		}
	break;
}

?>