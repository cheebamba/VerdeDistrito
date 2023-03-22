function i_url() {
  var dt = new Date(),
      u = new String();
      s = window.screen;
      u += 'ts='+dt.getTime();
      if(window.screen) u += '&scr='+s.width+'x'+s.height+'&colorbit='+s.colorDepth;
      if ((navigator.plugins && navigator.plugins['Shockwave Flash']) || (navigator.appName.indexOf('Microsoft') != -1 &&
          navigator.appVersion.indexOf('Mac') == -1 && navigator.appVersion.indexOf('3.1') == -1)) var f=1;
      if(navigator.javaEnabled()) var j=1;
      u += '&f='+f+'&j='+j;
      if(document.all || document.layers) u += '&java='+navigator.javaEnabled();
      return u;
}
document.write('<a href="http://www.sciema.czuby.net/VerdeDistrito/modules/statystyki/index.php" target="_blank"><img src="http://'+ ipath +'/stat.php?ref=1&idref=' + escape(document.referrer) + '&'+ i_url() + '" border=0></a>')

