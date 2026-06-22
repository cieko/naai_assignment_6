<?php

function calculateGrade(int $totalMarks): string
{
    // Calculate grade based on total marks
    if ($totalMarks >= 90) return 'A+';
    if ($totalMarks >= 80) return 'A';
    if ($totalMarks >= 70) return 'B';
    if ($totalMarks >= 60) return 'C';
    if ($totalMarks >= 50) return 'D';

    return 'F';
}

function addResult(mysqli $conn, array $data): bool
{
    // Calculate total marks and grade before saving
    $totalMarks = $data['internal_marks'] + $data['external_marks'];
    $grade = calculateGrade($totalMarks);

    // Insert student result into database
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO results (
            student_id,
            student_name,
            subject_name,
            internal_marks,
            external_marks,
            total_marks,
            grade
        ) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssiiis",
        $data['student_id'],
        $data['student_name'],
        $data['subject_name'],
        $data['internal_marks'],
        $data['external_marks'],
        $totalMarks,
        $grade
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}

function handleAddResult(mysqli $conn): void
{
    // Only handle form submissions
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    // Collect and sanitize form data
    $data = [
        'student_id' => trim($_POST['student_id'] ?? ''),
        'student_name' => trim($_POST['student_name'] ?? ''),
        'subject_name' => trim($_POST['subject_name'] ?? ''),
        'internal_marks' => (int) ($_POST['internal_marks'] ?? 0),
        'external_marks' => (int) ($_POST['external_marks'] ?? 0),
    ];

    // Store validation errors
    $errors = [];

    if ($data['student_id'] === '') {
        $errors[] = 'Student ID is required.';
    }

    if ($data['student_name'] === '') {
        $errors[] = 'Student name is required.';
    }

    if ($data['subject_name'] === '') {
        $errors[] = 'Subject name is required.';
    }

    if ($data['internal_marks'] < 0 || $data['internal_marks'] > 30) {
        $errors[] = 'Internal marks must be between 0 and 30.';
    }

    if ($data['external_marks'] < 0 || $data['external_marks'] > 70) {
        $errors[] = 'External marks must be between 0 and 70.';
    }

    // If errors → store flash and redirect back
    if (!empty($errors)) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => implode(' | ', $errors)
        ];

        header('Location: ?page=add-result');
        exit;
    }

    // save
    if (!addResult($conn, $data)) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Failed to save result.'
        ];

        header('Location: ?page=add-result');
        exit;
    }

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Result added successfully!'
    ];

    header('Location: ?page=view-results');
    exit;
}

function getResults(mysqli $conn): array
{
    $results = [];

    // Fetch all results, newest first
    $query = "
        SELECT *
        FROM results
        ORDER BY created_at DESC
    ";

    $response = mysqli_query($conn, $query);

    if (!$response) {
        return [];
    }

    while ($row = mysqli_fetch_assoc($response)) {
        $results[] = $row;
    }

    return $results;
}

function getResultById(mysqli $conn, int $id): ?array
{
    // Get a single result record using its ID
    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM results WHERE id = ? LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $row ?: null;
}

function updateResult(mysqli $conn, int $id, array $data): bool
{
    // Recalculate total and grade after updating marks
    $totalMarks = $data['internal_marks'] + $data['external_marks'];
    $grade = calculateGrade($totalMarks);

    // Update result record
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE results
         SET
            student_id = ?,
            student_name = ?,
            subject_name = ?,
            internal_marks = ?,
            external_marks = ?,
            total_marks = ?,
            grade = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssiiisi",
        $data['student_id'],
        $data['student_name'],
        $data['subject_name'],
        $data['internal_marks'],
        $data['external_marks'],
        $totalMarks,
        $grade,
        $id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}

function deleteResult(mysqli $conn, int $id): bool
{
    // Delete a result using its ID
    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM results WHERE id = ?"
    );

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}

function getDashboardStats(mysqli $conn): array
{
    // Default dashboard values
    $stats = [
        'total' => 0,
        'passed' => 0,
        'failed' => 0,
        'top_score' => 0
    ];

    // Calculate dashboard statistics
    $result = mysqli_query(
        $conn,
        "
        SELECT
            COUNT(*) AS total,
            SUM(CASE WHEN grade <> 'F' THEN 1 ELSE 0 END) AS passed,
            SUM(CASE WHEN grade = 'F' THEN 1 ELSE 0 END) AS failed,
            MAX(total_marks) AS top_score
        FROM results
        "
    );

    if ($row = mysqli_fetch_assoc($result)) {
        $stats = $row;
    }

    return $stats;
}

function getTopper(mysqli $conn): ?array
{
    $result = mysqli_query(
        $conn,
        "
        SELECT *
        FROM results
        ORDER BY total_marks DESC
        LIMIT 1
        "
    );

    return mysqli_fetch_assoc($result) ?: null;
}

function getSubjectAnalysis(mysqli $conn): array
{
    $subjects = [];

    $result = mysqli_query(
        $conn,
        "
        SELECT
            subject_name,
            COUNT(*) AS student_count,
            ROUND(AVG(total_marks), 2) AS average_marks
        FROM results
        GROUP BY subject_name
        ORDER BY average_marks DESC
        "
    );

    while ($row = mysqli_fetch_assoc($result)) {
        $subjects[] = $row;
    }

    return $subjects;
}

function searchResults(
    mysqli $conn,
    string $keyword
): array {

    $results = [];

    $keyword = '%' . $keyword . '%';

    $stmt = mysqli_prepare(
        $conn,
        "
        SELECT *
        FROM results
        WHERE
            student_id LIKE ?
            OR student_name LIKE ?
            OR subject_name LIKE ?
        ORDER BY created_at DESC
        "
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $keyword,
        $keyword,
        $keyword
    );

    mysqli_stmt_execute($stmt);

    $queryResult = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($queryResult)) {
        $results[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $results;
}
