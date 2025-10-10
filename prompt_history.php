<?php
$conversations = [];

if (is_logged_in()) {
    $conversations = get_conversations(); // No token param, uses session
    if (isset($conversations['error'])) {
        $conversations = []; // Treat error as empty
    }
}
?>

<div class="prompt-list-container">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search my prompts...">
    </div>
    <h6 class="mb-0 mt-1">My Prompts</h6>
    <div class="prompt-list">
        <?php if (is_array($conversations) && !empty($conversations)): ?>
            <?php foreach ($conversations as $conv): ?>
                <?php if (!$conv['archived']): ?>
                    <div class="prompt-list-item" data-id="<?php echo htmlspecialchars($conv['id']); ?>" data-title="<?php echo htmlspecialchars($conv['title']); ?>">

                        <p
                            style="cursor: pointer;"
                            onclick="window.location.href='my_prompt.php?id=<?php echo urlencode($conv['id']); ?>'">
                            <?php echo htmlspecialchars($conv['title']); ?>
                        </p>

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="prompt-list-item">
                <p>No prompts yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>