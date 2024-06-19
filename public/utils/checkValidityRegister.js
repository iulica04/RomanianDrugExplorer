document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('createUserForm');
    const usernameInput = document.getElementById('username-for-sign-up');
    const emailInput = document.getElementById('email');
    const phoneNumberInput = document.getElementById('phonenumber');
    const passwordInput = document.getElementById('password-for-sign-up');
    const submitBtn = document.getElementById('signUpButton');

    const validationRules = {
        "username-for-sign-up": {
            pattern: /^(?=.*[A-Za-z]{3,})[A-Za-z0-9!@#$%^&*]{3,16}$/,
            errorMessage: "Username should be 3-16 characters and shouldn't include any special characters!"
        },
        "email": {
            pattern: /.+@gmail\.com|.+@email\.com|.+@yahoo\.com/,
            errorMessage: "It should be a valid email address!"
        },
        "password-for-sign-up": {
            pattern: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/,
            errorMessage: "Password should be at least 8 characters and include at least one letter and one number!"
        },
        "phonenumber": {
            pattern: /^\d{10}$/,
            errorMessage: "Phone number should be 10 digits!"
        }
    };

    const inputs = [usernameInput, emailInput, phoneNumberInput, passwordInput];

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
