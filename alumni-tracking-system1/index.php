<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Portal</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">🎓 Alumni Portal</div>

    <ul class="nav-links">
        <li><a href="#stats">Stats</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="auth/login.php">Login</a></li>
    </ul>
</nav>

<!-- HERO SECTION -->
<div class="heading1">
    <div class="content">
        <h1>Alumni Tracking System</h1>
        <h2>Access Your Alumni Dashboard</h2>
        <p>Login to view your profile, updates, and alumni network.</p>

        <div class="buttons">
            <a href="auth/login.php" class="btn-landing">Login</a>
        </div>
    </div>
</div>

<!-- STATS SECTION -->
<section class="stats-section" id="stats">
    <div class="stat-box">
        <h2>500+</h2>
        <p>Registered Alumni</p>
    </div>

    <div class="stat-box">
        <h2>320</h2>
        <p>Employed Alumni</p>
    </div>

    <div class="stat-box">
        <h2>50+</h2>
        <p>Partner Companies</p>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section" id="features">
    <h2>System Features</h2>

    <div class="features-grid">
        <div class="feature-card">
            <h3>👤 Alumni Profiles</h3>
            <p>Manage personal and career information.</p>
        </div>

        <div class="feature-card">
            <h3>🔍 Live Search</h3>
            <p>Search alumni by name, course, or batch year.</p>
        </div>

        <div class="feature-card">
            <h3>📊 Analytics</h3>
            <p>Track employment status and alumni growth.</p>
        </div>

        <div class="feature-card">
            <h3>📢 Announcements</h3>
            <p>Stay updated with school and alumni events.</p>
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="about-section" id="about">
    <h2>About the Alumni Portal</h2>
    <p>
        This platform allows alumni to stay connected, update their profiles,
        track career progress, and engage with their alma mater.
    </p>
</section>

<!-- FOOTER -->
<footer>
    <p>© 2026 Alumni Tracking System | All Rights Reserved</p>
</footer>

</body>
</html>