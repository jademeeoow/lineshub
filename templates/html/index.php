<?php
include_once "../../php/login.php";
?>

<!DOCTYPE html>
<html lang="en">
                                            
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LINES HUB</title>
    <link rel="stylesheet" href="../../static/style/style.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>

<body>

    <div id="particles-js"></div>

    <div class="whole">
        <div class="form">
            <div class="sides first">
                <div class="tag tag1">
                    <h1>Lines Hub Admin User</h1>
                </div>
                <div class="logo">
                    <img src="../../static/images/logolines.jpg" alt="">
                </div>
                <div class="term tonone">
                    <p onclick="redirect('aboutus.html')">Redeveloped by <a>CR4MATIX - 1 </a></p>
                </div>
            </div>

            <form method="POST" action="index.php" id="loginForm">
                <div class="sides second" id="animateSecond">
                    <div class="marj">
                        <div class="tag">
                            <h1 class="tonone">LOGIN</h1>
                        </div>
                        <div class="coninp">
                            <?php if (isset($error)): ?>
                                <div class="error">
                                    <p><?php echo $error; ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="par">
                                <div class="label">
                                    <label for="email">Username or Email</label>
                                </div>
                                <div class="inp">
                                    <input type="text" id="email" name="login" required spellcheck="false" value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="par">
                                <div class="label">
                                    <label for="password">Password</label>
                                </div>
                                <div class="inp">
                                    <input type="password" id="password" name="password" required>

                                    <input type="hidden" id="encryptedPassword" name="encryptedPassword">
                                    <input type="hidden" id="iv" name="iv">
                                </div>
                            </div>
                            <div class="show">
                                <div class="inpcheck">
                                    <input type="checkbox" id="show">
                                </div>
                                <div class="labelcheck">
                                    <label for="show">Show Password</label>
                                </div>
                            </div>
                            <div class="btn">
                                <button id="submit">SUBMIT</button>
                            </div>

                            <div class="forgot">
                                <p onclick="redirect('forgotpass.php')">Forgot Password?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="term termres">
            <p onclick="redirect('aboutus.html')">Redeveloped by <a>CR4MATIX</a></p>
        </div>
    </div>

    <script src="../../static/script/script.js"></script>
    <script src="../../static/script/app.js"></script>
    <script src="../../static/script/particles.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const savedEmail = localStorage.getItem('savedEmail');
            if (savedEmail) {
                document.getElementById('email').value = savedEmail;
            }

            document.getElementById('loginForm').addEventListener('submit', function(event) {
                const passwordInput = document.getElementById('password');
                const emailInput = document.getElementById('email');
                const encryptedPasswordField = document.getElementById('encryptedPassword');
                const ivField = document.getElementById('iv');
                const iv = CryptoJS.lib.WordArray.random(16);
                const key = CryptoJS.enc.Utf8.parse('1234567890123456');

                const encryptedPassword = CryptoJS.AES.encrypt(CryptoJS.enc.Utf8.parse(passwordInput.value), key, {
                    keySize: 128 / 8,
                    iv: iv,
                    mode: CryptoJS.mode.CBC,
                    padding: CryptoJS.pad.Pkcs7
                }).toString();

                encryptedPasswordField.value = encryptedPassword;
                ivField.value = iv.toString(CryptoJS.enc.Base64);

                passwordInput.value = '';

                localStorage.setItem('savedEmail', emailInput.value);


                event.target.submit();
            });
        });
    </script>

</body>

</html>