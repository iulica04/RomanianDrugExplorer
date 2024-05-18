document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createUserForm');

    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = {
                username: document.getElementById('username-for-sign-up').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password-for-sign-up').value,
                phonenumber: document.getElementById('phonenumber').value,
            };

            fetch('/users', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').innerText = data.message;
                console.log(data);
            })
            .catch(error => {
                document.getElementById('response').innerText = 'Error: ' + error;
            });
        });
    } else {
        console.error('Form with ID createUserForm not found.');
    }
});
