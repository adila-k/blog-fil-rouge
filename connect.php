<?php

try { // Try to connect to database
    $myMysqlConnection = new PDO(
        'mysql:host=localhost; 
        dbname=blog; 
        charset=utf8',
        'root',
        'root');

    $myMysqlConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $error) { // If the connection fails
    exit('Erreur: '.$error->getMessage());
}
