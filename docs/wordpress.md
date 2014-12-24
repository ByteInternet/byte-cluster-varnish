# Snelle instructies

1. Download [deze plugin](https://github.com/ByteInternet/byte-cluster-varnish) naar je eigen computer.
2. Log in op de admin panel van je Wordpress site
2. Ga naar Plugins > Nieuwe Plugin > Upload Plugin > Upload de zip file > Klik op "Activeer"
4. Klaar! Controleer of alles goed werkt. Bij problemen, lees verder.

# Achtergrond

Byte heeft in samenwerking met 42functions hiervoor een eigen plugin
ontwikkeld. Deze plugin haakt in op de diverse processen binnen
WordPress en zorgt ervoor dat de cache op de correcte momenten geleegd
wordt. Denk hierbij aan het wijzigen van berichten, categorieën, widgets
of andere elementen op de website.

Indien de plugin correct geactiveerd is zie je een extra menu
verschijnen in de admin bar. Dit menu, ‘Cache’, kan gebruikt worden om
de plugin aan te sturen of om te configureren.

## Plugin configureren

Na het activeren van de plugin is deze gelijk actief. Er wordt een
standaard configuratie ingeladen welke van toepassing is voor de meeste
websites. Uiteraard is geen website hetzelfde en het is dan ook aan te
raden om de configuratie na te lopen nadat de plugin geactiveerd is.

Je kan de configuratiepagina vinden onder het menu item ‘Cache’ \>
‘Configuration’ in de admin bar. Eenmaal op de configuratiepagina
aangekomen kan je aangeven welk gedrag de plugin dient te vertonen
rondom het monitoren van opties, berichten, terms en comments.

### General 

In deze sectie kan je de efficiëntie van de plugin instellen. In sommige
gevallen wil het wel eens voorkomen dat er een pagina gewijzigd wordt
welke en grote hoeveelheid onderliggende pagina’s heeft die geleegd
dienen te worden; denk hierbij aan een archiefpagina. In sommige
gevallen wordt het legen een grote hoeveelheid pagina's inefficiënt. Het
is mogelijk een maximum in te stellen, indien dit maximum overschreden
wordt leegt de plugin automatisch de hele cache.

Aanvullend hierop zijn veel van de pagina’s die gemonitord worden door
de plugin gelaagde pagina’s. Dit zijn pagina's met eigen navigatie, zoals categorie of blog overzichten.
Omdat het in grote installaties kan oplopen tot een
flink aantal pagina’s kan er daarom een limiet worden ingesteld waarbij
bijvoorbeeld enkel de cache van de eerste 10 pagina’s geleegd wordt.

Verder is er het mogelijk om extra opties binnen WordPress te monitoren. Bij veranderde instellingen wordt de cache
automatisch geleegd.  De plugin kijkt uit zichzelf al vele opties, zoals de permalink structuur, tijdzones en SEO
instellingen.

Indien je een nieuwe plugin heb geïnstalleerd die invloed heeft op de
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

WordPress kent verschillende soorten comments. Het is niet voor alle comments nodig, om de cache te legen. 
Hier kan worden ingesteld bij welke comments dit wel moet gebeuren.

Na het wijzigen van een comment waarvan het type is gemarkeerd in de
plugin wordt automatisch de cache van de gekoppelde post geleegd.

# Gebruik je W3 Total Cache?

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
van de SEO op de website. Denk hierbij aan de [Google Panda update](http://orangevalley.nl/google-panda-update-in-nederland/) die
dubbele content op de website bestraft.

### Menu wijzigingen 

In WordPress kan men direct pagina’s en categorieën invoegen in het
menu. Bij het wijzigen van bijvoorbeeld een pagina titel of URL wordt
dan automatisch het menu bijgewerkt. W3 Total Cache erkent deze relaties
niet, na dergelijke wijzigingen wordt enkel de pagina cache geleegd; dit
terwijl in dit geval juist de algehele cache geleegd dient te worden.

# Varnish HTTP Purge 

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
