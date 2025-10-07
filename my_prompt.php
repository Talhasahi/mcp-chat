<?php
$page_title = "MCP Chat - My Prompts";
$page_icon = "fas fa-plus";
include 'includes/header.php';
include 'includes/sidebar.php';

?>

<style>
    /* My Prompts Specific Styles */
    .prompt-list-container {
        background-color: #FFFFFF;
        border-radius: 10px;
        padding: 2px;
        height: calc(100vh - 85px);
        /* Adjust for header and margin */
        overflow-y: auto;
        /* Independent scroll for prompts */
        overflow-x: hidden;
        /* Prevent horizontal scroll */
        margin-bottom: 0;
        /* No bottom margin */
    }

    .prompt-list-item {
        display: flex;
        align-items: center;
        padding: 5px;
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
        font-size: 13px;
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
        height: calc(100vh - 80px);
        /* Match prompt-list-container height */
        margin-bottom: 0;
        /* No bottom margin */
    }

    .chat-container {
        flex: 1;
        overflow-y: auto;
        /* Independent scroll for messages */
        overflow-x: hidden;
        /* Prevent horizontal scroll */
        padding: 5px;
        background-color: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 0;
        /* No bottom margin */
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
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 13px;
        word-wrap: break-word;
        /* Ensure long words wrap to prevent horizontal scroll */
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
        padding: 10px 20px 0 20px;
        /* Remove bottom padding */
        /* Not fixed - flows within col-9 */
        width: 100%;
        /* Ensure full width of parent (col-9) */
        margin-bottom: 0;
        /* No bottom margin */
    }

    /* Wrapper for tool include to contain dropdown positioning independently */
    .tool-wrapper {
        position: relative;
        /* Contain absolute dropdown within this wrapper */
        display: inline-block;
        /* Prevent full-width expansion */
        margin-right: 10px;
        /* Space from textarea */
    }

    /* Override for contained dropdown in non-fixed contexts */
    .tool-wrapper .tools-dropdown {
        left: 50%;
        /* Center under button if needed */
        transform: translateX(-50%);
        /* Adjust for centering */
        right: auto;
        /* Prevent full-width */
        min-width: 250px;
        /* Keep width consistent */
    }

    /* Auto-expanding textarea - overrides to match existing input styles and prevent UI disturbance */
    .chat-input-container .chat-input {
        position: static !important;
        /* Remove fixed positioning */
        bottom: auto !important;
        left: auto !important;
        right: auto !important;
        width: 100% !important;
        /* Full width of container */
        z-index: auto !important;
        background-color: transparent !important;
        /* No extra bg */
        border-top: none !important;
        /* No extra border */
        padding: 0 !important;
        /* Rely on child padding */
        align-items: flex-start !important;
        /* For expansion */
        gap: 10px;
        margin-bottom: 0;
        /* No bottom margin */
    }

    .chat-textarea {
        flex: 1;
        /* Take remaining space */
        border: none !important;
        /* Match existing input */
        outline: none !important;
        font-size: 14px !important;
        /* Match existing */
        padding: 10px !important;
        /* Match existing */
        background-color: #F0F0F0 !important;
        /* Match existing input bg */
        border-radius: 25px !important;
        /* Match existing */
        resize: none;
        /* Prevent manual resize */
        overflow: hidden;
        /* Hide scrollbars */
        min-height: 40px;
        /* Initial height to match button (40px) */
        max-height: 120px;
        /* Cap expansion to avoid too much growth */
        line-height: 1.4;
        /* Natural wrapping */
        box-sizing: border-box;
        /* Include padding in width calc */
        margin-right: 0;
        /* Remove any existing margin */
        margin-bottom: 0;
        /* No bottom margin */
        word-wrap: break-word;
        /* Ensure long words wrap to prevent horizontal scroll */
    }

    .chat-textarea:focus {
        background-color: #F0F0F0;
        /* Keep bg on focus, no outline change */
    }

    .chat-input-container .send-btn {
        flex-shrink: 0;
        /* Prevent button from shrinking */
        align-self: flex-end;
        /* Keep button aligned to bottom as textarea grows */
        margin: 0;
        /* Ensure no extra margins */
    }

    /* Ensure col-9 contains everything without full-screen bleed */
    .col-9 {
        position: relative;
        /* Contain children */
        flex: 0 0 83%;
        /* col-9 = 9/12 = 75% */
        max-width: 83%;
        padding: 0;
        /* Remove all padding (left, right, top, bottom) */
        margin-bottom: 0;
        /* No bottom margin */
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0px;
        width: 100%;
        margin-bottom: 0;
        /* No bottom margin on row */
    }

    .col-3 {
        flex: 0 0 17%;
        /* col-3 = 3/12 = 25% */
        max-width: 17%;
        padding: 0;
        /* Remove all padding (left, right, top, bottom) */
        margin-bottom: 0;
        /* No bottom margin */
    }

    /* Mobile View Adjustments */
    @media (max-width: 768px) {
        .col-3 {
            display: none;
            /* Hide prompt list in mobile view */
        }

        .col-9 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0;
            /* No padding on mobile */
            margin-bottom: 0;
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
            height: calc(100vh - 80px);
            /* Adjust for reduced header margins */
            margin-bottom: 0;
        }

        .chat-container {
            padding: 10px;
            /* Reduced padding */
            margin-bottom: 0;
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
            padding: 5px 10px 0 10px;
            /* Remove bottom padding */
            /* Reduced padding */
            margin-bottom: 0;
        }

        .chat-textarea {
            font-size: 12px !important;
            padding: 8px !important;
            min-height: 36px;
            /* Match smaller button on mobile */
            margin-bottom: 0;
        }

        .tool-wrapper .tools-dropdown {
            left: 0;
            /* Align left on mobile */
            transform: none;
            /* No centering */
        }
    }
</style>

<div class="main-content" style="padding: 0 0px 0px 0px;">
    <?php include  'includes/common-header.php'; ?>

    <div class="row">
        <!-- Left Sidebar (col-3) -->
        <div class="col-3">
            <div class="prompt-list-container">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search my prompts...">

                </div>
                <h6 class="mb-0 mt-1">My Prompts</h6>
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
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>

                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>


                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>

                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>


                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
                    </div>
                    <div class="prompt-list-item">
                        <p>LinkedIn post for product launch</p>
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
                <!-- Chat Input within col-9 and chat-section (contained, not full screen) -->
                <div class="chat-input-container">
                    <div class="chat-input mb-2">
                        <div class="tool-wrapper">
                            <?php include 'mcp-tools.php'; ?>
                        </div>
                        <textarea id="chatInput" class="chat-textarea" placeholder="Message to AI Chat..." rows="1"></textarea>
                        <!-- <i class="far fa-smile emoji"></i>
                        <i class="fas fa-microphone mic"></i> -->
                        <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-resize textarea on input (non-disruptive)
    document.addEventListener('DOMContentLoaded', () => {
        const chatInput = document.getElementById('chatInput');

        if (chatInput) {
            // Initial height set
            chatInput.style.height = 'auto';
            chatInput.style.height = chatInput.scrollHeight + 'px';

            chatInput.addEventListener('input', function() {
                this.style.height = 'auto'; // Reset
                const newHeight = Math.min(this.scrollHeight, 120); // Cap at 120px
                this.style.height = newHeight + 'px';
            });

            // Optional: Enter to send (without Shift for new line)
            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    document.querySelector('.send-btn').click();
                }
            });
        }
    });

    // Handle send button click (placeholder - no API call, just clear and alert for now)
    document.addEventListener('DOMContentLoaded', () => {
        const sendBtn = document.querySelector('.send-btn');
        const chatInput = document.getElementById('chatInput');

        if (sendBtn && chatInput) {
            sendBtn.addEventListener('click', (e) => {
                e.preventDefault();

                // Get input value
                let inputText = chatInput.value.trim();
                if (!inputText) {
                    alert('Please enter a message!');
                    return;
                }

                // Placeholder action: Clear input and reset height (add real logic later)
                chatInput.value = '';
                chatInput.style.height = 'auto';
                chatInput.style.height = chatInput.scrollHeight + 'px';
                alert('Message sent! (No API call - implement as needed)');
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>