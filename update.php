<?php

include 'connect.php';

// I declare a variable to use $_GET easily
$getData = $_GET;

// I check if I get an id
if(isset($getData["id"]) && !is_numeric($getData["id"]))
    {
        // If not, print the error message...
        echo "L'id est nécessaire pour la modification de l'article";
        // ... and exit the script
        return;
    }


    // I write my query request to retrieve content of the article
    $articleSqlQuery = "SELECT ap.id, titre, contenu, auteur, image, rs.score, rs.equipe1, rs.equipe2, rs.lieu, rs.resume, rs.date_match
    FROM articles_presse as ap
    LEFT JOIN resultats_sportifs AS rs ON ap.match_id = rs.id
    WHERE ap.id = :id"; 
    
    
    // :id is a placeholder for a value that is used in PHP (revoir la déf)
    $articleRetrieved = $myMysqlConnection -> prepare($articleSqlQuery);
    $articleRetrieved -> execute(
        [
            "id" => (int)$getData["id"] // here I get the id
        ]
    );
    $article = $articleRetrieved -> fetch(PDO::FETCH_ASSOC);
    // with PDO::FETCH_ASSOC I'll get 
    // ["titre" => "...", "auteur" => "...", "contenu" => "..."]
    // Easier to access values

// I check if the article exists
if(!$article){
    echo "Article introuvable. Vérifier l'id renseigné";
    return;
    }

    ?>

    <!-- Display the article -->

    <?php include 'header.php' ?>
    <section>
        <h1 class="text-center mb-10 mt-5">Mettre à jour l'article : <?= $article["titre"]; ?></h1>

        <form action="update-post.php" method="POST" enctype = "multipart/form-data" class="border border-black p-2 rounded-xl w-200 h-auto flex flex-col gap-4 m-auto px-15 py-10">


            <div class="hidden">
                <label for="id">Identitifiant de l'article</label>
                <input type="text" id="id" name="id" value="<?= $getData["id"]; ?>" class="input">
            </div>
            <!-- Title -->
            <div class="title flex-row-w ">
                <label for="titre">Titre</label>
                
                <input type="text" value="<?= $article["titre"]; ?>" name="titre" class="input">
            </div>
            <div class="auteur flex-row-w">
                <p>Article rédigé par
            <?= $article["auteur"]; ?></p>
            </div>
            <!-- Contenu -->
            <div class="contenu flex-row-w ">
                <label for="contenu">Contenu</label>
                <textarea name="contenu" id="contenu" class="h-150 input text-wrap"><?= $article["contenu"]; ?></textarea>
            </div>
            <!-- Image -->
             <div class="image flex flex-col">
                 <div class="dl-img flex-row-w ">
                     <label for="image">Image</label>
                     <input type="file" name="image" id="image" accept=".webp, .png, .jpg, image/jpeg" class="input">
                </div>
                <div class="hidden-image flex flex-col items-center mt-10">
                        <!-- To display the image -->
                        <?php 
                        $imagePath = "assets/img/" . $article["image"];
                        ?>
                        <?php if($article["image"] != null) : ?>
                        <p>Image actuelle :</p>
                        <div class="h-100 overflow-hidden">
                            <img src="<?= $imagePath ?>" class="h-full object-cover"/>
                        </div>
                        <?php endif; ?>
    
                </div>
             </div>

            <!-- Inpputs to add a mtach -->
             <div class="flex- flex-row justify-center">
                <label for="resultats">Souhaitez-vous ajouter les résultats du match ?</label>
                <input type="checkbox" id="btn-resultats" name="btn-resultats" class="size-fit">
                </div>
                <div class="hidden">
                    <label for="id_match">Id du match</label>
                    <input type="id_match" name="id_match" id="id_match" class="bg-slate-100"value="<?= $article["id"]; ?>" disabled class="input">
                </div>
                        <div class="hidden input-resultat">

                            
                            <div class="flex-row-w ">
                                <label for="matchdate" >Date du match</label>
                                <input type="date" name="matchdate" id="matchmdate" value="<?= $article["date_match"]; ?>"  class="input">
                            </div>
                            <div class="flex-row-w ">
                                <label for="team-1">Équipe 1</label>
                                <input type="text" name="team-1" id="team1" value="<?= $article["equipe1"]; ?>"  class="input">
                            </div>
                            <div class="flex-row-w ">
                                <label for="team-2">Équipe 2</label>
                                <input type="text" name="team-2" id="team2" value="<?= $article["equipe2"]; ?>"  class="input">
                            </div>
                            <div class="flex-row-w ">
                                <label for="score">Score du match (0 - 0)</label>
                                <input type="text" name="score" id="score" value="<?= $article["score"]; ?>"  class="input">
                            </div>
                            <div class="flex-row-w ">
                                <label for="location">Lieu</label>
                                <input type="text" name="location" id="location" value="<?= $article["lieu"]; ?>"  class="input">
                            </div>
                            <div class="flex-row-w ">
                                <label for="resume">Résumé</label>
                                <textarea name="resume" id="resume" value="<?= $article["resume"]; ?>"  class="input">

                                </textarea>
                            </div>
                        </div>
            <div class="self-center">
                <button class="btn">Envoyer</button>
                <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à l'accueil</a></button>
            </div>
        </form>
    </section>

       
        <script src="src/js/script.js"></script>
<?php include 'footer.php' ?>