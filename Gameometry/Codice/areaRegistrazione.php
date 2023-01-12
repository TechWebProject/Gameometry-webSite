<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
session_start();
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
if(isset($_SESSION['username'])){
    $header = str_replace('<a id="areaRiservata" href="areaLogIn.php">','<a id="areaRiservata" href="areaUtente.php">',$header);
}
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
$div->setAttribute('id','mainRegistrazione');

$form = $div->appendChild($doc->createElement('form'));
$form->setAttribute('action','areaRegistrazione.php');
$form->setAttribute('method','POST');

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
$spanMailInput->setAttribute('maxlength','100'); 

$spanMailMessage = $fieldset->appendChild($doc->createElement('span'));
$spanMailMessage->setAttribute('id','errorEmailRegister');

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
$spanUserInput->setAttribute('maxlength','30'); 

$spanUsernameMessage = $fieldset->appendChild($doc->createElement('span'));
$spanUsernameMessage->setAttribute('id','errorUsernameRegister');

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
$spanPasswordInput->setAttribute('maxlength','12'); 

$spanPasswordMessage = $fieldset->appendChild($doc->createElement('span'));
$spanPasswordMessage->setAttribute('id','errorPasswordRegister');

$spanGeneralMessage = $fieldset->appendChild($doc->createElement('span'));
$spanGeneralMessage->setAttribute('id','errorGeneralRegister');

$spanRegister = $fieldset->appendChild($doc->createElement('span'));
$spanRegister->setAttribute('id','submitButton');
$buttonR = $spanRegister->appendChild($doc->createElement('button'));
$buttonR->setAttribute('id','register');
$buttonR->setAttribute('type','submit');
$buttonR->setAttribute('name','registerButton');
$buttonR->setAttribute('aria-label','clicca per registrarti al sito');
$buttonR->appendChild($doc->createTextNode('REGISTRATI')); 

if(isset($_POST['registerButton']) && $_POST['email']!="" && $_POST['username']!="" && $_POST['password']!=""){
    $inputEmail = $_POST['email'];
    $inputNickname = $_POST['username'];
    $inputPassword = $_POST['password'];

    $db=OpenCon();

    $query_check_email="SELECT * FROM utente WHERE utente.email='$inputEmail'";
    $result_email=mysqli_query($db,$query_check_email);
    $emailOK=$result_email->fetch_array(MYSQLI_ASSOC);

    //controllo email --> i caratteri vengono controllati dal tag
    $correctEmail = true;
    if(isset($emailOK)){
        $correctEmail = false;
        $spanMailMessage->appendChild($doc->createTextNode('Email già utilizzata'));
    }

    //controllo del nickname
    $testNickName = str_split($inputNickname);
    $correctNickname = true;

    $notAllowed = array(" ","'","?","!","$");

    foreach($testNickName as $test){
        if(in_array($test, $notAllowed)){
            $correctNickname = false;
        }
    }

    if($correctNickname==false){
        $spanUsernameMessage->appendChild($doc->createTextNode('Sintassi del nickname errata'));
    }
    else {
        $query_check_nickname="SELECT * FROM utente WHERE utente.nickname='$inputNickname'";
        $result_nickname=mysqli_query($db,$query_check_nickname);
        $nicknameOK=$result_nickname->fetch_array(MYSQLI_ASSOC);
        if(isset($nicknameOK)){
            $spanUsernameMessage->appendChild($doc->createTextNode('Nickname già in uso nel sistema'));
        } 
    }

    //controllo della password
    $testPassword = str_split($inputPassword);
    $correctPassword = true;

    $passwordNotAllowed = array(" ","'",'"');

    foreach($testPassword as $test){
        if(in_array($test, $passwordNotAllowed)){
            $correctPassword = false;
        }
    }

    if($correctPassword==false){
        $spanPasswordMessage->appendChild($doc->createTextNode('Non è possibile utilizzare spazi, '."' ". 'o "'));
    }

    //controllo validità sul DB
    if($correctEmail && $correctNickname && $correctPassword){
        $currentDate = date("Y-m-d");
        $insertUser="insert into utente (email, nickname, password, dataIscrizione) values ('$inputEmail', '$inputNickname', '$inputPassword', '$currentDate')";
        $resultInsert=mysqli_query($db,$insertUser);

        $spanGeneralMessage->appendChild($doc->createTextNode('Utente correttamente registrato'));
    }

    mysqli_free_result($result);

    CloseCon($db);
}
else if(isset($_POST['registerButton'])) {
    $spanGeneralMessage = $spanGeneralMessage->appendChild($doc->createTextNode('Tutti i campi devono essere compilati'));
}

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>