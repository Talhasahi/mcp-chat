<?php
$page_title = "MCP Chat - Prompt Library";
include 'includes/header.php';
include 'includes/sidebar.php';

$page_icon = "fas fa-layer-group";
?>
<div class="main-content">



    <?php include 'includes/common-header.php'; ?>

    <div class="search-container">
        <input type="text" placeholder="Search for a prompt..." class="search-input">
        <i class="fas fa-filter filter-icon"></i>
    </div>
    <div class="left-right">
        <p class="section-title">All Prompts</p>
        <button class="btn btn-blackone" onclick="window.location.href='create_prompt.php'">&nbsp;Create Prompt&nbsp;
            <i class="fas fa-plus"></i>&nbsp;
        </button>
    </div>

    <div class="prompt-grid">
        <div class="card">
            <p class="category">SEO</p>
            <h3>SEO Content Roadmap</h3>
            <p class="description">Purpose Transform your content strategy into a data-driven SEO engine that systematically captures organic traffic, builds topical authority, and conv sdhdhsdhsdhsjhsjhhs
                sjhsdjsdhsdjhsdjhsdjh.. what aboy ny abc h aajjas ajs asjasjas asjashashasa ajhasjhas .</p>
            <div class="author">
                <img src="assets/images/author-avatar.png" alt="Jane Cooper" class="author-img">
                <div>
                    <p class="author-name">Jane Cooper</p>
                    <p class="author-role">Author</p>
                </div>
            </div>
            <button class="action-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
            <div class="icons">
                <i class="fas fa-link icon"></i>
                <i class="fas fa-share-alt icon"></i>
                <i class="fas fa-ellipsis-h icon"></i>
            </div>
        </div>
        <!-- Additional prompt cards to make it 4 in a row -->
        <div class="card">
            <p class="category">Marketing</p>
            <h3>Social Media Strategy</h3>
            <p class="description">Create a comprehensive plan to boost your brand's presence on social media platforms.</p>
            <div class="author">
                <img src="assets/images/author-avatar.png" alt="John Doe" class="author-img">
                <div>
                    <p class="author-name">John Doe</p>
                    <p class="author-role">Author</p>
                </div>
            </div>
            <button class="action-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
            <div class="icons">
                <i class="fas fa-link icon"></i>
                <i class="fas fa-share-alt icon"></i>
                <i class="fas fa-ellipsis-h icon"></i>
            </div>
        </div>
        <div class="card">
            <p class="category">Business</p>
            <h3>Business Plan Outline</h3>
            <p class="description">Develop a detailed business plan to guide your startup's growth and success.</p>
            <div class="author">
                <img src="assets/images/author-avatar.png" alt="Jane Smith" class="author-img">
                <div>
                    <p class="author-name">Jane Smith</p>
                    <p class="author-role">Author</p>
                </div>
            </div>
            <button class="action-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
            <div class="icons">
                <i class="fas fa-link icon"></i>
                <i class="fas fa-share-alt icon"></i>
                <i class="fas fa-ellipsis-h icon"></i>
            </div>
        </div>
        <div class="card">
            <p class="category">Coding</p>
            <h3>Code Review Checklist</h3>
            <p class="description">Ensure code quality with this step-by-step review checklist for developers.</p>
            <div class="author">
                <img src="assets/images/author-avatar.png" alt="Mike Johnson" class="author-img">
                <div>
                    <p class="author-name">Mike Johnson</p>
                    <p class="author-role">Author</p>
                </div>
            </div>
            <button class="action-btn" onclick="window.location.href='prompt_library_detail.php'">View Prompt</button>
            <div class="icons">
                <i class="fas fa-link icon"></i>
                <i class="fas fa-share-alt icon"></i>
                <i class="fas fa-ellipsis-h icon"></i>
            </div>
        </div>
    </div>
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