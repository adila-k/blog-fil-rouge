<?php include 'header.php' ?>

<section>
            <h1 class="text-center">Ajouter un article</h1>
     
            <form action="add-post.php" method="POST" enctype="multipart/form-data" class="flex flex-col flex-nowrap gap-4">

                <!-- 
                enctype="multipart/form-data" - Mendatory because there is a file input in my form 
                                    -->
                        <div class="flex-row-w">
                        <label class="label-add">Auteur de l'article</label>
                        <input type="text" class="input" id="auteur" name="auteur" placeholder="Auteur" />
                        </div>
                        <div class="flex-row-w">
                        <label class="label-add">Titre de l'article</label>
                        <input type="text" class="input" id="titre" name="titre" placeholder="Saisissez un titre percutant !" />
                        </div>
                        <div class="flex-row-w">
                        <label class="label-add">Image</label>
                        <input class="input" type="file" name="image" id="image" accept=".webp, .png, .jpg, image/jpeg" />
                        </div>

                <!-- Résultat match -->
                <div>
                    <label for="resultats" >Souhaitez-vous ajouter les résultats du match ?</label>
                    <input type="checkbox" id="btn-resultats" name="btn-resultats">
                </div>

                    <div class="hidden input-resultat">
                        <div class="flex-row-w"><label for="matchdate" class="label-add">Date du match</label><input type="date" name="matchdate" id="matchmdate" class="input"></div>
                        <div class="flex-row-w"><label for="team-1" class="label-add">Équipe 1</label><input type="text" name="team-1" id="team1" class="input"></div>
                        <div class="flex-row-w"><label for="team-2" class="label-add">Équipe 2</label><input type="text" name="team-2" id="team2" class="input"></div>
                        <div class="flex-row-w"><label for="score" class="label-add">Score du match (0 - 0)</label><input type="text" name="score" id="score" class="input"></div>
                        <div class="flex-row-w"><label for="location" class="label-add">Lieu</label><input type="text" name="location" id="location" class="input"></div>
                        <div class="flex-row-w"><label for="resume" class="label-add">Résumé</label><textarea name="resume" id="resume" class="input"></textarea>
                </div>
                    </div>

                        <div class="flex-row-w">
                        <label class="label-add">Contenu de l'article</label>
                        <textarea name="contenu" id="contenu" class="input"></textarea>
                        </div>

                    <button class="btn" type="submit">Envoyer</button>
            </form>

  <button class="btn btn-soft btn-secondary"><a href="/index.php">Retour à la page d'accueil</a></button>

    </section>

        <script src="src/js/script.js"></script>
<?php include 'footer.php' ?>