<html>
	<head>
		<title>Imperator STATS</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-2'>
		<meta name='Author' content='Logic'>
		<meta http-equiv='Reply-to' content='istats@anubisev.com'>
		<link href='istats.css' rel='stylesheet' type='text/css'>
	</head>

	<script>focus()</script>

	<body bgcolor='#FFFFFF' leftmargin='0' topmargin='0' marginheight='0' marginwidth='0'>

	<?
	include('conf.php');
	include('lang/'.$istat['lang'].'.php');
	include('include/month.inc.php');

	$dane['logs'] = file('logs/'.$_GET['r'].'/'.($_GET['m']+1).'.php');
	$nrmonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	if($dane['logs'][0] == 1) $nrmonth[1] = 29;
# zmiana z
	$gm = getmonth($_GET['m']+1, $_GET['r']);
#	$gm = getmonth($_GET['m']);
	?>

	<table border='0' cellspacing='0' cellpadding='0' width='100%' bgcolor='black'>
		<tr>
			<td>
				<table class='small' width='469' bgcolor='#336699' cellpadding='2' cellspacing='1' border='0'>
					<tr bgcolor='#336699'>
						<td align='center' colspan='4' class='bmiddle'><? print($rmsg['month'][$_GET['m']].' '.$_GET['r']); ?></td>
					</tr>
					<tr bgcolor='#1D8FCD' class='wsmall'>
						<td align='center'><? print($rmsg['tail'][2]); ?></td>
						<td align='center'><? print($rmsg['tail'][3]); ?></td>
						<td align='center'><? print($rmsg['tail'][4]); ?></td>
					</tr>
	<?
	//$screen = file('logs/stat.isl');
	//$dane['stat'] = explode(',', $screen[0]);
	//$min_miesiac = $dane['stat'][46];

	$min_miesiac = $gm[0];
	$max_miesiac = 0;

	for($x=1; $x<=$nrmonth[$_GET['m']]; $x++) {
		if($gm[$x] > $max_miesiac) $max_miesiac = $gm[$x];
		if($gm[$x] < $min_miesiac) $min_miesiac = $gm[$x];
	}

	for($n=1; $n<=$nrmonth[$_GET['m']]; $n++) {
		if($max_miesiac != 0) $wysokosc = round((100*$gm[$n]/$max_miesiac)*3);
		else $wysokosc = 1;
		print('<tr bgcolor=\'#EEEEEE\'><td width=\'20\' class=\'small\'>&nbsp;'.$n.'</td>');
		print('<td align=\'left\' width=\'230\'><img src=\'img/barh2.gif\' border=\'0\' height=\'10\' width=\''.$wysokosc.'\'></td>');
		if(!isset($gm[$n])) $gm[$n] = 0;
		print('<td width=\'60\' class=\'small\'>&nbsp;'.$gm[$n].'</td></tr>');
	}
?>
				</table>
				<? pokazstan($max_miesiac, $min_miesiac, $nrmonth[$_GET['m']], $gm[0]); ?>
			</td>
		</tr>
	</table>

	</body>
</html>
?>
