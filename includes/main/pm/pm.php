<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if($user['level']<1){
	qs_redirect(106, 'index.php');
}

$s = $_GET['s'];
$r = $_GET['r'];
$id = $_GET['id'];
$aid = $_GET['aid'];
$title = $T['pm.'.$s];
$a = $_GET['a'];

switch ($a) {
	case 'delete':
		$sql1 = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_id='".$aid."' AND pm_fromuser='".$user['id']."' AND (pm_status='1' OR pm_status='0')");
		$sql2 = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_id='".$aid."' AND pm_touser='".$user['id']."' AND (pm_fromstatus='1' OR pm_fromstatus='0')");
		if (mysql_num_rows($sql1)>0) {
			mysql_query("UPDATE ".$qs_db['pms']." SET pm_fromstatus='2' WHERE pm_id=".$aid."");
		}
		if(mysql_num_rows($sql2)>0) {
			mysql_query("UPDATE ".$qs_db['pms']." SET pm_status='2' WHERE pm_id=".$aid."");
		}
	break;
	case 'archive':
		$sql = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_id='".$aid."' AND pm_status='0' AND pm_touser='".$user['id']."'");
		if(mysql_num_rows($sql)>0){
			mysql_query("UPDATE ".$qs_db['pms']." SET pm_status='1' WHERE pm_id=".$aid."");
		}
	break;
}
if($s != 'archives' && $s != 'sentbox' && $s != 'new' && $s != 'view' && $s != 'send'){
	$title = $T['pm.unreadbox'];
}
if($s == 'view'){
	$sql = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_id='".$id."' AND pm_touser='".$user['id']."'");
	$result = mysql_fetch_array($sql);
	if(mysql_num_rows($sql)>0){
	$title = $T['pm.view'].' - '.qs_stripslashes($result['pm_title']);
	}
}

$loc = 'pm';

if($s != 'send'){
	require('includes/header.php');
	$tpl = new XTemplate(qs_tplfile('pm'));
	$tpl->assign(array(
		"PM_TEXT_TITLE" => $L['qs_title'],
		"PM_TEXT_FROM" => $L['qs_from'],
		"PM_TEXT_TO" => $L['qs_to'],
		"PM_TEXT_DATE" => $L['qs_date'],
		"PM_TEXT_WROTEBY" => $L['qs_wroteby']
	));
}
switch ($s) {
	case 'send':
		$to = str_replace(" " , "", $_POST['to']);
		$text = qs_addslashes($_POST['text']);
		$title = qs_addslashes($_POST['title']);
		$empty = strpos($to, ',');
		if(!empty($empty)){
			$to = explode(',', $to);
			$more = 1;
		}
		if(empty($to)){
			$pm_errortext .= $L['qs_pmemptyto'].'<br>';
			$error = 1;
		}
		if(!qs_isgoodlength($text, 2, 3000)){
			$pm_errortext .= $L['qs_pmtextwronglen'].'<br>';
			$error = 1;
		}
		if(!qs_isgoodlength($title, 1, 24)){
			$pm_errortext .= $L['qs_pmtitlewronglen'].'<br>';
			$error = 1;
		}
		if($error != 1) {
			if($more != 1){
				$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_nick='".$to."'");
				if(mysql_num_rows($sql)<1){
					$pm_errortext .= $L['qs_pmwronguser'].'<br>';
					$error = 1;
				}
				else {
					$result = mysql_fetch_array($sql);
					$date = gmdate("Y-m-d H:i:s");
					mysql_query("INSERT INTO ".$qs_db['pms']."(pm_date, pm_fromuser, pm_touser, pm_title, pm_text) VALUES('".$date."', '".$user['id']."', '".$result['user_id']."', '".$title."', '".htmlspecialchars($text)."')");
				}
			}
			else {
				$gooduser = 0;
				foreach ($to as $key){
					$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_nick='".$key."'");
					$result = mysql_fetch_array($sql);
					if(mysql_num_rows($sql)>0){
						$gooduser = 1;
						$date = gmdate("Y-m-d H:i:s");
						mysql_query("INSERT INTO ".$qs_db['pms']."(pm_date, pm_fromuser, pm_touser, pm_title, pm_text) VALUES('".$date."', '".$user['id']."', '".$result['user_id']."', '".$title."', '".htmlspecialchars($text)."')");
					}
				}
				if($gooduser != 1){
					$pm_errortext .= $L['qs_pmwronguser'].'<br>';
					$error = 1;
				}
			}
		}
		if($error != 1){
			qs_redirect(116, 'pm.php');
		}
		else {
			require('includes/header.php');
			$tpl = new XTemplate(qs_tplfile('pm'));
			$tpl->assign("PM_ERROR", $pm_errortext);
			$tpl->parse('MAIN.SEND_ERROR');
		}
	break;
	case 'archives':
		$ar = 'a';
		$sql = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_touser='".$user['id']."' AND pm_status='1' ORDER BY pm_date DESC");
		if (mysql_num_rows($sql)<1) {
			$tpl->assign("PM_NONEPMS", $L['qs_nonepms']);
		}
		else {
			while ($result = mysql_fetch_array($sql)) {
				$sql2 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result['pm_fromuser']."'");
				$result2 = mysql_fetch_array($sql2);
				$date = qs_userdate($result['pm_date'], $user['timezone']);
				$tpl->assign(array(
				"PM_ROW_TITLE" => '<a href="pm.php?id='.$result['pm_id'].'">'.qs_stripslashes($result['pm_title']).'</a>',
				"PM_ROW_FROM" => '<a href="users.php?a=details&id='.$result['pm_fromuser'].'">'.$result2['user_nick'].'</a>',
				"PM_ROW_DATE" => $date['h'].':'.$date['m'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
				"PM_ROW_ACTIONS" => '<a href="pm.php?s=new&to='.$result['pm_fromuser'].'&r='.$result['pm_id'].'">['.$L['qs_reply'].']</a> | <a href="pm.php?a=delete&aid='.$result['pm_id'].'">['.$L['qs_delete'].']</a>',
				));
				$tpl->parse('MAIN.ARCHIVES.PM_ROWS');
			}
		}
	$tpl->parse('MAIN.ARCHIVES');
	break;
	case 'sentbox':
		$sb = 'a';
		$sql = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_fromuser='".$user['id']."' AND (pm_fromstatus='0' OR pm_fromstatus='1') ORDER BY pm_date DESC");
		if (mysql_num_rows($sql)<1) {
			$tpl->assign("PM_NONEPMS", $L['qs_nonepms']);
		}
		else {
			while ($result = mysql_fetch_array($sql)) {
				$sql2 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result['pm_touser']."'");
				$result2 = mysql_fetch_array($sql2);
				$date = qs_userdate($result['pm_date'], $user['timezone']);
				$tpl->assign(array(
				"PM_ROW_TITLE" => '<a href="pm.php?id='.$result['pm_id'].'">'.qs_stripslashes($result['pm_title']).'</a>',
				"PM_ROW_TO" => '<a href="users.php?a=details&id='.$result['pm_touser'].'">'.$result2['user_nick'].'</a>',
				"PM_ROW_DATE" => $date['h'].':'.$date['m'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
				"PM_ROW_ACTIONS" => '<a href="pm.php?a=delete&aid='.$result['pm_id'].'">['.$L['qs_delete'].']</a>',
				));
				$tpl->parse('MAIN.SEND_BOX.PM_ROWS');
			}
		}
	$tpl->parse('MAIN.SEND_BOX');
	break;
	case 'new':
		$nw = 'a';
		$to = $_GET['to'];
		$r = $_GET['r'];
		if(!empty($to)){
			$sql = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$to."'");
			$result = mysql_fetch_array($sql);
			if(mysql_num_rows($sql)<1){
				$to = '';
			}
			else {
				$to = $result['user_nick'];
			}
			if(!empty($r)){
				$sql = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_id='".$r."' AND pm_touser='".$user['id']."'");
				$result = mysql_fetch_array($sql);
				if(mysql_num_rows($sql)<1){
					$text = '';
				}
				else {
				$date = qs_userdate($result['pm_date'], $user['timezone']);
				$pm_date = $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'];

$pmtext = '



--- '.$L['qs_orygmsg'].' ---
'.$L['qs_title'].': '.qs_stripslashes($result['pm_title']).', '.$L['qs_date'].': '.$pm_date.'
'.$L['qs_content'].':
--- '.$L['qs_begin'].' ---

'.qs_stripslashes($result['pm_text']).'

--- '.$L['qs_end'].' ---';
$pmtitle = $L['qs_re'].': '.qs_stripslashes($result['pm_title']);
				}
			}
		}
		$tpl->assign(array(
			"PM_FORM_TO" => '<input type="text" name="to" value="'.$to.'" size="50">',
			"PM_TEXT_TO2" => $L['qs_topm2'],
			"PM_FORM_TEXT" => '<textarea rows="12" name="text" cols="45">'.$pmtext.'</textarea>',
			"PM_TEXT_TEXT" => $L['qs_content'],
			"PM_FORM_TITLE" => '<input type="text" name="title" value="'.$pmtitle.'" size="50">',
			"PM_FORM_SEND" => '<input class="submit" type="submit" name="send" value="'.$L['qs_send'].'">',
		));
		$tpl->parse('MAIN.NEW_PM');
	break;
	default:
		if($id != ''){
			$sql = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_id='".$id."' AND (pm_touser='".$user['id']."' OR pm_fromuser='".$user['id']."')");
			if(mysql_num_rows($sql)<1){
				$tpl->assign("PM_TEXT_ERROR", $L['qs_wrongpm']);
			}
			else {
				$result = mysql_fetch_array($sql);
				$sql2 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result['pm_fromuser']."'");
				$result2 = mysql_fetch_array($sql2);
				$sql3 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result['pm_touser']."'");
				$result3 = mysql_fetch_array($sql3);
				$date = qs_userdate($result['pm_date'], $user['timezone']);
				$actions = '<a href="pm.php?s=new&to='.$result['pm_fromuser'].'&r='.$result['pm_id'].'">['.$L['qs_reply'].']</a> | <a href="pm.php?a=delete&aid='.$result['pm_id'].'">['.$L['qs_delete'].']</a>';
				if($result['pm_fromuser'] == $user['id']){
					$actions = '<a href="pm.php?a=delete&aid='.$result['pm_id'].'">['.$L['qs_delete'].']</a>';
				}
				$tpl->assign(array(
				"PM_TITLE" => qs_stripslashes($result['pm_title']),
				"PM_TEXT" => nl2br($result['pm_text']),
				"PM_FROM" => '<a href="users.php?a=details&id='.$result['pm_fromuser'].'">'.$result2['user_nick'].'</a>',
				"PM_TO" => '<a href="users.php?a=details&id='.$result['pm_touser'].'">'.$result3['user_nick'].'</a>',
				"PM_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
				"PM_ACTIONS" => $actions,
				));
				mysql_query("UPDATE ".$qs_db['pms']." SET pm_status='1' WHERE pm_id=".$result['pm_id']."");
			}
			$tpl->parse('MAIN.VIEW_PM');
		}
		else {
			$df = 'a';
			$sql = mysql_query("SELECT * FROM ".$qs_db['pms']." WHERE pm_touser='".$user['id']."' AND pm_status='0' ORDER BY pm_date DESC");
			if (mysql_num_rows($sql)<1) {
				$tpl->assign("PM_NONEPMS", $L['qs_nonepms']);
			}
			else {
				while ($result = mysql_fetch_array($sql)) {
					$sql2 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result['pm_fromuser']."'");
					$result2 = mysql_fetch_array($sql2);
					$date = qs_userdate($result['pm_date'], $user['timezone']);
					$tpl->assign(array(
					"PM_ROW_TITLE" => '<a href="pm.php?id='.$result['pm_id'].'">'.qs_stripslashes($result['pm_title']).'</a>',
					"PM_ROW_FROM" => '<a href="users.php?a=details&id='.$result['pm_fromuser'].'">'.$result2['user_nick'].'</a>',
					"PM_ROW_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
					"PM_ROW_ACTIONS" => '<a href="pm.php?s=new&to='.$result['pm_fromuser'].'&r='.$result['pm_id'].'">['.$L['qs_reply'].']</a> | <a href="pm.php?a=archive&aid='.$result['pm_id'].'">['.$L['qs_archive'].']</a> | <a href="pm.php?a=delete&aid='.$result['pm_id'].'">['.$L['qs_delete'].']</a>',
					));
					$tpl->parse('MAIN.UNREAD_BOX.PM_ROWS');
				}
			}
			$tpl->parse('MAIN.UNREAD_BOX');
		}
		break;
}

$tpl->assign("PM_LINKS", '<a '.$df.'href="pm.php">'.$L['qs_pmbox'].'</a> | <a '.$ar.'href="pm.php?s=archives">'.$L['qs_archives'].'</a> | <a '.$sb.'href="pm.php?s=sentbox">'.$L['qs_sentbox'].'</a> | <a '.$nw.'href="pm.php?s=new">'.$L['qs_newpm'].'</a><br>');
 
$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>