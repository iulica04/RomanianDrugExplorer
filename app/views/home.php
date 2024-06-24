<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_Home.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_Navbar.css">
    <script src="/RomanianDrugExplorer/public/utils/getCookie.js"></script>
</head>
<body>
    <header>
        <?php include 'elements/navbar.php'; ?>
    </header>
    <div class="body_for_home">
        <h1>Exploring the World of Drugs Together</h1><br><br>
        <p>At Romanian Drug Explorer, we're here for you. Our mission is to provide support, resources, and information about drugs to help individuals live healthier lives. We believe in the power of community and are committed to helping those who need it most.</p>
        <div class="buttons">
            <a href="/RomanianDrugExplorer/app/views/Statistics.php" class="button">Learn more</a>
            <?php if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) { ?>
                <p>or</p>
                <a href="/RomanianDrugExplorer/app/views/register.php" class="button">Sign up</a>
            <?php } ?>
        </div>
        <div id="about" class="about_us">
            <div class="container_1">
                <h2>About Us</h2>
            </div>
            <div class="container_2">
                <div class="text-container">
                    <h3>Our Purpose</h3>
                    <p class="text">At Romanian Drug Explorer, we care about improving people's lives. We understand that drug addiction can be a huge challenge and we want to help put an end to it. We offer a variety of services designed to help you overcome addiction and live your best life. Whether you need support, counseling, or just someone to talk to, our experienced team is here to help.</p>
                </div>
            </div>
            <div class="container_3">
                <div class="text-container">
                    <h3>Our Mission</h3>
                    <p class="text">At Romanian Drug Explorer, our mission is to help those struggling with drug addiction find the support they need to overcome their challenges. We understand the difficulties that come with addiction, and we are here to provide you with guidance and resources to make the journey to recovery as smooth as possible. Our team of experts is dedicated to helping you every step of the way, and we are committed to providing you with the support and treatment you need to get back on track.</p>
                </div>
            </div>
            <div class="container_4">
                <div class="text-container">
                    <h3>Our Story</h3>
                    <p class="text">Drug prevention is at the forefront of what we do at Romanian Drug Explorer. Our journey began with a desire to improve the drug situation in Romania, and we have succeeded in making a difference through our extensive experience. Our prevention services help individuals recognize the risks of drug abuse and provide the necessary steps to lead a healthy lifestyle. We’re here for you every step of the way.</p>
                </div>
            </div>
        </div>
        <div id="snackbar"></div>
    </div>
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Romanian Drug Explorer. All Rights Reserved.</p>
            <p>
                <a href="/RomanianDrugExplorer/app/views/PrivacyPolicy.php">Privacy Policy</a> |
                <a href="/RomanianDrugExplorer/app/views/TermsOfService.php">Terms of Service</a> |
                <a href="/RomanianDrugExplorer/app/views/ContactUs.php">Contact Us</a>
            </p>
        </div>
    </footer>
    <script src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
</body>
</html>
