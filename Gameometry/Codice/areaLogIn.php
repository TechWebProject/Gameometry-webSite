<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Accesso</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Accedi a Gameometry e gestisci i tuoi commenti", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, accesso, login, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Accesso",$header);
$body->appendChild($doc->createTextNode($header));

//main
$main = $body->appendChild($doc->createElement('main'));

$h1 = $main->appendChild($doc->createElement('h1'));
$h1 = $h1->appendChild($doc->createTextNode('AREA DI ACCESSO'));

$div = $main->appendChild($doc->createElement('div'));
$div->setAttribute('id','logIn');

$form = $div->appendChild($doc->createElement('form'));
$form->setAttribute('action','accesso');

$h2 = $form->appendChild($doc->createElement('h2'));
$h2->setAttribute('id','loginTitle');
$h2Content = $h2->appendChild($doc->createElement('span'));
$h2Content->setAttribute('lang','en');
$h2Content = $h2Content->appendChild($doc->createTextNode('Login'));

$fieldset = $form->appendChild($doc->createElement('fieldset'));

$spanUser = $fieldset->appendChild($doc->createElement('span'));
$spanUser->setAttribute('id','usernameBox');
$labelUser = $spanUser->appendChild($doc->createElement('label'));
$labelUser->setAttribute('for','username');
$spanUser2 = $labelUser->appendChild($doc->createElement('span'));
$spanUser2->setAttribute('lang','en');
$spanUser2 = $spanUser2->appendChild($doc->createTextNode('Username'));
$spanUserInput = $spanUser->appendChild($doc->createElement('input'));
$spanUserInput->setAttribute('name','username');
$spanUserInput->setAttribute('id','username');
$spanUserInput->setAttribute('placeholder','Digita il tuo username');
$spanUserInput->setAttribute('maxlength','30'); /* deve essere uguale alla dimensione dell'attributo nel DB */

$spanPassword = $fieldset->appendChild($doc->createElement('span'));
$spanPassword->setAttribute('id','passwordBox');
$labelPassword = $spanPassword->appendChild($doc->createElement('label'));
$labelPassword->setAttribute('for','password');
$spanPassword2 = $labelPassword->appendChild($doc->createElement('span'));
$spanPassword2->setAttribute('lang','en');
$spanPassword2 = $spanPassword2->appendChild($doc->createTextNode('Password'));
$spanPasswordInput = $spanPassword->appendChild($doc->createElement('input'));
$spanPasswordInput->setAttribute('type','password');
$spanPasswordInput->setAttribute('name','password');
$spanPasswordInput->setAttribute('id','password');
$spanPasswordInput->setAttribute('placeholder','Digita la tua password');
$spanPasswordInput->setAttribute('maxlength','30'); /* deve essere uguale alla dimensione dell'attributo nel DB */

$spanRegister = $fieldset->appendChild($doc->createElement('span'));
$spanRegister->setAttribute('id','registerBox');
$buttonR = $spanRegister->appendChild($doc->createElement('button'));
$buttonR->setAttribute('id','registrati');
$buttonR->setAttribute('aria-label','clicca per registrarti al sito');
$linkRegistrazione = $buttonR->appendChild($doc->createElement('a'));
$linkRegistrazione->setAttribute('href','areaRegistrazione.php');
$linkRegistrazione = $linkRegistrazione->appendChild($doc->createTextNode('registrati'));
$buttonS = $spanRegister->appendChild($doc->createElement('button'));
$buttonS->setAttribute('id','submit');
$buttonS->setAttribute('aria-label','clicca per accedere al sito');
$linkAccesso = $buttonS->appendChild($doc->createElement('a'));
$linkAccesso->setAttribute('href','#'); /* da definire dove l'utente finisce dopo l'accesso */
$linkAccesso = $linkAccesso->appendChild($doc->createTextNode('accedi'));

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>