<?
class statclass{

   var $dane;
   var $block;
   var $log_data;

    function statclass($path)
    {


         $this->dane['time'] = time();              // aktualny czas

         $this->dane['rok'] = date('Y');
         $this->dane['miesiac'] = date('n');
         $this->dane['dzien'] = date('j');
         $this->dane['fday'] = date('z')+1;       // liczba dni od poczatku roku
         $this->dane['godzina'] = date('G');
         $this->dane['tydzien'] = date('w');       // dzien tygodnia
         $this->dane['referer'] = '';
         $this->dane['page'] = '';
         $this->dane['agent'] = $_SERVER['HTTP_USER_AGENT'];
         $this->dane['ip'] = $_SERVER['REMOTE_ADDR'];
         $this->dane['host'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);

         if(isset($_GET['idref']))
         {
              $referer = explode('?', $_GET['idref']);
              $this->dane['referer'] = $referer[0];
         }

         // ustawienie sciezek do poszczegolnych plików
         $this->log_data['dir_logs'] = $path.'/logs';
         $this->log_data['stat'] = $path.'/logs/stat.isl';
         $this->log_data['browser'] = $path.'/logs/browser.isl';
         $this->log_data['os'] = $path.'/logs/os.isl';
         $this->log_data['host'] = $path.'/logs/host.isl';
         $this->log_data['referer'] = $path.'/logs/referer.isl';
         $this->log_data['last'] = $path.'/logs/last.isl';
         $this->log_data['lang'] = $path.'/logs/lang.isl';
         $this->log_data['keyword'] = $path.'/logs/keyword.isl';
         $this->log_data['domena'] = $path.'/logs/domena.isl';
         $this->log_data['search'] = $path.'/logs/search.isl';
         $this->log_data['pages'] = $path.'/logs/pages.isl';
         $this->log_data['raport'] = $path.'/logs/raport.isl';

         $rok=date("Y");

          // tworzenie sciezek do plikow miesiecy aktualnego roku
          for($n=1; $n<=12; $n++) {
                   $this->log_data['hits'][$n] = $path.'/logs/'.$rok.'/'.$n.'.php';
                   $this->log_data['calls'][$n] = $path.'/logs/'.$rok.'/'.$n.'_.php';
          }


         //$this->dane['ip'] = $this->GetIP();  // pobranie adresu ip

         if(!is_dir($path.'/logs') OR !file_exists($this->log_data['stat'])) $this->CreateLogFiles();  // utworzenie logow
         if(!is_dir($path.'/logs/'.$rok)) $this->CreateYearLogs();
    }



    // tworzenie podanego pliku, i ustawienie mu prawa
    function createfile($filename)
    {

                         if(filename=='')
             {
                     echo  'ERROR: Nie podano nazwy pliku. Zg³o¶ b³±d';
                exit;
             }

             if(!touch($filename))
             {
                     echo 'ERROR: Nie moge utworzyc pliku '.$filename.'. Sprawd¼ uprawnienia katalogu "logs"';
                exit;
             }

             chmod($filename, 0666);

    }



     // Tworzenie plikow do zapisu logow
     function CreateLogFiles()
     {
            if(!is_dir($this->log_data['dir_logs']))
            {
                    $old=umask(0);
                    $i_err=@mkdir($this->log_data['dir_logs'],0777);
                    if(!$i_err) { echo 'Error 004 - Can not create <b>'.$this->log_data['dir_logs'].'</b> folder'; exit; }
                    umask($old);
            }

             if(!file_exists($this->log_data['stat']))
             {
                      // utwórz szkielet pliku stat.isl
                      $fid = @fopen($this->log_data['stat'], 'w');
                      if(!$fid)
                      {
                        echo 'ERROR: Brak uprawnieñ do zapisu dla katalogu'.$this->log_data['dir_logs'];
                        exit;
                      }
                      flock($fid, 2);
                      for($n=0; $n<51; $n++) fwrite($fid, '0,');
                      fwrite($fid, '0');
                      flock($fid, 3);
                      fclose($fid);
                      chmod($this->log_data['stat'], 0666);
              }

              if(!file_exists($this->log_data['browser'])) $this->createfile($this->log_data['browser']);
              if(!file_exists($this->log_data['os'])) $this->createfile($this->log_data['os']);
              if(!file_exists($this->log_data['host'])) $this->createfile($this->log_data['host']);
              if(!file_exists($this->log_data['referer'])) $this->createfile($this->log_data['referer']);
              if(!file_exists($this->log_data['last'])) $this->createfile($this->log_data['last']);
              if(!file_exists($this->log_data['lang'])) $this->createfile($this->log_data['lang']);
              if(!file_exists($this->log_data['keyword'])) $this->createfile($this->log_data['keyword']);
              if(!file_exists($this->log_data['search'])) $this->createfile($this->log_data['search']);
              if(!file_exists($this->log_data['domena'])) $this->createfile($this->log_data['domena']);
              if(!file_exists($this->log_data['pages'])) $this->createfile($this->log_data['pages']);
              if(!file_exists($this->log_data['raport'])) $this->createfile($this->log_data['raport']);

     }




     /**************************************************************************
     * tworzenie plikow do zapisu danych z podzialem na miesiac, dni, godziny
     * rok - katalog, miesiac - pliki
     * dni i godziny - w plikach miesiecznych
     */
     function CreateYearLogs()
     {
              $rok = date('Y');
              $miesiac = date('m');

              $old = umask(000);
              if(!@mkdir($this->log_data['dir_logs'].'/'.$rok, 0777))
              {
                      echo '<font color=red>ERROR: Nie mo¿na utworzyæ katalogu <b>'.($this->log_data['dir_logs'].'/'.$rok).'</b>.<br><br></font> Sprawd¼ uprawnienia do katalogu "logs". Katalog ten powienien mieæ chmod 666';
                exit;
              }

              umask($old);

              $nrmonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);              // tablica dni w poszczegolnych miesiacach
              if(date('L') == 1) $nrmonth[1] = 29;                                          // jesli rok przestepny zmien liczbe dni w lutym

              // utwórz szkielet pliku hitów
              for($n=1; $n<=12; $n++) {
                     if(!file_exists($this->log_data['hits'][$n])) {
                            $fid = fopen($this->log_data['hits'][$n], 'w');
                            flock($fid, 2);
                            for($x=0; $x<$nrmonth[$n-1]; $x++) fwrite($fid, '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'."\n");
                            flock($fid, 3);
                            fclose($fid);
                            chmod($this->log_data['hits'][$n], 0666);
                     }
                     if(!file_exists($this->log_data['calls'][$n])) {
                            $fid = fopen($this->log_data['calls'][$n], 'w');
                            flock($fid, 2);
                            for($x=0; $x<$nrmonth[$n-1]; $x++) fwrite($fid, '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'."\n");
                            flock($fid, 3);
                            fclose($fid);
                            chmod($this->log_data['calls'][$n], 0666);
                     }
              }
    }



    /*******************************************************
    *  Zapisuje logi z podzialem na daty
    *****/
    function SetVisits($file)
    {
         // tablica dni wposzczegolnych miesiacach
         $nrmonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
         if(date('L') == 1) $nrmonth[1] = 29;      // jesli rok przestepny zmien liczbe dni w lutym
         $m = date('n');
         $fid=fopen($file[$m],'r+');
         while (!flock($fid,2+4));
         $nday=explode("\n",fread($fid,filesize($file[$m])));
         rewind($fid);
         $ile_dni = count($nday)-1;
         $hour_visit = explode(',', $nday[($this->dane['dzien']-1)]);      // utworz tablice dni ze stringa
         settype($hour_visit[$this->dane['godzina']], 'integer');          // zmien typ danych na liczbowe
         $hour_visit[$this->dane['godzina']]++;                            // zwieksz liczbe odwiedzin o odpowiedniej godzinie
         $hour_visit[24] = $this->dane['tydzien'];                         // zapisz dzien tygodnia
         $nday[($this->dane['dzien']-1)] = implode(',', $hour_visit);      // zloz tablice godzin do stringa
         for($x=0; $x<$ile_dni; $x++) fwrite($fid, $nday[$x]."\n");
         flock($fid, 3);
         fclose($fid);
    }



    /*******************************************************
    *  Pobiera adres IP, i przetwarza go
    *****/
    function GetIP()
    {
        if(isset($_SERVER['HTTP_CLIENT_IP']) &&
        !eregi('^(10.|192.168|(172\.((1[6-9])|(2[0-9])|(3[0-1]))\.))',$_SERVER['HTTP_CLIENT_IP']))
        {
                $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) &&
        !eregi('^(10.|192.168|(172\.((1[6-9])|(2[0-9])|(3[0-1]))\.))',$_SERVER['HTTP_X_FORWARDED_FOR']))
        {
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
                $ip = $_SERVER['REMOTE_ADDR'];
        }

       $dane['ip'] = $ip;
       $dane['proxy'] = '';

       // jezeli dwa numery IP
       if(eregi(',', $ip))
       {
              $ip = eregi_replace(' ', '', $ip);       // to je rozdziel
              $ips = explode(',', $ip);
              $dane['proxy'] = $ips[0];                                          // i wsadz do tablicy
              $dane['ip'] = $ips[1];                                                 // w osobne pola
       }

       $this->dane=$dane;
       return $dane;

    }


    /*******************************************************
    * zapis podanych danych do pliku
    * filename = nazwa pliku do ktorego ma zasotac zapisane
    * id_name  = dane do zapisu
    */

    function isave($filename, $id_name)
    {
           $id_name=trim($id_name);
           if(empty($id_name)) return;
           $flag = 1;
           $fid=fopen($filename,"r+");
           while(!flock($fid, 2+4));
           $lines=explode("\n",fread($fid,filesize($filename)));
           $ile_linii = count($lines)-1;
           $data=time();

        //echo strftime("%Y-%m-%d %H:%M ",$data);

           for($n=0; $n<$ile_linii; $n++)
           {
                     if(ereg($id_name, $lines[$n]))
                     {

                            $tmp = explode('|', $lines[$n]);
                            $tmp[0]++;
                            $tmp[2]=$data;
                            $lines[$n] = implode('|', $tmp);
                            $flag = 0;
                            break;
                     }
           }


          if($flag == 1) // dodaj nowe
          {
                 if(!empty($id_name)) fwrite($fid, '1|'.$id_name.'|'.$data."\n");
          }
          else
          {
                 rewind($fid);
                 $lines=implode("\n",$lines);
                 fwrite($fid, $lines);
                 $lines=null;
          }
          flock($fid, 3);
          fclose($fid);
          return $flag;
     }

     /********************************************************
        $flaga = 0 calls
        $flaga = 1 hits
     ********************************************************/
     function CountHits($flaga=0)
     {
            $fid = fopen($this->log_data['stat'], 'r+');
            while(!flock($fid, 2+4));
            $buf = fgetcsv($fid, 1024, ',');       // pobierz dane z pliku stat.isl
            if($flaga == 0) $buf[46]++;            // zwiêksz liczbe ods³on

            if($flaga == 1)
            {
                   $buf[0]++;                            // zwieksz ogólna liczbe odwiedzin
                   $buf[13+$this->dane['godzina']]++;       // zwieksz najczêsciej w godzinach
                   $buf[37+$this->dane['tydzien']]++;       // zwieksz najczêsciej w dniach tygodnia
            }

            $dane = implode(',', $buf);
            $buf = NULL;
            rewind($fid);
            fwrite($fid, $dane);
            flock($fid, 3);
            fclose($fid);
     }


     /*******************************
     * cut domain from host
     */
     function GetDomain()
     {
            $host=$this->dane['host'];
            $dane = explode('.', $host);
            if(!is_numeric(end($dane)) && $host != 'localhost')
            {
                   $ile = count($dane);
                   if(eregi('/', $dane[$ile-1])) eregi_replace('/', '', $dane[$ile-1]);
                   $domena = $dane[$ile-2].'.'.$dane[$ile-1];
                   $this->isave($this->log_data['domena'], $domena);
            }
            else return false;
     }


     /*******************************
     * detect country and save to file
     */
     function GetCountry()
     {
          $dd=explode(".",$this->dane['host']);
          if(!is_numeric($dd[0]))
          {

                 $lang = substr(strrchr($this->dane['host'], '.'), 1);
                 if(!empty($lang)) $this->isave($this->log_data['lang'], strtolower($lang));
          }
     }


       /******************************************************
       *  last visit saving
       *       input:  STRING - search engine address
       *       output: - $visits- number hits from IP
       *                 $last_visit= last date of visit
       */
       function LastVisit()
       {
              $last = $this->log_data['last'];

                  $fid=fopen($this->log_data['host'],"r");
                  $linesy=explode("\n",fread($fid,filesize($this->log_data['host'])));
                  $ile_linii = count($linesy)-1;
              $last_data=0;
                  for($nq=0; $nq<$ile_linii; $nq++)
                  {
                             if(ereg($this->dane['host'], $linesy[$nq]))
                          {
                          $tmp = explode('|', $linesy[$nq]);
                              if($tmp[0]>1) $last_data = $tmp[2];
                              break;
                       }
              }
              fclose($fid);

              $lines = file($last);
              $num = count($lines);
              if($num > 500) $num = 500;                            // zabezpieczenie przed zbyt du¿ym plikiem
              $fid = fopen($last, 'w');



              while(!flock($fid, 2+4));
              fwrite($fid, session_id().'::'.time().'::'.$this->dane['host'].'::'.$this->dane['referer'].'::'.$this->dane['os'].'::'.$this->dane['browser'].'::'.$this->dane['page'].'::'.$last_data."\n");
              for($n=0; $n<$num; $n++) fwrite($fid, $lines[$n]);
              flock($fid, 3);
              fclose($fid);
       }


       function GetPages($pages)
       {

            $tab=parse_url($pages);
            $url_pages=$tab['path'];

            if($url_pages == '') $url_pages = $rmsg['raport']['main'];
            $this->dane['page']=$url_pages;
            $this->isave($this->log_data['pages'], $url_pages);
       }



       /******************************************************
         referer saving
              input:  STRING - refferer address
       *******************************************************/
       function GetReferer($referer)
       {
            if(empty($referer)) return;       // jesli adres referujacy jest pusty
            //if(ereg($_SERVER['SERVER_NAME']==$referer))  return;
            $tab=parse_url($referer);
            $url_pages=$tab['path'];

            if($referer==$url_pages) return;

           $this->dane['referer']=$referer;

              if($referer != '-') $this->isave($this->log_data['referer'], $referer);
       }


       function i_microtime()
       {
               list($usec, $sec) = explode(' ', microtime());
               return((float)$usec+(float)$sec);
       }

}

?>
