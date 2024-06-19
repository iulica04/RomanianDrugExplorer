document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const submitBtn = document.getElementById('loginButton');

    const validationRules = {
        "username": {
            pattern: /^(?=.*[A-Za-z]{3,})[A-Za-z0-9!@#$%^&*]{3,16}$/,
            errorMessage: "Username should be 3-16 characters and shouldn't include any special characters!"
        },
        "password": {
            pattern: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/,
            errorMessage: "Password should be at least 8 characters and include at least one letter and one number!"
        }
    };

    const inputs = [usernameInput, passwordInput];

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

        submitBtn.disabled = !allValid;
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
