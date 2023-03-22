Statystyka IMPERATOR STATS

(C)2000-2004 by
    Autor:       Adam "Logic" Sobocinski <logic@anubisdev.com>
    Wspó³praca:  Piotr "GeoS" aka "Gajcy" Galas <geos@anubisdev.com>
                 Micha³ "MD5" Bundyra <md5@pf.pl>

Strona domowa:   http://www.anubisdev.com

----------------------------

Spis tre¶ci:

1. Licencja
2. Instalacja
3. Upgrade
4. Sprawy techniczne
5. Konfiguracja
6. Znane problemy
7. FAQ

1. Licencja
----------------------------
Program w wersji 5 ma status freeware.
Statystykê mozesz rozpowszechniaæ, pod warunkiem nie pobierania za nia
¿adnych op³at. Mo¿esz jej uzywaæ za darmo (tylko na stronach niekomercyjnych)
pod warunkiem, ¿e tresc jest zgodna z polskim prawem oraz po
bezplatnej rejestracji na stronie domowej: www.anubisdev.com
Autor nie bierze odpowiedzialnosci za jakiekolwiek szkody wynikle
z uzytkowania programu.

Uwaga!
Aby legalnie korzystac ze statystyk ,nie wolno usuwaæ logo statystyki,
które pojawi siê po instalacji na stronie w miejscu wywolania skryptu.



2. Instalacja
--------------
Aby zainstalowac statystykê musisz skopiowaæ j¹ do katalogu "istats5".
w systemach unixowych (linux, unix, BSD) nalezy ustawic
prawa do zapisu serwerowi WWW, lub ustawic je na chmod 777.
Dla katalogu logs takze ustawiamy prawa na 777.

Nastêpnie wejœc do konfiguracji
http://adres_www_do_statystyk/istats5/index.php?p=admin
i ustawic scie¿kê do statystyk. Skopiowac kod który siê
tam znajduje i wkleic do strony.

W miejscu dolaczenia statystyki pojawi siê logo, poprzez które mo¿na wejœæ
do statystyk. Strona na której bêdzie umieszczona statystyka musi miec
rozszerzenie .php  .php3  .phtml  lub inne rozpoznawane na serwerze
jako plik PHP.

Przed pierwszym uruchomieniem, nalezy ustawic adres www, prowadzacy do statystyk.
Mozna to zrobic w pliku conf.php, lub poprzez panel administracyjny.
Panel administracyjny wywolujemy, wpisujac adres

http://adres_www_do_statystyk/istats5/index.php?p=admin

Jeœli chcesz zliczaæ pojedyñcze podstrony serwisu wystarczy, ¿e w³¹czysz opcjê
"zliczaj podstrony" w panelu administracyjnym, a nastêpnie umieœcisz kod
na ka¿dej podstronie która ma byæ zliczana.


3. Upgrade
-------------------

Nie ma mozliwosci zrobic upgrade z wersji 4 lub nizej, poniewaz system logow
w nowej wersji jest niekompatybilny ze starszymi. Zmiany te byly konieczne
aby podniesc niezawodonosc programu.

4. Konfiguracja
-------------------
Konfigurowaæ statystykê, mo¿na na dwa sposoby. Poprzez panel
administracyjny (zalecany), lub poprzez edycjê pliku conf.php.

Statystyka posiada dwa poziomy zabezpieczenia, dla których ustawia
siê oddzielnie has³a.
Pierwszy poziom - dostêp tylko do prezentacji
Poziom drugi    - dostêp do prezentacji i administracji statystyki
Jeœli pozostawisz te pola puste, statystyka bêdzie dostêpna dla wszystkich.

Przy opcji "Lista IP do wykluczenia (rozdzielone ";")", jest mozliwosc
wpisania listy numerow IP, ktore maja zostac wylaczone ze zliczania.
Jesli wiec mam numer IP 127.0.0.1, wpisanie tego numeru w konfiguracje,
spowoduje, ze nasz wejscia nie beda zliczane.
Jest mozliwosc wylaczenia calej klasy za pomoca gwizdki *.
Np. 127.0.0.* - wszystkie adresy z zakresy 127.0.0.1 - 127.0.0.254 beda
wylaczone ze zliczania.


5. Sprawy techniczne
--------------------
Dzia³anie skryptu opiera siê na funkcjach PHP, JavaScript i cookies.
Operuje na plikach tekstowych, czyli nie potrzebuje ¿adnych baz danych.

Wersja 5 i wyzsze korzystaja z nowego unikalnego systemu zapisu logow,
dzieki temu pozwala to na bardziej wydajne dzialanie programu.

W sk³ad statystyki wchodz± nastêpuj±ce pliki:

stat.php     - g³ówny kod statystyki
rstat.php    - dodatkowy modu³ do zliczania rodzielczo¶ci i bitów kolorów
pages.php    - dodatkowy modu³ do zliczania wej¶æ na poszczególne podstrony
conf.php     - plik z danymi do konfiguracji statystyki
index.php    - skrypt do prezentacji wyników statystyki
winday.php   - wy¶wietla informacje o odwiedzinach z podanego miesi±ca
login.php    - skrypt do logowania

statclass.php  - g³ówna klasa statystyki
common.php     - funkcje wykorzystywane w obu warstwach (zapisu i prezentacji)
lang.inc.php - lista krajów
ogolne.inc.php - informacje kiedy i ile ;-)
hosts.inc.php  - z jakiego hosta i kraju
tech.inc.php   - techniczne informacje o odwiedzaj±cych
pages.inc.php  - zapisuje odwiedzane podstrony
seach.inc.php  - adresy referuj±ce, wyszukiwarki i s³owa kluczowe
last.inc.php   - wy¶wietla listê ostanich wej¶æ
kraj.inc.php   - wy¶wietla listê krajów
admin.inc.php  - konfiguracjia statystyki

get_search.php    - modu³ identyfik±j±cy wyszukiwarki i s³owa kluczowe wpisane do nich
get_os.php        - modu³ identyfikuj±cy system operacyjny
get_browser.php   - modu³ identyfikuj±cy przegl±darkê

img/           - pliki graficzne
doc/           - dokumentacja
logs/          - logi


Jesli znajdziesz blad w dzia³aniu lub masz pomys³ co dodaæ do
tej statystyki napisz e-mail : logic@stone.pl


6. Znane problemy
-----------------

Jesli z jakiego powodu statystyka nie dziala poprawnie, sprawdz
nastepujace rzeczy:

- gdy statystyka nie utworzyla katalogu "logs"
  zmien prawa katalogu istats5 na chmod 777;

- gdy statystyka nie zapisuje wejsc, pomimo utworzenia katalogu "logs",
  prawdopodobnie nieprawidlowo zosta³a zainstalowana statystyka,
  w tym przypadku usun ca³y katalog, program powinien ponownie stworzyc
  katalog, oraz wymagane w nim pliki;

- nie wyswietla sie logo statystyki i/lib nie zlicza wejsc,
  w tym przypadku sprawdz konfiguracje, w zmiennej $istat['base_path'],
  powinna znajdowac sie bierzaca sciezka do statystyk;

- nie zlicza mi kolorow i rozdzielczosci w dziale "techniczne",
  prawdopodobnie nie jest ustawiona, lub jest ustawiona nieprawidlowo
  sciezka (url) do statystyk. Ustawic ja mozna w pliku conf.php za
  pomoca dowolnego edytora tekstowego, lub poprzez panel administracyjny
  na stronie www;


7. FAQ
--------------

1. Pytanie:
Czy mogê u¿ywaæ statystyki na stronie komercyjnej?

Odpowiedz:
Statystyka przeznaczona jest dla serwisów osób prywatnych, wiêc
zabronione jest umieszczanie iStats na komercyjnych stronach.
Dla stron komercyjnych przeznaczony jest AnubisStat dostêpny
pod adresem www.anubisdev.com

2. Pytanie:
Chcia³bym zmieniæ logo, poniewa¿ to które jest nie pasuje mi do strony,
czy jest to mo¿liwe?


Odpowiedz:
Jesli czujesz siê na si³ach zrobiæ ³adne logo statystyki na swoja stronê, zrób to.
Ale poinformuj mnie o tym wysy³ajac maila na adres logic@anubisdev.com


3. Pytanie
Tam gdzie umieszczam kod statystyki, dostaje komunikat lub podobny:
Warning: session_start(): Cannot send session cookie - headers already sent by
(output started at /home/www/index.php:3) in /home/www/istats5/stat.php on line 7

Odpowiedz:
Problem spowodowany jest przez korzystanie z sesji. Poniewaz metoda wstawienia
statystyk do strony poprzez polecenie "include" nie dzia³a poprawanie na
wielu stronach, zrezygnowaliœmy ze wsparcia dla tej metody.
Aby statystyka dzia³a poprawnie na stronie, nale¿y wstawic kod:

<!-- start istats code -->
<script language="javascript">
<!--
var ipath='server/istats5';
document.write('<SCR' + 'IPT LANGUAGE="JavaScript" SRC="http://'+ ipath +'/istats.js"><\/SCR' + 'IPT>');
//-->
</script>
<!-- end istats code -->

Gdzie "server" to adres www serwera, na jakim zainstalowana jest statystyka


Jesli masz jakies pytania napisz: e-mail : logic@anubisdev.com


--------------------------------------------------------------------
   <END>
