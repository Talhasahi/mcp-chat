<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - Sign Up</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="login-container">
        <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
        <h1 class="login-heading">Create Account</h1>
        <p class="login-subtext">Please sign up to start your journey.</p>
        <form>
            <p class="label-text">Email</p>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="johndoe@gmail.com" required>
            </div>
            <p class="label-text">Phone</p>
            <div class="form-group">
                <input type="tel" class="form-control" placeholder="+1234567890" required>
            </div>
            <p class="label-text">Password</p>
            <div class="form-group">
                <input type="password" id="password" class="form-control" placeholder="Password" required>
                <span class="password-toggle" id="toggleIcon"><i class="fas fa-eye-slash"></i></span>
            </div>
            <button type="submit" class="btn-signin">Sign Up →</button>
            <div class="signup-link">I have already an account <a href="index.php">Sign in</a></div>
            <div class="or">Or</div>
            <div class="social-buttons">
                <img src="https://www.google.com/favicon.ico" alt="Google">
                <img src="https://www.apple.com/favicon.ico" alt="Apple">
            </div>
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
        </script>
    </div>
</body>

</html>