<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$a = $_GET['a'];
$title = $T[$a];

$tpl = new XTemplate(qs_tplfile('popup'));

$javascripts .= "<script type=\"text/javascript\">

function popup(type){
window.open('popup.php?a='+type,'Pop-up','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=no,with=480,height=512,left=32,top=16');}

function mail(user, domain){window.location = 'mailto:'+user+'@'+domain;}

function flip( rid ){
document.getElementById(rid).style.display = document.getElementById(rid).style.display == 'none' ? 'block' : 'none'}

</script>
<script type=\"text/javascript\">
<!--
window.name='main';

	function addtextcom(text)
	{
	document.com.com_text.value += text;
	document.com.com_text.focus();
	}
	function addtextcome(text)
	{
	document.come.com_text.value += text;
	document.come.com_text.focus();
	}

//-->
</script>
";

$style = '';

if(stristr($HTTP_USER_AGENT, "compatible")){
$style = '<style>
hr{
	position: absolute;
	display: inline;
	border-left-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-top-style: solid;
	border-top-width: 1px;
	border-top: 1px solid #CBCBCB;
	border-left:0 none;
    border-right:0 none;
	border-bottom:0 none;
	text-indent: 0;
	word-spacing: 0;
	border-style: solid;
	border-width: 1px;
    margin: 0;
    padding: 0;
    line-height:1px;
    margin-top:0;
	margin-bottom:0;
}
</style>';
}
else {
$style = '<style>
hr{
	position: relative;
	text-indent: 0; 
	word-spacing: 0; 
	border-style: solid; 
	border-width: 1px; 
    margin: 0; 
    padding: 0;
    border-top:1px solid #CBCBCB;
    border-left:0 none;
	border-right:0 none;
	border-bottom:0 none;
	margin-top:0;
	margin-bottom:0;
}
</style>';
}



$metas = '
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<meta http-equiv="Content-Language" content="'.$deflang.'">
<meta name="keywords" content="cs, q3">
';

$tpl->assign(array(
	"HEADER_MAIN_TITLE" => $conf['global_maintitle'],
	"HEADER_TITLE" => $title,
	"HEADER_METAS" => $metas,
	"HEADER_LOC" => $loc,
	"HEADER_JAVA" => $javascripts,
	"HEADER_STYLES" => $style,
));

if($a = 'abbcode'){
	$popup = '<table><tr>';
	$popup .= '<td>'.$L['qs_example'].' </td><td> '.$L['qs_working'].'</td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[b]Text[/b] </td><td> <b>Text</b></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[i]Text[/i] </td><td> <i>Text</i></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[u]Text[/u] </td><td> <u>Text</u></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[sm]Text[/sm] </td><td> <small>Text</small></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[big]Text[/big] </td><td> <big>Text</big></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[center]Text[/center] </td><td> <center>Text</center></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[p=center]Text1[/p]Text2 (center, left, right) </td><td> <p align="center">Text1</p>Text2</td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[size=16]Text[/size] </td><td> <span style="font-size:16">Text</span></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[color=red]Text[/color] </td><td> <span style="color:red">Text</span></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[hr=25] </td><td> <hr width="25"></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[img]http://www.adres.com/image.gif[/img] </td><td> <img src="http://www.sciema.czuby.net/VerdeDistrito/templates/vd_blue/images/logo_footer.jpg"></td>';
	$popup .= '</tr><tr>';
	$popup .= '<td>[list]<br>[*]Text 1<br>[*]Text 2<br>[*]Text 3<br>[/list]</td><td><ul><li>Text 1</li><li>Text 2</li><li>Text 3</li></ul></td>';
	$popup .= '</tr><tr>';
	$popup .= '</table>';
}

$tpl->assign(array(
	"POPUP_BODY" => $popup,
));

$tpl->parse('MAIN');
$tpl->out('MAIN');

?>