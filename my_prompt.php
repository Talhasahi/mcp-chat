<?php
$page_title = "MCP Chat - My Prompts";
$page_icon = "fas fa-plus";
include 'includes/header.php';
include 'includes/sidebar.php';
$conversationId = $_GET['id'] ?? null;
$conversation_messages = get_conversation_messages($conversationId);
if (isset($conversation_messages['error'])) {
    $conversation_messages = []; // Treat error as empty
}
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

    .message-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        max-width: 70%;
        /* Keep content constrained */
    }

    /* Fix for user messages: Right-align content and actions */
    .chat-message.user .message-wrapper {
        align-items: flex-end;
    }

    .chat-message.user .user-actions {
        align-items: flex-end;
    }

    .feedback-buttons {
        display: flex;
        gap: 6px;
        margin-top: 6px;
        opacity: 0.6;
        transition: opacity 0.2s ease;
        align-self: flex-start;
    }

    .feedback-buttons:hover {
        opacity: 1;
    }

    .feedback-btn {
        background: none;
        border: none;
        color: #888;
        cursor: pointer;
        font-size: 13px;
        padding: 2px 6px;
        border-radius: 3px;
        transition: all 0.2s ease;
        min-width: 28px;
        /* Square-ish for icons */
    }

    .feedback-btn:hover {
        color: #555;
        background-color: rgba(0, 0, 0, 0.05);
    }

    .feedback-btn.selected {
        background-color: rgba(40, 167, 69, 0.2);
        /* Light green for up */
    }

    .thumbs-down.selected {
        background-color: rgba(220, 53, 69, 0.2);
        /* Light red for down */
    }

    .user-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        margin-top: 4px;
        gap: 2px;
    }

    .compare-text {
        color: #666;
        font-size: 11px;
        font-style: italic;
        margin: 0;
        align-self: flex-end;
    }

    .grok-options {
        display: flex;
        gap: 8px;
    }

    .grok-option {
        color: #00B7E5;
        font-size: 12px;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 3px;
        transition: background-color 0.2s ease;
        text-decoration: none;
    }

    .grok-option:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    /* Suggestions UI (below feedback, AI-only) */
    .suggestions-section {
        margin-top: 10px;
        padding: 8px;
        background-color: rgba(240, 240, 240, 0.5);
        border-radius: 8px;
        align-self: flex-start;
    }

    .suggestions-title {
        font-size: 11px;
        color: #666;
        margin-bottom: 6px;
        font-weight: bold;
    }

    .suggestions-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .suggestion-item {
        background-color: #FFFFFF;
        color: #00B7E5;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        cursor: pointer;
        border: 1px solid #E4E4E7;
        transition: all 0.2s ease;
    }

    .suggestion-item:hover {
        background-color: #00B7E5;
        color: #FFFFFF;
        border-color: #00B7E5;
    }
</style>

<div class="main-content" style="padding: 0 0px 0px 0px;">
    <?php include 'includes/common-header.php'; ?>

    <div class="row">
        <!-- Left Sidebar (col-3) -->
        <div class="col-3">
            <?php include 'prompt_history.php'; ?>
        </div>

        <!-- Right Chat Section (col-9) -->
        <div class="col-9">
            <div class="chat-section">
                <div class="chat-container" id="chatContainer">
                    <?php if (!empty($conversation_messages) && is_array($conversation_messages)): ?>
                        <?php foreach ($conversation_messages as $msg): ?>
                            <?php
                            $isUser = ($msg['role'] === 'user');
                            $avatarSrc = $isUser ? 'assets/images/author-avatar.png' : 'assets/images/favicon.png';
                            $roleClass = $isUser ? 'user' : 'ai';
                            ?>
                            <?php if ($isUser): ?>
                                <div class="chat-message user">
                                    <div class="message-wrapper">
                                        <div class="message-content"><?php echo nl2br(htmlspecialchars($msg['content'])); ?></div>
                                        <div class="user-actions">
                                            <small class="compare-text">Compare with Grok</small>
                                            <div class="grok-options">
                                                <span class="grok-option" onclick="compareWithGrok(this, 'grok')">Grok</span>
                                                <span class="grok-option" onclick="compareWithGrok(this, 'simple')">Simple</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" class="avatar">
                                </div>
                            <?php else: ?>
                                <!-- AI message: With feedback + suggestions section -->
                                <div class="chat-message ai">
                                    <img src="<?php echo $avatarSrc; ?>" alt="AI Avatar" class="avatar">
                                    <div class="message-wrapper">
                                        <div class="message-content"><?php echo nl2br(htmlspecialchars($msg['content'])); ?></div>
                                        <div class="feedback-buttons">
                                            <button class="feedback-btn thumbs-up" title="Helpful">
                                                <i class="fas fa-thumbs-up"></i>
                                            </button>
                                            <button class="feedback-btn thumbs-down" title="Not helpful">
                                                <i class="fas fa-thumbs-down"></i>
                                            </button>
                                        </div>
                                        <!-- Suggestions placeholder for loaded messages (fetch separately if needed) -->
                                        <div class="suggestions-section" style="display: none;">
                                            <div class="suggestions-title">Try these:</div>
                                            <div class="suggestions-list">
                                                <!-- Dynamically populated via JS if available -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <script>
                            document.getElementById('chatContainer').scrollTop = document.getElementById('chatContainer').scrollHeight;
                        </script>
                    <?php else: ?>
                        <div class="chat-message user">
                            <div class="message-content">Select a prompt from the left to load the chat or start a new one.</div>
                            <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
                        </div>
                    <?php endif; ?>
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
    const conversationId = '<?php echo $conversationId ?? ''; ?>'; // From PHP
    const token = localStorage.getItem('token') || '<?php echo $_SESSION['token'] ?? ''; ?>';
    const chatProxyUrl = 'auth/chat.php'; // Proxy endpoint

    // Auto-resize textarea on input (non-disruptive)
    document.addEventListener('DOMContentLoaded', () => {
        const chatInput = document.getElementById('chatInput');
        const chatContainer = document.getElementById('chatContainer');

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

        // Handle send button click
        const sendBtn = document.querySelector('.send-btn');
        if (sendBtn && chatInput) {
            sendBtn.addEventListener('click', async (e) => {
                e.preventDefault();

                let inputText = chatInput.value.trim();
                if (!inputText) {
                    alert('Please enter a message!');
                    return;
                }

                if (!conversationId || !token) {
                    alert('Please select a conversation and log in.');
                    return;
                }

                // Disable send and show loading
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                // Add user message to UI immediately
                const userMessageHtml = `
    <div class="chat-message user">
        <div class="message-wrapper">
            <div class="message-content">${inputText.replace(/\n/g, '<br>')}</div>
            <div class="user-actions">
                <small class="compare-text">Compare with Grok</small>
                <div class="grok-options">
                    <span class="grok-option" onclick="compareWithGrok(this, 'grok')">Grok</span>
                    <span class="grok-option" onclick="compareWithGrok(this, 'simple')">Simple</span>
                </div>
            </div>
        </div>
        <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
    </div>
`;
                chatContainer.innerHTML += userMessageHtml;
                chatContainer.scrollTop = chatContainer.scrollHeight;

                // Clear input
                chatInput.value = '';
                chatInput.style.height = 'auto';
                chatInput.style.height = chatInput.scrollHeight + 'px';

                try {
                    // Send to proxy
                    const response = await fetch(chatProxyUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            conversationId: conversationId,
                            content: inputText
                        })
                    });

                    const result = await response.json();

                    console.log();

                    if (!response.ok) {
                        throw new Error(result.error || 'Failed to send message');
                    }

                    // Append AI response (use result.content as per your example JSON)
                    const aiContent = result.content || 'AI response received.';
                    let suggestionsHtml = '';
                    if (result.nextSuggestions && Array.isArray(result.nextSuggestions) && result.nextSuggestions.length > 0) {
                        suggestionsHtml = `
                            <div class="suggestions-section">
                                <div class="suggestions-title">Try these:</div>
                                <div class="suggestions-list">
                                    ${result.nextSuggestions.map(sugg => `<span class="suggestion-item" onclick="applySuggestion('${sugg.label}', '${sugg.key}')">${sugg.label}</span>`).join('')}
                                </div>
                            </div>
                        `;
                    }
                    const aiMessageHtml = `
                        <div class="chat-message ai">
                            <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                            <div class="message-wrapper">
                                <div class="message-content">${aiContent.replace(/\n/g, '<br>')}</div>
                                <div class="feedback-buttons">
                                    <button class="feedback-btn thumbs-up" title="Helpful">
                                        <i class="fas fa-thumbs-up"></i>
                                    </button>
                                    <button class="feedback-btn thumbs-down" title="Not helpful">
                                        <i class="fas fa-thumbs-down"></i>
                                    </button>
                                </div>
                                ${suggestionsHtml}
                            </div>
                        </div>
                    `;
                    chatContainer.innerHTML += aiMessageHtml;
                    chatContainer.scrollTop = chatContainer.scrollHeight;

                } catch (error) {
                    console.error('Error sending message:', error);
                    const errorHtml = `
                        <div class="chat-message ai">
                            <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                            <div class="message-content" style="color: red;">Error: ${error.message}</div>
                        </div>
                    `;
                    chatContainer.innerHTML += errorHtml;
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                } finally {
                    // Re-enable send
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                }
            });
        }

        // Feedback click handlers (UI only – connect API later)
        document.addEventListener('click', (e) => {
            if (e.target.closest('.feedback-btn')) {
                const btn = e.target.closest('.feedback-btn');
                const isUp = btn.classList.contains('thumbs-up');
                const messageWrapper = btn.closest('.message-wrapper');

                // Remove selected from siblings
                const siblings = messageWrapper.querySelectorAll('.feedback-btn');
                siblings.forEach(sib => sib.classList.remove('selected'));

                // Add selected to this
                btn.classList.add('selected');

                // Stub: console.log for now
                console.log(`Feedback: ${isUp ? 'Up' : 'Down'} for message`);
            }
        });
    });

    function compareWithGrok(span, type) {
        // Stub: Highlight selected for now
        document.querySelectorAll('.grok-option').forEach(opt => opt.style.backgroundColor = '');
        span.style.backgroundColor = 'rgba(0, 123, 255, 0.2)';

        console.log(`Compare with ${type} Grok for user message`);
        // Later: Trigger comparison API, e.g., fetch('/compare?type=' + type + '&messageId=...')
    }

    // Stub for applying suggestions (UI only – connect to new chat call later)
    function applySuggestion(label, key) {
        console.log(`Applying suggestion: ${label} (${key})`);
        // Later: e.g., populate chatInput with template + content, then send
        // Example: chatInput.value = suggestion.template.replace('{{TEXT}}', previousContent);
        // Then sendBtn.click();
    }
</script>

<?php include 'includes/footer.php'; ?>