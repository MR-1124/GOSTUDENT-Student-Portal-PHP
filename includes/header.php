<?php
require_once 'db.php';
require_once 'functions.php';
if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOSTUDENT</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' rx='8' fill='url(%23gradient)'/%3E%3Cpath d='M16 8L20 12H18V20C18 21.1046 17.1046 22 16 22C14.8954 22 14 21.1046 14 20V12H12L16 8Z' fill='white'/%3E%3Ccircle cx='16' cy='24' r='1.5' fill='white'/%3E%3Cdefs%3E%3ClinearGradient id='gradient' x1='0' y1='0' x2='32' y2='32' gradientUnits='userSpaceOnUse'%3E%3Cstop stop-color='%23667eea'/%3E%3Cstop offset='1' stop-color='%23764ba2'/%3E%3C/linearGradient%3E%3C/defs%3E%3C/svg%3E">
    <link rel="stylesheet" href="../../assets/css/apple-theme.css">
</head>
<body>
    <!-- Side Navbar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="dashboard.php" class="sidebar-brand">
                <div class="logo-icon-wrapper">
                    <svg class="logo-icon" width="40" height="40" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect class="logo-bg" width="32" height="32" rx="8" fill="url(#gradient-nav)"/>
                        <path class="logo-book-left" d="M10 10C10 9.44772 10.4477 9 11 9H13C13.5523 9 14 9.44772 14 10V22C14 22.5523 13.5523 23 13 23H11C10.4477 23 10 22.5523 10 22V10Z" fill="white" opacity="0.9"/>
                        <path class="logo-book-right" d="M18 10C18 9.44772 18.4477 9 19 9H21C21.5523 9 22 9.44772 22 10V22C22 22.5523 21.5523 23 21 23H19C18.4477 23 18 22.5523 18 22V10Z" fill="white" opacity="0.9"/>
                        <path class="logo-cap" d="M16 6L24 10L16 14L8 10L16 6Z" fill="white"/>
                        <circle class="logo-tassel" cx="20" cy="10" r="1.5" fill="#FFD700"/>
                        <circle class="logo-sparkle logo-sparkle-1" cx="6" cy="8" r="1" fill="white" opacity="0"/>
                        <circle class="logo-sparkle logo-sparkle-2" cx="26" cy="12" r="1" fill="white" opacity="0"/>
                        <circle class="logo-sparkle logo-sparkle-3" cx="16" cy="26" r="1" fill="white" opacity="0"/>
                        <defs>
                            <linearGradient id="gradient-nav" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#667eea"/>
                                <stop offset="50%" stop-color="#764ba2"/>
                                <stop offset="100%" stop-color="#667eea"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <span class="sidebar-brand-text">
                    <span class="logo-text-go">GO</span><span class="logo-text-student">STUDENT</span>
                </span>
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <?php if (isStudent()): ?>
                <a href="dashboard.php" class="sidebar-link" data-tooltip="Dashboard">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="assignments.php" class="sidebar-link" data-tooltip="Assignments">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span class="sidebar-text">Assignments</span>
                </a>
                <a href="quizzes.php" class="sidebar-link" data-tooltip="Quizzes">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span class="sidebar-text">Quizzes</span>
                </a>
                <a href="notices.php" class="sidebar-link" data-tooltip="Notices">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="sidebar-text">Notices</span>
                </a>
                <a href="results.php" class="sidebar-link" data-tooltip="Results">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    <span class="sidebar-text">Results</span>
                </a>
                <a href="grades.php" class="sidebar-link" data-tooltip="Grades">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                    </svg>
                    <span class="sidebar-text">Grades</span>
                </a>
                <a href="doubts.php" class="sidebar-link" data-tooltip="Doubts">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span class="sidebar-text">Doubts</span>
                </a>
                <a href="profile.php" class="sidebar-link" data-tooltip="Profile">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="sidebar-text">Profile</span>
                </a>
                <a href="../../logout.php" class="sidebar-link sidebar-link-logout" data-tooltip="Logout">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="sidebar-text">Logout</span>
                </a>
            <?php elseif (isTeacher()): ?>
                <a href="dashboard.php" class="sidebar-link" data-tooltip="Dashboard">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="manage_students.php" class="sidebar-link" data-tooltip="Students">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span class="sidebar-text">Students</span>
                </a>
                <a href="create_assignment.php" class="sidebar-link" data-tooltip="Assignments">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                    <span class="sidebar-text">Assignments</span>
                </a>
                <a href="add_quiz.php" class="sidebar-link" data-tooltip="Quizzes">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span class="sidebar-text">Quizzes</span>
                </a>
                <a href="view_submissions.php" class="sidebar-link" data-tooltip="Submissions">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    <span class="sidebar-text">Submissions</span>
                </a>
                <a href="grade_students.php" class="sidebar-link" data-tooltip="Grades">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                    </svg>
                    <span class="sidebar-text">Grades</span>
                </a>
                <a href="create_notice.php" class="sidebar-link" data-tooltip="Notices">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="sidebar-text">Notices</span>
                </a>
                <a href="doubts.php" class="sidebar-link" data-tooltip="Doubts">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span class="sidebar-text">Doubts</span>
                </a>
                <a href="profile.php" class="sidebar-link" data-tooltip="Profile">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="sidebar-text">Profile</span>
                </a>
                <a href="../../logout.php" class="sidebar-link sidebar-link-logout" data-tooltip="Logout">
                    <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="sidebar-text">Logout</span>
                </a>
            <?php endif; ?>
        </nav>
        
        <div class="sidebar-footer">
            <button class="sidebar-toggle" onclick="toggleSidebar(event)" aria-label="Toggle Sidebar" data-tooltip="Collapse">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                <span class="sidebar-toggle-text">Collapse</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <div class="container main-content">
