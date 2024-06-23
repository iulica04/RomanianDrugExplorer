<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_AddData.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <title>Upload Excel File</title>
</head>
<body>
    <div class="main">
        <h1 class="title">Upload Excel File</h1>
        <form id="uploadForm">
            <div class="selects">
                <div class="form-group">
                    <label for="yearSelect">Select Year:</label>
                    <select id="yearSelect" name="yearSelect">
                        <option value="" disabled selected>Choose a year...</option>
                        <option value="2020">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="typeSelect">Select Type:</label>
                    <select id="typeSelect" name="typeSelect">
                        <option value="" disabled selected>Choose a type...</option>
                        <option value="urgente-medicale">Urgente Medicale</option>
                        <option value="infractionalitati">Infractionalitati</option>
                        <option value="proiecte">Proiecte</option>
                        <option value="confiscari-dorguri">Confiscari Droguri</option>
                    </select>
                </div>
            </div>
            <input class="choose-file" type="file" id="fileToUpload" name="fileToUpload" accept=".xlsx">
            <label for="fileToUpload">Choose file</label>
            <p id="fileName" class="fileName"></p>
            <button type="submit">Upload</button>
        </form>
    </div>
    <div id="snackbar"></div>
    <script src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
    <script src="/RomanianDrugExplorer/public/utils/addDrugData.js"></script>
</body>
</html>