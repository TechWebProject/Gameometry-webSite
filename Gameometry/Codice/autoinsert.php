<?php
include 'Componenti/connect.php';

$dir = scandir("Gameometry/Codice/Locandine");
$str = 'Locandine/';

$db1=OpenCon();

$tmpquery= "SELECT COUNT(*) as Conto FROM videogioco";

$result = mysqli_query($db1,$tmpquery);

$r = mysqli_fetch_all($result,MYSQLI_ASSOC);

$count = $r[0]['Conto']; //Perchè è scritto in JSON e prima legge la riga [0] array e poi entra li e quindi gli fai leggere una cella che contiene, in questo caso 'Conto'

//echo $count." righe";    <--- in caso di debug

mysqli_free_result($result); //liberare il risultato dalla memoria
CloseCon($db1); //Chiudo la connessione per quella query

$db2 = OpenCon(); //Apro nuova connessione col db per questa nuova tipo di query

for($i = $count+2 ; $i < count($dir); $i++){
    $res = $str.$dir[$i];
    $trimmedword = RemoveSpecialChar($dir,$i);
    $trimmedword = str_replace('locandina ','',$trimmedword);
    $trimmedword= mysqli_real_escape_string($db2,$trimmedword);
    $res = mysqli_real_escape_string($db2,$res);
    $query = "INSERT INTO videogioco (titolo,imgLocandina) VALUES ('$trimmedword','$res')";
    $useless=mysqli_query($db2,$query);
}

CloseCon($db2);

?>