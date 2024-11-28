<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Care Job Application System</title>
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
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #388E3C; 
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .role-btn {
            padding: 12px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
            background-color: #4CAF50; 
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .role-btn:hover {
            background-color: #388E3C; 
            transform: translateY(-3px);
        }
        .role-btn:active {
            transform: translateY(1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Health Care Job Application System</h1>
        <a href="includes/login.php" class="role-btn">Users</a>
    </div>
</body>
</html>
