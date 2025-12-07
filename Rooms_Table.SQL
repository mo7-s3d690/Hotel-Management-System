CREATE TABLE `Rooms` (
`roomNo` INT,
`capacity` INT CHECK (capacity BETWEEN 1 AND 7),
`floor` INT CHECK (`floor` BETWEEN 1 AND 5),
`status` VARCHAR(20) DEFAULT 'Free' CHECK (status in ('Free', 'Occupied', 'Under maintenance')),
`description` TEXT NOT NULL,
`room_type` VARCHAR(10) CHECK (room_type IN ('Single', 'Double','Suite')),
`Price_per_night` FLOAT NOT NULL,
PRIMARY KEY(roomNo)
)