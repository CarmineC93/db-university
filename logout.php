<?php
//18 creo su file dedicato la funzionalità del logout

echo "logout";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["logout"]) && $_POST["logout"] === "1") {
    session_destroy();
    session_unset();
    //prima chiudiamo la sessione e poi riportiamo l'utente sul form di login che è nella pagina index.php
    header('localiton: index.php');
}
