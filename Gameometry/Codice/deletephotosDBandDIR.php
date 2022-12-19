<?php
include 'Componenti/connect.php';

$dir = scandir("Gameometry/Codice/imgs");
$str = 'imgs/';

echo "\n";
echo "========================================"."\n";
$nomeFile = readline('Inserisci il nome del file da eliminare: ');

/* Parte 1: Query che ricerca il path salvato sul DB e lo elimina dalla cartella imgs locale */

$db1=OpenCon();

$tmpquery= "SELECT imgLocandina as Path FROM videogioco WHERE titolo='$nomeFile'";

$result = mysqli_query($db1,$tmpquery);
$r = mysqli_fetch_all($result,MYSQLI_ASSOC);
$path = $r[0]['Path'];
 
$foo = false;
for($i = 2 ; $i < count($dir) && $foo==false; $i++){
    if(RemoveSpecialChar($dir,$i)==$nomeFile){
        $foo=true;
    }
}

if($foo==true){
    unlink($path);
}

mysqli_free_result($result);
CloseCon($db1);

/* Fine parte 1 */

/* Parte 2: Query che elimina sulla row corrispondente al nome file */

$db2=OpenCon();
$nomeFile=str_replace('locandina ','',$nomeFile);
$query = "DELETE FROM videogioco WHERE titolo='$nomeFile'";
mysqli_query($db2,$query);
CloseCon($db2);

/* Fine Parte 2 */

?>