<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$tpl = new XTemplate(qs_tplfile('comments'));

$a = $_GET['a'];
if($a == 'edit' || $a == 'delete'){
	$update = $_POST['update_com'];
	if(!empty($id)){
		$cid = $_GET['cid'];
		$sql12 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_id='".$cid."'");
		$result12 = mysql_fetch_array($sql12);
		if(mysql_num_rows($sql)>0){
			$last = gmdate("YmdHi")-($date['y'].$date['m'].$date['d'].$date['h'].$date['i']);
			if($user['level']>18 || qs_acscheck($user['level'], 'comments') || ($result12['comment_ownerid'] == $user['id'] && $last<6)){
				if($a == 'edit'){
					if(!empty($update)){
						$text = qs_addslashes($_POST['com_text']);
						if(mysql_query("UPDATE ".$qs_db['comments']." SET comment_text='".$text."' WHERE comment_id='".$cid."'")){
							$tpl->assign("ACTION_TEXT", $L['qs_comupdated']);
						}
						$tpl->parse('COMMENTS.ACTION_ROW');
					}
					else {
						$sql5 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result12['comment_ownerid']."'");
						$result5 = mysql_fetch_array($sql5);
						$tpl->assign(array(
							"EDIT_TEXT_TEXT" => '<form method="POST" action="'.$adres.'&a=edit&cid='.$cid.'" name="come">'.$L['qs_editcom'],
							"EDIT_FORM_TEXT" => '<textarea rows="5" cols="45" name="com_text">'.$result12['comment_text'].'</textarea>',
							"EDIT_FORM_OWNER" => '<a href="users.php?id='.$resul5['user_id'].'">'.$result5['user_nick'].'</a>',
							"EDIT_TEXT_OWNER" => $L['qs_ownern'],
							"NEW_SMILES" => qs_smilesbox('come', 'com_text'),
							"NEW_SEND" => '<input type="hidden" name="update_com" value="OK"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'"></form>',
						));
						$tpl->parse('COMMENTS.COMMENT_EDIT');
					}
				}
				if ($a == 'delete') {
					if(mysql_query("DELETE FROM ".$qs_db['comments']." WHERE comment_id='".$cid."'")){
						$tpl->assign("ACTION_TEXT", $L['qs_comdeleted']);
					}
					$tpl->parse('COMMENTS.ACTION_ROW');
				}
				
			}
		}
	}
}

$add = $_POST['add'];
$cp = (empty($_GET['cp'])) ? '1' : $_GET['cp'] ;
if(!empty($add_com)){
	if($user['level']>0){
		$text = qs_addslashes($_POST['com_text']);
		$sql11 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='".$cat."' AND comment_pageid='".$id."' ORDER BY comment_date DESC");
		$result11 = mysql_fetch_array($sql11);
		if($user['id'] == $result11['comment_ownerid']){
			$tpl->assign("NEW_ACTION", $L['qs_ownanswer']);
		}
		else {
			if(qs_isgoodlength($text, 2, 600)){
				$date = gmdate("Y-m-d H:i:s");
				if(mysql_query("INSERT INTO ".$qs_db['comments']."(comment_text, comment_cat, comment_pageid, comment_ownerid, comment_date) VALUES('".$text."', '".$cat."', '".$id."', '".$user['id']."', '".$date."')")){
					$tpl->assign("NEW_ACTION", $L['qs_comdone']);
				}
				else {
					$tpl->assign("NEW_ACTION", $L['qs_actionproblem']);
				}
			}
			else {
				$tpl->assign("NEW_ACTION", $L['qs_comwronglen']);
			}
		}
	}
	else {
		$tpl->assign("NEW_ACTION", $L['qs_notlogged']);
	}
	$tpl->parse('COMMENTS.COMMENT_ACTION');
}
$sql9 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='".$cat."' AND comment_pageid='".$id."'");
$count = mysql_num_rows($sql9);
$tpl->assign(array(
		"COMMENT_COUNT" => $count,
		"COMMENT_ADDLINK" => '<a href="#bottom">'.$L['qs_comment'].'</a>',
		"COMMENT_COMMENTS" => $L['qs_comments'],
));
if($count>0){
	$pages = ceil($count/$conf['comments_perpage']);
	if($cp<0 || $cp>$pages){
		$cp = 1;
	}
	$pe = $conf['comments_perpage']*($cp-1);
	for ($i=0; $i<=$pages; $i++){
		$a = ($i == $cp) ? 'a' : '' ;
		if ($i == 1){
			$com_pages = '<a '.$a.'href="'.$adres.'&cp='.$i.'">'.$i.'</a>';
		}
		else {
			$com_pages .= ' | <a '.$a.'href="'.$adres.'&cp='.$i.'">'.$i.'</a>';
		}
	}
	if($pages == 1){
		$com_pages = '';
	}
	$tpl->assign("COMMENT_PAGES", $com_pages);
	$i=0;
	$sql10 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='".$cat."' AND comment_pageid='".$id."'");
	$count = mysql_num_rows($sql10);
	$sql8 = mysql_query("SELECT * FROM ".$qs_db['comments']." WHERE comment_cat='".$cat."' AND comment_pageid='".$id."' ORDER BY comment_date ASC LIMIT ".$pe.",".$conf['comments_perpage']."");
	while ($result8 = mysql_fetch_array($sql8)) {
		$i++;
		$date = qs_userdate($result8['comment_date'], $user['timezone']);
		$tpl->assign(array(
			"COMMENT_TEXT" => qs_smiles(qs_viewtext($result8['comment_text'])),
			"COMMENT_DATE" => $date['h'].':'.$date['i'].' '.$date['d'].'-'.$date['m'].'-'.$date['y'],
			"COMMENT_NUMBER" => '#'.$i,
		));
		$sql5 = mysql_query("SELECT * FROM ".$qs_db['users']." WHERE user_id='".$result8['comment_ownerid']."'");
		$result5 = mysql_fetch_array($sql5);
		if(file_exists($result5['user_avatar'])){
			$avatar = $result5['user_avatar'];
		}
		else {
			$avatar = 'templates/'.$defskin.'/images/avatar.gif';
		}
		$userdata = qs_userdata($result8['comment_ownerid']);
		if($userdata['user_member'] == 1){
			$memberimg = '<img src="includes/images/icons/member.gif"> ';
		}
		else {
			$memberimg = '';
		}
		if(!file_exists($avatar)){
			$avatar = 'includes/images/users/0_avatar.jpg';
		}
		$tpl->assign(array(
			"OWNER_AVATAR" => '<img src="'.$avatar.'" width="60" height="60">',
			"OWNER_NICK" => '<a href="users.php?id='.$result5['user_id'].'">'.$result5['user_nick'].'</a>',
			"OWNER_COUNTRY" => $memberimg.' <img src="includes/images/flags/'.$result5['user_origin'].'.gif">',
			"OWNER_LEVEL" => qs_userlevel($result5['user_id']),
		));
		$date = qs_userdate($result8['comment_date'], '00');
		$last = gmdate("YmdHi")-($date['y'].$date['m'].$date['d'].$date['h'].$date['i']);
		if($user['level']>18 || qs_acscheck($user['level'], 'comments') || ($result8['comment_ownerid'] == $user['id'] && $last<6)){
			$tpl->assign("COMMENT_ADMIN", '<a href="'.$adres.'&a=edit&cid='.$result8['comment_id'].'">['.$L['qs_edit'].']</a> <a href="'.$adres.'&a=delete&cid='.$result8['comment_id'].'#action">['.$L['qs_delete'].']</a>');
			$tpl->parse('COMMENTS.COMMENT_ROW.COMMENT_ADMIN');
		}
		$tpl->parse('COMMENTS.COMMENT_ROW');
	}
}
else {
	$tpl->assign("COMMENT_NONE", $L['qs_nonecom']);
}
$tpl->assign("NEWS_ADDCOMMENT", '<a name="bottom">&nbsp;</a>'.$L['qs_addcomment']);
if($user['level']>0){
	$tpl->assign(array(
		"NEW_TEXT" => '<form method="POST" action="'.$adres.'#bottom" name="com"><textarea rows="5" cols="45" name="com_text"></textarea>',
		"NEW_SMILES" => qs_smilesbox('com', 'com_text'),
		"NEW_SEND" => '<input type="hidden" name="add_com" value="new"><input type="submit" name="submit" class="submit" value="'.$L['qs_send'].'"></form>',
	));
	$tpl->parse('COMMENTS.COMMENT_NEW');
}
else {
	$tpl->assign("NEW_NOTLOGGED", $L['qs_notlogged']);
	$tpl->parse('COMMENTS.NOT_LOGGED');
}
$tpl->parse('COMMENTS');
$tpl->out('COMMENTS');
?>