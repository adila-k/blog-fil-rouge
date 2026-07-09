<?php 
session_start();
include __DIR__.'/../components/header.php';


include __DIR__.'/../connect.php';
include __DIR__.'/../functions.php';

$sqlQUERY = 
'SELECT u.name, u.surname, a.id, a.title, a.content, a.date_publication, a.image, m.score
FROM users AS u 
JOIN articles AS a
ON a.users_id = u.id 
LEFT JOIN matches as m
ON m.id = a.match_id
ORDER BY date_publication DESC';

$Allarticles = $myMysqlConnection->prepare($sqlQUERY);
$Allarticles->execute(); // Let 'excute' empty because I don't want to enter/change datas

// In allArticles, get me all the lines
$articles = $Allarticles->fetchAll();

// var_dump($_SESSION);
?>

<!-- npx @tailwindcss/cli -i public/assets/src/css/input.css -o public/assets/src/css/output.css --watch -->

    <section>   
        
    <?php if(isset($_SESSION["loginSuccess"])):  ?>
   
    <div role="alert" class="alert alert-success size-fit mb-10 m-auto">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Connexion réussie. Bienvenue <?php echo $_SESSION["loggedUser"]["name"]  ?></span>

          <!-- REMOVE THE PERSISTANT POPUP -->
           <?php unset($_SESSION["loginSuccess"]); ?>
        </div>
    <?php endif; ?>

                    <!-- Page title -->
                     <div class="title-wrapper text-center mb-10">
                         <h1 class="mb-10">l'histoire d'un blog</h1>
                         <p>un blog qui raconte des histoires</p>
                     </div>

                     <?php if(!isset($_SESSION["loggedUser"])):  ?>
<!-- Card for disconnected/not registered users -->
 <div class="card bg-slate-50 w-96 border border-slate-500 flex flex-col gap-2 m-auto">
  <div class="card-body">
    <h2 class="card-title">l'histoire d'un blog</h2>
    <p>Vous devez être inscrit pour accéder à l'ensemble des articles. L'inscription est gratuite et prend moins de 5 minutes ! </p>
    <div class="card-actions justify-center">
      <button class="btn btn-soft btn-accent"><a href="../pages/register.php">S'inscrire</a></button>
    </div>
  </div>
</div>
 <?php endif; ?>

        <?php if(isset($_SESSION["loggedUser"]) && ($_SESSION["loggedUser"]["roles_id"] == "1" || $_SESSION["loggedUser"]["roles_id"] == "2")) : ?>
                <!-- Btn add a new article -->
                 <div class=" m-auto size-fit">
                     <button class="btn btn-success"><a href="/blog/pages/add.php">Ajouter un nouvelle article</a></button>
                 </div>
        <?php endif; ?>
                <?php if(isset($_SESSION["loggedUser"])) : ?>        
                <!-- Cards wrapper -->
                <div class="card-wrapper grid grid-cols-3 gap-5 mt-10 m-auto">
                    <?php foreach ($articles as $article) :?>
        
                        <!-- Card Item -->
                 <div class="card bg-base-100 w-75 shadow-sm">
                    <figure class="h-80">
                        <!-- To display the image -->
                        <?php $imagePath = "assets/img/" . $article["image"];?>
        
                        <?php if(isset($article["image"])) :  ?>
                        <img src="<?= $imagePath ?>" class="w-full object-cover"/>
                        <?php endif ?>
                    </figure>
                    <div class="card-body">
                        <p class="hidden"><?php echo strip_tags($article["id"]); ?></p>
                        <h2 class="card-title"><?php echo truncate(strip_tags($article['title'])); ?></h2>
                        <p class=" text-gray-600 text-xs">
                            Par  <span class="uppercase"><?php echo strip_tags($article['name']." ".$article["surname"]); ?></span> 
                        </p>
                        <p>Publié le <?php echo strip_tags($article['date_publication']); ?></p>
                            <?php if(isset($article["score"]) ): ?>   
                            <p>Score : 
                            
                            <?= strip_tags($article['score']); ?></p>
                            <?php endif ?>
                        <p><?php echo strip_tags(truncate($article['content'])); ?></p>

                        <div class="flex flex-col items-center my-5">
    
                                    <!-- I get a clean url -->
                                    <?php $url = createArticleUrl(strip_tags($article["id"]), strip_tags($article["title"])); ?>

                                    <!-- READ BUTTON -->

                                <button class="btn btn-info">
                                   <a href="<?= $url; ?>">Lire l'article</a>
                                </button>
                            </div>



                        <!-- BUTTONS DELETE / MODIFY -->
                        <div class="flex flex-row justify-center gap-2">
                            <?php if(isset($_SESSION["loggedUser"]) && ($_SESSION["loggedUser"]["roles_id"] == "1" || $_SESSION["loggedUser"]["roles_id"] == "2")) : ?>
                                <button class="btn btn-accent"> <a href="../pages/update.php?id=<?php echo strip_tags($article["id"])?>">Modifier</a> </button>

                                <?php if(isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"]["roles_id"] == "1") : ?>
                                <button class="btn btn-error"><a href="../pages/delete.php?id=<?php echo strip_tags($article["id"])?>">Supprimer</a>
                                </button>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            </div>
                    </div>
                    
                    <?php endforeach; ?>
                    <?php endif ?>
                </div>

    </section>
<?php include __DIR__.'/../components/footer.php'; ?>