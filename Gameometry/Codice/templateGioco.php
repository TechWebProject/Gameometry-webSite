<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang', 'it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head = file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>", "<title>Gameometry | Videogioco</title>", $head);
//Cambiare con il nome del gioco (riga sopra e sotto)
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Pagina dedicata a uno specifico videogioco", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$title = $_POST['immagine'];
$header = file_get_contents('sezioniComuni/header.html');
$header = str_replace(
    '<span lang="en"><a href="index.php">Home</a></span> &raquo; Notizie</p>',
    '<span lang="en"><a href="index.php">Home</a></span> &raquo; <span lang="it"><a href="index.php">Videogiochi</a></span> &raquo; '.$title.'</p>',
    $header
);
$html->appendChild($doc->createTextNode($header));

//QUERY
$db1=OpenCon();
$title=mysqli_real_escape_string($db1,$title);
$tmpquery= "SELECT trama,rilascio,casaProduttrice,imgLocandina,piattaformaV,genereV FROM videogioco WHERE titolo='$title'";

$result = mysqli_query($db1,$tmpquery);

$r = mysqli_fetch_all($result,MYSQLI_ASSOC);

$trama = $r[0]['trama'];
$data_uscita=$r[0]['rilascio'];
$publisher=$r[0]['casaProduttrice'];
$imgLocandina=$r[0]['imgLocandina'];
$piattaforma=$r[0]['piattaformaV'];
$genere=$r[0]['genereV'];

mysqli_free_result($result); 
CloseCon($db1); 

$main = $html->appendChild($doc->createElement('main'));
$imgbanner = $html->appendChild($doc->createElement('img'));
$imgbanner->setAttribute('id', 'bannergioco');
$imgbanner->setAttribute('alt', 'Immagine di copertina');
$imgbanner->setAttribute('src', "Banner/banner_gtav.jpeg"); //(da cambiare con il database)
$main->appendChild($imgbanner);

$h1 = $html->appendChild($doc->createElement('h1'));
$h1->setAttribute('id', 'titologioco');
$title=str_replace("\'","'",$title);
$h1->appendChild($doc->createTextNode($title)); //DATABASE
$main->appendChild($h1);

$lista = $html->appendChild($doc->createElement('dl'));
$lista->setAttribute('id', 'boxattributi');
$main->appendChild($lista);

$imglocandina = $html->appendChild($doc->createElement('img'));
$imglocandina->setAttribute('id', 'locandinagioco');
$imglocandina->setAttribute('alt', 'locandina del gioco');
$imglocandina->setAttribute('src', $imgLocandina); //(da cambiare con il database)
$lista->appendChild($imglocandina);

$listaattributi = $html->appendChild($doc->createElement('dl'));
$listaattributi->setAttribute('id', 'attributigioco');
$lista->appendChild($listaattributi);

$attributo1 = $html->appendChild($doc->createElement('dt'));
$attributo1->appendChild($doc->createTextNode("Publisher")); 
$listaattributi->appendChild($attributo1);
//
$attributo1db = $html->appendChild($doc->createElement('dd'));
$attributo1db->appendChild($doc->createTextNode($publisher)); //DATABASE
$listaattributi->appendChild($attributo1db);
//
$attributo2 = $html->appendChild($doc->createElement('dt'));
$attributo2->appendChild($doc->createTextNode("Data di uscita")); 
$listaattributi->appendChild($attributo2);
//
$attributo2db = $html->appendChild($doc->createElement('dd'));
$attributo2db->appendChild($doc->createTextNode($data_uscita)); //DATABASE
$listaattributi->appendChild($attributo2db);
//
$attributo3 = $html->appendChild($doc->createElement('dt'));
$attributo3->appendChild($doc->createTextNode("Piattaforma")); //DATABASE
$listaattributi->appendChild($attributo3);
//
$attributo3db = $html->appendChild($doc->createElement('dd'));
$attributo3db->appendChild($doc->createTextNode($piattaforma)); //DATABASE
$listaattributi->appendChild($attributo3db);
//
$attributo4 = $html->appendChild($doc->createElement('dt'));
$attributo4->appendChild($doc->createTextNode("Genere")); //DATABASE
$listaattributi->appendChild($attributo4);
//
$attributo4db = $html->appendChild($doc->createElement('dd'));
$attributo4db->appendChild($doc->createTextNode($genere)); //DATABASE
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

/*
$divisore = $html->appendChild($doc->createElement('div'));
$divisore->setAttribute('id', 'separatore');
$divisore->appendChild($doc->createTextNode('|'));
$boxpunteggi->appendchild($divisore);
*/

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
$descrizionetrama->appendChild($doc->createTextNode($trama));
$main->appendChild($descrizionetrama);


//footer
$footer = file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");
