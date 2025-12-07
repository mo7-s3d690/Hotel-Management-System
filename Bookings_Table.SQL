CREATE TABLE Bookings (
`Booking_ID` INT AUTO_INCREMENT,
`Start_Date` DATE NOT NULL,
`Booking_Date` DATE NOT NULL,
`Payment_Type` VARCHAR(10) CHECK (Payment_Type IN ('Cash', 'Visa', 'InstaPay', 'PayPal', 'Pending')),
`Nights` INT CHECK (Nights > 0),
`Price` FLOAT,
`G-ssn` CHAR(14),
`AG-ID` VARCHAR(10),
`M-ID` VARCHAR(10),
`Room_No` INT,
PRIMARY KEY(`Booking_ID`),
FOREIGN KEY(`G-ssn`) REFERENCES `Guests`(`ssn`),
FOREIGN KEY(`Room_No`) REFERENCES `Rooms`(`roomNo`),
FOREIGN KEY(`AG-ID`) REFERENCES `Staff`(`ID`),
FOREIGN KEY(`M-ID`) REFERENCES `Staff`(`ID`)
);

ALTER TABLE Bookings
ADD COLUMN user_id INT,
ADD CONSTRAINT fk_bookings_user
FOREIGN KEY (user_id)
REFERENCES users(id)
ON DELETE CASCADE;