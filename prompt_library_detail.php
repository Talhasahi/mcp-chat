<?php 
$page_title = "MCP Chat - Prompt Library Detail";
include 'includes/header.php';
include 'includes/sidebar.php';
?>
    <div class="main-content">
        <div class="main-header" style="margin: 10px 0 5px 0;">
            <div class="header-left">
                <a href="prompt_library.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEO Content Roadmap</p>
            </div>
            <i class="fas fa-sign-out-alt logout-icon" onclick="toggleLogoutDropdown()"></i>
            <div class="logout-dropdown" id="logoutDropdown">
                <div class="logout-item" onclick="handleLogout()">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </div>
            </div>
        </div>
        <hr class="main-header-line">
        <div class="breadcrumbs">
            <a href="#">Prompt Library</a> > <a href="#">SEO</a> > <a href="#">SEO Content Roadmap</a>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="prompt-detail-section">
                    <div class="author">
                        <img src="assets/images/author-avatar.png" alt="Jane Cooper" class="author-img">
                        <div>
                            <p class="author-name">Jane Cooper</p>
                            <p class="author-role">Author</p>
                        </div>
                    </div>
                    <h6>SEO Content Roadmap</h6>
                    <p class="small">Version 1</p>
                    <p class="description mt-0">Purpose Transform your content strategy into a data-driven SEO engine that systematically captures organic traffic, builds topical authority, and converts visitors into customers. This prompt outlines a step-by-step plan to identify keyword opportunities, create high-quality content, and optimize for search engines, ensuring long-term growth and visibility.</p>
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
                    <button class="view-prompt-btn">Explore More Prompts</button>
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
    </div>

<?php include 'includes/footer.php'; ?>