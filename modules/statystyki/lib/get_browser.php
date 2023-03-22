<?
// funkcja identyfikujaca przegladarke
function istatBrowser($agent) {
        $rbrowser[] = array('(java) ([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})', 'Java');
        $rbrowser[] = array('(NetPositive) /([0-9]{1,2}\.[0-9]{0,3})', 'NetPositive');
        $rbrowser[] = array('(FrontPage) ([0-9]{1,2}\.[0-9]{1,2})', 'MS FrontPage');
        $rbrowser[] = array('(PHP)/([0-9]{1,2}\.[0-9]{1,2})', 'PHP');
        $rbrowser[] = array('(WebWasher) ([0-9]{1,2}\.[0-9]{1,2})', 'WebWasher');
        $rbrowser[] = array('(opera) ([0-9]{1,2}\.[0-9]{1,3})', 'Opera');
        $rbrowser[] = array('(opera) ([0-9]{1,2}\.[0-9x]{1,3})', 'Opera');
        $rbrowser[] = array('(msie) ([0-9]{1,2}\.[0-9]{1,2})', 'Internet Explorer');
        $rbrowser[] = array('(netscape6)[/]{1,2}([0-9]{1,2}\.[0-9]{1,4})', 'Netscape');
//        $rbrowser[] = array('(netscape6)//([0-9]{1,2}\.[0-9]{1,4})', 'Netscape');
        $rbrowser[] = array('mozilla/5', 'Netscape');
        $rbrowser[] = array('(mozilla)/([0-9]{1,2}\.[0-9]{1,3})', 'Netscape');
        $rbrowser[] = array('(firebird)[/]{1,2}([0-9]{1,2}\.[0-9]{1,4})', 'Mozilla Firebird');
        $rbrowser[] = array('(konqueror)/([0-9]{1,2}\.[0-9])', 'Konqueror');
        $rbrowser[] = array('lynx', 'Lynx');
        $rbrowser[] = array('(links) \.([0-9]{1,2}\.[0-9]{1,2})', 'Links');
        $rbrowser[] = array('mosaic', 'Mosaic');
        $rbrowser[] = array('(teleport pro)/([0-9\.]{1,9})', 'Teleport Pro');
        $rbrowser[] = array('(Amiga-AWeb)/([0-9 ]{1}\.[0-9]{1,2}\.[0-9]{1,4})', 'Amiga-AWeb');
        $rbrowser[] = array('(amigavoyager)/([0-9]{1}\.[0-9]{1,2}\.[0-9]{1,4})', 'AmigaVoyager');
        $rbrowser[] = array('AvantGo) ([0-9]{1}\.[0-9]{1,2})', 'AvantGo');
        $rbrowser[] = array('(AvantGo) ([0-9]{1}\.[0-9]{1,2})', 'BrowserEmulator');
        $rbrowser[] = array('(cosmos)/([0-9]{1,2}\.[0-9]{1,3})', 'Cosmos');
        $rbrowser[] = array('(da) ([0-9]{1,2}\.[0-9]{1,3})', 'Download Accelerator');
        $rbrowser[] = array('flashget', 'FlashGet');
        $rbrowser[] = array('(GetRight)/([0-9]{1,2}\.[0-9b]{1,3})', 'GetRight');
        $rbrowser[] = array('(gigabaz)/([0-9]{1,2}\.[0-9]{1,3})', 'GigaBaz');
        $rbrowser[] = array('(go!zilla) ([0-9]{1,2}\.[0-9b]{1,3})', 'Go!zilla');
        $rbrowser[] = array('(gozilla) ([0-9]{1,2}\.[0-9b]{1,3})', 'Go!zilla');
        $rbrowser[] = array('(ibrowse)/([0-9]{1,2}\.[0-9]{1,3})', 'IBrowser');
        $rbrowser[] = array('(ICS) ([0-9]{1,2}\.[0-9]{1,3}\.[0-9]{1,3})', 'ICS');
        $rbrowser[] = array('(lwp-trivial)/([0-9]{1,2}\.[0-9]{1,3})', 'lpw-trivial');
        $rbrowser[] = array('(Lotus-Notes)/([0-9]{1,2}\.[0-9]{1,3})', 'Lotus-Notes');
        $rbrowser[] = array('(msproxy)/([0-9]{1,2}\.[0-9]{0,3})', 'MSProxy');
        $rbrowser[] = array('(NetAnts)/([0-9]{1,2}\.[0-9]{0,3})', 'NetAnts');
        $rbrowser[] = array('(offline explorer)/([0-9]{1,2}\.[0-9]{0,3})', 'Offline Explorer');
        $rbrowser[] = array('(Penetrator) ([0-9]{1,2}\.[0-9]{0,3})', 'Penetrator');
        $rbrowser[] = array('(planetweb)/([0-9]{1,2}\.[0-9ab]{0,4})', 'Planetweb');
        $rbrowser[] = array('(PowerNet)/([0-9]{1,2}\.[0-9]{0,4})', 'PowerNet');
        $rbrowser[] = array('(Rotondo)/([0-9]{1,2}\.[0-9]{0,3})', 'Rotondo');
        $rbrowser[] = array('(UP\.Browser)/([0-9]{1,2}\.[0-9]{0,3})', 'UP.Browser');
        $rbrowser[] = array('w3m', 'W3M');
        $rbrowser[] = array('(WebCapture) ([0-9]{1,2}\.[0-9]{0,3})', 'WebCapture');
        $rbrowser[] = array('(WebCopier v)([0-9]{1,2}\.[0-9]{0,3})', 'WebCopier');
        $rbrowser[] = array('(webcollage)/([0-9]{1,2}\.[0-9]{0,3})', 'Webcollage');
        $rbrowser[] = array('(WebScrape)/([0-9]{1,2}\.[0-9]{0,3})', 'WebScrape');
        $rbrowser[] = array('(web downloader)(/[0-9]{1,2}\.[0-9]{0,1})', 'Web Downloader');
        $rbrowser[] = array('(mas downloader)(/[0-9]{1,2}\.[0-9]{0,1})', 'Web Downloader');
        $rbrowser[] = array('(webstripper)/([0-9]{1,2}\.[0-9]{0,3})', 'WebStripper');
        $rbrowser[] = array('(WebZIP)/([0-9]{1,2}\.[0-9]{0,3})', 'WebZIP');
        $rbrowser[] = array('webtv', 'WebTv');
        $rbrowser[] = array('(Wget)/([0-9]{1,2}\.[0-9]{0,3})', 'WGet');
        // robots
  $rbrowser[] = array('analyzer', 'Robots/Spider');
  $rbrowser[] = array('arena\.pl', 'Robots/Spider');
  $rbrowser[] = array('arachnofilia', 'Robots/Spider');
  $rbrowser[] = array('aspseek', 'Robots/Spider');
  $rbrowser[] = array('bot', 'Robots/Spider');
  $rbrowser[] = array('check', 'Robots/Spider');
  $rbrowser[] = array('crawl', 'Robots/Spider');
  $rbrowser[] = array('google', 'Robots/Spider');
  $rbrowser[] = array('infoseek', 'Robots/Spider');
  $rbrowser[] = array('inktomi', 'Robots/Spider');
  $rbrowser[] = array('netoskop', 'Robots/Spider');
  $rbrowser[] = array('NetSprint', 'Robots/Spider');
  $rbrowser[] = array('openfind', 'Robots/Spider');
  $rbrowser[] = array('roamer', 'Robots/Spider');
  $rbrowser[] = array('robot', 'Robots/Spider');
  $rbrowser[] = array('rover', 'Robots/Spider');
  $rbrowser[] = array('scooter', 'Robots/Spider');
  $rbrowser[] = array('search', 'Robots/Spider');
  $rbrowser[] = array('siphon', 'Robots/Spider');
  $rbrowser[] = array('slurp', 'Robots/Spider');
  $rbrowser[] = array('spider', 'Robots/Spider');
  $rbrowser[] = array('sweep', 'Robots/Spider');
  $rbrowser[] = array('szukaj', 'Robots/Spider');
  $rbrowser[] = array('walker', 'Robots/Spider');
  $rbrowser[] = array('WebStripper', 'Robots/Spider');
  $rbrowser[] = array('wisenutbot', 'Robots/Spider');
  $rbrowser[] = array('gulliver', 'Robots/Spider');
  $rbrowser[] = array('validator', 'Robots/Spider');
  $rbrowser[] = array('yandex', 'Robots/Spider');
  $rbrowser[] = array('ask jeeves', 'Robots/Spider');
  $rbrowser[] = array('moget@', 'Robots/Spider');
  $rbrowser[] = array('teomaagent', 'Robots/Spider');
  $rbrowser[] = array('infoNavirobot', 'Robots/Spider');
  $rbrowser[] = array('PPhpDig', 'Robots/Spider');
  $rbrowser[] = array('gigabaz', 'Robots/Spider');
  $rbrowser[] = array('Webclipping\.com', 'Robots/Spider');
  $rbrowser[] = array('RRC', 'Robots/Spider');
  $rbrowser[] = array('netmechanic', 'Robots/Spider');

        $ile = count($rbrowser);
        $browser = '';
        for($n=0; $n<$ile; $n++) {
                if(@eregi($rbrowser[$n][0], $agent, $wersja)) {
                        $browser = @$rbrowser[$n][1].' '.@$wersja[2];
                        break;
                }
         }
        return trim($browser);
}
?>