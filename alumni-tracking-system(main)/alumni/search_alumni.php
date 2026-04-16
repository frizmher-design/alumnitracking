<?php
include('../config/database.php');

$search_input = $_POST['search'] ?? '';
$search = "%$search_input%";

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
WHERE 1
";

if($search_input != ''){
    $query .= " AND (
        CONCAT(a.firstname, ' ', a.lastname) LIKE '$search' OR
        a.firstname LIKE '$search' OR
        a.lastname LIKE '$search' OR
        a.email LIKE '$search' OR
        a.phone LIKE '$search' OR
        a.student_id LIKE '$search' OR
        c.course_name LIKE '$search' OR
        s.status_name LIKE '$search' OR
        e.company LIKE '$search' OR
        a.graduation_year LIKE '$search'
    )";
}

$res = $conn->query($query);

if($res->num_rows > 0):
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

<?php 
endwhile; 
else:
?>

<tr>
<td colspan="9" class="text-center text-muted">No results found</td>
</tr>

<?php endif; ?>