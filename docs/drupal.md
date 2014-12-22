# Snelle instructies

1. Download de speciale [Drupal Varnish module voor Byte](https://raw.githubusercontent.com/ByteInternet/byte-cluster-varnish/master/drupal/byte_purge.zip)
2. Pak de bestanden uit naar ```sites/all/modules/contrib```
3. Ga naar de backend van je Drupal site en dan naar Administer \> Modules
4. Activeer. Klaar! Problemen? Lees verder.

# Achtergrond 

Het Byte SpeedCluster is out of the box al geschikt voor Drupal. Varnish neemt de 
instellingen over zoals die op zijn gegeven op de performance pagina van Drupal: ```http://<url van je site>/admin/config/development/performance```

De pagina’s worden bij het opvragen in de cache opgenomen en gedurende de 
tijd die is ingesteld voor volgende verzoeken van uit de cache geserveerd aan de 
gebruiker.

In de praktijk wil je echter soms dat een pagina niet pas na het verstrijken van de 
levensduur in de cache opnieuw wordt opgehaald, maar actief een nieuwe versie 
aanbieden. Bijvoorbeeld zodra er nieuwe content verschijnt (of blokken of views 
vernieuwd zijn). Dit kan door de betreffende data in de cache te ‘purgen’. Bij het 
eerst volgende verzoek wordt de data niet uit Varnish maar op de normale 
manier opgehaald van het cluster en vervolgens opnieuw in de cache 
opgenomen. 

Er zijn voor Drupal diverse modules beschikbaar die het purgen van Varnish 
caches kunnen verzorgen. De eerste module waar je bij uitkomt heet niet 
verrassend [Varnish](https://www.drupal.org/project/varnish).

Deze module communiceert via een aparte socket direct met Varnish, maar dit is 
bij Byte vanwege de cluster-setup niet mogelijk. In de setup bij Byte moet via 
http met Varnish worden gecommuniceerd. Deze module kan je dus niet 
gebruiken.

De bestaande module [Purge](https://www.drupal.org/project/purge) lijkt vervolgens een goed alternatief, maar ook deze module werkt niet lekker 
samen met de omgeving bij Byte, omdat:

1. Purge [requests sturen over https niet lukt](http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/)
2. Het standaard niet mogelijk is om gelijktijdig een pagina te purgen van zowel de https en http cache. Er is daarom een variant van deze module ontwikkeld, die genoemde problemen ondervangt. Deze module heet Byte Purge en is te downloaden via https://www.drupal.org/sandbox/jeroensurft/2383697 

# Stappenplan

**1. Code clonen**

Clone de module naar de map byte_purge met:

```bash
git clone --branch 7.x-1.x http://git.drupal.org/sandbox/Jeroensurft/2383697.git byte_purge
```

**2. Installatie en configuratie**

Je installeert de module op de gebruikelijke manier voor je site. De configuratie 
van Varnish doe je via ```http://<url van je site>/admin/config/development/performance```

Dit is de normale Drupal performance pagina. De Byte Purge module is zo 
gemaakt dat de bestaande cache-instellingen transparant worden doorgegeven 
aan de browser.

Om aan te kunnen geven hoelang de cache in Varnish geldig is, is aan deze pagina 
een dropdown ‘Varnish expiration’ toegevoegd. 

**3. Purgen configureren**

Zoals gezegd, is de Byte Purge module er omdat Drupal zo een manier heeft om 
aan Varnish door te geven dat er gepurged moet worden. Er moet echter ook nog 
bepaald worden wát er gepurged moet worden. Dit is eenvoudig in te stellen via 
de bestaande module [Expire](https://www.drupal.org/project/expire).

Ook kan je met de module [Rules](https://www.drupal.org/project/rules) eigen regels maken, om nog meer op maat de 
cache te purgen, bijvoorbeeld periodiek.

# Tweaks

#### Nog meer speed

In bepaalde gevallen (zie toelichting bij Achtergrond) worden pagina’s voor 
gebruikers die een cookie hebben voor iedere gebruiker apart gecached. Om de 
efficiëntie van de caching te verhogen kan dan het wenselijk zijn om de instelling 
‘omit_vary_cookie’ te gebruiken. Hiermee wordt aangegeven dat dezelfde cache 
gebruikt kan worden voor al deze gebruikers.
 
Dit is te activeren door in settings.php op nemen:
```php
$conf['omit_vary_cookie'] = TRUE;
```

Nota bene: zodra een gebruiker inlogt en dus een sessie cookie krijgt, wordt de 
Varnish cache sowieso overgeslagen.

#### Alle cache clearen

De module Byte Purge voorziet met opzet niet in het purgen van de volledige 
cache als je in Drupal op de gebruikelijke manier kiest voor ‘Alle caches legen’. 
Bij een site waar Varnish in gebruik is, is het niet ondenkbaar dat dit behoorlijke 
gevolgen voor de performance kan hebben. 

Wil je niettemin toch in één keer de Varnish cache in zijn geheel legen, dan kan 
dit door een Drupal rule aan deze actie te koppelen en dan /* op te geven voor de 
urls die gepurged moeten worden. Overigens komt deze functionaliteit ook via 
het Byte servicepaneel beschikbaar.

# Achtergrond

#### Vary

Met de “Vary” response header kan je er voor zorgen dat reverse proxies (zoals 
Varnish) meerdere variaties van een pagina bijhouden.

Standaard staat in de Vary header “Accept-Encoding”. Dit is noodzakelijk, want 
de browser stuurt dan mee welke encodings worden ondersteund. Gevolg is dat 
Varnish nu voor elke type encoding een aparte cache bijhoudt. Dit is gewenst, 
want je wilt niet dat de browser een response krijgt met een encoding die hij niet 
ondersteunt.

Dit werkt net zo als “Cookie” in de Vary header zit; Varnish gaat dan voor elke 
mogelijke inhoud van een Cookie een aparte cache bijhouden. Met als gevolg dat 
hierdoor de cache hit rate omlaag gaat, terwijl dit eigenlijk niet nodig is. Met 
‘omit_vary_cookie’ in settings.php voorkom je dan dit gedrag.

#### Browser caching

Je vraagt je wellicht af, waarom er in afwijking van de bestaande Purge module, 
een aparte instelling is voor de Varnish expiration bij de Byte Purge module. 

Normaal worden pagina’s die voor een bepaalde tijd gecached mogen worden in 
feite in je webbrowser gecached. Varnish geeft standaard de cache control 
headers door aan de browser, wat betekent dat als je geen maatregelen neemt, 
pagina’s dus ook in je browser gecached kunnen worden.

Soms is dit ongewenst, bijvoorbeeld in de situatie waarbij als je inlogt, er nog 
niet-ingelogde varianten van pagina’s in je browserchache zitten. Je zou de 
caching in Drupal uit kunnen zetten, maar dan stuurt Drupal een cache-control: 
no-cache header mee. Dit draait er vervolgens op uit dat er niets meer in Varnish 
wordt gecached. Dat is dus ook niet de bedoeling.

De oplossing om tóch controle te blijven houden over de cache-instellingen die 
aan de browser worden doorgegeven, is dus gevonden in een aparte instelling 
voor Varnish. Technisch is dit opgelost door Varnish in te stellen via de 
parameter ’s-maxage', die prioriteit heeft boven de standaard max-age 
parameter.

#### Known issue

In theorie zou je de browser cache op 0 kunnen zetten en Varnish op 1 dag. Maar 
helaas dit [werkt niet (altijd) zoals verwacht](http://stackoverflow.com/questions/1046966/whats-the-difference-between-cache-control-max-age-0-and-no-cache). 
Dit kan je oplossen door de cache-control header via .htaccess te overschijven 
door ‘no-cache’ door te geven. Als je hier dan handmatig een s-maxage aan 
toevoegt dan zal Varnish deze waarde nemen voor de cache.

#### Tot slot

Voor meer informatie over Varnish en achtergrondinformatie zie:

https://www.varnish-software.com/static/book/VCL_Basics.html#the-initial-
value-of-beresp-ttl

http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html

December 2014, in samenwerking met www.mediagrip.nl
