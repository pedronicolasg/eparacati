function confirmDeleteClass(id) {
  if (confirm('Tem certeza que deseja deletar esta turma?')) {
    window.location.href = `../../src/handlers/class/delete.php?id=${id}`;
  }
}

function confirmDeleteClassAndUsers(id) {
  if (confirm('Tem certeza que deseja deletar esta turma e todos os alunos nela?')) {
    window.location.href = `../../src/handlers/class/delete.php?id=${id}&deleteStudents`;
  }
}