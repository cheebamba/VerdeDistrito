<?
##################################################################
#
#   File to configure stats program: conf.php
#   iStats 5 by AnubisDev (c)2000-2003 Wroclaw
#
##################################################################

#base url to iStats
$istat['base_url'] = 'http://www.sciema.czuby.net/VerdeDistrito/';

# passwords
$istat['pass_stat'] = '';
$istat['pass_conf'] = '';

# show number visible
$istat['count_host'] = '30';
$istat['count_referer'] = '30';
$istat['count_last'] = '30';
$istat['count_country'] = '30';
$istat['count_domain'] = '30';
$istat['count_browser'] = '30';
$istat['count_os'] = '30';
$istat['count_search'] = '30';
$istat['count_keyword'] = '30';

# time expired to save new hits in minutes
$istat['expired'] = '15';

$istat['pages'] = '1';

# lock to ip list
# format: 127.*.1.*, sign "*" it is any value 0-255
# adress explode signs ";"
$istat['wyklucz'] = ' ';

# language version
$istat['lang'] = 'pol';

# number version, please not changes
$istat['ver'] = 'v-5.5.5';
