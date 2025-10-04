<?php
$page_title = "MCP Chat - Settings";
$page_icon = "fas fa-gear";
include 'includes/header.php';
include 'includes/sidebar.php';

// Get user preferences
$prefs = get_user_preferences();
$prefs_error = isset($prefs['error']) ? $prefs['error'] : null;
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
                <label class="form-label">Hotel</label>
                <input disabled type="text" class="form-input" value="<?php echo htmlspecialchars($_SESSION['hotel_name'] ?? 'N/A'); ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">My Role</label>
                <input disabled type="text" class="form-input" value="<?php echo htmlspecialchars($_SESSION['role'] ?? 'N/A'); ?>" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input disabled type="text" class="form-input" value="<?php echo htmlspecialchars($_SESSION['user_id'] ?? 'N/A'); ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input disabled type="email" class="form-input" value="<?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?>" readonly>
            </div>
        </div>
        <div class="form-row">
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
        <?php if ($prefs_error): ?>
            <p style="color: red; font-size: 0.9rem; margin-top: 0;">
                <?php echo htmlspecialchars($prefs_error); ?>
            </p>
        <?php endif; ?>
        <p>Manage your preferences</p>
        <div class="form-group">
            <label class="form-label">Default Provider</label>
            <select id="default-provider" class="form-select">
                <option value="">Select Default</option>
                <option value="openai" <?php echo isset($prefs['userPrefs']['defaultProvider']) && $prefs['userPrefs']['defaultProvider'] === ' ' ? 'selected' : ''; ?>>OpenAI</option>
                <option value="deepseek" <?php echo isset($prefs['userPrefs']['defaultProvider']) && $prefs['userPrefs']['defaultProvider'] === 'deepseek' ? 'selected' : ''; ?>>Deepseek</option>
                <option value="perplexity" <?php echo isset($prefs['userPrefs']['defaultProvider']) && $prefs['userPrefs']['defaultProvider'] === 'perplexity' ? 'selected' : ''; ?>>Perplexity</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Enabled Providers</label>
            <div class="toggle-group">
                <label>OpenAI
                    <input type="checkbox" id="provider-openai"
                        <?php echo isset($prefs['userPrefs']['enabledProviders']) && in_array('openai', $prefs['userPrefs']['enabledProviders']) ? 'checked' : ''; ?>>
                </label>
                <label>Deepseek
                    <input type="checkbox" id="provider-deepseek"
                        <?php echo isset($prefs['userPrefs']['enabledProviders']) && in_array('deepseek', $prefs['userPrefs']['enabledProviders']) ? 'checked' : ''; ?>>
                </label>
                <label>Perplexity
                    <input type="checkbox" id="provider-perplexity"
                        <?php echo isset($prefs['userPrefs']['enabledProviders']) && in_array('perplexity', $prefs['userPrefs']['enabledProviders']) ? 'checked' : ''; ?>>
                </label>
            </div>
        </div>
        <div class="form-group" id="models-section">
            <label class="form-label">Models</label>
            <div id="model-openai-group">
                <label>OpenAI Model</label>
                <select id="model-openai" class="form-select">
                    <option value="gpt-4o-mini" <?php echo isset($prefs['userPrefs']['models']['openai']) && $prefs['userPrefs']['models']['openai'] === 'gpt-4o-mini' ? 'selected' : ''; ?>>gpt-4o-mini</option>
                    <option value="gpt-4o" <?php echo isset($prefs['userPrefs']['models']['openai']) && $prefs['userPrefs']['models']['openai'] === 'gpt-4o' ? 'selected' : ''; ?>>gpt-4o</option>
                    <option value="gpt-3.5-turbo" <?php echo isset($prefs['userPrefs']['models']['openai']) && $prefs['userPrefs']['models']['openai'] === 'gpt-3.5-turbo' ? 'selected' : ''; ?>>gpt-3.5-turbo</option>
                </select>
            </div>
            <div id="model-deepseek-group">
                <label>Deepseek Model</label>
                <select id="model-deepseek" class="form-select">
                    <option value="deepseek-chat" <?php echo isset($prefs['userPrefs']['models']['deepseek']) && $prefs['userPrefs']['models']['deepseek'] === 'deepseek-chat' ? 'selected' : ''; ?>>deepseek-chat</option>
                    <option value="deepseek-coder" <?php echo isset($prefs['userPrefs']['models']['deepseek']) && $prefs['userPrefs']['models']['deepseek'] === 'deepseek-coder' ? 'selected' : ''; ?>>deepseek-coder</option>
                </select>
            </div>
            <div id="model-perplexity-group">
                <label>Perplexity Model</label>
                <select id="model-perplexity" class="form-select">
                    <option value="sonar" <?php echo isset($prefs['userPrefs']['models']['perplexity']) && $prefs['userPrefs']['models']['perplexity'] === 'sonar' ? 'selected' : ''; ?>>sonar</option>
                    <option value="llama-3" <?php echo isset($prefs['userPrefs']['models']['perplexity']) && $prefs['userPrefs']['models']['perplexity'] === 'llama-3' ? 'selected' : ''; ?>>llama-3</option>
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
</script>
<?php include 'includes/footer.php'; ?>