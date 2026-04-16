<?php 
session_start();
include('../includes/header.php'); 
include('../includes/sidebar.php'); 
include('../config/database.php'); 

$id = $_GET['id'];

// FETCH DATA
$query = "
SELECT 
a.*,
e.company,
e.job_title,
e.status_id
FROM alumni a
LEFT JOIN employment e ON a.id = e.alumni_id
WHERE a.id = $id
";

$data = $conn->query($query)->fetch_assoc();

// DROPDOWNS
$courses = $conn->query("SELECT * FROM courses");
$statuses = $conn->query("SELECT * FROM employment_status");

// SAFE VALUES
$company_val = $data['company'] ?? '';
$job_val = $data['job_title'] ?? '';
$status_val = $data['status_id'] ?? '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $student_id = trim($_POST['student_id']);
    if($student_id == ''){
        $student_id = NULL;
    }

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
    $company = $_POST['company'] ?? '';
    $job = $_POST['job_title'] ?? '';

    // ✅ VALIDATION
    if(empty($email) || empty($phone)){
        echo "<script>alert('Email and Phone are required!');</script>";
        exit();
    }

    if($student_id !== NULL){
        $check = $conn->prepare("SELECT id FROM alumni WHERE student_id=? AND id!=?");
        $check->bind_param("si", $student_id, $id);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0){
            echo "<script>alert('Student ID already exists!'); window.location='view_alumni.php';</script>";
            exit();
        }
    }

    // UPDATE alumni
    $stmt = $conn->prepare("UPDATE alumni SET 
    student_id=?, firstname=?, lastname=?, gender=?, birthdate=?, email=?, phone=?, address=?, course_id=?, graduation_year=?
    WHERE id=?");

    $stmt->bind_param("ssssssssiii", 
        $student_id,$firstname,$lastname,$gender,$birthdate,
        $email,$phone,$address,$course_id,$year,$id
    );

    $stmt->execute();

    // IF UNEMPLOYED → REMOVE COMPANY
    if($status_id == 2){ 
        $company = NULL;
        $job = NULL;
    }

    // CHECK EMPLOYMENT RECORD
    $checkEmp = $conn->query("SELECT id FROM employment WHERE alumni_id=$id");

    if($checkEmp->num_rows > 0){
        $stmt2 = $conn->prepare("UPDATE employment SET 
        status_id=?, company=?, job_title=? WHERE alumni_id=?");

        $stmt2->bind_param("issi",$status_id,$company,$job,$id);
        $stmt2->execute();
    } else {
        $stmt2 = $conn->prepare("INSERT INTO employment 
        (alumni_id, status_id, company, job_title) VALUES (?,?,?,?)");

        $stmt2->bind_param("iiss",$id,$status_id,$company,$job);
        $stmt2->execute();
    }

    header("Location: view_alumni.php");
    exit();
}
?>

<h3 class="text-white mb-4">Edit Alumni</h3>

<div class="card p-4 form-card">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
    <label class="form-label">Student ID</label>
    <input type="text" name="student_id" class="form-control"
    value="<?php echo $data['student_id']; ?>">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Course</label>
    <select name="course_id" class="form-select" required>
        <?php while($c = $courses->fetch_assoc()): ?>
            <option value="<?php echo $c['id']; ?>"
            <?php if($data['course_id'] == $c['id']) echo 'selected'; ?>>
                <?php echo $c['course_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="firstname" class="form-control"
    value="<?php echo $data['firstname']; ?>">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="lastname" class="form-control"
    value="<?php echo $data['lastname']; ?>">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Gender</label>
    <select name="gender" class="form-select">
        <option value="">Select</option>
        <option <?php if($data['gender']=='Male') echo 'selected'; ?>>Male</option>
        <option <?php if($data['gender']=='Female') echo 'selected'; ?>>Female</option>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Birthdate</label>
    <input type="date" name="birthdate" class="form-control"
    value="<?php echo $data['birthdate']; ?>">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
    value="<?php echo $data['email']; ?>" required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control"
    value="<?php echo $data['phone']; ?>" required>
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control"><?php echo $data['address']; ?></textarea>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Graduation Year</label>
    <input type="number" name="graduation_year" class="form-control"
    value="<?php echo $data['graduation_year']; ?>">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Employment Status</label>
    <select name="status_id" id="status" class="form-select">
        <?php while($s = $statuses->fetch_assoc()): ?>
            <option value="<?php echo $s['id']; ?>"
            <?php if($status_val == $s['id']) echo 'selected'; ?>>
                <?php echo $s['status_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

<div id="employmentFields">

<div class="col-md-6 mb-3">
    <label class="form-label">Company</label>
    <input type="text" name="company" class="form-control"
    value="<?php echo $company_val; ?>">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Job Title</label>
    <input type="text" name="job_title" class="form-control"
    value="<?php echo $job_val; ?>">
</div>

</div>

</div>

<div class="d-flex gap-2 mt-3">
    <button class="btn btn-primary w-100">Update</button>
    <a href="view_alumni.php" class="btn btn-secondary w-100">Cancel</a>
</div>

</form>

</div>

<script>
function toggleEmploymentFields() {
    var status = document.getElementById("status").value;
    var fields = document.getElementById("employmentFields");

    if(status == "2"){
        fields.style.display = "none";
    } else {
        fields.style.display = "block";
    }
}

toggleEmploymentFields();
document.getElementById("status").addEventListener("change", toggleEmploymentFields);
</script>

<?php include('../includes/footer.php'); ?>