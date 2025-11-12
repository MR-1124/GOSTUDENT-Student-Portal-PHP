-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 06:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `title`, `description`, `due_date`, `teacher_id`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics Assignment 1', 'Solve the following calculus problems and submit your solutions.', '2024-02-15', 1, NULL, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(2, 'Physics Lab Report', 'Write a detailed lab report on the pendulum experiment conducted in class.', '2024-02-20', 1, NULL, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(3, 'Computer Science Project', 'Develop a simple web application using HTML, CSS, and JavaScript.', '2024-03-01', 1, NULL, '2025-10-05 17:14:34', '2025-10-05 17:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade` decimal(5,2) DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`id`, `assignment_id`, `student_id`, `file_path`, `submitted_at`, `grade`, `feedback`) VALUES
(1, 1, 2, 'math_assignment1_emma.pdf', '2025-10-05 17:14:34', 82.00, 'Good'),
(2, 1, 3, 'math_assignment1_michael.pdf', '2025-10-05 17:14:34', 90.00, 'Excellent'),
(3, 2, 2, 'physics_lab_emma.docx', '2025-10-05 17:14:34', 100.00, 'Very good'),
(4, 1, 8, '1762967793_DAA PROJECT REPORT.pdf', '2025-11-12 17:16:33', 85.00, 'Good'),
(5, 2, 8, '1762967801_Full Stack Developer.pdf', '2025-11-12 17:16:41', NULL, NULL),
(6, 3, 8, '1762967807_STUDENT_PORTAL-SHASHANK.pdf', '2025-11-12 17:16:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doubts`
--

CREATE TABLE `doubts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `student_id` int(11) NOT NULL,
  `resolved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doubts`
--

INSERT INTO `doubts` (`id`, `title`, `content`, `student_id`, `resolved`, `created_at`, `updated_at`) VALUES
(1, 'Question about Calculus Assignment', 'I am having trouble understanding problem 3 in the calculus assignment. Can someone explain the approach?', 2, 1, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(2, 'Physics Lab Equipment', 'When will the physics lab equipment be available for the next experiment?', 3, 0, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(3, 'Programming Project Deadline', 'Is there any possibility to extend the deadline for the programming project?', 2, 0, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(4, 'Unable to understand HTML', 'Pls help', 8, 0, '2025-11-12 17:17:24', '2025-11-12 17:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `doubt_replies`
--

CREATE TABLE `doubt_replies` (
  `id` int(11) NOT NULL,
  `doubt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('student','teacher') NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doubt_replies`
--

INSERT INTO `doubt_replies` (`id`, `doubt_id`, `user_id`, `role`, `content`, `created_at`) VALUES
(1, 1, 1, 'teacher', 'For problem 3, you need to apply the chain rule. Start by differentiating the outer function and then multiply by the derivative of the inner function.', '2025-10-05 17:14:34'),
(2, 1, 2, 'student', 'Thank you, that helps! I was missing the chain rule application.', '2025-10-05 17:14:34'),
(3, 2, 1, 'teacher', 'The lab equipment will be available from next Monday. Please coordinate with your lab partner.', '2025-10-05 17:14:34'),
(4, 4, 1, 'teacher', 'No issues ill help', '2025-11-12 17:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `grade` decimal(5,2) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `assignment_id`, `quiz_id`, `grade`, `teacher_id`, `created_at`) VALUES
(1, 2, 1, NULL, 85.00, 1, '2025-10-05 17:14:34'),
(2, 3, 1, NULL, 78.00, 1, '2025-10-05 17:14:34'),
(3, 2, NULL, 1, 100.00, 1, '2025-10-05 17:14:34'),
(4, 3, NULL, 1, 66.67, 1, '2025-10-05 17:14:34'),
(5, 2, NULL, 2, 100.00, 1, '2025-10-05 17:14:34'),
(6, 2, 1, NULL, 82.00, 1, '2025-10-05 17:24:26'),
(7, 3, 1, NULL, 90.00, 1, '2025-10-05 17:24:48'),
(8, 2, 2, NULL, 100.00, 1, '2025-10-05 17:24:56'),
(9, 8, NULL, 1, 66.67, 1, '2025-11-12 17:16:56'),
(10, 8, 1, NULL, 85.00, 1, '2025-11-12 17:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `content`, `image_path`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to New Semester', 'Welcome all students to the new semester! Please check your schedules and be prepared for classes starting next week.', NULL, 1, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(2, 'Library Hours Update', 'The library will have extended hours during exam period. New timings: 8 AM to 10 PM Monday to Friday.', NULL, 1, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(3, 'Science Fair Registration', 'Registration for the annual science fair is now open. Last date to register is February 28th.', NULL, 1, '2025-10-05 17:14:34', '2025-10-05 17:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics Quiz 1', 1, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(2, 'Physics Fundamentals', 1, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(3, 'Programming Basics', 1, '2025-10-05 17:14:34', '2025-10-05 17:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `correct_option` int(11) NOT NULL CHECK (`correct_option` between 1 and 4),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_option`, `created_at`) VALUES
(1, 1, 'What is the derivative of x²?', '2x', 'x', '2', 'x²', 1, '2025-10-05 17:14:34'),
(2, 1, 'What is the integral of 2x?', 'x²', 'x² + C', '2x²', 'x', 2, '2025-10-05 17:14:34'),
(3, 1, 'What is the value of π (pi) approximately?', '3.14', '2.71', '1.41', '3.00', 1, '2025-10-05 17:14:34'),
(4, 2, 'What is the unit of force?', 'Newton', 'Joule', 'Watt', 'Pascal', 1, '2025-10-05 17:14:34'),
(5, 2, 'What is the acceleration due to gravity?', '9.8 m/s²', '10 m/s²', '8.9 m/s²', '11 m/s²', 1, '2025-10-05 17:14:34'),
(6, 2, 'What is the formula for kinetic energy?', '½mv²', 'mgh', 'F=ma', 'P=IV', 1, '2025-10-05 17:14:34'),
(7, 3, 'What does HTML stand for?', 'HyperText Markup Language', 'HighTech Modern Language', 'Hyper Transfer Markup Language', 'HighText Machine Language', 1, '2025-10-05 17:14:34'),
(8, 3, 'Which language is used for styling web pages?', 'CSS', 'HTML', 'JavaScript', 'Python', 1, '2025-10-05 17:14:34'),
(9, 3, 'What is the correct way to declare a variable in JavaScript?', 'var x;', 'variable x;', 'v x;', 'let variable x;', 1, '2025-10-05 17:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`answers`)),
  `score` decimal(5,2) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_submissions`
--

INSERT INTO `quiz_submissions` (`id`, `quiz_id`, `student_id`, `answers`, `score`, `submitted_at`) VALUES
(1, 1, 2, '{\"1\": \"1\", \"2\": \"2\", \"3\": \"1\"}', 100.00, '2025-10-05 17:14:34'),
(2, 1, 3, '{\"1\": \"1\", \"2\": \"1\", \"3\": \"1\"}', 66.67, '2025-10-05 17:14:34'),
(3, 2, 2, '{\"4\": \"1\", \"5\": \"1\", \"6\": \"1\"}', 100.00, '2025-10-05 17:14:34'),
(4, 1, 8, '{\"1\":\"4\",\"2\":\"2\",\"3\":\"1\"}', 66.67, '2025-11-12 17:16:56');

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_dashboard`
-- (See below for the actual view)
--
CREATE TABLE `student_dashboard` (
`student_id` int(11)
,`student_name` varchar(100)
,`submissions_count` bigint(21)
,`quizzes_taken` bigint(21)
,`average_grade` decimal(9,6)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `teacher_dashboard`
-- (See below for the actual view)
--
CREATE TABLE `teacher_dashboard` (
`teacher_id` int(11)
,`teacher_name` varchar(100)
,`assignments_count` bigint(21)
,`quizzes_count` bigint(21)
,`students_count` bigint(21)
,`pending_submissions` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher') NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `name`, `email`, `phone`, `address`, `dob`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 'teacher1', '$2a$10$bwFYbjA5zRZnJjyU4K.LlON7P/3rtGeyVCtGftenOx/XiBPqbxc8G', 'teacher', 'Dr. Sarah Johnson', 'sarah.johnson@school.edu', '+1234567890', '123 Education Street, City, State', '1980-05-15', '68e2aa4b842a3_1759685195.jpg', '2025-10-05 17:14:34', '2025-11-12 17:18:14'),
(2, 'student1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'John Smith', 'john.smith@student.edu', '+1234567891', '456 Student Ave, City, State', '2000-08-20', NULL, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(3, 'student2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Emma Wilson', 'emma.wilson@student.edu', '+1234567892', '789 College Road, City, State', '2001-03-10', NULL, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(4, 'student3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Michael Brown', 'michael.brown@student.edu', '+1234567893', '321 University Blvd, City, State', '2000-11-25', NULL, '2025-10-05 17:14:34', '2025-10-05 17:14:34'),
(5, 'Mayan', '$2y$10$qtdBgHkMh.H.Ns9mf4ytkeh77nMq7Zbl/LYCLdtasGGk1flwObuza', 'student', 'Mayan Roy', 'mayanroy1124@gmail.com', '9372982959', 'R13, New Navy Nagar, Colaba, Mumbai, Maharashtra - 400005', '2005-11-24', '68e2ad2c527ac_1759685932.jpg', '2025-10-05 17:15:31', '2025-10-05 17:38:52'),
(6, 'aditya', '$2y$10$ECKpxn9LjKa.1Kr9Ch.1nO0vXnVH629uauUIDw4znS3MtKKebFRgi', 'student', 'Aditya Bhardwaj', 'aditya@mail.com', '7766887284', 'Ranchi Jharkhand', '2005-04-14', NULL, '2025-10-05 18:05:57', '2025-10-05 18:05:57'),
(8, 'student', '$2y$10$4o2AT3hbJOzKGjHu3fSjG./lUPSGOLW15TVvtaY22UXvUGjAQgGlO', 'student', 'Mayan Roy', '23BCS10430@cuchd.in', '9372982959', 'New Navy Nagar, Colaba, Mumbai, Maharashtra - 400005', '2005-11-24', '1762967765_cropped_circle_image.png', '2025-11-12 17:15:37', '2025-11-12 17:16:05');

-- --------------------------------------------------------

--
-- Structure for view `student_dashboard`
--
DROP TABLE IF EXISTS `student_dashboard`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_dashboard`  AS SELECT `u`.`id` AS `student_id`, `u`.`name` AS `student_name`, (select count(0) from `assignment_submissions` where `assignment_submissions`.`student_id` = `u`.`id`) AS `submissions_count`, (select count(0) from `quiz_submissions` where `quiz_submissions`.`student_id` = `u`.`id`) AS `quizzes_taken`, (select avg(`grades`.`grade`) from `grades` where `grades`.`student_id` = `u`.`id`) AS `average_grade` FROM `users` AS `u` WHERE `u`.`role` = 'student' ;

-- --------------------------------------------------------

--
-- Structure for view `teacher_dashboard`
--
DROP TABLE IF EXISTS `teacher_dashboard`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `teacher_dashboard`  AS SELECT `u`.`id` AS `teacher_id`, `u`.`name` AS `teacher_name`, (select count(0) from `assignments` where `assignments`.`teacher_id` = `u`.`id`) AS `assignments_count`, (select count(0) from `quizzes` where `quizzes`.`teacher_id` = `u`.`id`) AS `quizzes_count`, (select count(0) from `users` where `users`.`role` = 'student') AS `students_count`, (select count(0) from (`assignment_submissions` `s` join `assignments` `a` on(`s`.`assignment_id` = `a`.`id`)) where `a`.`teacher_id` = `u`.`id` and `s`.`grade` is null) AS `pending_submissions` FROM `users` AS `u` WHERE `u`.`role` = 'teacher' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_submission` (`assignment_id`,`student_id`),
  ADD KEY `idx_assignment_submissions_student` (`student_id`),
  ADD KEY `idx_assignment_submissions_assignment` (`assignment_id`);

--
-- Indexes for table `doubts`
--
ALTER TABLE `doubts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_doubts_student` (`student_id`);

--
-- Indexes for table `doubt_replies`
--
ALTER TABLE `doubt_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_doubt_replies_doubt` (`doubt_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `idx_grades_student` (`student_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_quiz_submission` (`quiz_id`,`student_id`),
  ADD KEY `idx_quiz_submissions_student` (`student_id`),
  ADD KEY `idx_quiz_submissions_quiz` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doubts`
--
ALTER TABLE `doubts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doubt_replies`
--
ALTER TABLE `doubt_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD CONSTRAINT `assignment_submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doubts`
--
ALTER TABLE `doubts`
  ADD CONSTRAINT `doubts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doubt_replies`
--
ALTER TABLE `doubt_replies`
  ADD CONSTRAINT `doubt_replies_ibfk_1` FOREIGN KEY (`doubt_id`) REFERENCES `doubts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doubt_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `grades_ibfk_4` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD CONSTRAINT `quiz_submissions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
