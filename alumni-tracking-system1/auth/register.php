<?php
include('../config/database.php');

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password_raw = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if ($password_raw !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {

        $password = password_hash($password_raw, PASSWORD_DEFAULT);

        // Check email
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $error = "Email already registered!";
        } else {

            $stmt = $conn->prepare("INSERT INTO users(fullname,email,password,role) VALUES(?,?,?,?)");
            $stmt->bind_param("ssss", $fullname, $email, $password, $role);

            if ($stmt->execute()) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong!";
            }
        }
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

.register-card {
    width: 400px;
    padding: 30px;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    color: #fff;
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

/* ROLE */
.role-box {
    display: flex;
    gap: 10px;
}

.role-card {
    flex: 1;
    cursor: pointer;
}

.role-card input {
    display: none;
}

.card-content {
    padding: 15px;
    border-radius: 12px;
    background: rgba(255,255,255,0.15);
    text-align: center;
    transition: 0.3s;
    color: white;
}

.role-card input:checked + .card-content {
    background: #ffc107;
    color: black;
    font-weight: bold;
    transform: scale(1.05);
}

.btn-register {
    background-color: #ffc107;
    border: none;
    color: black;
    font-weight: bold;
}

.btn-register:hover {
    background-color: #e0a800;
}

.btn-login {
    border: 1px solid #fff;
    color: white;
}

.btn-login:hover {
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

    <div class="register-card shadow">

        <h3 class="text-center mb-2">🎓 Create Account</h3>
        <p class="text-center small-text mb-3">Join the Alumni System</p>

        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">

            <input type="text" name="fullname" class="form-control mb-3" placeholder="Full Name" required>

            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

            <!-- PASSWORD -->
            <input type="password" id="password" name="password" class="form-control mb-2" placeholder="Password" required>

            <!-- CONFIRM PASSWORD -->
            <input type="password" id="confirm_password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password" required>

            <!-- SHOW PASSWORD -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="togglePassword">
                <label class="form-check-label small-text" for="togglePassword">
                    Show Password
                </label>
            </div>

            <!-- ROLE -->
            <div class="role-box mb-3">

                <label class="role-card">
                    <input type="radio" name="role" value="staff" checked>
                    <div class="card-content">
                        👤 <strong>Staff</strong><br>
                        <small>Regular access</small>
                    </div>
                </label>

                <label class="role-card">
                    <input type="radio" name="role" value="admin">
                    <div class="card-content">
                        🛡️ <strong>Admin</strong><br>
                        <small>Full control</small>
                    </div>
                </label>

            </div>

            <button class="btn btn-register w-100 mb-2">Register</button>

        </form>

        <a href="login.php" class="btn btn-login w-100">Back to Login</a>

    </div>

</div>

<!-- SCRIPT -->
<script>
document.getElementById("togglePassword").addEventListener("change", function() {
    const pass = document.getElementById("password");
    const confirm = document.getElementById("confirm_password");

    const type = this.checked ? "text" : "password";
    pass.type = type;
    confirm.type = type;
});
</script>

</body>
</html>