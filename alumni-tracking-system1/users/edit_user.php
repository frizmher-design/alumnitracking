<?php 
session_start();
include('../includes/header.php'); 
include('../includes/sidebar.php'); 
include('../config/database.php'); 

if($_SESSION['role'] != 'admin'){
    header("Location: ../dashboard/index.php");
    exit();
}

$id = (int)$_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if(!$user){
    header("Location: manage_users.php");
    exit();
}

// SPLIT NAME
$nameParts = explode(" ", $user['fullname'], 2);
$firstname = $nameParts[0];
$lastname = $nameParts[1] ?? "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $fullname = $firstname . " " . $lastname;

    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi",$fullname,$email,$role,$id);
    $stmt->execute();

    if(!empty($_POST['password'])){
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET password='$password' WHERE id=$id");
    }

    header("Location: manage_users.php");
    exit();
}
?>

<h3 class="mb-4 text-white">Edit User</h3>

<div class="card p-4 form-card">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="firstname" class="form-control"
    value="<?php echo $firstname; ?>" required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="lastname" class="form-control"
    value="<?php echo $lastname; ?>" required>
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
    value="<?php echo $user['email']; ?>" required>
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-select">
        <option value="staff" <?php if($user['role']=='staff') echo 'selected'; ?>>Staff</option>
        <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
    </select>
</div>

<div class="col-md-12 mb-2">
    <label class="form-label">New Password</label>
    <input type="password" id="password" name="password" class="form-control"
    placeholder="Leave blank to keep current">
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" onclick="togglePassword()">
    <label class="form-check-label">Show Password</label>
</div>

</div>

<div class="d-flex gap-2">
    <button class="btn btn-primary w-100">Update User</button>
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