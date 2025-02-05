<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - LibraTech</title>
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url("../assets/img/Libr.jpeg");
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .verification-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            padding: 30px;
            max-width: 500px;
            min-width: 300px;
            position: relative;
        }

        .verification-container img {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            outline: none;
        }

        .otp-input:focus {
            border: 2px solid #007bff;
        }

        .btn-verify {
            background-color: rgb(0, 217, 255);
            color: white;
            font-weight: bold;
            border-radius: 30px;
            padding: 10px 20px;
            border: none;
            width: 100%;
            margin-bottom: 15px;
        }

        .btn-verify:hover {
            background-color: rgb(0, 217, 255);
        }

        .btn-resend {
            background: none;
            border: none;
            color: #666;
            font-weight: bold;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }

        .btn-resend:disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        .timer {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="verification-container text-center">
        <div class="mb-4">
            <img src="../assets/img/email.png" alt="Email Icon">
        </div>
        <h2 class="font-weight-bold mb-2">Verifikasi Email Anda</h2>
        <p class="text-muted mb-4">Silakan masukkan kode OTP yang dikirimkan ke email Anda.</p>

        <form method="post" action="../func.php">
            <div class="otp-input-container">
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)">
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)">
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)">
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)">
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)">
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)">
            </div>
            <br>
            <button class="btn btn-verify" type="submit" name="verifyOTP">Verifikasi Email</button>
        </form>
        <hr>
        <p class="text-center">Anda ingin mengganti email? <a href="register.php">klik di sini</a></p>

        <form method="post" action="../func.php" id="resend-form">
            <button class="btn btn-outline-secondary btn-sm mt-3" type="submit" name="resendOTP"
                style="border-radius: 12px;" id="resend-btn" disabled>Kirim Ulang Kode OTP</button>
        </form>
        <p id="timer" class="timer"></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Timer functionality
        var countDownDate = new Date().getTime() + 30000;
        var x = setInterval(function () {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("timer").innerHTML = seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("resend-btn").disabled = false;
                document.getElementById("timer").innerHTML = "";
            }
        }, 1000);

        // OTP input functionality
        function moveToNext(element, event) {
            var inputs = document.querySelectorAll('.otp-input');
            var index = Array.prototype.indexOf.call(inputs, element);
            if (event.keyCode == 8 && index > 0) {
                inputs[index - 1].focus();
            } else if (index < inputs.length - 1 && element.value !== '') {
                inputs[index + 1].focus();
            }
        }

        function handlePaste(event) {
            event.preventDefault();
            var text = event.clipboardData.getData('Text');
            var inputs = document.querySelectorAll('.otp-input');
            for (var i = 0; i < Math.min(text.length, inputs.length); i++) {
                inputs[i].value = text[i];
                if (i < inputs.length - 1) {
                    inputs[i + 1].focus();
                }
            }
        }
    </script>
</body>

</html>