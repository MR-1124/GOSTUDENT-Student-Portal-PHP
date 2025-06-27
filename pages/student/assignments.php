<?php
require_once '../../includes/header.php';
checkStudent();
?>
<h4 class="center-align">Assignments</h4>
<div class="row">
    <?php
    $stmt = $pdo->query("SELECT * FROM assignments ORDER BY due_date");
    while ($row = $stmt->fetch()) {
        $subStmt = $pdo->prepare("SELECT * FROM assignment_submissions WHERE assignment_id = ? AND student_id = ?");
        $subStmt->execute([$row['id'], $_SESSION['user_id']]);
        $submitted = $subStmt->fetch();

        echo '<div class="col s12 m6 l4">';
        echo '<div class="card">';
        echo '<div class="card-content">';
        echo '<span class="card-title">' . htmlspecialchars($row['title']) . '</span>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p><strong>Due:</strong> ' . $row['due_date'] . '</p>';
        if ($row['file_path']) {
            echo '<a href="../../assets/uploads/' . $row['file_path'] . '" download class="btn-small waves-effect waves-light">Download</a>';
        }
        echo '</div>';
        echo '<div class="card-action">';
        if ($submitted) {
            echo '<span class="green-text">Submitted</span>';
        } else {
            echo '<a href="#modal' . $row['id'] . '" class="modal-trigger btn waves-effect waves-light">Submit</a>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        if (!$submitted) {
            echo '<div id="modal' . $row['id'] . '" class="modal">';
            echo '<div class="modal-content">';
            echo '<h4>Submit Assignment: ' . htmlspecialchars($row['title']) . '</h4>';
            echo '<form method="POST" action="submit_assignment.php" enctype="multipart/form-data" onsubmit="return confirmSubmission()">';
            echo '<input type="hidden" name="assignment_id" value="' . $row['id'] . '">';
            echo '<div class="file-field input-field">';
            echo '<div class="btn">';
            echo '<span>File</span>';
            echo '<input type="file" name="assignment_file" required>';
            echo '</div>';
            echo '<div class="file-path-wrapper">';
            echo '<input class="file-path validate" type="text">';
            echo '</div>';
            echo '</div>';
            echo '<button type="submit" class="btn waves-effect waves-light">Submit</button>';
            echo '</form>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '<a href="#!" class="modal-close btn-flat">Cancel</a>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</div>
<script>
function confirmSubmission() {
    return confirm("Are you sure you want to submit this assignment? You can only submit once.");
}
</script>
<?php require_once '../../includes/footer.php'; ?>