<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Cours PHP</title>
    <link rel="stylesheet" href="src/css/output.css">
</head>
<body>
        <header class="navbar bg-base-100 shadow-sm">
  <div class="flex-1">
    <a href="index.php" class="btn btn-ghost text-xl">l'histoire d'un blog</a>
  </div>
  <div class="flex-none">
    <ul class="menu menu-horizontal px-1 flex flex-row gap-2">
      <li><a href="index.php">Accueil</a></li>

      <?php if(!isset($_SESSION["loggedUser"])) :  ?>
      <li><button class="btn btn-secondary"><a href="login.php">Se connecter</a></button></li>
      <?php endif; ?>
      <?php if(isset($_SESSION["loggedUser"])) :  ?>
      <li><button class="btn btn-secondary"><a href="logout.php">Se déconnecter</a></button></li>
      <?php endif; ?>
      <li><button class="btn btn-soft btn-accent"><a href="register.php">S'inscrire</a></button></li>
    </ul>
  </div>
  
</header>

<main>