<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Applicazione Budget personale<br><br>

### Giordano Bruno Michela - ICTS23-25.007<br>Corso ITS Software developer<br>PHP - Verifica finale

Laravel framework<br>
Breeze starter kit<br>
Tailwind CSS

## Installazione

### Installazione delle Dipendenze
Assicurati di avere tutte le dipendenze necessarie installate. Esegui i seguenti comandi nel tuo terminale:

composer install<br>
npm install

### Compilazione degli Asset
Compila gli asset frontend:

npm run build

### Configurazione dell'Ambiente
Copia il file .env.example in .env e configura le variabili d'ambiente:

cp .env.example .env

### Generazione della Chiave dell'Applicazione
Genera la chiave dell'applicazione:

php artisan key:generate

### Esecuzione delle Migrazioni
Esegui le migrazioni del database e i seed delle tabelle di default:

php artisan migrate<br>
php artisan db:seed

### Avvio del Server di Sviluppo
Avvia il server di sviluppo di Laravel:

php artisan serve

## Istruzioni

### Profilo utente

- Dal pulsante in alto a destra con il proprio username si accede ad un menu per visualizzare il proprio profilo e le impostazioni.
- Dalla schermata del profilo si può modificare l'username, cambiare password, e cancellare il profilo.

### Impostazioni

- Per accedere alle impostazioni cliccare sull'username (in alto a destra) e selezionare **Settings**
Dalle impostazioni si possono aggiungere, rimuovere, e modificare i conti e i tipi di transazione. Ogni tipo di transazione personalizzato dev'essere classificato come entrata, addebito, o trasferimento.
  - La cancellazione di un account comporta la cancellazione di tutte le relative transazioni. È presente un'ulteriore richiesta di conferma prima della cancellazione di un account.

### Dashboard

- La **Dashboard** è accessibile dal relativo link nella navbar, in alto a sinistra.
- Nella sezione superiore sono visibili i box per i bilanci (totale e per ogni conto), e il selettore del periodo di riferimento.
- Nella sezione inferiore è presente una tabella per visualizzare le transazioni.

#### Bilanci

- Dalla tabella è possibile visualizzare i bilanci di ogni conto.
  - Cliccando sulla riga di ogni conto è possibile filtrare i risultati della tabella transazioni per visualizzare solo le transazioni del conto selezionato.

- Sotto la tabella è presente il contatore del bilancio complessivo.

- E' infine presente un pulsante **Reset** per reimpostare la tabella per visualizzare tutte le transazioni.

#### Periodo di riferimento

- E' possibile filtrare le transazioni in base ad un periodo a scelta.
- Con i pulsanti **M+** e **M-** si può avanzare o retrocedere di un mese.
- Per confermare il filtro per periodo cliccare sul pulsante **Filter**.
- E' infine presente un pulsante **Reset** per reimpostare la tabella per visualizzare tutte le transazioni.

#### Tabella transazioni

- La tabella transazioni visualizza di default tutte le transazioni ordinate per data, dalla più recente in giù.
  - È possibile selezionare un numero di righe tra 10, 25, e 50.
- In alto a destra è presente il pulsante **+** per aggiungere una transazione.
- Cliccando sugli header **Date** e **Amount** si possono ordinare i risultati rispettivamente per data e import ascendente/discendente.
- Cliccando su una riga si accede alla schermata di modifica della transazione, nella quale si possono modificare tutti i relativi dettagli, e anche caricare un'immagine (per esempio di uno scontrino) o un file pdf.
- L'immagine verrà visualizzata nel box a destra nei dettagli della transazione, mentre il file pdf sarà scaricabile tramite il pulsante **Download PDF**.
- Nell'ultima colonna di ogni riga è presente il pulsante per cancellare la transazione. Verrà visualizzata una schermata di conferma contenente tutti i dettagli della transazione.
<br><br>
Nelle schermate di modifica e cancellazione, inserendo nell'URI un id di un elemento non appartenente all'utente corrente, non verrà effettuata alcuna modifica.