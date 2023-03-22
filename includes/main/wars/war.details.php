<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'war';

$id = $_GET['id'];
$sql = mysql_query("SELECT * FROM ".$qs_db['wars']." WHERE war_id='".$id."'");
if(mysql_num_rows($sql)<1 || empty($id)){
	qs_redirect(900);
}
$result = mysql_fetch_array($sql);
$title = 'VD.'.$result['war_div'].' vs '.$result['war_opp'];

if($result['war_ur']>$result['war_or']){
	$score = '<font color="green">'.$result['war_ur'].':'.$result['war_or'].'</font>';
}
elseif($result['war_ur']<$result['war_or']){
	$score = '<font color="red">'.$result['war_ur'].':'.$result['war_or'].'</font>';
}
elseif($result['war_ur'] == '0' && $result['war_or'] == '0'){
	$score = '';
}
else{
	$score = '<font color="blue">'.$result['war_ur'].':'.$result['war_or'].'</font>';
}


require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('war.details'));

$sql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='5' AND cat_st='".$result['war_div']."'");
$result2 = mysql_fetch_array($sql2);

if(!file_exists($result['war_avatar'])){
	$avatar = 'includes/images/teams/none.gif';
}
else {
	$avatar = $result['war_avatar'];
}
$csql = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='4' AND cat_st='".$result['war_lst']."'");
$cat = mysql_fetch_array($csql);
$csql2 = mysql_query("SELECT * FROM ".$qs_db['cats']." WHERE cat_id='5' AND cat_st='".$result['war_div']."'");
$cat2 = mysql_fetch_array($csql2);
$date = qs_userdate($result['war_date'], $user['timezone']);
$tpl->assign(array(
	"WAR_TEXT_DATE" => $L['qs_date'],
	"WAR_FORM_DATE" => $date['d'].'.'.$date['m'].'.'.$date['y'],
	"WAR_TEXT_TIME" => $L['qs_tm'],
	"WAR_FORM_TIME" => $date['h'].':'.$date['i'],
	"WAR_TEXT_DIV" => $L['qs_div'],
	"WAR_FORM_DIV" => 'VD.'.$result['war_div'].' <img src="includes/images/flags/pl.gif">',
	"WAR_FORM_ULOGO" => '<img src="includes/images/teams/vd.jpg">',
	"WAR_FORM_OPP" => '<img src="includes/images/flags/'.$result['war_ocountry'].'.gif"> '.$result['war_opp'],
	"WAR_FORM_OLOGO" => '<img src="'.$avatar.'">',
	"WAR_TEXT_MAPS" => $L['qs_maps'],
	"WAR_FORM_MAP1" => $result['war_map1'],
	"WAR_FORM_MAP2" => $result['war_map2'],
	"WAR_TEXT_TV" => $L['qs_see'],
	"WAR_FORM_TV" => $result['war_tv'],
	"WAR_TEXT_SB" => $L['qs_sb'],
	"WAR_FORM_SB" => $result['war_sb'],
	"WAR_TEXT_L" => $L['qs_leev'],
	"WAR_FORM_L" => '<img src="includes/images/flags/'.$result['war_lcountry'].'.gif"> <img src="includes/images/icons/'.$cat['cat_ico'].'"> '.$result['war_ltitle'].'',
	"WAR_TEXT_RESULT" => $L['qs_result'],
	"WAR_FORM_RESULT" => $score,
	"WAR_TEXT_GAME" => $L['qs_game'],
	"WAR_FORM_GAME" => '<img src="includes/images/games/'.$cat2['cat_ico'].'"> '.$result2['cat_title'],
	"WAR_TEXT_SQUAD" => $L['qs_squad'],
	"WAR_FORM_USQUAD" => qs_bbcode(nl2br($result['war_us'])),
	"WAR_FORM_OSQUAD" => qs_bbcode(nl2br($result['war_os'])),
	"WAR_TEXT_TEXT" => $L['qs_des'],
	"WAR_FORM_TEXT" => qs_bbcode(nl2br($result['war_text'])),
));

if(qs_acscheck($user['level'], 'wars')){
	$tpl->assign("WAR_FORM_EDIT", '<a href="admin.php?s=editwar&id='.$result['war_id'].'">['.$L['qs_edit'].']</a>');
}

$tpl->parse('MAIN.WARS_ROW');

$tpl->parse('MAIN');
$tpl->out('MAIN');
$adres = 'wars.php?id='.$id;
$cat = '3';
$id = $_GET['id'];
require('includes/main/comments/comments.php');
require('includes/footer.php');

?>