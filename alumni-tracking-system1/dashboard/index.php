<?php
session_start();
include('../config/database.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$role = $_SESSION['role'];
$fullname = $_SESSION['fullname'];

// ✅ TOTAL ALUMNI
$total = $conn->query("SELECT COUNT(*) as t FROM alumni")->fetch_assoc()['t'];

// ✅ EMPLOYED
$employed = $conn->query("
SELECT COUNT(*) as e 
FROM employment e
JOIN employment_status s ON e.status_id = s.id
WHERE s.status_name = 'Employed'
")->fetch_assoc()['e'];

// ✅ UNEMPLOYED
$unemployed = $conn->query("
SELECT COUNT(*) as u 
FROM employment e
JOIN employment_status s ON e.status_id = s.id
WHERE s.status_name = 'Unemployed'
")->fetch_assoc()['u'];
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>

<h3 class="mb-2 text-white"><?php echo ucfirst($role); ?> Dashboard</h3>
<p class="text-light mb-4">Welcome back, <?php echo $fullname; ?></p>

<div class="row g-3">

<div class="col-md-4">
    <div class="stat-card p-4">
        <div class="stat-title">Total Alumni</div>
        <div class="stat-value"><?php echo $total; ?></div>
    </div>
</div>

<div class="col-md-4">
    <div class="stat-card p-4">
        <div class="stat-title">Employed</div>
        <div class="stat-value"><?php echo $employed; ?></div>
    </div>
</div>

<div class="col-md-4">
    <div class="stat-card p-4">
        <div class="stat-title">Unemployed</div>
        <div class="stat-value"><?php echo $unemployed; ?></div>
    </div>
</div>

</div>

<div class="row mt-4">

<div class="col-md-8">
    <div class="card p-4 mb-3">
        <h5>System Overview</h5>
        <p>This system helps manage alumni records and track employment status.</p>
    </div>

    <?php if($role === 'admin'): ?>
    <div class="card p-4 border-warning border-start border-4">
        <h5>Admin Controls</h5>
        <a href="../users/manage_users.php" class="btn btn-warning">Manage Users</a>
    </div>
    <?php endif; ?>
</div>

<div class="col-md-4">
    <div class="card p-4">
        <h5>Quick Actions</h5>

        <a href="../alumni/add_alumni.php" class="btn btn-success w-100 mb-2">Add Alumni</a>
        <a href="../alumni/view_alumni.php" class="btn btn-primary w-100 mb-2">View Alumni</a>

        <?php if($role === 'admin'): ?>
            <a href="../users/manage_users.php" class="btn btn-dark w-100">Manage Users</a>
        <?php endif; ?>
    </div>
</div>

</div>

<?php include('../includes/footer.php'); ?>