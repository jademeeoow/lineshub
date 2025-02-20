<?php
include_once "../../php/authentication.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link rel="stylesheet" href="../../static/style/authentication.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>


<body>
    <div id="particles-js"></div>



    <div class="whole">


        <div class="con">
            <div class="tit">
                <p>Please Enter The Code</p>
            </div>
            <div class="des">
                <p>Check the code that was sent to your email</p>
            </div>
            <?php if (!empty($message)) : ?>
                <div class="message-success">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($message2)) : ?>
                <div class="message-error">
                    <p><?php echo $message2; ?></p>
                </div>
            <?php endif; ?>
            <form id="authForm" action="authentication.php" method="GET">
                <div class="inp">
                    <input type="hidden" name="code" id="codeInput" maxlength="6" pattern="[0-9]{6}" required>
                    <div class="par">
                        <input type="number" max="9" class="singleDigitInput" required>
                    </div>
                    <div class="par">
                        <input type="number" max="9" class="singleDigitInput" required>
                    </div>
                    <div class="par">
                        <input type="number" max="9" class="singleDigitInput" required>
                    </div>
                    <div class="par">
                        <input type="number" max="9" class="singleDigitInput" required>
                    </div>
                    <div class="par">
                        <input type="number" max="9" class="singleDigitInput" required>
                    </div>
                    <div class="par">
                        <input type="number" max="9" class="singleDigitInput" required>
                    </div>
                </div>
                <div class="line">
                    <div class="under"></div>
                    <div class="under"></div>
                    <div class="under"></div>
                    <div class="under"></div>
                    <div class="under"></div>
                    <div class="under"></div>
                </div>
                <div class="btn">
                    <button type="submit">SUBMIT</button>
                </div>
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? $_GET['email'] ?? '', ENT_QUOTES); ?>">
            </form>
            <div class="resend">
                <form action="authentication.php" method="POST">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? $_GET['email'] ?? '', ENT_QUOTES); ?>">
                    <button type="submit">Resend Code</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../../static/script/app.js"></script>
    <script src="../../static/script/particles.js"></script>
    <script>
       const singleDigitInputs = document.querySelectorAll('.singleDigitInput');
const authForm = document.getElementById('authForm');

function updateCodeInput() {
    let code = '';
    singleDigitInputs.forEach(input => {
        code += input.value;
    });
    return code;
}

authForm.addEventListener('submit', function(event) {
    const code = updateCodeInput();
    if (code.length !== 6) {
        event.preventDefault();
        alert('Please enter a 6-digit code.');
    } else {
        document.getElementById('codeInput').value = code;
    }
});

singleDigitInputs.forEach((input, index) => {
   
    input.maxLength = 1;

    
    input.addEventListener('input', function() {
        if (this.value.length === 1 && index < singleDigitInputs.length - 1) {
            singleDigitInputs[index + 1].focus();
        } else if (this.value.length > 1) {
           
            this.value = this.value[0];
        }
    });

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Backspace' && this.value.length === 0 && index > 0) {
            singleDigitInputs[index - 1].focus();
        }
    });


    input.addEventListener('paste', function(event) {
        event.preventDefault();
        const pasteData = event.clipboardData.getData('text/plain');
        const numbersOnly = pasteData.replace(/\D/g, '');
        if (numbersOnly.length <= 6) {
            let startIndex = 0;
            singleDigitInputs.forEach((input) => {
                if (numbersOnly[startIndex]) {
                    input.value = numbersOnly[startIndex++];
                } else {
                    input.value = '';
                }
            });
            updateCodeInput();
        } else {
            alert('You can only paste up to 6 digits.');
        }
    });
});

    </script>
</body>

</html>