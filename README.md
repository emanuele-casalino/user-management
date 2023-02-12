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

## Login

Nella pagina di login si effettua l'accesso tramite username e password. Il login viene effettuato:
- se l'utente e attivo e non sospeso.
