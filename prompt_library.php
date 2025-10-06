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
        <p class="section-title">All Prompts<?php echo $search ? ' for "' . htmlspecialchars($search) . '"' : ''; ?></p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'author'): ?>
            <button class="btn btn-blackone" onclick="window.location.href='create_prompt.php'">
                &nbsp;Create Prompt&nbsp;
                <i class="fas fa-plus"></i>&nbsp;
            </button>
        <?php endif; ?>

    </div>

    <?php if ($has_prompts): ?>
        <div class="prompt-grid">
            <?php foreach ($prompts as $prompt): ?>
                <?php
                $category = $prompt['categoryId'] ? $prompt['categoryId'] : 'SEO';
                $truncatedBody = strlen($prompt['body']) > 150 ? substr($prompt['body'], 0, 150) . '...' : $prompt['body'];
                $authorName = $prompt['authorId']; // Use authorId as name
                $promptId = $prompt['id'];
                ?>
                <div class="card">
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
    <?php else: ?>
        <div id="no-results" style="text-align: center; padding: 2rem; color: #6c757d;">
            <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <p><?php echo $search ? 'No prompts found for "' . htmlspecialchars($search) . '".' : 'No prompts available yet.'; ?></p>
        </div>
    <?php endif; ?>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter</h5>
            </div>
            <div class="modal-body">
                <div class="mt-0">
                    <h6>Categories</h6>
                    <div class="category-grid">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryAssistant">
                            <label class="form-check-label" for="categoryAssistant">Assistant</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryBusiness" checked>
                            <label class="form-check-label" for="categoryBusiness">Business</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryCoding">
                            <label class="form-check-label" for="categoryCoding">Coding</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryDesign">
                            <label class="form-check-label" for="categoryDesign">Design</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryFinances">
                            <label class="form-check-label" for="categoryFinances">Finances</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryMarketing">
                            <label class="form-check-label" for="categoryMarketing">Marketing</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryCopywriting">
                            <label class="form-check-label" for="categoryCopywriting">Copywriting</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryEducation">
                            <label class="form-check-label" for="categoryEducation">Education</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryHealth">
                            <label class="form-check-label" for="categoryHealth">Health</label>
                        </div>
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
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-cancel w-50" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-apply w-50">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('.filter-icon').addEventListener('click', function() {
        new bootstrap.Modal(document.getElementById('filterModal')).show();
    });

    function selectType(element) {
        document.querySelectorAll('.type-tag').forEach(tag => tag.classList.remove('selected'));
        element.classList.add('selected');
    }
</script>
<?php include 'includes/footer.php'; ?>