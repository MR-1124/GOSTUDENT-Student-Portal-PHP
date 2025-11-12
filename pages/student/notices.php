<?php
require_once '../../includes/header.php';
checkStudent();
?>

<h2 class="mb-xl">Notices</h2>

<div class="row">
    <?php
    $stmt = $pdo->query("SELECT n.*, u.name AS teacher_name FROM notices n JOIN users u ON n.teacher_id = u.id ORDER BY n.created_at DESC");
    $hasNotices = false;
    while ($row = $stmt->fetch()) {
        $hasNotices = true;
        echo '<div class="col col-4">';
        echo '<div class="card notice-card">';
        
        // Image section
        if ($row['image_path']) {
            echo '<div class="notice-image">';
            echo '<img src="../../assets/uploads/' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['title']) . '">';
            echo '</div>';
        }
        
        // Content section
        echo '<div class="notice-content">';
        echo '<h3 class="notice-title">' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p class="notice-text">' . nl2br(htmlspecialchars($row['content'])) . '</p>';
        
        // Footer with metadata
        echo '<div class="notice-footer">';
        echo '<div class="notice-meta">';
        echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
        echo '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>';
        echo '<circle cx="12" cy="7" r="4"></circle>';
        echo '</svg>';
        echo '<span>' . htmlspecialchars($row['teacher_name']) . '</span>';
        echo '</div>';
        echo '<div class="notice-date">';
        echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
        echo '<circle cx="12" cy="12" r="10"></circle>';
        echo '<polyline points="12 6 12 12 16 14"></polyline>';
        echo '</svg>';
        echo '<span>' . date('M d, Y', strtotime($row['created_at'])) . '</span>';
        echo '</div>';
        echo '</div>';
        
        echo '</div>'; // notice-content
        echo '</div>'; // card
        echo '</div>'; // col
    }
    
    if (!$hasNotices) {
        echo '<div class="col col-12">';
        echo '<div class="empty-state">';
        echo '<svg class="empty-state-icon" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
        echo '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>';
        echo '<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>';
        echo '</svg>';
        echo '<h3>No Notices Yet</h3>';
        echo '<p>Check back later for announcements and updates from your teachers.</p>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>

<?php require_once '../../includes/footer.php'; ?>
