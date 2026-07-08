<?php
include 'connect.php';

// I declare a variable to use $_POST easily
$postData = $_POST;
$imageName = null;

// I check inputs send by the author
if (!isset($postData['auteur'])
|| !isset($postData['titre'])
|| !isset($postData['contenu'])
|| trim(strip_tags($postData['auteur'])) === ''
|| trim(strip_tags($postData['titre'])) === ''
|| trim(strip_tags($postData['contenu'])) === ''
) {
    echo 'Pour pouvoir poster votre article, il faut renseigner tous les champs : auteur, titre et contenu';

    // Return false and exit the script
    return;
}

// I assign author's inputs to variables and secure them
$titre = trim(strip_tags($postData['titre']));
$auteur = trim(strip_tags($postData['auteur']));
$contenu = trim(strip_tags($postData['contenu']));

// I set match ID in case no match is entered
$match_id = null;
    

// Match datas
// I check if the checkbox is true
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
    
    // If a match is registred, I get its ID here
    $match_id = $myMysqlConnection -> lastInsertId();
}


// I need the article ID to add an image
$article_id = $myMysqlConnection -> lastInsertId();

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
            $path = "assets/img/";
            if(!is_dir($path)){
                echo "L'envoi de l'image n'est pas possible, le dossier upload est manquant";
                // exit
                return;
            }
            $imageName = "$article_id."."$extension";
            // If EVERYTHING is ok, upload the file
                move_uploaded_file($_FILES["image"]["tmp_name"], $path."/".$imageName);

            // And I add the image to articles db

            $sqlQueryImage = "
            INSERT INTO articles_presse(image)
            VALUES (:image)";

            $updateImage = $myMysqlConnection -> prepare($sqlQueryImage);
            $updateImage -> execute(
                [
                    "image" => $imageName,
                    "id" => $article_id
                ]
            );
}


// Insert the article is db
$sqlQueryArticle = 'INSERT INTO articles_presse(titre, contenu, auteur, date_publication, match_id, image) VALUES (:titre, :contenu, :auteur, :date_publication, :match_id, :image)';
$insertcontent = $myMysqlConnection->prepare($sqlQueryArticle);
$insertcontent->execute(
    [
        'titre' => $titre,
        'auteur' => $auteur,
        'contenu' => $contenu,
        'date_publication' => date('Y-m-d'),
        'match_id' => $match_id, // will be 0 or id
        'image' => $imageName
    ]
);


?>
<!-- I display the confirmation message -->

    <?php include 'header.php' ?>
<section>
        <h1>Article rajouté</h1>

        <div>
            <!-- I display the title -->
<div><h3><?php echo $titre; ?></h3></div>
<!-- I display the author -->
<div><h5>by <?php echo $auteur; ?></h3></div>
<!-- I display the message -->
<div><p><?php echo $contenu; ?></p></div>

        </div>
        <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à l'accueil</a></button>
</section>

<?php include 'footer.php' ?>
