INSERT INTO Rooms (roomNo, capacity, floor, status, description, room_type, Price_per_night) VALUES
(101, 2, 1, 'Free', 'Cozy double room', 'Double', 600),
(102, 1, 1, 'Free', 'Single room with window', 'Single', 400),
(103, 3, 1, 'Free', 'Large suite', 'Suite', 1200),
(104, 2, 1, 'Free', 'Double room with balcony', 'Double', 650),
(105, 1, 1, 'Free', 'Single room', 'Single', 350),

(201, 2, 2, 'Free', 'Double room', 'Double', 620),
(202, 1, 2, 'Free', 'Single room', 'Single', 420),
(203, 4, 2, 'Free', 'Family suite', 'Suite', 1400),
(204, 3, 2, 'Free', 'Triple room', 'Double', 700),
(205, 2, 2, 'Free', 'Double room', 'Double', 600),

(301, 1, 3, 'Free', 'Single room', 'Single', 380),
(302, 2, 3, 'Free', 'Double room', 'Double', 650),
(303, 3, 3, 'Free', 'Triple suite', 'Suite', 1500),
(304, 2, 3, 'Free', 'Double room', 'Double', 620),
(305, 1, 3, 'Free', 'Single room', 'Single', 360);


INSERT INTO Guests (ssn, Fname, Lname, gender, age, email, nationality, preferences) VALUES
('20000000000001', 'Ahmed', 'Samir', 'Male', 25, 'ahmed.samir@mail.com', 'Egyptian', 'Sea view'),
('20000000000002', 'Sara', 'Ali', 'Female', 27, 'sara.ali@mail.com', 'Egyptian', 'Quiet room'),
('20000000000003', 'Omar', 'Tarek', 'Male', 30, 'omar.tarek@mail.com', 'Egyptian', 'Near elevator'),
('20000000000004', 'Mona', 'Hassan', 'Female', 26, 'mona.hassan@mail.com', 'Egyptian', NULL),
('20000000000005', 'Youssef', 'Adel', 'Male', 32, 'youssef.adel@mail.com', 'Egyptian', 'High floor'),
('20000000000006', 'Fatma', 'Nabil', 'Female', 29, 'fatma.nabil@mail.com', 'Egyptian', NULL),
('20000000000007', 'Karim', 'Ibrahim', 'Male', 34, 'karim.ibrahim@mail.com', 'Egyptian', 'Late checkout'),
('20000000000008', 'Laila', 'Kamal', 'Female', 22, 'laila.kamal@mail.com', 'Egyptian', NULL),
('20000000000009', 'Hassan', 'Fouad', 'Male', 28, 'hassan.fouad@mail.com', 'Egyptian', 'Non-smoking'),
('20000000000010', 'Nour', 'Said', 'Female', 24, 'nour.said@mail.com', 'Moroccan', NULL),

('20000000000011', 'Mahmoud', 'Lotfy', 'Male', 35, 'mahmoud.lotfy@mail.com', 'Egyptian', NULL),
('20000000000012', 'Reem', 'Yehia', 'Female', 23, 'reem.yehia@mail.com', 'Egyptian', NULL),
('20000000000013', 'Tamer', 'Fathi', 'Male', 31, 'tamer.fathi@mail.com', 'Egyptian', NULL),
('20000000000014', 'Dina', 'Sherif', 'Female', 29, 'dina.sherif@mail.com', 'Egyptian', NULL),
('20000000000015', 'Ayman', 'Zakaria', 'Male', 40, 'ayman.zakaria@mail.com', 'Egyptian', 'Sea view'),
('20000000000016', 'Jana', 'Hossam', 'Female', 21, 'jana.hossam@mail.com', 'Egyptian', NULL),
('20000000000017', 'Mostafa', 'Ragab', 'Male', 33, 'mostafa.ragab@mail.com', 'Egyptian', NULL),
('20000000000018', 'Huda', 'Atef', 'Female', 28, 'huda.atef@mail.com', 'Egyptian', NULL),
('20000000000019', 'Samir', 'Younes', 'Male', 27, 'samir.younes@mail.com', 'Lebanese', NULL),
('20000000000020', 'Mariam', 'Adham', 'Female', 25, 'mariam.adham@mail.com', 'Egyptian', 'Quiet room');



INSERT INTO Staff (Fname, Lname, SSN, ID, Age, Salary, Department) VALUES
('Omar', 'Mahmoud',  '30000000000001', 'R001', 29, 7000, 'Receptionist'),
('Sara', 'Fouad',    '30000000000002', 'M001', 35, 8500, 'Maintenance'),
('Hassan','Ali',     '30000000000003', 'O001', 31, 9000, 'Online'),
('Mona', 'Khaled',   '30000000000004', 'R002', 28, 6800, 'Receptionist'),
('Adel', 'Youssef',  '30000000000005', 'M002', 40, 9500, 'Maintenance');


INSERT INTO Bookings (Start_Date, Booking_Date, Payment_Type, Nights, Price, `G-ssn`, `AG-ID`, `M-ID`, Room_No) VALUES
('2025-11-25', '2025-11-20', 'Cash',     2, 1200, '20000000000001', 'R001', 'M001', 101),
('2025-11-26', '2025-11-21', 'Visa',     3, 1800, '20000000000002', 'R002', 'M002', 102),
('2025-11-27', '2025-11-22', 'InstaPay', 1, 400,  '20000000000003', 'R001', 'M001', 103),
('2025-11-28', '2025-11-23', 'PayPal',   2, 800,  '20000000000004', 'R002', 'M002', 104),
('2025-11-29', '2025-11-24', 'Cash',     1, 600,  '20000000000005', 'R001', 'M001', 105),
('2025-11-30', '2025-11-25', 'Visa',     2, 1200, '20000000000006', 'O001', 'M002', 201),
('2025-12-01', '2025-11-26', 'PayPal',   3, 1800, '20000000000007', 'R001', 'M001', 202),
('2025-12-02', '2025-11-27', 'Cash',     1, 400,  '20000000000008', 'R002', 'M002', 203),
('2025-12-03', '2025-11-28', 'InstaPay', 4, 2400, '20000000000009', 'O001', 'M001', 204),
('2025-12-04', '2025-11-29', 'Cash',     2, 1200, '20000000000010', 'R001', 'M002', 205),
('2025-12-05', '2025-12-05', 'Visa',     3, 1800, '20000000000011', 'R002', 'M001', 101),
('2025-12-06', '2025-12-05', 'Cash',     1, 600,  '20000000000012', 'O001', 'M002', 102),
('2025-12-07', '2025-12-05', 'PayPal',   2, 1200, '20000000000013', 'R001', 'M001', 103),
('2025-12-08', '2025-12-05', 'InstaPay', 1, 700,  '20000000000014', 'R002', 'M002', 104),
('2025-12-09', '2025-12-05', 'Cash',     2, 1200, '20000000000015', 'O001', 'M001', 105),
('2025-12-10', '2025-12-06', 'Visa',     3, 1800, '20000000000016', 'R001', 'M002', 201),
('2025-12-11', '2025-12-06', 'Cash',     1, 360,  '20000000000017', 'R002', 'M001', 202),
('2025-12-12', '2025-12-06', 'PayPal',   4, 2600, '20000000000018', 'O001', 'M002', 203),
('2025-12-13', '2025-12-06', 'InstaPay', 1, 650,  '20000000000019', 'R001', 'M001', 204),
('2025-12-14', '2025-12-06', 'Cash',     2, 1200, '20000000000020', 'R002', 'M002', 205),
('2025-12-15', '2025-12-10', 'Visa',     3, 1800, '20000000000001', 'R001', 'M001', 101),
('2025-12-16', '2025-12-10', 'Cash',     1, 400,  '20000000000002', 'R002', 'M002', 102),
('2025-12-17', '2025-12-10', 'PayPal',   2, 800,  '20000000000003', 'O001', 'M001', 103),
('2025-12-18', '2025-12-10', 'InstaPay', 1, 600,  '20000000000004', 'R001', 'M002', 104),
('2025-12-19', '2025-12-10', 'Cash',     2, 1200, '20000000000005', 'R002', 'M001', 105),
('2025-12-20', '2025-12-12', 'Visa',     1, 600,  '20000000000006', 'O001', 'M002', 201),
('2025-12-21', '2025-12-12', 'Cash',     2, 1200, '20000000000007', 'R001', 'M001', 202),
('2025-12-22', '2025-12-12', 'PayPal',   3, 1800, '20000000000008', 'R002', 'M002', 203),
('2025-12-23', '2025-12-12', 'InstaPay', 1, 650,  '20000000000009', 'O001', 'M001', 204),
('2025-12-24', '2025-12-12', 'Cash',     2, 1200, '20000000000010', 'R001', 'M002', 205);






