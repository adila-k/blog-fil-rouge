<?php
session_start();
include 'connect.php';

$postData = $_POST;
$id = $postData["id"];

// I check ps send by the author
if (!isset($postData['id'])
|| !is_numeric($postData['id'])
|| !isset($postData['titre'])
|| !isset($postData['contenu'])
|| trim(strip_tags($postData['titre'])) === ''
|| trim(strip_tags($postData['contenu'])) === ''
) {
    echo 'Pour pouvoir mettre à jour votre article, il faut renseigner tous les champs : auteur, titre et contenu';
    // Returns false and exit the script
    return;
}

// I need the author to display it
$sqlQueryAuteur = 'SELECT auteur, match_id, image FROM articles_presse WHERE id = :id';
$articles= $myMysqlConnection -> prepare($sqlQueryAuteur);
$articles -> execute(
    [
        "id" => $id,
    ]
    );
$article= $articles -> fetch(PDO::FETCH_ASSOC)
;

// I assign author's ps to variables and secure them
$titre = trim(strip_tags($postData['titre']));
$contenu = trim(strip_tags($postData['contenu']));

// I set match ID in case no match is entered
$match_id = $article["match_id"];
    
// Match datas
// I check if the checkbox is true

$matchArray = [];

if(isset($postData["btn-resultats"]) && $postData["btn-resultats"]){

if(
    !isset($postData["team-1"])
    || !isset($postData["team-2"])
    || !isset($postData["score"])
    || !isset($postData["location"])
    ){
        echo "Tous les champs doivent être renseignés";

// Return false and exit the script
        return;
    }
    
    // And then I clean all datas
    
    $matchdate = trim(strip_tags($postData["matchdate"]));
    $team1 = trim(strip_tags($postData["team-1"]));
    $team2 = trim(strip_tags($postData["team-2"]));
    $score = trim(strip_tags($postData["score"]));
    $location = trim(strip_tags($postData["location"]));
    $resume = trim(strip_tags($postData["resume"]));
    
    // Insert the match in db
    // If there is a match registred, I need its id (it's a FK) to put in on the articles db
    $sqlQueryMatch = 'INSERT INTO resultats_sportifs(equipe1, equipe2, score, resume, lieu, date_match) VALUES (:equipe1, :equipe2, :score, :resume, :lieu, :date_match)';
    
    $insertMatch = $myMysqlConnection -> prepare($sqlQueryMatch);
    $insertMatch -> execute (
        [
            "equipe1" => $team1,
            "equipe2" =>  $team2,
            "score" =>  $score,
            "resume" =>  $resume,
            "lieu" =>  $location,
            "date_match" =>  $matchdate,
        ]
    );
    
    // If a match is registred and has no ID, I get its ID here
    if(!$match_id){
        $match_id = $myMysqlConnection -> lastInsertId();
    }
}


// I update the article
$sqlQuery = "
UPDATE articles_presse
SET titre = :titre, 
contenu = :contenu, 
match_id = :match_id
WHERE id = :id";
$udpateArticle = $myMysqlConnection -> prepare($sqlQuery);
$udpateArticle -> execute(
    [
        "id" => $id,
        "titre" => $titre,
        "contenu" => $contenu,
        "match_id" => $match_id, // will be 0 or id
    ]
);


// upload a image
// I check if a file is sent and is there is no error
if(isset($_FILES["image"]["name"]) && $_FILES["image"]["error"] == 0){

    // if so, check the size
    if($_FILES["image"]["size"] > 10000000){
        echo "Votre image est trop lourde";
        return;
    }

    // Check the format
    $fileInfo = pathinfo($_FILES["image"]["name"]); // pathinfo renvoie un array contenant des infos dont l'extension
    $extension = $fileInfo["extension"]; // renvoie l'extension without a dot
    
    $acceptedExtensions = ["webp", "png", "jpg", "image/jpeg"];

    // I declare a variable to track if the extension is valide
    $validExtension = false;

    foreach($acceptedExtensions as $extensionallowed){

    // If not ok
        if($extension == $extensionallowed){
             $validExtension = true; 
        }
    }
    
    if($validExtension == false){

                echo "Merci de télécharger une image au bon format : .webp, .png, .jpg";
                // exit programm
                return;
            }

        // I check if the upload folder exists

            $path = "assets/img/" ;
            if(!is_dir($path)){
                echo "L'envoi de l'image n'est pas possible, le dossier upload est manquant";
                // exit
                return;
            }
            $imageName = "$id."."$extension";
            // If EVERYTHING is ok, upload the file
                move_uploaded_file($_FILES["image"]["tmp_name"], $path."/".$imageName);

            // And I add the image to articles db

            $sqlQueryImage = "
            UPDATE articles_presse
            SET image = :image
            WHERE id = :id";

            $updateImage = $myMysqlConnection -> prepare($sqlQueryImage);
            $updateImage -> execute(
                [
                    "image" => $imageName,
                    "id" => $id
                ]
            );
}
?>

<!-- Display the updated article -->

    <?php include 'header.php' ?>
    <div>

        <h1>Article modifié avec succès !</h1>

 
<section class="mt-10">
       <!-- Display confirmation -->
        <div class="container m-auto size-fit">

            <div role="alert" class="alert alert-success size-fit mb-10">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>L'article "<?php echo ($titre); ?>" a été mise à jour.</span>
        </div>
        
        <button class="btn btn-info"><a href="article.php?id=<?= $postData["id"]; ?>">Voir l'article</a></button>
        <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à l'accueil</a></button>

        </div>

    </section>



 <?php include 'footer.php' ?>