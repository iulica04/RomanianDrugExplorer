function toggleMenu() {
    var navList = document.getElementById('navList');
    navList.classList.toggle('active');
}

document.querySelector('.for_login a').addEventListener('click', function(event) {
    if (event.target.textContent === 'Logout') {
        event.preventDefault();
        logout();
    }
}); // This closing brace was missing

function logout() {
    // Trimite o cerere la server pentru a încheia sesiunea
    fetch('http://localhost/RomanianDrugExplorer/users/logout', {
        method: 'POST',
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body: data }) => {
        if (status === 200) {
            showSnackbar(data.message, 'info');
            // Așteaptă 3 secunde apoi redirecționează către pagina de login
            setTimeout(function() {
                window.location.href = '/RomanianDrugExplorer/home';
            }, 2000);
        } else {
            showSnackbar(data.message, 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}