<?php session_start(); ?>
<html>
<head>
    <title>Login</title>
    <link rel = "stylesheet" href="/RomanianDrugExplorer/public/styles/style_Login.css">
    <meta charset="UTF-8">
</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk">

        <div class="login">
            <form action="logged.php" method="post">
                <label class="title" for="chk" aria-hidden="true">Login</label>
                <div class="input-group">
                    <input type="text" name="username" id="username" class="input" required>
                    <label class="label" for="username">Username</label>
                    <p class="error" id="username-error"></p>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="input" required>
                    <label class="label" for="password">Password</label>
                    <p class="error" id="password-error"></p>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>

        <div class="signup">
            <form action="sing_up.php" method="post">
                <label class="title-sign-up" for="chk" aria-hidden="true">Sign up</label>
                <div class="input-group">
                    <input type="text" name="username" id="username-for-sign-up" class="input" required>
                    <label class="label-sg" for="username-for-sign-up">Username</label>
                    <p class="error" id="username-for-sign-up-error"></p>
                </div>
                <div class="input-group">
                    <input type="text" name="email"  id="email" class="input" required>
                    <label class="label-sg" >Email</label>
                    <p class="error" id="email-error"></p>
                </div>
                <div class="input-group">
                    <input type="text" name="phone_number" id="phonenumber" class="input" required>
                    <label class="label-sg" for="phonenumber">Phone number</label>
                    <p class="error" id="phonenumber-error"></p>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password-for-sign-up" class="input" required>
                    <label class="label-sg" for="password-for-sign-up">Password</label>
                    <p class="error" id="password-for-sign-up-error"></p>
                </div>
                <button type="submit">Sign up</button>
            </form>
        </div>
    </div>
    <script src="../utils/checkValidity.js"></script>
</body>
</html>
