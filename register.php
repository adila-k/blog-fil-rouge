  <?php include 'header.php' ?>

  <!-- ? Comment ça va ?  -->
    
  <!-- My button -->


<!-- ? The <dialog> HTML element represents a modal or non-modal dialog box or other interactive component, such as a dismissible alert, inspector, or subwindow. -->

<section class="flex flex-col justify-center items-center gap-10">

<form action="login.php" method="POST" class="flex flex-col items-start gap-4">

<fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
  <legend class="fieldset-legend">Mon inscription a l'histoire d'un blog</legend>


  <label class="label">Prénom</label>
  <input type="email" class="input" name="name" placeholder="Prénom" required/>

  <label class="label">Nom</label>
  <input type="email" class="input" name="surname" placeholder="Nom" required/>

  <label class="label">Email</label>
  <input type="email" class="input" name="email" placeholder="Email" required/>

  <label class="label">Password</label>
  <input type="password" class="input" name="password" placeholder="Mot de passe" required/>

  <button class="btn btn-secondary mt-4">Se connecter</button>
</fieldset>

</form>

 <button class="btn btn-soft btn-secondary"><a href="index.php">Retour à l'accueil</a></button>

 </section>

  <?php include 'footer.php' ?>

