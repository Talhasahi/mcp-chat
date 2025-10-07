<?php
$page_title = "MCP Chat - Categories";
include 'includes/header.php';
include 'includes/sidebar.php';

$page_icon = "fas fa-tags";
require_author('dashboard.php');

// Function to fetch categories from /prompt-categories


$categories = fetch_categories();
$has_categories = !empty($categories);
?>

<div class="main-content">
    <?php include 'includes/common-header.php'; ?>
    <div class="left-right">
        <p class="section-title">All Categories</p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'author'): ?>
            <button class="btn btn-blackone" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                &nbsp;Create Category&nbsp;
                <i class="fas fa-plus"></i>&nbsp;
            </button>
        <?php endif; ?>
    </div>
    <?php if ($has_categories): ?>
        <div class="prompt-grid" style="text-align: center; padding: 2rem; color: #6c757d; margin-top: 2rem;">
            <?php foreach ($categories as $category): ?>
                <div class="card">
                    <p class="category"><?php echo htmlspecialchars($category['name'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 2rem; color: #6c757d;">
            <i class="fas fa-tags" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <p>No categories available yet.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Create Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCategoryForm">
                <div class="modal-body tab-content">
                    <div class="mt-0">
                        <div class="form-group">
                            <label class="form-label" for="categoryName">Category Name</label>
                            <input type="text" class="form-input" id="categoryName" name="name" placeholder="Enter category name" required>
                            <small class="form-text text-muted">This name will be used to organize prompts.</small>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-cancel w-50" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-apply w-50">Create Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle modal form submission with AJAX to auth/categories.php
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('createCategoryForm');
        const createBtn = form?.querySelector('.btn-apply');
        const loadingOverlay = document.getElementById('loading-overlay'); // Assumes this exists globally

        if (form && createBtn) {
            createBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                const nameInput = document.getElementById('categoryName');
                const name = nameInput.value.trim();

                if (!name) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Category name is required!'
                    });
                    return;
                }

                // Show loading
                if (loadingOverlay) loadingOverlay.style.display = 'block';
                createBtn.textContent = 'Creating...';
                createBtn.disabled = true;

                // Collect data
                const formData = new FormData();
                formData.append('name', name);

                try {
                    const response = await fetch('auth/categories.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: result.message || 'Category created successfully!'
                        }).then(() => {
                            bootstrap.Modal.getInstance(document.getElementById('createCategoryModal')).hide();
                            nameInput.value = ''; // Clear input
                            location.reload(); // Reload to fetch updated list
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: result.error || 'Failed to create category'
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
                    if (loadingOverlay) loadingOverlay.style.display = 'none';
                    createBtn.textContent = 'Create Category';
                    createBtn.disabled = false;
                }
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>