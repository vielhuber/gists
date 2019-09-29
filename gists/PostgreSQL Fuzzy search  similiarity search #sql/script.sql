CREATE EXTENSION IF NOT EXISTS pg_trgm;
SELECT set_limit(0.8); --sets the similiarity level (between 0 and 1)
SELECT * FROM table WHERE name % 'Your Name'