<?php
session_start();
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
    $articleSqlQuery = "SELECT ap.id, titre, contenu, auteur, date_publication, image, rs.score, rs.equipe1, rs.equipe2, rs.lieu, rs.resume, rs.date_match
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
    <!-- Title -->
    <section class="flex flex-col gap-10 py-20">

        <h1 class="text-center mb-10 mt-5"><?= $article["titre"]; ?></h1>

        <div class="img-author">
            <!-- Image -->              
                  <!-- To display the image -->
                    <?php 
                    $imagePath = "assets/img/" . $article["image"];
                    ?>
                    <?php if($article["image"] != null) : ?>
                    <div class="w-full h-100 overflow-hidden">
                        <img src="<?= $imagePath ?>" class="object-cover"/>
                    </div>
                    <?php endif; ?>

        <div class="hidden">
            <p for="id">Identitifiant de l'article</p>
            <p type="text" id="id" name="id" value="<?= $getData["id"]; ?>">
        </div>

        <!-- Auteur -->
            <div>
                <p>Article rédigé par
            <?= $article["auteur"]; ?></p>
            <!-- Date de publication -->
            <p>Publié le <span><?= $article["date_publication"]; ?></span></p>
            </div>
        </div>

            <!-- Contenu -->
            <div class="contenu flex-row-w ">

                <p><?= $article["contenu"]; ?></p>
            </div>

            <div class="resultats-match">

                <h2>Résultats du match</h2>
                    <div class="hidden">
                        <p for="id_match">Id du match</p>
                        <p type="id_match" name="id_match" id="id_match" class="bg-slate-100"value="<?= $article["id"]; ?>" disabled>
                    </div>
                            <div>
    
                                <div class="flex-row-w ">
                                    <p>Date du match : <span><?= $article["date_match"]; ?></span></p>
                                </div>
                                <div class="teams flex-row-w">
                                    
                                    <p><?= $article["equipe1"]; ?> <span>contre</span> <?= $article["equipe2"]; ?></p>
                                </div>
                                <div class="flex-row-w ">
                                    <p for="score">Score du match : <span><?= $article["score"]; ?></span></p>
                                </div>
                                <div class="flex-row-w ">
                                    <p for="location">Lieu</p>
                                    <p type="text" name="location" id="location" value="<?= $article["lieu"]; ?>">
                                </div>
                                <div class="flex-row-w ">
                                    <p for="resume">Résumé de la rencontre :</p>
                                    <p name="resume" id="resume" value="<?= $article["resume"]; ?>">
                            </p>
                                </div>
                            </div>
            </div>
            <div class="self-center">
                <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à la page d'accueil</a></button>
            </div>
    </section>

 <?php include 'footer.php' ?>
