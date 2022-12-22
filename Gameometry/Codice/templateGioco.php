<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang', 'it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head = file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>", "<title>Gameometry | Videogioco</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Pagina dedicata a uno specifico videogioco", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$title = $_POST['immagine'];
$header = file_get_contents('sezioniComuni/header.html');
$header = str_replace(
    '<span lang="en"><a href="index.php">Home</a></span> &raquo; Notizie</p>',
    '<span lang="en"><a href="index.php">Home</a></span> &raquo; <span lang="it"><a href="videogiochi.php">Videogiochi</a></span> &raquo; '.$title.'</p>',
    $header
);
$html->appendChild($doc->createTextNode($header));

//QUERY
$db1=OpenCon();
$title=mysqli_real_escape_string($db1,$title);
$tmpquery= "SELECT recensione.titolo as title,trama,rilascio,casaProduttrice,imgBanner,imgLocandina,piattaformaV,genereV FROM recensione,videogioco WHERE recensione.idVideogioco=videogioco.titolo and videogioco.titolo='$title'";

$result = mysqli_query($db1,$tmpquery);

$r = mysqli_fetch_all($result,MYSQLI_ASSOC);

$titoloGioco = $r[0]['title'];
$trama = $r[0]['trama'];
$data_uscita=$r[0]['rilascio'];
$publisher=$r[0]['casaProduttrice'];
$banner=$r[0]['imgBanner'];
$imgLocandina=$r[0]['imgLocandina'];
$piattaforma=$r[0]['piattaformaV'];
$genere=$r[0]['genereV'];
mysqli_free_result($result); 
CloseCon($db1); 

$main = $html->appendChild($doc->createElement('main'));
$imgbanner = $html->appendChild($doc->createElement('img'));
$imgbanner->setAttribute('id', 'bannergioco');
$tmpBannerName = str_replace("Banner/","",$banner);
$imgbanner->setAttribute('alt', $tmpBannerName); /* togliere estensione img */
$imgbanner->setAttribute('src', $banner);
$main->appendChild($imgbanner);

$h1 = $html->appendChild($doc->createElement('h1'));
$h1->setAttribute('id', 'titologioco');
$title=str_replace("\'","'",$title);
$h1->appendChild($doc->createTextNode($title)); 
$main->appendChild($h1);

$lista = $html->appendChild($doc->createElement('dl'));
$lista->setAttribute('id', 'boxattributi');
$main->appendChild($lista);

$imglocandina = $html->appendChild($doc->createElement('img'));
$imglocandina->setAttribute('id', 'locandinagioco');
$tmpImgName = str_replace("Locandina/","",$imgLocandina);
$imglocandina->setAttribute('alt', $tmpImgName); /* togliere estensione img */
$imglocandina->setAttribute('src', $imgLocandina);
$lista->appendChild($imglocandina);

$listaattributi = $html->appendChild($doc->createElement('dl'));
$listaattributi->setAttribute('id', 'attributigioco');
$lista->appendChild($listaattributi);

$attributo1 = $html->appendChild($doc->createElement('dt'));
$attributo1->appendChild($doc->createTextNode("Publisher")); 
$listaattributi->appendChild($attributo1);
//
$attributo1db = $html->appendChild($doc->createElement('dd'));
$attributo1db->appendChild($doc->createTextNode($publisher)); 
$listaattributi->appendChild($attributo1db);
//
$attributo2 = $html->appendChild($doc->createElement('dt'));
$attributo2->appendChild($doc->createTextNode("Data di uscita")); 
$listaattributi->appendChild($attributo2);
//
$attributo2db = $html->appendChild($doc->createElement('dd'));
$attributo2db->appendChild($doc->createTextNode($data_uscita)); 
$listaattributi->appendChild($attributo2db);
//
$attributo3 = $html->appendChild($doc->createElement('dt'));
$attributo3->appendChild($doc->createTextNode("Piattaforma")); 
$listaattributi->appendChild($attributo3);
//
$attributo3db = $html->appendChild($doc->createElement('dd'));
$attributo3db->appendChild($doc->createTextNode($piattaforma)); 
$listaattributi->appendChild($attributo3db);
//
$attributo4 = $html->appendChild($doc->createElement('dt'));
$attributo4->appendChild($doc->createTextNode("Genere")); 
$listaattributi->appendChild($attributo4);
//
$attributo4db = $html->appendChild($doc->createElement('dd'));
$attributo4db->appendChild($doc->createTextNode($genere)); 
$listaattributi->appendChild($attributo4db);
//

$div_Recensione = $html->appendChild($doc->createElement('form'));
$div_Recensione->setAttribute('action','recensioneGioco.php');
$div_Recensione->setAttribute('method','POST');
$div_Recensione->setAttribute('id', 'link_recensione');
$nostrarecensione = $div_Recensione->appendChild($doc->createElement('button'));
$nostrarecensione->setAttribute('name', 'recensione'); 
$nostrarecensione->setAttribute('value',$titoloGioco);
$nostrarecensione->setAttribute('id', 'lanostrarecensione');
$nostrarecensione->appendChild($doc->createTextNode("Leggi la nostra recensione"));
$main->appendChild($div_Recensione);

$boxpunteggi = $html->appendChild($doc->createElement('div'));
$boxpunteggi->setAttribute('id', 'boxpunteggi');
$main->appendChild($boxpunteggi);

$scores = $html->appendChild($doc->createElement('div'));
$scores->setAttribute('class', 'scores');
$boxpunteggi->appendChild($scores);

$rec = $html->appendChild($doc->createElement('div'));
$rec->setAttribute('id', 'rec');
$scores->appendChild($rec);

$puntegiocritica = $html->appendChild($doc->createElement('span'));
$puntegiocritica->setAttribute('id', 'punteggioCritica');
$puntegiocritica->appendChild($doc->createTextNode('null')); 
$rec->appendChild($puntegiocritica);

$nostropunteggio = $html->appendChild($doc->createElement('span'));
$nostropunteggio->appendChild($doc->createTextNode('Il nostro punteggio')); 
$rec->appendChild($nostropunteggio);

/*
$divisore = $html->appendChild($doc->createElement('div'));
$divisore->setAttribute('id', 'separatore');
$divisore->appendChild($doc->createTextNode('|'));
$boxpunteggi->appendchild($divisore);
*/

$scoresutenti = $html->appendChild($doc->createElement('div'));
$scoresutenti->setAttribute('class', 'scores');
$boxpunteggi->appendChild($scoresutenti);

$recutenti = $html->appendChild($doc->createElement('div'));
$recutenti->setAttribute('id', 'recutenti');
$scoresutenti->appendChild($recutenti);

$punteggioutenti = $html->appendChild($doc->createElement('span'));
$punteggioutenti->setAttribute('id', 'punteggioUtenti');
$punteggioutenti->appendChild($doc->createTextNode('null')); 
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
