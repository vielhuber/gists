CREATE TABLE _test(id SERIAL PRIMARY KEY, item_id INT NOT NULL, parent_id INT);
INSERT INTO _test(item_id, parent_id) VALUES (1, null), (2, 1), (3, 1), (3, 5), (4, 3), (5, 5);