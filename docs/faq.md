#### Geen enkele pagina wordt gecached  

Let goed op de response headers, veel frameworks starten standaard een sessie waardoor er een no-cache header terug komt.

Anders heb je misschien een cookie die het gebruik van de cache voorkomt of de url van site bevat een van de gereserveerde woorden.  

Kijk hiervoor in de lijst bij de sectie *Tips*  

#### Cache aan, maar nog steeds traag

Een frontend cache is een onderdeel van een snelle site hebben.  De cache heeft alleen invloed op de snelheid waarmee request terug komen naar de gebruiker.  

Je kan nogsteeds veel te veel requests doen. Of de site rendered gewoon erg traag door teveel css of javascript.  

Kijk bijvoorbeeld op [Yslow](http://yslow.org/) voor meer tips over dit onderwerp.  

#### Mijn responses bevatten cache headers, maar ik doe nergens header() calls in de code

Kijk goed of je framework niet standaard een sessie start. Als dat niet het geval kan het ook een third-party component zijn wat je gebruikt.  

#### Gebruikers kunnen niet meer inloggen

Als de inlog pagina's en onderliggende pagina's worden gecached kan dat vervelende gevolgen hebben. Vaak dat er helemaal niet meer ingelogd kan worden of dat dezelfde pagina voor alle bezoekers wordt terug gegegen. Let dus goed op dat je de juiste cache headers terug stuurt na inloggen. Of nog beter een NO_CACHE cookie terug geeft.

#### Welke versie van Varnish gebruiken jullie?

Versie 3, de laatste stabiele uit Debian.  

#### Hoe zit het met SSL?

Dat werkt gewoon! Wel vereist de nieuwe architectuur de toepassing van SNI. Dit betekent dat extreem oude browsers (Windows XP, IE 6) niet werken. De praktijk laat echter zien dat er nog maar een handjevol van zulke browsers in omloop zijn, en dit aantal iedere maand verder afneemt, omdat Microsoft de support voor deze versies heeft beeindigd.

#### Een externe plugin mag niet gecached worden. Wat nu?

Je zou de relevante URLs kunnen her-routeren met een RewriteRule, zodat ze bijvoorbeeld beginnen met “/nc/” (no cache). NTB.

#### Hoe kan ik de hele site flushen?

- Knop service panel  
- Een PURGE of BAN request doen voor “/.*”  

#### Hoe stel ik een TTL in voor specifieke URLs?

Geef via “cache-control” headers een max-age of s-maxage mee.  

#### Kan iedereen een purge request sturen naar mijn site?

Ja, maar deze zullen genegeerd worden. Alleen interne purge requests (van hetzelfde cluster) zullen afgehandeld worden en er voor zorgen dat de cache geleegd wordt.
