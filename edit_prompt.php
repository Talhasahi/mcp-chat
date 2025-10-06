<?php
$page_title = "MCP Chat - Edit Prompt";
include 'includes/header.php';
include 'includes/sidebar.php';
$page_icon = "fas fa-edit";

start_session();
require_login(); // Ensure logged in

$api_base_url = $GLOBALS['api_base_url'] ?? ''; // From config.php
$token = $_SESSION['token'] ?? '';

$promptId = trim($_GET['id'] ?? '');
$prompt = null;
$error = '';

if ($promptId) {
    // Function to fetch single prompt (reuse call_authenticated_api for GET)
    function fetch_single_prompt($api_base_url, $token, $promptId)
    {
        $endpoint = '/prompts/' . $promptId;

        $result = call_authenticated_api($endpoint, null, 'GET');
        $response = $result['response'];
        $http_code = $result['code'];

        if (!$response || $http_code !== 200) {
            return null;
        }

        $promptData = json_decode($response, true);
        return is_array($promptData) ? $promptData : null;
    }

    $prompt = fetch_single_prompt($api_base_url, $token, $promptId);
    if (!$prompt) {
        $error = 'Prompt not found or error fetching details.';
    }
} else {
    $error = 'No prompt ID provided.';
}

$hasPrompt = $prompt && !$error;
$title = $hasPrompt ? $prompt['title'] : '';
$version = $hasPrompt ? $prompt['version'] : '1.0';
$body = $hasPrompt ? $prompt['body'] : '';
$tags_str = $hasPrompt && $prompt['tags'] ? implode(',', $prompt['tags']) : '';
$category = $hasPrompt ? ($prompt['categoryId'] ?? '') : ''; // For select, but null -> empty
?>

<style>
    /* Custom CSS for tags - add to assets/css/mcp.css or inline */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25em;
        margin-top: 0.5em;
    }

    .tag {
        background: #00B7E5;
        color: #FFFFFF;
        border: 1px solid #FFFFFF;
        border-radius: 4px;
        padding: 0.25em 0.5em;
        font-size: 0.875em;
        display: flex;
        align-items: center;
    }

    .tag .remove {
        margin-left: 0.5em;
        cursor: pointer;
        color: #dc3545;
        font-weight: bold;
    }

    .tag .remove:hover {
        color: #dc3545;
    }

    #tagInput {
        width: 100%;
    }
</style>

<div class="main-content">
    <?php include 'includes/common-header.php'; ?>

    <div class="breadcrumbs">
        <a href="my_prompt.php">My Prompts</a> > <a href="prompt_library_detail.php?id=<?php echo urlencode($promptId); ?>">View Prompt</a> > <a href="#">Edit</a>
    </div>

    <?php if ($error || !$hasPrompt): ?>
        <div style="text-align: center; padding: 2rem; color: #dc3545;">
            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <p><?php echo htmlspecialchars($error); ?></p>
            <a href="my_prompt.php" class="btn btn-blackone">Back to My Prompts</a>
        </div>
    <?php else: ?>
        <div class="tab-content" id="edit">
            <h6>Edit Prompt</h6>
            <p class="small">Update the details below to modify your AI prompt.</p>
            <form id="editPromptForm" method="post" action="auth/update_prompt.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($promptId); ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Prompt Title</label>
                        <input type="text" class="form-input" id="title" name="title" placeholder="Enter a descriptive title for your prompt" value="<?php echo htmlspecialchars($title); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Version</label>
                        <input type="text" class="form-input" id="version" name="version" placeholder="e.g., 1.0" value="<?php echo htmlspecialchars($version); ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Select a category</option>
                            <option value="design" <?php echo $category === 'design' ? 'selected' : ''; ?>>Design</option>
                            <option value="marketing" <?php echo $category === 'marketing' ? 'selected' : ''; ?>>Marketing</option>
                            <option value="coding" <?php echo $category === 'coding' ? 'selected' : ''; ?>>Coding</option>
                            <option value="seo" <?php echo $category === 'seo' ? 'selected' : ''; ?>>SEO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <input type="text" class="form-input" id="tagInput" placeholder="Type a tag and press Enter (e.g., seo, support)" />
                        <div id="tagsContainer" class="tags-container"></div>
                        <input type="hidden" name="tags" id="tagsHidden" value="<?php echo htmlspecialchars($tags_str); ?>" /> <!-- Hidden for form submit -->
                        <small class="form-text text-muted">Press Enter to add a tag. Click 'x' to remove.</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Body</label>
                        <textarea class="form-input" id="body" name="body" rows="4" placeholder="Describe the prompt in detail. Use {brackets} for variables if needed." required><?php echo htmlspecialchars($body); ?></textarea>
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit" class="save-btn">Update Prompt</button>
                    <button type="button" class="cancel-btn" onclick="window.location.href='prompt_library_detail.php?id=<?php echo urlencode($promptId); ?>'">Cancel</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    // Dynamic tags JS - Load existing tags on init
    const tagInput = document.getElementById('tagInput');
    const tagsContainer = document.getElementById('tagsContainer');
    const tagsHidden = document.getElementById('tagsHidden');

    let tags = []; // Array to track tags

    // Load existing tags from hidden input
    if (tagsHidden.value) {
        tags = tagsHidden.value.split(',').map(tag => tag.trim()).filter(tag => tag);
    }
    renderTags(); // Initial render

    // Add tag on Enter
    tagInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const tagText = tagInput.value.trim().toLowerCase();
            if (tagText && !tags.includes(tagText)) { // No duplicates
                tags.push(tagText);
                renderTags();
                tagInput.value = '';
            }
        }
    });

    // Render tags as badges
    function renderTags() {
        tagsContainer.innerHTML = '';
        tags.forEach((tag, index) => {
            const tagEl = document.createElement('span');
            tagEl.className = 'tag';
            tagEl.innerHTML = `${tag} <span class="remove" onclick="removeTag(${index})">&times;</span>`;
            tagsContainer.appendChild(tagEl);
        });
        // Update hidden input for form submit (comma-separated)
        tagsHidden.value = tags.join(',');
    }

    // Remove tag
    function removeTag(index) {
        tags.splice(index, 1);
        renderTags();
    }

    // Optional: Add on blur (if Enter not pressed)
    tagInput.addEventListener('blur', function() {
        if (tagInput.value.trim()) {
            // Auto-add if not empty
            const tagText = tagInput.value.trim().toLowerCase();
            if (!tags.includes(tagText)) {
                tags.push(tagText);
                renderTags();
            }
            tagInput.value = '';
        }
    });

    // AJAX form submit handler
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('editPromptForm');
        const saveBtn = form.querySelector('.save-btn');
        const loadingOverlay = document.getElementById('loading-overlay');

        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault(); // Stop default POST

                // Show loading overlay and disable button
                loadingOverlay.style.display = 'block';
                saveBtn.textContent = 'Updating...';
                saveBtn.disabled = true;

                // Collect data (tags already in hidden)
                const formData = new FormData(form);

                try {
                    const response = await fetch('auth/update_prompt.php', {
                        method: 'POST',
                        body: formData // Multipart for form fields
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: result.message || 'Prompt updated successfully'
                        }).then(() => {
                            window.location.href = 'prompt_library.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: result.error || 'Failed to update prompt'
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Network error: ' + error.message
                    });
                } finally {
                    // Hide loading and reset button
                    loadingOverlay.style.display = 'none';
                    saveBtn.textContent = 'Update Prompt';
                    saveBtn.disabled = false;
                }
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>