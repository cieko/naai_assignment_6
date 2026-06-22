<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/results-crud.php';

$conn = connection();

$page = $_GET['page'] ?? 'dashboard';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$allowedPages = [
    'dashboard',
    'add-result',
    'view-results'
];

if (!in_array($page, $allowedPages, true)) {
    $page = 'dashboard';
}

$pageTitles = [
    'dashboard'    => 'Dashboard',
    'add-result'   => 'Add Result',
    'view-results' => 'View Results'
];

$basePath = '/result-board/';
$currentTitle = $pageTitles[$page] ?? 'Result Board';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <base href="<?= htmlspecialchars($basePath) ?>">

    <title>
        <?= htmlspecialchars($currentTitle) ?> | Result Board
    </title>

    <link
        rel="stylesheet"
        href="assets/css/style.css">

    <link
        rel="shortcut icon"
        href="assets/images/favicon.ico"
        type="image/x-icon">

    <script>
        window.APP_CONFIG = {
            basePath: <?= json_encode($basePath) ?>
        };
    </script>

    <script src="assets/js/add-result.js" defer></script>
    <script src="assets/js/edit-result.js" defer></script>
    <script src="assets/js/app.js" defer></script>
</head>

<body>

    <!-- Skip navigation for keyboard users -->
    <a
        href="#app"
        class="skip-link">
        Skip to main content
    </a>

    <?php require __DIR__ . '/partials/hero.php'; ?>

    <?php if ($flash): ?>
        <div
            class="sr-only"
            role="status"
            aria-live="polite"
            aria-atomic="true">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <?php require __DIR__ . '/partials/flash-toast.php'; ?>

    <main
        id="app"
        class="container"
        role="main"
        tabindex="-1"
        aria-label="<?= htmlspecialchars($currentTitle) ?>"
        data-current-page="<?= htmlspecialchars($page) ?>">

        <?php require __DIR__ . "/pages/{$page}.php"; ?>

    </main>

    <?php require __DIR__ . '/partials/footer.php'; ?>

</body>

</html>