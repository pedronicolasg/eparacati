<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'Exo', Arial, sans-serif;
      color: #333;
      line-height: 1.4;
      width: 210mm;
      min-height: 297mm;
      padding: 10mm;
      margin: 0;
      background-color: #fff;
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #10b981;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }

    .header h1 {
      color: #10b981;
      margin-bottom: 3px;
      font-size: 16px;
      font-weight: bold;
    }

    .header p {
      color: #666;
      font-size: 10px;
      margin: 0;
    }

    .section {
      margin-bottom: 10px;
      padding: 8px;
      background-color: #f9f9f9;
      border-radius: 3px;
      border-left: 3px solid #10b981;
    }

    .section h2 {
      color: #10b981;
      margin: 0 0 5px 0;
      font-size: 14px;
      font-weight: bold;
      border-bottom: 1px solid #ddd;
      padding-bottom: 3px;
    }

    .info-grid {
      display: block;
      margin-top: 5px;
    }

    .info-item {
      margin-bottom: 5px;
      display: block;
      overflow: hidden;
    }

    .info-label {
      font-weight: bold;
      color: #555;
      font-size: 12px;
      display: inline-block;
      width: 30%;
      vertical-align: top;
    }

    .info-value {
      font-size: 12px;
      display: inline-block;
      width: 68%;
      vertical-align: top;
      margin-top: 0;
    }

    .notes {
      background-color: #fffbeb;
      border-left: 3px solid #f59e0b;
      padding: 8px;
      margin-top: 10px;
      border-radius: 3px;
    }

    .notes h3 {
      color: #b45309;
      margin: 0 0 5px 0;
      font-size: 12px;
      font-weight: bold;
    }

    .notes p {
      font-size: 10px;
      margin: 0;
    }

    .footer {
      text-align: center;
      font-size: 10px;
      color: #666;
      margin-top: 10px;
      border-top: 1px solid #ddd;
      padding-top: 5px;
    }

    .equipment-image {
      text-align: center;
      margin: 8px 0;
    }

    .equipment-image img {
      max-width: 150px;
      max-height: 90px;
      border: 1px solid #ddd;
      border-radius: 3px;
      padding: 2px;
    }

    @media print {
      body {
        padding: 0;
        margin: 0;
      }

      .section {
        page-break-inside: avoid;
      }

      .equipment-image img {
        max-width: 140px;
        max-height: 80px;
      }
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>Agendamento #<?php echo $schedule['id']; ?></h1>
    <p>Gerado em <?php echo date('d/m/Y H:i'); ?></p>
  </div>

  <div class="section">
    <h2>Equipamento</h2>
    <div class="equipment-image">
      <img src="<?php echo (!empty($equipment['image']) ? $equipment['image'] : 'https://placehold.co/400x300.png'); ?>" alt="<?php echo $equipment['name']; ?>">
    </div>
    <div class="info-grid">
      <div class="info-item">
        <span class="info-label">Nome:</span>
        <span class="info-value"><?php echo $equipment['name']; ?></span>
      </div>
      <div class="info-item">
        <span class="info-label">ID:</span>
        <span class="info-value"><?php echo $equipment['id']; ?></span>
      </div>
      <div class="info-item">
        <span class="info-label">Descrição:</span>
        <span class="info-value"><?php echo $equipment['description']; ?></span>
      </div>
    </div>
  </div>

  <div class="section">
    <h2>Usuário</h2>
    <div class="info-grid">
      <div class="info-item">
        <span class="info-label">Nome:</span>
        <span class="info-value"><?php echo $user['name']; ?></span>
      </div>
      <div class="info-item">
        <span class="info-label">Cargo:</span>
        <span class="info-value"><?php echo Format::roleName($user['role']); ?></span>
      </div>
    </div>
  </div>

  <div class="section">
    <h2>Detalhes do Horário</h2>
    <div class="info-grid">
      <div class="info-item">
        <span class="info-label">Data:</span>
        <span class="info-value"><?php echo $formattedDate; ?></span>
      </div>
      <div class="info-item">
        <span class="info-label">Horário:</span>
        <span class="info-value"><?php echo $selectedTimeSlot['name'] . ' (' . $selectedTimeSlot['start'] . ' - ' . $selectedTimeSlot['end'] . ')'; ?></span>
      </div>
      <?php if ($class): ?>
        <div class="info-item">
          <span class="info-label">Turma:</span>
          <span class="info-value"><?php echo $class['name']; ?> (<?php echo $class['grade']; ?>ª Série)</span>
        </div>
      <?php endif; ?>
      <div class="info-item">
        <span class="info-label">ID do Agendamento:</span>
        <span class="info-value"><?php echo $schedule['id']; ?></span>
      </div>
    </div>
  </div>

  <?php if (!empty($schedule['note'])): ?>
    <div class="notes">
      <h3>Observações</h3>
      <p><?php echo $schedule['note']; ?></p>
    </div>
  <?php endif; ?>

  <div class="footer">
    <p>Este documento foi gerado automaticamente pelo sistema Agendaê da EP Aracati.</p>
  </div>
</body>

</html>