
<?php
//11 creo una funzione per il login in un file dedicato
function login($username, $password, $conn)
{
    //passiamo la password nella funzione dell'algoritmo md5
    $md5password = md5($password);
    //ora controlliamo se l'utente del login è autorizzato, cioè se quell username e password sono nel database.Lo facciamo con un a query
    $sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$md5password' ";
    $result = $conn->query($sql);
}
