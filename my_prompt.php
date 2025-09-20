<?php
$page_title = "MCP Chat - My Prompts";
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<style>
    /* My Prompts Specific Styles */
    .prompt-list-container {
        background-color: #FFFFFF;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        height: calc(100vh - 100px);
        /* Adjust for header and margin */
        overflow-y: auto;
        /* Independent scroll for prompts */
    }

    .prompt-list-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #E4E4E7;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .prompt-list-item:hover {
        background-color: #F0F0F0;
    }

    .prompt-list-item img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .prompt-list-item p {
        font-size: 14px;
        color: #000000;
        margin: 0;
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .chat-section {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 100px);
        /* Match prompt-list-container height */
    }

    .chat-container {
        flex: 1;
        overflow-y: auto;
        /* Independent scroll for messages */
        padding: 20px;
        background-color: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chat-message {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .chat-message.user {
        justify-content: flex-end;
    }

    .chat-message.ai {
        justify-content: flex-start;
    }

    .chat-message img.avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 0 10px;
    }

    .chat-message .message-content {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 14px;
    }

    .chat-message.user .message-content {
        background-color: #00B7E5;
        color: #FFFFFF;
        border: 1px solid #00B7E5;
    }

    .chat-message.ai .message-content {
        background-color: #F0F0F0;
        color: #000000;
        border: 1px solid #E4E4E7;
    }

    .chat-message .message-content img {
        max-width: 100%;
        border-radius: 10px;
        margin-top: 10px;
    }

    .chat-input-container {
        background-color: #FFFFFF;
        border-top: 1px solid #E4E4E7;
        padding: 10px 20px;
    }

    /* Mobile View Adjustments */
    @media (max-width: 768px) {
        .col-3 {
            display: none;
            /* Hide prompt list in mobile view */
        }

        .col-9 {
            width: 100%;
            /* Full width for chat section */
            max-width: 100%;
        }

        .main-content {
            padding: 0 10px 10px 10px;
            /* Reduced padding */
        }

        .main-header {
            margin: 5px 0;
            /* Reduced margin */
        }

        .chat-section {
            height: calc(100vh - 60px);
            /* Adjust for reduced header margins */
        }

        .chat-container {
            padding: 10px;
            /* Reduced padding */
        }

        .chat-message {
            margin-bottom: 10px;
            /* Reduced margin between messages */
        }

        .chat-message img.avatar {
            display: none;
            /* Hide avatars in mobile view */
        }

        .chat-message .message-content {
            max-width: 90%;
            /* Increase content width without avatars */
        }

        .chat-input-container {
            padding: 5px 10px;
            /* Reduced padding */
        }

        .chat-input {
            margin-bottom: 5px;
            /* Reduced margin */
        }
    }
</style>

<div class="main-content" style="padding: 0 20px 20px 20px;">
    <div class="main-header" style="margin: 10px 0 5px 0;">
        <div class="header-left">
            <i class="fas fa-plus"></i>
            <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Prompts</p>
        </div>
        <i class="fas fa-sign-out-alt logout-icon" onclick="toggleLogoutDropdown()"></i>
        <div class="logout-dropdown" id="logoutDropdown">
            <div class="logout-item" onclick="handleLogout()">
                <i class="fas fa-sign-out-alt"></i> Log out
            </div>
        </div>
    </div>
    <hr class="main-header-line">
    <div class="row">
        <!-- Left Sidebar (col-3) -->
        <div class="col-3">
            <div class="prompt-list-container">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search my prompts...">
                    <i class="fas fa-filter filter-icon"></i>
                </div>
                <div class="section-title">My Prompts</div>
                <div class="prompt-list">
                    <div class="prompt-list-item">
                        <p>Suggest taglines for a luxury perfume</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Launch campaign ideas</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Skincare brand name ideas</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Skincare brand name ideas</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Skincare brand name ideas</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Skincare brand name ideas</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Skincare brand name ideas</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Skincare brand name ideas</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Brainstorm marketing strategies</p>
                    </div>
                    <!-- Additional prompts for scroll testing -->
                    <div class="prompt-list-item">
                        <p>Create a social media plan</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Write a blog post outline</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>Design a logo concept</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Chat Section (col-9) -->
        <div class="col-9">
            <div class="chat-section">
                <div class="chat-container">
                    <!-- Sample Chat Messages -->
                    <div class="chat-message user">
                        <div class="message-content">Can you suggest taglines for a luxury perfume?</div>
                        <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
                    </div>
                    <div class="chat-message ai">
                        <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                        <div class="message-content">1. "Elegance in Every Note" <br> 2. "Scent of Sophistication" <br> 3. "Unleash Your Essence"</div>
                    </div>
                    <div class="chat-message user">
                        <div class="message-content">What are some launch campaign ideas?</div>
                        <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
                    </div>
                    <div class="chat-message ai">
                        <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                        <div class="message-content">Host an exclusive launch event with influencers. <br> <img src="assets/images/ai-chat.jpg" alt="Campaign Image"></div>
                    </div>
                    <div class="chat-message user">
                        <div class="message-content">Give me 5 name ideas for a skincare brand.</div>
                        <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
                    </div>
                    <div class="chat-message ai">
                        <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                        <div class="message-content">1. GlowVibe <br> 2. PurelyRadiant <br> 3. SkinBloom <br> 4. LushCare <br> 5. DermaGlow</div>
                    </div>
                    <div class="chat-message user">
                        <div class="message-content">Write a LinkedIn post for a product launch.</div>
                        <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
                    </div>
                    <div class="chat-message ai">
                        <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                        <div class="message-content">Excited to announce our new product! 🚀 Join us in revolutionizing skincare. #ProductLaunch</div>
                    </div>
                    <div class="chat-message user">
                        <div class="message-content">Can you brainstorm marketing strategies?</div>
                        <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
                    </div>
                    <div class="chat-message ai">
                        <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                        <div class="message-content">Leverage social media ads and collaborate with micro-influencers. <br> <img src="assets/images/ai-chat.jpg" alt="Strategy Image"></div>
                    </div>
                    <!-- Additional messages for scroll testing -->
                    <div class="chat-message user">
                        <div class="message-content">Can you create a social media plan?</div>
                        <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
                    </div>
                    <div class="chat-message ai">
                        <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                        <div class="message-content">Daily posts on Instagram and Twitter with targeted ads. <br> <img src="assets/images/ai-chat.jpg" alt="Plan Image"></div>
                    </div>
                </div>
                <!-- Chat Input within col-9 -->
                <div class="chat-input-container">
                    <div class="chat-input mb-2">
                        <i class="fas fa-paperclip attachment"></i>
                        <input type="text" placeholder="Message to AI Chat...">
                        <i class="far fa-smile emoji"></i>
                        <i class="fas fa-microphone mic"></i>
                        <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>