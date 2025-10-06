<?php
// mcp-tools.php
?>
<i class="fas fa-tools attachment" onclick="toggleToolsDropdown()"></i>

<style>
    .tools-dropdown {
        position: absolute;
        bottom: 100%;
        /* Position above the icon */
        left: 0;
        background-color: #FFFFFF;
        border: 1px solid #E4E4E7;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 250px;
        z-index: 1000;
        display: none;
        padding: 10px 0;
        overflow: hidden;
        /* For smooth sub expansion */
    }

    .tools-dropdown.active {
        display: block;
    }

    .tools-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        font-size: 14px;
        color: #000000;
        border-bottom: 1px solid #F0F0F0;
        position: relative;
        overflow: hidden;
    }

    .tools-item:last-child {
        border-bottom: none;
    }

    .tools-item:hover {
        background-color: #F0F0F0;
    }

    .tools-item i {
        margin-right: 10px;
        width: 16px;
        color: #00B7E5;
    }

    /* Sub-dropdown styles - vertical below parent with animation */
    .sub-tools-dropdown {
        background-color: #FFFFFF;
        border: 1px solid #E4E4E7;
        border-top: none;
        /* Seamless connection */
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-height: 0;
        /* Start collapsed */
        overflow: hidden;
        z-index: 1001;
        transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
        opacity: 0;
        padding: 0;
    }

    .sub-tools-dropdown.active {
        max-height: 300px;
        /* Expand to max needed height */
        opacity: 1;
        padding: 0 0 10px 0;
        /* Add bottom padding when open */
    }

    .sub-tools-item {
        padding: 8px 20px;
        /* Reduced padding for less space */
        cursor: pointer;
        transition: background-color 0.2s ease;
        font-size: 13px;
        color: #333333;
        border-bottom: 1px solid #F8F8F8;
        line-height: 1.3;
    }

    .sub-tools-item:last-child {
        border-bottom: none;
    }

    .sub-tools-item:hover {
        background-color: #F8F8F8;
    }

    .tools-item.has-sub::after {
        content: '▾';
        position: absolute;
        right: 15px;
        font-size: 12px;
        color: #999999;
        transition: transform 0.2s ease;
    }

    .tools-item.has-sub.active::after {
        transform: rotate(180deg);
    }

    .attachment {
        color: #000000;
        /* Default color */
        transition: color 0.2s ease;
    }

    .attachment.active {
        color: #00B7E5;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .tools-dropdown {
            min-width: 200px;
            left: -50px;
            /* Adjust position if needed */
        }

        .sub-tools-dropdown {
            max-height: none;
            /* No height limit on mobile */
            transition: none;
            /* Disable animation on mobile for simplicity */
            border: none;
            border-top: 1px solid #E4E4E7;
            border-radius: 0;
            opacity: 1;
        }

        .sub-tools-dropdown.active {
            padding: 0 0 10px 0;
        }
    }
</style>

<div class="tools-dropdown" id="toolsDropdown">
    <div class="tools-item has-sub" onclick="toggleSubTools('energy')">
        <i class="fas fa-bolt"></i>
        Energy Tools
    </div>
    <div class="sub-tools-dropdown" id="sub-energy">
        <?php if (isset($_SESSION['energy_mcp_tools']['tools'])): ?>
            <?php foreach ($_SESSION['energy_mcp_tools']['tools'] as $tool): ?>
                <div class="sub-tools-item" title="<?= htmlspecialchars($tool['description'] ?? '') ?>" onclick="selectSubTool('Energy', '<?= htmlspecialchars($tool['title'] ?? '') ?>')">
                    <?= htmlspecialchars($tool['title'] ?? '') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="tools-item has-sub" onclick="toggleSubTools('brevo')">
        <i class="fas fa-envelope"></i>
        Brevo Tools
    </div>


    <div class="sub-tools-dropdown" id="sub-brevo">
        <?php if (isset($_SESSION['brevo_mcp_tools']['tools'])): ?>
            <?php foreach ($_SESSION['brevo_mcp_tools']['tools'] as $tool): ?>
                <div class="sub-tools-item" title="<?= htmlspecialchars($tool['description'] ?? '') ?>" onclick="selectSubTool('Brevo', '<?= htmlspecialchars($tool['title'] ?? '') ?>')">
                    <?= htmlspecialchars($tool['title'] ?? '') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="tools-item has-sub" onclick="toggleSubTools('xml')">
        <i class="fas fa-code"></i>
        XML Tools
    </div>
    <div class="sub-tools-dropdown" id="sub-xml">
        <?php if (isset($_SESSION['xml_mcp_tools']['tools'])): ?>
            <?php foreach ($_SESSION['xml_mcp_tools']['tools'] as $tool): ?>
                <div class="sub-tools-item" title="<?= htmlspecialchars($tool['description'] ?? '') ?>" onclick="selectSubTool('XML', '<?= htmlspecialchars($tool['title'] ?? '') ?>')">
                    <?= htmlspecialchars($tool['title'] ?? '') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleToolsDropdown() {
        const dropdown = document.getElementById('toolsDropdown');
        const icon = document.querySelector('.attachment');
        dropdown.classList.toggle('active');
        icon.classList.toggle('active');
    }

    function toggleSubTools(category) {
        // Close all other sub-dropdowns first
        document.querySelectorAll('.sub-tools-dropdown').forEach(sub => {
            if (sub.id !== 'sub-' + category) {
                sub.classList.remove('active');
                sub.previousElementSibling.classList.remove('active');
            }
        });

        // Toggle the current one
        const subDropdown = document.getElementById('sub-' + category);
        const parentItem = subDropdown.previousElementSibling;
        parentItem.classList.toggle('active');
        subDropdown.classList.toggle('active');
    }

    function selectSubTool(category, toolName) {
        // Handle selection (e.g., alert or integrate with chat)
        alert('Selected: ' + category + ' - ' + toolName); // Placeholder - replace with actual logic
        // Close all dropdowns
        document.getElementById('toolsDropdown').classList.remove('active');
        document.querySelector('.attachment').classList.remove('active');
        document.querySelectorAll('.tools-item.has-sub').forEach(item => item.classList.remove('active'));
        document.querySelectorAll('.sub-tools-dropdown').forEach(sub => sub.classList.remove('active'));
    }

    // Close dropdown on outside click
    document.addEventListener('click', function(event) {
        const icon = document.querySelector('.attachment');
        const dropdown = document.getElementById('toolsDropdown');
        if (!icon.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
            icon.classList.remove('active');
            // Also close subs
            document.querySelectorAll('.tools-item.has-sub').forEach(item => item.classList.remove('active'));
            document.querySelectorAll('.sub-tools-dropdown').forEach(sub => sub.classList.remove('active'));
        }
    });
</script>