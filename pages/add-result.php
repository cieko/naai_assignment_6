<?php

/** @var mysqli $conn */

$errors = handleAddResult($conn);
?>

<section
    class="card add-result"
    data-page-title="Add Result"
    aria-labelledby="add-result-title">

    <header class="add-result__header">

        <h1
            id="add-result-title">
            Add Result
        </h1>

        <p>
            Enter student examination details.
        </p>

    </header>

    <form
        class="add-result__form"
        action=""
        method="post"
        novalidate
        aria-label="Add examination result form">

        <div class="template-wrapper">

            <fieldset>
                <legend class="sr-only">
                    Student Information
                </legend>

                <div class="form-group__wrapper">

                    <div class="form-group id">

                        <label for="student_id">
                            Student ID
                        </label>

                        <input
                            type="text"
                            id="student_id"
                            name="student_id"
                            value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>"
                            autocomplete="off"
                            required>

                    </div>

                    <div class="form-group name">

                        <label for="student_name">
                            Student Name
                        </label>

                        <input
                            type="text"
                            id="student_name"
                            name="student_name"
                            value="<?= htmlspecialchars($_POST['student_name'] ?? '') ?>"
                            autocomplete="name"
                            required>

                    </div>

                </div>

            </fieldset>

            <fieldset>

                <legend class="sr-only">
                    Examination Marks
                </legend>

                <div class="form-group__wrapper">

                    <div class="subject-name form-group">

                        <label for="subject_name">
                            Subject Name
                        </label>

                        <input
                            type="text"
                            id="subject_name"
                            name="subject_name"
                            value="<?= htmlspecialchars($_POST['subject_name'] ?? '') ?>"
                            autocomplete="off"
                            required>

                    </div>

                    <div class="internal form-group">

                        <label for="internal_marks">
                            Internal (Out of 30)
                        </label>

                        <input
                            type="number"
                            id="internal_marks"
                            name="internal_marks"
                            value="<?= htmlspecialchars($_POST['internal_marks'] ?? '') ?>"
                            min="0"
                            max="30"
                            aria-describedby="internal-help"
                            required>

                        <small
                            id="internal-help"
                            class="sr-only">
                            Enter marks between 0 and 30
                        </small>

                    </div>

                    <div class="external form-group">

                        <label for="external_marks">
                            External (Out of 70)
                        </label>

                        <input
                            type="number"
                            id="external_marks"
                            name="external_marks"
                            value="<?= htmlspecialchars($_POST['external_marks'] ?? '') ?>"
                            min="0"
                            max="70"
                            aria-describedby="external-help"
                            required>

                        <small
                            id="external-help"
                            class="sr-only">
                            Enter marks between 0 and 70
                        </small>

                    </div>

                </div>

            </fieldset>

            <fieldset>

                <legend class="sr-only">
                    Calculated Result
                </legend>

                <div class="form-group__wrapper">

                    <div class="total form-group">

                        <label for="total_marks">
                            Total Marks
                        </label>

                        <input
                            type="number"
                            id="total_marks"
                            name="total_marks"
                            readonly
                            aria-describedby="total-description">

                        <span
                            id="total-description"
                            class="sr-only">
                            Automatically calculated from internal and external marks
                        </span>

                    </div>

                    <div class="grade form-group">

                        <label for="grade">
                            Grade
                        </label>

                        <input
                            type="text"
                            id="grade"
                            name="grade"
                            readonly
                            aria-describedby="grade-description">

                        <span
                            id="grade-description"
                            class="sr-only">
                            Automatically calculated based on total marks
                        </span>

                    </div>

                </div>

            </fieldset>

        </div>

        <button
            id="save-result-btn"
            type="submit"
            disabled
            aria-disabled="true">
            Save Result
        </button>

    </form>

</section>