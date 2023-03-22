<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'forum';
$title = $T['forum'];

$menuleft = 'OFF';
require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('forum.cats'));

$sql = mysql_query("SELECT * FROM ".$qs_db['fcats']." ORDER BY cat_subid");
while($result = mysql_fetch_array($sql)){
	if($result['cat_minlevel'] <= $user['level']){
		$tpl->assign(array(
			"CAT_SUBID" => $result['cat_subid'],
			"CAT_TITLE" => qs_stripslashes($result['cat_title']),
		));
		$sql2 = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_catid='".$result['cat_id']."' ORDER BY sub_subid");
		while($result2 = mysql_fetch_array($sql2)){
			if($result2['sub_minlevel'] <= $user['level']){
				$sql3 = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$result2['sub_id']."'");
				
				$tcount = mysql_num_rows($sql3);
				$pcount = 0;
				$tdate = 0;
				$pdate = 0;
				$mkpdate = 0;
				$mktdate = 0;
				
				$arenew = 'OFF';
				while($result3 = mysql_fetch_array($sql3)){
					
					$topicaid = 'a'.$result3['topic_id'];
					
					if(($result3['topic_status'] == 0 || $result3['topic_status'] == 2 || $result3['topic_status'] == 4) && $_SESSION[''.$topicaid.''] < $result3['topic_lpdate'] && $user['lastf'] < $result3['topic_lpdate']){
						$arenew = 'ON';
					}
					
					$sql4 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result3['topic_id']."'");
					$pcount += mysql_num_rows($sql4);
					$ttdate = qs_userdate($result3['topic_date'], $user['timezone']);
					$mktdate = mktime($ttdate['h'], $ttdate['i'], $ttdate['s'], $ttdate['m'], $ttdate['d'], $ttdate['y']);
					if($mktdate > $tdate){
						$tdate = $mktdate;
						$topicdate = $ttdate['h'].':'.$ttdate['i'].' '.$ttdate['d'].'-'.$ttdate['m'].'-'.$ttdate['y'];
						$cuser = qs_userdata($result3['topic_ownerid']);
						$towner = '<a href="forum.php?t='.$result3['topic_id'].'"><img src="templates/'.$defskin.'/icons/arrow1.gif"></a> <a href="users.php?id='.$result3['topic_ownerid'].'">'.$cuser['user_nick'].'</a>';
					}
					$sql5 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result3['topic_id']."' ORDER BY post_date DESC LIMIT 0,1");
					if(mysql_num_rows($sql5)){
						$result5 = mysql_fetch_array($sql5);
						$tpdate = qs_userdate($result5['post_date'], $user['timezone']);
						$mkpdate = mktime($tpdate['h'], $tpdate['i'], $tpdate['s'], $tpdate['m'], $tpdate['d'], $tpdate['y']);
					}
					if($mkpdate > $pdate){
						$pdate = $mkpdate;
						$postdate = $tpdate['h'].':'.$tpdate['i'].' '.$tpdate['d'].'-'.$tpdate['m'].'-'.$tpdate['y'];
						$luser = qs_userdata($result5['post_ownerid']);
						$powner = '<a href="forum.php?t='.$result3['topic_id'].'&p=last#'.$result5['post_id'].'"><img src="templates/'.$defskin.'/icons/arrow1.gif"></a> <a href="users.php?id='.$result5['post_ownerid'].'">'.$luser['user_nick'].'</a>';
					}
				}
				if(empty($tdate) && empty($pdate)){
					$lkind = $L['qs_none'];
				}
				elseif($tdate > $pdate){
					$ldate = $topicdate;
					$lowner = $towner;
					$lkind = $L['qs_topic'];
				}
				else{
					$ldate = $postdate;
					$lowner = $powner;
					$lkind = $L['qs_post'];
				}
				
				if($result2['sub_status'] == 1){
					$ico = '<img src="templates/'.$defskin.'/icons/forum_locked.gif">';
				}
				elseif($arenew == 'ON'){
					$ico = '<img src="templates/'.$defskin.'/icons/forum_new.gif">';
				}
				else{
					$ico = '<img src="templates/'.$defskin.'/icons/forum_old.gif">';
				}
				
	$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_catid='".$result2['sub_id']."'");
	$i = 0;
	while ($modresult = mysql_fetch_array($modsql)) {
		$i++;
		$moduser = qs_userdata($modresult['mod_userid']);
		if($i == 1){
			$moderators = '<b><a href="users.php?id='.$moduser['user_id'].'">'.$moduser['user_nick'].'</a></b>';
		}
		else{
			$moderators .= ', <b><a href="users.php?id='.$moduser['user_id'].'">'.$moduser['user_nick'].'</a></b>';
		}
		
	}
	if(empty($moderators)){
		$moderators = $L['qs_none'];
	}
				$tpl->assign(array(
					"SUB_ID" => $result2['sub_id'],
					"SUB_ICO" => $ico,
					"SUB_SUBID" => $result2['sub_subid'],
					"SUB_TITLE" => qs_stripslashes($result2['sub_title']),
					"SUB_DES" => $result2['sub_des'],
					"SUB_MODS" => $moderators,
					"SUB_TEXT_MODS" => '<a href="users.php?c=forums">'.$L['qs_moderators'].'</a>',
					"SUB_TCOUNT" => $tcount,
					"SUB_PCOUNT" => $pcount,
					"SUB_LKIND" => $lkind.'<br>',
					"SUB_LDATE" => $ldate.'<br>',
					"SUB_LOWNER" => $lowner,
				));
				$tpl->parse('MAIN.CAT_ROW.SUB_ROW');
			}
			$lkind = '';
			$ldate = '';
			$lowner = '';
		}
		$tpl->parse('MAIN.CAT_ROW');
	}
}
$msgcsql = mysql_query("SELECT * FROM ".$qs_db['fcats']." WHERE cat_minlevel<='".$user['level']."' ORDER BY cat_id");
while($msgcresult = mysql_fetch_array($msgcsql)){
	$msgssql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_catid='".$msgcresult['cat_id']."' AND sub_minlevel<='".$user['level']."' ORDER BY sub_id");
	while($msgsreulst = mysql_fetch_array($msgssql)){
		$msgtsql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$msgsreulst['sub_id']."' ORDER BY topic_id");
		$msgscount += mysql_num_rows($msgtsql);
		while($msgtresult = mysql_fetch_array($msgtsql)){
			$msgpsql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$msgtresult['topic_id']."' ORDER BY post_id");
			$msgscount += mysql_num_rows($msgpsql);
		}
	}
}

$userssql = mysql_query("SELECT * FROM ".$qs_db['users']." ORDER BY user_regdate DESC");
$userscount = mysql_num_rows($userssql);
$userresult = mysql_fetch_array($userssql);
$mgonline = $gonline+$monline;

$mk5minago = time()-301;
$usersonlinesql = mysql_query("SELECT * FROM ".$qs_db['online']." WHERE online_lastvisit>'".$mk5minago."' && online_userid<>'0'");
$i = 0;
while ($uoresult = mysql_fetch_array($usersonlinesql)) {
	$i++;
	$useronline = qs_userdata($uoresult['online_userid']);
	if($i == 1){
		$usersonline = '<a href="users.php?id='.$useronline['user_id'].'">'.$useronline['user_nick'].'</a>';
	}
	else{
		$usersonline .= ', <a href="users.php?id='.$useronline['user_id'].'">'.$useronline['user_nick'].'</a>';
	}
	
}
if(empty($usersonline)){
	$usersonline = $L['qs_none'];
}

$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);

$tpl->assign(array(
	"CAT_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
	"CAT_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo;',
	"FORUM_STATS_1" => $L['qs_forum_stats_1_1'].' <b>'.$msgscount.'</b> '.$L['qs_forum_stats_1_2'],
	"FORUM_STATS_2" => $L['qs_forum_stats_2_1'].' <b>'.$userscount.'</b> '.$L['qs_forum_stats_2_2'],
	"FORUM_STATS_3" => $L['qs_forum_stats_3'].': <a href="users.php?id='.$userresult['user_id'].'"><b>'.$userresult['user_nick'].'</b></a>',
	"FORUM_STATS_4" => $L['qs_forum_stats_4_1'].' <b>'.$mgonline.'</b> '.$L['qs_forum_stats_4_2'].' : <b>'.$monline.'</b> '.$L['qs_forum_stats_4_3'].', <b>'.$gonline.'</b> '.$L['qs_forum_stats_4_4'],
	"FORUM_STATS_5" => $L['qs_forum_stats_5'].': <b>'.$usersonline.'</b>',
	"TEXT_FORUM" => $L['qs_forum'],
	"TEXT_TOPICS" => $L['qs_topics'],
	"TEXT_POSTS" => $L['qs_posts'],
	"TEXT_LAST" => $L['qs_last'],
	"TEXT_WHOSHERE" => $L['qs_whosonforum'],
	"TEXT_NEW_POSTS" => $L['qs_new_posts'],
	"TEXT_NONE_NEW" => $L['qs_none_new_posts'],
	"TEXT_FORUM_LOCKED" => $L['qs_forum_locked']
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>