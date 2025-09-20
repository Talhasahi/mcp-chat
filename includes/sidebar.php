<div class="sidebar">
    <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
    <a href="dashboad.php" class="menu-item <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboad.php') ? 'active' : ''; ?>">
        <i class="fas fa-home"></i>
    </a>
    <a href="prompt_library.php"
        class="menu-item <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['prompt_library.php', 'prompt_library_detail.php'])) ? 'active' : ''; ?>">
        <i class="fas fa-layer-group"></i>
    </a>

    <a href="settings.php" class="menu-item <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>">
        <i class="fas fa-gear"></i>
    </a>
    <img src="assets/images/user-avatar.png" alt="User Avatar" class="user-avatar">
</div>