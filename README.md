Salve a tutti.
Questo programmino in PHP serve per permettere l'iscrizione al sito nel quale si trova, senza dover eventualmente compromettere il codice del sito stesso adibito alla gestione dati del sito stesso.

# File system/config.php

Questo file serve per configurare il funzionamento del programmino. In particolare:
- il link del sito nel quale si trova il programmino, senza fare riferimento al programmino stesso
- la directory del programmino
- il link del programmino
- i parametri di connessione al database
- la tabella dove vengono memorizzate le informazioni dell'utente
- gli attributi di base dell'utente
- il nome del ruolo utilizzato per l'amministratore
- i limiti sulle lunghezze del nome utente
- i limiti sulle lunghezza della password, e il costo per l'algoritmo BCRYPT
- la lunghezza massima dell'indirizzo di posta elettronica
- quale valore dare all'utente qualora fosse attivo (true o false)

# File system/consts.php

Questo file contiene le costanti per il funzionamento del programmino: In particolare:
- le costanti sui nomi di directory del programmino
- le costanti sui nomi di file del programmino
- la lingua predefinita, e quelle disponibili
- le costanti sulla durata di alcuni eventi:
  - la durata massima della sessione di accesso è di un'ora
  - la durata massima di attesa di ricezione email dal programmino è di un'ora, alla fine di evitare lo spam da parte del programmino stesso
  - la durata massima di una password è di 30 giorni
- le costanti sulle variabili di sessione

# Lingue

Questo programmino è tradotto in due lingue:
- Italiano
- Inglese

# Utente

Un utente deve almeno avere questi attributi:
- ID
- ruolo
- nome utente
- password
- indirizzo di posta elettronica
- se l'utente è attivo o meno
- la data di reimpostazione
- la data dell'ultima password
- data e ora di creazione
- data e ora di modifica

Un utente è sospeso se non è attivo e se è impostata la data dell'ultima password.

# Pagine

Questo programmino ha dodici pagine:
- Per tutti gli utenti:
  - home - è la pagina iniziale del programmino
  - info - pagina con le informazioni del creatore di questo programmino
- Per solo gli utenti ospiti:
  - login - serve per effettuare l'accesso al programmino
  - password_recovery - serve per richiedere il recupero della password, qualora non si riuscisse a ricordarla. Vale per gli utenti già attivi.
  - request_activation_link - serve per richiedere il link di attivazione al sito sul quale si trova il programmino, qualora lo si fosse smarrito. Vale per gli utenti non ancora attivi.
  - set_password - serve per impostare la password. Pagina raggiungibile solo dal link inviato tramite posta elettronica tramite le due pagine precedenti.
  - sign_up_on_the_site - dà la possibilità di iscriversi al sito sul quale si trova il programmino
- Per solo gli utenti i quali hanno effettuato l'accesso
  - view_user_information - serve per visualizzare le informazioni dell'utente il quale ha effettuato l'accesso al programmino
  - change_username - serve per cambiare il nome utente
  - change_password - serve per cambiare la password
  - unsubscribe_from_the_site - serve per annullare l'iscrizione al sito sul quale si trova il programmino
  - logout - serve per effettuare l'uscita dal programmino

## Accesso

Nella pagina di login si effettua l'accesso tramite username e password. Il login viene effettuato:
- se l'utente è attivo e non sospeso.
- se la data dell'ultima password è troppo vecchia

## Recupero password

Nella pagina di recupero password, è sufficiente immettere l'indirizzo di posta elettronica. Questa operazione ha successo:
- quando esiste l'utente con l'indirizzo di posta elettronica immesso
- se tale utente è attivo e non sospeso
- se l'ultimo messaggio tramite posta elettronica associato all'indirizzo immesso è stato mandato più di un'ora prima
In caso di successo dell'operazione, il link inviato tramite posta elettronica ha la validità di un'ora.

## Richiesta link di attivazione

Come la pagina precedente, ma l'utente non deve essere attivo ma comunque non sospeso.

## Imposta password

Accessibile dal link inviato tramite messaggio di posta elettronica tramite le due pagine precedenti, serve comunque una stringa di hash con la quale recuperare l'utente, il quale non deve essere comunque sospeso, a prescindere dal fatto che sia attivo o no.
Attenzione! Se è passata più di un'ora dall'invio del link di attivazione, deve essere generato un nuovo link di attivazione.
Nel form dell'impostazione della password, si devono immettere due stringhe, le quali devono coincidere.
Se si tenta di impostare la password, se è già stata impostata, uguale a quella già immessa, viene generato un messaggio di errore.

## Modifica nome utente

Serve per modificare il nome utente dell'utente loggato.
N.B. Viene richiesta la password in quanto si tratta di una modifica alle informazioni di base dell'utente.

## Modifica password

Serve per modificare la password dell'utente loggato.
Richiede tre stringhe: la password vecchia, e le due stringhe che costituiscono la nuova password da immettere e che, quindi, devono essere uguali. Se la password vecchia non corrisponde a quella registrata, oppure è uguale alla password nuova, viene generato un messaggio di errore. 

## Annulla l'iscrizione dal sito

Serve per annullare l'iscrizione dal sito. C'è una checkbox, di default deselezionata, al fine di prevenire un'annullamento accidentale dell'iscrizione dal sito.
N.B. Viene richiesta la password in quanto si tratta di una modifica alle informazioni di base dell'utente.
