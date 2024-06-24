<footer>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <div class="footer-content">
           <div class="group">
                <div class="logo">
                    <a>RoDX</a>
                </div>
                <p class = "little-text"> we are here to inform you</p>
            </div>
            <div class="group">
               <h3>Information</h3>
                <ul>
                    <li><a href="#about">About</a></li>
                    <li><a href="/RomanianDrugExplorer/app/views/HelpAndAdvice.php">Help & Advice</a></li>
                    <li><a href="/RomanianDrugExplorer/app/views/Contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="group">
               <h3>Our Service</h3>
                <ul>
                    <li><a href="/RomanianDrugExplorer/app/views/Statistics.php">Statistics</a></li>
                    <?php if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) { ?>
                        <li><a  onclick=" showSnackbar('Please log in to view this statistics.','error')">Learn More</a></li>
                    <?php } else { ?>
                    <li><a href="/RomanianDrugExplorer/app/views/LearnMore.php">Learn More</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="group">
               <h3>Our Team</h3>
                <ul>
                    <li><a href="https://www.instagram.com/vreme_iulia/" target="_blank">
                    <i class="fab fa-instagram"></i> Iulia</a></li>
                   
                   <li> <a href="https://www.instagram.com/dianaandreea5.p/" target="_blank">
                    <i class="fab fa-instagram"></i> Diana</a></li>
                </ul>
            </div>
            <div class="group">
               <h3>Contact us</h3>
                <ul>
                    <li><a>romaniandrugexplorer@outlook.com</a></li>
                    <li><a>0800 080 999</a></li>
                </ul>
            </div>
        </div>
        <p>&copy; 2024 Romanian Drug Explorer. All Rights Reserved.</p>
    </footer>