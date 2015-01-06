# Aan de slag

Nog even en je site is sneller dan 99% van het internet. Dat voelt goed, toch? Om daar te komen, moet je een paar dingen doen. 

## Stap 1: Leer hoe het werkt

Varnish zit tussen jouw website en je bezoeker. Varnish bewaart content in een cache en kan deze tot 100x sneller naar je bezoekers sturen.

Dat klinkt mooi! Maar let op, er zit natuurlijk een addertje onder het gras. Niet alle content is geschikt om gecached te worden, zoals bijvoorbeeld gepersonaliseerde of geheime pagina's. In veel gevallen wordt dit door het Byte Varnish Cluster juist gedetecteerd. In sommige gevallen moet je zelf extra instructies geven. We raden dus altijd aan om eerst goed te testen voordat je Varnish activeert!

Om aan de slag te gaan met Varnish, is het erg handig om de HTTP headers te kunnen inzien. Het makkelijkst is om Chrome te gebruiken, dan de Developer Tools te activeren (```F12``` op Windows, ```Cmd+Opt+i``` op Mac). Klik op tabblad ```Network```. Refresh (```F5```) je site. Klik op het eerste request. Klik rechts op mini-tabblad ```Headers```. Hier zie je wat er heen en weer wordt gestuurd tussen jouw browser en de server. [Meer weten over HTTP headers](http://www.mobify.com/blog/beginners-guide-to-http-cache-headers/)?

## Stap 2: Controleer geschiktheid

### Cache headers
Controleer of je site uberhaupt geschikt is voor caching. In de headers die de server terugstuurt (zie hierboven) mag *niet* ```Cache-control: no-cache``` of ```Cache-control: private``` voorkomen. Gebeurt dit wel, dan is er een aantal mogelijke oorzaken:

1. Je bent ingelogd op de backend van je site en daardoor kan er niet gecached worden. Probeer het opnieuw, maar dan zonder cookies (gebruik een "Incognito" venster met Ctrl-Shift-N). Immers, de meeste bezoekers van je site zullen _niet_ ingelogd zijn.
2. Een externe module van je site gebruikt ```session_start()``` van PHP. Deze genereert sowieso een ```Cache-control: no-cache``` header. Oplossing: verwijder de module, pas de module aan, of installeer een extra module die de Cache-control header weer (dynamisch) verwijdert. Voor Joomla is sowieso een extra module vereist, zie de instructies verderop.
3. Er is een ```.htaccess``` geinstalleerd die een extra header genereert. Kijk of je deze kunt omschrijven.

### Content-Encoding
Omdat Varnish tussen de webservers en de bezoeker staat is het niet wenselijk dat de webservers alle content gzippen, dit is alleen nuttig tussen Varnish en de bezoeker van de site. Daarnaast zal het gzippen van content in sommige gevallen tot foutmeldingen van Varnish leiden.

Zorg dat ```zlib.output_compression``` uitgeschakeld staat op het servicepanel.

1. Ga naar ons Servicepanel op https://servicepanel.byte.nl
2. Klik op de tab Instellingen. Klik op de knop PHP.
3. Zet ```zlib.output_compression``` op 'default' of 'off'.
4. Klik op 'Instellingen opslaan'.

## Stap 3: Installeer benodigde software

De meeste webapplicaties hebben een extra module nodig om correct te kunnen werken. Die zorgt voor twee dingen: allereerst dat de geproduceerde pagina's worden aangemerkt als geschikt voor caching. En ten tweede, dat wanneer de content wijzigt (bijvoorbeeld in de backend) ook de bijbehorende cache-versie wordt bijgewerkt.

We hebben hier instructies voor de meest gebruikte webapplicaties verzameld: [Wordpress](wordpress.md), [Drupal](drupal.md) en [Joomla](joomla.md). Als je meer exotische software gebruikt, zul je zelf op zoek moeten naar een Varnish module, of er zelf een maken. Zie hiervoor onze [maatwerk instructies](custom.md).

## Stap 4: Test de nieuwe software

Wanneer je site op een Byte Varnish Cluster staat, kun je eenvoudig de werking van Varnish testen, zonder dat je wijzigingen direct voor de hele wereld hoeft door te voeren. Hiervoor heb je nodig: het **test IP**, te vinden op het Service Panel. Op het test IP is altijd Varnish actief (in de door jou gekozen modus, zie hieronder). 

Je kunt zorgen dat je eigen browser de DNS negeert en het test IP gebruikt, met behulp van [een lokaal hosts bestand](https://www.byte.nl/wiki/DNS#DNS_Caching).

Gaat er iets mis met de test? Zie [Maatwerk > hoe te debuggen](custom.md#debuggen) voor hulp.

## Stap 5: Activeer Varnish en laat je concurrenten ver achter je

Op het Byte Service Panel kun je uit vier modi kiezen:

1. Cache niets (alle cache staat uit)
1. Cache enkel static assets (plaatjes, css)
1. Cache dynamisch, geoptimaliseerd voor Joomla/Wordpress/Drupal en maatwerk CMSen
1. Cache alles aggressief (in high traffic/load situaties waarbij men niet in de cms backend hoeft) dus negeer alle cookies, expires en cache headers.

De makkelijke modus is de tweede, hiervoor hoef je normaliter niets te wijzigen.

De modus met het beste resultaat is de derde.

 
