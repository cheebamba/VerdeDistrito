<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'forum';

$id = $_GET['id'];

$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
$result = mysql_fetch_array($sql);

$title = $T['forum'].': '.qs_stripslashes($result['sub_title']);

if(mysql_num_rows($sql)<=0){
	qs_redirect(117);
}
else{
	
	$tpp = 30;
	
	$p = (empty($_GET['p'])) ? '1' : $_GET['p'] ;
	$pe = $tpp*($p-1);
	
	$psql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$id."' && (topic_status<>'4' && topic_status<>'5')");
	$psqlcount = 0;
	while ($presult = mysql_fetch_array($psql)) {
		$ssql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
		$sresult = mysql_fetch_array($ssql);
		if($sresult['sub_minlevel']<=$user['level']){
			$psqlcount++;
		}
	}
	$postsql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$id."' && (topic_status='2' OR topic_status='3')");
	$pcount = mysql_num_rows($postsql);
	if($p == 1){
		$p1 = $tpp-$pcount;
		$p2 = 0;
	}
	else{
		$p2 = ($tpp*($p-1))-$psqlcount;
		$p1 = $tpp;
	}
	$pages = ceil($psqlcount/$tpp);
	$pages = ($pages == 0) ? 1 : $pages;
	
	if($p>$pages){
		if(mysql_num_rows($sql)<=0){
			qs_redirect(117);
		}
	}
	
	$pages1 = $L['qs_page'].'&nbsp;&nbsp;'.$p.'&nbsp;&nbsp;'.$L['qs_from2'].'&nbsp;&nbsp;'.$pages;
	
	if($p != 1){
		$posts_pages .= '<b><a href="forum.php?id='.$id.'&p='.($p-1).'">&laquo;</a></b> ';
	}
	for ($i=1; $i<=$pages; $i++){
		if($pages != 1){
			$a = ($i == $p) ? $i : '<b><a href="forum.php?id='.$id.'&p='.$i.'">'.$i.'</a></b>' ;
			if ($i == 1){
				$posts_pages .= $a;
			}
			else {
				$posts_pages .= ' | '.$a;
			}
		}
	}
	if($p != $pages){
		$posts_pages .= ' <b><a href="forum.php?id='.$id.'&p='.($p+1).'">&raquo;</a></b>';
	}
	
	if($user['level']>0){
		$where = strrchr($_SERVER['SCRIPT_NAME'], '/');
		$lenwhere = strlen($where)-5;
		$where = substr($where,1,$lenwhere);
		mysql_query("UPDATE ".$qs_db['online']." SET online_where='".$where.":".$id."' WHERE online_userid='".$user['id']."'");
	}
	$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
	$result = mysql_fetch_array($sql);
	
	$sqlcat = mysql_query("SELECT * FROM ".$qs_db['fcats']." WHERE cat_id='".$result['sub_catid']."'");
	$resultcat = mysql_fetch_array($sqlcat);
	
	if($resultcat['cat_minlevel'] > $user['level']){
		qs_redirect(107);
	}
	
	if($result['sub_minlevel'] > $user['level']){
		qs_redirect(107);
	}
	
	$menuleft = 'OFF';
	require('includes/header.php');
	$tpl = new XTemplate(qs_tplfile('forum.subcat'));
	
	$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_catid='".$id."'");
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
	
	if($result['sub_status'] == '0'){
		$button = '<a href="forum.php?m=new&id='.$result['sub_id'].'"><img src="templates/'.$defskin.'/icons/forum_new_topic.gif"></a>';
	}
	elseif($result['sub_status'] == '1'){
		$button = '<img src="templates/'.$defskin.'/icons/forum_new_locked.gif">';
	}
	$tpl->assign(array(
		"SUB_NEW_BUTTON" => $button,
		"SUB_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$id.'">'.qs_stripslashes($result['sub_title']).'</a>',
		"SUB_MODS" => $moderators,
		"SUB_PAGES2" => $posts_pages,
		"SUB_PAGES1" => $pages1,
	));
	
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$id."' && (topic_status='4' OR topic_status='5') && topic_minlevel<='".$user['level']."' ORDER BY topic_lpdate");
	$i = 0;
	while ($result2 = mysql_fetch_array($sql2)) {
		if($result2['topic_minlevel'] <= $user['level']){
			$i++;
			$sql3 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result2['topic_id']."' ORDER BY post_date");
			$postscount = mysql_num_rows($sql3);
			if($postscount != 0){
				$sql4 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result2['topic_id']."' ORDER BY post_date DESC LIMIT 0,1");
				$result4 = mysql_fetch_array($sql4);
				$luser = qs_userdata($result4['post_ownerid']);
				$ldate = qs_userdate($result4['post_date'], $user['timezone']);
				$tpl->assign(array(
					"TOPIC_LOWNER" => '<a href="forum.php?t='.$result2['topic_id'].'&p=last#'.$result4['post_id'].'"><img src="templates/'.$defskin.'/icons/arrow1.gif"></a> <a href="users.php?id='.$luser['user_id'].'">'.$luser['user_nick'].'</a>',
					"TOPIC_LDATE" => $ldate['h'].':'.$ldate['i'].' '.$ldate['d'].'-'.$ldate['m'].'-'.$ldate['y']
				));
				$tpl->parse('MAIN.ADVERT_ROW.LP_ROW');
			}
			else{
				$tpl->assign(array(
					"TOPIC_LEMPTY" => $L['qs_none'],
				));
				$tpl->parse('MAIN.ADVERT_ROW.LP_EMPTY');
			}
			
			$topicaid = 'a'.$result2['topic_id'];
				
			if($result2['topic_status'] == 5){
				$ico = '<img src="templates/'.$defskin.'/icons/forum_advert_locked.gif">';
			}
			elseif($result2['topic_status'] == 4 && $_SESSION[''.$topicaid.''] < $result2['topic_lpdate'] && $user['lastf'] < $result2['topic_lpdate']){
				$ico = '<img src="templates/'.$defskin.'/icons/forum_advert_new.gif">';
			}
			else{
				$ico = '<img src="templates/'.$defskin.'/icons/forum_advert_old.gif">';
			}
			
			$cuser = qs_userdata($result2['topic_ownerid']);
			$cdate = qs_userdate($result2['topic_date'], $user['timezone']);
			$tpl->assign(array(
				"TOPIC_ICO" => $ico,
				"TOPIC_ID" => $result2['topic_id'],
				"TOPIC_TITLE" => $result2['topic_title'],
				"TOPIC_VIEWS" => $result2['topic_views'],
				"TOPIC_POSTS" => $postscount,
				"TOPIC_COWNER" => '<a href="users.php?id='.$cuser['user_id'].'">'.$cuser['user_nick'].'</a>',
				"TOPIC_CDATE" => $cdate['h'].':'.$cdate['i'].' '.$cdate['d'].'-'.$cdate['m'].'-'.$cdate['y'],
			));
			$tpl->parse('MAIN.ADVERT_ROW');
		}
	}
	if($i>0){
		$tpl->assign(array(
			"TEXT_ADVERT" => $L['qs_advert'],
		));
		$tpl->parse('MAIN.ADVERT_B');
		$tpl->assign(array(
			"TEXT_TOPICS" => $L['qs_topics'],
		));
		$tpl->parse('MAIN.ADVERT_E');
	}
	
	$sql2 = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$id."' && (topic_status='0' OR topic_status='1') && topic_minlevel<='".$user['level']."' ORDER BY topic_lpdate DESC LIMIT ".$p2.",".$p1."");
	$sql3 = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$id."' && (topic_status='0' OR topic_status='1' OR topic_status='2' OR topic_status='3') && topic_minlevel<='".$user['level']."' ORDER BY topic_lpdate DESC");
	$sql4 = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_subcatid='".$id."' && (topic_status='2' OR topic_status='3') && topic_minlevel<='".$user['level']."' ORDER BY topic_lpdate DESC");
	if(mysql_num_rows($sql3) == 0){
		$tpl->assign(array(
			"TOPIC_EMPTY" => $L['qs_nonetopics'],
		));
		$tpl->parse('MAIN.TOPIC_EMPTY');
	}
	else {
		if($p == 1){
			while($result2 = mysql_fetch_array($sql4)){
				if($result2['topic_minlevel'] <= $user['level']){
					$sql3 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result2['topic_id']."' ORDER BY post_date");
					$postscount = mysql_num_rows($sql3);
					if($postscount != 0){
						$sql4 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result2['topic_id']."' ORDER BY post_date DESC LIMIT 0,1");
						$result4 = mysql_fetch_array($sql4);
						$luser = qs_userdata($result4['post_ownerid']);
						$ldate = qs_userdate($result4['post_date'], $user['timezone']);
						$tpl->assign(array(
							"TOPIC_LOWNER" => '<a href="forum.php?t='.$result2['topic_id'].'&p=last#'.$result4['post_id'].'"><img src="templates/'.$defskin.'/icons/arrow1.gif"></a> <a href="users.php?id='.$luser['user_id'].'">'.$luser['user_nick'].'</a>',
							"TOPIC_LDATE" => $ldate['h'].':'.$ldate['i'].' '.$ldate['d'].'-'.$ldate['m'].'-'.$ldate['y']
						));
						$tpl->parse('MAIN.STICKED_ROW.LP_ROW');
					}
					else{
						$tpl->assign(array(
							"TOPIC_LEMPTY" => $L['qs_none'],
						));
						$tpl->parse('MAIN.STICKED_ROW.LP_EMPTY');
					}
					
					$topicaid = 'a'.$result2['topic_id'];
				
					if($result2['topic_status'] == 3){
						$ico = '<img src="templates/'.$defskin.'/icons/forum_sticked_locked.gif">';
					}
					elseif($result2['topic_status'] == 2 && $_SESSION[''.$topicaid.''] < $result2['topic_lpdate'] && $user['lastf'] < $result2['topic_lpdate']){
						$ico = '<img src="templates/'.$defskin.'/icons/forum_sticked_new.gif">';
					}
					else{
						$ico = '<img src="templates/'.$defskin.'/icons/forum_sticked_old.gif">';
					}
					
					$cuser = qs_userdata($result2['topic_ownerid']);
					$cdate = qs_userdate($result2['topic_date'], $user['timezone']);
					$tpl->assign(array(
						"TOPIC_ICO" => $ico,
						"TOPIC_ID" => $result2['topic_id'],
						"TOPIC_TITLE" => $result2['topic_title'],
						"TOPIC_VIEWS" => $result2['topic_views'],
						"TOPIC_POSTS" => $postscount,
						"TOPIC_COWNER" => '<a href="users.php?id='.$cuser['user_id'].'">'.$cuser['user_nick'].'</a>',
						"TOPIC_CDATE" => $cdate['h'].':'.$cdate['i'].' '.$cdate['d'].'-'.$cdate['m'].'-'.$cdate['y'],
					));
					$tpl->parse('MAIN.STICKED_ROW');
				}
			}
		}
		$i = 0;
		while($result2 = mysql_fetch_array($sql2)){
			if($result2['topic_minlevel'] <= $user['level']){
				$i++;
				$sql3 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result2['topic_id']."' ORDER BY post_date");
				$postscount = mysql_num_rows($sql3);
				if($postscount != 0){
					$sql4 = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$result2['topic_id']."' ORDER BY post_date DESC LIMIT 0,1");
					$result4 = mysql_fetch_array($sql4);
					$luser = qs_userdata($result4['post_ownerid']);
					$ldate = qs_userdate($result4['post_date'], $user['timezone']);
					$tpl->assign(array(
						"TOPIC_LOWNER" => '<a href="forum.php?t='.$result2['topic_id'].'&p=last#'.$result4['post_id'].'"><img src="templates/'.$defskin.'/icons/arrow1.gif"></a> <a href="users.php?id='.$luser['user_id'].'">'.$luser['user_nick'].'</a>',
						"TOPIC_LDATE" => $ldate['h'].':'.$ldate['i'].' '.$ldate['d'].'-'.$ldate['m'].'-'.$ldate['y']
					));
					$tpl->parse('MAIN.TOPIC_ROW.LP_ROW');
				}
				else{
					$tpl->assign(array(
						"TOPIC_LEMPTY" => $L['qs_none'],
					));
					$tpl->parse('MAIN.TOPIC_ROW.LP_EMPTY');
				}
				
				$topicaid = 'a'.$result2['topic_id'];
				
				if($result2['topic_status'] == 1){
					$ico = '<img src="templates/'.$defskin.'/icons/forum_topic_locked.gif">';
				}
				elseif($result2['topic_status'] == 0 && $_SESSION[''.$topicaid.''] < $result2['topic_lpdate'] && $user['lastf'] < $result2['topic_lpdate']){
					$ico = '<img src="templates/'.$defskin.'/icons/forum_topic_new.gif">';
				}
				else{
					$ico = '<img src="templates/'.$defskin.'/icons/forum_topic_old.gif">';
				}
				
				$cuser = qs_userdata($result2['topic_ownerid']);
				$cdate = qs_userdate($result2['topic_date'], $user['timezone']);
				$tpl->assign(array(
					"TOPIC_ICO" => $ico,
					"TOPIC_ID" => $result2['topic_id'],
					"TOPIC_TITLE" => qs_stripslashes($result2['topic_title']),
					"TOPIC_VIEWS" => $result2['topic_views'],
					"TOPIC_POSTS" => $postscount,
					"TOPIC_COWNER" => '<a href="users.php?id='.$cuser['user_id'].'">'.$cuser['user_nick'].'</a>',
					"TOPIC_CDATE" => $cdate['h'].':'.$cdate['i'].' '.$cdate['d'].'-'.$cdate['m'].'-'.$cdate['y'],
				));
				$tpl->parse('MAIN.TOPIC_ROW');
			}
		}
		if($i<1){
			$tpl->assign(array(
				"TOPIC_EMPTY" => $L['qs_nonetopics'],
			));
			$tpl->parse('MAIN.TOPIC_EMPTY');
		}
	}
	
	$mk5minago = time()-301;
	$usersonlinesql = mysql_query("SELECT * FROM ".$qs_db['online']." WHERE online_lastvisit>'".$mk5minago."' && online_userid<>'0' && online_where='forum:".$id."'");
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
		"SUB_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
		"SUB_WHOSHERE" => $usersonline,
		"TEXT_MODS" => '<a href="users.php?c=forums">'.$L['qs_moderators'].'</a>',
		"TEXT_TOPICS" => $L['qs_topics'],
		"TEXT_REPLYS" => $L['qs_replys'],
		"TEXT_AUTHOR" => $L['qs_author'],
		"TEXT_LASTP" => $L['qs_lastp'],
		"TEXT_VIEWS" => $L['qs_views'],
		"TEXT_WHOSHERE" => $L['qs_userswatchingf'],
		"TEXT_TOPIC_NEW" => $L['qs_topic_new'],
		"TEXT_TOPIC_OLD" => $L['qs_topic_old'],
		"TEXT_TOPIC_LOCKED" => $L['qs_topic_locked'],
		"TEXT_STICKED_NEW" => $L['qs_sticked_new'],
		"TEXT_STICKED_OLD" => $L['qs_sticked_old'],
		"TEXT_STICKED_LOCKED" => $L['qs_sticked_locked'],
		"TEXT_ADVERT_NEW" => $L['qs_advert_new'],
		"TEXT_ADVERT_OLD" => $L['qs_advert_old'],
		"TEXT_ADVERT_LOCKED" => $L['qs_advert_locked'],
	));
	
	$tpl->parse('MAIN');
	$tpl->out('MAIN');
	require('includes/footer.php');
}

?>