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
        padding: 5px 20px 0 20px;
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

    .grok-option {
        color: #00B7E5;
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

    /* AI actions: Feedback + Compare (right of dislike) */
    .ai-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 6px;
        opacity: 0.6;
        transition: opacity 0.2s ease;
    }

    .ai-actions:hover {
        /* opacity: 1; */
    }

    .ai-actions .feedback-buttons {
        display: flex;
        gap: 6px;
    }



    .ai-actions .compare-text {
        font-size: 11px;
        color: #666;
        font-style: italic;
        margin-right: 4px;
    }

    .change-provider {
        cursor: pointer;

        font-size: 11px;
        color: #00B7E5;
        font-style: italic;
        align-self: flex-end;

    }

    .change-provider:hover {
        color: #009EC9;
        font-size: 11.50px;
    }

    /* New styles for selected tool tag */
    .selected-tool-tag {
        display: none;
        background-color: #E4E4E7;
        color: #000000;
        padding: 5px 10px;
        border-radius: 20px;
        margin-bottom: 10px;
        font-size: 13px;
        position: relative;
        width: fit-content;
    }

    .selected-tool-tag.active {
        display: block;
    }

    .selected-tool-cross {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        font-weight: bold;
        margin-left: 10px;
    }

    .selected-tool-cross:hover {
        color: #a71d2a;
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
                            $assistantId = $isUser ? '' : ($msg['id'] ?? ''); // Assume 'id' is assistantMessageId for AI
                            ?>
                            <?php if ($isUser): ?>
                                <div class="chat-message user">
                                    <div class="message-wrapper">
                                        <div class="message-content"><?php echo nl2br(htmlspecialchars($msg['content'])); ?></div>
                                    </div>
                                    <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" class="avatar">
                                </div>
                            <?php else: ?>
                                <!-- AI message: With feedback + compare options right of dislike -->
                                <div class="chat-message ai">
                                    <img src="<?php echo $avatarSrc; ?>" alt="AI Avatar" class="avatar">
                                    <div class="message-wrapper" data-assistant-id="<?php echo htmlspecialchars($assistantId); ?>" data-feedback-state="none">
                                        <div class="message-content"><?php echo nl2br(htmlspecialchars($msg['content'])); ?></div>
                                        <div class="ai-actions">
                                            <div class="feedback-buttons">
                                                <button class="feedback-btn thumbs-up" title="Helpful">
                                                    <i class="fas fa-thumbs-up"></i>
                                                </button>
                                                <button class="feedback-btn thumbs-down" title="Not helpful">
                                                    <i class="fas fa-thumbs-down"></i>
                                                </button>
                                            </div>
                                            <!-- <small class="compare-text">Compare with:</small>
                                            <small class="change-provider" onclick="compareWithGrok(this, 'grok')">Grok</small>
                                            <small class="change-provider" onclick="compareWithGrok(this, 'simple')">Simple</small> -->

                                        </div>
                                        <!-- Suggestions placeholder for loaded messages (fetch separately if needed) -->
                                        <div class="suggestions-section" style="display: none;">
                                            <div class="suggestions-title">Suggestions:</div>
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
                <div id="selectedToolTag" class="selected-tool-tag mt-1"></div>
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
    const chatProxyUrl = 'auth/chat.php';
    const chatWithToolProxyUrl = 'auth/chat_with_tool.php'; // New proxy
    const feedbackProxyUrl = 'auth/feedback.php';
    const forceProxyUrl = 'auth/force_provider_chat.php';
    let suggestionOverride = null;
    let lastSentContent = '';
    let lastInputText = '';
    let selectedTool = null; // To store {category, name, args, title}
    const sendBtn = document.querySelector('.send-btn');

    // Helper: Append user message to chat container
    function appendUserMessage(content) {
        const chatContainer = document.getElementById('chatContainer');
        const userMessageHtml = `
            <div class="chat-message user">
                <div class="message-wrapper">
                    <div class="message-content">${content.replace(/\n/g, '<br>')}</div>
                </div>
                <img src="assets/images/author-avatar.png" alt="User Avatar" class="avatar">
            </div>
        `;
        chatContainer.insertAdjacentHTML('beforeend', userMessageHtml);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Helper: Append AI message to chat container
    function appendAIMessage(aiContent, assistantMessageId, nextSuggestions, provider) {
        const chatContainer = document.getElementById('chatContainer');
        const suggestionsHtml = buildSuggestionsHtml(nextSuggestions);
        const compareOptionsHtml = buildCompareOptionsHtml(provider);

        const aiMessageHtml = `
            <div class="chat-message ai">
                <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                <div class="message-wrapper" data-assistant-id="${assistantMessageId || ''}" data-feedback-state="none" data-suggestions='${JSON.stringify(nextSuggestions || [])}'>
                    <div class="message-content">${aiContent.replace(/\n/g, '<br>')}</div>
                    <div class="ai-actions">
                        <div class="feedback-buttons">
                            <button class="feedback-btn thumbs-up" title="Helpful">
                                <i class="fas fa-thumbs-up"></i>
                            </button>
                            <button class="feedback-btn thumbs-down" title="Not helpful">
                                <i class="fas fa-thumbs-down"></i>
                            </button>
                        </div>
                        ${compareOptionsHtml}
                    </div>
                    ${suggestionsHtml}
                </div>
            </div>
        `;
        chatContainer.insertAdjacentHTML('beforeend', aiMessageHtml);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Helper: Build suggestions HTML
    function buildSuggestionsHtml(nextSuggestions) {
        if (!nextSuggestions || !Array.isArray(nextSuggestions) || nextSuggestions.length === 0) {
            return '';
        }
        return `
            <div class="suggestions-section">
                <div class="suggestions-title">Suggestions:</div>
                <div class="suggestions-list">
                    ${nextSuggestions.map(sugg => `<span class="suggestion-item" onclick="applySuggestion('${sugg.key}')">${sugg.label}</span>`).join('')}
                </div>
            </div>
        `;
    }

    // Helper: Build compare options HTML
    function buildCompareOptionsHtml(currentProvider) {
        const enabledProviders = <?php echo json_encode($_SESSION['enabledProviders'] ?? []); ?>;
        const otherProviders = enabledProviders.filter(p => p !== currentProvider);
        if (otherProviders.length === 0) {
            return '';
        }
        return `
            <small class="compare-text">Compare with:</small>
            ${otherProviders.map(provider => 
                `<small class="change-provider" onclick="compareWithProvider('${provider}')">${provider.charAt(0).toUpperCase() + provider.slice(1)}</small>`
            ).join('')}
        `;
    }

    // Helper: Hide UI elements (suggestions, compare)
    function hideUIElements() {
        document.querySelectorAll('.suggestions-section').forEach(sec => sec.style.display = 'none');
        document.querySelectorAll('.compare-text').forEach(sec => sec.style.display = 'none');
        document.querySelectorAll('.change-provider').forEach(sec => sec.style.display = 'none');
    }

    // Helper: Set loading state on send button
    function setLoadingState(loading) {
        if (loading) {
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        } else {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        }
    }

    // Helper: Reset textarea height
    function resetTextareaHeight() {
        const chatInput = document.getElementById('chatInput');
        if (chatInput) {
            chatInput.style.height = 'auto';
            chatInput.style.height = chatInput.scrollHeight + 'px';
        }
    }

    // Helper: Send chat request (normal or with tool or force provider)
    async function sendChatRequest(content, forceProvider = null) {
        let url = chatProxyUrl;
        let body = {
            conversationId,
            content
        };

        if (selectedTool) {
            url = chatWithToolProxyUrl;
            body.tool = {
                category: selectedTool.category,
                name: selectedTool.name,
                args: selectedTool.args
            };
        } else if (forceProvider) {
            url = forceProxyUrl;
            body = {
                provider: forceProvider,
                content
            };
        }

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        const result = await response.json();
        console.log(result);
        if (!response.ok) {
            throw new Error(result.error || 'Failed to send message');
        }
        return result;
    }

    // Main: Auto-resize textarea on input
    document.addEventListener('DOMContentLoaded', () => {
        const chatInput = document.getElementById('chatInput');
        const chatContainer = document.getElementById('chatContainer');

        if (chatInput) {
            // Initial height set
            resetTextareaHeight();

            chatInput.addEventListener('input', function() {
                this.style.height = 'auto';
                const newHeight = Math.min(this.scrollHeight, 120);
                this.style.height = newHeight + 'px';
            });

            // Enter to send (without Shift for new line)
            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendBtn.click();
                }
            });
        }

        // Send button handler
        if (sendBtn && chatInput) {
            sendBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                const inputText = chatInput.value.trim();
                if (!inputText) {
                    alert('Please enter a message!');
                    return;
                }

                if (!conversationId || !token) {
                    alert('Please select a conversation and log in.');
                    return;
                }

                // Prepare content
                let sendContent = inputText;
                if (suggestionOverride && suggestionOverride.fullPrompt) {
                    sendContent = suggestionOverride.fullPrompt;
                    suggestionOverride = null;
                }
                lastSentContent = sendContent;
                lastInputText = inputText;

                hideUIElements();
                setLoadingState(true);
                appendUserMessage(inputText);
                chatInput.value = '';
                resetTextareaHeight();

                try {
                    const result = await sendChatRequest(sendContent);
                    const {
                        content: aiContent,
                        assistantMessageId,
                        nextSuggestions,
                        provider
                    } = result;
                    appendAIMessage(aiContent || 'AI response received.', assistantMessageId, nextSuggestions, provider);
                    // Clear selected tool after successful send
                    clearSelectedTool();
                } catch (error) {
                    console.error('Error sending message:', error);
                    const errorHtml = `
                        <div class="chat-message ai">
                            <img src="assets/images/favicon.png" alt="AI Avatar" class="avatar">
                            <div class="message-content" style="color: red;">Error: ${error.message}</div>
                        </div>
                    `;
                    chatContainer.insertAdjacentHTML('beforeend', errorHtml);
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                } finally {
                    setLoadingState(false);
                }
            });
        }

        // Feedback handler
        document.addEventListener('click', async (e) => {
            if (e.target.closest('.feedback-btn')) {
                e.preventDefault();
                const btn = e.target.closest('.feedback-btn');
                const isUp = btn.classList.contains('thumbs-up');
                const messageWrapper = btn.closest('.message-wrapper');
                const assistantMessageId = messageWrapper.dataset.assistantId;

                if (!assistantMessageId) {
                    console.error('No assistantMessageId found');
                    return;
                }

                const currentState = messageWrapper.dataset.feedbackState || 'none';
                let newState = determineNewFeedbackState(currentState, isUp);

                // Update UI optimistically
                updateFeedbackUI(messageWrapper, newState, btn);

                // Prepare payload
                const payload = {
                    assistantMessageId,
                    reaction: newState
                };
                const {
                    reason,
                    comment
                } = getFeedbackDetails(newState);
                if (newState !== 'none') {
                    payload.reason = reason;
                    payload.comment = comment;
                }

                try {
                    const response = await fetch(feedbackProxyUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });
                    const result = await response.json();
                    if (!response.ok) {
                        throw new Error(result.error || 'Feedback failed');
                    }
                    console.log(`Feedback sent: ${newState}`);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        title: 'Thanks for your feedback!',
                        icon: 'success',
                    });
                } catch (error) {
                    console.error('Feedback error:', error);
                    // Revert UI
                    revertFeedbackUI(messageWrapper, currentState);
                    alert('Failed to send feedback: ' + error.message);
                }
            }
        });
    });

    // Helper: Determine new feedback state
    function determineNewFeedbackState(currentState, isUp) {
        if (currentState === 'like' && isUp) return 'none';
        if (currentState === 'dislike' && !isUp) return 'none';
        return isUp ? 'like' : 'dislike';
    }

    // Helper: Update feedback UI
    function updateFeedbackUI(messageWrapper, newState, btn) {
        const siblings = messageWrapper.querySelectorAll('.feedback-btn');
        siblings.forEach(sib => sib.classList.remove('selected'));
        if (newState !== 'none') {
            btn.classList.add('selected');
        }
        messageWrapper.dataset.feedbackState = newState;
    }

    // Helper: Revert feedback UI
    function revertFeedbackUI(messageWrapper, currentState) {
        const siblings = messageWrapper.querySelectorAll('.feedback-btn');
        siblings.forEach(sib => sib.classList.remove('selected'));
        if (currentState !== 'none') {
            const prevBtn = messageWrapper.querySelector(`.feedback-btn.${currentState === 'like' ? 'thumbs-up' : 'thumbs-down'}`);
            if (prevBtn) prevBtn.classList.add('selected');
        }
        messageWrapper.dataset.feedbackState = currentState;
    }

    // Helper: Get feedback details (reason/comment)
    function getFeedbackDetails(state) {
        if (state === 'like') {
            return {
                reason: 'helpful',
                comment: 'Concise and accurate.'
            };
        } else if (state === 'dislike') {
            return {
                reason: 'incorrect',
                comment: 'Got the date wrong.'
            };
        }
        return {
            reason: null,
            comment: null
        };
    }

    // Apply suggestion function
    function applySuggestion(key) {
        const clickedItem = event.target;
        const messageWrapper = clickedItem.closest('.message-wrapper');
        if (!messageWrapper) {
            console.error('No message wrapper found');
            return;
        }

        const prevContentEl = messageWrapper.querySelector('.message-content');
        if (!prevContentEl) {
            console.error('No previous content found');
            return;
        }
        const prevText = prevContentEl.textContent.trim();

        const suggestionsStr = messageWrapper.dataset.suggestions;
        const suggestions = suggestionsStr ? JSON.parse(suggestionsStr) : [];
        const sugg = suggestions.find(s => s.key === key);
        if (!sugg || !sugg.template) {
            console.error('Suggestion not found or missing template:', key);
            return;
        }

        let fullPrompt = sugg.template.replace('{{TEXT}}', prevText);
        if (fullPrompt.includes('{{LANG}}')) {
            fullPrompt = fullPrompt.replace('{{LANG}}', 'German');
        }

        const chatInput = document.getElementById('chatInput');
        if (chatInput) {
            chatInput.value = sugg.label;
            resetTextareaHeight();
            suggestionOverride = {
                fullPrompt
            };
            sendBtn.click();
        }
        console.log(`Applying suggestion: ${key} with full prompt`);
    }

    // Compare with provider function (renamed for clarity)
    function compareWithProvider(provider) {
        if (!lastSentContent) {
            alert('No recent message to compare.');
            return;
        }

        hideUIElements();
        setLoadingState(true);
        appendUserMessage(lastInputText);

        sendChatRequest(lastSentContent, provider)
            .then(result => {
                setLoadingState(false);
                const {
                    content: aiContent,
                    assistantMessageId,
                    nextSuggestions,
                    provider: currentProvider
                } = result;
                if (result.error) {
                    alert('Failed to compare: ' + result.error);
                    return;
                }
                appendAIMessage(aiContent || 'AI response received.', assistantMessageId, nextSuggestions, currentProvider);
            })
            .catch(error => {
                setLoadingState(false);
                console.error('Force provider error:', error);
                alert('Failed to compare: ' + error.message);
            });
    }
</script>

<?php include 'includes/footer.php'; ?>