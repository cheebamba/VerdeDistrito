<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'users';
$title = $T['users'];
$a = $_GET['a'];
if($a == 'friend' && $user['level']>0){
	$e = $_GET['e'];
	if(empty($e)){
		$fid = $_GET['fid'];
		if($fid == $user['id']){
			qs_redirect(900);
		}
		$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE (friend_1='".$user['id']."' AND friend_2='".$fid."') AND friend_status='0'");
		if(mysql_num_rows($sql)>0){
			qs_redirect(120);
		}
		$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE (friend_1='".$user['id']."' AND friend_2='".$fid."') AND friend_status='1'");
		if(mysql_num_rows($sql)>0){
			qs_redirect(121);
		}
		if(mysql_query("INSERT INTO ".$qs_db['friends']."(friend_1, friend_2, friend_status)VALUES('".$user['id']."', '".$fid."', '0')")){
$text = $user['nick'].' '.$L['qs_wantfriend'].' :
<a href="users.php?a=friend&fid='.$user['id'].'&e=a1">'.$L['qs_faccept1'].'</a>
<a href="users.php?a=friend&fid='.$user['id'].'&e=a2">'.$L['qs_faccept2'].'</a>
<a href="users.php?a=friend&fid='.$user['id'].'&e=r">'.$L['qs_freject'].'</a>';
			$date = gmdate("Y-m-d H:i:s");
			mysql_query("INSERT INTO ".$qs_db['pms']."(pm_date, pm_fromuser, pm_touser, pm_title, pm_text) VALUES('".$date."', '".$user['id']."', '".$fid."', '".$L['qs_friendrequest']."', '".$text."')");
			qs_redirect(125);
		}
	}
	else {
		$fid = $_GET['fid'];
		if($e == 'a1'){
			$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE (friend_1='".$fid."' AND friend_2='".$user['id']."') AND friend_status='1'");
			if(mysql_num_rows($sql)>0){
				qs_redirect(122);
			}
			$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE (friend_1='".$fid."' AND friend_2='".$user['id']."') AND friend_status='0'");
			if(mysql_num_rows($sql)>0){
				mysql_query("UPDATE ".$qs_db['friends']." SET friend_status='1' WHERE friend_1='".$fid."' AND friend_2='".$user['id']."'");
				qs_redirect(126);
			}
			else {
				qs_redirect(900);
			}
		}
		elseif($e == 'a2'){
			$sql1 = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$fid."' AND friend_2='".$user['id']."' AND friend_status='1'");
			$sql2 = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$user['id']."' AND friend_2='".$fid."' AND friend_status='1'");
			if(mysql_num_rows($sql1)>0 && mysql_num_rows($sql2)>0){
				qs_redirect(123);
			}
			$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$fid."' AND friend_2='".$user['id']."'  AND (friend_status='0' OR friend_status='1')");
			if(mysql_num_rows($sql)>0){
				mysql_query("UPDATE ".$qs_db['friends']." SET friend_status='1' WHERE friend_1='".$fid."' AND friend_2='".$user['id']."'");
				$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$user['id']."' AND friend_2='".$fid."'  AND friend_status='1'");
				if(mysql_num_rows($sql)<1){
					$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$user['id']."' AND friend_2='".$fid."'  AND friend_status='0'");
					if(mysql_num_rows($sql)>0){
						mysql_query("UPDATE ".$qs_db['friends']." SET friend_status='1' WHERE friend_1='".$user['id']."' AND friend_2='".$fid."'");
						qs_redirect(126);
					}
					else {
						mysql_query("INSERT INTO ".$qs_db['friends']."(friend_1, friend_2, friend_status)VALUES('".$user['id']."', '".$fid."', '1')");
						qs_redirect(126);
					}
				}
				else {
					qs_redirect(126);
				}
			}
		}
		elseif($e == 'r'){
			$sql = mysql_query("SELECT * FROM ".$qs_db['friends']." WHERE friend_1='".$user['id']."' AND friend_2='".$fid."'");
			if(mysql_num_rows($sql)>0){
				if(mysql_query("DELETE FROM ".$qs_db['friends']." WHERE friend_1='".$user['id']."' AND friend_2='".$fid."'")){
					qs_redirect(127);
				}
			}
		}
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('users'));

$s = strtoupper($_GET['s']);
if($s != 'ASC'){
	$s = 'DESC';
}
$b = strtolower($_GET['b']);
if($b != 'nick' && $b != 'level' && $b != 'regdate'){
	$b = 'regdate';
}
$p = (empty($_GET['p'])) ? '1' : $_GET['p'] ;
$pe = $conf['users_maxperpage']*($p-1);

$c = $_GET['c'];
if(!empty($c)){
	if($c == 'forums'){
		$lvlsql = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_acs_forums='1'");
		$i = 0;
		while ($lvlresult = mysql_fetch_array($lvlsql)) {
			$i++;
			if($i == '1'){
				$c = " WHERE user_level='".$lvlresult['level_level']."'";
			}
			else {
				$c .= " OR user_level='".$lvlresult['level_level']."'";
			}
		}
	}
}

$sql = mysql_query("SELECT * FROM ".$qs_db['users']."".$c." ORDER BY user_id");
$count = mysql_num_rows($sql);

@$pages = ceil($count/$conf['users_maxperpage']);
for ($i=0; $i<=$pages; $i++){
	$a = ($i == $p) ? 'a' : '' ;
	if ($i == 1){
		$users_pages = '<a '.$a.'href="users.php?p='.$i.'&b='.$b.'&s='.$s.'">'.$i.'</a>';
	}
	else {
		$users_pages .= ' | <a '.$a.'href="users.php?p='.$i.'&b='.$b.'&s='.$s.'">'.$i.'</a>';
	}
}
$sn = 'ASC';
$sl = 'ASC';
$sr = 'ASC';
if($b == 'nick'){
	$sn = ($s == 'ASC') ? 'DESC' : 'ASC' ;
}
if($b == 'level'){
	$sl = ($s == 'ASC') ? 'DESC' : 'ASC' ;
}
if($b == 'regdate'){
	$sr = ($s == 'ASC') ? 'DESC' : 'ASC' ;
}
if($pages == 1){
	$users_pages = '';
}
if($count<$conf['users_maxperpage']){
	$here = $count;
}
else {
	$here = $conf['users_maxperpage'];
}

$sql2 = mysql_query("SELECT * FROM ".$qs_db['users']."".$c." ORDER BY user_".$b." ".$s." LIMIT ".$pe.",".$conf['users_maxperpage']."");
$counthere = mysql_num_rows($sql2);

$users_pages2 = $users_pages.'<br>'.$L['qs_onpage'].': '.$counthere.'/'.$count;
$users_pages1 = $L['qs_onpage'].': '.$counthere.'/'.$count.'<br>'.$users_pages.'<br><br>';

$tpl->assign(array(
	"USERS_PAGES1" => $users_pages1,
	"USERS_PAGES2" => $users_pages2,
	"USERS_SORTBY_NICK" => '<a href="users.php?b=nick&s='.$sn.'">'.$L['qs_nick'].'</a>',
	"USERS_SORTBY_LEVEL" => '<a href="users.php?b=level&s='.$sl.'">'.$L['qs_level'].'</a>',
	"USERS_SORTBY_REGDATE" => '<a href="users.php?b=regdate&s='.$sr.'">'.$L['qs_regdate'].'</a>',
	"USERS_PM_TEXT" => $L['qs_pm'],
));

$permission = qs_acscheck($user['level'], 'users');
if($permission){
	$tpl->assign("USERS_EDIT", $L['qs_edit']);
}
	
$sql = mysql_query("SELECT * FROM ".$qs_db['users']."".$c." ORDER BY user_".$b."");
if(mysql_num_rows($sql)>0){
	$sql = mysql_query("SELECT * FROM ".$qs_db['users']."".$c." ORDER BY user_".$b." ".$s." LIMIT ".$pe.",".$conf['users_maxperpage']."");
	while ($result = mysql_fetch_array($sql)) {
		$regdate = explode(" ", $result['user_regdate']);
		$tpl->assign(array(
			"USERS_ROW_PM" => '<a href="pm.php?s=new&to='.$result['user_id'].'"><img border="0" src="templates/'.$defskin.'/icons/pm.gif"></a>',
			"USERS_ROW_COUNTRY" => '<img src="includes/images/flags/'.$result['user_origin'].'.gif" alt="'.$F[$result['user_country']].'">',
			"USERS_ROW_NICK" => '<a href="users.php?a=details&id='.$result['user_id'].'"> '.$result['user_nick'].'</a>',
			"USERS_ROW_LEVEL" => $level[$result['user_level']],
			"USERS_ROW_REGDATE" => $regdate[0],
			));
			if($permission && $user['level']>$result['user_level']){
				$tpl->assign("USERS_ROW_EDITLINK", '<a href="users.php?a=edit&id='.$result['user_id'].'">'.$L['qs_edit'].'</a>');
			}
			else {
				$tpl->assign("USERS_ROW_EDITLINK", '');
			}
		$tpl->parse('MAIN.USERS_ROW');
	}
	
}
else{
	$tpl->assign("USERS_NONE", $L['qs_none']);
}

// TEMPLATE VARIABLES



$tpl->assign(array(
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>