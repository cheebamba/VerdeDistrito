<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'wars';
$title = $T['wars'];

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('wars'));

$div = $_GET['div'];
if(empty($div)){
	$div = '';
}
else {
	$div = " AND war_div='".$div."'";
}

$sql = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE war_id<>0 AND (war_ur<>'0' OR war_or<>'0')".$div."");
$sall = mysql_num_rows($sql);

$sql = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE war_ur>war_or".$div."");
$swon = mysql_num_rows($sql);

$sql = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE war_ur<war_or".$div."");
$slost = mysql_num_rows($sql);

$sql = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE (war_ur<>'0' AND war_or<>'0') AND war_ur=war_or".$div."");
$sdraw = mysql_num_rows($sql);

$tpl->assign(array(
	"WARS_TEXT_ALL" => $L['qs_all'],
	"WARS_FORM_ALL" => $sall,
	"WARS_TEXT_WON" => $L['qs_won'],
	"WARS_FORM_WON" => $swon,
	"WARS_TEXT_LOST" => $L['qs_lost'],
	"WARS_FORM_LOST" => $slost,
	"WARS_TEXT_DRAW" => $L['qs_draw'],
	"WARS_FORM_DRAW" => $sdraw,
	"WARS_FORM_DIVS" => '<a href="wars.php">all</a> | <a href="wars.php?div=q3ca">q3ca</a> | <a href="wars.php?div=q3eF">q3eF</a> | <a href="wars.php?div=cs">cs</a> | <a href="wars.php?div=et/t3">et/t3</a> | <a href="wars.php?div=et">et</a> | <a href="wars.php?div=cod2">cod2</a>',
));

$div = $_GET['div'];
if(empty($div)){
	$div = '';
}
else {
	$div = " WHERE war_div='".$div."'";
}

$sql = mysql_query("SELECT * FROM ".$qs_db['wars']."".$div." ORDER BY war_date DESC");
while ($result = mysql_fetch_array($sql)) {
	if($result['war_ur']>$result['war_or']){
		$score = '<font color="green">'.$result['war_ur'].':'.$result['war_or'].'</font>';
	}
	elseif($result['war_ur']<$result['war_or']){
		$score = '<font color="red">'.$result['war_ur'].':'.$result['war_or'].'</font>';
	}
	elseif($result['war_ur'] == '0' && $result['war_or'] == '0'){
		$score = '<font color="blue">'.$L['qs_incoming'].'</font>';
	}
	else{
		$score = '<font color="blue">'.$result['war_ur'].':'.$result['war_or'].'</font>';
	}
	$date = qs_userdate($result['war_date'], $user['timezone']);
	$league = (strlen($result['war_ltitle']) > 5) ? substr($result['war_ltitle'], 0, 5).'...' : $result['war_ltitle'] ;
	$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='4' AND cat_st='".$result['war_lst']."'");
	$csql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='5' AND cat_st='".$result['war_div']."'");
	$cat2 = mysql_fetch_array($csql2);
	$cat = mysql_fetch_array($csql);
	$tpl->assign(array(
		"WAR_TEXT_DATE" => $L['qs_date'],
		"WAR_FORM_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
		"WAR_TEXT_DIV" => $L['qs_div'],
		"WAR_FORM_DIV" => '<img src="includes/images/games/'.$cat2['cat_ico'].'"> <img src="includes/images/flags/pl.gif"> VD.'.$result['war_div'],
		"WAR_TEXT_OPP" => $L['qs_opp'],
		"WAR_FORM_OPP" => '<img src="includes/images/flags/'.$result['war_ocountry'].'.gif"> '.$result['war_opp'],
		"WAR_TEXT_L" => $L['qs_leev'],
		"WAR_FORM_L" => '<img src="includes/images/flags/'.$result['war_lcountry'].'.gif"> <img src="includes/images/icons/'.$cat['cat_ico'].'"> '.$league,
		"WAR_TEXT_RESULT" => $L['qs_result'],
		"WAR_FORM_RESULT" => $score,
		"WAR_TEXT_MORE" => $L['qs_readmore'],
		"WAR_FORM_MORE" => '<a href="wars.php?id='.$result['war_id'].'">'.$L['qs_readmore'].'</a>',
	));
	$tpl->parse('MAIN.WARS_ROW');
}

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>