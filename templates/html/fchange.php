<?php

include_once "../../php/fchange.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../../static/style/forgotpass.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>


<body>
    <div id="particles-js"></div>
    <div class="whole">
        <div class="con">
        <?php if ($message): ?>
                <div class="tit">
                    <p>Password  Changed!</p>
                </div>
                <div class="desjd">
                    <p><?php echo $message; ?></p>
                </div>
                <div class="gagokajd">
                    <button onclick="redirect('index.php')">Back to Login</button>
                </div>

                <?php else: ?>
            <form method="POST" action="fchange.php">
                <div class="tit">
                    <p>Change Password</p>
                </div>
                <div class="des">
                    <p>Update your new password</p>
                </div>


                <?php if (!empty($message2)) : ?>
                    <div class="message-error">
                        <p><?php echo $message2; ?></p>
                    </div>
                <?php endif; ?>
                <div class="toclose">
                    <div class="marj">
                        <div class="par">
                            <div class="label">
                                <label for="new_password">New Password</label>
                            </div>
                            <div class="inp">
                                <input type="password" id="new_password" name="new_password" required>
                            </div>
                        </div>
                        <div class="par">
                            <div class="label">
                                <label for="confirm_password">Confirm New Password</label>
                            </div>
                            <div class="inp">
                                <input type="password" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES); ?>">
                        <div class="btn">
                            <button type="submit">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="back">
                <p style="margin-bottom: 15px;" onclick="redirect('index.php')">Back to Login</p>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <script src="../../static/script/script.js"></script>
    <script src="../../static/script/app.js"></script>
    <script src="../../static/script/particles.js"></script>
</body>

</html>