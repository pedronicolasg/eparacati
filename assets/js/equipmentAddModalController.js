const equipmentAddModal = document.getElementById("equipmentAddModal");
const openEquipmentAddModalBtn = document.getElementById("equipmentadd-open-modal-btn");
const closeEquipmentAddModalBtn = document.getElementById("equipmentadd-close-modal-btn");

function openEquipmentAddModal() {
  equipmentAddModal.classList.remove("hidden");
  equipmentAddModal.style.opacity = "0";
  equipmentAddModal.style.display = "flex";

  setTimeout(() => {
    equipmentAddModal.style.opacity = "1";
    equipmentAddModal.style.transition = "opacity 300ms ease-in-out";
  }, 10);

  document.body.style.overflow = "hidden";
}

function closeEquipmentAddModal() {
  equipmentAddModal.style.opacity = "0";
  equipmentAddModal.style.transition = "opacity 300ms ease-in-out";

  setTimeout(() => {
    equipmentAddModal.style.display = "none";
    equipmentAddModal.classList.add("hidden");
    document.body.style.overflow = "auto";
  }, 300);
}

openEquipmentAddModalBtn.addEventListener("click", openEquipmentAddModal);
closeEquipmentAddModalBtn.addEventListener("click", closeEquipmentAddModal);

equipmentAddModal.addEventListener("click", (e) => {
  if (e.target === equipmentAddModal) closeEquipmentAddModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && equipmentAddModal.style.display === "flex")
    closeEquipmentAddModal();
});
