# Maatwerk

Je kunt ook gebruik maken van Varnish Cluster indien je een andere software gebruikt dan hier beschreven. Daarvoor is wel enig handwerk vereist. Op deze pagina vind je een concreet stappenplan, plus achtergrondinformatie om eventuele problemen op te kunnen lossen.

De volgende definities worden gebruikt:

> Applicatie = PHP script op de server

> Client = Browser 

## Wanneer wordt er gecached 

Er wordt niet gecached in de volgende gevallen:

- POST requests
- Basic authorization (bijv met behulp van .htaccess)
- Bestanden die i.h.a. erg groot zijn en daardoor weinig profijt hebben van caching (msi, exe, dmg, zip, tgz, gz, mp3, flv, mov, mp4, mpg, mpeg, avi, dmg, mkv, zip, rar, tar, gz, tar.gz, tar.bz2, flv).
- De applicatie stuurt een Cache-Control: no-cache header of een Expires datum in het verleden.
- De URL bevat een van de volgende woorden:
	- /administrator (Joomla)
	- /components/banners (Joomla)
	- preview=true (Wordpress)
	- xmlrpc.php (Wordpress)
	- wp-login, wp-admin, login (Wordpress)
	- cron.php (generiek)
	- begint met /nc/ (no cache) (generiek)
- Er wordt door de client een cookie meegestuurd, met een naam die een van deze woorden bevat:
	- SESS (Drupal)
	- NO_CACHE (Drupal)
	- PERSISTENT_LOGIN (Drupal)
	- userID (Joomla)
	- isloggedin (Joomla)
	- wordpress_logged_in (Wordpress)
	- UserID (mediawiki)

In alle andere gevallen gelden de volgende stappen:

1. Alle Google Analytics gerelateerde parameters worden uit de URL gestripped (die zijn enkel relevant voor de client).
1. Alle overige binnenkomende cookies worden verwijderd.
1. De applicatie genereert een antwoord. Indien daar een relevante Cache-Control header in zit, wordt het antwoord niet gecached.
1. Zonee, dan worden ook daar eventuele cookies van verwijderd. 
1. Indien het antwoord een Expires of Cache-control header bevat met een TTL in de toekomst, wordt het antwoord in de cache gestopt met deze TTL (maar maximaal 1 dag).


# Algemene werkwijze

Om Varnish in te zetten als je gebruik maakt van een custom cms moet je een aantal stappen volgen.

#### Stap 1

Zet de intelligente cache aan in het Byte service panel. Pagina's zullen nu waar mogelijk gecached worden.  

Door middel van de X-Cache antwoord headers kan worden bekeken of een antwoord uit de cache komt. Zie sectie *Tips* voor meer info.

#### Stap 2

Bepaal welke pagina's gecached mogen worden en vooral welke niet. Zie sectie *Wanneer cachen?* voor mee info.  

Stuur de juiste headers mee om content wel of niet te laten cachen. Zie hiervoor sectie *Tips*.  

Ook zijn er situaties te bedenken dat de site voor een bepaalde bezoeker niet gecached mag worden, denk aan een ingelogde gebruiker waarbij altijd gebruikers info getoond wordt. In deze situatie kan je een __NO_CACHE__ cookie plaatsen. Het volgende voorbeeld plaatst bijvoorbeeld voor het komende uur een no cache cookie.

```php
setcookie("NO_CACHE", true, time()+3600, "/");
```

#### Stap 3

Leeg de cache waar nodig. Denk bijvoorbeeld aan een wijziging in het cms of door synchronisatie met een extern systeem.  

Dit kan door een PURGE request te sturen naar de betreffende url van de gewijzigde content. Ook kan je de hele cache legen door PURGE request te sturen naar ```/.*``` 

Als je cms een hooks of events systeem heeft is het handig om na het opslaan van content deze logica uit te voeren.

```PHP
$curl = curl_init("http://je-website.nl/url-to-purge");
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PURGE");
curl_exec($curl);
```



## Wanneer cachen?

Cachen is een hele mooie oplossing, maar moet zeker niet altijd ingezet worden. Er zijn ook veel meer redenen te bedenken om Varnish niet in te zetten dan wel.  

Maar gelukkig valt een groot deel van de pagina's op internet in de categorie wel inzetten. Maar het is altijd een afweging de per site en per pagina gemaakt moet worden.  

Het is geen 1 klik oplossing om al je sites sneller te maken.

Wel

- Statische pagina's
- Pagina's die hetzelfde zijn voor elke bezoeker


Niet

- Gepersonaliseerde pagina's
- Pagina's met random content
- Beveiligde pagina's
- Pagina's die een beperkt aantal keer opgevraagd mogen worden.


# Debuggen

Help, mijn URL wordt gecached, maar dat wil ik niet!

Help, mijn URL wordt niet gecached, maar dat wil ik wel!

**Stap 1: debuggen met Chrome**

Kijk naar de headers in Google Chrome, developer toolbar (F12), tabblad netwerk, klik een request, en kijk dan naar de reply headers. De relevante zijn:

- X-Cache: HIT als je een antwoord uit de cache krijgt. en MISS als er niks in de cache zat, of de pagina niet cachebaar is. 
- X-Cacheable: NO (Request wordt niet gecached, reden wordt vermeld) of YES (Request wordt wel gecached)
- Age: x sec. Bij een cache HIT: hoe lang de URL al in de cache zit.
- Expires: datum. Zover in de toekomst (of soms verleden) moet de URL gecached worden. Indien in het verleden => geen cache! 
- Cache-control: indien “no-cache” of “must-revalidate”, dan is de cache door de applicatie uitgeschakeld.

Kijk ook naar de Cookies tab. Hier staan de cookies die je browser meestuurt, en die kunnen potentieel de cache uitschakelen. Zie ook de algemene informatie. 

**Stap 2: debuggen zonder cookies**

Doe hetzelfde als bij 1, maar dan met een anonymous browser venster (Chrome: ctrl-shift-N). Zo begin je cookie-loos, en kun je simuleren wat nieuwe bezoekers van je site zullen ervaren. 

**Stap 3: debuggen met curl**

Om eventuele browser instellingen uit te sluiten, kun je ook nog testen met curl. Dit is enkel beschikbaar op Mac OS en Linux.

```bash
curl -sLkD - -o /dev/null  https://www.byte.nl/
```

Met deze opties negeer je certificaatfouten en laat je alleen de headers zien van het antwoord, plus eventuele redirects. Controleer dezelfde zaken als bij stap 1.


## Valkuilen

Een aantal veel voorkomende valkuilen waar je op moet letten bij het gebruik van Varnish.

#### PHP Sessions

Bij gebruik van sessies stuurt PHP default een nocache header mee. Geen enkele pagina met sessies wordt dus gecached.

Om dit te voorkomen moet je dus echt alleen sessies gebruiken waar nodig. Is dit niet mogelijk binnen je CMS, dan kan je met behulp van de ```session_cache_limiter()``` functie de headers aanpassen. Roep deze functie aan voordat ```session_start()``` wordt aangeroepen. 

```php
session_cache_limiter("public"); //pagina's mogen gecached worden.
session_cache_limiter("nocache"); //pagina's mogen niet gecached worden.
```

Let op, gebruik van sessies betekent wel vaak dat je per bezoeker zaken wil behouden of aanpassen op de pagina.

Dat is dus bij een gecachede pagina niet meer mogelijk. Zet dit dus heel selectief in.

#### Analytics

Als je gebruikt maak van server side analytics zal dit niet meer kloppen. Er komen uiteindelijk veel minder requests binnen op de PHP applicatie.  

Op het gebruik van een pakket als Google Analytics of een andere externe dienst heeft Varnish natuurlijk geen invloed.

#### ACL

Als je access control doet op pagina's op basis van ip zal dit niet meer werken. De pagina's komen immers uit de cache en de gebruiker komt nooit langs een .htaccess. Zorg dus dat je geheime pagina's nooit worden gecached! 

#### Nieuwe versies van bestanden

Ook statische assets zoals afbeeldingen of css zullen gecached worden door Varnish. Als je bijvoorbeeld een nieuwe versie van je site deployed of een nieuwe versie van een afbeelding wordt geplaatst is het verstandig om ook een cache purge doen. Anders krijgen bezoekers verouderde content te zien.


