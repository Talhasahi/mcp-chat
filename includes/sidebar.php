<div class="sidebar">
    <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">

    <a style="text-decoration: none;" href="dashboard.php" class="menu-item <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="fas fa-home"></i>
    </a>
    <a style="text-decoration: none;" href="prompt_library.php"
        class="menu-item <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['prompt_library.php', 'prompt_library_detail.php'])) ? 'active' : ''; ?>">
        <i class="fas fa-layer-group"></i>
    </a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'author'): ?>
        <a style="text-decoration: none;" href="category.php"
            class="menu-item <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['category.php', 'category.php'])) ? 'active' : ''; ?>">
            <i class="fas fa-tags"></i>

        </a>
    <?php endif; ?>
    <a style="text-decoration: none;" href="my_prompt.php" class="menu-item <?php echo (basename($_SERVER['PHP_SELF']) == 'my_prompt.php') ? 'active' : ''; ?>">
        <i class="fas fa-plus"></i>
    </a>

    <a style="text-decoration: none;" href="settings.php" class="menu-item <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>">
        <i class="fas fa-gear"></i>
    </a>
    <img src="assets/images/user-avatar.png" alt="User Avatar" class="user-avatar">
</div>