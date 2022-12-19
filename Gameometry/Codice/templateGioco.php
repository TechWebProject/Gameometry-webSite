<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang', 'it');
$body = $doc->appendChild($doc->createElement('body'));

//$nomegioco = (DATABASE)
//$banner = (DATABASE)
//$locandina = (DATABASE)

//head
$head = file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>", "<title>Gameometry | Videogioco</title>", $head);
//Cambiare con il nome del gioco (riga sopra e sotto)
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Pagina dedicata a uno specifico videogioco", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header = file_get_contents('sezioniComuni/header.html');
$header = str_replace(
    '<span lang="en"><a href="index.php">Home</a></span> &raquo; Notizie</p>',
    '<span lang="en"><a href="index.php">Home</a></span> &raquo; <span lang="it"><a href="index.php">Videogiochi</a></span> &raquo; Nome_Videogioco</p>',
    $header
);
$html->appendChild($doc->createTextNode($header));

//////////////
//io vi ammazzo
/////////////


$main = $html->appendChild($doc->createElement('main'));
$imgbanner = $html->appendChild($doc->createElement('img'));
$imgbanner->setAttribute('id', 'bannergioco');
$imgbanner->setAttribute('alt', 'Immagine di copertina');
$imgbanner->setAttribute('src', "./imgs/banner_gtav.jpeg"); //(da cambiare con il database)
$main->appendChild($imgbanner);

$h1 = $html->appendChild($doc->createElement('h1'));
$h1->setAttribute('id', 'titologioco');
$h1->appendChild($doc->createTextNode("Titolo Gioco")); //DATABASE
$main->appendChild($h1);

$lista = $html->appendChild($doc->createElement('dl'));
$lista->setAttribute('id', 'boxattributi');
$main->appendChild($lista);

$imglocandina = $html->appendChild($doc->createElement('img'));
$imglocandina->setAttribute('id', 'locandinagioco');
$imglocandina->setAttribute('alt', 'locandina del gioco');
$imglocandina->setAttribute('src', "./imgs/locandina Grand Theft Auto 5.webp"); //(da cambiare con il database)
$lista->appendChild($imglocandina);

$listaattributi = $html->appendChild($doc->createElement('dl'));
$listaattributi->setAttribute('id', 'attributigioco');
$lista->appendChild($listaattributi);

$attributo1 = $html->appendChild($doc->createElement('dt'));
$attributo1->appendChild($doc->createTextNode("Publisher")); //DATABASE
$listaattributi->appendChild($attributo1);
//
$attributo1db = $html->appendChild($doc->createElement('dd'));
$attributo1db->appendChild($doc->createTextNode("nome_publisher")); //DATABASE
$listaattributi->appendChild($attributo1db);
//
$attributo2 = $html->appendChild($doc->createElement('dt'));
$attributo2->appendChild($doc->createTextNode("Data di uscita")); //DATABASE
$listaattributi->appendChild($attributo2);
//
$attributo2db = $html->appendChild($doc->createElement('dd'));
$attributo2db->appendChild($doc->createTextNode("data")); //DATABASE
$listaattributi->appendChild($attributo2db);
//
$attributo3 = $html->appendChild($doc->createElement('dt'));
$attributo3->appendChild($doc->createTextNode("Piattaforma")); //DATABASE
$listaattributi->appendChild($attributo3);
//
$attributo3db = $html->appendChild($doc->createElement('dd'));
$attributo3db->appendChild($doc->createTextNode("piattaformadb")); //DATABASE
$listaattributi->appendChild($attributo3db);
//
$attributo4 = $html->appendChild($doc->createElement('dt'));
$attributo4->appendChild($doc->createTextNode("Genere")); //DATABASE
$listaattributi->appendChild($attributo4);
//
$attributo4db = $html->appendChild($doc->createElement('dd'));
$attributo4db->appendChild($doc->createTextNode("generedb")); //DATABASE
$listaattributi->appendChild($attributo4db);
//

$nostrarecensione = $html->appendChild($doc->createElement('a'));
$nostrarecensione->setAttribute('href', ''); //Pagina recensione
$nostrarecensione->setAttribute('id', 'lanostrarecensione');
$nostrarecensione->appendChild($doc->createTextNode("Leggi la nostra recensione"));
$main->appendChild($nostrarecensione);

$boxpunteggi = $html->appendChild($doc->createElement('div'));
$boxpunteggi->setAttribute('id', 'boxpunteggi');
$main->appendChild($boxpunteggi);

$scores = $html->appendChild($doc->createElement('div'));
$scores->setAttribute('id', 'scores');
$boxpunteggi->appendChild($scores);

$rec = $html->appendChild($doc->createElement('div'));
$rec->setAttribute('id', 'rec');
$scores->appendChild($rec);

$puntegiocritica = $html->appendChild($doc->createElement('span'));
$puntegiocritica->setAttribute('id', 'punteggioCritica');
$puntegiocritica->appendChild($doc->createTextNode('null')); //DATABASE
$rec->appendChild($puntegiocritica);

$nostropunteggio = $html->appendChild($doc->createElement('span'));
$nostropunteggio->appendChild($doc->createTextNode('Il nostro punteggio')); //DATABASE
$rec->appendChild($nostropunteggio);

/////////
$divisore = $html->appendChild($doc->createElement('div'));
$divisore->setAttribute('id', 'separatore');
$divisore->appendChild($doc->createTextNode('|'));
$boxpunteggi->appendchild($divisore);
////////

$scoresutenti = $html->appendChild($doc->createElement('div'));
$scoresutenti->setAttribute('id', 'scores');
$boxpunteggi->appendChild($scoresutenti);

$recutenti = $html->appendChild($doc->createElement('div'));
$recutenti->setAttribute('id', 'recutenti');
$scoresutenti->appendChild($recutenti);

$punteggioutenti = $html->appendChild($doc->createElement('span'));
$punteggioutenti->setAttribute('id', 'punteggioUtenti');
$punteggioutenti->appendChild($doc->createTextNode('null')); //DATABASE
$recutenti->appendChild($punteggioutenti);

$punteggioutentispan = $html->appendChild($doc->createElement('span'));
$punteggioutentispan->appendChild($doc->createTextNode('Punteggio degli Utenti'));
$recutenti->appendChild($punteggioutentispan);

$htrama = $html->appendChild($doc->createElement('h2'));
$htrama->setAttribute('id', 'trama');
$htrama->appendChild($doc->createTextNode('Trama'));
$main->appendChild($htrama);

$descrizionetrama = $html->appendChild($doc->createElement('p'));
$descrizionetrama->setAttribute('id', 'descrizione');
$descrizionetrama->appendChild($doc->createTextNode("According to all known laws of aviation, there is no way a bee should be able to fly. Its wings are too small to get its fat little body off the ground. The bee, of course, flies anyway because bees don't care what humans think is impossible. Yellow, black. Yellow, black. Yellow, black. Yellow, black. Ooh, black and yellow! Let's shake it up a little. Barry! Breakfast is ready!"));
$main->appendChild($descrizionetrama);


//footer
$footer = file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");
