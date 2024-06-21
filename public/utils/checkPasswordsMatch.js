document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('forgotPasswordForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const resetPasswordButton = document.getElementById('resetPasswordButton');

    const validationRules = {
        "password": {
            pattern: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/,
            errorMessage: "Password should be at least 8 characters and include at least one letter and one number!"
        },
        "confirm-password": {
            pattern: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/,
            errorMessage: "Password should be at least 8 characters and include at least one letter and one number!"
        }
    };

    const inputs = [passwordInput, confirmPasswordInput];

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            validateForm();
        });
    });

    form.addEventListener('submit', (event) => {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    function validateForm() {
        let allValid = true;

        inputs.forEach(input => {
            const { pattern, errorMessage } = validationRules[input.id];
            if (!pattern.test(input.value)) {
                showError(input.id + '-error', errorMessage);
                allValid = false;
            } else {
                hideError(input.id + '-error');
            }
        });

        // Check if passwords match
        if (passwordInput.value !== confirmPasswordInput.value) {
            showError('confirm-password-error', 'Passwords do not match!');
            allValid = false;
        }

        resetPasswordButton.disabled = !allValid;
        return allValid;
    }

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function hideError(elementId) {
        const errorElement = document.getElementById(elementId);
        errorElement.style.display = 'none';
    }
});