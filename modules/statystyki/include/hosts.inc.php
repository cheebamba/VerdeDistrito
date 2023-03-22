<?
// najczesciej z hostow
horizontal($rmsg['title']['host'], 'host.isl', 'barh3.gif', $istat['count_host'], $rmsg['raport']['no_data']);

print('<br>');

// najczesciej z domen
horizontal($rmsg['title']['domain'], 'domena.isl', 'barh3.gif', $istat['count_domain'], $rmsg['raport']['no_data']);

print('<br>');

//najczesciej z krajow
horizontal($rmsg['title']['country'], 'lang.isl', 'barh3.gif', $istat['count_country'], $rmsg['raport']['no_data'], 1);


?>
