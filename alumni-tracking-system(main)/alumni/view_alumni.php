<?php 
include('../includes/header.php'); 
include('../includes/sidebar.php'); 
include('../config/database.php'); 
?>

<h3 class="text-white mb-3">Alumni List</h3>
<p class="text-muted">Manage your alumni records</p>

<a href="add_alumni.php" class="btn btn-success mb-3">+ Add Alumni</a>

<!-- ✅ SEARCH BAR -->
<input type="text" id="search" class="form-control mb-3" placeholder="Search alumni...">

<div class="card p-3">

<div style="overflow-x: auto;">

<table class="table">

<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Course</th>
    <th>Year</th>
    <th>Status</th>
    <th>Company</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Action</th>
</tr>
</thead>

<!-- ✅ IMPORTANT -->
<tbody id="alumniTable">

<?php
$query = "
SELECT 
a.id,
a.student_id,
a.firstname,
a.lastname,
a.email,
a.phone,
a.graduation_year,
c.course_name,
s.status_name,
e.company

FROM alumni a
LEFT JOIN courses c ON a.course_id = c.id
LEFT JOIN employment e ON a.id = e.alumni_id
LEFT JOIN employment_status s ON e.status_id = s.id
";

$res = $conn->query($query);

while($row = $res->fetch_assoc()):
?>

<tr>

<td><?php echo !empty($row['student_id']) ? $row['student_id'] : 'N/A'; ?></td>

<td>
<span style="white-space: nowrap;">
<?php echo htmlspecialchars($row['firstname']." ".$row['lastname']); ?>
</span>
</td>

<td><?php echo $row['course_name'] ?? 'N/A'; ?></td>

<td><?php echo $row['graduation_year']; ?></td>

<td>
<?php if($row['status_name'] == 'Employed'): ?>
    <span class="badge badge-success">Employed</span>
<?php else: ?>
    <span class="badge badge-danger">Unemployed</span>
<?php endif; ?>
</td>

<td>
<?php 
if($row['status_name'] == 'Employed'){
    echo !empty($row['company']) ? htmlspecialchars($row['company']) : '-';
} else {
    echo '<span class="text-muted" style="white-space: nowrap;">No Company</span>';
}
?>
</td>

<td><?php echo !empty($row['email']) ? htmlspecialchars($row['email']) : 'N/A'; ?></td>

<td><?php echo !empty($row['phone']) ? htmlspecialchars($row['phone']) : 'N/A'; ?></td>

<td>
    <div class="action-buttons">
        <a href="edit_alumni.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>

        <a href="delete_alumni.php?id=<?php echo $row['id']; ?>" 
        class="btn btn-danger btn-sm"
        onclick="return confirm('Delete this record?')">Delete</a>
    </div>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>
</div>

<!-- ✅ AJAX SCRIPT -->
<script>
document.getElementById("search").addEventListener("keyup", function() {
    let search = this.value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "search_alumni.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("alumniTable").innerHTML = this.responseText;
    };

    xhr.send("search=" + encodeURIComponent(search));
});
</script>

<?php include('../includes/footer.php'); ?>