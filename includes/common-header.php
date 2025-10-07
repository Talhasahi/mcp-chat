<?php
$page_title = isset($page_title) ? $page_title : 'Page Title';
$page_icon = isset($page_icon) ? $page_icon : 'fas fa-home';
?>
<div <?php if ($page_title == "MCP Chat - My Prompts") echo 'style="padding: 0 20px 20px 20px;"'; ?>>
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 1.2rem;">Loading...</div>
    </div>
    <div class="main-header" style="margin: 10px 0 5px 0;">
        <div class="header-left">
            <i class="<?php echo htmlspecialchars($page_icon); ?>"></i>
            <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars($page_title); ?></p>
        </div>
        <i class="fas fa-sign-out-alt logout-icon" onclick="toggleLogoutDropdown()"></i>
        <div class="logout-dropdown" id="logoutDropdown">
            <div class="logout-item" onclick="handleLogout()">
                <i class="fas fa-sign-out-alt"></i> Log out
            </div>
        </div>
    </div>
    <hr class="main-header-line">
</div>