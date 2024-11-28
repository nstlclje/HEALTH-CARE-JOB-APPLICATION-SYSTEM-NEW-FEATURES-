<?php
session_start();
require '../core/dbConfig.php';
include('../core/models.php'); 

if (isset($_SESSION['user_name'])) {
    
    log_activity($_SESSION['user_name'], "Logged out.");
    
    session_destroy();
    session_unset();
    
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Users WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_id'] = $user['user_id'];

        log_activity($user['user_name'], "User logged in with email: $email");
        
        header("Location: ../includes/index.php");
        exit;
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<?php require '../core/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #A8E6CF, #DCEDC1); 
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.9); 
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #388E3C; 
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input {
            padding: 12px;
            font-size: 1rem;
            border: none;
            border-radius: 10px;
            outline: none;
            background-color: rgba(255, 255, 255, 0.3); 
            color: #333;
        }

        input::placeholder {
            color: #ddd;
        }

        button {
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #fff;
            background-color: #4CAF50; 
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #388E3C; 
            transform: translateY(-3px);
        }

        button:active {
            transform: translateY(1px);
        }

        .error {
            background-color: #ff4d4d;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            color: #fff;
        }

        p {
            color: #333;
        }

        a {
            color: #388E3C; 
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <?php if (isset($error_message)) { echo "<div class='error'>$error_message</div>"; } ?>
    </div>
</body>
</html>