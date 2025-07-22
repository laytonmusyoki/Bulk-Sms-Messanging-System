<?php
require 'vendor/autoload.php';
require 'db.php';

session_start();
if (!isset($_SESSION['username'])) {
    die("Access Denied. Please login.");
}

// Africa's Talking Config
$username = "layton";
$apiKey = "";

$AT = new AfricasTalking\SDK\AfricasTalking($username, $apiKey);
$sms = $AT->sms();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipients = explode(",", $_POST['recipients']);
    $message = $_POST['message'];

    echo "<h2>SMS Sending Report</h2>";

    foreach ($recipients as $recipient) {
        $recipient = trim($recipient);
        $date = date('Y-m-d H:i:s');
        $escaped_recipient = mysqli_real_escape_string($conn, $recipient);
        $escaped_message = mysqli_real_escape_string($conn, $message);
        $escaped_date = mysqli_real_escape_string($conn, $date);

        // Validate if recipient starts with '+'
        if (strpos($recipient, '+') === 0) {
            $status = 'Failed';
            $errorMsg = 'Number should not start with a + sign. Use format like 2547...';

            // Log to database
            $sql = "INSERT INTO sms_history (recipient, message, status, date) 
                    VALUES ('$escaped_recipient', '$escaped_message', '$status', '$escaped_date')";
            mysqli_query($conn, $sql);

            echo "Invalid number <b>$recipient</b>: $errorMsg<br>";
            continue;
        }

        if (!empty($recipient)) {
            try {
                $result = $sms->send([
                    'to'      => $recipient,
                    'message' => $message
                ]);

                $status = 'Success';

                $sql = "INSERT INTO sms_history (recipient, message, status, date) 
                        VALUES ('$escaped_recipient', '$escaped_message', '$status', '$escaped_date')";
                mysqli_query($conn, $sql);

                echo "SMS sent to <b>$recipient</b><br>";
            } catch (Exception $e) {
                $status = 'Failed';
                $errorMsg = $e->getMessage();
                $escaped_status = mysqli_real_escape_string($conn, $status);

                $sql = "INSERT INTO sms_history (recipient, message, status, date) 
                        VALUES ('$escaped_recipient', '$escaped_message', '$escaped_status', '$escaped_date')";
                mysqli_query($conn, $sql);

                echo " Failed to send SMS to <b>$recipient</b>: $errorMsg<br>";
            }
        }
    }

    $_SESSION['success_message'] = "SMS sending process completed!";
    header("Location: dashboard.php");
    exit;
}
?>
