<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../config/database.php'); ?>

<?php
$total = $conn->query("SELECT COUNT(*) as t FROM alumni")->fetch_assoc()['t'];
$employed = $conn->query("SELECT COUNT(*) as e FROM alumni WHERE employment_status='Employed'")->fetch_assoc()['e'];
$unemployed = $conn->query("SELECT COUNT(*) as u FROM alumni WHERE employment_status='Unemployed'")->fetch_assoc()['u'];
?>

<h3 class="mb-4">Dashboard</h3>

<div class="row g-3">

<div class="col-md-4">
    <div class="card shadow text-white bg-primary">
        <div class="card-body">
            <h6>Total Alumni</h6>
            <h2><?php echo $total; ?></h2>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow text-white bg-success">
        <div class="card-body">
            <h6>Employed</h6>
            <h2><?php echo $employed; ?></h2>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow text-white bg-danger">
        <div class="card-body">
            <h6>Unemployed</h6>
            <h2><?php echo $unemployed; ?></h2>
        </div>
    </div>
</div>

</div>

<div class="row mt-4">

<div class="col-md-8">
    <div class="card shadow p-3">
        <h5>Welcome</h5>
        <p>
            This Alumni Tracking System helps manage graduate records,
            monitor employment status, and generate reports.
        </p>
    </div>
</div>



<?php include('../includes/footer.php'); ?>