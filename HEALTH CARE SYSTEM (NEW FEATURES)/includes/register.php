<?php
include('../core/dbConfig.php');
include('../core/models.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date_of_registration = date("Y-m-d");

    $query = "SELECT * FROM Users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $error_message = "Email already exists!";
    } else {
        $query = "INSERT INTO Users (user_name, email, password, date_of_registration)
                  VALUES ('$user_name', '$email', '$password', '$date_of_registration')";
        if (mysqli_query($conn, $query)) {
            $success_message = "Registered successfully! <a href='login.php'>Login</a>";
            log_activity($user_name, "User registered with email: $email");
        } else {
            $error_message = "Error during registration!";
        }
    }
}
?>

<?php include('../core/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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

        .success {
            background-color: #28a745;
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
        <h2>User Registration</h2>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <input type="text" name="user_name" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>