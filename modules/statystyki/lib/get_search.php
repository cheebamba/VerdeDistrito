<?
// lista ile razy dana wyszukiwarka wprowadzi³a dan¹ osobê na nasz¹ stronê
function istatSearch($refer) {
        $sr[] = array('wp', 'szukaj', 'Wirtualna Polska');
        $sr[] = array('poland', 'query', 'Poland.com');
        $sr[] = array('ahoj', 'q', 'Ahoj.pl');
        $sr[] = array('altavista', 'q', 'Altavista.com');
        $sr[] = array('google', 'q', 'Google');
        $sr[] = array('google', 'as_q', 'Google');
        $sr[] = array('yoyo', 'wpis', 'Yoyo.pl');
        $sr[] = array('onet', 'qt', 'Onet.pl');
        $sr[] = array('hoga', 'qt', 'Hoga.pl');
        $sr[] = array('arena', 'qt', 'Arena.pl');
        $sr[] = array('emulti', 'wyr', 'Emulti.pl');
        $sr[] = array('abacho', 'q', 'Abacho');
        $sr[] = array('bestoftheweb', 'q', 'Best Of The Web');
        $sr[] = array('bluewin', 'q', 'Bluewin');
        $sr[] = array('fireball', 'q', 'Fireball');
        $sr[] = array('kvasir', 'q', 'Kvasir');
        $sr[] = array('msn', 'q', 'MSN');
        $sr[] = array('search', 'q', 'Search');
        $sr[] = array('infoseek', 'qt', 'InfoSeek');
        $sr[] = array('acoon', 'begriff', 'Acoon');
        $sr[] = array('alltheweb', 'query', 'All The Web');
        $sr[] = array('evision', 'query', 'Evision');
        $sr[] = array('aol', 'query', 'AOL');
        $sr[] = array('freenet', 'query', 'FreeNet');
        $sr[] = array('lycos', 'query', 'Lycos');
        $sr[] = array('mamma', 'query', 'Mamma');
        $sr[] = array('big-search', 'search', 'Big Search');
        $sr[] = array('cypria', 'search', 'Cypria');
        $sr[] = array('excite', 'search', 'Excite');
        $sr[] = array('ask', 'ask', 'Ask');
        $sr[] = array('netscape', 'search', 'Netscape');
        $sr[] = array('metaspinner', 'qry', 'MetSpinner');
        $sr[] = array('nbci', 'keyword', 'Nbci');
        $sr[] = array('web', 'su', 'North Ernlight');
        $sr[] = array('yahoo', 'p', 'Yahoo');
        $sr[] = array('szukacz.icm', 'q', 'Szukacz-ICM');
        $sr[] = array('yandex', 'text', 'Yandex.pl');
        $sr[] = array('netsprint', 'qt', 'netsprint');
        $sr[] = array('o2', 'szukaj', 'O2.pl');

        $seach = '';

        // parsuj url'a
        $url = parse_url($refer);

        // twórz zmienne z zapytania url'a
        parse_str($url['query']);

        // liczba znanych wyszukiwarek
        $ile = count($sr);

        // zidentyfikuj wyszukiwarke
        for($n=0; $n<$ile; $n++)
    {
                if(@eregi($sr[$n][0], $refer) && isset($$sr[$n][1]))
        {
                        $search = $sr[$n][2];
                        break;
                }
         }

        // slowa kluczowe
        if(!empty($search)) {
                $srq = $$sr[$n][1];
                $srq = strtolower($srq);
                $sign = array('%22', '%23', '%24', '%25', '%26', '%27', '%2a', '%2b', '%2c', '%5c');
                while(list($keysign, $valuesign) = each($sign)) $srq = str_replace($valuesign, '', $srq);
                $srq = str_replace('+', ' ', $srq);
                $srq = stripslashes($srq);
                $srq = rawurldecode($srq);
                $ret[1] = strtolower($srq);
                $ret[0] = $search;
        }
        return $ret;
}

?>

