<?php
require_once "template.php";

$template = new template();
$template->setPage("modificaUtente.html");
$modificaUtente = $template->initializePage();

$modificaUtente = str_replace("Titolo_pagina","Gestione Utente | Gameometry",$modificaUtente);
$modificaUtente = str_replace("parole_chiave", "gameometry, accesso, login, videogioco, videogiochi, utente, recensioni", $modificaUtente);
$modificaUtente = str_replace("descrizione","Pagina dedicata alla modifica della propria area personale di Gameometry", $modificaUtente);

if(isset($_SESSION['username'])){
    $modificaUtente = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $modificaUtente);
}

$modificaUtente = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; <a href=\"areaUtente.php\">Area riservata</a> &raquo; Modifica profilo</p>", $modificaUtente);

if(isset($_POST['modifyButton']) && $_POST['username']!="" && $_POST['password']!=""){
    $email = $_SESSION['email'];
    $inputNickname = $_POST['username'];
    $inputPassword = $_POST['password'];

    $db=OpenCon();

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
        $modificaUtente = str_replace("<span id=\"errorUsernameRegister\"></span>","<span id=\"errorUsernameRegister\">".$spanUsernameMessage."</span>",$modificaUtente);
    }
    else {
        $query_check_nickname="SELECT * FROM utente WHERE utente.nickname='$inputNickname'";
        $result_nickname=mysqli_query($db,$query_check_nickname);
        $nicknameOK=$result_nickname->fetch_array(MYSQLI_ASSOC);
        if(isset($nicknameOK)){
            $spanUsernameMessage = "Nickname già in uso nel sistema";
            $modificaUtente = str_replace("<span id=\"errorUsernameRegister\"></span>","<span id=\"errorUsernameRegister\">".$spanUsernameMessage."</span>",$modificaUtente);
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
        $modificaUtente = str_replace("<span id=\"errorPasswordRegister\"></span>","<span id=\"errorPasswordRegister\">".$spanPasswordMessage."</span>",$modificaUtente);
    }

    //aggiornamento del DB
    if($correctNickname && $correctPassword){
        $oldNickname = $_SESSION['username'];
        $modifyUser="UPDATE utente SET nickname='$inputNickname', password='$inputPassword' WHERE utente.nickname='$oldNickname'";
        $resultUpdate=mysqli_query($db,$modifyUser);

        $_SESSION['username'] = $inputNickname;


        CloseCon($db);

        header("Location: areaUtente.php");
    }
    else {
        CloseCon($db);
    }
}
else if(isset($_POST['modifyButton'])) {
    $spanGeneralMessage = "Tutti i campi devono essere compilati";
    $modificaUtente = str_replace("<span id=\"errorGeneralRegister\"></span>","<span id=\"errorGeneralRegister\">".$spanGeneralMessage."</span>",$modificaUtente);
}

echo $modificaUtente;

?>