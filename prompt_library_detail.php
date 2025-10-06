<?php
$page_title = "MCP Chat - Prompt Library Detail";
include 'includes/header.php';
include 'includes/sidebar.php';
$page_icon = "fas fa-arrow-left";

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
$category = $hasPrompt ? ($prompt['categoryId'] ? $prompt['categoryId'] : 'SEO') : 'SEO';
$title = $hasPrompt ? $prompt['title'] : 'Untitled Prompt';
$version = $hasPrompt ? str_replace('v', '', $prompt['version']) : '1'; // Strip 'v' for display
$body = $hasPrompt ? $prompt['body'] : '';
$authorName = $hasPrompt ? $prompt['authorId'] : 'Unknown Author';
?>

<div class="main-content">
    <?php include 'includes/common-header.php'; ?>

    <div class="breadcrumbs">
        <a href="prompt_library.php">Prompt Library</a> > <a href="prompt_library.php"><?php echo htmlspecialchars($category); ?></a> > <a href="#"><?php echo htmlspecialchars($title); ?></a>
    </div>
    <?php if ($error): ?>
        <div style="text-align: center; padding: 2rem; color: #dc3545;">
            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <p><?php echo htmlspecialchars($error); ?></p>
            <a href="prompt_library.php" class="btn btn-blackone">Back to Library</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-8">
                <div class="prompt-detail-section">
                    <div class="author">
                        <img src="assets/images/author-avatar.png" alt="<?php echo htmlspecialchars($authorName); ?>" class="author-img">
                        <div>
                            <p class="author-name"><?php echo htmlspecialchars($authorName); ?></p>
                            <p class="author-role">Author</p>
                        </div>
                    </div>
                    <h6><?php echo htmlspecialchars($title); ?></h6>
                    <p class="small">Version <?php echo htmlspecialchars($version); ?></p>
                    <p class="description mt-0"><?php echo nl2br(htmlspecialchars($body)); ?></p>
                    <div class="icons">
                        <i class="fas fa-copy"></i>&nbsp;&nbsp;
                        <i class="fas fa-share-alt icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="sidebar-detail">
                    <h6>How to Use this Prompt</h6>
                    <ol>
                        <li>Copy the prompt and use it directly in AI Chat.</li>
                        <li>If there are any parts in {brackets}, replace them with your info.</li>
                        <li>Follow any steps or tips inside the prompt.</li>
                        <li>Enjoy your conversation.</li>
                    </ol>
                    <button class="view-prompt-btn" onclick="window.location.href='prompt_library.php'">Explore More Prompts</button>
                </div>
            </div>
        </div>
        <p class="more-prompts-title">More prompts like this</p>
        <div class="more-prompts-grid">
            <div class="prompt-library-card">
                <p class="category">SEO</p>
                <h3>Keyword Research Guide</h3>
                <p class="description">Discover high-impact keywords to fuel your SEO strategy and drive targeted traffic to your site.</p>
                <div class="author">
                    <img src="assets/images/author-avatar.png" alt="John Doe" class="author-img">
                    <div>
                        <p class="author-name">John Doe</p>
                        <p class="author-role">Author</p>
                    </div>
                </div>
                <button class="view-prompt-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
            <div class="prompt-library-card">
                <p class="category">SEO</p>
                <h3>Content Optimization Pro</h3>
                <p class="description">Optimize existing content for better search rankings and user engagement with proven techniques.</p>
                <div class="author">
                    <img src="assets/images/author-avatar.png" alt="Jane Smith" class="author-img">
                    <div>
                        <p class="author-name">Jane Smith</p>
                        <p class="author-role">Author</p>
                    </div>
                </div>
                <button class="view-prompt-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
            <div class="prompt-library-card">
                <p class="category">SEO</p>
                <h3>Link Building Strategy</h3>
                <p class="description">Build authoritative backlinks to boost your site's domain authority and improve rankings.</p>
                <div class="author">
                    <img src="assets/images/author-avatar.png" alt="Mike Johnson" class="author-img">
                    <div>
                        <p class="author-name">Mike Johnson</p>
                        <p class="author-role">Author</p>
                    </div>
                </div>
                <button class="view-prompt-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
            <div class="prompt-library-card">
                <p class="category">SEO</p>
                <h3>Technical SEO Audit</h3>
                <p class="description">Conduct a comprehensive technical audit to fix site issues and enhance crawlability.</p>
                <div class="author">
                    <img src="assets/images/author-avatar.png" alt="Sarah Lee" class="author-img">
                    <div>
                        <p class="author-name">Sarah Lee</p>
                        <p class="author-role">Author</p>
                    </div>
                </div>
                <button class="view-prompt-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
            <div class="prompt-library-card">
                <p class="category">SEO</p>
                <h3>Technical SEO Audit</h3>
                <p class="description">Conduct a comprehensive technical audit to fix site issues and enhance crawlability.</p>
                <div class="author">
                    <img src="assets/images/author-avatar.png" alt="Sarah Lee" class="author-img">
                    <div>
                        <p class="author-name">Sarah Lee</p>
                        <p class="author-role">Author</p>
                    </div>
                </div>
                <button class="view-prompt-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>