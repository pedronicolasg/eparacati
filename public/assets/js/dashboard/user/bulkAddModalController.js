const modal = document.getElementById("userBulkAddModal");
const openUserBulkAddModalBtn = document.getElementById(
  "bulkuseradd-open-modal-btn",
);
const closeUserBulkAddModalBtn = document.getElementById(
  "bulkuseradd-close-modal-btn",
);

function openUserBulkAddModal() {
  modal.classList.remove("hidden");
  modal.style.opacity = "0";
  modal.style.display = "flex";

  setTimeout(() => {
    modal.style.opacity = "1";
    modal.style.transition = "opacity 300ms ease-in-out";
  }, 10);

  document.body.style.overflow = "hidden";
}

function closeUserBulkAddModal() {
  modal.style.opacity = "0";
  modal.style.transition = "opacity 300ms ease-in-out";

  setTimeout(() => {
    modal.style.display = "none";
    modal.classList.add("hidden");
    document.body.style.overflow = "auto";
  }, 300);
}

openUserBulkAddModalBtn.addEventListener("click", openUserBulkAddModal);
closeUserBulkAddModalBtn.addEventListener("click", closeUserBulkAddModal);

modal.addEventListener("click", (e) => {
  if (e.target === modal) closeUserBulkAddModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && modal.style.display === "flex")
    closeUserBulkAddModal();
});
