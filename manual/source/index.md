# Wat is Byte Varnish Cluster?

Byte werkt aan de ontwikkeling van Varnish Cluster: een supersnel cluster, ondersteund met Varnish, voor 3x tot 10x snellere laadtijden.

Elke bedrijf wil voor bezoekers van zijn site of shop een prettige, sneller ervaring. Sneller betekent dat mensen meer bestellen, meer informatie aanvragen of fijner hun zaken met het bedrijf digitaal afhandelen.  

En wat je ook niet wilt is dat de site plat gaat bij media aandacht, campagnes, incidenten of gewoon groot succes. Door social media en e-mailmarketing wordt het gedrag qua bezoekerspieken steeds grilliger.  

En dat terwijl de resultaten van de site of shop vaak steeds belangrijker worden, voor veel bedrijven is de site inmiddels het primaire communicatie of commerciele kanaal. De site moet het altijd doen.  

Byte heeft daarom SpeedCluster ontwikkeld. Een technisch geavanceerd systeem, gebaseerd op onze Cluster techniek, gecombineerd met de cache methode Varnish. Zo zijn sites supersnel (< 100ms) en kunnen ook grote verkeerspieken (100.000 bezoekers per dag) aan. Ook Google vindt het heel belangrijk dat sites snel zijn en geeft snelle sites een boost in de resultaten.  

Varnish is een cache die voor de site geplaatst wordt. Alle requests worden dus eerst door Varnish afgehandeld. Als Varnish voor de request antwoord heeft wordt deze direct verzonden naar de gebruiker en zal de request niet worden doorgezet naar Apache. Een request uit Varnish zal dus veel sneller zijn dan een reguliere request.  

Mocht er geen antwoord in de cache zitten gaat de request door naar Apache en wordt het antwoord waar nodig in de cache geplaatst.
 
Wel een technische uitdaging voor onze partners, een goede configuratie is niet triviaal. Maar je zorgt wel dat de sites van je klanten snel en piekbestendig worden. Neem je de uitdaging aan?
 
Met SpeedCluster kun je elke site verschrikkelijk snel maken en hoef je je nooit meer druk te maken over piekbelasting.

# Waarom is het cool?

# Voor wie?

# Aan de slag, wat kun je verwachten?

# Hoe werkt het

In de uiteindelijke versie kan de Byte klant uit 3 modi kiezen: 
1. Cache niets
1. Cache enkel static assets (plaatjes, css)
1. Cache intelligent, geoptimaliseerd voor Joomla/Wordpress/Drupal en custom CMS
1. Cache alles aggressief (in high traffic/load situaties waarbij men niet in de cms backend hoeft) dus negeer alle cookies, expires en cache headers.

Voor de rest van deze handleiding gaan we uit van modus 3, die voor de meeste mensen van toepassing zal zijn. 

Applicatie = PHP script op de server
Client = Browser 

## Algemeen 
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


