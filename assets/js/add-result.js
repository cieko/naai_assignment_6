function initAddResult() {
    const internalInput = document.getElementById('internal_marks');
    const externalInput = document.getElementById('external_marks');
    const totalInput = document.getElementById('total_marks');
    const gradeInput = document.getElementById('grade');
    const saveButton = document.getElementById('save-result-btn');

    if (!internalInput || !externalInput) {
        return;
    }

    let debounceTimer;

    function getGrade(total) {
        if (total >= 90) return 'A+';
        if (total >= 80) return 'A';
        if (total >= 70) return 'B';
        if (total >= 60) return 'C';
        if (total >= 50) return 'D';

        return 'F';
    }

    function calculateResult() {
        if (!internalInput.value || !externalInput.value) {
            totalInput.value = '';
            gradeInput.value = '';
            saveButton.disabled = true;
            return;
        }

        const total =
            Number(internalInput.value) +
            Number(externalInput.value);

        totalInput.value = total;
        gradeInput.value = getGrade(total);

        saveButton.disabled = false;
    }

    function handleInput() {
        saveButton.disabled = true;

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(calculateResult, 500);
    }

    internalInput.addEventListener('input', handleInput);
    externalInput.addEventListener('input', handleInput);
}

document.addEventListener('DOMContentLoaded', initAddResult);