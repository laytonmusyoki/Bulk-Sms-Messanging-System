<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, phone, password) VALUES ('$username', '$phone', '$password')";

    if (mysqli_query($conn, $sql)) {
        $success = "Registration successful! <a href='login.php'>Click to Login</a>";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Messenger System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            margin-bottom: 25px;
            text-align: center;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            background: #ffe0e0;
            color: #cc0000;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
   
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <div class="login-container">
         <h2>Register for Messenger System</h2>
        <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    
    <div class="links">
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <p><a href="index.php">Back to Home</a></p>
    </div>
    </div>
</body>
</html>
