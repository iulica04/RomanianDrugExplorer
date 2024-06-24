import { APP_PORT } from './config.js';


$('#loginForm').on('submit', function(e) {
    e.preventDefault();

    const userData = {
        username: $('#username').val(),
        password: $('#password').val()
    };


    fetch(`http://localhost${APP_PORT}/RomanianDrugExplorer/users/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(userData),
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body: data }) => {
        if (status === 200) {
            showSnackbar(data.message, 'info');
            // Wait for 3 seconds then redirect to home page
            setTimeout(function() {
                window.location.href = '/RomanianDrugExplorer/home';
            }, 2000);
        } else {
            showSnackbar(data.message, 'error');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});