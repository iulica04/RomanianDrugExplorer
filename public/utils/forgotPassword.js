$('#forgotPasswordForm').on('submit', function(event) {
    event.preventDefault();

    const username = $('#username').val();
    const email = $('#email').val();

    fetch('http://localhost/RomanianDrugExplorer/users/forgot-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, email }),
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body: data }) => {
        if (status === 200) {
            showSnackbar("Password reset code sent. Check inbox and spam folder.", 'info');
           
            setTimeout(function() {
                window.location.href = '/RomanianDrugExplorer/verifyCode';
            }, 2000);
        } else {
            showSnackbar(data.message, 'error');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});