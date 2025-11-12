-- ============================================
-- Quick Sample Data (Assumes teacher_id = 1)
-- Run this if you already have users created
-- ============================================

-- ASSIGNMENTS (5 samples)
INSERT INTO assignments (title, description, due_date, teacher_id) VALUES
('Math Assignment: Algebra', 'Solve problems 1-15 from Chapter 3', DATE_ADD(CURDATE(), INTERVAL 7 DAY), 1),
('English Essay: Book Review', 'Write a 500-word review of your favorite book', DATE_ADD(CURDATE(), INTERVAL 10 DAY), 1),
('Science Lab Report', 'Submit your physics experiment report', DATE_ADD(CURDATE(), INTERVAL 5 DAY), 1),
('History Project', 'Create a timeline of World War II events', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 1),
('Programming Task', 'Build a simple calculator in Python', DATE_ADD(CURDATE(), INTERVAL 12 DAY), 1);

-- QUIZZES (3 samples with questions)
-- Quiz 1: Math
INSERT INTO quizzes (title, teacher_id) VALUES ('Math Quiz: Algebra Basics', 1);
SET @quiz1 = LAST_INSERT_ID();
INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES
(@quiz1, 'What is 2x + 5 = 15? Solve for x', '5', '10', '7', '8', 1),
(@quiz1, 'Simplify: 3(x + 2)', '3x + 2', '3x + 6', 'x + 6', '3x + 5', 2),
(@quiz1, 'What is the value of x if x/2 = 8?', '4', '16', '10', '6', 2);

-- Quiz 2: Science
INSERT INTO quizzes (title, teacher_id) VALUES ('Science Quiz: Physics', 1);
SET @quiz2 = LAST_INSERT_ID();
INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES
(@quiz2, 'What is the SI unit of force?', 'Newton', 'Joule', 'Watt', 'Pascal', 1),
(@quiz2, 'Speed of light in vacuum?', '300,000 km/s', '150,000 km/s', '450,000 km/s', '200,000 km/s', 1),
(@quiz2, 'Formula for kinetic energy?', '1/2 mv²', 'mgh', 'mc²', 'Fd', 1);

-- Quiz 3: English
INSERT INTO quizzes (title, teacher_id) VALUES ('English Quiz: Grammar', 1);
SET @quiz3 = LAST_INSERT_ID();
INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES
(@quiz3, 'Past tense of "run"?', 'Ran', 'Runned', 'Running', 'Runs', 1),
(@quiz3, 'Plural of "child"?', 'Childs', 'Childes', 'Children', 'Childrens', 3),
(@quiz3, 'Synonym for "happy"?', 'Sad', 'Joyful', 'Angry', 'Tired', 2);

-- NOTICES (8 samples)
INSERT INTO notices (title, content, teacher_id) VALUES
('Mid-Term Exam Schedule', 'Exams will be held from Dec 15-20. Check the timetable on notice board.', 1),
('Winter Break Holiday', 'School closed from Dec 23 to Jan 5. Classes resume Jan 6.', 1),
('Science Fair Announcement', 'Annual Science Fair on Jan 15! Submit projects by Dec 30.', 1),
('Sports Day Event', 'Sports Day on Jan 20. All students must participate!', 1),
('New Library Books', '200+ new books added! Visit library Mon-Fri, 8 AM - 4 PM.', 1),
('Parent-Teacher Meeting', 'Meeting on Dec 10, 2-5 PM. Please confirm attendance.', 1),
('Scholarship Applications', 'Merit scholarships open! GPA 3.5+ eligible. Deadline: Jan 15.', 1),
('Coding Workshop', 'Free 3-day Web Dev workshop Dec 12-14. Register by Dec 8!', 1);

-- Verify data
SELECT 'Assignments Created:' as Info, COUNT(*) as Count FROM assignments;
SELECT 'Quizzes Created:' as Info, COUNT(*) as Count FROM quizzes;
SELECT 'Quiz Questions Created:' as Info, COUNT(*) as Count FROM quiz_questions;
SELECT 'Notices Created:' as Info, COUNT(*) as Count FROM notices;
