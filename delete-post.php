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

// I get datas from the article to display title

$sqpQuery = "
DELETE FROM articles_presse WHERE id = :id";
$deleteArticle = $myMysqlConnection -> prepare($sqpQuery);

// I get the id
$deleteArticle -> execute (
    [
        "id" => $getData["id"],
    ]
);
?>
    <?php include 'header.php' ?>
    <section class="mt-10">
       <!-- Display confirmation -->
        <div class="container m-auto size-fit">

            <div role="alert" class="alert alert-success size-fit mb-10">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>L'article <?php echo $getData["id"] ?> a été supprimé avec succès.</span>
        </div>
        
        <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à l'accueil</a></button>

        </div>

    </section>

<?php include 'footer.php' ?>