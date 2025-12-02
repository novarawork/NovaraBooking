<?php
session_start();

// Si ya está logueado, mandamos directo al panel
if (!empty($_SESSION['user_id'])) {
    header('Location: panel.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>El Potrero – Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --bg: #050816;
      --card-bg: #0f172a;
      --accent: #22c55e;
      --accent-soft: rgba(34, 197, 94, 0.12);
      --text-main: #e5e7eb;
      --text-muted: #9ca3af;
      --danger: #f97373;
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
      display: flex;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at top, #1f2937 0, #020617 55%, #000 100%);
      color: var(--text-main);
      padding: 16px;
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      background: linear-gradient(145deg, #020617, #020617);
      border-radius: 18px;
      padding: 28px 22px 24px;
      border: 1px solid rgba(148, 163, 184, 0.2);
      box-shadow:
        0 18px 45px rgba(0, 0, 0, 0.6),
        0 0 0 1px rgba(15, 23, 42, 0.9);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 18px;
    }

    .logo-icon {
      width: 32px;
      height: 32px;
      border-radius: 999px;
      background: radial-gradient(circle at 30% 20%, #bbf7d0 0, #22c55e 45%, #14532d 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: 700;
      color: #022c22;
      box-shadow: 0 0 18px rgba(34, 197, 94, 0.6);
    }

    .logo-text h1 {
      font-size: 18px;
      letter-spacing: 0.04em;
    }

    .logo-text span {
      display: block;
      font-size: 11px;
      color: var(--text-muted);
    }

    .title {
      font-size: 15px;
      margin-bottom: 6px;
    }

    .subtitle {
      font-size: 11px;
      color: var(--text-muted);
      margin-bottom: 18px;
    }

    .field {
      margin-bottom: 12px;
    }

    .field label {
      display: block;
      font-size: 11px;
      color: var(--text-muted);
      margin-bottom: 4px;
    }

    .field input {
      width: 100%;
      padding: 9px 10px;
      border-radius: 9px;
      border: 1px solid rgba(148, 163, 184, 0.45);
      background: rgba(15, 23, 42, 0.9);
      color: var(--text-main);
      font-size: 13px;
      outline: none;
      transition: border-color 0.15s ease, box-shadow 0.15s ease,
        background 0.15s ease;
    }

    .field input:focus {
      border-color: rgba(34, 197, 94, 0.9);
      box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.7);
      background: #020617;
    }

    .btn {
      width: 100%;
      margin-top: 6px;
      padding: 9px 12px;
      border-radius: 999px;
      border: none;
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #022c22;
      font-weight: 600;
      font-size: 13px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      box-shadow:
        0 12px 30px rgba(22, 163, 74, 0.55),
        0 0 0 1px rgba(21, 128, 61, 0.7);
      transition: transform 0.12s ease, box-shadow 0.12s ease, filter 0.12s ease;
    }

    .btn:hover {
      transform: translateY(-1px);
      filter: brightness(1.05);
      box-shadow:
        0 16px 40px rgba(21, 128, 61, 0.7),
        0 0 0 1px rgba(22, 163, 74, 0.9);
    }

    .btn:active {
      transform: translateY(0);
      box-shadow:
        0 8px 18px rgba(21, 128, 61, 0.7),
        0 0 0 1px rgba(22, 163, 74, 0.9);
    }

    .message {
      margin-top: 10px;
      font-size: 11px;
      padding: 8px 10px;
      border-radius: 8px;
      display: none;
    }

    .message.error {
      background: rgba(239, 68, 68, 0.08);
      color: #fecaca;
      border: 1px solid rgba(248, 113, 113, 0.5);
    }

    .message.success {
      background: rgba(22, 163, 74, 0.1);
      color: #bbf7d0;
      border: 1px solid rgba(22, 163, 74, 0.6);
    }

    .footer-note {
      margin-top: 14px;
      font-size: 10px;
      color: var(--text-muted);
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="logo">
      <div class="logo-icon">P</div>
      <div class="logo-text">
        <h1>El Potrero</h1>
        <span>Panel interno – Gestión de turnos</span>
      </div>
    </div>

    <h2 class="title">Ingresá a tu panel</h2>
    <p class="subtitle">Accedé a la gestión de canchas y, próximamente, al bar.</p>

    <form id="login-form" autocomplete="on">
      <div class="field">
        <label for="email">Email</label>
        <input
          id="email"
          name="email"
          type="email"
          placeholder="admin@elpotrero.com"
          required
        />
      </div>

      <div class="field">
        <label for="password">Contraseña</label>
        <input
          id="password"
          name="password"
          type="password"
          placeholder="••••••••"
          required
        />
      </div>

      <button type="submit" class="btn" id="btn-login">
        <span>Ingresar</span>
        <span>⏵</span>
      </button>

      <div id="msg" class="message"></div>

      <div class="footer-note">
        Si olvidaste tu contraseña, contactá al administrador del sistema.
      </div>
    </form>
  </div>

  <script>
    const form = document.getElementById("login-form");
    const msgEl = document.getElementById("msg");
    const btn = document.getElementById("btn-login");

    function showMessage(text, type = "error") {
      if (!msgEl) return;
      msgEl.textContent = text;
      msgEl.className = "message " + type;
      msgEl.style.display = "block";
    }

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      if (!btn) return;

      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value;

      if (!email || !password) {
        showMessage("Completá email y contraseña.", "error");
        return;
      }

      btn.disabled = true;
      btn.textContent = "Ingresando...";

      try {
        const res = await fetch("/api/auth.php?action=login", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ email, password, action: "login" }),
        });

        const data = await res.json();

        if (!data.success) {
          showMessage(data.error || "No se pudo iniciar sesión.", "error");
          btn.disabled = false;
          btn.textContent = "Ingresar";
          return;
        }

        showMessage("Ingreso correcto, redirigiendo...", "success");
        // Redirigimos al panel selector (canchas / bar)
        window.location.href = "../panel.php";
      } catch (err) {
        console.error(err);
        showMessage("Error de conexión con el servidor.", "error");
        btn.disabled = false;
        btn.textContent = "Ingresar";
      }
    });
  </script>
</body>
</html>
