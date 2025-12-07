CREATE TRIGGER Change_Room_State
AFTER INSERT ON Bookings
FOR EACH ROW
UPDATE Rooms SET status = 'Occupied' WHERE roomNo = NEW.Room_No