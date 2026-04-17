<?php 
session_start();
include('../includes/header.php'); 
include('../includes/sidebar.php'); 
include('../config/database.php'); 
?>

<h3 class="text-white mb-3">Manage Users</h3>
<p class="text-muted">Manage system users</p>

<a href="add_user.php" class="btn btn-success mb-3">+ Add User</a>

<div class="card p-3">

<div style="overflow-x: auto;">

<table class="table">

<thead>
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Created At</th>
    <th>Updated At</th>
    <th>Last Access</th> <!-- ✅ NEW -->
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
$query = "
SELECT 
u.*,
MAX(l.login_time) AS last_login
FROM users u
LEFT JOIN user_logs l ON u.id = l.user_id
GROUP BY u.id
";

$res = $conn->query($query);

while($row = $res->fetch_assoc()):
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['fullname']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td>
<?php if($row['role'] == 'admin'): ?>
    <span class="badge badge-success">Admin</span>
<?php else: ?>
    <span class="badge badge-secondary">Staff</span>
<?php endif; ?>
</td>

<!-- CREATED -->
<td>
<?php echo date("M d, Y h:i A", strtotime($row['created_at'])); ?>
</td>

<!-- UPDATED -->
<td>
<?php 
echo isset($row['updated_at']) 
    ? date("M d, Y h:i A", strtotime($row['updated_at'])) 
    : 'N/A'; 
?>
</td>

<!-- ✅ LAST ACCESS -->
<td>
<?php 
echo $row['last_login'] 
    ? date("M d, Y h:i A", strtotime($row['last_login'])) 
    : '<span class="text-muted">Never</span>'; 
?>
</td>

<td>
    <div class="action-buttons">
        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>

        <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
        class="btn btn-danger btn-sm"
        onclick="return confirm('Delete this user?')">Delete</a>
    </div>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

<?php include('../includes/footer.php'); ?>