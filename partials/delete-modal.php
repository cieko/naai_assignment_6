<?php
/** @var array $resultToDelete */
?>

<div class="modal-overlay">

    <div class="modal card delete-modal">

        <a
            href="?page=view-results"
            class="modal-close">
            &times;
        </a>

        <div class="delete-modal__content">

            <h2>Delete Result</h2>

            <p>
                Are you sure you want to delete this record?
            </p>

            <div class="delete-preview">

                <strong>
                    <?= htmlspecialchars($resultToDelete['student_name']) ?>
                </strong>

                <span>
                    <?= htmlspecialchars($resultToDelete['subject_name']) ?>
                </span>

            </div>

            <form method="post">

                <input
                    type="hidden"
                    name="result_id"
                    value="<?= $resultToDelete['id'] ?>">

                <div class="delete-actions">

                    <a
                        href="?page=view-results"
                        class="action-btn cancel-btn">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        name="confirm_delete"
                        value="1"
                        class="action-btn delete-btn">
                        Delete
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>