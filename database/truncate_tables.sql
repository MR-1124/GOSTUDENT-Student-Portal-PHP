-- ============================================
-- Description: Clears all data from all tables
-- WARNING: This will delete ALL data permanently!
-- ============================================

USE `student_portal`;

-- ============================================
-- Delete all data from tables (in correct order to respect foreign keys)
-- ============================================

-- Delete child tables first (tables with foreign keys)
DELETE FROM `doubt_replies`;
DELETE FROM `doubts`;
DELETE FROM `notices`;
DELETE FROM `grades`;
DELETE FROM `quiz_submissions`;
DELETE FROM `quiz_questions`;
DELETE FROM `quizzes`;
DELETE FROM `assignment_submissions`;
DELETE FROM `assignments`;

-- Delete parent table last
DELETE FROM `users`;

-- ============================================
-- Reset auto-increment counters (optional)
-- ============================================

ALTER TABLE `doubt_replies` AUTO_INCREMENT = 1;
ALTER TABLE `doubts` AUTO_INCREMENT = 1;
ALTER TABLE `notices` AUTO_INCREMENT = 1;
ALTER TABLE `grades` AUTO_INCREMENT = 1;
ALTER TABLE `quiz_submissions` AUTO_INCREMENT = 1;
ALTER TABLE `quiz_questions` AUTO_INCREMENT = 1;
ALTER TABLE `quizzes` AUTO_INCREMENT = 1;
ALTER TABLE `assignment_submissions` AUTO_INCREMENT = 1;
ALTER TABLE `assignments` AUTO_INCREMENT = 1;
ALTER TABLE `users` AUTO_INCREMENT = 1;

-- ============================================
-- Optional: Insert demo accounts back
-- Username: teacher | Password: password123
-- Username: student | Password: password123
-- ============================================

INSERT INTO `users` (`username`, `password`, `role`, `name`, `email`) VALUES
('teacher', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'Demo Teacher', 'teacher@gostudent.edu'),
('student', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Demo Student', 'student@gostudent.edu');

-- ============================================
-- Done! All tables are now empty (except demo users)
-- ============================================
