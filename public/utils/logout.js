function logout() {

    // Trimite o cerere la server pentru a încheia sesiunea
    fetch('http://localhost:8080/RomanianDrugExplorer/users/logout', {
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