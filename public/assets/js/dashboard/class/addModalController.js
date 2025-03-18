const classAddModal = document.getElementById("classAddModal");
const openclassAddModalBtn = document.getElementById("classadd-open-modal-btn");
const closeclassAddModalBtn = document.getElementById("classadd-close-modal-btn");

function openclassAddModal() {
  classAddModal.classList.remove("hidden");
  classAddModal.style.opacity = "0";
  classAddModal.style.display = "flex";

  setTimeout(() => {
    classAddModal.style.opacity = "1";
    classAddModal.style.transition = "opacity 300ms ease-in-out";
  }, 10);

  document.body.style.overflow = "hidden";
}

function closeclassAddModal() {
  classAddModal.style.opacity = "0";
  classAddModal.style.transition = "opacity 300ms ease-in-out";

  setTimeout(() => {
    classAddModal.style.display = "none";
    classAddModal.classList.add("hidden");
    document.body.style.overflow = "auto";
  }, 300);
}

openclassAddModalBtn.addEventListener("click", openclassAddModal);
closeclassAddModalBtn.addEventListener("click", closeclassAddModal);

classAddModal.addEventListener("click", (e) => {
  if (e.target === classAddModal) closeclassAddModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && classAddModal.style.display === "flex")
    closeclassAddModal();
});
