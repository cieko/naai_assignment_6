<?php

/** @var mysqli $conn */

$stats = getDashboardStats($conn);

$topper = getTopper($conn);

$subjects = getSubjectAnalysis($conn);

$passPercentage = $stats['total'] > 0
    ? round(($stats['passed'] / $stats['total']) * 100, 1)
    : 0;

$failPercentage = $stats['total'] > 0
    ? round(($stats['failed'] / $stats['total']) * 100, 1)
    : 0;

?>

<section
    class="dashboard"
    data-page-title="Dashboard"
    aria-labelledby="dashboard-title">

    <h1 id="dashboard-title" class="sr-only">
        Dashboard
    </h1>

    <div class="dashboard-bento">

        <section
            class="card topper-card"
            aria-labelledby="topper-heading">

            <div class="topper-header">

                <span
                    class="topper-icon"
                    aria-hidden="true">
                    🏆
                </span>

                <div>
                    <h2 id="topper-heading">
                        Top Performing Student
                    </h2>

                    <p>
                        Highest overall examination score
                    </p>
                </div>

            </div>

            <?php if ($topper): ?>

                <div class="topper-details">

                    <div class="topper-name">
                        <?= htmlspecialchars($topper['student_name']) ?>
                    </div>

                    <div class="topper-grid">

                        <div>
                            <span>Student ID</span>

                            <strong>
                                <?= htmlspecialchars($topper['student_id']) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Subject</span>

                            <strong>
                                <?= htmlspecialchars($topper['subject_name']) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Total Marks</span>

                            <strong>
                                <?= $topper['total_marks'] ?>/100
                            </strong>
                        </div>

                        <div>
                            <span>Grade</span>

                            <strong>
                                <?= htmlspecialchars($topper['grade']) ?>
                            </strong>
                        </div>

                    </div>

                </div>

            <?php else: ?>

                <p>No results available.</p>

            <?php endif; ?>

        </section>

        <section
            class="card stat-card"
            aria-labelledby="total-results-heading">

            <h2 id="total-results-heading">
                Total Results
            </h2>

            <span aria-label="<?= $stats['total'] ?> total results">
                <?= $stats['total'] ?>
            </span>

        </section>

        <section
            class="card stat-card"
            aria-labelledby="top-score-heading">

            <h2 id="top-score-heading">
                Top Score
            </h2>

            <span aria-label="Highest score <?= $stats['top_score'] ?: 0 ?>">
                <?= $stats['top_score'] ?: 0 ?>
            </span>

        </section>

        <section
            class="card stat-card"
            aria-labelledby="pass-rate-heading">

            <h2 id="pass-rate-heading">
                Pass Rate
            </h2>

            <span aria-label="<?= $passPercentage ?> percent pass rate">
                <?= $passPercentage ?>%
            </span>

        </section>

        <section
            class="card stat-card"
            aria-labelledby="subjects-heading">

            <h2 id="subjects-heading">
                Subjects
            </h2>

            <span aria-label="<?= count($subjects) ?> subjects">
                <?= count($subjects) ?>
            </span>

        </section>

        <section
            class="card stat-card"
            aria-labelledby="passed-heading">

            <h2 id="passed-heading">
                Passed
            </h2>

            <span aria-label="<?= $stats['passed'] ?> students passed">
                <?= $stats['passed'] ?>
            </span>

        </section>

        <section
            class="card stat-card"
            aria-labelledby="failed-heading">

            <h2 id="failed-heading">
                Failed
            </h2>

            <span aria-label="<?= $stats['failed'] ?> students failed">
                <?= $stats['failed'] ?>
            </span>

        </section>

        <section
            class="card subject-analysis"
            aria-labelledby="subject-analysis-heading">

            <h2 id="subject-analysis-heading">
                <span aria-hidden="true">📚</span>
                Subject Analysis
            </h2>

            <?php if ($subjects): ?>

                <table>

                    <caption class="sr-only">
                        Subject-wise performance analysis
                    </caption>

                    <thead>
                        <tr>
                            <th scope="col">Subject</th>
                            <th scope="col">Students</th>
                            <th scope="col">Average Marks</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($subjects as $subject): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($subject['subject_name']) ?>
                                </td>

                                <td>
                                    <?= $subject['student_count'] ?>
                                </td>

                                <td>
                                    <?= $subject['average_marks'] ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <p class="dashboard__no-data">
                    No subject data available.
                </p>

            <?php endif; ?>

        </section>

    </div>

</section>