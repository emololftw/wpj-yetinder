# YETINDER

Zadání úkolu pro jako backend developer pro firmu [WPJ]

### Použité nástroje
- PhpStorm
- PHP 8.2
- Tailwind v3 (layout grid + styling)
- AlpineJS + ApexCharts (grafika)
- Latte jako šablonovací systém
- Nextras/Migrations
- Docker-compose
- Composer

### Popis modulů

Pro tento projekt byl zvolen šablonovací systém Latte. Kompletně nahradil nativní symfony twig. Dědičnost šablon je troufám si říct dost podobné. Výhodu Latte vidím v přehlednosti a možnosti operace s proměnnými jako v PHP. Definice bloků pro menší opakovatelnost kódu. Ve vývoji používám bundler Webpack. V tomto projektu je využito CDN. Projekt je responsivní.

###### Top 10 Yetyů
Tabulka posledních 10 záznamů (je omezena `limit()` funkcí). Seřazení je pomocí dvou sloupců (váha a hodnocení).
![Top 10 Yetyů](/.docs/top_10.png)

###### Přidat nového Yetiho!
Formulář pro přidání nového záznamu do DB. Formulář obsahuje frontend + backend validaci dat. Pro vykreslení a funkci formuláře byla použita externí knihovna: [nette/forms]. Formulář obsahuje i omezení formuálářových prvků, pro lepší definici Yetiho. Pro příklad výška nemůže být menší jak 200 cm. Formulář také kontroluje unikátnost jména.
###### Swipe
Swipe už je poznávání jiných Yeti v naší databázi. Yeti modul jako takový, bez parametrů není dostupný (router kontroluje validitu parametrů pomocí nativního validátoru). Pokud Controller zjistí, že `id === null` tak dojde k přesměrování na modul Swipe Select. Swipe obsahuje všechny základní informace o Yetim a jeho hodnocení, které můžete dvěma tlačítky (signály) změnit. Po jakémkoliv výsledku hodnocení se Vám nabídne další Yeti z nabídky. Systém také pozná, jaké profily jsou prémiové. Bacha! Fronta není nekonečná, může se stát, že systém už pro Vás nemá žádné další kandidáty!
![Swipe](/.docs/swipe.png)

###### Swipe Select
V předchozím příkladu bylo popsáno, že pokud parametr není validní, dojde k přesměrování na tento modul. Zde je jednoduchý formulář, který se snaží uživatele poznat. Ptá se ho na preferované pohlaví a hlavně je zde možnost hodu kostkou. Každý Yeti v databázi si také hodil kostkou (popř. systém). Podle výsledku hodu kostkou systém vytvoří frontu Vámi preferovaného pohlaví, kde na prvních příčkách jsou Yetiové se stejnou hodnotou hozené kostky. Fronta je uložena v `sessions` a jsou zde uloženy pouze odkazy na příslušné entity.
###### Analytika
Základní grafický přehled výsledků. Pro datové řady bylo využito agregačních funkcí (viz. `DatabaseService`). Grafy jsou vykresleny pomocí knihovny [ApexCharts].
![Analytika](/.docs/analysis.png)

###### Schéma databáze
![db](/.docs/db_scheme.png)

### Docker-compose
```bash
cd .docker
docker compose -p wpj_klima_jaroslav up -d
```

### Migraci databáze spustíme
```bash
php bin\console migrations:reset
```

### Stránka je po spuštění docker-compose exposnutá na
```http request
http://localhost:8888
```

### Dráťák
```link
https://app.moqups.com/OSKbdJz9hZzmWX1PxvqoXO6kGsz872Vq/view/page/ab9d56032
```


[WPJ]: <https://wpj.cz>
[nette/forms]: <https://github.com/nette/forms>
[ApexCharts]: <https://apexcharts.com/>
