-- ============================================
-- Sample Data for GOSTUDENT Portal
-- ============================================

-- Note: Make sure you have at least one teacher and one student user created
-- You can use the registration page or run these queries first:

-- Sample Teacher (username: teacher1, password: password123)
INSERT INTO users (username, password, role, name, email, phone, address, dob) 
VALUES ('teacher1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'Dr. Sarah Johnson', 'sarah.johnson@school.edu', '555-0101', '123 Education St, City', '1985-03-15');

-- Sample Students (username: student1, student2, student3, password: password123)
INSERT INTO users (username, password, role, name, email, phone, address, dob) 
VALUES 
('student1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'John Smith', 'john.smith@student.edu', '555-0201', '456 Student Ave, City', '2005-06-20'),
('student2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Emma Davis', 'emma.davis@student.edu', '555-0202', '789 Learning Ln, City', '2005-08-12'),
('student3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Michael Brown', 'michael.brown@student.edu', '555-0203', '321 Scholar Rd, City', '2005-04-25');

-- ============================================
-- ASSIGNMENTS
-- ============================================

-- Assignment 1: Mathematics - Algebra Basics
INSERT INTO assignments (title, description, due_date, teacher_id, file_path, created_at) 
VALUES (
    'Algebra Fundamentals - Chapter 3',
    'Complete exercises 1-20 from Chapter 3. Focus on solving linear equations and understanding variables. Show all your work and explain your reasoning for each problem.',
    DATE_ADD(CURDATE(), INTERVAL 7 DAY),
    1,
    NULL,
    NOW()
);

-- Assignment 2: English Literature
INSERT INTO assignments (title, description, due_date, teacher_id, file_path, created_at) 
VALUES (
    'Book Report: To Kill a Mockingbird',
    'Write a 500-word essay analyzing the themes of justice and morality in "To Kill a Mockingbird". Include specific examples from the text and discuss how these themes relate to modern society.',
    DATE_ADD(CURDATE(), INTERVAL 10 DAY),
    1,
    NULL,
    NOW()
);

-- Assignment 3: Science - Physics
INSERT INTO assignments (title, description, due_date, teacher_id, file_path, created_at) 
VALUES (
    'Newton''s Laws of Motion Lab Report',
    'Complete the lab experiment on Newton''s Laws and submit a detailed report. Include your hypothesis, methodology, observations, calculations, and conclusions. Attach photos of your setup.',
    DATE_ADD(CURDATE(), INTERVAL 5 DAY),
    1,
    NULL,
    NOW()
);

-- Assignment 4: History
INSERT INTO assignments (title, description, due_date, teacher_id, file_path, created_at) 
VALUES (
    'World War II Timeline Project',
    'Create a comprehensive timeline of major events during World War II (1939-1945). Include at least 15 significant events with dates, descriptions, and their impact on the war''s outcome.',
    DATE_ADD(CURDATE(), INTERVAL 14 DAY),
    1,
    NULL,
    NOW()
);

-- Assignment 5: Computer Science
INSERT INTO assignments (title, description, due_date, teacher_id, file_path, created_at) 
VALUES (
    'Python Programming: Data Structures',
    'Implement a student management system using Python. Use lists, dictionaries, and functions. The program should allow adding, removing, and searching for students. Submit your .py file.',
    DATE_ADD(CURDATE(), INTERVAL 12 DAY),
    1,
    NULL,
    NOW()
);

-- ============================================
-- QUIZZES
-- ============================================

-- Quiz 1: Mathematics Quiz
INSERT INTO quizzes (title, teacher_id, created_at) 
VALUES ('Algebra Basics Quiz', 1, NOW());

SET @quiz1_id = LAST_INSERT_ID();

INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES
(@quiz1_id, 'What is the value of x in the equation: 2x + 5 = 15?', '5', '10', '7.5', '3', 1),
(@quiz1_id, 'Simplify: 3(x + 4) - 2x', 'x + 12', '5x + 12', 'x + 4', '3x + 12', 1),
(@quiz1_id, 'If y = 2x + 3, what is y when x = 4?', '11', '10', '8', '9', 1),
(@quiz1_id, 'Solve for x: x/3 = 9', '27', '3', '6', '12', 1),
(@quiz1_id, 'What is the slope of the line y = 4x - 2?', '4', '-2', '2', '-4', 1);

-- Quiz 2: Science Quiz
INSERT INTO quizzes (title, teacher_id, created_at) 
VALUES ('Physics Fundamentals', 1, NOW());

SET @quiz2_id = LAST_INSERT_ID();

INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES
(@quiz2_id, 'What is Newton''s First Law of Motion?', 'An object at rest stays at rest unless acted upon by force', 'F = ma', 'Every action has an equal and opposite reaction', 'Energy cannot be created or destroyed', 1),
(@quiz2_id, 'What is the SI unit of force?', 'Newton', 'Joule', 'Watt', 'Pascal', 1),
(@quiz2_id, 'If an object has a mass of 10kg and acceleration of 5m/s², what is the force?', '50N', '15N', '2N', '5N', 1),
(@quiz2_id, 'What type of energy does a moving car have?', 'Kinetic Energy', 'Potential Energy', 'Thermal Energy', 'Chemical Energy', 1),
(@quiz2_id, 'What is the speed of light in vacuum?', '300,000 km/s', '150,000 km/s', '450,000 km/s', '200,000 km/s', 1);

-- Quiz 3: English Grammar
INSERT INTO quizzes (title, teacher_id, created_at) 
VALUES ('Grammar and Vocabulary Test', 1, NOW());

SET @quiz3_id = LAST_INSERT_ID();

INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES
(@quiz3_id, 'Which sentence is grammatically correct?', 'She don''t like pizza', 'She doesn''t like pizza', 'She not like pizza', 'She no likes pizza', 2),
(@quiz3_id, 'What is the past tense of "run"?', 'Ran', 'Runned', 'Running', 'Runs', 1),
(@quiz3_id, 'Identify the noun in: "The quick brown fox jumps"', 'Quick', 'Brown', 'Fox', 'Jumps', 3),
(@quiz3_id, 'What is a synonym for "happy"?', 'Sad', 'Joyful', 'Angry', 'Tired', 2),
(@quiz3_id, 'Which is the correct plural of "child"?', 'Childs', 'Childes', 'Children', 'Childrens', 3);

-- Quiz 4: History Quiz
INSERT INTO quizzes (title, teacher_id, created_at) 
VALUES ('World History: 20th Century', 1, NOW());

SET @quiz4_id = LAST_INSERT_ID();

INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES
(@quiz4_id, 'In which year did World War II end?', '1943', '1944', '1945', '1946', 3),
(@quiz4_id, 'Who was the first person to walk on the moon?', 'Buzz Aldrin', 'Neil Armstrong', 'Yuri Gagarin', 'John Glenn', 2),
(@quiz4_id, 'When did the Berlin Wall fall?', '1987', '1988', '1989', '1990', 3),
(@quiz4_id, 'Which country was NOT part of the Allied Powers in WWII?', 'USA', 'UK', 'Germany', 'Soviet Union', 3),
(@quiz4_id, 'What year did the Cold War officially end?', '1989', '1990', '1991', '1992', 3);

-- ============================================
-- NOTICES
-- ============================================

-- Notice 1: Exam Schedule
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'Mid-Term Examination Schedule',
    'Dear Students, The mid-term examinations will be held from December 15-20, 2024. Please check the detailed timetable on the notice board. Ensure you bring your ID cards and required stationery. Good luck with your preparations!',
    NULL,
    1,
    NOW()
);

-- Notice 2: Holiday Announcement
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'Winter Break Holiday Notice',
    'The school will be closed for winter break from December 23, 2024 to January 5, 2025. Classes will resume on January 6, 2025. We wish all students and their families a wonderful holiday season!',
    NULL,
    1,
    NOW()
);

-- Notice 3: Science Fair
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'Annual Science Fair - Call for Projects',
    'We are excited to announce our Annual Science Fair on January 15, 2025! Students are encouraged to submit their innovative science projects. Registration deadline is December 30, 2024. Prizes will be awarded to top 3 projects in each category.',
    NULL,
    1,
    NOW()
);

-- Notice 4: Sports Day
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'Sports Day Event - January 20, 2025',
    'Get ready for our annual Sports Day! Various athletic events including track and field, basketball, and soccer will be held. All students are required to participate. Parents are welcome to attend and cheer for their children!',
    NULL,
    1,
    NOW()
);

-- Notice 5: Library Update
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'New Books Added to Library',
    'The school library has received 200+ new books covering various subjects including fiction, science, history, and technology. Visit the library to explore the new collection. Library hours: Monday-Friday, 8:00 AM - 4:00 PM.',
    NULL,
    1,
    NOW()
);

-- Notice 6: Parent-Teacher Meeting
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'Parent-Teacher Meeting - December 10, 2024',
    'We invite all parents to attend the Parent-Teacher meeting on December 10, 2024, from 2:00 PM to 5:00 PM. This is an opportunity to discuss your child''s academic progress and address any concerns. Please confirm your attendance.',
    NULL,
    1,
    NOW()
);

-- Notice 7: Scholarship Opportunity
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'Merit Scholarship Applications Open',
    'Applications are now open for the Academic Excellence Scholarship for the next academic year. Students with a GPA of 3.5 or higher are eligible to apply. Application deadline: January 15, 2025. Contact the administration office for more details.',
    NULL,
    1,
    NOW()
);

-- Notice 8: Workshop Announcement
INSERT INTO notices (title, content, image_path, teacher_id, created_at) 
VALUES (
    'Coding Workshop: Introduction to Web Development',
    'Join us for a free 3-day coding workshop on Web Development! Learn HTML, CSS, and JavaScript basics. Workshop dates: December 12-14, 2024. Limited seats available. Register at the computer lab by December 8, 2024.',
    NULL,
    1,
    NOW()
);

-- ============================================
-- VERIFICATION QUERIES
-- ============================================

-- Check inserted data
-- SELECT * FROM assignments ORDER BY created_at DESC;
-- SELECT * FROM quizzes ORDER BY created_at DESC;
-- SELECT * FROM quiz_questions ORDER BY quiz_id, id;
-- SELECT * FROM notices ORDER BY created_at DESC;

-- ============================================
-- NOTES
-- ============================================
-- 1. Password for all sample users is: password123
-- 2. Teacher ID is assumed to be 1 (adjust if different)
-- 3. Due dates are set relative to current date
-- 4. Image paths are NULL (you can upload images through the UI)
-- 5. Run this script after creating the database schema
