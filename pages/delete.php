<?php
session_start();
include __DIR__.'/../connect.php';

// I declare a variable to use $_GET easily
$getData = $_GET;

// I check if I get an id
if(!isset($getData["id"]) || !is_numeric($getData["id"]))
    {
        // If not, print the error message...
        echo "L'id est nécessaire pour la suppression de l'article";
        // ... and exit the script
        return;
    }

$sqlQuery = "SELECT title, content FROM articles WHERE id = :id";
$articles = $myMysqlConnection -> prepare($sqlQuery);
$articles -> execute(
[
    "id" => (int)$getData["id"] // here I get the id
]
);

$article = $articles -> fetch(PDO::FETCH_ASSOC);
    // with PDO::FETCH_ASSOC I'll get 
    // ["titre" => "...", "auteur" => "...", "contenu" => "..."]
    // Easier to access values

    
?>

    <!-- Display the article -->

      <?php include __DIR__.'/../components/header.php'; ?>
    <section class="h-full flex flex-col items-center justify-stretch">
        <h1>Vous êtes sûr de vouloir supprimer l'article :  <?= $article["title"]; ?> ?</h1>

        <form action="deletepost.php" method="POST">

    

         <button type="submit" class="btn"><a href=" deletepost.php?id=<?= ($getData["id"])?> ">OUI</a></button>
         <button class="btn btn-soft btn-secondary"><a href="../public/index.php">Retour à la page d'accueil</a></button>

        </form>
    </section>

 <?php include __DIR__.'/../components/footer.php';  ?>