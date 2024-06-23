<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Help and Advice</title>
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_Contact.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_Navbar.css">
</head>
<body>
<header>
        <h1 class="title">Romanian Drug Explorer</h1>
        <?php include 'elements/navbar.php'; ?>
    </header>
    <div class="main">
        <div class="container_1">
            <div class="card">
                <h1>Need some friendly, confidential advice?</h1>
                <p>PhoneCall <a href="tel:0800 080 999">0800 080 999</a><br>
                It's availble 24 hours a day, 7 days a week.</p>
                <h2>Call service details</h2>
                <p>ChatText  7484 <br>
                Write a question through SMS and you will get a respond as fast as posible.</p>
                <h2>Text service details</h2>
                <p>EmailSend an email<br>
                Send an email at info@droguri-help-line.ro.</p>
                <h2>Email service details</h2>
                <p>Live Chat - offline<br>
                Live chat (offline)<br>
                Our live chat service operates from 10am - 6pm, 5 days a week.</p>
                <h3>Telephone</h3>
                <p>Call 0800 080 999 when in need.</p>
            </div>
        </div>
        <div class="container_2">
            <div class="card">
                <h2>Concerned about...</h2>
                <ul>
                    <li><a href="HelpAndAdvice.html">A friend</a></li>
                    <li><a href="HelpAndAdvice.html">A child</a></li>
                    <li><a href="HelpAndAdvice.html">Pressure to take drugs</a></li>
                </ul>
            </div>
            <div class="card">
                <h2>What to do in an emergency:</h2>
                <p class="emergency">If you or someone else needs urgent help after taking drugs or drinking, call 112 for an ambulance. Tell the crew everything you know. It could save their life.</p>
            </div>
        </div>
    </div>
    <script>
        function toggleMenu() {
            var navList = document.getElementById('navList');
            navList.classList.toggle('active');
        }
    </script>  
</body>
</html>