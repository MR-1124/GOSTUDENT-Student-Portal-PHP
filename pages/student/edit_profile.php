<?php
require_once '../../includes/header.php';
checkStudent();

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $profile_picture = $user['profile_picture'];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $fileName = uploadFile($_FILES['profile_picture']);
        if ($fileName) {
            // Delete old profile picture if exists
            if ($user['profile_picture'] && file_exists('../../assets/uploads/' . $user['profile_picture'])) {
                unlink('../../assets/uploads/' . $user['profile_picture']);
            }
            $profile_picture = $fileName;
        } else {
            $error = "Profile picture upload failed! Please make sure the file is an image (JPG, PNG, GIF) and less than 5MB.";
        }
    }

    if (!isset($error)) {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ?, dob = ?, profile_picture = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $address, $dob, $profile_picture, $_SESSION['user_id']]);
        $success = "Profile updated successfully!";
        // Refresh user data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
    }
}
?>

<h2 class="mb-xl">Edit Profile</h2>

<div class="row">
    <div class="col col-8" style="margin: 0 auto;">
        <div class="card">
            <div class="card-content">
                <?php if (isset($error)): ?>
                    <div class="alert alert-error mb-lg">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success mb-lg">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" name="name" class="form-input" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input id="phone" type="text" name="phone" class="form-input" value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input id="dob" type="date" name="dob" class="form-input" value="<?php echo $user['dob']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" name="address" class="form-textarea"><?php echo htmlspecialchars($user['address']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-input" accept="image/*">
                        <p class="form-helper">Upload a new profile picture (optional)</p>
                    </div>
                    
                    <div class="flex gap-sm" style="margin-top: var(--spacing-lg);">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="profile.php" class="btn btn-ghost">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-md);
}
@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once '../../includes/footer.php'; ?>
