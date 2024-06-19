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

    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
}