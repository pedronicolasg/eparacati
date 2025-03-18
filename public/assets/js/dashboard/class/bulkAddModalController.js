const modal = document.getElementById("classBulkAddModal");
const openclassBulkAddModalBtn = document.getElementById(
  "bulkclassadd-open-modal-btn",
);
const closeclassBulkAddModalBtn = document.getElementById(
  "bulkclassadd-close-modal-btn",
);

function openclassBulkAddModal() {
  modal.classList.remove("hidden");
  modal.style.opacity = "0";
  modal.style.display = "flex";

  setTimeout(() => {
    modal.style.opacity = "1";
    modal.style.transition = "opacity 300ms ease-in-out";
  }, 10);

  document.body.style.overflow = "hidden";
}

function closeclassBulkAddModal() {
  modal.style.opacity = "0";
  modal.style.transition = "opacity 300ms ease-in-out";

  setTimeout(() => {
    modal.style.display = "none";
    modal.classList.add("hidden");
    document.body.style.overflow = "auto";
  }, 300);
}

openclassBulkAddModalBtn.addEventListener("click", openclassBulkAddModal);
closeclassBulkAddModalBtn.addEventListener("click", closeclassBulkAddModal);

modal.addEventListener("click", (e) => {
  if (e.target === modal) closeclassBulkAddModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && modal.style.display === "flex")
    closeclassBulkAddModal();
});
