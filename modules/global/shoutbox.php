<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$data = qs_userdata($user['id']);
if($data['user_member'] == '1'){

$shout_max = '20';

$javascripts .= qs_smilescript('shoutbox_sm', 'shout_text');

$spacer = '<img src="templates/'.$defskin.'/images/spacer.gif" width="4">';
$hr = '<img border="0" src="templates/'.$defskin.'/images/hr_shout.jpg">';

$shoutbox = '<tr>
							<td>
							<img border="0" src="templates/'.$defskin.'/images/menu_shoutbox.jpg" width="219" height="35"></td>
						</tr>
						<tr>
							<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td width="18">&nbsp;</td>
									<td width="195">';
$shoutbox .= '<center>'.$hr.'<br>'.$spacer.'<br>';
$sql = mysql_query("SELECT * FROM ".$qs_db['shoutbox']." ORDER BY shout_date DESC LIMIT 0,".$shout_max."");
if(mysql_num_rows($sql)<1){
	$shoutbox .= $L['qs_none'];
	$shoutbox .= '<br>'.$hr.'<br><br>';
}
$shoutbox .= '<div align="center"><table width="95%"><tr><td>';
while($result = mysql_fetch_array($sql)){
	$owner = qs_userdata($result['shout_ownerid']);
	$shoutbox .= '<a href="users.php?id='.$owner['user_id'].'"><b>'.$owner['user_nick'].'</a> :</b> ';
	$shoutbox .= qs_smiles(qs_bbcode2(qs_viewtext($result['shout_text'])));
	$shoutbox .= '<br>'.$spacer.'<br>'.$hr.'<br>'.$spacer.'<br>';
}
$shoutbox .= '</td></tr></table></div>';
$shoutbox .= '<form name="shoutbox_sm" method="POST" action="plugin.php?plug=shoutbox"><br>'.qs_smilesbox('shoutbox_sm', 'shout_text').'<br><textarea rows="6" name="shout_text" cols="22"></textarea><br>';
$shoutbox .= '<input type="hidden" name="send" value="1"><input type="submit" class="submit" name="submit" value="'.$L['qs_send'].'"></form>';
$shoutbox .= '<a href="plugin.php?plug=shoutbox">'.$L['qs_seeall'].'</a>';
$shoutbox .= '</center>';
$shoutbox .= '</td>
									<td width="6">&nbsp;</td>
								</tr>
							</table>
							</td>
						</tr>';
}
?>