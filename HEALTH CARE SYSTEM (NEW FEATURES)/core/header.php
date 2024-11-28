<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Care System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #A8E6CF, #DCEDC1); 
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .navbar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 20px;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background: transparent; 
            
        }

        .navbar a.home-btn {
            background: rgba(0, 0, 0, 0.1);
            color: #388E3C; 
            text-decoration: none;
            font-weight: bold;
            padding: 12px 24px; 
            font-size: 1rem; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            transition: background 0.3s;
        }

        .navbar a.home-btn:hover {
            background-color: #388E3C; 
            color: #fff;
        }

        .navbar a.home-btn:active {
            transform: translateY(1px); 
        }

    </style>
</head>
<body>
    <div class="navbar">
        <a href="../index.php" class="home-btn">Home</a>
    </div>
</body>
</html>