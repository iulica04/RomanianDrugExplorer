<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Validation Code Input</title>
<link rel="stylesheet" type="text/css" href="/RomanianDrugExplorer/public/styles/style_verifyCode.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <div class="main">
    <h3 class = "title">Verification Code</h3> 
    <p class = "description">Please enter the reset code you received via email in the fields below to proceed with the password reset process.</p>
    <div class = "code-container">
    <div class="code-input">
        <input type="text" maxlength="1" id="digit1" onkeyup="moveToNextOrPrev(this, 'digit2', 'digit1')">
        <input type="text" maxlength="1" id="digit2" onkeyup="moveToNextOrPrev(this, 'digit3', 'digit1')">
        <input type="text" maxlength="1" id="digit3" onkeyup="moveToNextOrPrev(this, 'digit4', 'digit2')">
        <input type="text" maxlength="1" id="digit4" onkeyup="moveToNextOrPrev(this, '', 'digit3')">
    </div>
</div>
    <button id = "verifyCodeButton">Verify Code</button>
    </div>

    <div id="snackbar"></div>
    
        <script src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
        <script src="/RomanianDrugExplorer/public/utils/codeContainer.js"></script>
        <script type="module" src="/RomanianDrugExplorer/public/utils/validateCode.js"></script>
</body>
</html>
