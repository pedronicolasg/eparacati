document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('setup-form');
  const steps = document.querySelectorAll('.step-content');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');
  const submitBtn = document.getElementById('submit-btn');
  const progressBar = document.getElementById('progress-bar');
  const currentStepEl = document.getElementById('current-step');
  const stepTitleEl = document.getElementById('step-title');
  const activationKeyInput = document.getElementById('activation-key');
  const loadingScreen = document.getElementById('loading-screen');
  const mainContent = document.getElementById('main-content');
  const loadingMessage = document.getElementById('loading-message');

  const stepTitles = ['Ativação', 'Perfil', 'Dados Iniciais'];

  let currentStep = 1;
  const totalSteps = steps.length;

  updateUI();

  function updateUI() {
    progressBar.style.width = `${(currentStep / totalSteps) * 100}%`;
    currentStepEl.textContent = currentStep;
    stepTitleEl.textContent = stepTitles[currentStep - 1];

    prevBtn.disabled = currentStep === 1;

    if (currentStep === totalSteps) {
      nextBtn.classList.add('hidden');
      submitBtn.classList.remove('hidden');
    } else {
      nextBtn.classList.remove('hidden');
      submitBtn.classList.add('hidden');
    }

    steps.forEach((step, index) => {
      if (index + 1 === currentStep) {
        step.classList.remove('hidden');
        step.classList.add('animate-fade-in');
      } else {
        step.classList.add('hidden');
        step.classList.remove('animate-fade-in');
      }
    });
  }

  form.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
    }
  });

  nextBtn.addEventListener('click', function () {
    if (currentStep === 1) {
      const key = activationKeyInput.value.trim();
      if (!key) {
        alert('Por favor, insira uma chave de ativação.');
        return;
      }

      fetch('app/src/controllers/setup/validate_key.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `activation_key=${encodeURIComponent(key)}`
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            currentStep++;
            updateUI();
          } else {
            alert(data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Erro ao validar a chave. Tente novamente.');
        });
    } else if (currentStep < totalSteps) {
      currentStep++;
      updateUI();
    }
  });

  prevBtn.addEventListener('click', function () {
    if (currentStep > 1) {
      currentStep--;
      updateUI();
    }
  });

  submitBtn.addEventListener('click', function (e) {
    e.preventDefault();
    mainContent.classList.add('hidden');
    loadingScreen.classList.remove('hidden');
    loadingMessage.textContent = "Configurando o sistema...";
    setTimeout(() => {
      form.submit();
    }, 2000);
  });

  const profileUpload = document.getElementById('profile-upload');
  const profilePreview = document.getElementById('profile-preview');

  profileUpload.addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (file) {
      if (!file.type.startsWith('image/')) {
        alert('Por favor, selecione uma imagem válida.');
        return;
      }

      if (file.size > 5 * 1024 * 1024) {
        alert('A imagem deve ter no máximo 5MB.');
        return;
      }

      const reader = new FileReader();

      reader.onload = function (e) {
        profilePreview.innerHTML = '';
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'w-full h-full object-cover rounded-full';
        profilePreview.appendChild(img);
        profilePreview.classList.remove('border-dashed');
        profilePreview.classList.add('border-solid', 'border-fuchsia-500');
      };

      reader.readAsDataURL(file);
    }
  });

  const fileInputs = document.querySelectorAll('.file-input');

  fileInputs.forEach(input => {
    input.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const container = this.closest('.file-upload-container');
      const fileInfo = container.querySelector('.file-info');
      const uploadArea = container.querySelector('.upload-area');
      const fileType = this.dataset.type;

      const extension = file.name.split('.').pop().toLowerCase();
      if (extension !== 'csv' && extension !== 'xlsx') {
        alert('Por favor, selecione um arquivo CSV ou XLSX.');
        return;
      }

      uploadArea.innerHTML = '';
      const uploadIcon = document.createElement('i');
      uploadIcon.className = 'fas fa-check-circle text-2xl';

      if (fileType === 'users') {
        uploadIcon.classList.add('text-green-400');
        uploadArea.classList.add('border-green-500');
      } else if (fileType === 'equipment') {
        uploadIcon.classList.add('text-yellow-400');
        uploadArea.classList.add('border-yellow-500');
      } else if (fileType === 'classes') {
        uploadIcon.classList.add('text-purple-400');
        uploadArea.classList.add('border-purple-500');
      }

      uploadArea.appendChild(uploadIcon);
      uploadArea.classList.remove('border-dashed');
      uploadArea.classList.add('border-solid');

      fileInfo.innerHTML = '';
      fileInfo.classList.remove('hidden');

      const fileIcon = document.createElement('i');
      if (extension === 'csv') {
        fileIcon.className = 'fas fa-file-csv mr-2';
      } else {
        fileIcon.className = 'fas fa-file-excel mr-2';
      }

      if (fileType === 'users') {
        fileIcon.classList.add('text-green-400');
      } else if (fileType === 'equipment') {
        fileIcon.classList.add('text-yellow-400');
      } else if (fileType === 'classes') {
        fileIcon.classList.add('text-purple-400');
      }

      const fileName = document.createElement('span');
      fileName.className = 'text-sm text-gray-300';
      fileName.textContent = file.name;

      const fileSize = document.createElement('span');
      fileSize.className = 'text-xs text-gray-500 ml-2';

      const size = file.size;
      let formattedSize;
      if (size < 1024) {
        formattedSize = size + ' B';
      } else if (size < 1024 * 1024) {
        formattedSize = (size / 1024).toFixed(1) + ' KB';
      } else {
        formattedSize = (size / (1024 * 1024)).toFixed(1) + ' MB';
      }

      fileSize.textContent = `(${formattedSize})`;

      const removeBtn = document.createElement('button');
      removeBtn.className = 'ml-auto text-gray-500 hover:text-gray-300 transition-colors';
      removeBtn.innerHTML = '<i class="fas fa-times"></i>';
      removeBtn.type = 'button';

      removeBtn.addEventListener('click', function () {
        input.value = '';
        uploadArea.innerHTML = `
          <i class="fas fa-cloud-upload text-gray-500 peer-hover:text-${fileType === 'users' ? 'green' : fileType === 'equipment' ? 'yellow' : 'purple'}-400 text-xl mb-1 transition-colors"></i>
          <span class="text-xs text-gray-500 peer-hover:text-gray-300 transition-colors">Clique para selecionar</span>
        `;
        uploadArea.classList.add('border-dashed');
        uploadArea.classList.remove('border-solid', `border-${fileType === 'users' ? 'green' : fileType === 'equipment' ? 'yellow' : 'purple'}-500`);
        fileInfo.classList.add('hidden');
      });

      const fileInfoContent = document.createElement('div');
      fileInfoContent.className = 'flex items-center';
      fileInfoContent.appendChild(fileIcon);
      fileInfoContent.appendChild(fileName);
      fileInfoContent.appendChild(fileSize);
      fileInfoContent.appendChild(removeBtn);
      fileInfo.appendChild(fileInfoContent);
    });
  });

  const passwordEye = document.querySelector('.fa-eye');
  const passwordInput = passwordEye.closest('.relative').querySelector('input');

  passwordEye.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      this.classList.remove('fa-eye');
      this.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      this.classList.remove('fa-eye-slash');
      this.classList.add('fa-eye');
    }
  });
});