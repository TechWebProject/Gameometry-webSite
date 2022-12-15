==================
UTILIZZO XAMPP
==================

1- Scaricare Xampp
2- Andare sulla directory di Xampp (solitamente su C: ) , in htdocs spostare la cartella col progetto (DBprova)
3- Avviare Xampp e cliccare su Start su Apache e su MySQL
4- Aprire il browser e scrivere sulla barra di ricerca localhost/Gameometry/Codice/index.php


======================
LETTURA DIRECTORY
======================

-Immagini: cartella che corrisponde alla cartella attuale di GitHub per le immagini utilizzate nel progetto

-imgs: cartella utilizzata dal codice per reperire le img attualmente presenti in locale ma anche sul DB

-connect.php: file importato dove serve per connettersi al DB + una funzione per rimuovere dai nome le estensioni dei file

-index.html: pagina fittizia in quanto mi serviva solo l'utilizzo del  bottone che rievoca l'utilizzo dell'li "videogiochi" nell'header

-*autoinsert: codice da runnare da vs non appena si aggiunge una nuova immagine sulla cartella imgs. Invia una query che inserisce sul db le sue info (fin ora utili)

-*deletephotosDBandDIR: codice da runnare da vs non appena si decide di rimuovere un'immagine, lo si avvia e si specifica su console l'esatto nome del file senza estensioni (corrisponde all'attributo "titolo" sul DB)

-css vari soliti non aggiornati all'ultima modifica



*per utilizzare questi file è necessario avere il DB "gameometry" creato con la tabella "videogioco" e due attributi di testo "titolo" e "imgLocandina"
