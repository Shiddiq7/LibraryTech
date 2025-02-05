<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <title>Verify OTP - LibraTech</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('../assets/img/Libr.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            /* Increased max-width for wider card */
            text-align: center;
        }

        .otp-input {
            width: 40px;
            height: 40px;
            font-size: 18px;
            text-align: center;
            margin: 10px 5px;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 5px;
            color: white;
            outline: none;
        }

        .btn {
            background-color: #007bff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-size: 18px;
            color: white;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="card">
        <h4 class="mb-3" style="letter-spacing: 1px;">Verifikasi Akun Gmail Anda</h4>
        <p>Silakan masukkan kode OTP yang dikirimkan ke email Anda.</p>
        <form method="post" action="../func.php">
            <label class="form-label" for="inputOTP">Masukkan Kode OTP</label>
            <div class="mt-3 mb-4">
                <input type="text" name="otp[]" id="inputOTP" class="otp-input" maxlength="1"
                    onkeyup="moveToNext(this, event)" onpaste="handlePaste(event)" />
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)" />
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)" />
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)" />
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)" />
                <input type="text" name="otp[]" class="otp-input" maxlength="1" onkeyup="moveToNext(this, event)"
                    onpaste="handlePaste(event)" />
            </div>
            <button class="btn btn-outline-primary" type="submit" name="verifyOTP"
                style="border-radius: 12px;">Verifikasi</button>
        </form>
        <form method="post" action="../func.php" id="resend-form">
            <button class="btn btn-outline-secondary btn-sm mt-3" type="submit" name="resendOTP"
                style="border-radius: 12px;" id="resend-btn" disabled>Kirim Ulang Kode OTP</button>
        </form>
        <p id="timer" style="font-size: 12px; color: #fff;"></p>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
</body>

<!-- timer -->
<script>
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
</script>

<!-- OTP Input -->
<script>
    function moveToNext(element, event) {
        var inputs = document.querySelectorAll('.otp-input');
        var index = Array.prototype.indexOf.call(inputs, element);
        if (event.keyCode == 8 && index > 0) {
            inputs[index - 1].focus();
        } else if (index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }
    function handlePaste(event) {
        var text = event.clipboardData.getData('Text');
        var inputs = document.querySelectorAll('.otp-input');
        for (var i = 0; i < text.length; i++) {
            inputs[i].value = text[i];
        }
    }
</script>

</html>