<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'team';
$title = $T['team'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('team'));

$sql = mysql_query("SELECT * FROM ".$qs_db['divs']." ORDER BY div_subid");
if(mysql_num_rows($sql)>0){
	while ($result = mysql_fetch_array($sql)) {
		$tpl->assign(array(
			"DIV_TITLE" => $result['div_name'],
			"DIV_IMG" => '<a href="team.php?div='.$result['div_st'].'"><img src="includes/images/div/'.$result['div_st'].'.gif"></div>',
		));
		$tpl->parse('MAIN.DIV_ROW');
	}
}
$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>