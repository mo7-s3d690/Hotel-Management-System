CREATE TABLE `Guests`(
`ssn` CHAR(14),
`Fname` VARCHAR(15) NOT NULL,
`Lname` VARCHAR(15),
`gender` VARCHAR(10) CHECK (gender in ('Male','Female')),
`age` INT CHECK (age > 18),
`email` VARCHAR(60) UNIQUE NOT NULL,
`nationality` VARCHAR(40),
`preferences` TEXT,
PRIMARY KEY(`ssn`)
)