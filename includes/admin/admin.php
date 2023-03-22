<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$title = $T['administration'];
$loc = 'admin';

if($user['level']<3){
	qs_redirect(107);
}

if(qs_acscheck($user['level'], 'panel')){

$i = 0;
$menu = '<td width="134" valign="top">';
$i++;
$menu .= '<a href="admin.php">'.$A['qs_index'].'</a><br>';
if(qs_acscheck($user['level'], 'config')){
	$i++;
	$menu .= '<a href="admin.php?s=config">'.$A['qs_config'].'</a><br>';
}
if(qs_acscheck($user['level'], 'cats')){
	$i++;
	$menu .= '<a href="admin.php?s=cats">'.$A['qs_cats'].'</a><br>';
}
if($i == 3){
	$i=0;
	$menu .= '</td><td width="134" valign="top">';
}
if(qs_acscheck($user['level'], 'levels')){
	$i++;
	$menu .= '<a href="admin.php?s=levels">'.$A['qs_levels'].'</a><br>';
}
if($i == 3){
	$i=0;
	$menu .= '</td><td width="134" valign="top">';
}
if(qs_acscheck($user['level'], 'logs')){
	$i++;
	$menu .= '<a href="admin.php?s=logs">'.$A['qs_logs'].'</a><br>';
}
if($i == 3){
	$i=0;
	$menu .= '</td><td width="134" valign="top">';
}
if(qs_acscheck($user['level'], 'emots')){
	$i++;
	$menu .= '<a href="admin.php?s=emots">'.$A['qs_emots'].'</a><br>';
}
if($i == 3){
	$i=0;
	$menu .= '</td><td width="134" valign="top">';
}
if(qs_acscheck($user['level'], 'forums')){
	$i++;
	$menu .= '<a href="admin.php?s=forum">'.$L['qs_forum'].'</a><br>';
}

if($i == 3){
	$i=0;
	$menu .= '</td><td width="134" valign="top">';
}
if(qs_acscheck($user['level'], 'team')){
	$i++;
	$menu .= '<a href="admin.php?s=divs">'.$A['qs_team'].'</a><br>';
}
if($i == 3){
	$i=0;
	$menu .= '</td><td width="134" valign="top">';
}
if(qs_acscheck($user['level'], 'pages')){
	$i++;
	$menu .= '<a href="admin.php?s=pages">'.$T['pages'].'</a><br>';
}
if($i == 3){
	$i=0;
	$menu .= '</td><td width="134" valign="top">';
}
/*if(qs_acscheck($user['level'], '')){
	$i++;
	$menu .= '<a href="admin.php?s=">'.$A['qs_'].'</a><br>';
}
*/
$menu .= '</td>';

}

$s = $_GET['s'];
switch ($s) {
	case 'config':
		include('includes/admin/config/config.php');
	break;
	
	case 'emots':
		include('includes/admin/emots/emots.php');
	break;
	
	case 'logs':
		include('includes/admin/logs/logs.php');
	break;
	
	case 'cats':
		include('includes/admin/cats/cats.php');
	break;
	
	case 'forum':
		include('includes/admin/forum/forum.php');
	break;
	
	case 'news':
		include('includes/admin/news/news.add.php');
	break;
	
	case 'levels':
		include('includes/admin/levels/levels.php');
	break;
	
	case 'authorize':
		include('includes/admin/authorize.php');
	break;
	
	case 'myauthorize':
		include('includes/admin/myauthorize.php');
	break;
	
	case 'viewa':
		include('includes/admin/articles/article.view.php');
	break;
	
	case 'viewn':
		include('includes/admin/news/news.view.php');
	break;
	
	case 'editnews':
		include('includes/admin/news/news.edit.php');
	break;
	
	case 'pages':
		include('includes/admin/pages/pages.php');
	break;
	
	case 'page':
		include('includes/admin/pages/page.add.php');
	break;

	case 'editpage':
		include('includes/admin/pages/page.edit.php');
	break;
	
	case 'art':
		include('includes/admin/articles/article.add.php');
	break;
	
	case 'editart':
		include('includes/admin/articles/article.edit.php');
	break;
	
	case 'divs':
		include('includes/admin/team/member.divs.php');
	break;
	
	case 'div':
		include('includes/admin/team/member.list.php');
	break;
	
	case 'war':
		include('includes/admin/wars/war.add.php');
	break;
	
	case 'editwar':
		include('includes/admin/wars/war.edit.php');
	break;
	
	case 'file':
		include('includes/admin/files/file.add.php');
	break;
	
	case 'editfile':
		include('includes/admin/files/file.edit.php');
	break;
	
	case 'upload':
		include('includes/admin/upload.php');
	break;
	
	default:
		require('includes/header.php');
		$tpl = new XTemplate(qs_tplafile('index'));
		if(qs_acscheck($user['level'], 'authorizer')){
			$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_status='0' ORDER BY news_date");
			$count = mysql_num_rows($sql);
			$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_status='0' AND article_page='1' ORDER BY article_date");
			$count += mysql_num_rows($sql);
			$count = ($count>0) ? '<b>'.$count.'</b>' : $count;
			$content .= '<a href="admin.php?s=authorize">'.$A['qs_authorize'].'</a> ('.$count.')<br><br>';
		}
		if(qs_acscheck($user['level'], 'news') OR qs_acscheck($user['level'], 'articles')){
			$sql = mysql_query("SELECT * FROM ".$qs_db['news']." WHERE news_status='0' AND news_ownerid='".$user['id']."' ORDER BY news_date");
			$count = mysql_num_rows($sql);
			$sql = mysql_query("SELECT * FROM ".$qs_db['articles']." WHERE article_status='0' AND article_page='1' AND article_ownerid='".$user['id']."' ORDER BY article_date");
			$count += mysql_num_rows($sql);
			$count = ($count>0) ? '<b>'.$count.'</b>' : $count;
			$content .= '<br><a href="admin.php?s=myauthorize">'.$A['qs_myauthorize'].'</a> ('.$count.')<br><br><br>';
		}
		if(qs_acscheck($user['level'], 'news')){
			$content .= '<a href="admin.php?s=news">'.$A['qs_addnews'].'</a><br>';
		}
		if(qs_acscheck($user['level'], 'articles')){
			$content .= '<a href="admin.php?s=art">'.$A['qs_addart'].'</a><br>';
		}
		if(qs_acscheck($user['level'], 'wars')){
			$content .= '<a href="admin.php?s=war">'.$A['qs_addwar'].'</a><br>';
		}
		if(qs_acscheck($user['level'], 'pages')){
			$content .= '<a href="admin.php?s=page">'.$A['qs_addpage'].'</a><br>';
		}
		if(qs_acscheck($user['level'], 'upload')){
			$content .= '<a href="admin.php?s=file">'.$A['qs_addfile'].'</a><br>';
		}
		if(qs_acscheck($user['level'], 'upload')){
			$content .= '<br><a href="admin.php?s=upload">'.$A['qs_uploadimg'].'</a><br>';
		}
		$tpl->assign("ADMIN_CONTENT", $content);
	break;
}

$tpl->assign("ADMIN_MENU", $menu);

$tpl->parse('MAIN');
$tpl->out('MAIN');
require('includes/footer.php');

?>