DELIMITER $$

CREATE TRIGGER prevent_booking_overlap_update
BEFORE UPDATE ON Bookings
FOR EACH ROW
BEGIN
    DECLARE new_end DATE;
    SET new_end = DATE_ADD(NEW.Start_Date, INTERVAL NEW.Nights DAY);

    IF EXISTS (
        SELECT 1
        FROM Bookings
        WHERE Room_No = NEW.Room_No
        AND Booking_ID <> OLD.Booking_ID   -- Prevent self-match
        AND DATE_ADD(Start_Date, INTERVAL Nights DAY) > NEW.Start_Date
        AND new_end > Start_Date
    ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Updated booking overlaps with an existing reservation!';
    END IF;
END$$

DELIMITER ;
