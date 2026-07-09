// ============
// SHARE BUTTON
// ============

// * J'attends que le contenu du DOM soit chargé avant que le script ne se lance
// ? In case the shareButton does not exist
document.addEventListener("DOMContentLoaded", function () {
  // * I get my element from DOM
  const shareButton = document.getElementById("shareButton");
  // ? return is case it does not exist
  if (!shareButton) return;

  shareButton.addEventListener("click", async () => {
    const shareData = {
      title: shareButton.dataset.title,
      text: shareButton.dataset.text,
      url: shareButton.dataset.url || window.location.href,
    };

    try {
      if (navigator.share) {
        await navigator.share(shareData);
      } else {
        // Fallback pour desktop
        await navigator.clipboard.writeText(shareData.url);
        showAlert("Lien copié !");
      }
    } catch (err) {
      console.error("Erreur de partage:", err);
    }
  });

  function showAlert(message) {
    const alert = document.getElementById("shareAlert");
    alert.textContent = message;
    alert.style.display = "block";
    setTimeout(() => (alert.style.display = "none"), 3000);
  }
});
