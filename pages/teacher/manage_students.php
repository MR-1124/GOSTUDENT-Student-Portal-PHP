<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'student'");
    $stmt->execute([$_POST['delete_id']]);
    header("Location: manage_students.php");
    exit;
}

require_once '../../includes/header.php';
?>

<h2 class="mb-xl">Manage Students</h2>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">All Students</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM users WHERE role = 'student' ORDER BY created_at DESC");
                    $hasStudents = false;
                    while ($row = $stmt->fetch()) {
                        $hasStudents = true;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . date('M d, Y', strtotime($row['created_at'])) . '</td>';
                        echo '<td>';
                        echo '<form method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this student? This action cannot be undone.\')">';
                        echo '<input type="hidden" name="delete_id" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="btn btn-destructive">Delete</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    
                    if (!$hasStudents) {
                        echo '<tr><td colspan="5" class="text-center text-muted">No students registered yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
