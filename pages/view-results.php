<?php

/** @var mysqli $conn */

$search = trim(
    $_GET['search'] ?? ''
);

$results = $search !== ''
    ? searchResults($conn, $search)
    : getResults($conn);

$editId = isset($_GET['edit'])
    ? (int) $_GET['edit']
    : null;

$deleteId = isset($_GET['delete'])
    ? (int) $_GET['delete']
    : null;

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['update_result'])
    && $editId !== null
) {

    $data = [
        'student_id' => trim($_POST['student_id']),
        'student_name' => trim($_POST['student_name']),
        'subject_name' => trim($_POST['subject_name']),
        'internal_marks' => (int) $_POST['internal_marks'],
        'external_marks' => (int) $_POST['external_marks'],
    ];

    if (updateResult($conn, $editId, $data)) {

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Result updated successfully!'
        ];

        header('Location: ?page=view-results');
        exit;
    }
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['confirm_delete'])
) {

    $deleteId = (int) $_POST['result_id'];

    if (deleteResult($conn, $deleteId)) {

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Result deleted successfully!'
        ];
    } else {

        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Failed to delete result.'
        ];
    }

    header('Location: ?page=view-results');
    exit;
}
?>

<section
    class="card view-results"
    data-page-title="View Results"
    aria-labelledby="view-results-title">

    <h1
        id="view-results-title"
        class="sr-only">
        View Results
    </h1>

    <div class="view-results__header">

        <div>
            <h2>View Results</h2>
            <p>All examination records.</p>
        </div>

        <form
            class="search-form"
            method="get"
            role="search"
            aria-label="Search student records">

            <input
                type="hidden"
                name="page"
                value="view-results">

            <label
                for="search-results"
                class="sr-only">
                Search by student ID, student name or subject
            </label>

            <input
                id="search-results"
                type="text"
                name="search"
                placeholder="Search student..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                aria-describedby="search-help">

            <span
                id="search-help"
                class="sr-only">
                Search by student ID, student name or subject name
            </span>

            <button
                type="submit"
                class="search-btn"
                aria-label="Search results">
                Search
            </button>

        </form>

    </div>

    <div class="table-wrapper">

        <table>

            <caption class="sr-only">
                Student examination results table
            </caption>

            <thead>

                <tr>
                    <th scope="col">Student ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Internal</th>
                    <th scope="col">External</th>
                    <th scope="col">Total</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php if (empty($results)): ?>

                    <tr>

                        <td
                            colspan="8"
                            class="empty-row"
                            role="status"
                            aria-live="polite">

                            <?php if ($search !== ''): ?>
                                No matching results found.
                            <?php else: ?>
                                No results found.
                            <?php endif; ?>

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach ($results as $result): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($result['student_id']) ?>
                            </td>

                            <td
                                class="name"
                                title="<?= htmlspecialchars($result['student_name']) ?>">
                                <?= htmlspecialchars($result['student_name']) ?>
                            </td>

                            <td
                                class="subject"
                                title="<?= htmlspecialchars($result['subject_name']) ?>">
                                <?= htmlspecialchars($result['subject_name']) ?>
                            </td>

                            <td><?= $result['internal_marks'] ?></td>
                            <td><?= $result['external_marks'] ?></td>
                            <td><?= $result['total_marks'] ?></td>
                            <td><?= $result['grade'] ?></td>

                            <td class="actions">

                                <a
                                    href="?page=view-results&edit=<?= $result['id'] ?>"
                                    class="action-btn edit-btn"
                                    aria-label="Edit result for <?= htmlspecialchars($result['student_name']) ?>">
                                    Edit
                                </a>

                                <a
                                    href="?page=view-results&delete=<?= $result['id'] ?>"
                                    class="action-btn delete-btn"
                                    aria-label="Delete result for <?= htmlspecialchars($result['student_name']) ?>">
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>

<?php
if ($editId !== null) {
    $resultToEdit = getResultById(
        $conn,
        $editId
    );

    require __DIR__ . '/../partials/edit-modal.php';
}
?>

<?php
if ($deleteId !== null) {

    $resultToDelete = getResultById(
        $conn,
        $deleteId
    );

    require __DIR__ . '/../partials/delete-modal.php';
}
?>