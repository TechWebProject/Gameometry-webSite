<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
session_start();
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang', 'it');
$body = $doc->appendChild($doc->createElement('body'));

$giocoRecensito;
if (isset($_POST['recensione'])) {
    $giocoRecensito = $_POST['recensione'];
} elseif (isset($_GET['titRec'])) {
    $giocoRecensito = $_GET['titRec'];
}

//QUERY
$db1 = OpenCon();
$title = mysqli_real_escape_string($db1, $giocoRecensito);
$tmpquery = "SELECT recensione.titolo as title,videogioco.titolo as videogioco,imgBanner,contenuto,voto FROM recensione,videogioco WHERE recensione.idVideogioco=videogioco.titolo and recensione.titolo='$title'";

$result = mysqli_query($db1, $tmpquery);
$r = $result->fetch_array(MYSQLI_ASSOC);

$titoloRec = $r['title'];
$titoloGioco = $r['videogioco'];
$banner = $r['imgBanner'];
$contenutoRec = $r['contenuto'];
$voto = $r['voto'];

mysqli_free_result($result);

CloseCon($db1);

//head
$head = file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>", "<title>Gameometry | Recensione $titoloGioco</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina &egrave; dedicata alle recensioni videoludiche sugli ultimi prodotti usciti", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, recensioni, recensione, videogioco, videogiochi, voto, commento", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header = file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie", "<a href=recensioni.php>Recensioni</a> &raquo; Recensione $titoloGioco", $header);
if (isset($_SESSION['username'])) {
    $header = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $header);
}
$body->appendChild($doc->createTextNode($header));

//main
$main = $body->appendChild($doc->createElement('main'));
$main->setAttribute('id', 'recensioneGioco');

$db = OpenCon();

$query_nrows = "SELECT COUNT(*) as nrighe FROM videogioco";
$result = mysqli_query($db, $query_nrows);
$tmparr = $result->fetch_array(MYSQLI_ASSOC);
$n_rows = $tmparr['nrighe'];

mysqli_free_result($result);

$query = "SELECT titolo FROM videogioco";
$result = mysqli_query($db, $query);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);


CloseCon($db);

$labelTitoli = $main->appendChild($doc->createElement('label'));
$t = '';

for ($i = 0; $i < $n_rows; $i++) {
    if ($i == $n_rows - 1) {
        $t .= $arr[$i]['titolo'];
    } else {
        $t .= $arr[$i]['titolo'] . ',';
    }
}

$labelTitoli->appendChild($doc->createTextNode($t));
$labelTitoli->setAttribute('id', 'arrTitoli');

$searchscript = $main->appendChild($doc->createElement('script'));
$searchscript->setAttribute('type', 'text/JavaScript');
$searchscript->setAttribute('src', 'Componenti/scriptSearch.js');

$divheader = $main->appendChild($doc->createElement('div'));
$divheader->setAttribute('id', 'headerRecensione');

$h1_Titolo = $divheader->appendChild($doc->createElement('h1'));
$h1_Titolo->setAttribute('id', 'titoloRecensione');
$h1_Titolo = $h1_Titolo->appendChild($doc->createTextNode($titoloRec));

$span_sTitolo = $divheader->appendChild($doc->createElement('span'));
$span_sTitolo = $span_sTitolo->appendChild($doc->createTextNode(''));

$div_copert = $divheader->appendChild($doc->createElement('div'));
$div_copert->setAttribute('id', 'copertina');
$imgCoper = $div_copert->appendChild($doc->createElement('img'));
$imgCoper->setAttribute('id', 'bannerRecensione');
$imgCoper->setAttribute('src', $banner);
//$imgCoper->setAttribute('tabindex','0');

$div_scores = $divheader->appendChild($doc->createElement('div'));
$div_scores->setAttribute('class', 'scores');

$div_rec = $div_scores->appendChild($doc->createElement('div'));
$div_rec->setAttribute('id', 'rec');

$span_pCritica = $div_rec->appendChild($doc->createElement('span'));
$span_pCritica->setAttribute('id', 'punteggioCritica');
//$span_pCritica->setAttribute('tabindex','0')
$span_pCritica = $span_pCritica->appendChild($doc->createTextNode($voto));

$span_textPunt = $div_rec->appendChild($doc->createElement('span'));
$span_textPunt = $span_textPunt->appendChild($doc->createTextNode('Il nostro punteggio'));

$p_contenuto = $main->appendChild($doc->createElement('p'));
$p_contenuto->setAttribute('id', 'contenuto');
//$p_contenuto->setAttribute('tabindex','0')
$p_contenuto->appendChild($doc->createTextNode($contenutoRec));

if (isset($_SESSION['email'])) {
    $h2_giveComment = $main->appendChild($doc->createElement('h2'));
    $h2_giveComment->setAttribute('class', 'titleH2');
    $h2_giveComment = $h2_giveComment->appendChild($doc->createTextNode('LASCIA UN COMMENTO'));

    $div_commento = $main->appendChild($doc->createElement('div'));
    $div_commento->setAttribute('id', 'inputCommento');

    $form_commento = $div_commento->appendChild($doc->createElement('form'));
    $form_commento->setAttribute('action', 'areaUtente.php');
    $form_commento->setAttribute('method', 'POST');

    $text_area = $form_commento->appendChild($doc->createElement('textarea'));
    $text_area->setAttribute('id', 'areaCommento');
    $text_area->setAttribute('name', 'commentoU');
    $text_area->setAttribute('rows', '10');
    $text_area->setAttribute('placeholder', ' Lascia un commento');
    $text_area->setAttribute('maxlength', '900');

    $div_voto = $form_commento->appendChild($doc->createElement('div'));
    $div_voto->setAttribute('id', 'votazione');

    $p_voto = $div_voto->appendChild($doc->createElement('p'));
    $p_voto = $p_voto->appendChild($doc->createTextNode('Lascia un voto'));

    $input_voto1 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto1->setAttribute('id', 'rate1');
    $input_voto1->setAttribute('name', 'rating');
    $input_voto1->setAttribute('type', 'radio');
    $input_voto1->setAttribute('value', '1');

    $label1 = $div_voto->appendChild($doc->createElement('label'));
    $label1->setAttribute('id', 'voto');
    $label1->setAttribute('for', 'rate1');
    $label1 = $label1->appendChild($doc->createTextNode('1'));

    $input_voto2 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto2->setAttribute('id', 'rate2');
    $input_voto2->setAttribute('name', 'rating');
    $input_voto2->setAttribute('type', 'radio');
    $input_voto2->setAttribute('value', '2');

    $label2 = $div_voto->appendChild($doc->createElement('label'));
    $label2->setAttribute('id', 'voto');
    $label2->setAttribute('for', 'rate2');
    $label2 = $label2->appendChild($doc->createTextNode('2'));

    $input_voto3 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto3->setAttribute('id', 'rate3');
    $input_voto3->setAttribute('name', 'rating');
    $input_voto3->setAttribute('type', 'radio');
    $input_voto3->setAttribute('value', '3');

    $label3 = $div_voto->appendChild($doc->createElement('label'));
    $label3->setAttribute('id', 'voto');
    $label3->setAttribute('for', 'rate3');
    $label3 = $label3->appendChild($doc->createTextNode('3'));

    $input_voto4 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto4->setAttribute('id', 'rate4');
    $input_voto4->setAttribute('name', 'rating');
    $input_voto4->setAttribute('type', 'radio');
    $input_voto4->setAttribute('value', '4');

    $label4 = $div_voto->appendChild($doc->createElement('label'));
    $label4->setAttribute('id', 'voto');
    $label4->setAttribute('for', 'rate4');
    $label4 = $label4->appendChild($doc->createTextNode('4'));

    $input_voto5 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto5->setAttribute('id', 'rate5');
    $input_voto5->setAttribute('name', 'rating');
    $input_voto5->setAttribute('type', 'radio');
    $input_voto5->setAttribute('value', '5');

    $label5 = $div_voto->appendChild($doc->createElement('label'));
    $label5->setAttribute('id', 'voto');
    $label5->setAttribute('for', 'rate5');
    $label5 = $label5->appendChild($doc->createTextNode('5'));

    $input_voto6 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto6->setAttribute('id', 'rate6');
    $input_voto6->setAttribute('name', 'rating');
    $input_voto6->setAttribute('type', 'radio');
    $input_voto6->setAttribute('value', '6');

    $label6 = $div_voto->appendChild($doc->createElement('label'));
    $label6->setAttribute('id', 'voto');
    $label6->setAttribute('for', 'rate6');
    $label6 = $label6->appendChild($doc->createTextNode('6'));

    $input_voto7 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto7->setAttribute('id', 'rate7');
    $input_voto7->setAttribute('name', 'rating');
    $input_voto7->setAttribute('type', 'radio');
    $input_voto7->setAttribute('value', '7');

    $label7 = $div_voto->appendChild($doc->createElement('label'));
    $label7->setAttribute('id', 'voto');
    $label7->setAttribute('for', 'rate7');
    $label7 = $label7->appendChild($doc->createTextNode('7'));

    $input_voto8 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto8->setAttribute('id', 'rate8');
    $input_voto8->setAttribute('name', 'rating');
    $input_voto8->setAttribute('type', 'radio');
    $input_voto8->setAttribute('value', '8');

    $label8 = $div_voto->appendChild($doc->createElement('label'));
    $label8->setAttribute('id', 'voto');
    $label8->setAttribute('for', 'rate8');
    $label8 = $label8->appendChild($doc->createTextNode('8'));

    $input_voto9 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto9->setAttribute('id', 'rate9');
    $input_voto9->setAttribute('name', 'rating');
    $input_voto9->setAttribute('type', 'radio');
    $input_voto9->setAttribute('value', '9');

    $label9 = $div_voto->appendChild($doc->createElement('label'));
    $label9->setAttribute('id', 'voto');
    $label9->setAttribute('for', 'rate9');
    $label9 = $label9->appendChild($doc->createTextNode('9'));

    $input_voto10 = $div_voto->appendChild($doc->createElement('input'));
    $input_voto10->setAttribute('id', 'rate10');
    $input_voto10->setAttribute('name', 'rating');
    $input_voto10->setAttribute('type', 'radio');
    $input_voto10->setAttribute('value', '10');

    $label10 = $div_voto->appendChild($doc->createElement('label'));
    $label10->setAttribute('id', 'voto');
    $label10->setAttribute('for', 'rate10');
    $label10 = $label10->appendChild($doc->createTextNode('10'));

    $submit_prova = $form_commento->appendChild($doc->createElement('input'));
    $submit_prova->setAttribute('type', 'hidden');
    $submit_prova->setAttribute('name', 'inviaCommento2');
    $submit_prova->setAttribute('value', $titoloGioco);

    $submit_voto = $form_commento->appendChild($doc->createElement('input'));
    $submit_voto->setAttribute('id', 'inviaCommento');
    $submit_voto->setAttribute('type', 'submit');
    $submit_voto->setAttribute('name', 'inviaCommento');
    $submit_voto->setAttribute('value', 'Commenta');
}

$h2_commenti = $main->appendChild($doc->createElement('h2'));
$h2_commenti->setAttribute('class', 'titleH2');
$h2_commenti = $h2_commenti->appendChild($doc->createTextNode('COMMENTI'));

$div_commenti = $main->appendChild($doc->createElement('div'));
$div_commenti->setAttribute('id', 'recensioni-utenti');

//commenti
$db2 = OpenCon();
$title1 = mysqli_real_escape_string($db2, $giocoRecensito);

$query_nrows = "SELECT COUNT(*) as nRighe FROM utente,commento,recensione,videogioco WHERE commento.idUtente=utente.email and commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and recensione.titolo='$title1'";
$result = mysqli_query($db2, $query_nrows);
$tmparr = $result->fetch_array(MYSQLI_ASSOC);
$n_rows = $tmparr['nRighe'];
mysqli_free_result($result);

$tmpquery2 = "SELECT utente.nickname as nickname, commento.contenuto as contenutoU, commento.voto as votoU FROM utente,commento,recensione,videogioco WHERE commento.idUtente=utente.email and commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and recensione.titolo='$title1' ORDER BY commento.data desc";
$result2 = mysqli_query($db2, $tmpquery2);
$arr2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
mysqli_free_result($result2);

CloseCon($db2);

for ($i = 0; $i < $n_rows; $i++) {
    $nickname = $arr2[$i]['nickname'];
    $contenuto = $arr2[$i]['contenutoU'];
    $votoU = $arr2[$i]['votoU'];

    $div_post = $div_commenti->appendChild($doc->createElement('div'));
    $div_post->setAttribute('class', 'post');

    $img_utente = $div_post->appendChild($doc->createElement('img'));
    $img_utente->setAttribute('class', 'r2');
    $img_utente->setAttribute('alt', 'immagine profilo utente registrato');
    $img_utente->setAttribute('src', 'Immagini/avatar.png');

    $div_postCommento = $div_post->appendChild($doc->createElement('div'));
    $div_postCommento->setAttribute('class', 'commento');

    $ul_contenuto = $div_postCommento->appendChild($doc->createElement('ul'));
    $ul_contenuto->setAttribute('class', 'contenutoRecensioneU');

    $li_utente = $ul_contenuto->appendChild($doc->createElement('li'));
    $li_utente->setAttribute('class', 'toBold');
    $li_utente = $li_utente->appendChild($doc->createTextNode($nickname));
    $li_commento = $ul_contenuto->appendChild($doc->createElement('li'));
    $li_commento = $li_commento->appendChild($doc->createTextNode($contenuto));

    $div_punteggio = $div_post->appendChild($doc->createElement('div'));
    $div_punteggio->setAttribute('class', 'boxPunteggioU');
    $p_punteggio = $div_punteggio->appendChild($doc->createElement('p'));
    $p_punteggio->setAttribute('class', 'punteggioU');
    $p_punteggio = $p_punteggio->appendChild($doc->createTextNode($votoU));
}

//footer
$footer = file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");
