<?php
require_once '../../includes/header.php';
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
?>
<h4 class="center-align">Student Doubts</h4>
<div class="row">
    <?php
    $stmt = $pdo->prepare("SELECT d.*, u.name AS student_name 
                           FROM doubts d 
                           JOIN users u ON d.student_id = u.id 
                           ORDER BY d.created_at DESC");
    $stmt->execute();
    while ($doubt = $stmt->fetch()) {
        echo '<div class="col s12">';
        echo '<div class="card doubt-card">';
        echo '<div class="card-content">';
        echo '<span class="card-title">' . htmlspecialchars($doubt['title']) . '</span>';
        echo '<p>' . htmlspecialchars($doubt['content']) . '</p>';
        echo '<p><small>Posted by: ' . htmlspecialchars($doubt['student_name']) . ' on ' . $doubt['created_at'] . '</small></p>';
        if ($doubt['resolved']) {
            echo '<span class="resolved-badge">Resolved</span>';
        } else {
            echo '<a href="#replyModal' . $doubt['id'] . '" class="modal-trigger btn-small waves-effect waves-light">Reply</a>';
        }
        // Fetch replies
        $replyStmt = $pdo->prepare("SELECT dr.*, u.name AS user_name 
                                    FROM doubt_replies dr 
                                    JOIN users u ON dr.user_id = u.id 
                                    WHERE dr.doubt_id = ? 
                                    ORDER BY dr.created_at");
        $replyStmt->execute([$doubt['id']]);
        while ($reply = $replyStmt->fetch()) {
            $replyClass = $reply['role'] === 'student' ? 'student-reply' : 'teacher-reply';
            echo '<div class="reply-card ' . $replyClass . '">';
            echo '<p>' . htmlspecialchars($reply['content']) . '</p>';
            echo '<p><small>Replied by: ' . htmlspecialchars($reply['user_name']) . ' (' . ucfirst($reply['role']) . ') on ' . $reply['created_at'] . '</small></p>';
            echo '</div>';
        }
        echo '</div>';
        if (!$doubt['resolved']) {
            echo '<div class="modal" id="replyModal' . $doubt['id'] . '">';
            echo '<div class="modal-content">';
            echo '<h4>Reply to Doubt: ' . htmlspecialchars($doubt['title']) . '</h4>';
            echo '<div class="doubt-preview">';
            echo '<p><strong>Original Doubt:</strong> ' . htmlspecialchars($doubt['content']) . '</p>';
            echo '<p><small>Posted by: ' . htmlspecialchars($doubt['student_name']) . ' on ' . $doubt['created_at'] . '</small></p>';
            echo '</div>';
            // Show previous replies
            $replyStmt->execute([$doubt['id']]);
            while ($reply = $replyStmt->fetch()) {
                echo '<div class="reply-preview">';
                echo '<p>' . htmlspecialchars($reply['content']) . '</p>';
                echo '<p><small>By: ' . htmlspecialchars($reply['user_name']) . ' (' . ucfirst($reply['role']) . ') on ' . $reply['created_at'] . '</small></p>';
                echo '</div>';
            }
            echo '<form method="POST">';
            echo '<input type="hidden" name="doubt_id" value="' . $doubt['id'] . '">';
            echo '<div class="input-field">';
            echo '<textarea id="content' . $doubt['id'] . '" class="materialize-textarea" name="content" required></textarea>';
            echo '<label for="content' . $doubt['id'] . '">Your Reply</label>';
            echo '</div>';
            echo '<button type="submit" name="reply_doubt" class="btn waves-effect waves-light">Submit Reply</button>';
            echo '</form>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '<a href="#!" class="modal-close btn-flat">Cancel</a>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
<?php require_once '../../includes/footer.php'; ?>