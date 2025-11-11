USE hooshungry;

-- Create restricted user
GRANT SELECT, INSERT, UPDATE ON hooshungry.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

-- Add data validation
ALTER TABLE recipe
ADD CONSTRAINT chk_calories CHECK (calories >= 0),
ADD CONSTRAINT chk_fat CHECK (fat >= 0),
ADD CONSTRAINT chk_protein CHECK (protein >= 0),
ADD CONSTRAINT chk_sodium CHECK (sodium >= 0);

-- Create audit trail
CREATE TABLE IF NOT EXISTS recipe_audit (
  id INT AUTO_INCREMENT PRIMARY KEY,
  recipe_id INT,
  who_updated VARCHAR(30),
  update_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  old_calories INT,
  new_calories INT
);

DELIMITER $$
CREATE TRIGGER log_recipe_update
AFTER UPDATE ON recipe
FOR EACH ROW
INSERT INTO recipe_audit (recipe_id, who_updated, old_calories, new_calories)
VALUES (OLD.id, CURRENT_USER(), OLD.calories, NEW.calories);
$$
DELIMITER ;

-- Create restricted view
CREATE OR REPLACE VIEW recipe_public AS
SELECT id, name, calories, protein, fat, carbohydrates
FROM recipe;


-- Verify privileges
SHOW GRANTS FOR 'appuser'@'localhost';

SHOW FULL TABLES IN hooshungry WHERE TABLE_TYPE LIKE 'VIEW';






