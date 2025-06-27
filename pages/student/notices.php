<?php
require_once '../../includes/header.php';
checkStudent();
?>
<h4 class="center-align">Notices</h4>
<div class="row">
    <?php
    $stmt = $pdo->query("SELECT n.*, u.name AS teacher_name FROM notices n JOIN users u ON n.teacher_id = u.id ORDER BY n.created_at DESC");
    while ($row = $stmt->fetch()) {
        echo '<div class="col s12 m6 l4">';
        echo '<div class="card">';
        if ($row['image_path']) {
            echo '<div class="card-image">';
            echo '<img src="../teacher/assets/uploads/' . $row['image_path'] . '" alt="Notice Image" class="responsive-img">';
            echo '</div>';
        }
        echo '<div class="card-content">';
        echo '<span class="card-title">' . htmlspecialchars($row['title']) . '</span>';
        echo '<p>' . htmlspecialchars($row['content']) . '</p>';
        echo '<p><small>Posted by: ' . htmlspecialchars($row['teacher_name']) . ' on ' . $row['created_at'] . '</small></p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
<?php require_once '../../includes/footer.php'; ?>

