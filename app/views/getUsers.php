<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel = "stylesheet" href="/RomanianDrugExplorer/public/styles/style_GetUsers.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="main">
    <h1 class="title">Users</h1>
    <table id="usersTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    </div>

    <div id="snackbar"></div>

    <script src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
    <script src="/RomanianDrugExplorer/public/utils/editUsers.js"></script>
</body>
</html>