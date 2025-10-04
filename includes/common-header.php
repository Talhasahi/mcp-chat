<?php
$page_title = isset($page_title) ? $page_title : 'Page Title';
$page_icon = isset($page_icon) ? $page_icon : 'fas fa-home';
?>

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