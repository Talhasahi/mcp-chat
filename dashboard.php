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
    <button class="primary-btn">Explore More Prompts →</button>
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
<div class="suggested-prompts">
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Suggest taglines for a luxury perfume</div>
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>What are some launch campaign ideas?</div>
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Give me 5 name ideas for a skincare brand</div>
    <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Write a LinkedIn post announcing a product launch</div>
</div>
<div class="chat-input mb-2">
    <?php include 'mcp-tools.php'; ?>
    <input type="text" placeholder="Message to Ai Chat...">
    <i class="far fa-smile emoji"></i>
    <i class="fas fa-microphone mic"></i>
    <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
</div>

<?php include 'includes/footer.php'; ?>