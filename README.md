#Vítejte v našem frameworku LORA

##Ještě, než se pustíte do práce, ujistěte se, že jste provedli všechny následující kroky:

1. Zkontrolujte soubot **stylize.js** ve složce ./public/js/lib/autoload/stylize.js => pokud zde není nebo je nečitelný či prázdný je třeba jej zkompilovat.
Kompilaci provedete CLI příkazem: **php bin/stylize compile**

2. Přejděte do složky ./config a zadejte správné údaje do web.ini a database.ini
3.složky ./log, ./temp/cache by měli mít zapisovací práva

3. Pokud máte projekt zkopírovaný a již byl spuštěn, je třeba vyprázdnit cache uložených šablon: **php lora cache:flush**
