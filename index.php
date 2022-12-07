
<?php
define("DB_SERVERNAME", "localhost:3306"); //inserire porta del server di mysql port in MAMP
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "db_university");


$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
// questo è l'ordine richiesto per l'inserimento dei parametri  

//controllo nel caso la connessione non sia riuscita
if ($conn && $conn->connect_error) {
    //se c'è un errore di connessione stampa un messaggio e interrompe qui l'esecuzione successiva
    exit("connessione non riuscita");
    //N.B. tra exit() e die() la differrenza è solo semantica 
}

//prendiamo la query
$sql = " SELECT * 
        FROM `departments` "; //SENZA I BACKTICK DA ERRORE boolfalse
//conn ora è un oggetto che abbiamo instanziato
$result = $conn->query($sql);
//questo risultato di conn lo salviamo in una variabile result per manipolarlo
var_dump($result); //il risultato sarà un oggetto con molte proprietà. Ciò che mi interessa la riga con numero di dipartimenti(12)

//per stamparli uno alla volta in un html userò un while, previo controllo if che mi assicuri che c'è qualche riga da stampare
//controllo anche che result esista, cioè non sia null, altrimenti null->num_rows>0 darà errore perchè result non esiste
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        var_dump($row);
    }
}

//non ho stampato su html ma solo su pagina html