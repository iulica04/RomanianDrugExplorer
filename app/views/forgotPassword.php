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
        <div class="forgotPassword">
            <form id="forgotPasswordForm" action="send_reset_email.php" method="post">
                <label class="title" for="chk" aria-hidden="true">Forgot Password</label>
                <div class="input-group">
                    <label class="label" for="username-for-sign-up">Enter your username: </label>
                    <input type="text" name="username" id="username" class="input" required>
                </div>   
                <div class="input-group">
                    <label class="label" for="email">Email</label>
                    <input type="text" name="email" id="email" class="input" required>
                </div>
                <button id="resetPasswordButton">Send Reset Code</button>
            </form>
        </div>
        <div id="snackbar"></div>
        <script src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
        <script src="/RomanianDrugExplorer/public/utils/forgotPassword.js"></script>
    </div>
</body>
</html>
