<?php 
session_start();
include('../includes/header.php'); 
include('../includes/sidebar.php'); 
include('../config/database.php'); 

if($_SESSION['role'] != 'admin'){
    header("Location: ../dashboard/index.php");
    exit();
}

$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $fullname = $firstname . " " . $lastname;

    // CHECK EMAIL
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if($res->num_rows > 0){
        $error = "Email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users(fullname,email,password,role) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss",$fullname,$email,$password,$role);
        $stmt->execute();

        header("Location: manage_users.php");
        exit();
    }
}
?>

<h3 class="mb-4 text-white">Add User</h3>

<div class="card p-4 form-card">

<?php if($error): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="firstname" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="lastname" class="form-control" required>
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-select" required>
        <option value="staff">Staff</option>
        <option value="admin">Admin</option>
    </select>
</div>

<div class="col-md-12 mb-2">
    <label class="form-label">Password</label>
    <input type="password" id="password" name="password" class="form-control" required>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" onclick="togglePassword()">
    <label class="form-check-label">Show Password</label>
</div>

</div>

<div class="d-flex gap-2">
    <button class="btn btn-success w-100">Create User</button>
    <a href="manage_users.php" class="btn btn-secondary w-100">Cancel</a>
</div>

</form>

</div>

<script>
function togglePassword() {
    var x = document.getElementById("password");
    x.type = (x.type === "password") ? "text" : "password";
}
</script>

<?php include('../includes/footer.php'); ?>