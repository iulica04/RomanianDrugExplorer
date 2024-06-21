function showSnackbar(message, messageType) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = message;
    snackbar.className = "show";

    // Add the message type class to the Snackbar
    if (messageType === 'error') {
        snackbar.className += " error";
    } else if (messageType === 'info') {
        snackbar.className += " info";
    }

    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 4000);
}

window.clearFormInputs = function(formId) {
    var form = document.getElementById(formId);

    // Get all input elements within the form
    var inputs = form.getElementsByTagName('input');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = '';
    }
}