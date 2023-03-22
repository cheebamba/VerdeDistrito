<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'pages')){
	qs_redirect(107);
}

$loc = 'admin';
$title = $T['pages'];

$sql = mysql_query("SELECT * FROM ".$qs_db['pages']." ORDER BY page_id");

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/pages'));

while($result = mysql_fetch_array($sql)){
	$date = qs_userdate($result['page_date'], $user['timezone']);
	$owner = qs_userdata($result['page_ownerid']);
	$tpl->assign(array(
		"PAGE_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
		"PAGE_TITLE" => $result['page_title'],
		"PAGE_OWNER" => '<a href="users.php?id='.$owner['user_id'].'">'.$owner['user_nick'].'</a>',
		"PAGE_EDIT" => '<a href="admin.php?s=editpage&id='.$result['page_id'].'">'.$L['qs_edit'].'</a>'
	));
	$tpl->parse('MAIN.PAGE_ROW');
}

?>