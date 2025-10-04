<?php
$page_title = "MCP Chat - Settings";
$page_icon = "fas fa-gear";
include 'includes/header.php';
include 'includes/sidebar.php';

?>
<div class="main-content">


    <?php include 'includes/common-header.php'; ?>
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
</script>
<?php include 'includes/footer.php'; ?>