<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../config/database.php'); ?>

<h3 class="mb-4 text-white">Reports</h3>
<p class="text-muted">Analytics of alumni employment</p>

<?php
// TOTAL
$total = $conn->query("SELECT COUNT(*) as t FROM alumni")->fetch_assoc()['t'];

// EMPLOYED
$employed = $conn->query("
SELECT COUNT(*) as e 
FROM employment e
JOIN employment_status s ON e.status_id = s.id
WHERE s.status_name = 'Employed'
")->fetch_assoc()['e'];

// UNEMPLOYED
$unemployed = $conn->query("
SELECT COUNT(*) as u 
FROM employment e
JOIN employment_status s ON e.status_id = s.id
WHERE s.status_name = 'Unemployed'
")->fetch_assoc()['u'];
?>

<!-- STATS -->
<div class="row g-3 mb-4">

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

<!-- CHART CARD -->
<div class="card p-4 d-flex justify-content-center align-items-center text-center">

    <h5 class="text-white mb-3">Employment Distribution</h5>

    <canvas id="myChart" width="300" height="300"></canvas>

    <div class="mt-3 text-white">
        <span style="color:#22c55e;">● Employed</span> |
        <span style="color:#ef4444;">● Unemployed</span>
    </div>

</div>

<!-- PURE JS CHART (NO CDN, NO LIBRARY) -->
<script>
const employed = <?php echo $employed; ?>;
const unemployed = <?php echo $unemployed; ?>;

const total = employed + unemployed;

// Prevent error if 0
const empPercent = total ? employed / total : 0;
const unempPercent = total ? unemployed / total : 0;

const canvas = document.getElementById('myChart');
const ctx = canvas.getContext('2d');

const centerX = canvas.width / 2;
const centerY = canvas.height / 2;
const radius = 100;

// Background circle
ctx.beginPath();
ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
ctx.fillStyle = '#1f2937';
ctx.fill();

// Employed slice
let start = 0;
let end = start + (Math.PI * 2 * empPercent);

ctx.beginPath();
ctx.moveTo(centerX, centerY);
ctx.arc(centerX, centerY, radius, start, end);
ctx.fillStyle = '#22c55e';
ctx.fill();

// Unemployed slice
start = end;
end = start + (Math.PI * 2 * unempPercent);

ctx.beginPath();
ctx.moveTo(centerX, centerY);
ctx.arc(centerX, centerY, radius, start, end);
ctx.fillStyle = '#ef4444';
ctx.fill();

// Inner circle (donut)
ctx.beginPath();
ctx.arc(centerX, centerY, 55, 0, Math.PI * 2);
ctx.fillStyle = '#111';
ctx.fill();

// Center text
ctx.fillStyle = '#fff';
ctx.font = 'bold 16px Segoe UI';
ctx.textAlign = 'center';
ctx.fillText("Total", centerX, centerY - 5);
ctx.fillText(total, centerX, centerY + 20);
</script>

<?php include('../includes/footer.php'); ?>