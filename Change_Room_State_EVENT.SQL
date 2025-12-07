DELIMITER $$

CREATE EVENT update_room_status_daily
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_TIMESTAMP
DO
BEGIN
    -- Mark rooms as Free if no active booking today
    UPDATE Rooms r
    SET r.status = 'Free'
    WHERE NOT EXISTS (
        SELECT 1
        FROM Bookings b
        WHERE b.Room_No = r.roomNo
        AND CURDATE() >= b.Start_Date
        AND CURDATE() < DATE_ADD(b.Start_Date, INTERVAL b.Nights DAY)
    );

    -- Mark rooms as Occupied if there is an active booking today
    UPDATE Rooms r
    SET r.status = 'Occupied'
    WHERE EXISTS (
        SELECT 1
        FROM Bookings b
        WHERE b.Room_No = r.roomNo
        AND CURDATE() >= b.Start_Date
        AND CURDATE() < DATE_ADD(b.Start_Date, INTERVAL b.Nights DAY)
    );
END$$
DELIMITER ;
