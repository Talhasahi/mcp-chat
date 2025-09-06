<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - Set New Password</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="login-container">
        <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
        <h1 class="login-heading">Set New Password</h1>
        <p class="login-subtext">Please set new password to pick up where you left off.</p>
        <form>
            <p class="label-text">Password</p>
            <div class="form-group">
                <input type="password" id="password" class="form-control" placeholder="Password" required>
                <span class="password-toggle" id="togglePassword"><i class="fas fa-eye-slash"></i></span>
            </div>
            <p class="label-text">Confirm Password</p>
            <div class="form-group">
                <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                <span class="password-toggle" id="toggleConfirmPassword"><i class="fas fa-eye-slash"></i></span>
            </div>
            <button type="submit" class="btn-signin">Confirm Password →</button>
        </form>
        <script>
            const password = document.getElementById("password");
            const togglePassword = document.getElementById("togglePassword");
            const confirmPassword = document.getElementById("confirmPassword");
            const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

            togglePassword.addEventListener("click", function() {
                if (password.type === "password") {
                    password.type = "text";
                    togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    password.type = "password";
                    togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            });

            toggleConfirmPassword.addEventListener("click", function() {
                if (confirmPassword.type === "password") {
                    confirmPassword.type = "text";
                    toggleConfirmPassword.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    confirmPassword.type = "password";
                    toggleConfirmPassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            });
        </script>
    </div>
</body>

</html>