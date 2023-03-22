<?
function getyear($rok, $typ='') {
	GLOBAL $nrmonth, $istat_path;

	$count_m[0] = 0;
	for($g=1; $g<=12; $g++) {
		$count_m[$g] = 0;
		$dane['logs'] = file($istat_path.'logs/'.$rok.'/'.$g.$typ.'.php');
		$ile_dni = $nrmonth[$g-1];
		for($n=0; $n<$ile_dni; $n++) {
			$a_dzien = explode(',', $dane['logs'][$n]);
			for($i=0; $i<24; $i++) $count_m[$g] += $a_dzien[$i];
		}
		$count_m[0] += $count_m[$g];
	}
	return $count_m;
}

// dane z dnia miesiaca
function getday($dzien, $miesiac, $rok) {
	GLOBAL $nrmonth, $istat_path;

	$dane['logs'] = file($istat_path.'logs/'.$rok.'/'.($miesiac-0).'.php');
	$a_dzien = explode(',', $dane['logs'][$dzien-1]);
	$a_day[0] = 0;
	for($n=1; $n<=24; $n++) $a_day[$n] = $a_dzien[$n-1];
	for($n=1; $n<=24; $n++) $a_day[0] += $a_day[$n];

	return $a_day;
}

// dane z miesiaca
function getmonth($miesiac, $rok) {
	GLOBAL $nrmonth, $istat_path;

	$dane['logs'] = file($istat_path.'logs/'.$rok.'/'.($miesiac-0).'.php');

	$ile_dni = $nrmonth[$miesiac-1];
	$count_m[0] = 0;
	for($x=1; $x<=$ile_dni; $x++) {
		$count_m[$x] = 0;
		$a_dzien = explode(',', $dane['logs'][$x-1]);
		for($d=0; $d<24; $d++) $count_m[$x] += $a_dzien[$d];
		$count_m[0] += $count_m[$x];
	}
	return $count_m;
}

// status
// max - najwieksza liczba odwiedzin
// min - najmniejsza liczba owiedzin
// ile - przz ile podzielic
// razem - sum odwiedzin
function pokazstan($max, $min, $ile, $razem) {
	GLOBAL $miesiac, $rmsg;
	if(empty($max)) $max = 0;
	if(empty($min)) $min = 0;
	if(empty($razem)) $razem = 0;
	if(!empty($ile)) $srednia = round($razem/$ile);
	else $srednia = 0;

	print('<table border=\'0\' width=\'100%\' cellspacing=\'0\' align=\'center\' class=\'min_max\' cellpadding=\'3\' bgcolor=\'#336699\'><tr align=\'center\'><td class=\'middle\'>');
	print('&nbsp;</td></tr></table>');
}
?>
