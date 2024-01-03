document.addEventListener("DOMContentLoaded", function () {
  const editButton = document.getElementById("editButton");
  const editForm = document.getElementById("editForm");
  const infos = document.getElementById("infos");

  editButton.addEventListener("click", function () {
    editForm.classList.remove("d-none");
    infos.classList.add("d-none");  });

})

const backButton = document.getElementById("backButton");

backButton.addEventListener("click", function () {
  window.history.back();
});
