const modal = document.getElementById("crud-modal");
const openModalBtn = document.getElementById("open-modal-btn");
const closeModalBtn = document.getElementById("close-modal-btn");

function openModal() {
  modal.classList.remove("hidden");
  modal.style.opacity = "0";
  modal.style.display = "flex";

  setTimeout(() => {
    modal.style.opacity = "1";
    modal.style.transition = "opacity 300ms ease-in-out";
  }, 10);

  document.body.style.overflow = "hidden";
}

function closeModal() {
  modal.style.opacity = "0";
  modal.style.transition = "opacity 300ms ease-in-out";

  setTimeout(() => {
    modal.style.display = "none";
    modal.classList.add("hidden");
    document.body.style.overflow = "auto";
  }, 300);
}

openModalBtn.addEventListener("click", openModal);
closeModalBtn.addEventListener("click", closeModal);

modal.addEventListener("click", (e) => {
  if (e.target === modal) closeModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && modal.style.display === "flex") closeModal();
});
