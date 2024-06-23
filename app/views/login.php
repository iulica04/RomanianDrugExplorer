<?php session_start(); ?>
<html>
<head>
    <title>Login</title>
    <link rel = "stylesheet" href="/RomanianDrugExplorer/public/styles/style_Login.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="UTF-8">
</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk">

        <div class="login">
            <form id="loginForm" method="post">
                <label class="title" for="chk" aria-hidden="true">Login</label>
                <div class="input-group">
                    <input type="text" name="username" id="username" class="input" required>
                    <label class="label" for="username">Username</label>
                    <span class="error" id="username-error"></span>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="input" required>
                    <label class="label" for="password">Password</label>
                    <span class="error" id="password-error"></span>
                </div>
                <div class="forgot-password1">
                    <p> Forgot password? </p>
                    <a href="/RomanianDrugExplorer/app/views/forgotPassword.php">Reset it</a>
                </div>
                <button type="submit">Login</button>
                <div class="have-account">
                    <p> Do you already have an account? </p>
                    <a href="/RomanianDrugExplorer/app/views/register.php">Sign Up</a>
                </div>
                <div class="forgot-password">
                    <p> Forgot password? </p>
                    <a href="/RomanianDrugExplorer/app/views/forgotPassword.php">Reset it</a>
                </div>
            </form>
        </div>

        <div class="signup">
            <form id="createUserForm" method="post">
                <label class="title-sign-up" for="chk" aria-hidden="true">Sign up</label>
                <div class="input-group">
                    <input type="text" name="username" id="username-for-sign-up" class="input" required>
                    <label class="label-sg" for="username-for-sign-up">Username</label>
                    <span class="error" id="username-for-sign-up-error"></span>
                </div>
                <div class="input-group">
                    <input type="text" name="email"  id="email" class="input" required>
                    <label class="label-sg" >Email</label>
                    <span class="error" id="email-error"></span>
                </div>
                <div class="input-group">
                    <input type="text" name="phone_number" id="phonenumber" class="input" required>
                    <label class="label-sg" for="phonenumber">Phone number</label>
                    <span class="error" id="phonenumber-error"></span>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password-for-sign-up" class="input" required>
                    <label class="label-sg" for="password-for-sign-up">Password</label>
                    <span class="error" id="password-for-sign-up-error"></span>
                </div>
                <button type="submit">Sign up</button>
            </form>
        </div>

        <div id="snackbar"></div>


<script src="/RomanianDrugExplorer/public/utils/checkValidityRegister.js"></script>
<script src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
<script type="module" src="/RomanianDrugExplorer/public/utils/register.js"></script>
<script type="module" src="/RomanianDrugExplorer/public/utils/login.js"></script>

    </div>
    
</body>
</html>
