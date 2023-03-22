<?
// qSystem - made by qalix
// qSystem - Contact : qalix@op.pl
// qSystem - Ver.: 1.01
// qSystem - Date 2006-12-20

if(defined( 'QS_SYSTEM' )) { define('QS_SYSTEM', 1 ); } else { die( 'Zly adres URL.' ); }

$L = array(
	january => 'Stycze�',
	february => 'Luty',
	march => 'Marzec',
	april => 'Kwiecie�',
	may => 'Maj',
	june => 'Czerwiec',
	july => 'Lipiec',
	august => 'Sierpie�',
	september => 'Wrzesie�',
	october => 'Pazdziernik',
	november => 'Listopad',
	december => 'Grudzie�',
	qs_yes => 'Tak',
	qs_no => 'Nie',
	qs_nick => 'Nick',
	qs_name => 'Imi�',
	qs_surname => 'Nazwisko',
	qs_topic => 'Temat',
	qs_top => 'Powr�t do g�ry',
	qs_post => 'Post',
	qs_level => 'Poziom',
	qs_text => 'Info',
	qs_avatar => 'Avatar',
	qs_photo => 'Zdjecie',
	qs_regdate => 'Zarejestrowany',
	qs_joined => 'Do��czy�',
	qs_registered => 'Zarejestrowanych',
	qs_signature => 'Podpis',
	qs_forum => 'Forum',
	qs_occupation => 'Zajecie',
	qs_origin => 'Pochodzenie',
	qs_timezone => 'Strefa czasowa',
	qs_posts => 'Posty',
	qs_members => 'Cz�onkowie',
	qs_birthdate => 'Data urodzenia',
	qs_date => 'Data',
	qs_skin => 'Wygl�d',
	qs_lang => 'J�zyk',
	qs_pass => 'Has�o',
	qs_pass2 => 'Powt�rz has�o',
	qs_passn1 => 'Nowe has�o',
	qs_passn2 => 'Powt�rz nowe has�o',
	qs_url => 'Adres',
	qs_passo => 'Stare has�o',
	qs_email => 'Mail',
	qs_email2 => 'Powt�rz mail',
	qs_location => 'Miasto',
	qs_country => 'Kraj',
	qs_gg => 'Gadu-Gadu',
	qs_irc => 'Kanal IRC',
	qs_msn => 'MSN',
	qs_icq => 'ICQ',
	qs_website => 'Strona WWW',
	qs_gender => 'Plec',
	qs_codetxt => 'Kod bezpieczenstwa',
	qs_code => 'Kod',
	qs_remember => 'Zapamietaj',
	qs_gender_unknown => 'Nieznana',
	qs_gender_male => 'M�czyzna',
	qs_gender_female => 'Kobieta',
	qs_cpu => 'Procesor',
	qs_mb => 'P�yta g��wna',
	qs_ram => 'Pami��',
	qs_author => 'Autor',
	qs_whosonforum => 'Kto jest na Forum',
	qs_new_posts => 'Nowe posty',
	qs_none_new_posts => 'Brak nowych post�w',
	qs_forum_locked => 'Forum zablokowane',
	qs_topic_locked => 'Temat zablokowany',
	qs_forum_stats_1_1 => 'Nasi u�ytkownicy napisali',
	qs_forum_stats_1_2 => 'wiadomo�ci',
	qs_forum_stats_2_1 => 'Mamy',
	qs_forum_stats_2_2 => 'zarejestrowanych u�ytkownik�w',
	qs_forum_stats_3 => 'Ostatnio zarejestrowa� si�',
	qs_forum_stats_4_1 => 'Na stronie jest',
	qs_forum_stats_4_2 => 'u�ytkownik�w',
	qs_forum_stats_4_3 => 'Zarejestrowanych',
	qs_forum_stats_4_4 => 'Go�ci',
	qs_forum_stats_5 => 'U�ytkownicy przegl�daj�cy strone',
	qs_match => 'Mecz',
	qs_hide => 'Ukryj',
	qs_stor => 'Twardy dysk',
	qs_gc => 'Karta graficzna',
	qs_mc => 'Karta dzwi�kowa',
	qs_mon => 'Monitor',
	qs_mouse => 'Myszka',
	qs_replys => 'Odpowiedzi',
	qs_pad => 'Podk�adka',
	qs_hp => 'S�uchawki',
	qs_net => '��cze',
	qs_os => 'System',
	qs_res => 'Rozdzielczo��',
	qs_sens => 'Sensitivity',
	qs_drink => 'Nap�j',
	qs_food => 'Jedzenie',
	qs_book => 'Ksi��ka',
	qs_mov => 'Film',
	qs_act => 'Aktor/Aktorka',
	qs_mus => 'Muzyka',
	qs_plr => 'Gracz',
	qs_ourplr => 'Gracz VD',
	qs_team => 'Dru�yna',
	qs_hobby => 'Hobby',
	qs_sport => 'Sport',
	qs_game => 'Gra',
	qs_friends => 'Znajomi',
	qs_send => 'Wy�lij',
	qs_cp => 'Zmie� has�o',
	qs_welcome => 'Witaj',
	qs_profile => 'Profil',
	qs_login => 'Zaloguj',
	qs_logout => 'Wyloguj',
	qs_registration => 'Rejestracja',
	qs_changepass => 'Zmien has�o',
	qs_edit => 'Edytuj',
	qs_delete => 'Usu�',
	qs_orygmsg => 'Oryginalna wiadomo��',
	qs_end => 'Koniec',
    qs_begin => 'Poczatek',
	qs_content => 'Tre��',
	qs_pmbox => 'Nowe wiadomo��i',
	qs_archives => 'Archiwum',
    qs_archive => 'Archiwuj',
	qs_sentbox => 'Wys�ane',
	qs_newpm => 'Wy�lij wiadomo��',
	qs_wrongpm => 'Dana wiadomo�� nie istnieje',
	qs_nonepms => 'Brak wiadomo��i',
	qs_re => 'Odp',
    qs_reply => 'Odpowiedz',
	qs_comment => 'Komentuj',
	qs_comments => 'Komentarzy',
	qs_ownern => 'Napisa�',
	qs_wroteby2 => 'napisa�',
	qs_readmore => 'Wi�cej',
	qs_stlocked => 'Zab.',
	qs_addcomment => 'Dodaj komentarz',
	qs_notlogged => 'Nie jestes zalogowany.',
	qs_comdone => 'Komentarz dodany.',
	qs_shodone => 'Shout dodany.',
	qs_actionproblem => 'Wystapi� problem.',
	qs_websettings => 'Ustawienia strony',
	qs_images => 'Obrazki',
	qs_contact => 'Kontakt',
	qs_data => 'Dane',
	qs_fav => 'Ulubione',
	qs_hard => 'Sprz�t',
    qs_pm => 'PM',
    qs_title => 'Tytu�',
    qs_to => 'Do',
    qs_from => 'Od',
    qs_wfrom => 'Sk�d',
    qs_wroteby => 'Napisa�',
    qs_des => 'Opis',
    qs_character => 'Znak',
    qs_nonetopics => 'Brak Temat�w',
    qs_userswatchingf => 'U�ytkownicy przegl�daj�cy to forum',
	qs_topics => 'Tematy',
	qs_last => 'Ostatni',
	qs_lastp => 'Ostatni Post',
	qs_moderators => 'Moderatorzy',
	qs_advert => 'Og�oszenie',
    qs_topm2 => '(nazwy u�ytkownik�w oddzielaj przecinkiem)',
    qs_pmemptyto => 'Nie podano adresata',
    qs_withdraw => 'Cofnij akceptacj�',
    qs_lostpass => 'Zgubi�e� has�o?',
    qs_comdeleted => 'Komentarz usuni�ty',
    qs_comupdated => 'Komentarz zmieniony',
    qs_editcom => 'Edytuj komentarz',
    qs_online => 'Online',
    qs_present_time => 'Obecny czas to',
    qs_users => 'U�ytkownik�w',
    qs_member => 'Cz�onek',
    qs_guests => 'Go�ci',
    qs_catid => 'ID kategori',
    qs_from2 => 'z',
    qs_age => 'Wiek',
    qs_hardwares => 'Sprz�t',
    qs_favourites => 'Ulubione',
    qs_shouts => 'Shouty',
    qs_newshout => 'Wy�lij shout\'a',
    qs_previous => 'Poprzednia',
    qs_next => 'Nast�pna',
    qs_seeall => 'Zobacz wszystkie',
    qs_onpage => 'Na tej stronie',
    qs_friendrequest => 'Akceptuj znajomego',
    qs_wantfriend => 'Chce do��czy� do twoich znajomych',
    qs_faccept1 => 'Zezw�l',
    qs_faccept2 => 'Zezw�l i dodaj do swojej listy',
    qs_freject => 'Odrzu� pro�be',
    qs_delfriend => 'Usu� znajomego',
    qs_addasfriend => 'Dodaj jako znajomego',
    qs_change => 'Zmie�',
    qs_addcat => 'Dodaj kategorie',
    qs_adddiv => 'Dodaj dywizj�',
    qs_addscat => 'Dodaj podkategorie',
    qs_catalreadyexists => 'Kategoria o takim id ju� istnieje.',
    qs_id => 'ID',
    qs_subid => 'sID',
    qs_sent => 'Wys�any',
    qs_cattitle => 'Nazwa',
    qs_st => 'Skr�t',
    qs_order => 'Kolejno��',
    qs_minlevel => 'Minimalny poziom',
    qs_minlvl => 'Min poziom',
    qs_text1 => 'Tre�� (kr�tsza)',
    qs_text2 => 'Tre�� d�u�sza (opcjonalnie)',
    qs_category => 'Kategoria',
    qs_news => 'News',
    qs_accept => 'Akceptuj',
    qs_since => 'Z nami od',
    qs_article => 'Artyku�',
    qs_picture => 'Obrazek',
    qs_deleteart => 'Usu� ca�y artyku�',
    qs_addpage => 'Dodaj strone',
    qs_pagenum => 'Numer strony',
    qs_page => 'Strona',
    qs_add => 'Dodaj',
    qs_deletepage => 'Usu� strone',
    qs_gotoprofile => 'zobacz profil',
    qs_div => 'Dywizja',
    qs_writenewtopic => 'Rozpocznij nowy w�tek',
    qs_userid => 'ID u�ytkownika',
    qs_leader => 'Lider',
    qs_inactive => 'Nieaktywny',
    qs_active => 'Aktywny',
    qs_addmem => 'Dodaj cz�onka',
    qs_all => 'Wszystkich',
    qs_opp => 'Przeciwnik',
    qs_leev => 'Liga/Event',
    qs_result => 'Wynik',
    qs_won => 'Wygrane',
    qs_lost => 'Przegrane',
    qs_draw => 'Zremisowane',
    qs_maps => 'Mapy',
    qs_lvlalreadye => 'Taki poziom ju� istnieje',
    qs_see => 'Zobacz',
    qs_sb => 'Scorebot',
    qs_view => 'Podglad',
    qs_views => 'Wy�wietle�',
    qs_squad => 'Sk�ad',
    qs_game => 'Gra',
    qs_tm => 'Godz',
    qs_map1 => 'Pierwsza mapa',
    qs_map2 => 'Druga mapa',
    qs_tva => 'IP tv (gtv, hltv)',
    qs_lcountry => 'Kraj Ligi/Eventu',
    qs_ocountry => 'Kraj przeciwnika',
    qs_usquad => 'Nasz sk�ad',
    qs_common => 'Zwyk�y',
    qs_lock => 'Zablokuj',
    qs_sticked => 'Przyklejony',
    qs_osquad => 'Sk�ad przeciwnika',
    qs_active => 'Aktywny',
    qs_imgurl => '�cie�ka obrazka',
    qs_addnewsmile => 'Dodaj now� emotikon�',
    qs_opplogo => 'Logo przeciwnika',
    qs_urltoimg => 'Adres do twojego obrazka',
    qs_fileurl => 'Adres do pliku',
    qs_filesize => 'Rozmiar pliku (podaj jednostke: KB, MB)',
    qs_filename => 'Nazwa',
    qs_size => 'Rozmiar',
    qs_downloaded => 'Sci�gni�to',
    qs_sentby => 'Doda�',
    qs_sentat => 'Data dodania',
    qs_download => 'Sci�gnij',
    qs_incoming => 'Nadchodz�cy',
    qs_newtopic => 'Rozpocznij nowy teamt',
    qs_ico => 'Ikonka',
    qs_moveto => 'Przenie�',
    qs_quotation => 'Cytat',
    qs_writereply => 'Napisz odpowiedz',
    qs_edittopic => 'Edytuj temat',
    qs_editpost => 'Edytuj post',
    qs_asblock => 'Nie mo�esz odpowiada� na w�asny post.',
    qs_topic_new => 'Temat - Nowe posty',
    qs_topic_old => 'Temat - Brak nowych',
    qs_topic_locked => 'Temat - Zablokowany',
    qs_sticked_new => 'Przyklejony - Nowe posty',
    qs_sticked_old => 'Przyklejony - Brak nowych',
    qs_sticked_locked => 'Przyklejony - Zablokowany',
    qs_advert_new => 'Og�oszenie - Nowe posty',
    qs_advert_old => 'Og�oszenie - Brak nowych',
    qs_advert_locked => 'Og�oszenie - Zablokowany',
    qs_logtodown => 'Musisz by� zalogowany by pobra� ten plik.',
	qs_ownanswer => 'Nie mo�esz odpowiada� na w�asn� wiadomo��.',
	qs_comwronglen => 'Z�a d�ugo�� komentarza (d�u�szy ni� 2 i kr�tszy ni� 600 znak�w)',
	qs_newswronglen => 'Z�a d�ugo�� tre�ci lub tytu�u (d�u�szy ni� 1 i kr�tszy ni� 64 znaki)',
	qs_topicwronglen => 'Z�a d�ugo�� tytu�u (1-64 znak�w).',
	qs_messagewronglen => 'Nie poda�e� tre�ci wiadomo�ci.',
	qs_showronglen => 'Z�a d�ugo�� shout\'a (d�u�szy ni� 1 i kr�tszy ni� 600 znak�w)',
	qs_pmtextwronglen => 'Z�a d�ugo�� wiadomo��i (d�u�sza ni� 2 i kr�tsza ni� 3000 znak�w)',
	qs_pmtitlewronglen => 'Z�a d�ugo�� tematu (wiecej ni� 1 i mniej ni� 24)',
	qs_pmwronguser => 'Dany u�ytkownik nie istnieje',
	qs_avatarwrongext => 'Z�e rozszrzenie avatara (.jpg, .gif, .png).',
	qs_avatartoobig => 'Avatar za du�y',
	qs_avatarwrongxy => 'Z�y rozmiar obrazka',
	qs_photowrongext => 'Z�e rozszrzenie zdjecia (.jpg, .gif, .png).',
	qs_phototoobig => 'Zdjecie za du�e',
	qs_photowrongxy => 'Z�y rozmiar obrazka',
	qs_emptyfields => 'Wymagane pola (*) nie zosta�y wype�nione.',
	qs_emptyfieldslog => 'Nie poda�es danych.',
	qs_inusenick => 'Ten nick istnieje ju� w naszej bazie, wybierz inny.',
	qs_inuseemail => 'Taki mail istnieje ju� w naszej bazie.',
	qs_wrongnicklen => 'Z�a d�ugo�� nicka ( kr�tszy od 20 i d�u�szy od 2 ).',
	qs_wrongpasslen => 'Z�a d�ugo�� has�a ( kr�tsze od 32 i d�u�sze od 4 ).',
	qs_wrongpasso => 'Poda�es z�e stare has�o.',
	qs_illegalnick => 'Nieprawid�owy nick.',
	qs_illegalpass => 'Nieprawid�owe has�o.',
	qs_wrongnick => 'Nieprawid�owy nick.',
	qs_wrongpass => 'Has�a sie nie zgadzaja.',
	qs_wrongemail => 'Nieprawid�owy mail.',
	qs_wrongcode => 'Kod nie pasuje.',
	qs_logerror => 'B�ad, uzytkownik nie istnieje lub poda�es b��dne has�o.',
	qs_usernotactive => 'Twoje konto nie jest aktywne.',
    qs_privatemessages => 'Wiadomo�ci',
    qs_msg => 'Wiadomo�ci',
	qs_none => 'Brak',
	qs_message => 'Wiadomo��',
	qs_nonecom => 'Brak komentarzy.',
	qs_mailnotsend => 'Mail nie zosta� wys�any.',
	qs_lostpass => 'Zgubione has�o',
	qs_lptext => 'Podaj e-mail, kt�rego u�y�e� podczas rejestracji, je�sli mail bedzie poprawny, to login oraz has�o zostan� na niego wys�ane',
	qs_example => 'Przyk�ad',
	qs_working => 'Dzia�anie',
	qs_default => 'Domy�lny',
	qs_darkred => 'Ciemnoczerwony',
	qs_red => 'Czerwony',
	qs_orange => 'Pomara��zowy',
	qs_brown => 'Br�zowy',
	qs_yellow => '��ty',
	qs_green => 'Zielony',
	qs_olive => 'Oliwkowy',
	qs_cyan => 'B��kitny',
	qs_blue => 'Niebieski',
	qs_darkblue => 'Ciemnoniebieski',
	qs_indigo => 'Purpurowy',
	qs_violet => 'Fioletowy',
	qs_white => 'Bia�y',
	qs_black => 'Czarny',
	qs_min => 'Minimalny',
	qs_small => 'Ma�y',
	qs_normal => 'Normalny',
	qs_big => 'Du�y',
	qs_huge => 'Ogromny',
	qs_color => 'Kolor',
	qs_delphoto => 'Usu� zdj�cie',
	qs_delmember => 'Usu� cz�onka',
);

$T = array(
    'administration' => 'Administracja',
	'auth.reg' => 'Rejestracja',
	'auth' => 'Logowanie',
	'abbcode' => 'BBCode',
	'emots' => 'Emotikony',
	'logs' => 'Logi',
	'config' => 'Konfiguracja',
	'panel' => 'Panel adm.',
	'news' => 'Newsy',
	'forum' => 'Forum',
	'levels' => 'Poziomy',
	'profile' => 'Profil',
	'profile.cp' => 'Zmiana has�a',
	'message' => 'Wiadomo�c',
	'users' => 'U�ytkownicy',
	'pm.unreadbox' => 'PW - Nieprzeczytane',
	'pm.new' => 'PW - Wy�lij wiadomo��',
	'pm.archives' => 'PW - Archiwum',
	'pm.view' => 'PW - Wiadomo��',
	'pm.sentbox' => 'PW - Wys�ane',
	'pm.send' => 'PW - Wysy�anie wiadomo��i',
	'news' => 'News',
	'news.archives' => 'Archiwum News',
	'news.view' => 'Wyswietl news',
	'articles' => 'Artyku�y',
	'wars' => 'Wars',
	'shoutbox' => 'Shoutbox',
	'news.add' => 'Dodaj Newsa',
	'cats' => 'Kategorie',
	'news.edit' => 'Edytouj Newsa',
	'authorize' => 'Autoryzacja',
	'myauthorize' => 'Moje artykuly w autoryzacja',
	'pages' => 'Strony',
	'page.add' => 'Dodaj strone',
	'page.edit' => 'Edytuj strone',
	'awards' => 'Osi�gni�cia',
	'contact' => 'Kontakt',
	'comments' => 'Komentarze',
	'about' => 'O nas',
	'sponsors' => 'Sponsorzy',
	'lost.pass' => 'Zgubione has�o',
	'article.add' => 'Dodaj artyku�',
	'article.edit' => 'Edytuj artyku�',
	'article.view' => 'Wyswietl artyku�',
	'team' => 'Dru�yna',
	'wars' => 'Mecze',
	'war.add' => 'Dodaj mecz',
	'war.edit' => 'Edytuj mecz',
	'upload' => 'Upload obrazk�w',
	'file.add' => 'Dodaj plik',
	'files' => 'Pliki',
	'file' => 'Plik'
);

$BBC = array(
	b => 'Pogrubiony',
);

$MT = array(
	reg1 => 'Otrzyma�e� tego emaila poniewa� rejestrowa�e� si� (lub kto� uzywaj�cy Twojego maila) na stronie',
	reg2 => 'Jezeli tego nie robi�es zignoruj tego maila, w razie powtarzania si� tej sytuacji skontaktuj si� z administratorem ',
	reg3 => 'Aby aktywowa� konto na stronie u�yj linku:',
	reg4 => 'Loguj sie poprzez :',
	reg5 => 'W razie problem�w skontaktuj si� z administratorem serwisu',
	lp1 => 'Otrzyma�e� tego emaila poniewa� uzy�e� formularzu zapomnianego has�a (lub kto� uzywaj�cy Twojego maila) na stronie',
	lp2 => 'Jezeli tego nie robi�es zignoruj tego maila, w razie powtarzania si� tej sytuacji skontaktuj si� z administratorem ',
	lp3 => 'W razie problem�w skontaktuj si� z administratorem serwisu',
);

$F = array(
	af => 'Afganistan',
	za => 'Afryka Po�udniowa',
	al => 'Albania',
	ad => 'Andora',
	en => 'Anglia',
	an => 'Antyle',
	sa => 'Arabia Saudyjska',
	ar => 'Argentyna',
	am => 'Armenia',
	aw => 'Aruba',
	au => 'Australia',
	at => 'Austria',
	az => 'Azerbejd�an',
	bs => 'Bahama',
	bh => 'Bahrain',
	bd => 'Bangladesz',
	bb => 'Barbados',
	be => 'Belgia',
	bz => 'Belize',
	bj => 'Benin',
	bm => 'Bermudy',
	bt => 'Bhutan',
	by => 'Bia�oru�',
	bo => 'Boliwia',
	ba => 'Bo�nia i Hercegowina',
	bw => 'Botswana',
	br => 'Brazylia',
	bn => 'Brunei',
	bg => 'Bu�garia',
	bf => 'Burkina Faso',
	bi => 'Burundi',
	cl => 'Chile',
	cn => 'Chiny',
	hr => 'Chorwacja',
	cy => 'Cypr',
	cz => 'Czechy',
	dk => 'Dania',
	eg => 'Edipt',
	ec => 'Ekwador',
	er => 'Erytrea',
	ee => 'Estonia',
	et => 'Etiopia',
	eu => 'Europa',
	fj => 'Fid�i',
	fi => 'Finlandia',
	fr => 'Francja',
	ga => 'Gabon',
	gi => 'Giblartar',
	gr => 'Grecja',
	gl => 'Grenlandia',
	ge => 'Gruzja',
	gu => 'Guam',
	gt => 'Gwatemala',
	gn => 'Gwinea',
	ht => 'Haiti',
	es => 'Hiszpania',
	nl => 'Holandia',
	hk => 'Hong Kong',
	in => 'Indie',
	id => 'Indonezja',
	iq => 'Irak',
	ir => 'Iran',
	ie => 'Irlandia',
	is => 'Islandia',
	il => 'Izrael',
	jm => 'Jamajka',
	jp => 'Japonia',
	ye => 'Jemen',
	jo => 'Jordan',
	yu => 'Jugos�awia',
	cm => 'Kamerun',
	ca => 'Kanada',
	qa => 'Katar',
	kz => 'Kazachstan',
	ke => 'Kenia',
	kg => 'Kirgistan',
	co => 'Kolumbia',
	cg => 'Kongo',
	kr => 'Korea Po�udniowa',
	kp => 'Korea P�nocna',
	cr => 'Kostaryka',
	cu => 'Kuba',
	kw => 'Kuwejt',
	lb => 'Liban',
	ly => 'Libia',
	lt => 'Litwa',
	lu => 'Luksemburg',
	lv => '�otwa',
	mg => 'Madagaskar',
	my => 'Malezja',
	mr => 'Mauretania',
	mx => 'Meksyk',
	md => 'Mo�dawia',
	mc => 'Monako',
	mn => 'Mongolia',
	mz => 'Mozambik',
	na => 'Namibia',
	nr => 'Nauru',
	de => 'Niemcy',
	no => 'Norwegia',
	nz => 'Nowa Zelandia',
	om => 'Oman',
	pk => 'Pakistan',
	pa => 'Panama',
	py => 'Paragwaj',
	pe => 'Peru',
	pl => 'Polska',
	pt => 'Portugalia',
	pr => 'Puerto Rico',
	cf => 'Republika Afryki Srodkowej',
	ru => 'Rosja',
	ro => 'Rumunia',
	lc => 'Saint Lucia',
	sn => 'Senegal',
	sl => 'Sierra Leone',
	sg => 'Singapur',
	sk => 'S�owacja',
	si => 'S�owenia',
	so => 'Somalia',
	sd => 'Sudan',
	sx => 'Szkocja',
	ch => 'Szwajcaria',
	se => 'Szwecja',
	wr => 'Swiat',
	th => 'Tajlandia',
	tw => 'Tajwan',
	tz => 'Tanzania',
	tg => 'Togo',
	tt => 'Trynidad i Tobago',
	tn => 'Tunezja',
	tr => 'Turcja',
	tv => 'Tuwalu',
	ug => 'Uganda',
	ua => 'Ukraina',
	uy => 'Urugwaj',
	us => 'USA',
	uz => 'Uzbekistan',
	wa => 'Walia',
	va => 'Watykan',
	ve => 'Wenezuela',
	hu => 'W�gry',
	uk => 'Wielka Brytania',
	vn => 'Wietnam',
	it => 'W�ochy',
	ci => 'Wybrze�e Ko�ci s�oniowej',
	ck => 'Wyspy Cooka',
	vg => 'Wyspy Dziewicze',
	fo => 'Wyspy Owcze',
	tc => 'Wyspy Turks i Caicos',
	cv => 'Zielony Przyl�dek',
	ae => 'Zjednoczone Emiraty Arabskie'
);

?>
