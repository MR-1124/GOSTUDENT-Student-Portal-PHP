<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, name, email, phone, address, dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $role, $name, $email, $phone, $address, $dob]);
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - GOSTUDENT</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' rx='8' fill='url(%23gradient)'/%3E%3Cpath d='M16 8L20 12H18V20C18 21.1046 17.1046 22 16 22C14.8954 22 14 21.1046 14 20V12H12L16 8Z' fill='white'/%3E%3Ccircle cx='16' cy='24' r='1.5' fill='white'/%3E%3Cdefs%3E%3ClinearGradient id='gradient' x1='0' y1='0' x2='32' y2='32' gradientUnits='userSpaceOnUse'%3E%3Cstop stop-color='%23667eea'/%3E%3Cstop offset='1' stop-color='%23764ba2'/%3E%3C/linearGradient%3E%3C/defs%3E%3C/svg%3E">
    <link rel="stylesheet" href="assets/css/apple-theme.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body class="auth-page">
    <div class="auth-container auth-container-large">
        <div class="auth-card">
            <!-- Logo Section -->
            <div class="auth-logo">
                <svg class="auth-logo-icon" width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect class="logo-bg" width="64" height="64" rx="16" fill="url(#gradient-auth)"/>
                    <path class="logo-book-left" d="M20 20C20 18.8954 20.8954 18 22 18H26C27.1046 18 28 18.8954 28 20V44C28 45.1046 27.1046 46 26 46H22C20.8954 46 20 45.1046 20 44V20Z" fill="white" opacity="0.9"/>
                    <path class="logo-book-right" d="M36 20C36 18.8954 36.8954 18 38 18H42C43.1046 18 44 18.8954 44 20V44C44 45.1046 43.1046 46 42 46H38C36.8954 46 36 45.1046 36 44V20Z" fill="white" opacity="0.9"/>
                    <path class="logo-cap" d="M32 12L48 20L32 28L16 20L32 12Z" fill="white"/>
                    <circle class="logo-tassel" cx="40" cy="20" r="3" fill="#FFD700"/>
                    <defs>
                        <linearGradient id="gradient-auth" x1="0" y1="0" x2="64" y2="64" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#667eea"/>
                            <stop offset="50%" stop-color="#764ba2"/>
                            <stop offset="100%" stop-color="#667eea"/>
                        </linearGradient>
                    </defs>
                </svg>
                <h1 class="auth-title">
                    <span class="gradient-text-primary">GO</span><span class="gradient-text-secondary">STUDENT</span>
                </h1>
                <p class="auth-subtitle">Create your account</p>
            </div>
            
            <!-- Error Alert -->
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Registration Form -->
            <form method="POST" class="auth-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input id="username" type="text" name="username" class="form-input" placeholder="Choose a username" required autofocus>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input id="password" type="password" name="password" class="form-input" placeholder="Create a password" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input id="name" type="text" name="name" class="form-input" placeholder="Enter your full name" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input id="email" type="email" name="email" class="form-input" placeholder="your@email.com" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <input id="phone" type="text" name="phone" class="form-input" placeholder="Your phone number">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <input id="dob" type="date" name="dob" class="form-input">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <textarea id="address" name="address" class="form-textarea" rows="2" placeholder="Your address"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="role" class="form-label">I am a</label>
                    <div class="role-selector">
                        <label class="role-option">
                            <input type="radio" name="role" value="student" required>
                            <div class="role-card">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                                </svg>
                                <span class="role-title">Student</span>
                                <span class="role-desc">Access courses and assignments</span>
                            </div>
                        </label>
                        <label class="role-option">
                            <input type="radio" name="role" value="teacher" required>
                            <div class="role-card">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span class="role-title">Teacher</span>
                                <span class="role-desc">Create and manage courses</span>
                            </div>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-large">
                    <span>Create Account</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>
            
            <!-- Footer Links -->
            <div class="auth-footer">
                <p>Already have an account? <a href="login.php" class="auth-link">Sign in</a></p>
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="auth-decoration auth-decoration-1"></div>
        <div class="auth-decoration auth-decoration-2"></div>
        <div class="auth-decoration auth-decoration-3"></div>
    </div>
</body>
</html>
