<?php
require_once '../../includes/header.php';
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'student'");
    $stmt->execute([$_POST['delete_id']]);
    header("Location: manage_students.php");
    exit;
}
?>
<h4>Manage Students</h4>
<table class="striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM users WHERE role = 'student'");
        while ($row = $stmt->fetch()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>';
            echo '<form method="POST" style="display:inline;">';
            echo '<input type="hidden" name="delete_id" value="' . $row['id'] . '">';
            echo '<button type="submit" class="btn red">Delete</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php require_once '../../includes/footer.php'; ?>