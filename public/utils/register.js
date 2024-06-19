$(document).ready(function() {
    $('#createUserForm').on('submit', function(e) {
        e.preventDefault();

        const userData = {
            username: $('#username-for-sign-up').val(),
            email: $('#email').val(),
            phonenumber: $('#phonenumber').val(),
            password: $('#password-for-sign-up').val(),
            role: 'user'
        };

        console.log(userData);

        fetch(`http://localhost/RomanianDrugExplorer/users`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
        })
        .then(response => response.json())
        .then(data => {
            // Check the message received from the server
            if (data.message === 'User created successfully') {
                // If the user was created successfully, show a green Snackbar
                showSnackbar(data.message, 'info');
            } else {
                // If there was an error, show a red Snackbar
                showSnackbar(data.message, 'error');
            }
        })
        .catch((error) => {
          console.error('Error:', error);
          // If there was an error with the fetch operation, show a red Snackbar
          showSnackbar('An error occurred while creating the user', 'error');
        });
    });
});