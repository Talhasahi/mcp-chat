<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - Settings</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #FFFFFF;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 60px;
            background-color: #1a1a1a;
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1000;
        }

        .sidebar .logo {
            width: 50px;
            margin-bottom: 20px;
        }

        .sidebar .menu-item {
            margin: 5px 0;
            font-size: 18px;
            color: #808080;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .sidebar .menu-item.active {
            color: #00B7E5;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .menu-item:hover {
            color: #00B7E5;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .user-avatar {
            width: 40px;
            border-radius: 50%;
            margin-top: auto;
            margin-bottom: 10px;
        }

        .main-content {
            flex: 1;
            margin-left: 60px;
            padding: 0 20px 20px 20px;
            overflow-y: auto;
            height: 100vh;
        }

        .main-header {
            display: flex;
            align-items: center;
        }

        .main-header .header-left {
            display: flex;
            align-items: center;
        }

        .main-header .back-icon {
            font-size: 18px;
            color: #808080;
            margin-right: 10px;
            cursor: pointer;
        }

        .main-header .title {
            font-size: 18px;
            color: #000000;
            margin: 0;
        }

        .main-header .logout-icon {
            font-size: 18px;
            color: #808080;
            cursor: pointer;
            margin-left: auto;
            /* Pushes logout icon to the right */
            transition: color 0.3s ease;
        }

        .main-header .logout-icon:hover {
            color: #00B7E5;
        }

        .main-header .logout-dropdown {
            display: none;
            position: absolute;
            top: 40px;
            right: 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            z-index: 1000;
        }

        .main-header .logout-dropdown.active {
            display: block;
        }

        .main-header .logout-dropdown .logout-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            color: #000000;
            cursor: pointer;
            padding: 5px;
        }

        .main-header .logout-dropdown .logout-item:hover {
            color: #00B7E5;
        }

        .main-header-line {
            width: 100%;
            border: 0;
            height: 1px;
            background-color: #E2E4E9;
            margin: 5px 0 10px 0;
        }

        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .tab {
            font-size: 16px;
            color: #808080;
            padding: 8px 15px;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab.active {
            color: #000000;
            border-bottom: 2px solid #00B7E5;
            font-weight: 600;
        }

        .tab-content {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .tab-content h6 {
            font-size: 18px;
            color: #000000;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .tab-content p {
            font-size: 14px;
            color: #808080;
            margin-bottom: 20px;
        }

        .tab-content .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .tab-content .form-group {
            flex: 1;
        }

        .tab-content .form-label {
            font-size: 14px;
            color: #000000;
            margin-bottom: 5px;
            display: block;
        }

        .tab-content .form-input {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #E4E4E7;
            padding: 6px;
            font-size: 14px;
            background-color: white;
            outline: none;
        }

        .tab-content .form-input:focus {
            border-color: transparent;
            box-shadow: 0 0 5px #00B7E5;
        }

        .tab-content .toggle-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .tab-content .toggle-btn {
            width: 50px;
            height: 25px;
            background-color: #E4E4E7;
            border-radius: 12.5px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .tab-content .toggle-btn.active {
            background-color: #00B7E5;
        }

        .tab-content .toggle-btn .toggle-circle {
            width: 21px;
            height: 21px;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform 0.3s ease;
        }

        .tab-content .toggle-btn.active .toggle-circle {
            transform: translateX(25px);
            /* Full right side when active */
        }

        .tab-content .model-section {
            display: none;
            margin-top: 15px;
        }

        .tab-content .model-section.active {
            display: block;
        }

        .tab-content .form-select {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #E4E4E7;
            padding: 6px;
            font-size: 14px;
            background-color: white;
            outline: none;
        }

        .tab-content .form-select:focus {
            border-color: transparent;
            box-shadow: 0 0 5px #00B7E5;
        }

        .tab-content .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .tab-content .save-btn,
        .tab-content .cancel-btn {
            flex: 1;
            background-color: #00B7E5;
            color: #FFFFFF;
            border: none;
            border-radius: 25px;
            padding: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #00B7E5;
        }

        .tab-content .cancel-btn {
            background-color: #FFFFFF;
            color: #00B7E5;
        }

        .tab-content .save-btn:hover {
            background-color: #FFFFFF;
            color: #00B7E5;
            border: 1px solid #00B7E5;
        }

        .tab-content .cancel-btn:hover {
            background-color: #00B7E5;
            color: #FFFFFF;
            border: 1px solid #00B7E5;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 50px;
            }

            .main-content {
                margin-left: 50px;
                padding: 0 15px 20px 15px;
            }

            .main-header {
                margin: 5px 0 5px 0;
            }

            .main-header-line {
                margin: 3px 0 8px 0;
            }

            .tabs {
                flex-direction: column;
                gap: 10px;
            }

            .tab {
                padding: 5px 10px;
            }

            .toggle-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .model-section {
                margin-top: 10px;
            }

            .button-group {
                flex-direction: column;
                gap: 10px;
            }

            .main-header .logout-dropdown {
                right: 15px;
            }
        }
    </style>
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