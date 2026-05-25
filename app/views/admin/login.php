<?php
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login — CivilLanka</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    /* ── Reset ───────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }

    body {
      font-family: 'Inter', sans-serif;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      color: #1a1a1a;
    }

    /* ── Animated background ─────────────────── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse at 20% 50%, rgba(200,169,126,0.08) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 20%, rgba(230,230,230,0.5) 0%, transparent 50%);
      z-index: 0;
      animation: bgPulse 8s ease-in-out infinite alternate;
    }

    @keyframes bgPulse {
      from { opacity: 0.6; }
      to   { opacity: 1; }
    }

    /* ── Login card ──────────────────────────── */
    .login-card {
      position: relative;
      z-index: 1;
      width: 420px;
      max-width: 92vw;
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid rgba(0,0,0,0.05);
      border-radius: 20px;
      padding: 48px 40px;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      box-shadow:
        0 20px 60px rgba(0,0,0,0.05),
        inset 0 0 0 1px rgba(255,255,255,0.5);
      animation: cardIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(30px) scale(0.96); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── Logo ────────────────────────────────── */
    .login-logo {
      text-align: center;
      margin-bottom: 12px;
    }

    .login-logo img {
      height: 60px;
      opacity: 0.95;
    }

    .login-subtitle {
      text-align: center;
      font-size: 0.7rem;
      letter-spacing: 0.35em;
      text-transform: uppercase;
      color: #999;
      margin-bottom: 40px;
    }

    /* ── Form inputs ─────────────────────────── */
    .form-group {
      position: relative;
      margin-bottom: 24px;
    }

    .form-group input {
      width: 100%;
      padding: 16px 18px;
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      color: #1a1a1a;
      font-size: 0.95rem;
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
    }

    .form-group input::placeholder {
      color: #94a3b8;
      font-weight: 400;
    }

    .form-group input:focus {
      border-color: #c8a97e;
      background: #fff;
      box-shadow: 0 0 0 4px rgba(200,169,126,0.1);
    }

    /* ── Submit button ───────────────────────── */
    .login-btn {
      width: 100%;
      padding: 16px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(135deg, #c8a97e 0%, #a8875c 100%);
      color: #fff;
      font-size: 0.85rem;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.3s;
      margin-top: 8px;
    }

    .login-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(200,169,126,0.25);
    }

    .login-btn:active {
      transform: translateY(0);
    }

    /* ── Error message ───────────────────────── */
    .login-error {
      background: #fef2f2;
      border: 1px solid #fee2e2;
      border-radius: 10px;
      padding: 12px 16px;
      margin-bottom: 20px;
      color: #ef4444;
      font-size: 0.82rem;
      display: none;
      animation: shake 0.4s ease;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-6px); }
      40%, 80% { transform: translateX(6px); }
    }

    .login-error.show { display: block; }

    /* ── Back link ───────────────────────────── */
    .back-link {
      display: block;
      text-align: center;
      margin-top: 28px;
      color: #94a3b8;
      font-size: 0.75rem;
      text-decoration: none;
      letter-spacing: 0.06em;
      transition: color 0.3s;
    }
    .back-link:hover { color: #64748b; }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="login-logo">
      <img src="<?= $BASE ?>/Logos/trans.PNG" alt="CivilLanka" />
    </div>
    <p class="login-subtitle">Admin Panel</p>

    <div id="login-error" class="login-error"></div>

    <form id="login-form" autocomplete="off">
      <div class="form-group">
        <input type="text" id="username" name="username" placeholder="Username" autocomplete="username" required />
      </div>
      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Password" autocomplete="current-password" required />
      </div>
      <button type="submit" class="login-btn" id="login-submit">Sign In</button>
    </form>

    <a href="<?= $BASE ?>/" class="back-link">← Back to website</a>
  </div>

  <script>
    const form   = document.getElementById('login-form');
    const errBox = document.getElementById('login-error');
    const btn    = document.getElementById('login-submit');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      errBox.classList.remove('show');
      btn.textContent = 'Signing in…';
      btn.disabled = true;

      const fd = new FormData(form);

      try {
        const res  = await fetch('<?= $BASE ?>/api/auth?action=login', { method: 'POST', body: fd });
        const data = await res.json();

        if (data.success) {
          window.location.href = '<?= $BASE ?>/admin';
        } else {
          errBox.textContent = data.error || 'Login failed';
          errBox.classList.add('show');
          btn.textContent = 'Sign In';
          btn.disabled = false;
        }
      } catch (err) {
        console.error('Login request failed:', err);
        errBox.textContent = 'Network error';
        errBox.classList.add('show');
        btn.textContent = 'Sign In';
        btn.disabled = false;
      }
    });
  </script>
</body>
</html>
