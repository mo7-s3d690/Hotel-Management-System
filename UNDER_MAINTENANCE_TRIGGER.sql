DELIMITER $$

CREATE TRIGGER prevent_maintenance_booking
BEFORE INSERT ON Bookings
FOR EACH ROW
BEGIN
    DECLARE roomStatus VARCHAR(20);

    SELECT status INTO roomStatus
    FROM Rooms
    WHERE roomNo = NEW.Room_No;

    IF roomStatus = 'Under maintenance' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Room is under maintenance and cannot be booked.';
    END IF;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER prevent_maintenance_booking_update
BEFORE UPDATE ON Bookings
FOR EACH ROW
BEGIN
    DECLARE roomStatus VARCHAR(20);

    SELECT status INTO roomStatus
    FROM Rooms
    WHERE roomNo = NEW.Room_No;

    IF roomStatus = 'Under maintenance' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Room is under maintenance and cannot be booked.';
    END IF;
END$$

DELIMITER ;
