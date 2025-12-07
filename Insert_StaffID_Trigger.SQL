DELIMITER $$

CREATE TRIGGER staff_prefix_check
BEFORE INSERT ON Staff
FOR EACH ROW
BEGIN
    IF NOT (
        (NEW.ID LIKE 'R%' AND NEW.Department = 'Receptionist') OR
        (NEW.ID LIKE 'M%' AND NEW.Department = 'Maintenance') OR
        (NEW.ID LIKE 'O%' AND NEW.Department = 'Online')
    ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Staff_ID must start with R, M, or O';
    END IF;
END$$

DELIMITER ;
