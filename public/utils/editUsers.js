$(document).ready(function() {
    fetch('http://localhost/RomanianDrugExplorer/users')
    .then(response => response.json())
    .then(users => {
        // Loop through the users and add a row for each one
        users.forEach(user => {
            $('#usersTable tbody').append(
                `<tr>
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.phonenumber}</td>
                    <td><button class="deleteButton">X</button></td>
                </tr>`
            );
        });

        // Add click event listener to delete buttons
        $('.deleteButton').click(function() {
            if (confirm('Are you sure you want to delete this user?')) {
                const id = $(this).parent().parent().children().first().text();
                fetch(`http://localhost/RomanianDrugExplorer/users/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body: data }) => {
                    if (status === 200) {
                        showSnackbar(data.message, 'info');
                        $(this).parent().parent().remove();
                    } else {
                        showSnackbar(data.error, 'error');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    showSnackbar('An error occurred while deleting the user', 'error');
                });
            }
        });
    })
});