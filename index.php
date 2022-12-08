<?php
//12 colleghiamo il file del login
require __DIR__ . "/login.php";

//7 nel caso questi dati volessi farli vedere solo a chi fa login inizializzo una session
//8 prima di inizializzare la session, controlliamo non ci sia già una session attiva
if (session_status() === PHP_SESSION_NONE) { //status può dare tre valori= DISABLED, NONE, ACTIVE
    session_start();
}

//PARTE DI CONNESSIONE AL DATABASE
//1 definendo questi dati, andiamo a presentarci al server, indicando i nostri dati
define("DB_SERVERNAME", "localhost:3306"); //inserire porta del server di mysql port in MAMP
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "db_university"); //nome del database cui ci collegheremo

//2 ci connettiamo al database con classe mysqli . Questo è l'ordine richiesto per l'inserimento dei parametri 
$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

//3 controllo nel caso la connessione non sia riuscita
if ($conn && $conn->connect_error) {
    //se c'è un errore di connessione stampa un messaggio e interrompe qui l'esecuzione successiva
    exit("connessione non riuscita");
    //N.B. tra exit() e die() la differrenza è solo semantica 
} //altrimenti procediamo con collegamento a database con le varie query


//PARTE DI LOGIN
// 14
if (isset($_POST["username"]) && isset($_POST["password"])) {
    //15 richiamo la funzione nel file dedicato
    login($_POST["username"], $_POST["password"], $conn);
}

//9 faccio un controllo prima di prelevare tutti i dati
if (isset($_SESSION["userId"]) && $_SESSION["userId"] != 0) {

    //4 prepariamo la query
    $sql = "SELECT * 
            FROM `departments` "; //SENZA I BACKTICK Dà ERRORE boolfalse
    //5 conn ora è un oggetto che abbiamo instanziato
    $result = $conn->query($sql);
    //questo risultato di conn lo salviamo in una variabile result per manipolarlo. 
    var_dump($result); //il risultato sarà un oggetto con molte proprietà. Ciò che mi interessa ora è la riga con numero di dipartimenti(12)


    /*   Per stampare in pagina HTML, questa parte con if e while la sposto in html, 
        i commenti sono gli stessi

        //6 per stamparli uno alla volta userò un while
        //controllo che result esista, cioè non sia null, altrimenti null->num_rows>0 darà errore perchè result non esiste
        //E controllo anche che ci siano righe da stampare

        if ($result && $result->num_rows > 0) {
            //fetch_assoc è una funzione e serve a prendere i risultati da $result, i valori associati
            //con il ciclo while prende ogni volta la riga successiva finchè ce ne sono. Quando non ce ne sono da null, cioè false, e il loop while si interrompe
            while ($row = $result->fetch_assoc()) {
                //la row è un array associativo di valori
                var_dump($row);
            }
        }

    */
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <main>
        <section class="container mt-5">

            <!-- 10 form login -->
            <div class="row">
                <div class="col-7 justify-content-center">
                    <div class="card border-primary mb-3">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form action="index.php" method="POST">
                                <label for="username">Username</label>
                                <input class="form-control" type="text" id="username" name="username">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password">
                                <button class="btn btn-success mt-4">LOGIN</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($result) && $result->num_rows > 0) { ?>
                <h2>Liste</h2>
                <ul class="list-group list-group-flush">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <li class="list-group-item">
                            <h4><?php echo $row["name"]  ?></h4>
                            <h4><?php echo $row["email"] ?></h4>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else if (isset($result) && $result->num_rows === 0) { ?>
                <h3>Non ci sono risultati</h3>
            <?php } ?>
        </section>
    </main>

</body>

</html>