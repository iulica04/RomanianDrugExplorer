import { APP_PORT } from './config.js';

$('#forgotPasswordForm').on('submit', function(event) {
    event.preventDefault();

    const username = $('#username').val();
    const email = $('#email').val();

    fetch(`http://localhost${APP_PORT}/RomanianDrugExplorer/users/forgot-password`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, email }),
    })
    .then(response =>console.log(response.text()))
    .then(({ status, body: data }) => {
        if (status === 200) {
            showSnackbar("Password reset code sent. Check inbox and spam folder.", 'info');
           
            setTimeout(function() {
                window.location.href = '/RomanianDrugExplorer/app/views/verifyCode.php';
            }, 2000);
        } else {
            showSnackbar(data.message, 'error');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});