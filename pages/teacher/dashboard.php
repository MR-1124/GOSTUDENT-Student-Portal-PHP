<?php
require_once '../../includes/header.php';
checkTeacher();

$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<div class="welcome-banner">
    <h1>Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <p>Manage your classes and track student progress</p>
</div>

<div class="row">
    <div class="col col-4">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Recent Assignments</h3>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM assignments WHERE teacher_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$_SESSION['user_id']]);
                $assignments = $stmt->fetchAll();
                if ($assignments): ?>
                    <div style="margin-top: var(--spacing-md);">
                        <?php foreach ($assignments as $row): ?>
                            <div style="padding: var(--spacing-md) 0; border-bottom: 1px solid var(--color-border);">
                                <div class="font-semibold"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="text-muted" style="font-size: 0.875rem; margin-top: var(--spacing-xs);">
                                    Due: <?php echo date('M d, Y', strtotime($row['due_date'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No assignments created yet</p>
                <?php endif; ?>
            </div>
            <div class="card-action">
                <a href="create_assignment.php" class="btn btn-primary">Create Assignment</a>
            </div>
        </div>
    </div>
    
    <div class="col col-4">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Recent Quizzes</h3>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM quizzes WHERE teacher_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$_SESSION['user_id']]);
                $quizzes = $stmt->fetchAll();
                if ($quizzes): ?>
                    <div style="margin-top: var(--spacing-md);">
                        <?php foreach ($quizzes as $row): ?>
                            <div style="padding: var(--spacing-md) 0; border-bottom: 1px solid var(--color-border);">
                                <div class="font-semibold"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="text-muted" style="font-size: 0.875rem; margin-top: var(--spacing-xs);">
                                    Posted: <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No quizzes created yet</p>
                <?php endif; ?>
            </div>
            <div class="card-action">
                <a href="add_quiz.php" class="btn btn-primary">Add Quiz</a>
            </div>
        </div>
    </div>
    
    <div class="col col-4">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Recent Notices</h3>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM notices WHERE teacher_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$_SESSION['user_id']]);
                $notices = $stmt->fetchAll();
                if ($notices): ?>
                    <div style="margin-top: var(--spacing-md);">
                        <?php foreach ($notices as $row): ?>
                            <div style="padding: var(--spacing-md) 0; border-bottom: 1px solid var(--color-border);">
                                <div class="font-semibold"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="text-muted" style="font-size: 0.875rem; margin-top: var(--spacing-xs);">
                                    Posted: <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No notices posted yet</p>
                <?php endif; ?>
            </div>
            <div class="card-action">
                <a href="create_notice.php" class="btn btn-primary">Create Notice</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>