function clearFormInputs(formId) {
    var form = document.getElementById(formId);

    // Get all input elements within the form
    var inputs = form.getElementsByTagName('input');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = '';
    }
}