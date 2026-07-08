    <?php
     session_start();
    include 'header.php' 
    
  ?>

    <section class="flex flex-col items-center">   

    <!-- Login form -->


<form action="login-submit.php" method="POST" class="flex flex-col items-start gap-4">

<fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
  <legend class="fieldset-legend">Accéder à mon espace abonné</legend>

  <label class="label">Email</label>
  <input type="email" class="input" name="email" placeholder="Votre email" required/>

  <label class="label">Password</label>
  <input type="password" class="input" name="password" placeholder="Password" required/>

  <button class="btn btn-secondary mt-4">Se connecter</button>
</fieldset>

</form>

  <?php include 'footer.php' ?>

