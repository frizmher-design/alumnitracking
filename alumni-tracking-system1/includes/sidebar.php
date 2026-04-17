<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">

    <h4>🎓 ATS</h4>

    <!-- DASHBOARD -->
    <a href="../dashboard/index.php"
       class="menu-link <?php echo ($current == 'index.php') ? 'active' : ''; ?>">
       📊 Dashboard
    </a>

    <!-- ALUMNI -->
    <a href="../alumni/view_alumni.php"
       class="menu-link <?php echo ($current == 'view_alumni.php') ? 'active' : ''; ?>">
       🎓 Alumni
    </a>

    <!-- REPORTS -->
    <a href="../reports/reports.php"
       class="menu-link <?php echo ($current == 'reports.php') ? 'active' : ''; ?>">
       📊 Reports
    </a>

    <!-- ADMIN ONLY -->
    <?php if($_SESSION['role'] == 'admin'): ?>
    <a href="../users/manage_users.php"
       class="menu-link <?php echo ($current == 'manage_users.php') ? 'active' : ''; ?>">
       👥 Users
    </a>
    <?php endif; ?>

    <!-- LOGOUT -->
    <a href="../auth/logout.php" class="menu-link text-danger mt-auto">
        🚪 Logout
    </a>

</div>

<div class="main-content">

<!-- TOPBAR -->
<div class="topbar">
    <div>🎓 Alumni Tracking System</div>

    <div>
        👤 <?php echo $_SESSION['fullname']; ?>
        <a href="../auth/logout.php" class="btn btn-sm btn-danger ms-2">Logout</a>
    </div>
</div>

<div class="container-fluid mt-4">