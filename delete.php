<?php

include 'connect.php';

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

$sqlQuery = "SELECT titre, contenu FROM articles_presse WHERE id = :id";
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

       <?php include 'header.php' ?>
    <section>
        <h1>Vous êtes sûr de vouloir supprimer l'article :  <?= $article["titre"]; ?> ?</h1>

        <form action="delete-post.php" method="POST">

    

         <button type="submit" class="btn"><a href=" delete-post.php?id=<?= ($getData["id"])?> ">OUI</a></button>
         <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à la page d'accueil</a></button>

        </form>
    </section>

     <?php include 'footer.php' ?>