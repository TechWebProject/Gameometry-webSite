==============
UTILIZZO XAMPP
==============

1- Scaricare Xampp
2- Andare sulla directory di Xampp (solitamente su C: ) , in htdocs spostare la cartella col progetto (Gameometry)
3- Avviare Xampp e cliccare su Start su Apache e su MySQL
4- Aprire il browser e scrivere sulla barra di ricerca localhost/Gameometry/Codice/index.php


=================
LETTURA DIRECTORY
=================

-Immagini: cartella che corrisponde alla cartella per le immagini utilizzate nel progetto

-Locandine/Banner: cartelle utilizzate dal codice per reperire le img attualmente presenti in locale ma anche sul DB

-connect.php: file importato, serve per connettersi al DB + una funzione per rimuovere dal nome le estensioni dei file

-*autoinsert: codice da runnare da vs non appena si aggiunge una nuova immagine sulla cartella imgs. Invia una query che inserisce sul db le sue info (fin ora utili)

-*deletephotosDBandDIR: codice da runnare da vs non appena si decide di rimuovere un'immagine, lo si avvia e si specifica su console l'esatto nome del file senza estensioni (corrisponde all'attributo "titolo" sul DB)

*per utilizzare questi file è necessario avere il DB "gameometrydb" creato tramite le query presenti nel file DB.sql
