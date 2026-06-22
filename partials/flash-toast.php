<?php if (!empty($flash)): ?>

    <div
        class="toast <?= htmlspecialchars($flash['type']) ?>"
        role="<?= $flash['type'] === 'error' ? 'alert' : 'status' ?>"
        aria-live="<?= $flash['type'] === 'error' ? 'assertive' : 'polite' ?>"
        aria-atomic="true">

        <?= htmlspecialchars($flash['message']) ?>

    </div>

<?php endif; ?>