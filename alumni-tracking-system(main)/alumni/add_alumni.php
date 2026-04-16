<?php 
session_start();
include('../includes/header.php'); 
include('../includes/sidebar.php'); 
include('../config/database.php'); 

// FETCH DATA FOR DROPDOWNS
$courses = $conn->query("SELECT * FROM courses");
$statuses = $conn->query("SELECT * FROM employment_status");

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $student_id = $_POST['student_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = $_POST['address'];
    $course_id = $_POST['course_id'];
    $year = $_POST['graduation_year'];

    $status_id = $_POST['status_id'];
    $company = $_POST['company'];
    $job = $_POST['job_title'];

    // ✅ VALIDATION
    if(empty($email) || empty($phone)){
        echo "<script>alert('Email and Phone are required!');</script>";
    } else {

        // INSERT INTO alumni
        $stmt = $conn->prepare("INSERT INTO alumni 
        (student_id, firstname, lastname, gender, birthdate, email, phone, address, course_id, graduation_year) 
        VALUES (?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param("sssssssssi", 
            $student_id,$firstname,$lastname,$gender,$birthdate,
            $email,$phone,$address,$course_id,$year
        );

        $stmt->execute();

        $alumni_id = $conn->insert_id;

        // INSERT INTO employment
        $stmt2 = $conn->prepare("INSERT INTO employment 
        (alumni_id, status_id, company, job_title) 
        VALUES (?,?,?,?)");

        $stmt2->bind_param("iiss", $alumni_id,$status_id,$company,$job);
        $stmt2->execute();

        header("Location: view_alumni.php");
        exit();
    }
}
?>

<h3 class="text-white mb-4">Add Alumni</h3>

<div class="card p-4 form-card">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
    <label class="form-label">Student ID</label>
    <input type="text" name="student_id" class="form-control">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Course</label>
    <select name="course_id" class="form-select" required>
        <option value="">Select Course</option>
        <?php while($c = $courses->fetch_assoc()): ?>
            <option value="<?php echo $c['id']; ?>">
                <?php echo $c['course_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="firstname" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="lastname" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Gender</label>
    <select name="gender" class="form-select">
        <option value="">Select</option>
        <option>Male</option>
        <option>Female</option>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Birthdate</label>
    <input type="date" name="birthdate" class="form-control">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" required>
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control"></textarea>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Graduation Year</label>
    <input type="number" name="graduation_year" class="form-control">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Employment Status</label>
    <select name="status_id" class="form-select">
        <?php while($s = $statuses->fetch_assoc()): ?>
            <option value="<?php echo $s['id']; ?>">
                <?php echo $s['status_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Company</label>
    <input type="text" name="company" class="form-control">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Job Title</label>
    <input type="text" name="job_title" class="form-control">
</div>

</div>

<div class="d-flex gap-2 mt-3">
    <button class="btn btn-success w-100">Save</button>
    <a href="view_alumni.php" class="btn btn-secondary w-100">Cancel</a>
</div>

</form>

</div>

<?php include('../includes/footer.php'); ?>