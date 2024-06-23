<nav class="items">
    <div class="logo">
        <a>RoDX</a>
    </div>           
    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="menu-icon">&#9776;</label>
    <div class="list">
    <?php
        if ($_SERVER['REQUEST_URI'] == "/RomanianDrugExplorer/home") { ?>
        <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true)
    { ?>
        <a href="/RomanianDrugExplorer/app/views/addData.php">Add Data</a>
        <a href="/RomanianDrugExplorer/app/views/getUsers.php">Users</a>
      <?php }  else { ?>
        <a href="#about">About</a>
        <a href="/RomanianDrugExplorer/app/views/HelpAndAdvice.php">Help & Advice</a>
        <a href="/RomanianDrugExplorer/app/views/Contact.php"> Contact</a>
        <?php } ?>
    <?php 
    } else { ?>
        <a href="/RomanianDrugExplorer/home">Home</a>
        <?php if ($_SERVER['REQUEST_URI'] == "/RomanianDrugExplorer/app/views/LearnMore.php") { ?>
        <a href="/RomanianDrugExplorer/app/views/Statistics.php">Statistics</a>
        <?php } ?>
        <a href="/RomanianDrugExplorer/app/views/HelpAndAdvice.php">Help & Advice</a>
        <a href="/RomanianDrugExplorer/app/views/Contact.php"> Contact</a>
    <?php } ?>
      <div class="for_login">
      <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <script src="/RomanianDrugExplorer/public/utils/verifyCookie.js"></script>
            <a>Logout</a>
            <script type="module" src="/RomanianDrugExplorer/public/utils/logout.js"></script>
      <?php else: ?>
             <a href="/RomanianDrugExplorer/app/views/login.php">Login</a>
      <?php endif; ?>
      </div> 
    </div>
</nav>


