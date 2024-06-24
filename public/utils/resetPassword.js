import { APP_PORT } from './config.js';

$(document).ready(function() {
    $('#forgotPasswordForm').on('submit', function(event) {
        event.preventDefault();

        const userId = localStorage.getItem('userId');
        const password = $('#password').val();
        const confirmPassword = $('#confirm-password').val();

        if (password !== confirmPassword) {
            // Show error if passwords do not match
            showSnackbar('Passwords do not match.', 'error');
        }

        fetch(`http://localhost${APP_PORT}/RomanianDrugExplorer/users/` + userId + '/reset-password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify( {password}),
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body: data }) => {
            if (status === 200) {
                showSnackbar('Password reset successfully.', 'info');
                setTimeout(function() {
                    window.location.href = '/RomanianDrugExplorer/app/views/login.php';
                }, 2000);
                
            } else {
                showSnackbar(data.error, 'error');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
});