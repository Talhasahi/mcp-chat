<?php
$page_title = "MCP Chat - My Prompts";
$page_icon = "fas fa-plus";
include 'includes/header.php';
include 'includes/sidebar.php';

?>

<style>

</style>

<div class="main-content" style="padding: 0 20px 20px 20px;">
    <?php include  'includes/common-header.php'; ?>

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
                        <?php include 'mcp-tools.php'; ?>
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