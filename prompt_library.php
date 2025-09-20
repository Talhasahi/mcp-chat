<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - Prompt Library</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #FFFFFF;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 60px;
            background-color: #1a1a1a;
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1000;
        }

        .sidebar .logo {
            width: 50px;
            margin-bottom: 20px;
        }

        .sidebar .menu-item {
            margin: 5px 0;
            font-size: 18px;
            color: #808080;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .sidebar .menu-item.active {
            color: #00B7E5;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .menu-item:hover {
            color: #00B7E5;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .user-avatar {
            width: 40px;
            border-radius: 50%;
            margin-top: auto;
            margin-bottom: 10px;
        }

        .main-content {
            flex: 1;
            margin-left: 60px;
            padding: 0 20px 20px 20px;
            overflow-y: auto;
            height: 100vh;
        }

        .main-header {
            display: flex;
            align-items: center;
        }

        .main-header .back-icon {
            font-size: 18px;
            color: #808080;
            margin-right: 10px;
            cursor: pointer;
        }

        .main-header .title {
            font-size: 18px;
            color: #000000;
            margin: 0;
        }

        .main-header-line {
            width: 100%;
            border: 0;
            height: 1px;
            background-color: #E2E4E9;
            margin: 5px 0 10px 0;
        }

        .search-container {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 100%;
            margin: 20px 0;
        }

        .search-input {
            flex: 1;
            border-radius: 8px;
            border: 1px solid #E4E4E7;
            padding: 6px;
            font-size: 14px;
            background-color: white;
            outline: none;
        }

        .search-input:focus {
            border-color: transparent;
            box-shadow: 0 0 5px #00B7E5;
        }

        .filter-icon {
            margin-left: 10px;
            font-size: 18px;
            color: #808080;
            cursor: pointer;
        }

        .all-prompts {
            font-size: 16px;
            color: #000000;
            padding: 5px 15px;
            border-radius: 5px;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 20px;
        }

        .prompt-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .prompt-library-card {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .prompt-library-card .category {
            font-size: 12px;
            color: #000000;
            background-color: #FFFFFF;
            padding: 2px 10px;
            border-radius: 15px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .prompt-library-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #000000;
            margin-bottom: 10px;
        }

        .prompt-library-card .description {
            font-size: 12px;
            color: #808080;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 3.6em;
            line-height: 1.2em;
        }

        .prompt-library-card .author {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-top: 0;
            margin-top: 0;
        }

        .prompt-library-card .author-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            margin-top: 2px;
        }

        .prompt-library-card .author-name {
            font-size: 12px;
            color: #000000;
            font-weight: 600;
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        .prompt-library-card .author-role {
            font-size: 12px;
            color: #808080;
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        .prompt-library-card .view-prompt-btn {
            width: 100%;
            background-color: #00B7E5;
            color: #FFFFFF;
            border: none;
            border-radius: 25px;
            padding: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 10px;
            border: 1px solid #00B7E5;
        }

        .prompt-library-card .view-prompt-btn:hover {
            background-color: #FFFFFF;
            color: #00B7E5;
            border: 1px solid #00B7E5;
        }

        .prompt-library-card .icons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .prompt-library-card .icon {
            color: #808080;
            cursor: pointer;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 50px;
            }

            .main-content {
                margin-left: 50px;
                padding: 0 15px 20px 15px;
            }

            .main-header {
                margin: 5px 0 5px 0;
            }

            .main-header-line {
                margin: 3px 0 8px 0;
            }

            .search-container {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input {
                width: 100%;
                margin-bottom: 10px;
            }

            .filter-icon {
                margin-left: 0;
            }

            .all-prompts {
                font-size: 14px;
                padding: 4px 12px;
            }

            .prompt-grid {
                grid-template-columns: 1fr;
            }

            .prompt-library-card {
                max-width: 100%;
            }
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 20px;
            padding: 20px;
            background-color: #FFFFFF;
        }

        .modal-header {
            border: none;
            padding: 0 0 10px 0;
        }

        .modal-title {
            font-size: 18px;
            color: #000000;
        }

        .modal-body .category-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .modal-body .form-check {
            margin: 0;
        }

        .modal-body .form-check-label {
            color: #808080;
            margin-left: 5px;
        }

        .modal-body .type-tag {
            display: inline-block;
            padding: 5px 15px;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            border: 1px solid #E4E4E7;
            color: #000000;
            background-color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .modal-body .type-tag:hover {
            border-color: #00B7E5;
            color: #00B7E5;
        }

        .modal-body .type-tag.selected {
            background-color: #FFFFFF;
            color: #00B7E5;
            border: 1px solid #00B7E5;
        }

        .modal-body .date-input {
            border-radius: 8px;
            border: 1px solid #E4E4E7;
            padding: 6px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 14px;
            background-color: white;
            outline: none;
        }

        .modal-body .date-input:focus {
            border-color: transparent;
            box-shadow: 0 0 5px #00B7E5;
        }

        .modal-body .btn {
            border-radius: 25px;
            padding: 8px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-body .btn-apply {
            background-color: #00B7E5;
            color: #FFFFFF;
            border: 1px solid #00B7E5;
        }

        .modal-body .btn-apply:hover {
            background-color: #FFFFFF;
            color: #00B7E5;
            border: 1px solid #00B7E5;
        }

        .modal-body .btn-cancel {
            background-color: #FFFFFF;
            color: #00B7E5;
            border: 1px solid #00B7E5;
        }

        .modal-body .btn-cancel:hover {
            background-color: #00B7E5;
            color: #FFFFFF;
            border: 1px solid #00B7E5;
        }
    </style>
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
            <i class="fas fa-layer-group"></i>
            <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prompt Library</p>
        </div>
        <hr class="main-header-line">
        <div class="search-container">
            <input type="text" placeholder="Search for a prompt..." class="search-input">
            <i class="fas fa-filter filter-icon"></i>
        </div>
        <p class="all-prompts">All Prompts</p>
        <div class="prompt-grid">
            <div class="prompt-library-card">
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
                <button class="view-prompt-btn">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
            <!-- Additional prompt cards to make it 4 in a row -->
            <div class="prompt-library-card">
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
                <button class="view-prompt-btn">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
            <div class="prompt-library-card">
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
                <button class="view-prompt-btn">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
            <div class="prompt-library-card">
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
                <button class="view-prompt-btn">View Prompt</button>
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
    </script>
</body>

</html>