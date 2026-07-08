const btnResultats = document.querySelector("#btn-resultats");
const inputResultats = document.querySelector(".input-resultat");

btnResultats.addEventListener("change", () => {
  if (btnResultats.checked) {
    // Si coché, on retire hidden et on s'assure d'avoir la mise en page
    inputResultats.classList.remove("hidden");
    inputResultats.classList.add("flex", "flex-col", "gap-4");
  } else {
    // Si décoché, on cache tout
    inputResultats.classList.add("hidden");
    inputResultats.classList.remove("flex", "flex-col", "gap-4");
  }
});
