document.getElementById('verifyCodeButton').addEventListener('click', function(event) {
    event.preventDefault(); // prevent the form from submitting normally

    var digit1 = document.getElementById('digit1').value;
    var digit2 = document.getElementById('digit2').value;
    var digit3 = document.getElementById('digit3').value;
    var digit4 = document.getElementById('digit4').value;

    var code = digit1 + digit2 + digit3 + digit4;

    if(code.length !== 4) {
        showSnackbar("Code must be 4 digits long.", 'error');
        return;
    }

    fetch('http://localhost/RomanianDrugExplorer/users/verify-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ code }),
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body: data }) => {
        if (status === 200) {
            showSnackbar(data.message, 'info');
            // Așteaptă 3 secunde apoi redirecționează către pagina de login
            
        } else {
            showSnackbar(data.message, 'error');
        }
    })
    .catch((error) => {
      console.error('Error:', error);
    });
});