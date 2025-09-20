<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - Settings</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/mcp.css">
</head>

<body>
    <div class="sidebar">
        <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
        <div class="menu-item"><i class="fas fa-home"></i></div>
        <div class="menu-item active"><i class="fas fa-layer-group"></i></div>
        <div class="menu-item"><i class="fas fa-plus"></i></div>
        <img src="assets/images/user-avatar.png" alt="User Avatar" class="user-avatar">
        <div class="menu-item"><i class="fas fa-gear"></i></div>
    </div>
    <div class="main-content">
        <div class="main-header" style="margin: 10px 0 5px 0;">
            <div class="header-left">
                <i class="fas fa-gear"></i>
                <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Settings</p>
            </div>
            <i class="fas fa-sign-out-alt logout-icon" onclick="toggleLogoutDropdown()"></i>
            <div class="logout-dropdown" id="logoutDropdown">
                <div class="logout-item" onclick="handleLogout()">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </div>
            </div>
        </div>
        <hr class="main-header-line">
        <div class="tabs">
            <div class="tab active" data-tab="account">Account Detail</div>
            <div class="tab" data-tab="preferences">Preferences</div>
        </div>
        <div class="tab-content" id="account">
            <h6>Account Detail</h6>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-input" value="JaneCooper" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" value="jane.cooper@example.com" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-input" value="+1-555-123-4567" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Change Password</label>
                    <input type="password" class="form-input" placeholder="Enter new password">
                </div>
            </div>
            <div class="button-group">
                <button class="save-btn">Save Changes</button>
                <button class="cancel-btn">Cancel</button>
            </div>
        </div>
        <div class="tab-content" id="preferences" style="display: none;">
            <h6>Preferences</h6>
            <p>Manage your preferences</p>
            <div class="toggle-group">
                <label class="form-label">A/B Testing</label>
                <div class="toggle-btn" id="abTestingToggle" onclick="toggleABTesting()">
                    <div class="toggle-circle"></div>
                </div>
            </div>
            <div class="model-section" id="modelSection">
                <h6>Model 1</h6>
                <div class="form-group">
                    <label class="form-label">Select Model</label>
                    <select class="form-select">
                        <option value="grok">Grok</option>
                        <option value="chatgpt">Chat GPT</option>
                    </select>
                </div>
            </div>
            <div class="button-group">
                <button class="save-btn">Save Changes</button>
                <button class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const tabId = this.getAttribute('data-tab');
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.style.display = 'none';
                });
                document.getElementById(tabId).style.display = 'block';
            });
        });

        function toggleABTesting() {
            const toggleBtn = document.getElementById('abTestingToggle');
            const modelSection = document.getElementById('modelSection');
            toggleBtn.classList.toggle('active');
            modelSection.classList.toggle('active');
        }

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