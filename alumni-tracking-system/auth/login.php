<?php
session_start();
include('../config/database.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($user = $res->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Alumni Tracking System</title>

    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url('../assets/images/background-image.jpg') no-repeat center center/cover;
            font-family: 'Segoe UI', sans-serif;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.65);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 370px;
            padding: 30px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            color: #fff;
        }

        /* Logo and Header Styling */
        .brand-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .brand-logo {
            width: 45px; /* Adjust size as needed */
            height: 45px;
            object-fit: contain;
        }

        .login-card h3 {
            font-weight: bold;
            margin: 0;
        }

        .form-control {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.3);
            color: white;
            box-shadow: none;
        }

        .btn-login {
            background-color: #ffc107;
            border: none;
            color: black;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #e0a800;
        }

        .btn-register {
            border: 1px solid #fff;
            color: white;
            text-decoration: none;
            display: block;
            text-align: center;
            padding: 8px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: white;
            color: black;
        }

        .small-text {
            font-size: 13px;
            color: #ccc;
        }
    </style>
</head>

<body>

<div class="overlay">

    <div class="login-card shadow">

        <div class="brand-wrapper">
            <img src="../assets/images/logo.jpg.jpg " alt="Logo" class="brand-logo">
            <h3>Alumni System</h3>
        </div>
        
        <p class="text-center small-text mb-4">Sign in to continue</p>

        <?php if($error): ?>
            <div class="alert alert-danger py-2" style="font-size: 14px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button type="submit" class="btn btn-login w-100 mb-2">Login</button>
        </form>

        <a href="register.php" class="btn btn-register w-100">Create Account</a>

    </div>

</div>

</body>
</html>
