Installeer deze plugin: https://wordpress.org/plugins/varnish-http-purge/

- patch: altijd op http verbinden
- zet dit in wp-config.php:
- define('VHP_VARNISH_IP',$_SERVER["HTTP_X_ORIGINAL_SERVER_IP"]);

Getest met versie 3.5.1. Geen configuratie nodig. 
