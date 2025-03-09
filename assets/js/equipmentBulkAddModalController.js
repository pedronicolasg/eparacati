const modal = document.getElementById("equipmentBulkAddModal");
const openEquipmentBulkAddModalBtn = document.getElementById(
  "bulkequipmentadd-open-modal-btn",
);
const closeEquipmentBulkAddModalBtn = document.getElementById(
  "bulkequipmentadd-close-modal-btn",
);

function openEquipmentBulkAddModal() {
  modal.classList.remove("hidden");
  modal.style.opacity = "0";
  modal.style.display = "flex";

  setTimeout(() => {
    modal.style.opacity = "1";
    modal.style.transition = "opacity 300ms ease-in-out";
  }, 10);

  document.body.style.overflow = "hidden";
}

function closeEquipmentBulkAddModal() {
  modal.style.opacity = "0";
  modal.style.transition = "opacity 300ms ease-in-out";

  setTimeout(() => {
    modal.style.display = "none";
    modal.classList.add("hidden");
    document.body.style.overflow = "auto";
  }, 300);
}

openEquipmentBulkAddModalBtn.addEventListener("click", openEquipmentBulkAddModal);
closeEquipmentBulkAddModalBtn.addEventListener("click", closeEquipmentBulkAddModal);

modal.addEventListener("click", (e) => {
  if (e.target === modal) closeEquipmentBulkAddModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && modal.style.display === "flex")
    closeEquipmentBulkAddModal();
});
