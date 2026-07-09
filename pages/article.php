<?php
session_start();
include __DIR__.'/../connect.php';
include __DIR__.'/../functions.php';

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
    $articleSqlQuery = "SELECT a.id, title, content, date_publication, a.image, u.name, u.surname, m.score, m.team1, m.team2, m.location, m.summary, m.date
    FROM articles as a
    JOIN users as u
    ON u.id = a.users_id
    LEFT JOIN matches AS m ON a.match_id = m.id
    WHERE a.id = :id"; 
    
    
    // :id is a placeholder for a value that is used in PHP (revoir la déf)
    $articleRetrieved = $myMysqlConnection -> prepare($articleSqlQuery);
    $articleRetrieved -> execute(
        [
            "id" => (int)$getData["id"] // here I get the id
        ]
    );
    $article = $articleRetrieved -> fetch(PDO::FETCH_ASSOC);
    // with PDO::FETCH_ASSOC I'll get 
    // ["title" => "...", "auteur" => "...", "contenu" => "..."]
    // Easier to access values

// I check if the article exists
if(!$article){
    echo "Article introuvable. Vérifier l'id renseigné";
    return;
    }

    ?>

    <!-- Display the article -->

    <?php include __DIR__.'/../components/header.php';  ?>
    <!-- Title -->
    <section class="flex flex-col gap-10 py-20 items-center">

        <h1 class="text-center mb-10 mt-5"><?= $article["title"]; ?></h1>

        <div class="img-author">
            <!-- Image -->              
                  <!-- To display the image -->
                    <?php 
                    $imagePath = "/blog/public/assets/img/" . $article["image"];
                    ?>
                    <?php if($article["image"] != null) : ?>
                    <div class="w-full overflow-hidden">
                        <img src="<?= $imagePath ?>" class="object-contain"/>
                    </div>
                    <?php endif; ?>

        <div class="hidden">
            <p for="id">Identitifiant de l'article</p>
            <p type="text" id="id" name="id" value="<?= $getData["id"]; ?>">
        </div>

        <!-- Auteur -->
            <div>
                <p>Article rédigé par
            <?= $article["name"]." ".$article["surname"]; ?></p>
            <!-- Date de publication -->
            <p>Publié le <span><?= $article["date_publication"]; ?></span></p>
            </div>
        </div>

            <!-- Contenu -->
            <div class="contenu flex-row-w ">

                <p><?= $article["content"]; ?></p>
            </div>

            <div class="resultats-match">

                <h2>Résultats du match</h2>
                    <div class="hidden">
                        <p for="id_match">Id du match</p>
                        <p type="id_match" name="id_match" id="id_match" class="bg-slate-100"value="<?= $article["id"]; ?>" disabled>
                    </div>
                            <div>
    
                                <div class="flex-row-w ">
                                    <p>Date du match : <span><?= $article["date"]; ?></span></p>
                                </div>
                                <div class="teams flex-row-w">
                                    
                                    <p><?= $article["team1"]; ?> <span>contre</span> <?= $article["team2"]; ?></p>
                                </div>
                                <div class="flex-row-w ">
                                    <p for="score">Score du match : <span><?= $article["score"]; ?></span></p>
                                </div>
                                <div class="flex-row-w ">
                                    <p for="location">Lieu</p>
                                    <p type="text" name="location" id="location" value="<?= $article["location"]; ?>">
                                </div>
                                <div class="flex-row-w ">
                                    <p for="resume">Résumé de la rencontre :</p>
                                    <p name="resume" id="resume" value="<?= $article["summary"]; ?>">
                            </p>
                                </div>
                            </div>
            </div>

            <div class="flex flex-row items-center gap-4">
                <p>Envie de partager cet article ? </p>

                 <!-- I get a clean url -->
                     <?php $url = createArticleUrl(strip_tags($article["id"]), strip_tags($article["title"])); ?>

                <div class="size-fit">
                <button class="btn btn-circle" id="shareButton"
                data-title = "<?= $article["title"] ? $article["title"] : "" ; ?>"
                data-text = "<?=  $article["title"] ? $article["title"] : "" ; ?>"
                data-url = "<?= "http://localhost:8888/blog/public/".$url; ?>"
                >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-[1.2em]"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                </button>

                </div>
            </div>

             <!-- Zone d'alerte pour le partage (affichée par JavaScript) -->
             <div id="shareAlert" class="alert hidden"></div>

            <div class="self-center">
                <button class="btn btn-soft btn-secondary"><a href="/blog/public/index.php">Retour à la page d'accueil</a></button>
            </div>
    </section>

    <script src="/blog/public/assets/src/js/share-btn.js"></script>

 <?php include __DIR__.'/../components/footer.php';  ?>
