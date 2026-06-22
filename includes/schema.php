<?php

function initialiseDatabase(mysqli $conn): void
{
    $sql = "
        CREATE TABLE IF NOT EXISTS results (
            id INT AUTO_INCREMENT PRIMARY KEY,

            student_id VARCHAR(20) NOT NULL,
            student_name VARCHAR(100) NOT NULL,
            subject_name VARCHAR(100) NOT NULL,

            internal_marks TINYINT UNSIGNED NOT NULL,
            external_marks TINYINT UNSIGNED NOT NULL,

            total_marks TINYINT UNSIGNED NOT NULL,
            grade VARCHAR(2) NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            INDEX idx_student_id (student_id),
            INDEX idx_student_name (student_name),
            INDEX idx_subject_name (subject_name)
        )
    ";

    if (!mysqli_query($conn, $sql)) {
        throw new RuntimeException(
            'Failed to initialise database: ' . mysqli_error($conn)
        );
    }
}