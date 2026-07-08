<?php 
include 'connect.php';
include 'functions.php';

// I get all articles of the db
$sqlQUERY = 
'SELECT ap.id, titre, contenu, auteur, date_publication, image, rs.score
FROM articles_presse AS ap
LEFT JOIN resultats_sportifs AS rs ON ap.match_id = rs.id
ORDER BY date_publication DESC';

$Allarticles = $myMysqlConnection->prepare($sqlQUERY);
$Allarticles->execute(); // Let 'excute' empty because I don't want to enter/change datas

// In allArticles, get me all the lines
$articles = $Allarticles->fetchAll();

?>

<!-- npx @tailwindcss/cli -i src/css/input.css -o src/css/output.css --watch -->

    <?php include 'header.php' ?>

    <section>   
        
        
                    <!-- Page title -->
                <h1 class="text-center  mb-10">Ensemble des articles</h1>
        
                <!-- Btn add a new article -->
                 <div class=" m-auto size-fit">
                     <button class="btn btn-success"><a href="add.php">Ajouter un nouvelle article</a></button>
                 </div>
        
                <!-- Cards wrapper -->
                <div class="card-wrapper flex flex-wrap row justify-evenly gap-10 mt-10 md:w-full">
                    <?php foreach ($articles as $article) :?>
        
                        <!-- Card Item -->
                <div class="card bg-base-100 w-96 shadow-sm">
                    <figure class="h-80">
                        <!-- To display the image -->
                        <?php $imagePath = "assets/img/" . $article["image"];?>
        
                        <?php if(isset($article["image"])) :  ?>
                        <img src="<?= $imagePath ?>" class="w-full object-cover"/>
                        <?php endif ?>
                    </figure>
                    <div class="card-body">
                        <p class="hidden"><?php echo strip_tags($article["id"]); ?></p>
                        <h2 class="card-title"><?php echo truncate(strip_tags($article['titre'])); ?></h2>
                        <p class=" text-gray-600 text-xs">
                            Par  <span class="uppercase"><?php echo strip_tags($article['auteur']); ?></span> 
                        </p>
                        <p>Publié le <?php echo strip_tags($article['date_publication']); ?></p>
                            <?php if(isset($article["score"]) ): ?>   
                            <p>Score : 
                            
                            <?= strip_tags($article['score']); ?></p>
                            <?php endif ?>
                        <p><?php echo strip_tags(truncate($article['contenu'])); ?></p>
        
                        <div>
                            <button class="btn btn-info"><a href="article.php?id=<?php echo strip_tags($article["id"])?>">Lire l'article</a></button>
                        </div>
                        <div>
                                <button class="btn btn-accent"> <a href="update.php?id=<?php echo strip_tags($article["id"])?>">Modifier</a> </button>
                                <button class="btn btn-error"><a href="delete.php?id=<?php echo strip_tags($article["id"])?>">Supprimer</a>
                                </button>
                            </div>
          </div>
        </div>
         
                        <?php endforeach; ?>
                </div>

    </section>
<?php include 'footer.php' ?>