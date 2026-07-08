<?php
session_start(); 
  include "connect.php";
  require_once "functions.php";

  $postData = $_POST;
  unset($_SESSION['loggedUser']); 
  unset($_SESSION["loginSuccess"]); 
  unset($_SESSION["errorMessage"]); // I need to remove all datas from session to prevent persistance des datas


    // * I need to import datas from my db
$sqlQuery = "
SELECT * FROM administrateurs";
$allUsers = $myMysqlConnection -> prepare($sqlQuery);
$allUsers -> execute();

$users = $allUsers -> fetchAll(PDO::FETCH_ASSOC);
    // * with PDO::FETCH_ASSOC I'll get 
    // * ["titre" => "...", "auteur" => "...", "contenu" => "..."]
    // * Easier to access values

  // If inputs are given
  if(isset($postData["email"]) && isset($postData["password"])){

  // * Check if the email is an real email
    if(!filter_var($postData["email"], FILTER_VALIDATE_EMAIL)){
      $_SESSION["errorMessage"] = "Merci de renseigner une adresse email valide";
    }

    // * If the email is valid
    else {
      // I compare user inputs with datas from the db
      foreach($users AS $user){
        if(password_verify($postData["password"], $user["password_hash"]) && $postData["email"] === $user["email"])
          {
            // If true I store the email to loggedUser array
            $_SESSION['loggedUser'] = [
              "email" => $user["email"],
              "login" => $user['login']
            ];
        
          }
          }
          
          if(!isset($_SESSION['loggedUser'])){
            $_SESSION["errorMessage"] = "Les informations ne nous permettent pas de vous identifier.";
            }
            else{
            $_SESSION["loginSuccess"] = "Bienvenue " .$_SESSION['loggedUser']["login"];

            }
    }
  }

 if(isset($_SESSION['loggedUser'])) {

   redirectUrl("index.php");
 }
?>

<?php 
include 'header.php' ?>
<section class="flex flex-col items-center">

<?php if(!isset($_SESSION['loggedUser'])):  ?>
    <div class="error-container flex flex-col items-center gap-10">


        <div role="alert" class="alert alert-error size-fit">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span><?php echo $_SESSION["errorMessage"]?></span>
        </div>
        
        <form action="login-submit.php" method="POST" class="flex flex-col items-start gap-4">
        
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
          <legend class="fieldset-legend">Accéder à mon espace abonné</legend>
        
          <label class="label">Email</label>
          <input type="email" class="input" name="email" placeholder="Votre email" required/>
        
          <label class="label">Password</label>
          <input type="password" class="input" name="password" placeholder="Password" required/>
        
          <button class="btn btn-secondary mt-4">Se connecter</button>
        </fieldset>
        
        </form>
        
         <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à l'accueil</a></button>

    </div>
    <?php endif; ?>

</section>

<?php include 'footer.php' ?>