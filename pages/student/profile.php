<?php
require_once '../../includes/header.php';
checkStudent();

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<h2 class="mb-xl">My Profile</h2>

<div class="row">
    <div class="col col-4">
        <div class="card text-center">
            <div class="card-content">
                <?php if ($user['profile_picture']): ?>
                    <img src="../../assets/uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="avatar avatar-xl" style="margin: 0 auto var(--spacing-md);">
                <?php else: ?>
                    <div class="avatar avatar-xl" style="margin: 0 auto var(--spacing-md); background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">
                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <h3 style="margin-bottom: var(--spacing-xs);"><?php echo htmlspecialchars($user['name']); ?></h3>
                <span class="badge badge-primary"><?php echo ucfirst($user['role']); ?></span>
            </div>
        </div>
    </div>
    
    <div class="col col-8">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Personal Details</h3>
                <div class="table-container">
                    <table>
                        <tbody>
                            <tr>
                                <th style="width: 180px;">Username</th>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo htmlspecialchars($user['phone'] ?: 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo htmlspecialchars($user['address'] ?: 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td><?php echo $user['dob'] ? date('M d, Y', strtotime($user['dob'])) : 'Not provided'; ?></td>
                            </tr>
                            <tr>
                                <th>Member Since</th>
                                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-action">
                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>