<?php
require_once '../config/bootstrap.php';



if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$trans = require_once "../lang/". $_SESSION['lang'].".php";

// Login formasini tekshirish
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        header("Location: ../index.php");
        exit();
    } else {
        $error = $trans['error'];
    }


    
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $trans['title'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #4a90e2, #9013fe);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px 40px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            color: #333;
        }
        .container h2 {
            margin-bottom: 20px;
            color: #4a90e2;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group input:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
        }
        .btn {
            background: #4a90e2;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background: #3a7bd5;
        }
        .error {
            color: #e74c3c;
            margin-bottom: 15px;
        }
        .lang-switch {
            margin-top: 20px;
        }
        .lang-switch a {
            color: #4a90e2;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }
        .lang-switch a:hover {
            text-decoration: underline;
        }
        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?= $trans['title'] ?></h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="<?= $trans['username'] ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="<?= $trans['password'] ?>" required>
            </div>
            <button class="btn" type="submit"><?= $trans['login'] ?></button>
        </form>

        <div class="lang-switch">
            <a href="?lang=uz">O'zbekcha</a> | <a href="?lang=ru">Русский</a>
        </div>
    </div>
</body>
</html>
