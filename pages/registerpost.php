<?php

session_start();
include __DIR__.'/../connect.php';
include_once __DIR__."/../functions.php";

// I declare a variable to use $_post easily
$postData = $_POST;

// ? I check data entered by the user

if (!isset($postData['name'])
|| !isset($postData['surname'])
|| !isset($postData['email'])
|| !isset($postData['password'])
|| !isset($postData['role'])
|| trim(strip_tags($postData['name'])) === ''
|| trim(strip_tags($postData['surname'])) === ''
|| trim(strip_tags($postData['email'])) === ''
|| trim(strip_tags($postData['password'])) === ''
) {
    $_SESSION["errorMessage"] = 'Nous n\'avons pas pu valider votre inscription. Veuilez remplir tous les champs';

    // ? Redirect to the page registration
    redirectUrl("register.php");
}


// ? I check if the email is a real email

if(!filter_var(strip_tags($postData['email']), FILTER_VALIDATE_EMAIL )){
    $_SESSION["errorMessage"] = "Nous n\'avons pas pu valider votre inscription. Merci de renseigner une adresse email valide";
    
     // ? Redirect to the page registration
    redirectUrl("register.php");
}


// ? Clean inputs for security purposes

$name = strip_tags($postData['name']);
$surname = strip_tags($postData['surname']);
$email = strip_tags($postData['email']);
$userRole = strip_tags($postData['role']);
$hashPassword = password_hash((strip_tags($postData['password'])), PASSWORD_DEFAULT);

// ? I need to het the last users ID and email (1 unique email is accepted) 
$mysqlQueryId = "SELECT id, email FROM users";
$allUsers = $myMysqlConnection -> prepare($mysqlQueryId);
$allUsers -> execute();

$users = $allUsers -> fetchAll(PDO::FETCH_ASSOC);

$userId = $myMysqlConnection -> lastInsertId();

foreach($users AS $user){
    if($email === $user["email"]){
        $_SESSION["errorMessage"] = "Cet email est déjà enregistré. Nous ne pouvons pas valider votre inscription.";
        
        // ? Redirect to the page registration
    redirectUrl("register.php");
    }
}


$mysqlQuery = "
INSERT INTO users (id, name, surname, email, password, roles_id) 
VALUES (:id, :name, :surname, :email, :password, :roles_id)";

$insertUser = $myMysqlConnection -> prepare($mysqlQuery);
$insertUser -> execute(
    [
        "id" => "$userId",
        "name" => "$name",
        "surname" => "$surname",
        "email" => "$email",
        "password" => "$hashPassword",
        "roles_id" => "$userRole"
    ]
);

$_SESSION["registerSuccess"] = "Bienvenue ".$name." ! Connectez vous pour consulter nos articles.";

 if(isset($_SESSION["registerSuccess"])) {
   redirectUrl("login.php");
 }

 var_dump($postData);
 
?>
