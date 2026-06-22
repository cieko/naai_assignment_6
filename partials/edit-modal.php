<?php

/** @var array $resultToEdit */
?>

<div
    class="modal-overlay"
    role="dialog"
    aria-modal="true"
    aria-labelledby="edit-result-title">

    <div class="modal card">

        <a
            href="?page=view-results"
            class="modal-close"
            aria-label="Close edit result dialog">
            &times;
        </a>

        <section
            class="add-result"
            aria-labelledby="edit-result-title">

            <header class="add-result__header">

                <h2 id="edit-result-title">
                    Edit Result
                </h2>

                <p>
                    Update student examination details.
                </p>

            </header>

            <form
                class="add-result__form edit-result-form"
                method="post"
                aria-label="Edit examination result form">

                <input
                    type="hidden"
                    name="update_result"
                    value="1">

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
                                    value="<?= htmlspecialchars($resultToEdit['student_id']) ?>"
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
                                    value="<?= htmlspecialchars($resultToEdit['student_name']) ?>"
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
                                    value="<?= htmlspecialchars($resultToEdit['subject_name']) ?>"
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
                                    min="0"
                                    max="30"
                                    value="<?= $resultToEdit['internal_marks'] ?>"
                                    aria-describedby="edit-internal-help"
                                    required>

                                <small
                                    id="edit-internal-help"
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
                                    min="0"
                                    max="70"
                                    value="<?= $resultToEdit['external_marks'] ?>"
                                    aria-describedby="edit-external-help"
                                    required>

                                <small
                                    id="edit-external-help"
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
                                    value="<?= $resultToEdit['total_marks'] ?>"
                                    readonly
                                    aria-describedby="edit-total-description">

                                <span
                                    id="edit-total-description"
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
                                    value="<?= htmlspecialchars($resultToEdit['grade']) ?>"
                                    readonly
                                    aria-describedby="edit-grade-description">

                                <span
                                    id="edit-grade-description"
                                    class="sr-only">
                                    Automatically calculated based on total marks
                                </span>

                            </div>

                        </div>

                    </fieldset>

                </div>

                <button
                    id="update-result-btn"
                    type="submit"
                    disabled
                    aria-disabled="true">
                    Update Result
                </button>

            </form>

        </section>

    </div>

</div>