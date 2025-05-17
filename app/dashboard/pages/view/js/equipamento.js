function deleteEquipmentImage(id) {
    if (!confirm('Tem certeza que deseja deletar a imagem?')) {
      return;
    }
  
    const imageContainer = document.querySelector('#output');
    const originalSrc = imageContainer.src;
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'absolute inset-0 bg-gray-900/50 flex items-center justify-center';
    loadingOverlay.innerHTML = '<div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-white"></div>';
    imageContainer.parentElement.style.position = 'relative';
    imageContainer.parentElement.appendChild(loadingOverlay);
  
    fetch(`../../src/controllers/equipment/deleteImage.php?id=${id}`, {
      method: 'GET',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      loadingOverlay.remove();
      if (data.success) {
        imageContainer.src = 'https://placehold.co/900x600.png';
        showAlert('Sucesso', 'Imagem do equipamento deletada com sucesso', 'success');
      } else {
        throw new Error(data.message || 'Erro ao deletar imagem');
      }
    })
    .catch(error => {
      loadingOverlay.remove();
      imageContainer.src = originalSrc;
      showAlert('Erro', error.message, 'error');
    });
  }
  
  function showAlert(title, message, type) {
    const alertContainer = document.createElement('div');
    alertContainer.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white max-w-sm z-50`;
    alertContainer.innerHTML = `
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} text-xl"></i>
        </div>
        <div class="ml-3">
          <p class="font-bold">${title}</p>
          <p class="text-sm">${message}</p>
        </div>
      </div>
    `;
    document.body.appendChild(alertContainer);
    
    setTimeout(() => {
      alertContainer.classList.add('opacity-0', 'transition-opacity', 'duration-500');
      setTimeout(() => alertContainer.remove(), 500);
    }, 3000);
  }