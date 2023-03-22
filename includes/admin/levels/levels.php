<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if(!qs_acscheck($user['level'], 'levels')){
	qs_redirect(107);
}

$loc = 'admin';
$title = $T['levels'];

$a = $_POST['a'];
if($a == 'update'){
	$del = $_POST['delete'];
	$olvl = $_POST['olvl'];
	if($del = "ON"){
		mysql_query("DELETE FROM ".$qs_db['levels']." WHERE level_level='".$olvl."'");
	}
	else{
		$level = $_POST['level'];
		$name = $_POST['name'];
		$authorizer = $_POST['authorizer'];
		$news = $_POST['news'];
		$cats = $_POST['cats'];
		$levels = $_POST['levls'];
		$articles = $_POST['articles'];
		$wars = $_POST['wars'];
		$emots = $_POST['emots'];
		$download = $_POST['download'];
		$comments = $_POST['comments'];
		$logs = $_POST['logs'];
		$forums = $_POST['forums'];
		$pages = $_POST['pages'];
		$upload = $_POST['uplaod'];
		$users = $_POST['users'];
		$config = $_POST['config'];
		$tools = $_POST['tools'];
		$panel = $_POST['panel'];
		$lsql = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_level='".$level."'");
		if(mysql_num_rows($lsql) > 0){
			$action = $L['qs_lvlalreadye'];
		}
		else{
			mysql_query("UPDATE ".$qs_db['levels']." SET level_level='".$level."', level_name='".$name."', level_authorizer='".$authorizer."', level_news='".$news."', level_cats='".$cats."', level_levels='".$levels."', level_='".$articles."', level_='".$articles."', level_wars='".$wars."', level_emots='".$emots."', level_download='".$download."', level_comments='".$comments."', level_logs='".$logs."', level_forums='".$forums."', level_pages='".$pages."', level_upload='".$upload."', level_users='".$users."', level_config='".$config."', level_tools='".$tools."', level_panel='".$panel."' WHERE level_level='".$olvl."'");
		}
	}
}
if($a == 'add'){
	$level = $_POST['level'];
	$name = $_POST['name'];
	$authorizer = $_POST['authorizer'];
	$news = $_POST['news'];
	$cats = $_POST['cats'];
	$levels = $_POST['levls'];
	$articles = $_POST['articles'];
	$wars = $_POST['wars'];
	$emots = $_POST['emots'];
	$download = $_POST['download'];
	$comments = $_POST['comments'];
	$logs = $_POST['logs'];
	$forums = $_POST['forums'];
	$pages = $_POST['pages'];
	$upload = $_POST['uplaod'];
	$users = $_POST['users'];
	$config = $_POST['config'];
	$tools = $_POST['tools'];
	$panel = $_POST['panel'];
	$lsql = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_level='".$level."'");
	if(mysql_num_rows($lsql) > 0){
		$action2 = $L['qs_lvlalreadye'];
	}
	else{
		mysql_query("INSERT INTO ".$qs_db['levels']."(level_level, level_name, level_authorizer, level_news, level_cats, level_levels, level_articles, level_wars, level_emots, level_download, level_comments, level_logs, level_forums, level_pages, level_upload, level_users, level_config, level_tools, level_panel) VALUES('".$level."', '".$name."', '".$authorizer."', '".$news."', '".$cats."', '".$levels."', '".$articles."', '".$wars."', '".$emots."', '".$download."', '".$comments."', '".$logs."', '".$forums."', '".$pages."', '".$upload."', '".$users."', '".$config."', '".$tools."', '".$panel."')");
	}
}

require('includes/header.php');
$tpl = new XTemplate(qs_tplfile('admin/levels'));

$tpl->assign(array(
	"LEVEL_TEXT_DELETE" => $L['qs_delete'],
	"LEVEL_TEXT_LEVEL" => $L['qs_level'],
	"LEVEL_TEXT_NAME" => $L['qs_filename'],
	"LEVEL_TEXT_AUTHORIZER" => (strlen($T['authorize']) > 5) ? substr($T['authorize'], 0, 5) : $T['authorize'],
	"LEVEL_TEXT_NEWS" => $L['qs_news'],
	"LEVEL_TEXT_CATS" => (strlen($T['cats']) > 5) ? substr($T['cats'], 0, 5) : $T['cats'],
	"LEVEL_TEXT_LEVELS" => (strlen($T['levels']) > 5) ? substr($T['levels'], 0, 5) : $T['levels'],
	"LEVEL_TEXT_ARTICLES" => (strlen($T['articles']) > 5) ? substr($T['articles'], 0, 5) : $T['articles'],
	"LEVEL_TEXT_WARS" => $T['wars'],
	"LEVEL_TEXT_EMOTS" => (strlen($T['emots']) > 5) ? substr($T['emots'], 0, 5) : $T['emots'],
	"LEVEL_TEXT_TEAM" => $T['team'],
	"LEVEL_TEXT_DOWNLOAD" => $T['files'],
	"LEVEL_TEXT_COMMENTS" => (strlen($T['comments']) > 5) ? substr($T['comments'], 0, 5) : $T['comments'],
	"LEVEL_TEXT_LOGS" => $T['logs'],
	"LEVEL_TEXT_FORUMS" => $T['forum'],
	"LEVEL_TEXT_PAGES" => $T['pages'],
	"LEVEL_TEXT_UPLOAD" => (strlen($T['upload']) > 5) ? substr($T['upload'], 0, 5) : $T['upload'],
	"LEVEL_TEXT_USERS" => (strlen($T['users']) > 5) ? substr($T['users'], 0, 5) : $T['users'],
	"LEVEL_TEXT_CONFIG" => (strlen($T['config']) > 5) ? substr($T['config'], 0, 5) : $T['config'],
	"LEVEL_TEXT_PANEL" => $T['panel'],
));

$sql = mysql_query("SELECT * FROM ".$qs_db['levels']." ORDER BY level_level");
while ($result = mysql_fetch_array($sql)) {
	$level = '<select name="level">';
	for ($i=1; $i<=20; $i++){
		if($result['level_level'] == $i){
			$level .= '<option value="'.$i.'" selected>'.$i.'</option>';
		}
		else{
			$level .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	$level .= '</select>';
	$c1 = ($result['level_authorizer'] == '1') ? 'checked' : '';
	$c2 = ($result['level_news'] == '1') ? 'checked' : '';
	$c3 = ($result['level_cats'] == '1') ? 'checked' : '';
	$c4 = ($result['level_levels'] == '1') ? 'checked' : '';
	$c5 = ($result['level_articles'] == '1') ? 'checked' : '';
	$c6 = ($result['level_wars'] == '1') ? 'checked' : '';
	$c7 = ($result['level_emots'] == '1') ? 'checked' : '';
	$c8 = ($result['level_team'] == '1') ? 'checked' : '';
	$c9 = ($result['level_download'] == '1') ? 'checked' : '';
	$c10 = ($result['level_comments'] == '1') ? 'checked' : '';
	$c11 = ($result['level_logs'] == '1') ? 'checked' : '';
	$c12 = ($result['level_forums'] == '1') ? 'checked' : '';
	$c13 = ($result['level_pages'] == '1') ? 'checked' : '';
	$c14 = ($result['level_upload'] == '1') ? 'checked' : '';
	$c15 = ($result['level_users'] == '1') ? 'checked' : '';
	$c16 = ($result['level_config'] == '1') ? 'checked' : '';
	$c17 = ($result['level_panel'] == '1') ? 'checked' : '';
	$tpl->assign(array(
		"LEVEL_DELETE" => '<input type="checkbox" name="del" value="ON">',
		"LEVEL_LEVEL" => $level,
		"LEVEL_NAME" => '<input type="text" name="name" value="'.$result['level_name'].'">',
		"LEVEL_AUTHORIZER" => '<input type="checkbox" name="authorizer" value="ON" '.$c1.'>',
		"LEVEL_NEWS" => '<input type="checkbox" name="news" value="ON" '.$c2.'>',
		"LEVEL_CATS" => '<input type="checkbox" name="cats" value="ON" '.$c3.'>',
		"LEVEL_LEVELS" => '<input type="checkbox" name="levels" value="ON" '.$c4.'>',
		"LEVEL_ARTICLES" => '<input type="checkbox" name="articles" value="ON" '.$c5.'>',
		"LEVEL_WARS" => '<input type="checkbox" name="wars" value="ON" '.$c6.'>',
		"LEVEL_EMOTS" => '<input type="checkbox" name="emots" value="ON" '.$c7.'>',
		"LEVEL_TEAM" => '<input type="checkbox" name="team" value="ON" '.$c8.'>',
		"LEVEL_DOWNLOAD" => '<input type="checkbox" name="downloads" value="ON" '.$c9.'>',
		"LEVEL_COMMENTS" => '<input type="checkbox" name="comments" value="ON" '.$c10.'>',
		"LEVEL_LOGS" => '<input type="checkbox" name="logs" value="ON" '.$c11.'>',
		"LEVEL_FORUMS" => '<input type="checkbox" name="forums" value="ON" '.$c12.'>',
		"LEVEL_PAGES" => '<input type="checkbox" name="pages" value="ON" '.$c13.'>',
		"LEVEL_UPLOAD" => '<input type="checkbox" name="upload" value="ON" '.$c14.'>',
		"LEVEL_USERS" => '<input type="checkbox" name="users" value="ON" '.$c15.'>',
		"LEVEL_CONFIG" => '<input type="checkbox" name="config" value="ON" '.$c16.'>',
		"LEVEL_PANEL" => '<input type="checkbox" name="panel" value="ON" '.$c17.'>',
		"LEVEL_SEND" => '<input type="hidden" name="a" value="update"><input type="hidden" name="olvl" value="'.$result['level_level'].'"><input type="submit" class="submit" name="send" value="'.$L['qs_change'].'">',
	));
	$tpl->parse('MAIN.LEVEL_ROW');
}
$ksql = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_level<'21'");
if(mysql_num_rows($ksql)<20){
	$level = '<select name="level">';
	$asd = 0;
	for ($i=1; $i<=20; $i++){
		$asd++;
		$asql = mysql_query("SELECT * FROM ".$qs_db['levels']." WHERE level_level='".$i."'");
		if(mysql_num_rows($asql) == 0){
			if($asd == 1){
				$level .= '<option value="'.$i.'" selected>'.$i.'</option>';
			}
			else{
				$level .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
	}
	$level .= '</select>';
	$tpl->assign(array(
		"LEVEL_LEVEL" => $level,
		"LEVEL_NAME" => '<input type="text" name="name">',
		"LEVEL_AUTHORIZER" => '<input type="checkbox" name="authorizer" value="ON">',
		"LEVEL_NEWS" => '<input type="checkbox" name="news" value="ON">',
		"LEVEL_CATS" => '<input type="checkbox" name="cats" value="ON">',
		"LEVEL_LEVELS" => '<input type="checkbox" name="levels" value="ON">',
		"LEVEL_ARTICLES" => '<input type="checkbox" name="articles" value="ON">',
		"LEVEL_WARS" => '<input type="checkbox" name="wars" value="ON">',
		"LEVEL_EMOTS" => '<input type="checkbox" name="emots" value="ON">',
		"LEVEL_TEAM" => '<input type="checkbox" name="team" value="ON">',
		"LEVEL_DOWNLOAD" => '<input type="checkbox" name="downloads" value="ON">',
		"LEVEL_COMMENTS" => '<input type="checkbox" name="comments" value="ON">',
		"LEVEL_LOGS" => '<input type="checkbox" name="logs" value="ON">',
		"LEVEL_FORUMS" => '<input type="checkbox" name="forums" value="ON">',
		"LEVEL_PAGES" => '<input type="checkbox" name="pages" value="ON">',
		"LEVEL_UPLOAD" => '<input type="checkbox" name="upload" value="ON">',
		"LEVEL_USERS" => '<input type="checkbox" name="users" value="ON">',
		"LEVEL_CONFIG" => '<input type="checkbox" name="config" value="ON">',
		"LEVEL_PANEL" => '<input type="checkbox" name="panel" value="ON>',
		"LEVEL_SEND" => '<input type="hidden" name="a" value="add"><input type="submit" class="submit" name="send" value="'.$L['qs_add'].'">',
		));
	$tpl->parse('MAIN.LEVEL_NEW');
}
?>