<?php

class Format
{
  public static function roleName($role, $forUser = false)
  {
    $roleMap = [
      'aluno' => 'Aluno',
      'lider' => 'Líder',
      'vice_lider' => 'Vice-Líder',
      'gremio' => 'Grêmio',
      'professor' => 'Professor',
      'pdt' => 'PDT',
      'funcionario' => 'Funcionário',
      'gestao' => 'Gestão',
    ];

    if ($forUser) {
      array_walk($roleMap, function (&$role) {
        $role = str_replace(
          ['Aluno', 'Professor', 'Funcionário', 'Gestão'],
          ['Aluno(a)', 'Professor(a)', 'Funcionário(a)', 'Gestor(a)'],
          $role
        );
      });
    }

    return $roleMap[$role] ?? ucfirst($role);
  }

  public static function actionName($action)
  {
    $actionMap = [
      'add' => 'Criação',
      'delete' => 'Destruição',
      'update' => 'Edição',
      'book' => 'Agendamento',
      'login' => 'Login',
      'logout' => 'Saída',
      'view' => 'Visualização'
    ];

    return $actionMap[$action] ?? ucfirst($action);
  }

  public static function tableName($table)
  {
    $tableMap = [
      'users' => 'Usuários',
      'classes' => 'Turmas',
      'equipments' => 'Equipamentos',
      'bookings' => 'Agendamentos',
      'attendance' => 'Frequência',
      'logs' => 'Registros'
    ];

    return $tableMap[$table] ?? ucfirst($table);
  }

  public static function typeName($type)
  {
    $typeMap = [
      'notebook' => 'Notebook',
      'extensao' => 'Extensão',
      'projetor' => 'Projetor',
      'sala' => 'Sala',
      'outro' => 'Outro'
    ];

    return $typeMap[$type] ?? ucfirst($type);
  }

  public static function statusName($status)
  {
    $statusMap = [
      'disponivel' => 'Disponivel',
      'indisponivel' => 'Indisponivel',
      'agendado' => 'Agendado'
    ];

    return $statusMap[$status] ?? ucfirst($status);
  }

  public static function date($date)
  {
    $dateTime = DateTime::createFromFormat('d-m-Y H:i:s', $date);
    if ($dateTime === false) {
      throw new InvalidArgumentException('Formato de data inválido.');
    }
    return $dateTime->format('d/m/Y - H:i');
  }
}
