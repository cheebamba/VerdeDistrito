<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$loc = 'shout';
$title = $T['shoutbox'];

$data = qs_userdata($user['id']);
if($data['user_member'] != '1'){
	qs_redirect(107);
}

$shoutbox_minlevel = 15;

include('modules/big/shoutbox/shoutbox.cfg.php');

$send = $_POST['send'];

$javascripts .= qs_smilescript('shoutbox', 'shout_text');
$javascripts .= qs_smilescript('shoutboxes', 'shout_text');

if(!empty($send)){
	$text = qs_addslashes($_POST['shout_text']);
	if(qs_isgoodlength($text, 1, 600)){
			$date = gmdate("Y-m-d H:i:s");
			if(mysql_query("INSERT INTO ".$qs_db['shoutbox']."(shout_text, shout_date, shout_ownerid) VALUES('".$text."', '".$date."', '".$user['id']."')")){
				qs_redirect(119);
			}
			else {
				require('includes/header.php');
				$tpl = new XTemplate('modules/big/shoutbox/shoutbox.tpl');
				$tpl->assign("SHOUT_ACTION", $L['qs_actionproblem']);
				$done = 1;
			}
	}
	else {
		require('includes/header.php');
		$tpl = new XTemplate('modules/big/shoutbox/shoutbox.tpl');
		$tpl->assign("SHOUT_ACTION", $L['qs_showronglen']);
		$done = 1;
	}
}
$id = $_GET['id'];
$sql = mysql_query("SELECT * FROM ".$qs_db['shoutbox']." WHERE shout_id='".$id."'");
$result = mysql_fetch_array($sql);
if($user['level']>=$shoutbox_minlevel || $user['id'] == $result['shout_ownerid']){
	$a = $_GET['a'];
	if($a == 'edit'){
		if(mysql_num_rows($sql)>0){
			$edit = $_POST['edit'];
			if($edit == 1){
				$text = $_POST['shout_text'];
				if(mysql_query("UPDATE ".$qs_db['shoutbox']." SET shout_text='".$text."' WHERE shout_id='".$id."'")){
					qs_redirect(128, 'plugin.php?plug=shoutbox');
				}
			}
			$owner = qs_userdata($result['shout_ownerid']);
			require('includes/header.php');
			$tpl = new XTemplate('modules/big/shoutbox/shoutbox.tpl');
			$done =1;
			$tpl->assign(array(
				"SHOUT_EDIT_FORM" => '<form name="shoutboxes" method="POST" action="plugin.php?plug=shoutbox&a=edit&id='.$id.'">',
				"SHOUT_EDIT_SMILES" => qs_smilesbox('shoutboxes', 'shout_text'),
				"SHOUT_EDIT_OWNER_TEXT" => $L['qs_ownern'],
				"SHOUT_EDIT_OWNER" => '<a href="users.php?id='.$owner['user_id'].'">'.$owner['user_nick'].'</a>',
				"SHOUT_EDIT_TEXT" => '<textarea rows="6" name="shout_text" cols="22">'.$result['shout_text'].'</textarea>',
				"SHOUT_EDIT_SEND" => '<input type="hidden" name="edit" value="1"><input type="submit" class="submit" name="submit" value="'.$L['qs_send'].'">'
			));
			$tpl->parse('MAIN.SHOUT_EDIT');
		}
		else {
			qs_redirect(900, 'plugin.php?plug=shoutbox');
		}
	}
	elseif($a == 'del'){
		$id = $_GET['id'];
		$sql = mysql_query("SELECT * FROM ".$qs_db['shoutbox']." WHERE shout_id='".$id."'");
		if(mysql_num_rows($sql)>0){
			if(mysql_query("DELETE FROM ".$qs_db['shoutbox']." WHERE shout_id='".$id."'")){
				qs_redirect(129, 'plugin.php?plug=shoutbox');
			}
		}
		else {
			qs_redirect(900, 'plugin.php?plug=shoutbox');
		}
	}
}
if($done != 1){
	require('includes/header.php');
	$tpl = new XTemplate('modules/big/shoutbox/shoutbox.tpl');
}

$p = (empty($_GET['p'])) ? '1' : $_GET['p'] ;
$pe = $shout_max*($p-1);

$sql = mysql_query("SELECT * FROM ".$qs_db['shoutbox']." ORDER BY shout_date");
$count = mysql_num_rows($sql);
$pages = ceil($count/$shout_max);
$a1 = ($p == 1) ? 'a' : '' ;
$a2 = ($p == $pages) ? 'a' : '' ;
$shout_pages = '<a '.$a1.'href="plugin.php?plug=shoutbox&p='.($p-1).'"><<< '.$L['qs_previous'].'</a>';
$shout_pages .= ' | <a '.$a2.'href="plugin.php?plug=shoutbox&p='.($p+1).'">'.$L['qs_next'].' >>></a>';


$sql = mysql_query("SELECT * FROM ".$qs_db['shoutbox']." ORDER BY shout_date DESC LIMIT ".$pe.",".$shoutbox_max."");
while ($result = mysql_fetch_array($sql)) {
	$owner = qs_userdata($result['shout_ownerid']);
	$tpl->assign(array(
		"SHOUT_ROW_OWNER" => '<b><a href="users.php?id='.$owner['user_id'].'">'.$owner['user_nick'].'</a> </b> ',
		"SHOUT_ROW_TEXT" => qs_bbcode2(qs_smiles(qs_viewtext($result['shout_text']))),
	));
	if($user['level']>=$shoutbox_minlevel || $user['id'] == $result['shout_ownerid']){
		$tpl->assign("SHOUT_ACTION_LINKS", '<br>[<a href="plugin.php?plug=shoutbox&a=edit&id='.$result['shout_id'].'">'.$L['qs_edit'].'</a>] [<a href="plugin.php?plug=shoutbox&a=del&id='.$result['shout_id'].'">'.$L['qs_delete'].'</a>]');
		$tpl->parse('MAIN.SHOUT_ROW.ACTION');
	}
	$tpl->parse('MAIN.SHOUT_ROW');
}

$tpl->assign(array(
	"SHOUT_PAGES" => $shout_pages,
	"SHOUT_TEXT_SHOUTS" => $L['qs_shouts'],
	"SHOUT_TEXT_NEW" => $L['qs_newshout'],
	"SHOUT_NEW_SMILES" => qs_smilesbox('shoutbox', 'shout_text'),
	"SHOUT_NEW_TEXT" => '<textarea rows="6" name="shout_text" cols="22"></textarea>',
	"SHOUT_NEW_SEND" => '<input type="hidden" name="send" value="1"><input type="submit" class="submit" name="submit" value="'.$L['qs_send'].'">'
));

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>