<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

// USTAWIENIA BAZY DANYCH

/*

$db_host = "localhost";	// adres hosta bazy danych ( gdy port inny niz 3306 nalezy go podac - np. localhost:9999 )
$db_user = "qalix";	// uzytkownik bazy danych
$db_pass = "";	// haslo uzytkownika
$db_name = "qalix_uk_db";	// nazwa bazy danych
$db_prefix = "vd_"; // prefiks przed nazwa tabelek w bazie danych

$db_host = "mysql1.yoyo.pl";	// adres hosta bazy danych ( gdy port inny niz 3306 nalezy go podac - np. localhost:9999 )
$db_user = "db138617";	// uzytkownik bazy danych
$db_pass = "Rastek1";	// haslo uzytkownika
$db_name = "db138617";	// nazwa bazy danych
$db_prefix = "vd_"; // prefiks przed nazwa tabelek w bazie danych

$db_host = "localhost";	// adres hosta bazy danych ( gdy port inny niz 3306 nalezy go podac - np. localhost:9999 )
$db_user = "sciema";	// uzytkownik bazy danych
$db_pass = "xth6KDf7";	// haslo uzytkownika
$db_name = "cnl1";	// nazwa bazy danych
$db_prefix = "vd_"; // prefiks przed nazwa tabelek w bazie danych

$db_host = "89.149.194.240:2222";	// adres hosta bazy danych ( gdy port inny niz 3306 nalezy go podac - np. localhost:9999 )
$db_user = "xxx_vddb";	// uzytkownik bazy danych
$db_pass = "Rastek1";	// haslo uzytkownika
$db_name = "xxx_vddb";	// nazwa bazy danych
$db_prefix = "vd_"; // prefiks przed nazwa tabelek w bazie danych

$db_host = "localhost";	// adres hosta bazy danych ( gdy port inny niz 3306 nalezy go podac - np. localhost:9999 )
$db_user = "wnetrzni_vd";	// uzytkownik bazy danych
$db_pass = "Rastek1";	// haslo uzytkownika
$db_name = "wnetrzni_vd";	// nazwa bazy danych
$db_prefix = "vd_"; // prefiks przed nazwa tabelek w bazie danych

*/

$db_host = "localhost";	// adres hosta bazy danych ( gdy port inny niz 3306 nalezy go podac - np. localhost:9999 )
$db_user = "sciema";	// uzytkownik bazy danych
$db_pass = "xth6KDf7";	// haslo uzytkownika
$db_name = "n2l";	// nazwa bazy danych
$db_prefix = "vd_"; // prefiks przed nazwa tabelek w bazie danych

// USTAWIENIA SYSTEMU

$deflang = "pl"; // jezyk qSystemu
$defskin = "vd_blue"; // nazwa stylu strony ( templates/X )
$deftimezone = '+01'; // strefa czasowa ( dla polski '+01' )

$skins = array(
	vd_blue => 'VD blue',
);

$langs = array(
	pl => 'Polski',
);

// USTAWIENIA TEBELEK BAZY DANYCH

$qs_db = array(
	users => $db_prefix.'users',
	config => $db_prefix.'config',
	log =>  $db_prefix.'log',
	levels => $db_prefix.'levels',
	pms => $db_prefix.'pms',
	news => $db_prefix.'news',
	comments => $db_prefix.'comments',
	articles => $db_prefix.'articles',
	cats => $db_prefix.'cats',
	smiles => $db_prefix.'smiles',
	online => $db_prefix.'online',
	shoutbox => $db_prefix.'shoutbox',
	friends => $db_prefix.'friends',
	pages => $db_prefix.'pages',
	members => $db_prefix.'members',
	wars => $db_prefix.'wars',
	files => $db_prefix.'files',
	fcats => $db_prefix.'fcats',
	fsubcats => $db_prefix.'fsubcats',
	topics => $db_prefix.'topics',
	posts => $db_prefix.'posts',
	mods => $db_prefix.'moderators',
	divs => $db_prefix.'divs',
);

?>
