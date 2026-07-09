 </main>
<footer class="footer sm:footer-horizontal footer-center bg-yellow-200 text-base-content p-4">
  <aside>
    <p>l'histoire d'un blog</p>
  </aside>

  <?php if(isset($_SESSION["loggedUser"])) :  ?>
      <button class="btn btn-secondary"><a href="/blog/pages/logout.php">Se déconnecter</a></button>
      <?php endif; ?>
</footer>
    </body>
    </html>