document.getElementById('copyIdButton').addEventListener('click', function () {
  let id = document.getElementById('logId').innerText;
  navigator.clipboard.writeText(id).then(function () {
    alert('ID copiado: ' + id);
  }, function (err) {
    console.error('Erro ao copiar ID: ', err);
  });
});

function exportLogAsJSON(id) {
  window.location.href = `../../src/controllers/log/download.php?id=${id}&format=json`;
}

function exportLogAsExcel(id) {
  window.location.href = `../../src/controllers/log/download.php?id=${id}&format=excel`;
}

function deleteLog(id) {
  if (confirm('Tem certeza que deseja deletar este registro?')) {
    window.location.href = `../../src/controllers/log/delete.php?id=${id}`;
  }
}