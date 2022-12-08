
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//11 creo una funzione per il login in un file dedicato
function login($username, $password, $conn)
{
    //passiamo la password nella funzione dell'algoritmo md5
    $md5password = md5($password);

    //ora controlliamo se l'utente del login è autorizzato, cioè se quell username e password sono nel database.Lo facciamo con una query

    //METODO SBAGLIATO E HACKERABILE
    /*  $sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$md5password' ";
            $result = $conn->query($sql);*/

    //METODO CORRETTO E SICURO
    //impedisce all'utente malintenzionato di passare codice direttamente nella query che ora sarà prima uno statement, una stringa
    //prepariamo lo statement 
    $stmt  = $conn->prepare("SELECT * 
                            FROM `users` 
                            WHERE `username` = ? AND `password` = ? "); //i ? sono segnaposti
    //ora sostituiamo i segnaposto con funzione bind_params il cui primo paramatro è il tipo di dato passato (s=string, d=numero) 
    $stmt->bind_param('ss', $username, $md5password);
    $stmt->execute();
    $result = $stmt->get_result();
    var_dump($result);

    //se abbiamo un risultato il login ha funzionato
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        var_dump($user);
        $_SESSION["userId"] = $user["id"];
        $_SESSION["username"] = $user["username"];
    } else {
        $_SESSION["userId"] = 0;
        $_SESSION["username"] = "";
    }
}
