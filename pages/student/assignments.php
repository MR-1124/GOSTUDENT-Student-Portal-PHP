<?php
require_once '../../includes/header.php';
checkStudent();
?>

<h2 class="mb-xl">Assignments</h2>

<div class="row">
    <?php
    $stmt = $pdo->query("SELECT * FROM assignments ORDER BY due_date");
    while ($row = $stmt->fetch()) {
        $subStmt = $pdo->prepare("SELECT * FROM assignment_submissions WHERE assignment_id = ? AND student_id = ?");
        $subStmt->execute([$row['id'], $_SESSION['user_id']]);
        $submitted = $subStmt->fetch();

        echo '<div class="col col-4">';
        echo '<div class="card">';
        echo '<div class="card-content">';
        echo '<h3 class="card-title">' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p class="mb-md">' . htmlspecialchars($row['description']) . '</p>';
        echo '<div class="flex items-center gap-sm mb-md">';
        echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>';
        echo '<span class="text-muted">Due: ' . date('M d, Y', strtotime($row['due_date'])) . '</span>';
        echo '</div>';
        if ($row['file_path']) {
            echo '<a href="../../assets/uploads/' . htmlspecialchars($row['file_path']) . '" download class="btn btn-outline btn-sm">Download Materials</a>';
        }
        echo '</div>';
        echo '<div class="card-action">';
        if ($submitted) {
            echo '<span class="badge badge-success">Submitted</span>';
        } else {
            echo '<button onclick="openModal(\'modal' . $row['id'] . '\')" class="btn btn-primary">Submit Assignment</button>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
        if (!$submitted) {
            echo '<div id="modal' . $row['id'] . '" class="modal" style="display: none;">';
            echo '<div class="modal-header">';
            echo '<h3 class="modal-title">Submit Assignment</h3>';
            echo '</div>';
            echo '<div class="modal-content">';
            echo '<h4 class="mb-md">' . htmlspecialchars($row['title']) . '</h4>';
            echo '<form method="POST" action="submit_assignment.php" enctype="multipart/form-data" onsubmit="return confirmSubmission()">';
            echo '<input type="hidden" name="assignment_id" value="' . $row['id'] . '">';
            echo '<div class="form-group">';
            echo '<label for="file' . $row['id'] . '" class="form-label">Upload your assignment file</label>';
            echo '<input type="file" name="assignment_file" id="file' . $row['id'] . '" class="form-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip" required>';
            echo '<p class="form-helper" style="margin-top: var(--spacing-xs); font-size: 0.875rem; color: var(--color-muted-foreground);">Accepted: PDF, Word, Excel, PowerPoint, Text, ZIP (max 10MB)</p>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '<button type="button" onclick="closeModal(\'modal' . $row['id'] . '\')" class="btn btn-ghost">Cancel</button>';
            echo '<button type="submit" class="btn btn-primary">Submit Assignment</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '<div id="overlay' . $row['id'] . '" class="modal-overlay" style="display: none;" onclick="closeModal(\'modal' . $row['id'] . '\')"></div>';
        }
    }
    ?>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('overlay' + id.replace('modal', '')).style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('overlay' + id.replace('modal', '')).style.display = 'none';
    document.body.style.overflow = 'auto';
}

function confirmSubmission() {
    return confirm("Are you sure you want to submit this assignment? You can only submit once.");
}
</script>

<?php require_once '../../includes/footer.php'; ?>