  <?php 
  session_start();
  include __DIR__.'/../components/header.php'; 

  ?>

<!-- ? The <dialog> HTML element represents a modal or non-modal dialog box or other interactive component, such as a dismissible alert, inspector, or subwindow. -->

<section class="flex flex-col justify-center items-center gap-10">

<!-- 
===================================
REGISTRATION FAILED (ERROR MESSAGE)
=================================== 
-->

 <?php if(isset($_SESSION["errorMessage"])) : ?>
<!-- ERROR MESSAGE -->
<div role="alert" class="alert alert-error">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span><?php echo $_SESSION["errorMessage"]; ?></span>

  <!-- TO REMOVE THE PERSISTANT FAILURE MESSAGE -->
  <?php unset($_SESSION["errorMessage"]); ?>
</div>

<?php endif; ?>


<form action="registerpost.php" method="POST" class="flex flex-col items-start gap-4">

<fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
  <legend class="fieldset-legend">Mon inscription a l'histoire d'un blog</legend>


  <label class="label">Prénom</label>
  <input type="text" class="input" name="name" placeholder="Prénom" required/>

  <label class="label">Nom</label>
  <input type="text" class="input" name="surname" placeholder="Nom" required/>

  <label class="label">Email</label>
  <input type="email" class="input" name="email" placeholder="Email" required/>

  <label class="label">Password</label>
  <input type="password" class="input" name="password" placeholder="Mot de passe" required/>

  <div class="hidden">
    <label for="id">Rôle de l'inscrit</label>
    <input type="text" name="role" value="3"/>

  </div>

  <button class="btn btn-secondary mt-4">S'inscrire</button>
</fieldset>

</form>

<p>Si vous souhaitez contribuer à l'évolution du site et devenir rédacteur, <a href="">contactez-nous</a> ! </p>

 <button class="btn btn-soft btn-secondary"><a href="/blog/public/index.php">Retour à l'accueil</a></button>

 </section>

 <?php include __DIR__.'/../components/footer.php';  ?>
