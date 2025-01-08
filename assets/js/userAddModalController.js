const userAddModal = document.getElementById("userAddModal");
const openUserAddModalBtn = document.getElementById("useradd-open-modal-btn");
const closeUserAddModalBtn = document.getElementById("useradd-close-modal-btn");

function openUserAddModal() {
  userAddModal.classList.remove("hidden");
  userAddModal.style.opacity = "0";
  userAddModal.style.display = "flex";

  setTimeout(() => {
    userAddModal.style.opacity = "1";
    userAddModal.style.transition = "opacity 300ms ease-in-out";
  }, 10);

  document.body.style.overflow = "hidden";
}

function closeUserAddModal() {
  userAddModal.style.opacity = "0";
  userAddModal.style.transition = "opacity 300ms ease-in-out";

  setTimeout(() => {
    userAddModal.style.display = "none";
    userAddModal.classList.add("hidden");
    document.body.style.overflow = "auto";
  }, 300);
}

openUserAddModalBtn.addEventListener("click", openUserAddModal);
closeUserAddModalBtn.addEventListener("click", closeUserAddModal);

userAddModal.addEventListener("click", (e) => {
  if (e.target === userAddModal) closeUserAddModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && userAddModal.style.display === "flex")
    closeUserAddModal();
});
