<?php
$page_title = "MCP Chat - Create Prompt";
include 'includes/header.php';
include 'includes/sidebar.php';
$page_icon = "fas fa-plus";
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
        <a href="my_prompt.php">My Prompts</a> > <a href="#">Create New</a>
    </div>
    <div class="tab-content" id="create">
        <h6>Create a New Prompt</h6>
        <p class="small">Fill in the details below to craft a reusable AI prompt for your workflow.</p>
        <form id="createPromptForm" method="post" action="save_prompt.php"> <!-- Action to future handler -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Prompt Title</label>
                    <input type="text" class="form-input" id="title" name="title" placeholder="Enter a descriptive title for your prompt" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Version</label>
                    <input type="text" class="form-input" id="version" name="version" placeholder="e.g., 1.0" value="1.0" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Select a category</option>
                        <option value="design">Design</option>
                        <option value="marketing">Marketing</option>
                        <option value="coding">Coding</option>
                        <option value="seo">SEO</option>


                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tags</label>
                    <input type="text" class="form-input" id="tagInput" placeholder="Type a tag and press Enter (e.g., seo, support)" />
                    <div id="tagsContainer" class="tags-container"></div>
                    <input type="hidden" name="tags" id="tagsHidden" /> <!-- Hidden for form submit -->
                    <small class="form-text text-muted">Press Enter to add a tag. Click 'x' to remove.</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Body</label>
                    <textarea class="form-input" id="body" name="body" rows="4" placeholder="Describe the prompt in detail. Use {brackets} for variables if needed." required></textarea>
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="save-btn">Create Prompt</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='prompt_library.php'">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Tab switching (single tab, but for consistency)
    document.addEventListener('DOMContentLoaded', () => {
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
    });

    // Dynamic tags JS
    const tagInput = document.getElementById('tagInput');
    const tagsContainer = document.getElementById('tagsContainer');
    const tagsHidden = document.getElementById('tagsHidden');

    let tags = []; // Array to track tags

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
        const form = document.getElementById('createPromptForm');
        const saveBtn = form.querySelector('.save-btn');
        const loadingOverlay = document.getElementById('loading-overlay');

        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // Stop default POST

            // Show loading overlay and disable button
            loadingOverlay.style.display = 'block';
            saveBtn.textContent = 'Creating...';
            saveBtn.disabled = true;

            // Collect data (tags already in hidden)
            const formData = new FormData(form);

            try {
                const response = await fetch('auth/prompts.php', {
                    method: 'POST',
                    body: formData // Multipart for form fields
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: result.message || 'Prompt created successfully'
                    }).then(() => {
                        window.location.href = 'prompt_library.php'; // Redirect to list
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: result.error || 'Failed to create prompt'
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
                saveBtn.textContent = 'Create Prompt';
                saveBtn.disabled = false;
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>