<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Applicazione Budget personale<br><br>Giordano Bruno Michela - ICTS23-25.007<br><br>Corso ITS Software developer
Laravel framework<br>
Breeze starter kit<br>

## Installazione delle Dipendenze
Assicurati di avere tutte le dipendenze necessarie installate. Esegui i seguenti comandi nel tuo terminale:

composer install<br>
npm install

## Compilazione degli Asset
Compila gli asset frontend:

npm run build

## Configurazione dell'Ambiente
Copia il file .env.example in .env e configura le variabili d'ambiente:

cp .env.example .env

## Generazione della Chiave dell'Applicazione
Genera la chiave dell'applicazione:

php artisan key:generate

## Esecuzione delle Migrazioni
Esegui le migrazioni del database e i seed delle tabelle di default:

php artisan migrate<br>
php artisan db:seed

## Avvio del Server di Sviluppo
Avvia il server di sviluppo di Laravel:

php artisan serve