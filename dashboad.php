<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - AI Desk</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/mcp.css">
</head>

<body>
    <div class="sidebar">
        <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
        <div class="menu-item active"><i class="fas fa-home"></i></div>
        <div class="menu-item"><i class="fas fa-layer-group"></i></div>
        <div class="menu-item"><i class="fas fa-plus"></i></div>
        <div class="settings-icon"><i class="fas fa-cog"></i></div>
        <img src="assets/images/user-avatar.png" alt="User Avatar" class="user-avatar">
    </div>
        <div class="main-content" style="padding: 0 20px 120px 20px;">
            <div class="main-header" style="margin: 10px 0 5px 0;">
                <div class="header-left">
                    <i class="fas fa-home"></i>
                    <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AI Desk</p>
                </div>
                <i class="fas fa-sign-out-alt logout-icon" onclick="toggleLogoutDropdown()"></i>
                <div class="logout-dropdown" id="logoutDropdown">
                    <div class="logout-item" onclick="handleLogout()">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </div>
                </div>
            </div>
            <hr class="main-header-line">
            <img src="assets/images/logo-icon.png" alt="Central Logo" class="central-logo">
            <h1 class="main-heading">How can we assist you today?</h1>
            <p class="main-subtext">Get instant support from curated AI prompts crafted for productivity, creativity, and decision-making. Choose a prompt to get started, or explore more from the Prompt Library.</p>
            <button class="primary-btn">Explore More Prompts →</button>
            <div class="prompt-cards">
                <div class="prompt-card">
                    <h3>Brainstorm Ideas</h3>
                    <p>Unlock creative solutions, business names, or marketing angles in seconds.</p>
                    <span class="arrow">→</span>
                </div>
                <div class="prompt-card">
                    <h3>Summarize Key Insights</h3>
                    <p>Paste long content and instantly get a sharp, executive summary.</p>
                    <span class="arrow">→</span>
                </div>
                <div class="prompt-card">
                    <h3>Polish My Writing</h3>
                    <p>Improve grammar, clarity, and tone of your drafts or messages.</p>
                    <span class="arrow">→</span>
                </div>
                <div class="prompt-card">
                    <h3>Generate a Strategy Plan</h3>
                    <p>Build a quick outline or action plan for your project or team goals.</p>
                    <span class="arrow">→</span>
                </div>
            </div>
        </div>
    <div class="suggested-prompts">
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Suggest taglines for a luxury perfume</div>
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>What are some launch campaign ideas?</div>
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Give me 5 name ideas for a skincare brand</div>
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Write a LinkedIn post announcing a product launch</div>
    </div>
    <div class="chat-input mb-2">
        <i class="fas fa-paperclip attachment"></i>
        <input type="text" placeholder="Message to Ai Chat...">
        <i class="far fa-smile emoji"></i>
        <i class="fas fa-microphone mic"></i>
        <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
    </div>

    <script>
        function toggleLogoutDropdown() {
            const dropdown = document.getElementById('logoutDropdown');
            dropdown.classList.toggle('active');
        }

        function handleLogout() {
            // Add logout logic here (e.g., redirect or API call)
            alert('Logged out!'); // Placeholder action
            document.getElementById('logoutDropdown').classList.remove('active');
        }

        // Close dropdown if clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('logoutDropdown');
            const icon = document.querySelector('.logout-icon');
            if (!icon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
</body>

</html>