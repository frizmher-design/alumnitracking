<?php
include('../config/database.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users(fullname,email,password) VALUES(?,?,?)");
        $stmt->bind_param("sss", $fullname, $email, $password);
        $stmt->execute();

        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>

<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>

/* SAME BACKGROUND */
body {
    margin: 0;
    height: 100vh;
    background: url('../assets/images/background-image.jpg') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

/* SAME OVERLAY */
.overlay {
    background: rgba(0, 0, 0, 0.65);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* GLASS CARD */
.register-card {
    width: 400px;
    padding: 30px;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    color: #fff;
}

/* INPUTS */
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

/* BUTTON */
.btn-register {
    background-color: #ffc107;
    border: none;
    color: black;
    font-weight: bold;
}

.btn-register:hover {
    background-color: #e0a800;
}

/* LOGIN BUTTON */
.btn-login {
    border: 1px solid #fff;
    color: white;
}

.btn-login:hover {
    background: white;
    color: black;
}

/* TEXT */
.small-text {
    font-size: 13px;
    color: #ccc;
}

</style>
</head>

<body>

<div class="overlay">

    <div class="register-card shadow">

        <h3 class="text-center mb-2">🎓 Create Account</h3>
        <p class="text-center small-text mb-3">Join the Alumni System</p>

        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">

            <input type="text" name="fullname" class="form-control mb-3" placeholder="Full Name" required>

            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button class="btn btn-register w-100 mb-2">Register</button>

        </form>

        <a href="login.php" class="btn btn-login w-100">Back to Login</a>

    </div>

</div>

</body>
</html>