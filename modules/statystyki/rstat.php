<?
if(isset($_GET['scr'])) {
       $stat = 'logs/stat.isl';
       $fid = fopen($stat, 'r+');
       while (!flock($fid, 2+4));
       $buf = fgetcsv($fid, 1024, ',');       // pobierz dane z pliku stat.isl

       switch($_GET['scr']) {
              case '640x480'  : $buf[1]++; break;
              case '800x600'  : $buf[2]++; break;
              case '1024x768' : $buf[3]++; break;
              case '1152x864' : $buf[4]++; break;
              case '1280x1024': $buf[5]++; break;
              default: $buf[6]++; break;
       }
       switch($_GET['colorbit']) {
              case '4' : $buf[7]++; break;
              case '8' : $buf[8]++; break;
              case '16': $buf[9]++; break;
              case '24': $buf[10]++; break;
              case '32': $buf[11]++; break;
              default: $buf[12]++; break;
       }

       switch($_GET['f']) {
              case '1' : $buf[48]++; break;
              default: $buf[49]++; break;
       }

       switch($_GET['j']) {
              case '1' : $buf[50]++; break;
              default: $buf[51]++; break;
       }

       $buffer = implode(',', $buf);
       rewind($fid);
       fwrite($fid, chop($buffer));
       flock($fid, 3);
       fclose($fid);
}

?>
