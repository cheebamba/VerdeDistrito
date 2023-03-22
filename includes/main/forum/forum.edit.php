<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'forum';

$m = $_GET['m'];
if(empty($m)){
	$m = $_POST['m'];
}
$id = $_GET['id'];
if(empty($id)){
	$id = $_POST['id'];
}
$t = $_GET['t'];
if(empty($t)){
	$t = $_POST['t'];
}
$p = $_GET['p'];
if(empty($p)){
	$p = $_POST['p'];
}
$a = $_POST['a'];

if($m == 'new'){
	if(!empty($id)){
		$sqlcat = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
		$resultcat = mysql_fetch_array($sqlcat);
		if($user['level'] == 0){
			qs_redirect(106);
		}
		elseif($resultcat['sub_minlevel'] > $user['level']){
			qs_redirect(107);
		}
		if($a == 'add'){
			$topic = $_POST['title'];
			$text = $_POST['text'];
			$topic_status = 0;
			$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$id."'");
			if(qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
				$radio = $_POST['radio1'];
				if($locked == 'ON'){
					$checkedl = 'checked';
				}
				$locked = $_POST['locked'];
				if($radio == 'common'){
					$checkedc = 'checked';
					if($locked == 'ON'){
						$topic_status = 1;
					}
					else{
						$topic_status = 0;
					}
				}
				elseif($radio == 'sticked'){
					$checkeds = 'checked';
					if($locked == 'ON'){
						$topic_status = 3;
					}
					else{
						$topic_status = 2;
					}
				}
				elseif($radio == 'advert'){
					$checkeda = 'checked';
					if($locked == 'ON'){
						$topic_status = 5;
					}
					else{
						$topic_status = 4;
					}
				}
				
			}
			if(qs_isgoodlength($text, 1, 0) && qs_isgoodlength($topic, 1, 64)){
				$text = qs_addslashes($text);
				$title = qs_addslashes($title);
				if(mysql_query("INSERT INTO ".$qs_db['topics']."(topic_title, topic_text, topic_subcatid, topic_ownerid, topic_lpdate, topic_date, topic_status) VALUES('".$topic."', '".$text."', '".$id."', '".$user['id']."', '".gmdate("Y-m-d H:i:s")."', '".gmdate("Y-m-d H:i:s")."', '".$topic_status."')")){
					qs_redirect(400, 'forum.php?t='.mysql_insert_id());
				}
			}
			else{
				if(!qs_isgoodlength($topic, 1, 64)){
					$error_text = $L['qs_topicwronglen'].'<br>';
				}
				if(!qs_isgoodlength($text, 1, 0)){
					$error_text .= $L['qs_messagewronglen'].'<br>';
				}
			}
		}
		
		$bbform = 'form';
		$bbinput = 'text';
		
		$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
		$result = mysql_fetch_array($sql);
		
		$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);
		
		$title = $L['qs_forum'].': '.$L['qs_newtopic'].' - '.$resultcat['sub_title'];
		
		require('includes/header.php');
		$tpl = new XTemplate(qs_tplfile('forum.edit'));
		
		if(empty($checkeda) && empty($checkeds)){
			$checkedc = 'checked';
		}
		
		if(!empty($error_text)){
			$error_text = '<br><br><b>'.$error_text.'</b><br>';
		}
		
		$tpl->assign(array(
			"TOPIC_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
			"TOPIC_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$id.'">'.$result['sub_title'].'</a>',
			"TOPIC_TEXT_WRITE" => $L['qs_writenewtopic'],
			"TOPIC_ERROR" => $error_text,
			"TOPIC_BBCBOX" => qs_bbcbox2(),
			"TOPIC_FORM_TOPIC" => '<input type="text" name="title" size="60" value="'.$topic.'">',
			"TOPIC_TEXT_TOPIC" => $L['qs_topic'],
			"TOPIC_FORM_TEXT" => '<textarea rows="20" name="text" cols="80">'.$text.'</textarea>',
			"TOPIC_TEXT_TEXT" => $L['qs_message'],
			"TOPIC_SMILES" => qs_smilesbox('form', 'text'),
			"TOPIC_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="id" value="'.$id.'"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
		));
		
		$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$id."'");
		
		if(qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
			$tpl->assign(array(
				"ADMIN_TEXT_LOCKED" => $L['qs_lock'],
				"ADMIN_LOCKED" => '<input type="checkbox" name="locked" value="ON"  '.$checkedl.'>',
				"ADMIN_TEXT_COMMON" => $L['qs_common'],
				"ADMIN_COMMON" => '<input name="radio1" type="radio" value="common"  '.$checkedc.'>',
				"ADMIN_TEXT_ADVERT" => $L['qs_advert'],
				"ADMIN_ADVERT" => '<input name="radio1" type="radio" value="advert" '.$checkeda.'>',
				"ADMIN_TEXT_STICKED" => $L['qs_sticked'],
				"ADMIN_STICKED" => '<input name="radio1" type="radio" value="sticked" '.$checkeds.'>',
			));
			$tpl->parse('MAIN.TOPIC_ROW.ADMIN_ROW');
		}
		
		$tpl->parse('MAIN.TOPIC_ROW');
		$tpl->parse('MAIN');
		$tpl->out('MAIN');
		require('includes/footer.php');
	}
}
elseif($m == 'reply'){
	if(!empty($t)){
		$tsql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_id='".$t."'");
		$tresult = mysql_fetch_array($tsql);
		$sqlcat = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$tresult['topic_subcatid']."'");
		$resultcat = mysql_fetch_array($sqlcat);
		if($user['level'] == 0){
			qs_redirect(106);
		}
		elseif($resultcat['sub_minlevel'] > $user['level'] || $tresult['topic_minlevel'] > $user['level']){
			qs_redirect(107);
		}
		if($a == 'add'){
			$text = $_POST['text'];
			$aspsql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$tresult['topic_id']."' ORDER BY post_date DESC LIMIT 0,1");
			$aspresult = mysql_fetch_array($aspsql);
			if($aspresult['post_ownerid'] == $user['id'] || ($tresult['topic_ownerid'] == $user['id'] && mysql_num_rows($aspsql) == 0)){
				$error_text = $L['qs_asblock'].'<br>';
			}
			else{
				if(qs_isgoodlength($text, 1, 0)){
					$text = qs_addslashes($text);
					if(mysql_query("INSERT INTO ".$qs_db['posts']."(post_text, post_topicid, post_ownerid, post_date) VALUES('".$text."', '".$t."', '".$user['id']."', '".gmdate("Y-m-d H:i:s")."')")){
						$mysql_insert_id = mysql_insert_id();
						mysql_query("UPDATE ".$qs_db['topics']." SET topic_lpdate='".gmdate("Y-m-d H:i:s")."' WHERE topic_id='".$tresult['topic_id']."'");
						header("Location: forum.php?t=".$t."&p=last#".$mysql_insert_id);
					}
				}
				else{
					if(!qs_isgoodlength($text, 1, 0)){
						$error_text = $L['qs_messagewronglen'].'<br>';
					}
				}
			}
		}
		
		$bbform = 'form';
		$bbinput = 'text';
		
		$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$tresult['topic_subcatid']."'");
		$result = mysql_fetch_array($sql);
		
		$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);
		
		$title = $L['qs_forum'].': '.$L['qs_reply'].' - '.$tresult['topic_title'];
		
		require('includes/header.php');
		$tpl = new XTemplate(qs_tplfile('forum.edit'));

		if(!empty($error_text)){
			$error_text = '<br><br><b>'.$error_text.'</b><br>';
		}
		
		$tpl->assign(array(
			"POST_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
			"POST_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$result['sub_id'].'">'.$result['sub_title'].'</a> &raquo; <a href="forum.php?t='.$t.'">'.$tresult['topic_title'].'</a>',
			"POST_TEXT_WRITE" => $L['qs_writereply'],
			"POST_ERROR" => $error_text,
			"POST_BBCBOX" => qs_bbcbox2(),
			"POST_FORM_TEXT" => '<textarea rows="20" name="text" cols="80">'.$text.'</textarea>',
			"POST_TEXT_TEXT" => $L['qs_message'],
			"POST_SMILES" => qs_smilesbox('form', 'text'),
			"POST_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="t" value="'.$t.'"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
		));
		
		$tpl->parse('MAIN.REPLY_ROW');
		$tpl->parse('MAIN');
		$tpl->out('MAIN');
		require('includes/footer.php');
	}
}
elseif($m == 'quote'){
	if(!empty($t)){
		$title = $L['qs_forum'].': '.$L['qs_reply'];
		$tsql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_id='".$t."'");
		$tresult = mysql_fetch_array($tsql);
		$sqlcat = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$tresult['topic_subcatid']."'");
		$resultcat = mysql_fetch_array($sqlcat);
		if($user['level'] == 0){
			qs_redirect(106);
		}
		elseif($resultcat['sub_minlevel'] > $user['level'] || $tresult['topic_minlevel'] > $user['level']){
			qs_redirect(107);
		}
		if($a == 'add'){
			$text = $_POST['text'];
			$aspsql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$tresult['topic_id']."' ORDER BY post_date DESC LIMIT 0,1");
			$aspresult = mysql_fetch_array($aspsql);
			if($aspresult['post_ownerid'] != $user['id'] || !($tresult['topic_ownerid'] == $user['id'] && mysql_num_rows($aspsql) == 0)){
				$error_text = $L['qs_asblock'].'<br>';
			}
			else{
				if(qs_isgoodlength($text, 1, 0)){
					$text = qs_addslashes($text);
					if(mysql_query("INSERT INTO ".$qs_db['posts']."(post_text, post_topicid, post_ownerid, post_date) VALUES('".$text."', '".$t."', '".$user['id']."', '".gmdate("Y-m-d H:i:s")."')")){
						$mysql_insert_id = mysql_insert_id();
						mysql_query("UPDATE ".$qs_db['topics']." SET topic_lpdate='".gmdate("Y-m-d H:i:s")."' WHERE topic_id='".$tresult['topic_id']."'");
						header("Location: forum.php?t=".$t."&p=last#".$mysql_insert_id);
					}
				}
				else{
					if(!qs_isgoodlength($text, 1, 0)){
						$error_text = $L['qs_messagewronglen'].'<br>';
					}
				}
			}
		}
		
		$bbform = 'form';
		$bbinput = 'text';
		
		$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$tresult['topic_subcatid']."'");
		$result = mysql_fetch_array($sql);
		
		$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);
		
		$title = $L['qs_forum'].': '.$L['qs_reply'].' - '.$tresult['topic_title'];
		
		require('includes/header.php');
		$tpl = new XTemplate(qs_tplfile('forum.edit'));

		$quser = qs_userdata($tresult['topic_ownerid']);
		
		if(!empty($error_text)){
			$error_text = '<br><br><b>'.$error_text.'</b><br>';
		}
		
		$tpl->assign(array(
			"POST_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
			"POST_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$result['sub_id'].'">'.$result['sub_title'].'</a> &raquo; <a href="forum.php?id='.$t.'">'.$tresult['topic_title'].'</a>',
			"POST_TEXT_WRITE" => $L['qs_writereply'],
			"POST_ERROR" => $error_text,
			"POST_BBCBOX" => qs_bbcbox2(),
			"POST_FORM_TEXT" => '<textarea rows="20" name="text" cols="80">[quote='.$quser['user_nick'].']'.$tresult['topic_text'].'[/quote]</textarea>',
			"POST_TEXT_TEXT" => $L['qs_message'],
			"POST_SMILES" => qs_smilesbox('form', 'text'),
			"POST_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="t" value="'.$t.'"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
		));
		
		$tpl->parse('MAIN.REPLY_ROW');
		$tpl->parse('MAIN');
		$tpl->out('MAIN');
		require('includes/footer.php');
	}
	elseif(!empty($p)){
		$postsql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_id='".$p."'");
		$postresult = mysql_fetch_array($postsql);
		$t = $postresult['post_topicid'];
		$title = $L['qs_forum'].': '.$L['qs_reply'];
		$tsql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_id='".$t."'");
		$tresult = mysql_fetch_array($tsql);
		$sqlcat = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$tresult['topic_subcatid']."'");
		$resultcat = mysql_fetch_array($sqlcat);
		if($user['level'] == 0){
			qs_redirect(106);
		}
		elseif($resultcat['sub_minlevel'] > $user['level'] || $tresult['topic_minlevel'] > $user['level']){
			qs_redirect(107);
		}
		if($a == 'add'){
			$text = $_POST['text'];
			$aspsql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_topicid='".$tresult['topic_id']."' ORDER BY post_date DESC LIMIT 0,1");
			$aspresult = mysql_fetch_array($aspsql);
			if($aspresult['post_ownerid'] != $user['id'] || !($tresult['topic_ownerid'] == $user['id'] && mysql_num_rows($aspsql) == 0)){
				$error_text = $L['qs_asblock'].'<br>';
			}
			else{
				if(qs_isgoodlength($text, 1, 0)){
					$text = qs_addslashes($text);
					if(mysql_query("INSERT INTO ".$qs_db['posts']."(post_text, post_topicid, post_ownerid, post_date) VALUES('".$text."', '".$t."', '".$user['id']."', '".gmdate("Y-m-d H:i:s")."')")){
						$mysql_insert_id = mysql_insert_id();
						mysql_query("UPDATE ".$qs_db['topics']." SET topic_lpdate='".gmdate("Y-m-d H:i:s")."' WHERE topic_id='".$tresult['topic_id']."'");
						qs_redirect(400, 'forum.php?t='.$t."&p=last#".$mysql_insert_id);
					}
				}
				else{
					if(!qs_isgoodlength($text, 1, 0)){
						$error_text = $L['qs_messagewronglen'].'<br>';
					}
				}
			}
		}
		
		$bbform = 'form';
		$bbinput = 'text';
		
		$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$tresult['topic_subcatid']."'");
		$result = mysql_fetch_array($sql);
		
		$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);
		
		$title = $L['qs_forum'].': '.$L['qs_reply'].' - '.$tresult['topic_title'];
		
		require('includes/header.php');
		$tpl = new XTemplate(qs_tplfile('forum.edit'));

		$quser = qs_userdata($postresult['post_ownerid']);
		
		if(!empty($error_text)){
			$error_text = '<br><br><b>'.$error_text.'</b><br>';
		}
		
		$tpl->assign(array(
			"POST_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
			"POST_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$result['sub_id'].'">'.$result['sub_title'].'</a> &raquo; <a href="forum.php?id='.$t.'">'.$tresult['topic_title'].'</a>',
			"POST_TEXT_WRITE" => $L['qs_writereply'],
			"POST_ERROR" => $error_text,
			"POST_BBCBOX" => qs_bbcbox2(),
			"POST_FORM_TEXT" => '<textarea rows="20" name="text" cols="80">[quote='.$quser['user_nick'].']'.$postresult['post_text'].'[/quote]</textarea>',
			"POST_TEXT_TEXT" => $L['qs_message'],
			"POST_SMILES" => qs_smilesbox('form', 'text'),
			"POST_FORM_SEND" => '<input type="hidden" name="a" value="add"><input type="hidden" name="t" value="'.$t.'"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
		));
		
		$tpl->parse('MAIN.REPLY_ROW');
		$tpl->parse('MAIN');
		$tpl->out('MAIN');
		require('includes/footer.php');
	}
}
elseif($m == 'edit'){
	if(!empty($t)){
		$tsql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_id='".$t."'");
		$tresult = mysql_fetch_array($tsql);
		$id = $tresult['topic_subcatid'];
		if(!empty($id)){
		$sqlcat = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
		$resultcat = mysql_fetch_array($sqlcat);
		$towner = qs_userdata($tresult['topic_ownerid']);
		$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$id."'");
		if(($resultcat['sub_minlevel'] <= $user['level'] && $tresult['topic_ownerid'] == $user['id']) || qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
			
		}
		else{
			qs_redirect(107);
		}
		if($a == 'update'){
			$topic = $_POST['title'];
			$text = $_POST['text'];
			$moveto = $_POST['moveto'];
			$topic_status = 0;
			
			if(qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
				$del = $_POST['del'];
				if($del == 'ON'){
					if(mysql_query("DELETE FROM ".$qs_db['topics']." WHERE topic_id='".$t."'")){
						if(mysql_query("DELETE FROM ".$qs_db['posts']." WHERE post_topicid='".$t."'")){
							qs_redirect(400, 'forum.php?id='.$resultcat['sub_id']);
						}
					}
				}
				$radio = $_POST['radio1'];
				if($locked == 'ON'){
					$checkedl = 'checked';
				}
				$locked = $_POST['locked'];
				if($radio == 'common'){
					$checkedc = 'checked';
					if($locked == 'ON'){
						$topic_status = 1;
					}
					else{
						$topic_status = 0;
					}
				}
				elseif($radio == 'sticked'){
					$checkeds = 'checked';
					if($locked == 'ON'){
						$topic_status = 3;
					}
					else{
						$topic_status = 2;
					}
				}
				elseif($radio == 'advert'){
					$checkeda = 'checked';
					if($locked == 'ON'){
						$topic_status = 5;
					}
					else{
						$topic_status = 4;
					}
				}
				
			}
			
			if(!empty($moveto)){
				$moveto = ", topic_subcatid='".$moveto."'";
			}
			
			if(qs_isgoodlength($text, 1, 0) && qs_isgoodlength($topic, 1, 64)){
				$text = qs_addslashes($text);
				$title = qs_addslashes($title);
				if(mysql_query("UPDATE ".$qs_db['topics']." SET topic_title='".$topic."', topic_text='".$text."', topic_status='".$topic_status."'".$moveto." WHERE topic_id='".$t."'")){
					qs_redirect(400, 'forum.php?t='.$t);
				}
			}
			else{
				if(!qs_isgoodlength($topic, 1, 64)){
					$error_text = $L['qs_topicwronglen'].'<br>';
				}
				if(!qs_isgoodlength($text, 1, 0)){
					$error_text .= $L['qs_messagewronglen'].'<br>';
				}
			}
		}
		$topic = $tresult['topic_title'];
		$text = $tresult['topic_text'];
		if(qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
			if($tresult['topic_status'] == 0){
				$checkedc = 'checked';
			}
			elseif($tresult['topic_status'] == 1){
				$checkedc = 'checked';
				$checkedl = 'checked';
			}
			elseif($tresult['topic_status'] == 2){
				$checkeds = 'checked';
			}
			elseif($tresult['topic_status'] == 3){
				$checkeds = 'checked';
				$checkedl = 'checked';
			}
			elseif($tresult['topic_status'] == 4){
				$checkeda = 'checked';
			}
			elseif($tresult['topic_status'] == 5){
				$checkeda = 'checked';
				$checkedl = 'checked';
			}
		}
		
		$bbform = 'form';
		$bbinput = 'text';
		
		$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
		$result = mysql_fetch_array($sql);
		
		$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);
		
		$title = $L['qs_forum'].': '.$L['qs_newtopic'].' - '.$resultcat['sub_title'];
		
		require('includes/header.php');
		$tpl = new XTemplate(qs_tplfile('forum.edit'));
		
		if(empty($checkeda) && empty($checkeds)){
			$checkedc = 'checked';
		}
		
		if(!empty($error_text)){
			$error_text = '<br><br><b>'.$error_text.'</b><br>';
		}
		
		$tpl->assign(array(
			"TOPIC_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
			"TOPIC_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$id.'">'.$result['sub_title'].'</a> &raquo; <a href="forum.php?t='.$tresult['topic_id'].'">'.$tresult['topic_title'].'</a>',
			"TOPIC_TEXT_WRITE" => $L['qs_edittopic'],
			"TOPIC_ERROR" => $error_text,
			"TOPIC_BBCBOX" => qs_bbcbox2(),
			"TOPIC_FORM_TOPIC" => '<input type="text" name="title" size="60" value="'.$topic.'">',
			"TOPIC_TEXT_TOPIC" => $L['qs_topic'],
			"TOPIC_FORM_TEXT" => '<textarea rows="20" name="text" cols="80">'.$text.'</textarea>',
			"TOPIC_TEXT_TEXT" => $L['qs_message'],
			"TOPIC_SMILES" => qs_smilesbox('form', 'text'),
			"TOPIC_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="t" value="'.$t.'"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
		));
		
		$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$id."'");
		
		if(qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
			$select = '<select name="moveto">';
			$select .= '<option value="" selected>---------------</option>';
			
			$fcsql = mysql_query("SELECT * FROM ".$qs_db['fcats']." ORDER BY cat_subid");
			while($fcresult = mysql_fetch_array($fcsql)){
				$select .= '<option value=""></option>';
				$select .= '<option value="">'.$fcresult['cat_title'].'</option>';
				$fcsql2 = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_catid='".$fcresult['cat_id']."' ORDER BY sub_subid");
				while($fcresult2 = mysql_fetch_array($fcsql2)){
					$select .= '<option value="'.$fcresult2['sub_id'].'">&nbsp;&nbsp;'.$fcresult2['sub_title'].'</option>';
				}
			}
		$select .= '</select>';
			$tpl->assign(array(
				"ADMIN_TEXT_LOCKED" => $L['qs_lock'],
				"ADMIN_LOCKED" => '<input type="checkbox" name="locked" value="ON"  '.$checkedl.'>',
				"ADMIN_TEXT_COMMON" => $L['qs_common'],
				"ADMIN_COMMON" => '<input name="radio1" type="radio" value="common"  '.$checkedc.'>',
				"ADMIN_TEXT_ADVERT" => $L['qs_advert'],
				"ADMIN_ADVERT" => '<input name="radio1" type="radio" value="advert" '.$checkeda.'>',
				"ADMIN_TEXT_STICKED" => $L['qs_sticked'],
				"ADMIN_STICKED" => '<input name="radio1" type="radio" value="sticked" '.$checkeds.'>',
				"ADMIN_MOVETO_TEXT" => $L['qs_moveto'],
				"ADMIN_MOVETO" => $select,
				"ADMIN_DELETE_TEXT" => $L['qs_delete'],
				"ADMIN_DELETE" => '<input type="checkbox" name="del" value="ON">',
			));
			$tpl->parse('MAIN.TOPIC_EDIT.ADMIN_ROW');
		}
		
		$tpl->parse('MAIN.TOPIC_EDIT');
		$tpl->parse('MAIN');
		$tpl->out('MAIN');
		require('includes/footer.php');
	}
	}
	elseif(!empty($p)){
		$pageofp = $_GET['pa'];
		$psql = mysql_query("SELECT * FROM ".$qs_db['posts']." WHERE post_id='".$p."'");
		$presult = mysql_fetch_array($psql);
		$tsql = mysql_query("SELECT * FROM ".$qs_db['topics']." WHERE topic_id='".$presult['post_topicid']."'");
		$tresult = mysql_fetch_array($tsql);
		$t = $presult['post_topicid'];
		$id = $tresult['topic_subcatid'];
		if(!empty($id)){
		$sqlcat = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
		$resultcat = mysql_fetch_array($sqlcat);
		$towner = qs_userdata($tresult['post_ownerid']);
		$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$id."'");
		if(($resultcat['sub_minlevel'] <= $user['level'] && $presult['post_ownerid'] == $user['id']) || qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
			
		}
		else{
			qs_redirect(107);
		}
		if($a == 'update'){
			if(qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
				$del = $_POST['del'];
				if($del == 'ON'){
					if(mysql_query("DELETE FROM ".$qs_db['posts']." WHERE post_id='".$p."'")){
						qs_redirect(400, 'forum.php?t='.$t.'&p=last');
					}
				}
			}
			$text = $_POST['text'];
			if(qs_isgoodlength($text, 1, 0)){
				$text = qs_addslashes($text);
				if(mysql_query("UPDATE ".$qs_db['posts']." SET post_text='".$text."' WHERE post_id='".$p."'")){
					header("Location: forum.php?t=".$t."&p=".$pageofp."#".$p);
				}
			}
			else{
				$error_text .= $L['qs_messagewronglen'].'<br>';
			}
		}
		$text = $presult['post_text'];
		
		$bbform = 'form';
		$bbinput = 'text';
		
		$sql = mysql_query("SELECT * FROM ".$qs_db['fsubcats']." WHERE sub_id='".$id."'");
		$result = mysql_fetch_array($sql);
		
		$pdate = qs_userdate(gmdate("Y-m-d H:i:s"), $user['timezone']);
		
		$title = $L['qs_forum'].': '.$L['qs_newpost'].' - '.$resultcat['sub_title'];
		
		$menuleft = 'OFF';
		require('includes/header.php');
		$tpl = new XTemplate(qs_tplfile('forum.edit'));
		
		if(!empty($error_text)){
			$error_text = '<br><br><b>'.$error_text.'</b><br>';
		}
		
		$tpl->assign(array(
			"POST_TIME" => $L['qs_present_time'].' '.$pdate['d'].' '.$months[$pdate['m']].' '.$pdate['y'].', '.$pdate['h'].':'.$pdate['i'],
			"POST_URL" => '<a href="forum.php">'.$L['qs_forum'].'</a> &raquo; <a href="forum.php?id='.$id.'">'.$result['sub_title'].'</a> &raquo; <a href="forum.php?t='.$tresult['topic_id'].'">'.$tresult['topic_title'].'</a>',
			"POST_TEXT_WRITE" => $L['qs_editpost'],
			"POST_ERROR" => $error_text,
			"POST_BBCBOX" => qs_bbcbox2(),
			"POST_FORM_TEXT" => '<textarea rows="20" name="text" cols="80">'.$text.'</textarea>',
			"POST_TEXT_TEXT" => $L['qs_message'],
			"POST_SMILES" => qs_smilesbox('form', 'text'),
			"POST_FORM_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="p" value="'.$p.'"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'">',
		));
		
		$modsql = mysql_query("SELECT * FROM ".$qs_db['mods']." WHERE mod_userid='".$user['id']."' && mod_catid='".$id."'");
		
		if(qs_acscheck($user['level'], 'forums') || mysql_num_rows($modsql)>0){
			$tpl->assign(array(
				"ADMIN_DELETE_TEXT" => $L['qs_delete'],
				"ADMIN_DELETE" => '<input type="checkbox" name="del" value="ON">',
			));
			$tpl->parse('MAIN.POST_EDIT.ADMIN_ROW');
		}
		
		$tpl->parse('MAIN.POST_EDIT');
		$tpl->parse('MAIN');
		$tpl->out('MAIN');
		require('includes/footer.php');
	}
	}
}

?>