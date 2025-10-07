<?php
$page_title = "MCP Chat - Prompt Library";
include 'includes/header.php';
include 'includes/sidebar.php';

$page_icon = "fas fa-layer-group";

start_session();
require_login(); // Ensure logged in

$api_base_url = $GLOBALS['api_base_url'] ?? ''; // From config.php
$token = $_SESSION['token'] ?? '';

$search = trim($_POST['search'] ?? $_GET['search'] ?? ''); // Handle POST or GET for simplicity

// Function to fetch prompts (reuse call_authenticated_api for GET)
function fetch_prompts($api_base_url, $token, $search = '')
{
    $endpoint = '/prompts';
    if ($search) {
        $endpoint .= '?search=' . urlencode($search);
    }

    $result = call_authenticated_api($endpoint, null, 'GET');
    $response = $result['response'];
    $http_code = $result['code'];

    if (!$response || $http_code !== 200) {
        // On error, set empty array (handle in UI)
        return [];
    }

    $prompts = json_decode($response, true);
    return is_array($prompts) ? $prompts : [];
}

$prompts = fetch_prompts($api_base_url, $token, $search);
$has_prompts = !empty($prompts);

$categories = fetch_categories();
?>

<div class="main-content">
    <?php include 'includes/common-header.php'; ?>

    <form method="POST" action="prompt_library.php" style="display: inline;">
        <div class="search-container">
            <input type="text" name="search" placeholder="Search for a prompt..." class="search-input" value="<?php echo htmlspecialchars($search); ?>" <?php echo $search ? 'autofocus' : ''; ?>>
            <button type="submit" style="border: none; background: none; cursor: pointer;">
                <i class="fas fa-search" style="color: #007bff;"></i>
            </button>
            <i class="fas fa-filter filter-icon"></i>
        </div>
    </form>

    <div class="left-right">
        <p class="section-title" id="sectionTitle">All Prompts<?php echo $search ? ' for "' . htmlspecialchars($search) . '"' : ''; ?></p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'author'): ?>
            <button class="btn btn-blackone" onclick="window.location.href='create_prompt.php'">
                &nbsp;Create Prompt&nbsp;
                <i class="fas fa-plus"></i>&nbsp;
            </button>
        <?php endif; ?>
    </div>

    <div id="promptGrid" class="prompt-grid" style="<?php echo $has_prompts ? '' : 'display: none;'; ?>">
        <?php foreach ($prompts as $prompt): ?>
            <?php
            $category = $prompt['category']['name'] ?? 'SEO';
            $truncatedBody = strlen($prompt['body']) > 150 ? substr($prompt['body'], 0, 150) . '...' : $prompt['body'];
            $authorName = $prompt['author']['email']; // Use authorId as name
            $promptId = $prompt['id'];
            ?>
            <div class="card" data-category="<?php echo htmlspecialchars($category); ?>">
                <p class="category"><?php echo htmlspecialchars($category); ?></p>
                <h3><?php echo htmlspecialchars($prompt['title']); ?></h3>
                <p class="description"><?php echo htmlspecialchars($truncatedBody); ?></p>
                <div class="author">
                    <img src="assets/images/author-avatar.png" alt="<?php echo htmlspecialchars($authorName); ?>" class="author-img">
                    <div>
                        <p class="author-name"><?php echo htmlspecialchars($authorName); ?></p>
                        <p class="author-role">Author</p>
                    </div>
                </div>
                <button class="action-btn" onclick="window.location.href='prompt_library_detail.php?id=<?php echo urlencode($promptId); ?>'">View Prompt</button>
                <div class="icons pointer">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'author'): ?>
                        <i class="fas fa-edit edit-icon pointer"
                            onclick="window.location.href='edit_prompt.php?id=<?php echo urlencode($promptId); ?>'"
                            title="Edit"></i>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="no-results" style="text-align: center; padding: 2rem; color: #6c757d; <?php echo $has_prompts ? 'display:none;' : ''; ?>">
        <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem;"></i>
        <p id="noResultsText"><?php echo $search ? 'No prompts found for "' . htmlspecialchars($search) . '".' : 'No prompts available yet.'; ?></p>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter</h5>
            </div>

            <div class="modal-body tab-content tab-padding-remove">
                <div class="mt-0">
                    <h6>Categories</h6>
                    <div class="category-grid">
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $index => $category): ?>
                                <?php
                                $name = $category['name'] ?? '';
                                $id = 'category' . str_replace(' ', '', strtoupper($name)); // e.g., categorySEO
                                $isChecked = '';
                                ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="<?php echo htmlspecialchars($id); ?>" <?php echo $isChecked; ?>>
                                    <label class="form-check-label" for="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($name); ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No categories available.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-input" value="">
                    </div>
                </div>
                <div class="mt-1">
                    <h6>Date Created</h6>
                    <input type="date" class="date-input search-input" value="2020-12-01">
                </div>
                <div class="mt-3">
                    <h6>Type</h6>
                    <div class="type-tag selected" onclick="selectType(this)" data-type="rarely">Rarely Used</div>
                    <div class="type-tag" onclick="selectType(this)" data-type="mostly">Mostly Used</div>
                    <div class="type-tag" onclick="selectType(this)" data-type="saved">Saved</div>
                </div> -->
                <div class="mt-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-cancel w-50" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-apply w-50">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var currentSearch = <?php echo json_encode($search); ?>;

    document.querySelector('.filter-icon').addEventListener('click', function() {
        new bootstrap.Modal(document.getElementById('filterModal')).show();
    });

    function selectType(element) {
        document.querySelectorAll('.type-tag').forEach(tag => tag.classList.remove('selected'));
        element.classList.add('selected');
    }

    document.querySelector('.btn-apply').addEventListener('click', function() {
        let selectedCategories = [];
        document.querySelectorAll('#filterModal .form-check-input:checked').forEach(function(cb) {
            let label = cb.nextElementSibling.textContent.trim();
            selectedCategories.push(label);
        });

        // Update section title
        let title = document.getElementById('sectionTitle');
        let baseTitle = 'All Prompts';
        if (currentSearch) {
            baseTitle += ' for "' + currentSearch + '"';
        }
        if (selectedCategories.length > 0) {
            baseTitle += ' filtered by: ' + selectedCategories.join(', ');
        }
        title.textContent = baseTitle;

        // Filter cards
        let cards = document.querySelectorAll('#promptGrid .card');
        cards.forEach(function(card) {
            let cardCategory = card.getAttribute('data-category');
            if (selectedCategories.length === 0 || selectedCategories.includes(cardCategory)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        // Check visible count and update no-results
        let visibleCount = 0;
        cards.forEach(function(card) {
            if (card.style.display !== 'none') {
                visibleCount++;
            }
        });

        let noResults = document.getElementById('no-results');
        let noResultsText = document.getElementById('noResultsText');
        if (visibleCount === 0) {
            let message = 'No prompts available.';
            if (currentSearch) {
                message = 'No prompts found for "' + currentSearch + '".';
            }
            if (selectedCategories.length > 0) {
                message = 'No prompts found for categories: ' + selectedCategories.join(', ') + '.';
            }
            noResultsText.textContent = message;
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }

        // Hide modal
        bootstrap.Modal.getInstance(document.getElementById('filterModal')).hide();
    });
</script>
<?php include 'includes/footer.php'; ?>