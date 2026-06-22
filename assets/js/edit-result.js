function initEditResult() {
    const form = document.querySelector('.edit-result-form');

    if (!form) {
        return;
    }

    const studentIdInput = form.querySelector('#student_id');
    const studentNameInput = form.querySelector('#student_name');
    const subjectInput = form.querySelector('#subject_name');
    const internalInput = form.querySelector('#internal_marks');
    const externalInput = form.querySelector('#external_marks');
    const totalInput = form.querySelector('#total_marks');
    const gradeInput = form.querySelector('#grade');

    const updateButton =
        form.querySelector('#update-result-btn');

    const initialValues = {
        student_id: studentIdInput.value,
        student_name: studentNameInput.value,
        subject_name: subjectInput.value,
        internal_marks: internalInput.value,
        external_marks: externalInput.value
    };

    let debounceTimer;

    function getGrade(total) {
        if (total >= 90) return 'A+';
        if (total >= 80) return 'A';
        if (total >= 70) return 'B';
        if (total >= 60) return 'C';
        if (total >= 50) return 'D';

        return 'F';
    }

    function hasChanges() {
        return (
            studentIdInput.value !== initialValues.student_id ||
            studentNameInput.value !== initialValues.student_name ||
            subjectInput.value !== initialValues.subject_name ||
            internalInput.value !== initialValues.internal_marks ||
            externalInput.value !== initialValues.external_marks
        );
    }

    function updateState() {
        const total =
            Number(internalInput.value || 0) +
            Number(externalInput.value || 0);

        totalInput.value = total;
        gradeInput.value = getGrade(total);

        updateButton.disabled = !hasChanges();
    }

    function handleInput() {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(
            updateState,
            500
        );
    }

    [
        studentIdInput,
        studentNameInput,
        subjectInput,
        internalInput,
        externalInput
    ].forEach(input => {
        input.addEventListener('input', handleInput);
    });

    updateButton.disabled = true;
}

document.addEventListener(
    'DOMContentLoaded',
    initEditResult
);