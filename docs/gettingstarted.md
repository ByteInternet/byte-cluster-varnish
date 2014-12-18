# Aan de slag

Nog even en je site is sneller dan 99% van het internet. Dat voelt goed, toch? Om daar te komen, moet je een paar dingen doen. 

## Stap 1: Leer hoe het werkt

Varnish zit tussen jouw website en je bezoeker. Varnish bewaart content in een cache en kan deze tot 100x sneller naar je bezoekers sturen, dan een normale webserver zou doen.

Dat klinkt makkelijk. Maar let op, er zit natuurlijk een addertje onder het gras. Niet alle content is geschikt om gecached te worden, zoals bijvoorbeeld gepersonaliseerde of geheime pagina's. In veel gevallen wordt dit door het Byte Varnish Cluster juist gedetecteerd. In sommige gevallen moet je zelf extra instructies geven. We raden dus altijd aan om eerst goed te testen voordat je Varnish activeert!

## Stap 2: Installeer benodigde software

De meeste webapplicaties hebben een extra module nodig om correct te kunnen werken. Die zorgt voor twee dingen: allereerst dat de geproduceerde pagina's worden aangemerkt als cache-baar. En ten tweede, dat wanneer de content wijzigt (bijvoorbeeld in de backend) ook de bijbehorende gecachete versie wordt bijgewerkt.

We hebben hier instructies voor de meest gebruikte webapplicaties verzameld. Als je meer exotische software gebruikt, zul je zelf op zoek moeten naar een Varnish module, of er zelf een maken. Zie hiervoor onze [maatwerk instructies](custom.md).

## Stap 4: Testen

Uit te werken: hoe gebruik je het "test-IP" om de cache te testen?

## Stap 3: Activeer Varnish

Op het Byte Service Panel kun je uit vier modi kiezen:

1. Cache niets (alle cache staat uit)
1. Cache enkel static assets (plaatjes, css)
1. Cache dynamisch, geoptimaliseerd voor Joomla/Wordpress/Drupal en maatwerk CMSen
1. Cache alles aggressief (in high traffic/load situaties waarbij men niet in de cms backend hoeft) dus negeer alle cookies, expires en cache headers.

De makkelijke modus is de tweede, hiervoor hoef je normaliter niets te wijzigen.

De modus met het beste resultaat is de derde.

 
