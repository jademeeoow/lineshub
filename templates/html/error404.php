<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="../../static/style/style.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
 

.error-container {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    display: flex;
    max-width: 600px;
    width: 100%;
    overflow: hidden;
    z-index: 1001;
}

.error-left {
    background: #FFCC00;
    color: black;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 50%;
}

.error-left img {
    width: 100px;
    margin-bottom: 20px;
}

.error-right {
    padding: 40px;
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.error-right h1 {
    font-size: 50px;
    margin: 0;
    color: #333;
}

.error-right p {
    margin: 20px 0;
    font-size: 18px;
    color: #555;
}

.back-button {
    padding: 10px 20px;
    background: #FFCC00;
    color: black;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
}

.back-button:hover {
    background: #E6B800;
}

.developer-note {
    margin-top: 20px;
    font-size: 12px;
    color: #888;
}

    </style>
</head>

<body>

    <div id="particles-js"></div>

    <div class="whole">
        <div class="error-container">
            <div class="error-left">
                <img src="../../static/images/logolines.jpg" alt="Logo">
                <h2>LINES PRINTING SERVICES</h2>
                <p>Oops! Page not found.</p>
            </div>
            <div class="error-right">
                <h1>404</h1>
                <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                <a href="index.php" class="back-button">Go to Homepage</a>
           
        </div>
    </div>

    <script src="../../static/script/particles.js"></script>
    
    <script src="../../static/script/app.js"></script>
   
</body>

</html>
