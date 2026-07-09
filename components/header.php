<?php 

// * To avoid this error : "Notice: session_start(): Ignoring session_start() because a session is already active (started from /Applications/MAMP/htdocs/blog/index.php on line 2) in /Applications/MAMP/htdocs/blog/header.php on line 2"
if(session_status() === PHP_SESSION_NONE) {
  session_start();
  }
  
  include __DIR__ .'../../connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Cours PHP</title>
    <link rel="stylesheet" href="/blog/public/assets/src/css/output.css">
</head>
<body class="flex flex-col justify-stretch items-center">
        <header class="navbar bg-base-100 shadow-sm flex flex-row justify-between px-10">
  <div>
    <a href="/blog/public/index.php" class="btn btn-ghost text-xl">l'histoire d'un blog</a>
  </div>

  <div class="header__navbar flex flex-row gap-4 items-center">

    <ul class="menu menu-horizontal px-1 flex flex-row gap-2">
      <li><a href="/blog/public/index.php">Accueil</a></li>

      <?php if(!isset($_SESSION["loggedUser"])) :  ?>
      <li><button class="btn btn-secondary"><a href="/blog/pages/login.php">Se connecter</a></button></li>
      <?php endif; ?>
      <?php if(isset($_SESSION["loggedUser"])) :  ?>
      <li><button class="btn btn-secondary"><a href="/blog/pages/logout.php">Se déconnecter</a></button></li>
      <?php endif; ?>
      <?php if(!isset($_SESSION["loggedUser"])) :  ?>
      <li><button class="btn btn-soft btn-accent"><a href="/blog/pages/register.php">S'inscrire</a></button></li>
      <?php endif; ?>
    </ul>

     <?php if(isset($_SESSION["loggedUser"])) :  ?>
    <!-- Avatar  -->
      <div>
          <div class="avatar avatar-online">
          <div class="w-8 rounded-full">
            <img src="https://img.daisyui.com/images/profile/demo/gordon@192.webp" />
          </div>
          </div>
          <?=  $_SESSION["loggedUser"]["name"]; ?>
        </div>
        <?php endif; ?>

  </div>
 
  
</header>

<main>