<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Registrazione</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Non perderti le ultime notizie e le nostre recensioni, registrati al mondo videoludico offerto Gameometry", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, registrazione, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Registrazione",$header);
$body->appendChild($doc->createTextNode($header));

//main
$main = $body->appendChild($doc->createElement('main'));

$db=OpenCon();

$query_nrows="SELECT COUNT(*) as nrighe FROM videogioco";
$result=mysqli_query($db,$query_nrows);
$tmparr=$result->fetch_array(MYSQLI_ASSOC);
$n_rows=$tmparr['nrighe'];

mysqli_free_result($result);

$query = "SELECT titolo FROM videogioco";
$result = mysqli_query($db,$query);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);


CloseCon($db);

$labelTitoli = $main->appendChild($doc->createElement('label'));
$t ='';

for ($i = 0; $i < $n_rows; $i++){
    if($i == $n_rows-1){
        $t .= $arr[$i]['titolo'];
    }else{
        $t .= $arr[$i]['titolo'].',';
    }
}

$labelTitoli->appendChild($doc->createTextNode($t));
$labelTitoli->setAttribute('id', 'arrTitoli');

$searchscript = $main->appendChild($doc->createElement('script'));
$searchscript->setAttribute('type','text/JavaScript');
$searchscript->setAttribute('src','Componenti/scriptSearch.js');

$h1 = $main->appendChild($doc->createElement('h1'));
$h1 = $h1->appendChild($doc->createTextNode('REGISTRAZIONE'));

$div = $main->appendChild($doc->createElement('div'));
$div->setAttribute('id','registrazione');

$form = $div->appendChild($doc->createElement('form'));
$form->setAttribute('action','registrazione');

$h2 = $form->appendChild($doc->createElement('h2'));
$h2->setAttribute('id','loginTitle');
$h2 = $h2->appendChild($doc->createTextNode('Registrazione'));

$fieldset = $form->appendChild($doc->createElement('fieldset'));

$spanMail = $fieldset->appendChild($doc->createElement('span'));
$spanMail->setAttribute('id','mailBox');
$labelMail = $spanMail->appendChild($doc->createElement('label'));
$labelMail->setAttribute('for','email');
$spanMail2 = $labelMail->appendChild($doc->createElement('span'));
$spanMail2->setAttribute('lang','en');
$spanMail2 = $spanMail2->appendChild($doc->createTextNode('Email'));
$spanMailInput = $spanMail->appendChild($doc->createElement('input'));
$spanMailInput->setAttribute('type','email');
$spanMailInput->setAttribute('name','email');
$spanMailInput->setAttribute('id','email');
$spanMailInput->setAttribute('placeholder','Digita la tua mail');
$spanMailInput->setAttribute('maxlength','30'); /* deve essere uguale alla dimensione dell'attributo nel DB */

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
$spanUserInput->setAttribute('placeholder','Scegli il tuo username');
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
$spanPasswordInput->setAttribute('placeholder','Scegli la tua password');
$spanPasswordInput->setAttribute('maxlength','30'); /* deve essere uguale alla dimensione dell'attributo nel DB */

$spanRegister = $fieldset->appendChild($doc->createElement('span'));
$spanRegister->setAttribute('id','submitButton');
$buttonR = $spanRegister->appendChild($doc->createElement('button'));
$buttonR->setAttribute('id','register');
$buttonR->setAttribute('aria-label','clicca per registrarti al sito');
$linkRegistrazione = $buttonR->appendChild($doc->createElement('a'));
$linkRegistrazione->setAttribute('href','#');
$linkRegistrazione = $linkRegistrazione->appendChild($doc->createTextNode('registrati'));

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>