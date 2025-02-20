<?php

include_once "../../php/forgotpassword.php"



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../../static/style/forgotpass.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>
<body>
    <div id="particles-js"></div>
    <div class="whole">
        <div class="con">
            <div class="tit">
                <p>Forgot Password</p>
            </div>
            <div class="des">
                <p>Please enter your email address. We'll send you a reset code.</p>
            </div>
            <div class="toclose">
                <?php if (isset($_SESSION['message']) && $_SESSION['message'] != ''): ?>
                    <div class="message">
                        <p><?php echo $_SESSION['message']; ?></p>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <form action="forgotpass.php" method="post">
                    <div class="marj">
                        <div class="par">
                            <div class="label">
                                <label for="email">Email</label>
                            </div>
                            <div class="inp">
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="btn">
                            <button type="submit">SUBMIT</button>
                        </div>
                        <div class="back">
                            <p onclick="redirect('index.php')">Back to Login</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../static/script/script.js"></script>
    <script src="../../static/script/app.js"></script>
    <script src="../../static/script/particles.js"></script>

   
</body>
</html>
