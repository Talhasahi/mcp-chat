<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - Prompt Library</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/mcp.css">
</head>

<body>
    <div class="sidebar">
        <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
        <div class="menu-item"><i class="fas fa-home"></i></div>
        <div class="menu-item active"><i class="fas fa-layer-group"></i></div>
        <div class="menu-item"><i class="fas fa-plus"></i></div>
        <div class="menu-item"><i class="fas fa-gear"></i></div>
        <img src="assets/images/user-avatar.png" alt="User Avatar" class="user-avatar">
    </div>
    <div class="main-content">

        <div class="main-header" style="margin: 10px 0 5px 0;">
            <div class="header-left">
                <i class="fas fa-layer-group"></i>
                <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prompt Library</p>
            </div>
            <i class="fas fa-sign-out-alt logout-icon" onclick="toggleLogoutDropdown()"></i>
            <div class="logout-dropdown" id="logoutDropdown">
                <div class="logout-item" onclick="handleLogout()">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </div>
            </div>
        </div>
        <hr class="main-header-line">
        <div class="search-container">
            <input type="text" placeholder="Search for a prompt..." class="search-input">
            <i class="fas fa-filter filter-icon"></i>
        </div>
        <p class="section-title">All Prompts</p>
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
                <button class="action-btn">View Prompt</button>
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
                <button class="action-btn">View Prompt</button>
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
                <button class="action-btn">View Prompt</button>
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
                <button class="action-btn">View Prompt</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.filter-icon').addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('filterModal')).show();
        });

        function selectType(element) {
            document.querySelectorAll('.type-tag').forEach(tag => tag.classList.remove('selected'));
            element.classList.add('selected');
        }

        function toggleLogoutDropdown() {
            const dropdown = document.getElementById('logoutDropdown');
            dropdown.classList.toggle('active');
        }

        function handleLogout() {
            // Add logout logic here (e.g., redirect or API call)
            alert('Logged out!'); // Placeholder action
            document.getElementById('logoutDropdown').classList.remove('active');
        }

        // Close dropdown if clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('logoutDropdown');
            const icon = document.querySelector('.logout-icon');
            if (!icon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
</body>

</html>