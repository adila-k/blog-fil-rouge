    <?php
    session_start();
  include __DIR__.'/../components/header.php'; 

  ?>

    <section class="flex flex-col items-center">  
      
<!-- 
=======================================
REGISTRATION SUCCESSFUL (ERROR MESSAGE)
======================================= 
-->

<?php if(isset($_SESSION["registerSuccess"])):  ?>
<div role="alert" class="alert alert-success mb-10">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span><?php echo $_SESSION["registerSuccess"]; ?></span>

  <!-- TO REMOVE THE PERSISTANT CONFIRMATION MESSAGE -->
  <?php unset($_SESSION["registerSuccess"]); ?>

</div>
<?php endif;?>

<!-- 
==========
LOGIN FORM
==========
-->

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

  <?php include __DIR__.'/../components/footer.php'; ?>

