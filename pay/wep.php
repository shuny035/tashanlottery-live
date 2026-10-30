<?php
error_reporting(0);

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tashan_db');

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, indiawin_tashan, indiawin_tashan, indiawin_tashan);
$sql2 = "SELECT upi FROM notice WHERE id='1'";
$result = $conn->query($sql2);
$row = mysqli_fetch_array($result);
$upiid = $row['upi'];
$am = $_GET['am'];
$user = $_GET['user'];
$mode = $_GET['mode'];

if ($mode == "PhonePe") {
    $open = "phonepe://pay";
} else if ($mode == "Paytm") {
    $open = "paytmmp://pay";
} else if ($mode == "GPay") {
    $open = "tez://upi/pay";
} else {
    $open = "upi://pay";
}

function random_strings($length_of_string)
{
    // String of all alphanumeric character
    $str_result = '0123456789AXYZ012345678901234567890123456789';
    // Shuffle the $str_result and returns substring
    return substr(
        str_shuffle($str_result),
        0,
        $length_of_string
    );
}

$rand = random_strings(22);
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {
    $utr = random_strings(12);
    $filename = $utr . '.jpeg';
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./" . $filename;

    // Get all the submitted data from the form
    $sql1 = "INSERT INTO recharge (username, recharge, status, upi, utr, rand) VALUES ('$user', '$am', 'unpaid', '$upiid', '$utr', '$rand')";
    $conn->query($sql1);

    // Now let's move the uploaded image into the folder
    if (move_uploaded_file($tempname, $folder)) {
        header("location: /#/rechargerecord");
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
}

// File upload and database insert
if (isset($_POST['upload'])) {
    $utr = random_strings(12);
    $filename = $utr . '.jpeg';
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./uploads/" . $filename;

    // Insert transaction into the database
    $sql1 = "INSERT INTO recharge (username, recharge, status, upi, utr, rand) VALUES ('$user', '$am', 'unpaid', '$upiid', '$utr', '$rand')";
    if ($conn->query($sql1) === TRUE) {
        // Now move the uploaded file to the desired folder
        if (move_uploaded_file($tempname, $folder)) {
            header("location: /#/rechargerecord");
        } else {
            echo "<h3>Failed to upload image!</h3>";
        }
    } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Pay</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 100%; max-width: 400px; margin: auto; border: 1px solid #ddd; }
        .container1 {
            width: auto;
            margin: 15px;
            border: 0px solid #ddd;
        }
        input, button { width: 90%; padding: 10px; margin: 10px 0; }
        .upload-box {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            padding: 15px;
            width: 90%;
            margin: auto;
            cursor: pointer;
            background: #fff;
            color: #555;
            font-weight: bold;
            border-radius: 10px;
        }
        .upload-box:hover {
            border-color: deeppink;
            color: deeppink;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="position: relative; background: deeppink; color: white; font-weight: bold; padding-top: 10px; padding-bottom: 10px; border-radius: 0 0 20px 20px; text-align: center; width: 100%; margin: auto;">
            FAST PAY
        </div>
        <h3 style="display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc; padding: 15px; width: 37%; margin: auto; margin-top: 10px; cursor: pointer; background: #fff; color: #555; font-weight: bold; border-radius: 10px;">
            Time Left:  <span id="countdown">4:15</span>
        </h3>
        <div class="container1">
            <h2>PAY ₹<?php echo $am; ?></h2>
            <p>Scan QR Code to Pay</p>
            <img src="http://127.0.0.1:8080/v1/create-qr-code/?size=150x150&data=upi%3A%2F%2Fpay%3Fpa%3DCFST20005816%40CUB%26pn%3DDEVRAJ%2BSOLUTIONS%26am%3D1000%26cu%3DINR%26tr%3DORD9598" alt="QR Code">

            <h3>Choose Your Method To Pay</h3>
            <p>1. Copy UPI Information:</p>
            <div style="display: flex; align-items: center; gap: 10px; justify-content: center;">
                <span id="upiText" style="font-size: 16px; font-weight: 0; background: #f8f8f8; padding: 8px 12px; border-radius: 5px; color: #333;"><?php echo $upiid;?></span>
                <button onclick="copyUPI()" style="padding: 6px 10px; background: #ff1493; color: white; font-weight: 600; border: none; cursor: pointer; font-size: 14px; border-radius: 5px;">COPY</button>
            </div>

            <p>2. Make Payment Using:</p>
            <div style="display: flex; gap: 10px; justify-content: center; margin: 10px 0;">
                <!-- Paytm -->
                <a href="upi://pay?pa=CFST20005816%40CUB&pn=DEVRAJ SOLUTIONS&am=1000&cu=INR" target="_blank">
                    <img src="http://127.0.0.1:8080/assets/paytm.jpg" alt="Paytm" width="50">
                </a>

                <!-- PhonePe -->
                <a href="phonepe://upi/pay?pa=CFST20005816%40CUB&pn=DEVRAJ SOLUTIONS&am=1000&cu=INR" target="_blank">
                    <img src="http://127.0.0.1:8080/assets/ppay.png" alt="PhonePe" width="50">
                </a>

                <!-- Google Pay -->
                <a href="tez://upi/pay?pa=CFST20005816%40CUB&pn=DEVRAJ SOLUTIONS&am=1000&cu=INR" target="_blank">
                    <img src="http://127.0.0.1:8080/assets/gpay.jpg" alt="Google Pay" width="50">
                </a>

                <!-- BHIM UPI -->
                <a href="upi://pay?pa=CFST20005816%40CUB&pn=DEVRAJ SOLUTIONS&am=1000&cu=INR" target="_blank">
                    <img src="http://127.0.0.1:8080/assets/upi.jpg" alt="UPI" width="50">
                </a>
            </div>

            <p>3. Upload Payment Receipt:</p>
            <form method="POST" enctype="multipart/form-data">
                <label class="upload-box">
                    <input type="file" id="fileInput" name="uploadfile" required style="display: none;">
                    <span id="fileLabel">Choose File</span>
                </label>
                <button type="submit" name="upload" style="background: deeppink; color: white; font-weight: 600; border: none; border-radius: 20px;">
                    SUBMIT
                </button>
            </form>
        </div>
    </div>

    <script>
        function startCountdown(duration) {
            let timer = duration, minutes, seconds;
            const countdownElement = document.getElementById("countdown");

            const interval = setInterval(function () {
                minutes = Math.floor(timer / 60);
                seconds = timer % 60;

                seconds = seconds < 10 ? "0" + seconds : seconds;
                countdownElement.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    countdownElement.textContent = "Time Over";
                }
            }, 1000);
        }

        // Start countdown from 10 minutes (600 seconds)
        startCountdown(600);
    </script>

    <script>
        function copyUPI() {
            const upiText = document.getElementById("upiText").innerText;
            navigator.clipboard.writeText(upiText).then(() => {
                alert("UPI ID copied!");
            });
        }
        
        
        
        
document.getElementById("fileInput").addEventListener("change", function () {
    const fileLabel = document.getElementById("fileLabel");
    const file = this.files[0];

    if (file) {
        const fileType = file.type;

        // Check if the selected file is an image
        if (fileType.startsWith('image/')) {
            fileLabel.textContent = "Uploading...";

            // Simulating the file upload process
            setTimeout(function () {
                fileLabel.textContent = "Uploaded Successfully ✅";

                // Handle image upload logic here, like saving details to database or processing further
                // Example: Display image preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imagePreview = document.createElement('img');
                    imagePreview.src = e.target.result;
                    imagePreview.style.width = '100px';
                    imagePreview.style.marginTop = '10px';
                    document.body.appendChild(imagePreview);  // Show the uploaded image preview
                };
                reader.readAsDataURL(file);  // Convert file to data URL for preview
            }, 2000);  // Simulate a delay for the upload
        } else {
            fileLabel.textContent = "Please upload an image file.";
        }
    }
});
</script>
    </script>

</body>
</html>
