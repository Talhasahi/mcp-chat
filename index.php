<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCP Chat - Sign In</title>
  <link rel="icon" type="image/png" href="assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <div class="login-container">
    <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
    <h1 class="login-heading">Welcome Back</h1>
    <p class="login-subtext">Please sign in to pick up where you left off.</p>
    <form id="loginForm">
      <p class="label-text">Email</p>
      <div class="form-group">
        <input type="email" id="email" class="form-control" placeholder="johndoe@gmail.com" value="" required>
      </div>
      <p class="label-text">Password</p>
      <div class="form-group">
        <input type="password" id="password" class="form-control" placeholder="Password" required>
        <span class="password-toggle" id="toggleIcon"><i class="fas fa-eye-slash"></i></span>

      </div>
      <button type="submit" class="btn-signin">Sign In →</button>
      <span id="error-message" class="error-message" style="color: red; font-size: 0.875em; display: none;"></span> <!-- New error span -->
      <a href="forgot.php" class="forgot-password">Forgot Password?</a>
      <!-- <div class="signup-link">Don’t you have an account? <a href="signup.php">Sign up</a></div> -->
      <!-- <div class="or">Or</div> -->
      <!-- <div class="social-buttons">
        <img src="https://www.google.com/favicon.ico" alt="Google">
        <img src="https://www.apple.com/favicon.ico" alt="Apple">
      </div> -->
    </form>
    <script>
      const password = document.getElementById("password");
      const toggleIcon = document.getElementById("toggleIcon");
      toggleIcon.addEventListener("click", function() {
        if (password.type === "password") {
          password.type = "text";
          toggleIcon.innerHTML = '<i class="fas fa-eye"></i>';
        } else {
          password.type = "password";
          toggleIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
        }
      });

      // AJAX login via proxy
      const form = document.getElementById('loginForm');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const errorSpan = document.getElementById('error-message'); // New

      // Function to show/hide error
      function showError(message) {
        errorSpan.textContent = message;
        errorSpan.style.display = 'block';
      }

      function clearError() {
        errorSpan.textContent = '';
        errorSpan.style.display = 'none';
      }

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearError(); // Clear on submit

        const data = {
          email: emailInput.value.trim(),
          password: passwordInput.value
        };

        try {
          const response = await fetch('auth/login.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          });

          const result = await response.json();

          if (response.ok) {
            localStorage.setItem('token', result.token); // Optional
            window.location.href = 'dashboard.php'; // Redirect
          } else {
            // Show red span below password
            showError(result.error || 'Login failed');
            passwordInput.focus(); // Refocus password for re-entry
          }
        } catch (error) {
          showError('Network error: ' + error.message);
        }
      });

      // Auto-redirect if logged in (unchanged)
      fetch('check_session.php')
        .then(res => res.json())
        .then(data => {
          if (data.logged_in) window.location.href = 'dashboard.php';
        })
        .catch(() => {}); // Ignore errors
    </script>


  </div>
</body>



</html>