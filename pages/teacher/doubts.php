<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_doubt'])) {
    $doubt_id = $_POST['doubt_id'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO doubt_replies (doubt_id, user_id, role, content) VALUES (?, ?, 'teacher', ?)");
    $stmt->execute([$doubt_id, $user_id, $content]);
    header("Location: doubts.php");
    exit;
}

require_once '../../includes/header.php';
?>

<h2 class="mb-xl">Student Doubts</h2>

<div class="row">
    <div class="col col-12">
        <?php
        $stmt = $pdo->prepare("SELECT d.*, u.name AS student_name 
                               FROM doubts d 
                               JOIN users u ON d.student_id = u.id 
                               ORDER BY d.resolved ASC, d.created_at DESC");
        $stmt->execute();
        $hasDoubts = false;
        while ($doubt = $stmt->fetch()) {
            $hasDoubts = true;
            echo '<div class="card mb-lg" style="border-left: 4px solid ' . ($doubt['resolved'] ? 'var(--color-success)' : 'var(--color-warning)') . ';">';
            echo '<div class="card-content">';
            echo '<div class="flex justify-between items-center mb-md">';
            echo '<h3 class="card-title" style="margin: 0;">' . htmlspecialchars($doubt['title']) . '</h3>';
            if ($doubt['resolved']) {
                echo '<span class="badge badge-success">Resolved</span>';
            } else {
                echo '<span class="badge badge-warning">Needs Response</span>';
            }
            echo '</div>';
            echo '<p class="mb-md">' . htmlspecialchars($doubt['content']) . '</p>';
            echo '<p class="text-muted" style="font-size: 0.875rem;">Posted by ' . htmlspecialchars($doubt['student_name']) . ' on ' . date('M d, Y', strtotime($doubt['created_at'])) . '</p>';
            
            // Fetch replies
            $replyStmt = $pdo->prepare("SELECT dr.*, u.name AS user_name 
                                        FROM doubt_replies dr 
                                        JOIN users u ON dr.user_id = u.id 
                                        WHERE dr.doubt_id = ? 
                                        ORDER BY dr.created_at");
            $replyStmt->execute([$doubt['id']]);
            $replies = $replyStmt->fetchAll();
            
            if ($replies) {
                echo '<div style="margin-top: var(--spacing-lg); padding-top: var(--spacing-lg); border-top: 1px solid var(--color-border);">';
                echo '<h4 class="mb-md" style="font-size: 1rem;">Replies</h4>';
                foreach ($replies as $reply) {
                    $bgColor = $reply['role'] === 'student' ? 'rgba(0, 122, 255, 0.05)' : 'rgba(52, 199, 89, 0.05)';
                    echo '<div style="background: ' . $bgColor . '; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-sm);">';
                    echo '<p class="mb-sm">' . htmlspecialchars($reply['content']) . '</p>';
                    echo '<p class="text-muted" style="font-size: 0.8125rem;">';
                    echo htmlspecialchars($reply['user_name']) . ' (' . ucfirst($reply['role']) . ') • ' . date('M d, Y', strtotime($reply['created_at']));
                    echo '</p>';
                    echo '</div>';
                }
                echo '</div>';
            }
            
            echo '</div>';
            if (!$doubt['resolved']) {
                echo '<div class="card-action">';
                echo '<button onclick="openModal(\'replyModal' . $doubt['id'] . '\')" class="btn btn-primary">Reply to Student</button>';
                echo '</div>';
                
                // Reply Modal
                echo '<div id="replyModal' . $doubt['id'] . '" class="modal" style="display: none;">';
                echo '<div class="modal-header">';
                echo '<h3 class="modal-title">Reply to: ' . htmlspecialchars($doubt['title']) . '</h3>';
                echo '</div>';
                echo '<div class="modal-content">';
                echo '<form method="POST">';
                echo '<input type="hidden" name="doubt_id" value="' . $doubt['id'] . '">';
                echo '<div class="form-group">';
                echo '<label for="content' . $doubt['id'] . '" class="form-label">Your Reply</label>';
                echo '<textarea id="content' . $doubt['id'] . '" name="content" class="form-textarea" rows="4" required></textarea>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<button type="button" onclick="closeModal(\'replyModal' . $doubt['id'] . '\')" class="btn btn-ghost">Cancel</button>';
                echo '<button type="submit" name="reply_doubt" class="btn btn-primary">Submit Reply</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '<div id="overlayreplyModal' . $doubt['id'] . '" class="modal-overlay" style="display: none;" onclick="closeModal(\'replyModal' . $doubt['id'] . '\')"></div>';
            }
            echo '</div>';
        }
        
        if (!$hasDoubts) {
            echo '<div class="card">';
            echo '<div class="card-content text-center">';
            echo '<p class="text-muted">No doubts posted yet</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('overlay' + id).style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('overlay' + id).style.display = 'none';
    document.body.style.overflow = 'auto';
}
</script>

<?php require_once '../../includes/footer.php'; ?>
