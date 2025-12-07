CREATE TABLE Staff(
`Fname` VARCHAR(30) Not NULL,
`Lname` VARCHAR(30),
`SSN` CHAR(14) UNIQUE,
`ID` VARCHAR(10),
`Age` INT NOT NULL CHECK(Age > 18),
`Salary` FLOAT NOT NULL CHECK(Salary > 0),
`Department` VARCHAR(30) CHECK (Department IN ('Online','Receptionist', 'Maintenance')),
PRIMARY KEY(`ID`)
)