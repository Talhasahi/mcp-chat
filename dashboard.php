<?php
$page_title = "MCP Chat - AI Desk";
include 'includes/header.php';
include 'includes/sidebar.php';
$page_icon = "fas fa-home";
?>
<div class="main-content" style="padding: 0 20px 120px 20px;">

    <?php include 'includes/common-header.php'; ?>
    <img src="assets/images/logo-icon.png" alt="Central Logo" class="central-logo">
    <h1 class="main-heading">How can we assist you today?</h1>
    <p class="main-subtext">Get instant support from curated AI prompts crafted for productivity, creativity, and decision-making. Choose a prompt to get started, or explore more from the Prompt Library.</p>
    <button class="primary-btn" onclick="window.location.href='prompt_library.php'">
        Explore More Prompts →
    </button>

    <div class="prompt-cards">
        <div class="prompt-card">
            <h3>Brainstorm Ideas</h3>
            <p>Unlock creative solutions, business names, or marketing angles in seconds.</p>
            <span class="arrow">→</span>
        </div>
        <div class="prompt-card">
            <h3>Summarize Key Insights</h3>
            <p>Paste long content and instantly get a sharp, executive summary.</p>
            <span class="arrow">→</span>
        </div>
        <div class="prompt-card">
            <h3>Polish My Writing</h3>
            <p>Improve grammar, clarity, and tone of your drafts or messages.</p>
            <span class="arrow">→</span>
        </div>
        <div class="prompt-card">
            <h3>Generate a Strategy Plan</h3>
            <p>Build a quick outline or action plan for your project or team goals.</p>
            <span class="arrow">→</span>
        </div>
    </div>
</div>
<div class="suggested-prompts mb-2">
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Suggest taglines for a luxury perfume</div>
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>What are some launch campaign ideas?</div>
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Give me 5 name ideas for a skincare brand</div>
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Write a LinkedIn post announcing a product launch</div>
</div>
<div class="chat-input mb-2">
    <?php include 'mcp-tools.php'; ?>
    <input type="text" id="chatInput" placeholder="Message to Ai Chat...">
    <!-- <i class="far fa-smile emoji"></i>
    <i class="fas fa-microphone mic"></i> -->
    <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
</div>

<script>
    // Handle send button click to create conversation and redirect
    document.addEventListener('DOMContentLoaded', () => {
        const sendBtn = document.querySelector('.send-btn');
        const chatInput = document.getElementById('chatInput');
        const loadingOverlay = document.getElementById('loading-overlay'); // Assumes global loading overlay

        if (sendBtn && chatInput) {
            sendBtn.addEventListener('click', async (e) => {
                e.preventDefault();

                // Get input value, trim to first 3 words
                let inputText = chatInput.value.trim();
                let title = 'My first chat'; // Fallback

                if (inputText) {
                    const words = inputText.split(/\s+/).filter(word => word.length > 0).slice(0, 3); // Split, filter empty, take first 3
                    title = words.join(' ');
                }

                // Show loading
                if (loadingOverlay) loadingOverlay.style.display = 'block';
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'; // Loading icon

                // Collect data as JSON
                const data = {
                    title: title
                };

                try {
                    const response = await fetch('auth/conversations.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // Clear input
                        chatInput.value = '';
                        // Redirect to my_prompt.php with id
                        window.location.href = `my_prompt.php?id=${result.id}`;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: result.error || 'Failed to create conversation'
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Network error: ' + error.message
                    });
                } finally {
                    // Hide loading and reset button
                    if (loadingOverlay) loadingOverlay.style.display = 'none';
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                }
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>