<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['user_name'] ?? 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>El Potrero – Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --bg: #020617;
      --card-bg: #020617;
      --accent: #22c55e;
      --accent-soft: rgba(34, 197, 94, 0.12);
      --text-main: #e5e7eb;
      --text-muted: #9ca3af;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "SF Pro Text",
        "Segoe UI", sans-serif;
    }

    body {
      min-height: 100vh;
      background: radial-gradient(circle at top, #1f2937 0, #020617 55%, #000 100%);
      color: var(--text-main);
      padding: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .wrapper {
      width: 100%;
      max-width: 960px;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 18px;
    }

    .top-title {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .top-title h1 {
      font-size: 18px;
      letter-spacing: 0.04em;
    }

    .top-title span {
      font-size: 11px;
      color: var(--text-muted);
    }

    .user-pill {
      font-size: 11px;
      padding: 6px 10px;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.9);
      border: 1px solid rgba(148, 163, 184, 0.4);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .user-pill strong {
      color: var(--accent);
    }

    .grid {
      display: grid;
      grid-template-columns: minmax(0, 1fr);
      gap: 14px;
    }

    @media (min-width: 720px) {
      .grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    .card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 18px 16px;
      border: 1px solid rgba(148, 163, 184, 0.25);
      box-shadow:
        0 18px 45px rgba(0, 0, 0, 0.55),
        0 0 0 1px rgba(15, 23, 42, 0.9);
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .card h2 {
      font-size: 15px;
      margin-bottom: 2px;
    }

    .card p {
      font-size: 11px;
      color: var(--text-muted);
    }

    .pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 10px;
      border-radius: 999px;
      padding: 4px 8px;
      background: rgba(15, 23, 42, 0.9);
      border: 1px solid rgba(148, 163, 184, 0.4);
      margin-top: 4px;
    }

    .pill span {
      color: var(--accent);
    }

    .btn-primary,
    .btn-disabled {
      margin-top: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 9px 13px;
      border-radius: 999px;
      font-size: 12px;
      border: none;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #022c22;
      box-shadow:
        0 12px 30px rgba(22, 163, 74, 0.55),
        0 0 0 1px rgba(21, 128, 61, 0.7);
      transition: transform 0.12s ease, box-shadow 0.12s ease, filter 0.12s ease;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      filter: brightness(1.05);
      box-shadow:
        0 16px 40px rgba(21, 128, 61, 0.7),
        0 0 0 1px rgba(22, 163, 74, 0.9);
    }

    .btn-disabled {
      background: rgba(15, 23, 42, 0.85);
      color: #6b7280;
      border: 1px dashed rgba(75, 85, 99, 0.7);
      cursor: not-allowed;
    }

    .logout {
      margin-top: 16px;
      text-align: right;
    }

    .logout a {
      font-size: 10px;
      color: var(--text-muted);
      text-decoration: none;
    }

    .logout a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="top-bar">
      <div class="top-title">
        <h1>Panel de El Potrero</h1>
        <span>Elegí qué querés gestionar</span>
      </div>
      <div class="user-pill">
        <span>Sesión:</span>
        <strong><?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></strong>
      </div>
    </div>

    <div class="grid">
      <!-- CANCHAS -->
      <div class="card">
        <h2>Canchas de fútbol</h2>
        <p>
          Gestioná turnos, pagos y clientes de las canchas de fútbol 7.
          Acceso al panel completo que ya estuvimos construyendo.
        </p>
        <div class="pill">
          <span>●</span> Módulo activo
        </div>
        <a href="admin/admin.php" class="btn-primary">
          <span>Ir al panel de canchas</span>
          <span>⏵</span>
        </a>
      </div>

      <!-- BAR -->
      <div class="card">
        <h2>Bar y consumos</h2>
        <p>
          Próximamente vas a poder llevar el control de comandas, mesas, consumos
          y cierres de caja del bar de El Potrero, todo en el mismo sistema.
        </p>
        <div class="pill">
          <span>●</span> Próximamente
        </div>
        <button class="btn-disabled" disabled>
          En desarrollo
        </button>
      </div>
    </div>

    <div class="logout">
      <a href="logout.php">Cerrar sesión</a>
    </div>
  </div>
</body>
</html>
