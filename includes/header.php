<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

if($menuleft == 'OFF'){
	$tpl = new XTemplate(qs_tplfile('header2'));
}
else{
	$tpl = new XTemplate(qs_tplfile('header'));
}
$javascripts .= "<script type=\"text/javascript\" language=\"Javascript\">

function popup(type){
window.open('popup.php?a='+type,'Window','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=no,with=480,height=512,left=32,top=16');}

function mail(user, domain){window.location = 'mailto:'+user+'@'+domain;}

function flip( rid ){
document.getElementById(rid).style.display = document.getElementById(rid).style.display == 'none' ? 'block' : 'none'}

</script>
<script type=\"text/javascript\">
<!--

window.name='main';

	function addtextform(text)
	{
	document.form.text.value += text;
	document.form.text.focus();
	}

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

if(!empty($bbform)){
$javascripts .= "</script>

<script language=\"JavaScript\" type=\"text/javascript\">
<!--
var imgt = false;
var selection = false;
var cpc = navigator.userAgent.toLowerCase();
var cv = parseInt(navigator.appVersion);
var ie = ((cpc.indexOf(\"msie\") != -1) && (cpc.indexOf(\"opera\") == -1));
var nv = ((cpc.indexOf('mozilla')!=-1) && (cpc.indexOf('spoofer')==-1) && (cpc.indexOf('compatible') == -1) && (cpc.indexOf('opera')==-1) && (cpc.indexOf('webtv')==-1) && (cpc.indexOf('hotjava')==-1));
var mz = 0;
var win = ((cpc.indexOf(\"win\")!=-1) || (cpc.indexOf(\"16bit\") != -1));
var mac = (cpc.indexOf(\"mac\")!=-1);

bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[img]','[/img]','[url]','[/url]','[match]','[/match]','[roll]','[/roll]');
imgt = false;

function getarsize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == \"undefined\") || (thearray[i] == \"\") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

function arpush(thearray,value) {
	thearray[ getarsize(thearray) ] = value;
}

function arpop(thearray) {
	thearraysize = getarsize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.".$bbform.".".$bbinput.";

	if ((cv >= 4) && ie && win) {
		selection = document.selection.createRange().text;
		if (!selection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + selection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	warekeeper(txtarea);
}


function bbadd(bbnumber) {
	var txtarea = document.".$bbform.".".$bbinput.";

	donotinsert = false;
	selection = false;
	bblast = 0;

	if (bbnumber == -1) {
		while (bbcode[0]) {
			butnumber = arpop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			buttext = eval('document.".$bbform.".addbbcode' + butnumber + '.value');
			eval('document.".$bbform.".addbbcode' + butnumber + '.value =\"' + buttext.substr(0,(buttext.length - 1)) + '\"');
		}
		imgt = false;
		txtarea.focus();
		return;
	}

	if ((cv >= 4) && ie && win)
	{
		selection = document.selection.createRange().text;
		if (selection) {
			document.selection.createRange().text = bbtags[bbnumber] + selection + bbtags[bbnumber+1];
			txtarea.focus();
			selection = '';
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}

	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {
		while (bbcode[bblast]) {
				butnumber = arpop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
				buttext = eval('document.".$bbform.".addbbcode' + butnumber + '.value');
				eval('document.".$bbform.".addbbcode' + butnumber + '.value =\"' + buttext.substr(0,(buttext.length - 1)) + '\"');
				imgt = false;
			}
			txtarea.focus();
			return;
	} else {

		if (imgt && (bbnumber != 14)) {
			txtarea.value += bbtags[15];
			lastValue = arpop(bbcode) - 1;
			document.".$bbform.".addbbcode14.value = \"Img\";
			imgt = false;
		}

		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imgt == false)) imgt = 1;
		arpush(bbcode,bbnumber+1);
		eval('document.".$bbform.".addbbcode'+bbnumber+'.value += \"*\"');
		txtarea.focus();
		return;
	}
	warekeeper(txtarea);
}

function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2)
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

function warekeeper(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

//-->
</script>";
}

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

$loc = (empty($loc)) ? 'news' : $loc;

$tpl->assign(array(
	"HEADER_MAIN_TITLE" => $conf['global_maintitle'],
	"HEADER_TITLE" => $title,
	"HEADER_METAS" => $metas,
	"HEADER_LOC" => $loc,
	"HEADER_JAVA" => $javascripts,
	"HEADER_STYLES" => $style,
));

$tpl->parse('HEADER');
$tpl->out('HEADER');

?>