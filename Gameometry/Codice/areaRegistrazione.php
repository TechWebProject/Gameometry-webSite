<?php
require_once "template.php";

$template = new template();
$template->setPage("areaRegistrazione.html");
$areaRegistrazione = $template->initializePage();

$areaRegistrazione = str_replace("Titolo_pagina","Registrazione | Gameometry",$areaRegistrazione);
$areaRegistrazione = str_replace("parole_chiave", "gameometry, registrazione, videogioco, videogiochi, utente, recensioni", $areaRegistrazione);
$areaRegistrazione = str_replace("descrizione","Non perderti le ultime notizie e le nostre recensioni, registrati al mondo videoludico offerto da Gameometry!", $areaRegistrazione);

$areaRegistrazione = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; Registrazione</p>", $areaRegistrazione);

if(isset($_POST['registerButton']) && $_POST['email']!="" && $_POST['username']!="" && $_POST['password']!=""){
    $inputEmail = $_POST['email'];
    $inputNickname = $_POST['username'];
    $inputPassword = $_POST['password'];

    $db=OpenCon();

    $query_check_email="SELECT * FROM utente WHERE utente.email='$inputEmail'";
    $result_email=mysqli_query($db,$query_check_email);
    $emailOK=$result_email->fetch_array(MYSQLI_ASSOC);

    //controllo email
    $correctEmail = true;
    if(!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
        $spanMailMessage = "Sintassi email errata";
        $areaRegistrazione = str_replace("<span id=\"errorEmailRegister\"></span>","<span id=\"errorEmailRegister\">".$spanMailMessage."</span>",$areaRegistrazione);
        $correctEmail=false;
    }

    if(isset($emailOK)){
        $correctEmail = false;
        $spanMailMessage = "Email già utilizzata";
        $areaRegistrazione = str_replace("<span id=\"errorEmailRegister\"></span>","<span id=\"errorEmailRegister\">".$spanMailMessage."</span>",$areaRegistrazione);
    }

    //controllo del nickname
    $testNickName = str_split($inputNickname);
    $correctNickname = true;

    $notAllowed = array(" ","'","\"","?","!","$","~",">","<",",","|","\\",";","}","{","=","+","(",")","*","&","^","%","#","@","`");

    foreach($testNickName as $test){
        if(in_array($test, $notAllowed)){
            $correctNickname = false;
        }
    }

    if($correctNickname==false){
        $spanUsernameMessage = "Sintassi del nickname errata";
        $areaRegistrazione = str_replace("<span id=\"errorUsernameRegister\"></span>","<span id=\"errorUsernameRegister\">".$spanUsernameMessage."</span>",$areaRegistrazione);
    }
    else {
        $query_check_nickname="SELECT * FROM utente WHERE utente.nickname='$inputNickname'";
        $result_nickname=mysqli_query($db,$query_check_nickname);
        $nicknameOK=$result_nickname->fetch_array(MYSQLI_ASSOC);
        if(isset($nicknameOK)){
            $spanUsernameMessage = "Nickname già in uso nel sistema";
            $areaRegistrazione = str_replace("<span id=\"errorUsernameRegister\"></span>","<span id=\"errorUsernameRegister\">".$spanUsernameMessage."</span>",$areaRegistrazione);
        } 
    }

    //controllo della password
    $testPassword = str_split($inputPassword);
    $correctPassword = true;

    $passwordNotAllowed = array(" ","'","\"","$","~",">","<",",","|","\\",";","}","{","=","+","(",")","*","&","^","%","#","@","`","-","_");

    foreach($testPassword as $test){
        if(in_array($test, $passwordNotAllowed)){
            $correctPassword = false;
        }
    }

    if($correctPassword==false){
        $spanPasswordMessage = "Non è possibile utilizzare spazi o singoli/doppi apici";
        $areaRegistrazione = str_replace("<span id=\"errorPasswordRegister\"></span>","<span id=\"errorPasswordRegister\">".$spanPasswordMessage."</span>",$areaRegistrazione);
    }

    //controllo validità nel DB
    if($correctEmail && $correctNickname && $correctPassword){
        $currentDate = date("Y-m-d");
        $insertUser="insert into utente (email, nickname, password, dataIscrizione) values ('$inputEmail', '$inputNickname', '$inputPassword', '$currentDate')";
        $resultInsert=mysqli_query($db,$insertUser);

        $spanGeneralMessage = "Utente correttamente registrato";
        $areaRegistrazione = str_replace("<span id=\"errorGeneralRegister\"></span>","<span id=\"errorGeneralRegister\">".$spanGeneralMessage."</span>",$areaRegistrazione);

        $linkAccesso = "<p id=\"linkRegistrazione\"><a href=\"areaLogIn.php\">Accedi ora!</a></p>";
        $areaRegistrazione = str_replace("</LINK_ACCESSO>",$linkAccesso,$areaRegistrazione);
    }

    CloseCon($db);
}
else if(isset($_POST['registerButton'])) {
    $spanGeneralMessage = "Tutti i campi devono essere compilati";
    $areaRegistrazione = str_replace("<span id=\"errorGeneralRegister\"></span>","<span id=\"errorGeneralRegister\">".$spanGeneralMessage."</span>",$areaRegistrazione);
}

echo $areaRegistrazione;

?>