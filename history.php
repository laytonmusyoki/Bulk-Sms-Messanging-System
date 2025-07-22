<?php
require_once 'db.php'; // Contains your $conn database connection

session_start();

// Fetch messages from the local sms_history table
$sql = "SELECT * FROM sms_history ORDER BY date DESC";
$result = mysqli_query($conn, $sql);

$messages = [];
$error = '';

if (!$result) {
    $error = "Database Error: " . mysqli_error($conn);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .content-header h1 {
            margin-bottom: 0.3em;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background-color: #f5f5f5;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
        }
        .status-success { background-color: #4caf50; }
        .status-failed { background-color: #f44336; }
    </style>
</head>
<body>

<section id="message-history" class="content-section">
    <div class="content-header">
        <h1>Message History</h1>
        <p>View all your sent messages and their delivery status.</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Recipient</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($error)): ?>
                    <tr><td colspan="4">Error: <?= htmlspecialchars($error) ?></td></tr>
                <?php elseif (empty($messages)): ?>
                    <tr><td colspan="4">No messages found.</td></tr>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?= htmlspecialchars($msg['date']) ?></td>
                            <td><?= htmlspecialchars($msg['recipient']) ?></td>
                            <td><?= htmlspecialchars($msg['message']) ?></td>
                            <td>
                                <span class="status-badge status-<?= strtolower($msg['status']) ?>">
                                    <?= htmlspecialchars($msg['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>
