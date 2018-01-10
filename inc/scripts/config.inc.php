<?php

if (stristr($_SERVER['HTTP_HOST'], 'local') || (substr($_SERVER['HTTP_HOST'],
            0, 7) == '192.168')) {
    $blnLocal = TRUE;
} else {
    $blnLocal = FALSE;
}
// Selon l'environnement d'exécution (développement ou production)
if ($blnLocal) {
    $host = 'localhost';
    $BD = '17_pni1_OFF';
    $user = 'krystinahamel';
    $password = 'cacacul123';
} else {
    $host = 'timunix2.cegep-ste-foy.qc.ca';
    $BD = '17_pni1_OFF';
    $user = '17_etudiant_2eme';
    $password = 'temp';
}
//Data Source Name pour l'objet PDO
$dsn = 'mysql:dbname='.$BD.';host='.$host;
//Tentative de connexion
$pdoConnexion = new PDO($dsn, $user, $password);
//Changement d'encodage de l'ensemble des caractères pour UTF-8
$pdoConnexion->exec("SET CHARACTER SET utf8");
//Pour obtenir des rapports d'erreurs et d'exception avec errorInfo()
$pdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);