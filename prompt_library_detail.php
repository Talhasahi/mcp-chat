<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - Prompt Library Detail</title>
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
            grid-template-columns: repeat(3, minmax(0, 1fr));
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

        .prompt-detail-section {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .prompt-detail-section .category {
            font-size: 12px;
            color: #000000;
            background-color: #FFFFFF;
            padding: 2px 10px;
            border-radius: 15px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .prompt-detail-section h3 {
            font-size: 18px;
            font-weight: 600;
            color: #000000;
            margin-bottom: 10px;
        }

        .prompt-detail-section .description {
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

        .prompt-detail-section .author {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-top: 0;
            margin-top: 0;
        }

        .prompt-detail-section .author-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            margin-top: 2px;
        }

        .prompt-detail-section .author-name {
            font-size: 12px;
            color: #000000;
            font-weight: 600;
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        .prompt-detail-section .author-role {
            font-size: 12px;
            color: #808080;
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        .sidebar-detail {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            min-height: 200px;
            /* Adjustable height */
        }

        .sidebar-detail h6 {
            font-size: 16px;
            color: #000000;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .sidebar-detail ol {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .sidebar-detail ol li {
            font-size: 14px;
            color: #808080;
            margin-bottom: 10px;
        }

        .sidebar-detail .explore-btn {
            width: 100%;
            background-color: #00B7E5;
            color: #FFFFFF;
            border: none;
            border-radius: 25px;
            padding: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #00B7E5;
        }

        .sidebar-detail .explore-btn:hover {
            background-color: #FFFFFF;
            color: #00B7E5;
            border: 1px solid #00B7E5;
        }

        .breadcrumbs {
            font-size: 14px;
            color: #000000;
            margin-bottom: 10px;
        }

        .breadcrumbs a {
            color: #000000;
            text-decoration: none;
        }

        .breadcrumbs a:hover {
            color: #00B7E5;
        }

        .more-prompts-title {
            font-size: 16px;
            color: #000000;
            padding: 5px 15px;
            border-radius: 5px;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 20px;
        }

        .more-prompts-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
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

            .row>.col-8,
            .row>.col-4 {
                width: 100%;
            }

            .more-prompts-grid {
                grid-template-columns: 1fr;
            }
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
            <a href="prompt_library.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEO Content Roadmap</p>
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
                    <button class="explore-btn">Explore More Prompts</button>
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
                <button class="view-prompt-btn">View Prompt</button>
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
                <button class="view-prompt-btn">View Prompt</button>
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
                <button class="view-prompt-btn">View Prompt</button>
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
                <button class="view-prompt-btn">View Prompt</button>
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
                <button class="view-prompt-btn">View Prompt</button>
                <div class="icons">
                    <i class="fas fa-link icon"></i>
                    <i class="fas fa-share-alt icon"></i>
                    <i class="fas fa-ellipsis-h icon"></i>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>