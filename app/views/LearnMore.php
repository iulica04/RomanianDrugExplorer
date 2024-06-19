<!DOCTYPE html>
<html lang="en">
<head>
    <title> Learn More</title>
    <link rel = "stylesheet" href="/RomanianDrugExplorer/public/styles/style_LearnMore.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <meta charset="UTF-8">
</head>
<body>
  <header>
    <h1 class="title">Romanian Drug Explorer</h1>
    <nav class="items">
        <div class="logo">
            <a href="#">RoDX</a>
        </div>          
        <input type="checkbox" id="menu-toggle">
      <label for="menu-toggle" class="menu-icon">&#9776;</label>     
        <div class="list">
          <a href="/RomanianDrugExplorer/app/views/LearnMore.php">Home</a>
          <a href="index.html#about">About</a>
          <a href="/RomanianDrugExplorer/app/views/Contact.php">Contact</a>
          <a href="/RomanianDrugExplorer/app/views/HelpAndAdvice.php">Help & Advice</a>
          <div class="for_login">
            <a href="/RomanianDrugExplorer/app/views/login.php">Login</a>
          </div> 
        </div>
    </nav>
</header>

    <div class="main">
          
            <h1>Statistics of the drug abuse :</h1>
            <div class="input-field col s12">
                <select onchange="redirect()">
                    <option value="" disabled selected>Choose a year...</option>
                    <option value="1">2023</option>
                    <option value="statistics_2022.html">2022</option>
                    <option value="statistics_2021.html">2021</option>
                    <option value="statistics_2020.html">2020</option>
                </select>
          </div>
          <div><h1 class="year">2023</h1></div> 
         
        <div class="container_1">
            <div class="card">
             
                <div class="image-column">
                  <div class ="card_1">
                    <div class="title_map"><h1>Drug Abuse Map:</h1></div>
                    <img src="C:\Users\Cpirlac\Desktop\TEH web\Harta.jpg" alt="Drug Abuse Map">
                  </div>
                </div>
               
               <div class="button-column">
                <div class ="card_1">
                  <button class="button button1">0%</button>
                  <button class="button button2">0-5%</button>
                  <button class="button button3">5-10%</button>
                  <button class="button button4">10-20%</button>
                  <button class="button button5">20-30%</button>
                  <button class="button button6">30-50%</button>
                  <button class="button button7">50-100%</button>
               </div>
               </div>
            </div>
        </div>
        
        <div class="container_2">
            <div class="card">
            <ul> 
              <h1>Resources:</h1>
                <li><i class="large material-icons">library_books</i>
                    <a href="Admiterea_la_tratament.xlsx">Admiterea la tratament ca urmare a consumului de stupefiante</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                    </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Urgente_medicale.xlsx">Urgențele medicale datorate consumului de droguri</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Bolile_infectioase.xlsx">Bolile infecțioase asociate consumului de droguri</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Confiscari_droguri.xlsx">Situația confiscărilor de droguri</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Infractiuni_regim_droguri.xlsx">Infracționalitatea la regimul drogurilor</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Proiecte_campanii_prevenire.xlsx">Proiectele și campaniile naționale de prevenire</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Precursori.xlsx">Precursorii (substanțe clasificate și operațiunile autorizate)</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
            </ul>
            
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