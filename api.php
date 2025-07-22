<?php
require 'db.php';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gateway = mysqli_real_escape_string($conn, $_POST['gateway']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $apikey = mysqli_real_escape_string($conn, $_POST['apikey']);

    // Check if this gateway already has saved settings
    $checkQuery = "SELECT * FROM api_settings WHERE gateway = '$gateway'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Record exists – perform an update
        $updateQuery = "UPDATE api_settings SET username = '$username', apikey = '$apikey' WHERE gateway = '$gateway'";
        if (mysqli_query($conn, $updateQuery)) {
            $success = "API settings updated successfully!";
        } else {
            $error = "Update Error: " . mysqli_error($conn);
        }
    } else {
        // No record – insert new
        $insertQuery = "INSERT INTO api_settings (gateway, username, apikey) VALUES ('$gateway', '$username', '$apikey')";
        if (mysqli_query($conn, $insertQuery)) {
            $success = "API settings saved successfully!";
        } else {
            $error = "Insert Error: " . mysqli_error($conn);
        }
    }
}
?>


<style>
    .api-settings {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
        width: 100%;
        margin: 0 auto;
    }

    .api-settings h2 {
        margin-bottom: 10px;
        font-size: 22px;
        color: #333;
    }

    .api-settings p {
        margin-bottom: 25px;
        color: #555;
    }

    .api-settings label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
    }

    .api-settings input[type="text"],
    .api-settings input[type="password"],
    .api-settings select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 15px;
        background-color: #f9f9f9;
        transition: border-color 0.3s;
    }

    .api-settings input:focus,
    .api-settings select:focus {
        border-color: #2196f3;
        outline: none;
    }

    .api-settings button {
        background-color: #2196f3;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .api-settings button:hover {
        background-color: #1976d2;
    }

    .api-settings .success-message {
        color: green;
        margin-top: 10px;
    }

    .api-settings .error-message {
        color: red;
        margin-top: 10px;
    }
</style>

<div class="api-settings">
    <h2>API Settings</h2>
    <p>Configure your SMS gateway and API credentials.</p>

    <?php if ($success): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
    <label for="gateway">SMS Gateway</label>
    <select name="gateway" id="gateway" required>
        <option value="africastalking" <?= $selectedGateway === 'africastalking' ? 'selected' : '' ?>>Africa's Talking</option>
        <option value="twilio" disabled>Twilio (Coming Soon)</option>
    </select>

    <label for="username">API Username</label>
    <input type="text" name="username" id="username" required value="<?= htmlspecialchars($username) ?>" placeholder="Enter API username">

    <label for="apikey">API Key</label>
    <input type="password" name="apikey" id="apikey" required value="<?= htmlspecialchars($apikey) ?>" placeholder="Enter API key">

    <button type="submit">Save Settings</button>
</form>

</div>
