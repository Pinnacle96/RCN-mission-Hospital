<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = $_POST['csrf_token'] ?? '';
  $recaptchaToken = $_POST['recaptcha_token'] ?? null;
  if (!csrf_validate($token)) {
    $error = 'Invalid request.';
  } elseif (!verify_recaptcha($recaptchaToken)) {
    $error = 'reCAPTCHA failed.';
  } else {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
      $error = 'Invalid credentials.';
    } else {
      try {
        // Rate limiting based on audit logs
        $stmt = db()->prepare("SELECT COUNT(*) AS failures FROM audit_logs WHERE action = 'login_failed' AND timestamp >= (NOW() - INTERVAL ? SECOND) AND user_id IS NULL");
        $stmt->execute([LOGIN_LOCK_WINDOW]);
        $failures = (int)$stmt->fetchColumn();
        if ($failures >= LOGIN_MAX_ATTEMPTS) {
          $error = 'Too many failed attempts. Please try again later.';
        } else {
          $stmt = db()->prepare('SELECT id, name, email, password_hash, role, status FROM users WHERE email = ? LIMIT 1');
          $stmt->execute([$email]);
          $user = $stmt->fetch();
          if ($user && password_verify_secure($password, $user['password_hash']) && $user['status'] === 'active') {
            session_regenerate_id(true);
            $_SESSION['user'] = [
              'id' => (int)$user['id'],
              'name' => $user['name'],
              'email' => $user['email'],
              'role' => $user['role'],
            ];
            audit_log((int)$user['id'], 'login_success');
            header('Location: ' . url('admin/dashboard.php'));
            exit;
          } else {
            audit_log(null, 'login_failed');
            $error = 'Invalid credentials.';
          }
        }
      } catch (Throwable $e) {
        $error = 'Login error.';
      }
    }
  }
}
?>
<?php
// Disable global hero for admin login page
$hero_enable = false;
include __DIR__ . '/../includes/header.php';
?>

<style>
  :root {
    --primary-color: #4361ee;
    --primary-dark: #3a56d4;
    --secondary-color: #7209b7;
    --light-bg: #f8f9fa;
    --dark-text: #212529;
    --light-text: #6c757d;
    --error-color: #e63946;
    --success-color: #2a9d8f;
    --border-radius: 8px;
    --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
  }

  .login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 20px;
  }

  .login-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 2.5rem;
    width: 100%;
    max-width: 420px;
    transition: var(--transition);
  }

  .login-card:hover {
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
  }

  .logo {
    text-align: center;
    margin-bottom: 1.5rem;
  }

  .logo-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    margin-bottom: 1rem;
  }

  .logo-icon svg {
    width: 30px;
    height: 30px;
    fill: white;
  }

  .logo h1 {
    font-size: 1.8rem;
    color: var(--dark-text);
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  .logo p {
    color: var(--light-text);
    font-size: 0.9rem;
  }

  .alert {
    padding: 12px 16px;
    border-radius: var(--border-radius);
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .alert-error {
    background-color: rgba(230, 57, 70, 0.1);
    color: var(--error-color);
    border-left: 4px solid var(--error-color);
  }

  .alert-icon {
    flex-shrink: 0;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark-text);
  }

  .form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
  }

  .form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 12px 16px;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
  }

  .btn-icon {
    margin-right: 8px;
  }

  .security-notice {
    margin-top: 1.5rem;
    padding: 12px;
    background-color: rgba(108, 117, 125, 0.1);
    border-radius: var(--border-radius);
    font-size: 0.8rem;
    color: var(--light-text);
    text-align: center;
  }

  .security-notice svg {
    margin-right: 5px;
    vertical-align: middle;
  }

  @media (max-width: 480px) {
    .login-card {
      padding: 2rem 1.5rem;
    }

    .logo h1 {
      font-size: 1.5rem;
    }
  }

  .password-container {
    position: relative;
  }

  .toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--light-text);
  }

  .form-footer {
    margin-top: 1.5rem;
    text-align: center;
    font-size: 0.9rem;
    color: var(--light-text);
  }
</style>

<div class="login-container">
  <div class="login-card">
    <div class="logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
        </svg>
      </div>
      <h1>Admin Portal</h1>
      <p>Secure access to your dashboard</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error">
        <svg class="alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"
            fill="currentColor" />
        </svg>
        <span><?php echo esc_html($error); ?></span>
      </div>
    <?php endif; ?>

    <form method="post" class="space-y-4">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="recaptcha_token" id="recaptcha_token_login">

      <div class="form-group">
        <label class="form-label">Email Address</label>
        <input name="email" type="email" class="form-input" placeholder="admin@example.com" required>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <div class="password-container">
          <input name="password" type="password" class="form-input" placeholder="Enter your password"
            required>
          <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"
                fill="currentColor" />
            </svg>
          </button>
        </div>
      </div>

      <button class="btn btn-primary" type="submit">
        <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"
            fill="white" />
        </svg>
        Sign In
      </button>
    </form>

    <div class="security-notice">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"
          fill="currentColor" />
      </svg>
      Secure login with reCAPTCHA protection
    </div>
  </div>
</div>

<script>
  function togglePasswordVisibility() {
    const passwordInput = document.querySelector('input[name="password"]');
    const toggleButton = document.querySelector('.toggle-password');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleButton.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z" fill="currentColor"/>
                </svg>
            `;
    } else {
      passwordInput.type = 'password';
      toggleButton.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="currentColor"/>
                </svg>
            `;
    }
  }
</script>

<?php if (!empty(RECAPTCHA_SITE_KEY)): ?>
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"></script>
  <script>
    grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>', {
        action: 'login'
      }).then(function(token) {
        document.getElementById('recaptcha_token_login').value = token;
      });
    });
  </script>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>