<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            background-image: radial-gradient(circle at 100% 100%, rgba(56, 87, 30, 0.82) 0%, rgba(56, 87, 30, 0) 40%),
                            radial-gradient(circle at 6.504% 88.037%, rgba(187, 201, 170, 0.99) 0%, rgba(187, 201, 170, 0) 50%),
                            radial-gradient(circle at 6.165% 12.617%, #87986A 0%, rgba(135, 152, 106, 0) 83%),
                            radial-gradient(circle at 93.687% 11.426%, #E9F5DB 0%, rgba(233, 245, 219, 0) 70%),
                            radial-gradient(circle at 48.901% 49.521%, #FFFFFF 0%, rgba(255, 255, 255, 0) 100%);
            padding: 0;
            margin: 0;
            font-family: Georgia, serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            margin: 10%;
            text-align: center;
            width: auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #c6d9a5;
            border-radius: 15px;
        }
        .container h1 {
            font-size: 7rem;
            margin-bottom: 10px;
            color: #243024;
        }
        .container p {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: #becbaf;
            background-color: #243024;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .container a:hover {
            background-color: #8d9188;
            color: #3A4D39;
            border: 1px solid #87986A;
        }   
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Oops! Page not found.</p>
        <p>The page you are looking for might have been removed or is temporarily unavailable.</p>
        <a href="/">Go to Homepage</a>
    </div>
</body>
</html>
