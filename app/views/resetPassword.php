<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="/RomanianDrugExplorer/public/styles/style_passwords.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="main">

        <input type="checkbox" id="chk">

        <div class = "forgotPassword">
            <form id="forgotPasswordForm" action="send_reset_email.php" method="post">
                <label class="title" for="chk" aria-hidden="true">Reset Password</label>
                <div class="input-group">
                    <label class="label" for="password">Enter your new password: </label>
                    <input type="password" name="password" id="password" class="input" required>
                    <span class="error" id="password-error"></span>
                </div>

                <div class="input-group">
                    <label class="label" for="confirm-password">Confirm password: </label>
                    <input type="password" name="confirm-password" id="confirm-password" class="input" required>
                    <span class="error" id="confirm-password-error"></span>
                </div>

                  
                <button id = "resetPasswordButton">Reset Password</button>


            </form>
        </div>

        <div id="snackbar"></div>

        <script src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
        <script src="/RomanianDrugExplorer/public/utils/checkPasswordsMatch.js"></script>
        <script src="/RomanianDrugExplorer/public/utils/resetPassword.js"></script>
    </div>
</body>
</html>