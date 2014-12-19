# Snelle instructie oud

Installeer deze plugin: https://wordpress.org/plugins/varnish-http-purge/

- patch: altijd op http verbinden
- zet dit in wp-config.php:
- define('VHP_VARNISH_IP',$_SERVER["HTTP_X_ORIGINAL_SERVER_IP"]);

Getest met versie 3.5.1. Geen configuratie nodig. 

# Snelle instructie nieuw

Alvorens Varnish goed kan functioneren is het belangrijk om te
controleren of de juiste headers vanuit de website verzonden worden. Op
basis van de verzonden response headers bepaald Varnish namelijk of de
desbetreffende pagina gecached moet worden of niet. Hiervoor wordt
gekeken naar de waarde van de ‘Cache-Control’ headers.

Onderstaand voorbeeld geeft bijvoorbeeld aan dat Varnish de pagina niet
in de cache hoeft op te nemen.

```
Cache-Control: no-cache, must-revalidate, max-age=0
```

Alvorens Varnish geïnstalleerd wordt is het dan ook te adviseren om te
controlleren of bovenstaande headers niet per ongeluk ten alle tijden
wordt mee gestuurd. In sommige gevallen zijn de plugin ontwikkelaars
niet even oplettend bezig en sturen ze soms per ongeluk \`no-cache\`
headers aan de pagina mee.

Eén veel voorkomende fout hierbij is dat er in één van de plugins een
PHP sessie wordt gestart. Bij het starten van een sessie worden er
namelijk automatisch ‘no-cache’ headers mee verzonden; daarom worden
sessies normaliter vermeden binnen WordPress.

```
session_start();
```

Let op:bij ingelogde gebruikers worden er altijd ‘no-cache’ headers mee
verstuurd. Zorg er dan ook voor dat je tijdens het testen uitgelogd
bent.

Stap 1 – Bestel Varnish 
-----------------------

Om gebruik te maken van Varnish op je WordPress website moet je eerst
Varnish bestellen, dit kan je doen via het Byte Service Panel. Onder de
tab… staat een extra knop waarmee je Varnish in jouw pakket kan
aanschaffen en activeren.

Je kan Varnish herkennen aan de volgende extra headers:

Via: 1.1 varnish

X-Varnish: [nummer]

Stap 2 – Installeer de Varnish plugin 
-------------------------------------

Na het bestellen van Varnish is deze in principe al actief op je
website. Vanaf dit moment wordt alles direct al in de cache opgeslagen.
Er is in dit stadium echter nog geen controle mogelijk over de cache
zelf. Het is daarom raadzaam om een extra plugin te installeren welke de
communicatie tussen Varnish en jouw WordPress omgeving beheert.

Byte heeft in samenwerking met 42functions hiervoor een eigen plugin
ontwikkeld. Deze plugin haakt in op de diverse processen binnen
WordPress en zorgt ervoor dat de cache op de correcte momenten geleegd
wordt. Denk hierbij aan het wijzigen van berichten, categorieën, widgets
of andere elementen op de website.

De  Varnish plugin kan je op[deze](http://google.nl) pagina downloaden,
eenmaal gedownload kan je het bestand uitpakken en in de plugins folder
van je WordPress installatie plaatsen. Zodra de plugin eenmaal
verplaatst is ga je naar de ‘Plugin’ pagina in het admin panel van
WordPress. Hier staat een nieuwe plugin genaamd ‘Varnish Cache’,
activeer deze middels de ‘Activeer’ knop.

[bespreken met Byte of plugin in WP directory komt]

Indien de plugin correct geactiveerd is zie je een extra menu
verschijnen in de admin bar. Dit menu, ‘Cache’, kan gebruikt worden om
de plugin aan te sturen of om te configureren.

Stap 3 – De plugin configureren 
-------------------------------

Na het activeren van de plugin is deze gelijk actief. Er wordt een
standaard configuratie ingeladen welke van toepassing is voor de meeste
websites. Uiteraard is geen website hetzelfde en het is dan ook aan te
raden om de configuratie na te lopen nadat de plugin geactiveerd is.

Je kan de configuratiepagina vinden onder het menu item ‘Cache’ \>
‘Configuration’ in de admin bar. Eenmaal op de configuratiepagina
aangekomen kan je aangeven welk gedrag de plugin dient te vertonen
rondom het monitoren van opties, berichten, terms en comments.

### General 

In deze sectie kan je de efficiënte van de plugin instellen. In sommige
gevallen wil het wel eens voorkomen dat er een pagina gewijzigd wordt
welke en grote hoeveelheid onderliggende pagina’s heeft die geleegd
dienen te worden; denk hierbij aan een archiefpagina.  In sommige
gevallen wordt het legen een grote hoeveelheid pagina’s inefficiënt. Het
is mogelijk een maximum in te stellen, indien dit maximum overschreden
wordt leegt de plugin automatisch de hele cache.

Aanvullend hierop zijn veel van de pagina’s die gemonitord worden door
de plugin gelaagde pagina’s. Dit wil zeggen dat het om pagina’s gaat
welke een eigen navigatie vereisen, denk hierbij aan categorie pagina’s
en blog overzichten. Omdat het in grote installaties kan oplopen tot een
flink aantal pagina’s kan er daarom een limiet worden ingesteld waarbij
bijvoorbeeld enkel de cache van de eerste 10 pagina’s geleegd wordt.

Verder is er het mogelijk om extra opties binnen WordPress te monitoren.
Hierbij wordt er gekeken naar de wijzigingen welke in deze opties plaats
vinden, mocht er een wijziging plaats vinden dan wordt de cache
automatisch geleegd.  De plugin kijkt uit zichzelf al naar een vele
hoeveelheid opties zoals de permalink structuur, tijdzones, SEO
instellingen en veel meer.

Indien je een nieuwe plugin heb geïnstalleerd welke invloed heeft op de
uitstraling van de website of op de onderliggende technieken (denk
hierbij aan SEO). Dan is het bijvoorbeeld ook handig dat de cache
geleegd wordt na het wijzigen van een optie in deze plugin. Dat kan dus
middels deze extra monitoring optie.

### Posts 

Berichten zijn de belangrijkste entiteiten op je website. De berichten
geven je website immers de vorm en inhoud waar je bezoekers naar op zoek
zijn, deze definiëren je site structuur en bepalen de vindbaarheid van
je website. Het is dan ook belangrijk dat de juiste cache geleegd wordt
na het wijzigen van een bericht.

Middels deze plugin kan je aangeven welke pagina’s, archieven en feeds
binnen jouw website relevant zijn om te legen na het wijzigen van een
pagina.

Onderstaand een afbeelding van alle relaties die een pagina binnen
WordPress kan hebben. Bij het wijzigen van een pagina is het dan ook
belangrijk dat deze allemaal gecontroleerd worden en geleegd worden
indien deze van toepassing zijn.

### Terms 

"Terms" is de omvattende benaming binnen WordPress welke gebruikt word
voor categorieën, tags en taxonomieën (eigen categorieën). Deze pagina’s
dienen doorgaans als een verzamelarchief voor alle onderliggende
berichten; het is dan ook belangrijk om te definiëren welke pagina’s er
geleegd moeten worden na een wijziging omtrent terms.

Voor de terms kan je via de plugin aangeven welke feeds, archieven en
pagina’s geleegd dienen te worden na het wijzigen van een term.
Aanvullend hierop kan nog aangegeven worden welke feed types de plugin
allemaal dient te legen.

Onderstaand een afbeelding van alle relaties die een term binnen
WordPress kan hebben. Bij het wijzigen van een erm is het dan ook
belangrijk dat deze allemaal gecontroleerd worden en geleegd worden
indien deze van toepassing zijn.

### Comments 

WordPress kent uit zichzelf meerdere type comments welke gebruikt kunnen
worden voor verschillende doeleinden. Niet alle comments zijn echter
dergelijk relevant dat daarvoor gelijk de hele cache geleegd dient te
worden. Het is dan ook mogelijk om via de plugin aan te geven welk type
comments deze dient te monitoren.

Na het wijzigen van een comment waarvan het type is gemarkeerd in de
plugin wordt automatisch de cache van de aanhangende post geleegd.

W3 Total Cache 
--------------

W3 Total Cache is een van de meest gebruikte plugins als het gaat om de
verbetering van de performance op WordPress websites. Deze rijk gevulde
plugin heeft een scala aan configuratiemogelijkheden waarbij diverse
caching methodieken op een  website kunnen worden toegepast. Eén van de
opties die zij hierbij bied is het gebruik van Varnish.

Hoewel Varnish ook door W3 Total Cache ondersteund wordt is de plugin er
niet optimaal op afgestemd. Zo zijn er diverse aspecten waarmee de
plugin geen rekening mee houd.

### Hiërarchische wijzigingen 

Op veel websites wordt er gebruik gemaakt van een kruimelpad. Indien men
de titel of belangrijker, de url,  van een pagina wijzigt dient men niet
alleen de desbetreffende pagina cache te wijzigen maar ook de cache van
alle onderliggende pagina’s. Deze cache dient geleegd te worden om
foutieve links op de onderliggende pagina’s te voorkomen.

### URL wijzigingen 

In sommige gevallen is het gewenst om de url van een pagina te wijzigen.
Indien dit voor komt is het belangrijk dat de cache van de ‘oude’ pagina
geleegd wordt opdat deze niet langer bereikbaar is. W3 Total Cache leegt
enkel de cache van de ‘nieuwe’ pagina, het gevolg hiervan is dat er op
dat moment twee versies van de pagina bestaan; dit uiteraard ten nadelen
van de SEO op de website. Denk hierbij aan de[Google Panda
update](http://orangevalley.nl/google-panda-update-in-nederland/) welke
dubbele content op de website bestraft.

### Menu wijzigingen 

In WordPress kan men direct pagina’s en categorieën invoegen in het
menu. Bij het wijzigen van bijvoorbeeld een pagina titel of URL wordt
dan automatisch het menu bijgewerkt. W3 Total Cache erkent deze relaties
niet, na dergelijke wijzigingen wordt enkel de pagina cache geleegd; dit
terwijl in dit geval juist de algehele cache geleegd dient te worden.

Varnish HTTP Purge 
------------------

Een ander veelgebruikte plugin naast W3 Total Cache is de Varnish HTTP
Purge plugin. In tegenstelling tot W3 Total Cache beperkt deze plugin
zich enkel tot een caching laag met betrekking tot Varnish.

Net als onze maatgemaakte oplossing fungeert de HTTP Purge plugin zich
als een communicatie laag tussen de website en Varnish. De plugin
monitort specifieke acties welke in de backend plaats vinden en flushed
vervolgens de bijhorende Varnish cache.

De HTTP purge plugin is echter een zeer beperkte plugin welke zich in
een beperkte mate richt op het legen van de cache rondom berichten. De
plugin beperkt zich enkel tot de basale relaties welke plaats vinden in
een basis WordPress installatie. Indien er gebruik gemaakt wordt van
eigen taxonomieën, auteur pagina’s of een aangepaste SEO structuur dan
schiet de HTTP Purge plugin al snel tekort.

Deze plugin is gericht op beheerders welke zich ervan bewust zijn
wanneer zij zelf de cache dienen te legen. Deze beheerders dienen de
relatie te begrijpen van de wijzigingen welke zij maken en de scoping
van de pagina’s welke de cache leegt na het uitvoeren van specifieke
acties.


