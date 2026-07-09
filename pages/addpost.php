<?php
session_start();
include __DIR__.'/../connect.php';

// I declare a variable to use $_POST easily
$postData = $_POST;
$imageName = null;

// I need author id and name to add a post
$authorName = $_SESSION["loggedUser"]["name"]." ".$_SESSION["loggedUser"]["surname"];
$authorid = $_SESSION["loggedUser"]["id"];

// I check inputs send by the author
if (!isset($postData['titre'])
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
    
    // * Insert the match in db
    // ? If there is a match registred, I need its id (it's a FK) to put in on the articles db
    $sqlQueryMatch = 'INSERT INTO matches (team1, team2, score, summary, location, date) VALUES (:team1, :team2, :score, :summary, :match_location, :date)';
    
    $insertMatch = $myMysqlConnection -> prepare($sqlQueryMatch);
    $insertMatch -> execute (
        [
            "team1" => $team1,
            "team2" =>  $team2,
            "score" =>  $score,
            "summary" =>  $resume,
            "location" =>  $location,
            "date" =>  $matchdate,
        ]
    );
    
    // If a match is registred, I get its ID here
    $match_id = $myMysqlConnection -> lastInsertId();
}

$datePublication = date('Y-m-d');
								
// Insert the article is db
$sqlQueryArticle = 'INSERT INTO articles (title, content, users_id, date_publication, match_id) VALUES (:title, :content, :users_id, :date_publication, :match_id)';
$insertcontent = $myMysqlConnection->prepare($sqlQueryArticle);
$insertcontent->execute(
    [
        'title' => $titre,
        'content' => $contenu,
        'date_publication' => $datePublication,
        'match_id' => $match_id, // will be 0 or id
        "users_id" => "$authorid"
    ]
);

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
            $path = __DIR__ . "/../public/assets/img";
            if(!is_dir($path)){
                echo "L'envoi de l'image n'est pas possible, le dossier upload est manquant";
                // exit
                return;
            }
            $imageName = "$article_id."."$extension";
            // If EVERYTHING is ok, upload the file
                move_uploaded_file($_FILES["image"]["tmp_name"], $path."/".$imageName);
}

else{
    $imageName = "default-img.jpg";
}

 // And I add the image to articles db
            $sqlQueryImage = "
            UPDATE articles
            SET image = :image
            WHERE id = :id";

            $updateImage = $myMysqlConnection -> prepare($sqlQueryImage);
            $updateImage -> execute(
                [
                    "image" => $imageName,
                    "id" => $article_id
                ]
            );

?>
<!-- I display the confirmation message -->

    <?php include __DIR__.'/../components/header.php'; ?>
<section class="flex flex-col">

            <!-- 
            ==============================
            == CONFIRMATION PUBLICATION ==
            ==============================
            -->
                <div role="alert" class="alert alert-success size-fit mb-10 self-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Article rajouté</span>
        </div>

        <div>
            <!-- I display the title -->
                <div><h1><?php echo $titre; ?></h1></div>
                <!-- I display the author -->
                <div class="uppercase text-slate-500"><h5>par <?php echo $auteur; ?></h3></div>
             <p>Publié le <?=  $datePublication;?></p>


                <!-- Get image path  -->
                <?php $path = "/blog/public/assets/img/"; ?>
                <div class="h-150 overflow-hidden flex flex-col justify-center my-10"><img src="<?=  $path.$imageName ; ?>" class="object-fit"/></div>

                <!-- I display the content -->
                <div class="justify"><p><?php echo $contenu; ?></p></div>

        </div>
        <button class="btn btn-soft btn-secondary size-fit self-center"><a href="/blog/public/index.php">Retour à l'accueil</a></button>
</section>

<?php include __DIR__.'/../components/footer.php';  ?>
