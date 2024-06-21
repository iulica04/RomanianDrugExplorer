function moveToNextOrPrev(currentInput, nextInputId, prevInputId) {
    var maxLength = parseInt(currentInput.getAttribute('maxlength'));
    var currentLength = currentInput.value.length;

    if (currentLength >= maxLength) {
        var nextInput = document.getElementById(nextInputId);
        if (nextInput) {
            nextInput.focus();
        }
    } else if (currentLength === 0) {
        var prevInput = document.getElementById(prevInputId);
        if (prevInput) {
            prevInput.focus();
        }
    }
}